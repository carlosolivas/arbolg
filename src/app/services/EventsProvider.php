<?php 

namespace App\Services;

use Illuminate\Support\ServiceProvider;

class EventsProvider extends ServiceProvider {

    public function boot()
    {
      Event::listen('sharing.familyTree.wasAccepted', function($shareDetail)
      {
            $nodePersonService = App::make("NodePersonService");

            $share = $shareDetail->Share();

            $status = $nodePersonService->merge();
      });
    }

    public function register() 
    {
    }
}