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

Route::group(array('prefix' => LaravelLocalization::setLocale()), function () {
	/** ADD ALL LOCALIZED ROUTES INSIDE THIS GROUP **/
	/*Route::get('/', function()
	{
	return View::make('hello');
	});*/

	Route::get('/', array('before' => 'auth', function () {
		return View::make('index');
	}));

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