<?php

class UserController extends BaseController {

	/* Login */
	public function get_login()
	{
		return View::make("user.login")
            ->with('email', '');
	}

	public function post_login () 
    { 
        // Login credentials
        $credentials = array(
            'email'    => Input::get('email'),
            'password' => Input::get('password'),
        );

        
        // Authenticate the user
        /*$user = Sentry::authenticate($credentials, false);*/

        // Log the user in
        /*Sentry::login($user, false);*/          

        return Redirect::to('/');       
    }    

    /* Logout */
    public function get_logout()
    {
        Sentry::logout();

        return Redirect::to('/login');   
    }
 
}