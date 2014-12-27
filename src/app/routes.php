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
Route::pattern('ownerId', '[0-9]+');

 Route::group(array('prefix' => LaravelLocalization::setLocale()), function()
{
    Route::group(array("before" => 'auth'), function()
    {
        Route::get('/', array('before' => 'auth', function () {
            return View::make('index');
        }));

        Route::get(
        '/tree',
        array('as' => 'tree', 'uses' => 'PersonController@get_tree'));

        Route::get(
        '/loadTreeElements',
        array('as' => 'loadTreeElements', 'uses' => 'PersonController@get_loadTreeElements'));        

        Route::post(
        '/saveParent',
        array('as' => 'saveParent', 'uses' => 'PersonController@post_saveParent'));

        Route::post(
        '/saveCouple',
        array('as' => 'saveCouple', 'uses' => 'PersonController@post_saveCouple'));

        Route::get(
        '/removePerson/{id}/{ownerId}',
        array('as' => 'removePerson', 'uses' => 'PersonController@get_removePerson'));

         Route::post(
        '/updatePersonData',
        array('as' => 'updatePersonData', 'uses' => 'PersonController@post_updatePersonData'));

        Route::get(
        '/sharing/{id}',
        array('as' => 'sharing', 'uses' => 'JoinController@get_sharing'));

        Route::get(
        '/setPhoto/{id}',
        array('as' => 'photo', 'uses' => 'PersonController@get_setPhoto'));

        Route::post(
        '/setPhoto',
        array('as' => 'photo', 'uses' => 'PersonController@post_setPhoto'));

        Route::get(
        '/removePhoto',
        array('as' => 'removePhoto', 'uses' => 'PersonController@get_removePhoto'));

    });
});

// Confide routes
Route::get('user/create', 'UserController@create');
Route::post('user', 'UserController@store');
Route::get('login', 'UserController@login');
Route::post('login', 'UserController@do_login');
Route::get('user/confirm/{code}', 'UserController@confirm');
Route::get('user/forgot_password', 'UserController@forgot_password');
Route::post('user/forgot_password', 'UserController@do_forgot_password');
Route::get('user/reset_password/{token}', 'UserController@reset_password');
Route::post('user/reset_password', 'UserController@do_reset_password');
Route::get('user/logout', 'UserController@logout');

//Sharing Routes
Route::get('/share/request', array('before' => 'auth', 'uses' => 'ShareController@testRequestShare'));
Route::post('/share/request', array('before' => 'auth', 'uses' => 'ShareController@SaveRequestShare'));
Route::get('/share/request/{shareDetailId}/accept', array('before' => 'auth', 'uses' => 'ShareController@AcceptShareRequest'));

Route::get('/share/request/{shareDetailId}/reject', array('before' => 'auth', 'uses' => 'ShareController@RejectShareRequest'));

Route::get('/share/request/{shareDetailId}/reject', array('before' => 'auth', 'uses' => 'ShareController@RejectShareRequest'));
