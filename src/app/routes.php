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
Route::pattern('id', '[0-9]+');

Route::group(array("before" => 'Confide'), function()
{
    Route::group(array('prefix' => LaravelLocalization::setLocale()), function()
    { 
        Route::get(
        '/',
        array('as' => 'home', 'uses' => 'PersonController@get_tree'));

        Route::get(
        '/tree',
        array('as' => 'tree', 'uses' => 'PersonController@get_tree'));

        Route::get(
        '/loadTreePersons',
        array('as' => 'loadTreePersons', 'uses' => 'PersonController@get_loadTreePersons'));

        Route::get(
        '/loadTreeRelations',
        array('as' => 'loadTreeRelations', 'uses' => 'PersonController@get_loadTreeRelations'));

        Route::post(
        '/saveParent',
        array('as' => 'saveParent', 'uses' => 'PersonController@post_saveParent'));

        Route::get(
        '/extendTree/{id}',
        array('as' => 'extendTree', 'uses' => 'PersonController@get_extendTree'));        

         Route::post(
        '/updatePersonData',
        array('as' => 'updatePersonData', 'uses' => 'PersonController@post_updatePersonData'));

         Route::get(
        '/loadSuggesteds/{id}',
        array('as' => 'loadSuggesteds', 'uses' => 'JoinController@get_loadSuggesteds'));

         Route::get(
        '/sendRequest/{fromId}/{toId}',
        array('as' => 'sendRequest', 'uses' => 'JoinController@get_sendRequest'));

        Route::get(
        '/invitation',
        array('as' => 'invitation', 'uses' => 'JoinController@get_makeInvitation'));
        
    });
});

Route::get('error','BaseController@error');
Route::get('test','BaseController@test');

// Confide routes
Route::get( 'user/create','UserController@create');
Route::post('user','UserController@store');

Route::get( 'login','UserController@login');

Route::post('login','UserController@do_login');
Route::get( 'user/confirm/{code}','UserController@confirm');
Route::get( 'user/forgot_password','UserController@forgot_password');
Route::post('user/forgot_password','UserController@do_forgot_password');
Route::get( 'user/reset_password/{token}', 'UserController@reset_password');
Route::post('user/reset_password','UserController@do_reset_password');
Route::get( 'user/logout','UserController@logout');

