<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::routes();

Route::middleware(['userAuth'])->group(function () {
	Route::get('/', function () {
	    return view('home');
	});


	Route::get('/customer', 'CustomerController@index');
	Route::get('/customer/getCustomer', 'CustomerController@getCustomer')->name('customer.getCustomer');
	Route::post('/customer/addCustomer', 'CustomerController@store')->name('customer.addCustomer');
});