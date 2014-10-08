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
    Session::put('User', 'Federico');
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
    

    Route::get('/createRelation','PersonController@get_createRelation');

    
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

