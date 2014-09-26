<?php

class AccountController extends BaseController {

	/* Login */
	public function get_login()
	{
		return View::make("account.login")
            ->with('email', '');
	}

	public function post_login () 
    {
        try
        {   
            // Login credentials
            $credentials = array(
                'email'    => Input::get('email'),
                'password' => Input::get('password'),
            );

            // Authenticate the user
            $user = Sentry::authenticate($credentials, false);

            // Log the user in
            Sentry::login($user, false);
        }
        catch (Cartalyst\Sentry\Users\WrongPasswordException $e)
        {
            echo 'Wrong password, try again.';
        }
        catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
        {
            echo 'User was not found.';
        }
        catch (Cartalyst\Sentry\Users\UserNotActivatedException $e)
        {
            echo 'User is not activated.';
        }    

        return Redirect::to('/');       
    }

    /* Register */
    public function get_register()
    {
        return View::make("account.register");
    }
    public function post_register()
    {
        try 
        {
            $user = Sentry::register(array(
                'email'     => Input::get('email'),
                'password'  => Input::get('password'),
                'first_name'=> Input::get('first_name'),
                'last_name'=> Input::get('last_name'),
                'activated' => false,
            ));

            $activationCode = $user->getActivationCode();

            $encryptedEmail = Crypt::encrypt(Input::get('email'));
            $encryptedCode = Crypt::encrypt($activationCode);

            $link = "http://arbolg.local:8000/activation/" . $encryptedEmail . "/" . $encryptedCode;            

            Mail::send('email.message', array('link' => $link), function($message)
            {
                $message->to((Input::get('email')), 'arbolg')->subject('Activar cuenta');
            });
                        
        }
        catch (Cartalyst\Sentry\Users\UserExistsException $e)
        {
            echo 'Ya existe un Usuario con el mismo E-mail.';
        }

        return Redirect::to('/login');   
    }

    /* Activation */
    public function get_activation($email, $code)
    {
        $decryptedEmail = Crypt::decrypt($email);
        $decryptedCode = Crypt::decrypt($code);

        $userToActivate;
        foreach (Sentry::findAllUsers() as $user ) {
          if (($user -> email) == $decryptedEmail) {
              $userToActivate = $user;
          }
        }

        // Attempt to activate the user
        if ($user->attemptActivation($decryptedCode))
        {
            return Redirect::to('/');   
        }
        else
        {
            echo 'User activation failed';
        }
    }

    /* Logout */
    public function get_logout()
    {
        Sentry::logout();

        return Redirect::to('/login');   
    }

     /*           BORRRAR!         */
    public function allusers()
    {
        $users = Sentry::findAllUsers();
        
        return View::make('account.allusers')->with('users', $users);
    }

    public function deleteAllUsers()
    {
        $users = Sentry::findAllUsers();

        foreach (Sentry::findAllUsers() as $user ) {
          $user->delete();
        }
    }
}