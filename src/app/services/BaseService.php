<?php

namespace App\Services;


abstract class BaseService 
{

    /**
     * Get a new instance of the specified service
     *
     * @param string $serviceName The service name
     *
     * @return Service
     */
    protected function get($servicePrefix) 
    {
        return App::make($servicePrefix . 'Service');
    } 

    /**
     * @return 
     * The array with the data for response to the client
     */
    protected function buildResponse($success, $id, $errors) {
        return [
                'success' => $success,
                'id' => $id,
                'errors' => $errors
            ];
    }
}
