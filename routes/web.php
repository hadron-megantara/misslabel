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
		Route::get('/material/list/get-by-transaction', 'MaterialController@getMaterialByTransactionId')->name('material.getMaterialByTransactionId');

		// Material-Transaction
		Route::get('/material/transaction', 'MaterialController@transaction')->name('material.transaction');
		Route::get('/material/transaction/get-transaction', 'MaterialController@getTransaction')->name('material.transaction.getTransaction');
		Route::post('/material/add-transaction', 'MaterialController@storeTransaction')->name('material.transaction.addTransaction');
		Route::post('/material/edit-transaction', 'MaterialController@updateTransaction')->name('material.transaction.editTransaction');
		Route::post('/material/delete-transaction', 'MaterialController@destroyTransaction')->name('material.transaction.deleteTransaction');
		Route::get('/material/transaction/download-note', 'MaterialController@downloadNote')->name('material.transaction.downloadNote');

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

		// Convection-Note
		Route::get('/convection/note', 'ConvectionController@note')->name('convection.note');
		Route::get('/convection/note/get-note', 'ConvectionController@getNote')->name('convection.note.get');
		Route::get('/convection/note/download-note', 'ConvectionController@downloadNote')->name('convection.note.download');

		// Convection-Product-In
		Route::get('/convection/product-in', 'ConvectionController@productIn')->name('convection.productIn');
		Route::get('/convection/product-in/get-product-in', 'ConvectionController@getProductIn')->name('convection.getProductIn');
		Route::post('/convection/product-in/product-accessories', 'ConvectionController@productAccessories')->name('convection.productIn.productAccessories');

		// Convection-Product
		Route::get('/convection/product', 'ConvectionController@product')->name('convection.product');
		Route::get('/convection/product/get-product', 'ConvectionController@getProduct')->name('convection.product.getProduct');
		Route::post('/convection/product/send-product', 'ConvectionController@sendProduct')->name('convection.product.sendProduct');
		Route::post('/convection/product/send-product-convection', 'ConvectionController@sendProductConvection')->name('convection.product.sendProductConvection');
		Route::post('/convection/product/send-product-from-convection', 'ConvectionController@sendProductFromConvection')->name('convection.product.sendProductFromConvection');

		// Convection-Type
		Route::get('/convection/list', 'ConvectionController@convectionList');
		Route::get('/convection/list/get-convection', 'ConvectionController@getConvectionList')->name('convection.getConvectionList');
		Route::post('/convection/list/add-convection', 'ConvectionController@storeConvectionList')->name('convection.addConvectionList');
		Route::post('/convection/list/edit-convection', 'ConvectionController@updateConvectionList')->name('convection.editConvectionList');
		Route::post('/convection/list/delete-convection', 'ConvectionController@destroyConvectionList')->name('convection.deleteConvectionList');
	// End of Convection

	// Warehouse
		Route::get('/warehouse', 'WarehouseController@index')->name('warehouse.index');

		// Warehouse-Stock
		Route::get('/warehouse/stock', 'WarehouseController@stock')->name('warehouse.stock');
		Route::get('/warehouse/get-stock', 'WarehouseController@getStock')->name('warehouse.getStock');

		// Warehouse-Delivery-Note
		Route::get('/warehouse/delivery-note', 'WarehouseController@deliveryNote')->name('warehouse.deliveryNote');
		Route::get('/warehouse/delivery-note/get-delivery-note', 'WarehouseController@getDeliveryNote')->name('warehouse.deliveryNote.getDeliveryNote');
		Route::get('/warehouse/delivery-note/download-note', 'WarehouseController@downloadNote')->name('warehouse.deliveryNote.downloadNote');

		// Warehouse-Transfer-Stock
		Route::post('/warehouse/transfer-stock', 'WarehouseController@transferStock')->name('warehouse.transferStock');

		// Warehouse-Warehouse-List
		Route::get('/warehouse/warehouse-list', 'WarehouseController@warehouseList')->name('warehouse.warehouseList');
		Route::get('/warehouse/list/get-warehouse', 'WarehouseController@getWarehouseList')->name('warehouse.getWarehouseList');
		Route::post('/warehouse/list/add-warehouse', 'WarehouseController@storeWarehouseList')->name('warehouse.addWarehouseList');
		Route::post('/warehouse/list/edit-warehouse', 'WarehouseController@updateWarehouseList')->name('warehouse.editWarehouseList');
		Route::post('/warehouse/list/delete-warehouse', 'WarehouseController@destroyWarehouseList')->name('warehouse.deleteWarehouseList');
	// End of Warehouse

	// Store
		Route::get('/store', 'StoreController@index')->name('store.index');

		// Stock-Incoming-Product
		Route::get('/store/incoming-product', 'StoreController@incomingProduct')->name('store.incomingProduct');
		Route::get('/store/get-incoming-product', 'StoreController@getIncomingProduct')->name('store.incomingProduct.get');
		Route::post('/store/verificate-incoming-product', 'StoreController@verificateIncomingProduct')->name('store.incomingProduct.verificate');

		// Stock-Stock
		Route::get('/store/stock', 'StoreController@stock')->name('store.stock');
		Route::get('/store/get-stock', 'StoreController@getStock')->name('store.getStock');

		// Stock-Transaction
		Route::post('/store/add-transaction', 'StoreController@addTransaction')->name('store.transaction.add');

		// Stock-Sales
		Route::get('/store/sales', 'StoreController@sales')->name('store.sales');
		Route::get('/store/get-sales', 'StoreController@getSales')->name('store.sales.get');

		// Stock-Sold-Out
		Route::get('/store/sold-out', 'StoreController@soldOut')->name('store.soldOut');
		Route::get('/store/get-sold-out', 'StoreController@getSoldOut')->name('store.getSoldOut');

		// Stock-Transfer-Stock
		Route::get('/store/transfer-stock', 'StoreController@transferStock')->name('store.transferStock');
		Route::post('/store/transfer-stock-process', 'StoreController@transferStockProcess')->name('store.transferStockProcess');
		Route::get('/store/transfer-stock-history', 'StoreController@transferStockHistory')->name('store.transferStockHistory');
		Route::get('/store/transfer-stock-history/get', 'StoreController@getTransferStockHistory')->name('store.transferStockHistory.get');

		// Stock-Store-List
		Route::get('/store/store-list', 'StoreController@storeList')->name('store.warehouseList');
		Route::get('/store/list/get-store', 'StoreController@getStoreList')->name('store.getStoreList');
		Route::post('/store/list/add-store', 'StoreController@storeStoreList')->name('store.addStoreList');
		Route::post('/store/list/edit-store', 'StoreController@updateStoreList')->name('store.editStoreList');
		Route::post('/store/list/delete-store', 'StoreController@destroyStoreList')->name('store.deleteStoreList');
	// End of Store

	// Configuration
		Route::get('/config/color', 'ConfigController@color')->name('config.color');
		Route::get('/config/get-color', 'ConfigController@getColor')->name('config.color.get');
		Route::post('/config/store-color', 'ConfigController@storeColor')->name('config.color.store');
		Route::post('/config/update-color', 'ConfigController@updateColor')->name('config.color.update');
		Route::post('/config/destroy-color', 'ConfigController@destroyColor')->name('config.color.destroy');

		Route::get('/config/product-model', 'ConfigController@productModel')->name('config.productModel');
		Route::get('/config/get-product-model', 'ConfigController@getProductModel')->name('config.productModel.get');
		Route::post('/config/store-product-model', 'ConfigController@storeProductModel')->name('config.productModel.store');
		Route::post('/config/update-product-model', 'ConfigController@updateProductModel')->name('config.productModel.update');
		Route::post('/config/destroy-product-model', 'ConfigController@destroyProductModel')->name('config.productModel.destroy');

		Route::get('/config/product', 'ConfigController@product')->name('config.product');
		Route::get('/config/get-product', 'ConfigController@getProduct')->name('config.product.get');
		Route::post('/config/store-product', 'ConfigController@storeProduct')->name('config.product.store');
		Route::post('/config/update-product', 'ConfigController@updateProduct')->name('config.product.update');
		Route::post('/config/destroy-product', 'ConfigController@destroyProduct')->name('config.product.destroy');

		Route::get('/config/seller', 'ConfigController@seller')->name('config.seller');
		Route::get('/config/get-seller', 'ConfigController@getSeller')->name('config.seller.get');
		Route::post('/config/store-seller', 'ConfigController@storeSeller')->name('config.seller.store');
		Route::post('/config/update-seller', 'ConfigController@updateSeller')->name('config.seller.update');
		Route::post('/config/destroy-seller', 'ConfigController@destroySeller')->name('config.seller.destroy');

		Route::get('/config/payment-type', 'ConfigController@paymentType')->name('config.paymentType');
		Route::get('/config/get-payment-type', 'ConfigController@getPaymentType')->name('config.paymentType.get');
		Route::post('/config/store-payment-type', 'ConfigController@storePaymentType')->name('config.paymentType.store');
		Route::post('/config/update-payment-type', 'ConfigController@updatePaymentType')->name('config.paymentType.update');
		Route::post('/config/destroy-payment-type', 'ConfigController@destroyPaymentType')->name('config.paymentType.destroy');
	// End of Configuration

	// Employee
		Route::get('/employee/list', 'EmployeeController@list')->name('employee.list');
		Route::get('/employee/get-employee', 'EmployeeController@getEmployee')->name('employee.get');
		Route::post('/employee/store-employee', 'EmployeeController@storeEmployee')->name('employee.store');
		Route::post('/employee/update-employee', 'EmployeeController@updateEmployee')->name('employee.update');
		Route::post('/employee/destroy-employee', 'EmployeeController@destroyEmployee')->name('employee.destroy');
	// End of Employee

	// Expense
		Route::get('/expense/list', 'ExpenseController@list')->name('expense.list');
		Route::get('/expense/get', 'ExpenseController@get')->name('expense.get');
		Route::post('/expense/store', 'ExpenseController@store')->name('expense.store');
		Route::post('/expense/update', 'ExpenseController@update')->name('expense.update');
		Route::post('/expense/destroy', 'ExpenseController@destroy')->name('expense.destroy');
	// End of Expense

	// Report
		Route::get('/report/sales-year', 'ReportController@salesYear')->name('report.salesYear');
		Route::get('/report/sales-month', 'ReportController@salesMonth')->name('report.salesMonth');
		Route::get('/report/turn-over', 'ReportController@turnOver')->name('report.turn-over');
		Route::get('/report/profit', 'ReportController@profit')->name('report.profit');
		Route::get('/report/cash', 'ReportController@cash')->name('report.cash');
		Route::get('/report/free-cash', 'ReportController@freeCash')->name('report.free-cash');
		Route::get('/report/payable-receivable', 'ReportController@payableReceivable')->name('report.payable-receivable');
		Route::get('/report/stock', 'ReportController@stock')->name('report.stock');
		Route::get('/report/expense', 'ReportController@expense')->name('report.expense');
	// End of Report

});