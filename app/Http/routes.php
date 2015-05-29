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

Route::group(['middleware' => 'auth'], function () {
    Route::get('coffee-shop/apply', ['as' => 'coffee-shop.apply', 'uses' => 'CoffeeShopsController@apply']);
    Route::post('coffee-shop/apply',
        ['as' => 'coffee-shop.applied', 'uses' => 'CoffeeShopsController@storeApplication']);

    Route::get('home', ['as' => 'home', 'uses' => 'HomeController@index']);
    Route::get('my-shop', ['as' => 'my-shop', 'uses' => 'HomeController@index']);
    Route::resource('coffee-shop', 'CoffeeShopsController');
    Route::get('coffee-shop/{coffee_shop}/gallery/{gallery}/up',
        ['as' => 'coffee-shop.gallery.up', 'uses' => 'GalleryImagesController@moveUp']);
    Route::get('coffee-shop/{coffee_shop}/gallery/{gallery}/down',
        ['as' => 'coffee-shop.gallery.down', 'uses' => 'GalleryImagesController@moveDown']);
    Route::resource('coffee-shop.gallery', 'GalleryImagesController');
    Route::resource('coffee-shop.products', 'ProductsController');

    Route::group(['middleware' => 'admin', 'prefix' => 'admin', 'namespace' => 'Admin'], function () {
        Route::get('home', ['as' => 'admin.home', 'uses' => 'AdminController@index']);

        Route::get('coffee-shop/{coffee_shop}/{status}',
            ['as' => 'admin.coffee-shop.review', 'uses' => 'CoffeeShopsController@review']);
        Route::resource('coffee-shop', 'CoffeeShopsController');
    });
});

/**
 * Authentication controllers
 */
Route::controllers([
    'auth'     => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);
