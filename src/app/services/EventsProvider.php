<?php 

namespace App\Services;

use Illuminate\Support\ServiceProvider;

class EventsProvider extends ServiceProvider {
    
    const CUSTOM_ELEMENT_NAME_KEEP_THE_TREE   = "keepTheTree";

    public function boot()
    {
      Event::listen('sharing.familyTree.wasAccepted', function($shareDetail)
      {
            $nodePersonService = App::make("NodePersonService");

            $share = $shareDetail->Share();
            $fromId = $share->elementId;

            $toId;
            foreach ($share->SharedWith() as $sharedWithItem) {
              $toId = $sharedWithItem->personId;
            }            

            $fromKeepsTheTree = 1;
            foreach ($share->ShareOptions() as $customElement) {
              if ($customElement->name == self::CUSTOM_ELEMENT_NAME_KEEP_THE_TREE) {
                $fromKeepsTheTree = $customElement->option;
              }
            }

            $userWhoMakesTheInvitation = $share->personId;

            $status = $nodePersonService->merge($fromId, $toId, $fromKeepsTheTree, $userWhoMakesTheInvitation);
      });
    }

    public function register() 
    {
    }
}