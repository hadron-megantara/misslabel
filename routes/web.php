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
	Route::get('/customer/get-customer', 'CustomerController@getCustomer')->name('customer.getCustomer');
	Route::post('/customer/add-customer', 'CustomerController@store')->name('customer.addCustomer');
	Route::post('/customer/edit-customer', 'CustomerController@update')->name('customer.editCustomer');
	Route::post('/customer/delete-customer', 'CustomerController@destroy')->name('customer.deleteCustomer');

	// Material
		// Material-Purchase-List
		Route::get('/material', 'MaterialController@index');

		// Material-Type
		Route::get('/material-type', 'MaterialController@type');
		Route::get('/material/get-material-type', 'MaterialController@getMaterialType')->name('material.getMaterialType');
		Route::post('/material/add-material-type', 'MaterialController@store')->name('material.addMaterialType');
		Route::post('/material/edit-material-type', 'MaterialController@update')->name('material.editMaterialType');
		Route::post('/material/delete-material-type', 'MaterialController@destroy')->name('material.deleteMaterialType');

		// Material-Convection
		Route::get('/material-convection', 'MaterialController@convection');
	// End of Material

});