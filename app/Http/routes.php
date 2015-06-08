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

    Route::group(['middleware' => 'owner'], function () {
        Route::get('order/{order}/nextStatus', ['as' => 'next-order-status', 'uses' => 'OrdersController@nextStatus']);
        Route::get('coffee-shop/{coffee_shop}/gallery/{gallery}/up',
            ['as' => 'coffee-shop.gallery.up', 'uses' => 'GalleryImagesController@moveUp']);
        Route::get('coffee-shop/{coffee_shop}/gallery/{gallery}/down',
            ['as' => 'coffee-shop.gallery.down', 'uses' => 'GalleryImagesController@moveDown']);
        Route::resource('coffee-shop.gallery', 'GalleryImagesController');
        Route::resource('coffee-shop.products', 'MenuController');
        Route::get('coffee-shop/{coffee_shop}/products/{product}/toggle/{size?}',
            ['as' => 'coffee-shop.products.toggle', 'uses' => 'MenuController@toggle']);
        Route::post('coffee-shop/{coffee_shop}/products/{product}/rename',
            ['as' => 'coffee-shop.products.rename', 'uses' => 'MenuController@rename']);
        Route::post('coffee-shop/{coffee_shop}/products/{product}/reprice/{size}',
            ['as' => 'coffee-shop.products.reprice', 'uses' => 'MenuController@reprice']);
        Route::get('my-shop', ['as' => 'my-shop', 'uses' => 'HomeController@index']);
        Route::resource('coffee-shop', 'CoffeeShopsController', ['except' => ['show', 'index']]);
    });

    Route::post('coffee-shop/{coffee_shop}/review',
        ['as' => 'coffee-shop.review', 'uses' => 'CoffeeShopsController@storeReview']);
    Route::resource('coffee-shop.order', 'OrdersController');
    Route::post('coffee-shop/{coffee_shop}/order/{order}/checkout',
        ['as' => 'coffee-shop.order.checkout', 'uses' => 'OrdersController@checkout']);

    Route::resource('products', 'ProductsController', ['only' => 'store']);

    Route::group(['middleware' => 'admin', 'prefix' => 'admin', 'namespace' => 'Admin'], function () {
        Route::get('home', ['as' => 'admin.home', 'uses' => 'AdminController@index']);

        Route::get('coffee-shop/{coffee_shop}/featured',
            ['as' => 'admin.coffee-shop.featured', 'uses' => 'CoffeeShopsController@featured']);
        Route::resource('coffee-shop', 'CoffeeShopsController', ['except' => ['create', 'store']]);
        Route::get('coffee-shop/{coffee_shop}/{status}',
            ['as' => 'admin.coffee-shop.review', 'uses' => 'CoffeeShopsController@review']);

        Route::get('products/{products}/enable',
            ['as' => 'admin.products.enable', 'uses' => 'ProductsController@enable']);
        Route::resource('products', 'ProductsController', ['except' => 'destroy']);
        Route::delete('products/{products}/{force?}',
            ['as' => 'admin.products.destroy', 'uses' => 'ProductsController@destroy']);
        Route::resource('product-types', 'ProductTypesController', ['only' => 'store']);
    });
});

Route::resource('coffee-shop', 'CoffeeShopsController', ['only' => ['show', 'index']]);

/**
 * Authentication controllers
 */
Route::controllers([
    'auth'     => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);
