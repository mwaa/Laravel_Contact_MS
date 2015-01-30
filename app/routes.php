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

Route::get('/', function()
{
	return Redirect::to('api/v1/contacts');
});

Route::api(['version' =>'v1','prefix' => 'api/v1'],function()
{
    Route::resource('contacts','ContactsController');
});
