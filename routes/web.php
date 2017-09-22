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
	Route::get('/', 'HomeController@index');

	Route::get('/customer', 'CustomerController@index');
	Route::get('/customer/get-customer', 'CustomerController@getCustomer')->name('customer.getCustomer');
	Route::post('/customer/add-customer', 'CustomerController@store')->name('customer.addCustomer');
	Route::post('/customer/edit-customer', 'CustomerController@update')->name('customer.editCustomer');
	Route::post('/customer/delete-customer', 'CustomerController@destroy')->name('customer.deleteCustomer');

	// Material
		// Material-Purchase-List
		Route::get('/material', 'MaterialController@index');
		Route::get('/material/get-material', 'MaterialController@getMaterial')->name('material.getMaterial');
		Route::post('/material/add-material', 'MaterialController@storeMaterial')->name('material.addMaterial');
		Route::post('/material/edit-material', 'MaterialController@updateMaterial')->name('material.editMaterial');
		Route::post('/material/delete-material', 'MaterialController@destroyMaterial')->name('material.deleteMaterial');

		// Material-Type
		Route::get('/material-type', 'MaterialController@type');
		Route::get('/material-type/get-material', 'MaterialController@getMaterialType')->name('material.getMaterialType');
		Route::post('/material-type/add-material', 'MaterialController@storeMaterialType')->name('material.addMaterialType');
		Route::post('/material-type/edit-material', 'MaterialController@updateMaterialType')->name('material.editMaterialType');
		Route::post('/material-type/delete-material', 'MaterialController@destroyMaterialType')->name('material.deleteMaterialType');

		// Material-Convection
		Route::get('/material-convection', 'MaterialController@convection');
	// End of Material

});