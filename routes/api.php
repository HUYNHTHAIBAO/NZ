<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'v1.0'], function () {
    Route::any('/quickom/oauth2/verify', 'Api\HomeController@oauth2')->name('quickom.oauth2.verify');


    Route::group(['prefix' => 'location'], function () {
        Route::get('/province', 'Api\LocationController@province')->name('location.province');
        Route::get('/district', 'Api\LocationController@district')->name('location.district');
        Route::get('/ward', 'Api\LocationController@ward')->name('location.ward');
    });
    Route::group(['prefix' => 'user'], function () {
        Route::post('/login', 'Api\UserController@login')->name('user.login');
        Route::get('/login-facebook', 'Api\UserController@loginFacebook')->name('user.loginFacebook');
        Route::get('/login-google', 'Api\UserController@loginGoogle')->name('user.loginGoogle');
        Route::post('/forgot-password', 'Api\UserController@forgotPassword')->name('user.forgotPassword');
        Route::post('/reset-password', 'Api\UserController@resetPassword')->name('user.resetPassword');
        Route::post('/register', 'Api\UserController@register')->name('user.register');
        Route::post('/update', 'Api\UserController@update')->name('user.update');
        Route::post('/verify', 'Api\UserController@verify')->name('user.verify');
        Route::post('/exits', 'Api\UserController@accountexits')->name('user.exits');
        Route::post('/logout', 'Api\UserController@logout')->name('user.logout');
        Route::post('/refresh', 'Api\UserController@refresh')->name('user.refresh');
        Route::any('/me', 'Api\UserController@me')->name('user.me');
        //get access token for test
        Route::any('/test', 'Api\UserController@test')->name('user.test');
        Route::any('/historycoupon', 'Api\UserController@historycoupon')->name('user.historycoupon');
    });
    Route::group(['prefix' => 'home'], function () {
        Route::get('/index', 'Api\HomeController@index')->name('home.index');
        Route::get('/index2', 'Api\HomeController@index2')->name('home.index2');
    });
    Route::group(['prefix' => 'banner'], function () {
        Route::get('/getAll', 'Api\BannerController@getAll')->name('banner.getAll');
    });
    Route::group(['prefix' => 'posts'], function () {
        Route::get('/detail', 'Api\PostsController@getDetail')->name('posts.getDetail');
        Route::get('', 'Api\PostsController@getAll')->name('posts.getAll');
        Route::get('/category/getAll', 'Api\PostsController@getAllCategory')->name('posts.getAllCategory');
    });
    Route::group(['prefix' => 'notification'], function () {
        Route::get('/', 'Api\NotificationController@index')->name('notification.index');
        Route::post('/read', 'Api\NotificationController@read')->name('notification.read');
    });
    Route::group(['prefix' => 'basket'], function () {
        Route::get('', 'Api\BasketController@getAll')->name('basket.getAll');
        Route::post('', 'Api\BasketController@add')->name('basket.add');
        Route::post('prepare-order', 'Api\BasketController@prepareOrder')->name('basket.prepareOrder');
        Route::get('/counter', 'Api\BasketController@counter')->name('basket.counter');
        Route::post('/update', 'Api\BasketController@update')->name('basket.update');
        Route::post('/remove-item', 'Api\BasketController@removeItems')->name('basket.removeItems');
        Route::post('/remove-all', 'Api\BasketController@removeAllItems')->name('basket.removeAllItems');
    });
    Route::group(['prefix' => 'orders'], function () {
        Route::get('', 'Api\OrdersController@getAll')->name('orders.getAll');
        Route::post('', 'Api\OrdersController@add')->name('orders.add');
        Route::get('/rating/{order_id}', 'Api\OrdersController@getRating')->name('orders.getRating');
        Route::post('/rating/{order_id}', 'Api\OrdersController@postRating')->name('orders.postRating');
        Route::post('/cancel/{order_id}', 'Api\OrdersController@cancel')->name('orders.cancel');
        Route::get('/{order_id}', 'Api\OrdersController@detail')->name('orders.detail');
    });
    Route::group(['prefix' => 'product'], function () {
        Route::get('/getAll', 'Api\ProductController@getAll')->name('product.getAll');
        Route::get('/search', 'Api\ProductController@search')->name('product.search');
        Route::get('/{id}', 'Api\ProductController@detail')->name('product.detail');
        Route::get('/type/getAll', 'Api\ProductController@getAllType')->name('product.getAllType');
    });

    Route::get('branch/getAll', 'Api\BranchController@getAll')->name('branch.getAll');
    Route::get('branch/getTableByIdBranch', 'Api\BranchController@getTableByIdBranch')->name('branch.getTableByIdBranch');
});
