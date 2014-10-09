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


Route::group(array('prefix' => LaravelLocalization::setLocale()), function()
{
    Route::get(
    '/',
    array('as' => 'home', 'uses' => 'HomeController@index'));

    Route::get(
    '/allPersons',
    array('as' => 'allPersons', 'uses' => 'PersonController@get_all'));

    Route::get(
    '/familyTree',
    array('as' => 'familyTree', 'uses' => 'PersonController@get_familyTree'));

    Route::get(
    '/create',
    array('as' => 'create', 'uses' => 'PersonController@get_create'));

    Route::post('/create','PersonController@post_create');

    Route::get(
    '/addParent',
    array('as' => 'addParent', 'uses' => 'PersonController@get_addParent'));

    Route::post('/addParent','PersonController@post_addParent');

    Route::get(
    '/addBrother',
    array('as' => 'addBrother', 'uses' => 'PersonController@get_addBrother'));

    Route::post('/addBrother','PersonController@post_addBrother');  

    Route::get('/', array('before' => 'auth', function()
    {
        return View::make('index');
    }));

    
    
});

// Confide routes
Route::get( 'user/create',                 'UserController@create');
Route::post('user',                        'UserController@store');
Route::get( 'login',                  'UserController@login');
Route::post('login',                  'UserController@do_login');
Route::get( 'user/confirm/{code}',         'UserController@confirm');
Route::get( 'user/forgot_password',        'UserController@forgot_password');
Route::post('user/forgot_password',        'UserController@do_forgot_password');
Route::get( 'user/reset_password/{token}', 'UserController@reset_password');
Route::post('user/reset_password',         'UserController@do_reset_password');
Route::get( 'user/logout',                 'UserController@logout');


