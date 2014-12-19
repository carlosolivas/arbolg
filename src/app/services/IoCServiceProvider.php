<?php

namespace App\Services;

use Illuminate\Support\ServiceProvider;
use \s4h\core\DbPersonRepository;

class IoCServiceProvider extends ServiceProvider 
{
    public function register()
    {
        $this->app->bind('NodePersonService', function() 
        {
    		$service = new NodePersonService;    
            $repo = new \s4h\core\DbPersonRepository(new \s4h\core\DbS3FileRepository);
           
        	$service->setPersonRepository($repo);           	
        	
        	return $service;        	
        });
    }
}