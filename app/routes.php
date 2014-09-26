<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/


Route::filter('Sentry', function()
{
    if (!Sentry::check()) {
        return Redirect::route('get_login')
            ->withErrors((new Illuminate\Support\MessageBag)
                ->add('user_must_login', Lang::get('message.user_must_login')))
            ->with('return_url', Request::fullUrl());
    } 
});

/*
| Filtered routes by Sentry
*/
Route::group(array('before' => 'Sentry'),function()
{
    Route::get('/', 'HomeController@index');
});
/*
| End filtered routes by Sentry
*/

/* Login */
Route::get(
    '/login',
    array('as' => 'get_login', 'uses' => 'AccountController@get_login')
);

Route::post(
    '/login',
    array('as' => 'post_login', 'uses' => 'AccountController@post_login')
);

/* Register */
Route::get(
    '/register',
    array('as' => 'get_register', 'uses' => 'AccountController@get_register')
);

Route::post(
    '/register',
    array('as' => 'post_register', 'uses' => 'AccountController@post_register')
);

/* Activation */
Route::get('activation/{email}/{code}', 'AccountController@get_activation');

/* Logout */
Route::get(
    '/logout',
    array('as' => 'get_logout', 'uses' => 'AccountController@get_logout')
);

/* Test */

Route::get(
    '/allusers',
    array('as' => 'allusers', 'uses' => 'AccountController@allusers')
);

Route::get(
    '/deleteAllUsers',
    array('as' => 'deleteAllUsers', 'uses' => 'AccountController@deleteAllUsers')
);
