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


Route::filter('filter', function()
{
    
});

/*

*/
Route::group(array('before' => 'filter'),function()
{
    Route::get(
    '/',
    array('as' => 'home', 'uses' => 'HomeController@index'));

    Route::get(
    '/allPersons',
    array('as' => 'allPersons', 'uses' => 'PersonController@get_all'));

    Route::get(
    '/create',
    array('as' => 'create', 'uses' => 'PersonController@get_create'));

    Route::post('/create','PersonController@post_create');
});
/*

*/

/* Login */
Route::get(
    '/login',
    array('as' => 'get_login', 'uses' => 'UserController@get_login')
);

Route::post(
    '/login',
    array('as' => 'post_login', 'uses' => 'UserController@post_login')
);


/* Logout */
Route::get(
    '/logout',
    array('as' => 'get_logout', 'uses' => 'UserController@get_logout')
);

