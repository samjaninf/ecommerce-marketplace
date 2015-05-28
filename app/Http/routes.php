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

Route::get('home', ['as' => 'home', 'uses' => 'HomeController@index']);

Route::group(['middleware' => 'auth'], function () {
    Route::get('coffee_shop/apply', ['as' => 'coffee_shop.apply', 'uses' => 'CoffeeShopsController@apply']);
    Route::post('coffee_shop/apply',
        ['as' => 'coffee_shop.applied', 'uses' => 'CoffeeShopsController@storeApplication']);

    Route::resource('coffee_shop', 'CoffeeShopsController');

    Route::group(['middleware' => 'admin', 'prefix' => 'admin', 'namespace' => 'Admin'], function () {
        Route::get('home', ['as' => 'admin.home', 'uses' => 'AdminController@index']);

        Route::get('coffee_shop/{coffee_shop}/{status}',
            ['as' => 'admin.coffee_shop.review', 'uses' => 'CoffeeShopsController@review']);
        Route::resource('coffee_shop', 'CoffeeShopsController');
    });
});

/**
 * Authentication controllers
 */
Route::controllers([
    'auth'     => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);
