<?php

namespace App\Services;

use Illuminate\Support\ServiceProvider;

class IoCServiceProvider extends ServiceProvider 
{
    public function register()
    {
        $this->app->bind('UserService', function() {
            $service = new UserService;
            $service->setRepository(new \App\Models\Repositories\UserRepository);
            return $service;
        });

        $this->app->bind('PersonService', function() {
            $service = new PersonService;
            $service->setRepository();
            return $service;
        });
    }
}