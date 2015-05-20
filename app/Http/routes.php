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

Route::get('/', 'WelcomeController@index');
Route::any('search/{query?}/{page?}', ['as' => 'search', 'uses' => 'WelcomeController@search']);

Route::get('home', 'HomeController@index');
Route::post('contact', ['as' => 'contact', 'uses' => 'HomeController@contact']);

Route::controllers([
    'auth'     => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);
