<?php

// Page
Route::get('/', 'PageController@home');
Route::get('faq', 'PageController@faq');
Route::get('about', 'PageController@about');
Route::get('term', 'PageController@index');
Route::get('privary', 'PageController@index');
Route::get('shipping', 'PageController@index');
Route::get('return', 'PageController@index');
Route::get('/contact', 'ContactUsController@index');
Route::post('/contact', 'ContactUsController@contact');

// Shop
Route::get('shop', 'ShopController@index');
Route::get('product/{id}', 'ShopController@product');

// Cart
Route::get('cart', 'CartController@index');
Route::post('cart/add/product/{id}', 'CartController@add');
Route::post('cart/product/{id}/{action}', 'CartController@update');

// Checkout
Route::post('checkout', 'PaypalController@checkout');
Route::get('checkout/done', 'PaypalController@getDone');
Route::get('checkout/success', 'PaypalController@success');

// Auth routes
Route::get('register', function(){abort(404);})->name('register');
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::get('logout', 'Auth\LoginController@logout');
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/reset', 'Auth\ResetPasswordController@customReset');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/email', 'Auth\ForgotPasswordController@customSendResetLinkEmail')->name('password.email');

// Image route
Route::post('image/upload', 'ImageController@uploadImage');
Route::post('image/delete', 'ImageController@deleteImage');

// Admin
Route::group(['prefix' => 'admin'], function () {
    // Dashboard
    Route::get('/', 'DashboardController@index');
    Route::post('product/{id}/statistic', 'DashboardController@productSale');
    Route::post('sale/statistic', 'DashboardController@saleStatistic');

    // Account
    Route::get('account', 'AccountController@index');
    Route::post('account/email', 'AccountController@updateEmail');
    Route::post('account/password', 'AccountController@updatePassword');

    // Product
    Route::resource('product', 'ProductController', ['except' => ['show']]);

    // Order
    Route::get('order', 'OrderController@index');
    Route::get('order/{id}', 'OrderController@show');
    Route::post('order/{id}/paid', 'OrderController@paid');
    Route::post('order/{id}/cancel', 'OrderController@cancel');
    Route::post('order/{id}/fulfill', 'OrderController@fulfill');
    Route::post('shipment/{id}', 'OrderController@updateShipment');
    Route::post('shipment/{id}/delete', 'OrderController@cancelShipment');

    // Shipment
    Route::get('customer', 'CustomerController@index');
    Route::get('customer/{id}', 'CustomerController@show');

    // message
    Route::get('message', 'ContactUsController@messages');
    Route::get('message/{id}', 'ContactUsController@reply');
});
