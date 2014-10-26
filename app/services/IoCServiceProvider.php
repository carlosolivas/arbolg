<?php

namespace App\Services;

use Illuminate\Support\ServiceProvider;

class IoCServiceProvider extends ServiceProvider 
{
    public function register()
    {
        $this->app->bind('NodePersonService', function() 
        {
            return new NodePersonService();
        });
    }
}