<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => ['api']], function () {
    Route::resource('user', 'UserController', ['except' => [
        'index', 'create', 'edit'
    ]]);

    Route::get('videos/{id}', 'VideoController@show');
    Route::get('top', 'VideoController@top');

    Route::get('country/{name}', 'CountryController@showByName');
});

