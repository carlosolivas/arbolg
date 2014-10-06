<?php

class BaseController extends Controller {

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

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

}
