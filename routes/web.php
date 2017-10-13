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
		// Material-List
		Route::get('/material/list', 'MaterialController@index')->name('material.index');
		Route::get('/material/list/get-material', 'MaterialController@getMaterial')->name('material.getMaterial');
		Route::post('/material/list/send-material', 'MaterialController@sendMaterial')->name('material.sendMaterial');

		// Material-Transaction
		Route::get('/material/transaction', 'MaterialController@transaction')->name('material.transaction');
		Route::get('/material/transaction/get-transaction', 'MaterialController@getTransaction')->name('material.transaction.getTransaction');
		Route::post('/material/add-transaction', 'MaterialController@storeTransaction')->name('material.transaction.addTransaction');
		Route::post('/material/edit-transaction', 'MaterialController@updateTransaction')->name('material.transaction.editTransaction');
		Route::post('/material/delete-transaction', 'MaterialController@destroyTransaction')->name('material.transaction.deleteTransaction');

		// Material-Type
		Route::get('/material/type', 'MaterialController@type');
		Route::get('/material/type/get-material', 'MaterialController@getMaterialType')->name('material.getMaterialType');
		Route::post('/material/type/add-material', 'MaterialController@storeMaterialType')->name('material.addMaterialType');
		Route::post('/material/type/edit-material', 'MaterialController@updateMaterialType')->name('material.editMaterialType');
		Route::post('/material/type/delete-material', 'MaterialController@destroyMaterialType')->name('material.deleteMaterialType');

		// Material-Color
		Route::get('/material/color', 'MaterialController@color');
		Route::get('/material/color/get-color', 'MaterialController@getMaterialColor')->name('material.getMaterialColor');
		Route::post('/material/color/add-colo', 'MaterialController@storeMaterialColor')->name('material.addMaterialColor');
		Route::post('/material/color/edit-color', 'MaterialController@updateMaterialColor')->name('material.editMaterialColor');
		Route::post('/material/color/delete-color', 'MaterialController@destroyMaterialColor')->name('material.deleteMaterialColor');

		// Material-Seller
		Route::get('/material/seller', 'MaterialController@seller');
		Route::get('/material/type/get-seller', 'MaterialController@getMaterialSeller')->name('material.seller.getSeller');
		Route::post('/material/type/add-seller', 'MaterialController@storeMaterialSeller')->name('material.seller.addSeller');
		Route::post('/material/type/edit-seller', 'MaterialController@updateMaterialSeller')->name('material.seller.editSeller');
		Route::post('/material/type/delete-seller', 'MaterialController@destroyMaterialSeller')->name('material.seller.deleteSeller');
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
		Route::get('/warehouse/get-stock', 'WarehouseController@getStock')->name('warehouse.getStock');

		// Warehouse-Sold-Out
		Route::get('/warehouse/sold-out', 'WarehouseController@soldOut')->name('warehouse.soldOut');

		// Warehouse-Transfer-Stock
		Route::get('/warehouse/transfer-stock', 'WarehouseController@transferStock')->name('warehouse.transferStock');

		// Warehouse-Warehouse-List
		Route::get('/warehouse/warehouse-list', 'WarehouseController@warehouseList')->name('warehouse.warehouseList');
	// End of Warehouse

});