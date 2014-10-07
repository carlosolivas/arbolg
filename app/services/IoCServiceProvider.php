<?php

namespace App\Services;

use Illuminate\Support\ServiceProvider;

class IoCServiceProvider extends ServiceProvider 
{
    public function register()
    {
        $this->app->bind('PersonService', function() 
        {
            return new PersonService();
        });
    }
}