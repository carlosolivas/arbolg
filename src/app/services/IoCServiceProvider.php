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
        	try {

        		$service = new NodePersonService;    
        		//$repo = new DbPersonRepository;
        		//dd($repo);
            	//$service->setPersonRepository(new \s4h\core\DbPersonRepository);           	
            	
            	return $service;
        	} catch (Exception $e) {
        		 dd($e);
        	}
        	
        });
    }
}