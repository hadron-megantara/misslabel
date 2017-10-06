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
		Route::get('/material', 'MaterialController@index')->name('material.index');
		Route::get('/material/get-material', 'MaterialController@getMaterial')->name('material.getMaterial');
		Route::post('/material/add-material', 'MaterialController@storeMaterial')->name('material.addMaterial');
		Route::post('/material/edit-material', 'MaterialController@updateMaterial')->name('material.editMaterial');
		Route::post('/material/delete-material', 'MaterialController@destroyMaterial')->name('material.deleteMaterial');
		Route::post('/material/send-material', 'MaterialController@sendMaterial')->name('material.sendMaterial');

		// Material-Type
		Route::get('/material/type', 'MaterialController@type');
		Route::get('/material/type/get-material', 'MaterialController@getMaterialType')->name('material.getMaterialType');
		Route::post('/material/type/add-material', 'MaterialController@storeMaterialType')->name('material.addMaterialType');
		Route::post('/material/type/edit-material', 'MaterialController@updateMaterialType')->name('material.editMaterialType');
		Route::post('/material/type/delete-material', 'MaterialController@destroyMaterialType')->name('material.deleteMaterialType');
	// End of Material

	// Convection
		Route::get('/convection', 'ConvectionController@convection');

		// Convection-Material-In
		Route::get('/convection/material-in', 'ConvectionController@index')->name('convection.index');
		Route::get('/convection/material-in/get-material-in', 'ConvectionController@getMaterialIn')->name('convection.getMaterialIn');
		Route::post('/convection/material-in/convert-to-product', 'ConvectionController@convertToProduct')->name('convection.materialIn.convertToProduct');

		// Convection-Product
		Route::get('/convection/product', 'ConvectionController@product')->name('convection.product');
		Route::get('/convection/product/get-product', 'ConvectionController@getProduct')->name('convection.product.getProduct');
		Route::post('/convection/product/send-product', 'ConvectionController@sendProduct')->name('convection.product.sendProduct');

		// Convection-Type
		Route::get('/convection/list', 'ConvectionController@convectionList');
		Route::get('/convection/list/get-convection', 'ConvectionController@getConvectionList')->name('convection.getConvectionList');
		Route::post('/convection/list/add-convection', 'ConvectionController@storeConvectionList')->name('convection.addConvectionList');
		Route::post('/convection/list/edit-convection', 'ConvectionController@updateConvectionList')->name('convection.editConvectionList');
		Route::post('/convection/list/delete-convection', 'ConvectionController@destroyConvectionList')->name('convection.deleteConvectionList');
	// End of Convection

	// Warehouse
		Route::get('/warehouse', 'WarehouseController@index')->name('warehouse.index');

		// Warehouse-Incoming-Stock
		Route::get('/warehouse/incoming-stock', 'WarehouseController@incomingStock')->name('warehouse.incomingStock');

		// Warehouse-Incoming-Stock
		Route::get('/warehouse/incoming-stock', 'WarehouseController@incomingStock')->name('warehouse.incomingStock');

		// Warehouse-Stock
		Route::get('/warehouse/stock', 'WarehouseController@stock')->name('warehouse.stock');

		// Warehouse-Sold-Out
		Route::get('/warehouse/sold-out', 'WarehouseController@soldOut')->name('warehouse.soldOut');

		// Warehouse-Transfer-Stock
		Route::get('/warehouse/transfer-stock', 'WarehouseController@transferStock')->name('warehouse.transferStock');

		// Warehouse-Warehouse-List
		Route::get('/warehouse/warehouse-list', 'WarehouseController@warehouseList')->name('warehouse.warehouseList');
	// End of Warehouse

});