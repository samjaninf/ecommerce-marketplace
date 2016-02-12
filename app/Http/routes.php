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

Route::any('/', ['as' => 'welcome', 'uses' => 'WelcomeController@index']);
Route::any('search/{query?}/{page?}', ['as' => 'search', 'uses' => 'WelcomeController@search']);

Route::post('webhooks/push-token', 'WelcomeController@pushToken');
Route::post('webhooks/auth', 'WelcomeController@auth');
Route::post('webhooks/validate', 'WelcomeController@validateId');
Route::get('webhooks/get-active-orders/{id}', 'WelcomeController@pendingorders');
Route::get('webhooks/validate/{token}', 'WelcomeController@validateToken');
Route::get('webhooks/get-order/{id}', 'WelcomeController@getOrder');
Route::post('webhooks/order-sent/{id}', 'WelcomeController@orderSent');

Route::get('about', 'WelcomeController@about');
Route::get('terms', 'WelcomeController@terms');
Route::get('terms-of-use', 'WelcomeController@termsOfUse');
route::get('coffee-shop-contract', 'WelcomeController@coffeeShopContract');
Route::get('contact-us', 'WelcomeController@contactUs');
Route::get('signup-faq', 'WelcomeController@signupfaq');
Route::post('contact', 'WelcomeController@contact');
Route::post('about', 'WelcomeController@updateAbout');
Route::post('recommend-coffee-shop', ['as' => 'recommend-coffee-shop', 'uses' => 'WelcomeController@recommend']);
Route::get('coffee-shop/apply', ['as' => 'coffee-shop.apply', 'uses' => 'CoffeeShopsController@apply']);
Route::post('coffee-shop/apply', ['as' => 'coffee-shop.applied', 'uses' => 'CoffeeShopsController@storeApplication']);
Route::resource('posts', 'PostsController');

Route::group(['middleware' => 'auth'], function () {

    Route::get('home', ['as' => 'home', 'uses' => 'HomeController@index']);
    Route::post('home', ['as' => 'home.store', 'uses' => 'HomeController@store']);

    Route::get('apply-offer/{offer}', ['as' => 'apply-offer', 'uses' => 'OrdersController@applyOffer']);
    Route::group(['middleware' => 'owner'], function () {
        Route::get('my-profile', 
            ['as' => 'my.profile', 'uses' => 'HomeController@profile']);
        Route::post('my-profile',  
            ['as' => 'my.profile.update', 'uses' => 'HomeController@profileupdate']);  
        Route::get('reporting', ['as' => 'reporting', 'uses' => 'HomeController@reporting']);
        Route::get('order/{order}/nextStatus', ['as' => 'next-order-status', 'uses' => 'OrdersController@nextStatus']);
        Route::get('coffee-shop/{coffee_shop}/gallery/{gallery}/up',
            ['as' => 'coffee-shop.gallery.up', 'uses' => 'GalleryImagesController@moveUp']);
        Route::get('coffee-shop/{coffee_shop}/gallery/{gallery}/down',
            ['as' => 'coffee-shop.gallery.down', 'uses' => 'GalleryImagesController@moveDown']);
        Route::resource('coffee-shop.gallery', 'GalleryImagesController');
        Route::resource('coffee-shop.products', 'MenuController');
        Route::get('coffee-shop/{coffee_shop}/toggle-spec/{spec}',
            ['as' => 'coffee-shop.toggle-spec', 'uses' => 'CoffeeShopsController@toggleSpec']);
        Route::get('coffee-shop/{coffee_shop}/products/{product}/toggle/{size?}',
            ['as' => 'coffee-shop.products.toggle', 'uses' => 'MenuController@toggle']);

        Route::post('coffee-shop/{coffee_shop}/products/{product}/rename',
            ['as' => 'coffee-shop.products.rename', 'uses' => 'MenuController@rename']);
        Route::post('coffee-shop/{coffee_shop}/products/{product}/change-description',
            ['as' => 'coffee-shop.products.change-description', 'uses' => 'MenuController@changeDescription']);
        Route::post('coffee-shop/{coffee_shop}/products/{product}/reprice/{size}',
            ['as' => 'coffee-shop.products.reprice', 'uses' => 'MenuController@reprice']);

        Route::post('coffee-shop/{coffee_shop}/offer-update',
            ['as' => 'coffee-shop.offer-update', 'uses' => 'CoffeeShopsController@offerUpdate']);



        Route::get('my-shop', ['as' => 'my-shop', 'uses' => 'HomeController@index']);
        Route::get('publish-my-shop', ['as' => 'publish-my-shop', 'uses' => 'CoffeeShopsController@publish']);
        Route::resource('coffee-shop', 'CoffeeShopsController', ['except' => ['show', 'index']]);
        
        Route::get('coffee-shop/{coffee_shop}/order', ['as' => 'order.history', 'uses' => 'OrdersController@index']);

        Route::get('coffee-shop/opening-times',
            ['as' => 'coffee-shop.opening-times', 'uses' => 'CoffeeShopsController@openingTimes']);
        Route::post('coffee-shop/opening-times', ['uses' => 'CoffeeShopsController@updateOpeningTimes']);

        Route::resource('offers', 'OffersController');
        Route::get('offers/{offer}/toggleActivation',
            ['as' => 'offers.toggle-activation', 'uses' => 'OffersController@toggleActivation']);

        Route::get('current-orders', ['as' => 'current-orders', 'uses' => 'CoffeeShopsController@showCurrentOrders']);
    });

    Route::get('/orders/{id}/tweet', ['as' => 'order.tweet', 'uses' => 'OrdersController@tweet']);
    Route::post('coffee-shop/{coffee_shop}/review',
        ['as' => 'coffee-shop.review', 'uses' => 'CoffeeShopsController@storeReview']);
    Route::resource('coffee-shop.order', 'OrdersController');
    Route::post('coffee-shop/{coffee_shop}/order/{order}/checkout',
        ['as' => 'coffee-shop.order.checkout', 'uses' => 'OrdersController@checkout']);
    Route::get('order/{order}/review', ['as' => 'order.success', 'uses' => 'OrdersController@show']);
    Route::get('order', ['as' => 'order.index', 'uses' => 'OrdersController@index']);

    Route::resource('products', 'ProductsController', ['only' => 'store']);
    Route::group(['middleware' => 'admin', 'prefix' => 'admin', 'namespace' => 'Admin'], function () {
        Route::get('home', ['as' => 'admin.home', 'uses' => 'AdminController@index']);
        Route::get('last-sales', ['as' => 'admin.sales', 'uses' => 'AdminController@lastSales']);
        Route::get('reporting/{from?}', ['as' => 'admin.reporting', 'uses' => 'AdminController@reporting']);
        Route::resource('post', 'PostsController');

        Route::get('coffee-shop/{coffee_shop}/featured',
            ['as' => 'admin.coffee-shop.featured', 'uses' => 'CoffeeShopsController@featured']);
        Route::resource('coffee-shop', 'CoffeeShopsController', ['except' => ['create', 'store']]);
        Route::get('coffee-shop/{coffee_shop}/{status}',
            ['as' => 'admin.coffee-shop.review', 'uses' => 'CoffeeShopsController@review']);
        route::get('coffeeshop/{coffee_shop}/enable',
            ['as' => 'admin.coffee-shop.enable', 'uses' => 'CoffeeShopsController@enable']);
        Route::get('coffeeshop/{cofee_shop}/delete',
            ['as' => 'admin.coffee-shop.delete', 'uses' => 'CoffeeShopsController@delete']);
        Route::get('products/{products}/enable',
            ['as' => 'admin.products.enable', 'uses' => 'ProductsController@enable']);
        Route::resource('products', 'ProductsController', ['except' => 'destroy']);
        Route::delete('products/{products}/{force?}',
            ['as' => 'admin.products.destroy', 'uses' => 'ProductsController@destroy']);
        Route::resource('product-types', 'ProductTypesController', ['only' => 'store']);

        Route::get('export', ['as' => 'admin.export', 'uses' => 'AdminController@export']);
        Route::get('users', ['as' => 'admin.users', 'uses' => 'AdminController@users']);
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
