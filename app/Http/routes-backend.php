<?php

// ------------------------------------------------------------------------------------
// BACKEND
// ------------------------------------------------------------------------------------

// ------------------------------------------------------------------------------------
// LOGIN PAGE
// ------------------------------------------------------------------------------------
Route::group(['domain' => 'editorial.balin.id', 'namespace' => 'Backend\\'], function()
{
	Route::post('/login',												['uses' => 'AuthController@doLogin', 	'as' => 'backend.dologin']);
});

Route::group(['domain' => 'editorial.balin.id', 'namespace' => 'Backend\\', 'middleware' => ['auth', 'staff']], function()
{
	Route::get('/change-password',										['uses' => 'PasswordController@create', 'as' => 'backend.changePassword']);
	
	Route::post('/update-password',										['uses' => 'PasswordController@store', 'as' => 'backend.updatePassword']);
	
	Route::get('/logout',												['uses' => 'AuthController@doLogout', 'as' => 'backend.dologout']);

	// ------------------------------------------------------------------------------------
	// DASHBOARD
	// ------------------------------------------------------------------------------------

	Route::get('/', 													['uses' => 'HomeController@index', 		'as' => 'backend.home']);

	// ------------------------------------------------------------------------------------
	// DATA
	// ------------------------------------------------------------------------------------
	Route::group(['namespace' => 'Data\\'], function()
	{
		// ------------------------------------------------------------------------------------
		// PRODUCT (pending, show, delete)
		// ------------------------------------------------------------------------------------

		Route::resource('product',  	'ProductController',			['names' => ['index' => 'backend.data.product.index', 'create' => 'backend.data.product.create', 'store' => 'backend.data.product.store', 'show' => 'backend.data.product.show', 'edit' => 'backend.data.product.edit', 'update' => 'backend.data.product.update', 'destroy' => 'backend.data.product.destroy']]);

		Route::any('ajax/get-product-by-name',							['uses' => 'ProductController@getProductByName', 'as' => 'backend.product.ajax.getProductByName']);

		Route::group(['namespace' => 'Product\\'], function()
		{
			// ------------------------------------------------------------------------------------
			// PRICE (pending crud)
			// ------------------------------------------------------------------------------------
			Route::resource('product/{pid?}/price',  		'PriceController',				['names' => ['index' => 'backend.data.product.price.index', 'create' => 'backend.data.product.price.create', 'store' => 'backend.data.product.price.store', 'show' => 'backend.data.product.price.show', 'edit' => 'backend.data.product.price.edit', 'update' => 'backend.data.product.price.update', 'destroy' => 'backend.data.product.price.destroy']]);
			
			Route::resource('product/{pid?}/varian',  	'VarianController',		['names' => ['index' => 'backend.data.product.varian.index', 'create' => 'backend.data.product.varian.create', 'store' => 'backend.data.product.varian.store', 'show' => 'backend.data.product.varian.show', 'edit' => 'backend.data.product.varian.edit', 'update' => 'backend.data.product.varian.update', 'destroy' => 'backend.data.product.varian.destroy']]);

		});
		// ------------------------------------------------------------------------------------
		// SUPPLIER (pending, show)
		// ------------------------------------------------------------------------------------

		Route::resource('suppliers',  	'SupplierController',			['names' => ['index' => 'backend.data.supplier.index', 'create' => 'backend.data.supplier.create', 'store' => 'backend.data.supplier.store', 'show' => 'backend.data.supplier.show', 'edit' => 'backend.data.supplier.edit', 'update' => 'backend.data.supplier.update', 'destroy' => 'backend.data.supplier.destroy']]);
		
		Route::any('ajax/get-supplier-by-name', 						['uses' => 'SupplierController@getSupplierByName', 'as' => 'backend.supplier.ajax.getSupplierByName']);

		// ------------------------------------------------------------------------------------
		// CUSTOMER
		// ------------------------------------------------------------------------------------

		Route::resource('customers',  	'CustomerController',			['names' => ['index' => 'backend.data.customer.index', 'create' => 'backend.data.customer.create', 'store' => 'backend.data.customer.store', 'show' => 'backend.data.customer.show', 'edit' => 'backend.data.customer.edit', 'update' => 'backend.data.customer.update', 'destroy' => 'backend.data.customer.destroy']]);
	
		Route::any('ajax/get-customer-by-name',							['uses' => 'CustomerController@getCustomerByName', 'as' => 'backend.customer.ajax.getCustomerByName']);
		
		Route::any('customers/resend/email/{id}',						['uses' => 'CustomerController@ResendEmail', 'as' => 'backend.data.customer.mail']);

		// ------------------------------------------------------------------------------------
		// POINTLOG
		// ------------------------------------------------------------------------------------
		Route::resource('users/{user_id?}/point/log', 'PointLogController',		['names' => ['index' => 'backend.data.pointlog.index', 'create' => 'backend.data.pointlog.create', 'store' => 'backend.data.pointlog.store', 'show' => 'backend.data.pointlog.show', 'edit' => 'backend.data.pointlog.edit', 'update' => 'backend.data.pointlog.update', 'destroy' => 'backend.data.pointlog.destroy']]);

		// ------------------------------------------------------------------------------------
		// TRANSACTION
		// ------------------------------------------------------------------------------------

		Route::resource('transactions',	'TransactionController',		['names' => ['index' => 'backend.data.transaction.index', 'create' => 'backend.data.transaction.create', 'store' => 'backend.data.transaction.store', 'show' => 'backend.data.transaction.show', 'edit' => 'backend.data.transaction.edit', 'update' => 'backend.data.transaction.update', 'destroy' => 'backend.data.transaction.destroy']]);
		
		Route::any('transactions/change/status/{id}',					['uses' => 'TransactionController@ChangeStatus', 'as' => 'backend.data.transaction.status']);
		
		Route::any('ajax/get-transaction-by-amount',					['uses' => 'TransactionController@getTransactionByAmount', 'as' => 'backend.transaction.ajax.getByAmount']);
		
		Route::any('transactions/resend/email/{id}',					['uses' => 'TransactionController@ResendEmail', 'as' => 'backend.data.transaction.email']);
		
		// ------------------------------------------------------------------------------------
		// PAYMENT
		// ------------------------------------------------------------------------------------
		
		Route::get('transaction/payments',								['uses' => 'PaymentController@getpaid', 'as' => 'backend.data.sell.getpaid']);
		
		Route::resource('payments',		'PaymentController',			['names' => ['index' => 'backend.data.payment.index', 'create' => 'backend.data.payment.create', 'store' => 'backend.data.payment.store', 'show' => 'backend.data.payment.show', 'edit' => 'backend.data.payment.edit', 'update' => 'backend.data.payment.update', 'destroy' => 'backend.data.payment.destroy']]);

		// ------------------------------------------------------------------------------------
		// SHIPMENT
		// ------------------------------------------------------------------------------------
		
		Route::resource('shipments',	'ShipmentController',			['names' => ['index' => 'backend.data.shipment.index', 'create' => 'backend.data.shipment.create', 'store' => 'backend.data.shipment.store', 'show' => 'backend.data.shipment.show', 'edit' => 'backend.data.shipment.edit', 'update' => 'backend.data.shipment.update', 'destroy' => 'backend.data.shipment.destroy']]);
		
	});

	// ------------------------------------------------------------------------------------
	// SETTING
	// ------------------------------------------------------------------------------------
	Route::group(['namespace' => 'Setting\\'], function()
	{
		// ------------------------------------------------------------------------------------
		// CATEGORY
		// ------------------------------------------------------------------------------------
		
		Route::resource('categories', 	'CategoryController', 			['names' => ['index' => 'backend.settings.category.index', 'create' => 'backend.settings.category.create', 'store' => 'backend.settings.category.store', 'show' => 'backend.settings.category.show', 'edit' => 'backend.settings.category.edit', 'update' => 'backend.settings.category.update', 'destroy' => 'backend.settings.category.destroy']]);
		
		Route::any('ajax/get-category',									['uses' => 'CategoryController@getCategoryByName', 'as' => 'backend.category.ajax.getByName']);

		Route::any('ajax/get-category-parent',							['uses' => 'CategoryController@getCategoryParentByName', 'as' => 'backend.category.ajax.getParent']);

		// ------------------------------------------------------------------------------------
		// TAG
		// ------------------------------------------------------------------------------------
		
		Route::resource('tags', 	'TagController', 					['names' => ['index' => 'backend.settings.tag.index', 'create' => 'backend.settings.tag.create', 'store' => 'backend.settings.tag.store', 'show' => 'backend.settings.tag.show', 'edit' => 'backend.settings.tag.edit', 'update' => 'backend.settings.tag.update', 'destroy' => 'backend.settings.tag.destroy']]);
		
		Route::any('ajax/get-tag',										['uses' => 'TagController@getTagByName', 'as' => 'backend.tag.ajax.getByName']);

		Route::any('ajax/get-tag-parent',								['uses' => 'TagController@getTagParentByName', 'as' => 'backend.tag.ajax.getParent']);

		// ------------------------------------------------------------------------------------
		// COURIER (Store, save image only if there were upload image. Need to sync with job)
		// ------------------------------------------------------------------------------------

		Route::resource('couriers',  	'CourierController',			['names' => ['index' => 'backend.settings.courier.index', 'create' => 'backend.settings.courier.create', 'store' => 'backend.settings.courier.store', 'show' => 'backend.settings.courier.show', 'edit' => 'backend.settings.courier.edit', 'update' => 'backend.settings.courier.update', 'destroy' => 'backend.settings.courier.destroy']]);
		
		Route::resource('couriers/{cou_id?}/shipping/cost',				'ShippingCostController',			['names' => ['index' => 'backend.settings.shippingCost.index', 'create' => 'backend.settings.shippingCost.create', 'store' => 'backend.settings.shippingCost.store', 'show' => 'backend.settings.shippingCost.show', 'edit' => 'backend.settings.shippingCost.edit', 'update' => 'backend.settings.shippingCost.update', 'destroy' => 'backend.settings.shippingCost.destroy']]);
		
		Route::any('couriers/{cou_id?}/shipping/cost/import',			['uses' => 'ShippingCostController@import', 'as' => 'backend.settings.shippingcost.import']);

		Route::any('ajax/get-courier-by-name',							['uses' => 'CourierController@getCourierByName', 'as' => 'backend.courier.ajax.getCourierByName']);

		Route::group(['middleware' => 'manager'], function()
		{
		// ------------------------------------------------------------------------------------
		// VOUCHER
		// ------------------------------------------------------------------------------------
		
		Route::resource('vouchers', 	'VoucherController', 			['names' => ['index' => 'backend.settings.voucher.index', 'create' => 'backend.settings.voucher.create', 'store' => 'backend.settings.voucher.store', 'show' => 'backend.settings.voucher.show', 'edit' => 'backend.settings.voucher.edit', 'update' => 'backend.settings.voucher.update', 'destroy' => 'backend.settings.voucher.destroy']]);
		
		// ------------------------------------------------------------------------------------
		// QUOTA
		// ------------------------------------------------------------------------------------
		
		Route::resource('vouchers/{vou_id?}/quotas', 					'QuotaController', 				['names' => ['index' => 'backend.settings.quota.index', 'create' => 'backend.settings.quota.create', 'store' => 'backend.settings.quota.store', 'show' => 'backend.settings.quota.show', 'edit' => 'backend.settings.quota.edit', 'update' => 'backend.settings.quota.update', 'destroy' => 'backend.settings.quota.destroy']]);

		// ------------------------------------------------------------------------------------
		// VOUCHERS' MAIL
		// ------------------------------------------------------------------------------------
		Route::get('vouchers/mail/{id}',								['uses' => 'VoucherController@getMail', 'as' => 'backend.settings.voucher.getmail']);
		
		Route::post('vouchers/mail/{id}',								['uses' => 'VoucherController@postMail', 'as' => 'backend.settings.voucher.postmail']);

		// ------------------------------------------------------------------------------------
		// STORE
		// ------------------------------------------------------------------------------------

		Route::resource('store',  		'StoreController',				['names' => ['index' => 'backend.settings.store.index', 'create' => 'backend.settings.store.create', 'store' => 'backend.settings.store.store', 'show' => 'backend.settings.store.show', 'edit' => 'backend.settings.store.edit', 'update' => 'backend.settings.store.update', 'destroy' => 'backend.settings.store.destroy']]);

		// ------------------------------------------------------------------------------------
		// FEATURED PRODUCT
		// ------------------------------------------------------------------------------------

		Route::resource('features',		'FeatureController',			['names' => ['index' => 'backend.settings.feature.index', 'create' => 'backend.settings.feature.create', 'store' => 'backend.settings.feature.store', 'show' => 'backend.settings.feature.show', 'edit' => 'backend.settings.feature.edit', 'update' => 'backend.settings.feature.update', 'destroy' => 'backend.settings.feature.destroy']]);
	
		Route::get('features/{id}/preview', 							['uses' => 'FeatureController@showPreview', 'as' => 'backend.settings.feature.show.preview']);


		// ------------------------------------------------------------------------------------
		// AUTHENTICATION
		// ------------------------------------------------------------------------------------

		Route::resource('authentications', 'AuthenticationController',	['names' => ['index' => 'backend.settings.authentication.index', 'create' => 'backend.settings.authentication.create', 'store' => 'backend.settings.authentication.store', 'show' => 'backend.settings.authentication.show', 'edit' => 'backend.settings.authentication.edit', 'update' => 'backend.settings.authentication.update', 'destroy' => 'backend.settings.authentication.destroy']]);
		});

		Route::group(['middleware' => 'admin'], function()
		{
		// ------------------------------------------------------------------------------------
		// POLICY
		// ------------------------------------------------------------------------------------

		Route::resource('policies',		'PolicyController',				['names' => ['index' => 'backend.settings.policies.index', 'create' => 'backend.settings.policies.create', 'store' => 'backend.settings.policies.store', 'show' => 'backend.settings.policies.show', 'edit' => 'backend.settings.policies.edit', 'update' => 'backend.settings.policies.update', 'destroy' => 'backend.settings.policies.destroy']]);
		});
	});

	// ------------------------------------------------------------------------------------
	// REPORT
	// ------------------------------------------------------------------------------------
	Route::group(['namespace' => 'Report\\', 'middleware' => 'manager'], function()
	{
		// ------------------------------------------------------------------------------------
		// GUDANG - CRITICAL STOCK
		// ------------------------------------------------------------------------------------
		
		Route::any('criticals',											['uses' => 'WarehouseController@critical', 'as' => 'backend.report.critical.stock']);

		// ------------------------------------------------------------------------------------
		// GUDANG - GLOBAL STOCK
		// ------------------------------------------------------------------------------------
		
		Route::any('stocks',											['uses' => 'WarehouseController@stock', 'as' => 'backend.report.global.stock']);

		// ------------------------------------------------------------------------------------
		// GUDANG - GLOBAL STOCK
		// ------------------------------------------------------------------------------------
		
		Route::any('movements',											['uses' => 'WarehouseController@movement', 'as' => 'backend.report.movement.stock']);

		// ------------------------------------------------------------------------------------
		// MARKET - MOST DOWNLINE
		// ------------------------------------------------------------------------------------
		
		Route::any('downlines',											['uses' => 'CustomerController@downline', 'as' => 'backend.report.customer.downline']);
	
		// ------------------------------------------------------------------------------------
		// MARKET - MOST BALANCE
		// ------------------------------------------------------------------------------------
		
		Route::any('balances',											['uses' => 'CustomerController@balance', 'as' => 'backend.report.customer.balance']);

		// ------------------------------------------------------------------------------------
		// MARKET - MOST CUSTOMER
		// ------------------------------------------------------------------------------------
		
		Route::any('most/buy/customer',									['uses' => 'CustomerController@mostbuy', 'as' => 'backend.report.customer.mostbuy']);

		// ------------------------------------------------------------------------------------
		// MARKET - FREQ CUSTOMER
		// ------------------------------------------------------------------------------------
		
		Route::any('frequent/buy/customer',								['uses' => 'CustomerController@frequentbuy', 'as' => 'backend.report.customer.frequentbuy']);

		// ------------------------------------------------------------------------------------
		// MARKET - MOST PRODUCT
		// ------------------------------------------------------------------------------------
		
		Route::any('most/buy/product',									['uses' => 'ProductController@mostbuy', 'as' => 'backend.report.product.mostbuy']);

		// ------------------------------------------------------------------------------------
		// MARKET - FREQ PRODUCT
		// ------------------------------------------------------------------------------------
		
		Route::any('frequent/buy/product',								['uses' => 'ProductController@frequentbuy', 'as' => 'backend.report.product.frequentbuy']);

		// ------------------------------------------------------------------------------------
		// FINANCE - POINT LOG
		// ------------------------------------------------------------------------------------
		
		Route::any('finance/point',										['uses' => 'FinanceController@point', 'as' => 'backend.report.finance.point']);

		// ------------------------------------------------------------------------------------
		// FINANCE - SELL/BUY TRANSACTION
		// ------------------------------------------------------------------------------------
		
		Route::any('finance/transaction',								['uses' => 'FinanceController@transaction', 'as' => 'backend.report.finance.transaction']);

		// ------------------------------------------------------------------------------------
		// FINANCE - HPP/HJ PRODUCT
		// ------------------------------------------------------------------------------------
		
		Route::any('finance/price',										['uses' => 'FinanceController@price', 'as' => 'backend.report.finance.price']);
		
		Route::group(['middleware' => 'admin'], function()
		{

		// ------------------------------------------------------------------------------------
		// AUDIT - ABANDONED CART
		// ------------------------------------------------------------------------------------
		
		Route::any('audit/abandoned',									['uses' => 'AuditController@abandoned', 'as' => 'backend.report.audit.abandoned']);

		// ------------------------------------------------------------------------------------
		// AUDIT - PAID 
		// ------------------------------------------------------------------------------------
		
		Route::any('audit/paid',										['uses' => 'AuditController@paid', 'as' => 'backend.report.audit.paid']);

		// ------------------------------------------------------------------------------------
		// AUDIT - SHIPPING
		// ------------------------------------------------------------------------------------
		
		Route::any('audit/ship',										['uses' => 'AuditController@ship', 'as' => 'backend.report.audit.ship']);

		// ------------------------------------------------------------------------------------
		// AUDIT - DELIVER
		// ------------------------------------------------------------------------------------
		
		Route::any('audit/deliver',										['uses' => 'AuditController@deliver', 'as' => 'backend.report.audit.deliver']);

		// ------------------------------------------------------------------------------------
		// AUDIT - CANCELED 
		// ------------------------------------------------------------------------------------
		
		Route::any('audit/cancel',										['uses' => 'AuditController@cancel', 'as' => 'backend.report.audit.cancel']);

		// ------------------------------------------------------------------------------------
		// AUDIT - PRICE
		// ------------------------------------------------------------------------------------
		
		Route::any('audit/price',										['uses' => 'AuditController@price', 'as' => 'backend.report.audit.price']);

		// ------------------------------------------------------------------------------------
		// AUDIT - VOUCHER
		// ------------------------------------------------------------------------------------
		
		Route::any('audit/voucher',										['uses' => 'AuditController@voucher', 'as' => 'backend.report.audit.voucher']);

		// ------------------------------------------------------------------------------------
		// AUDIT - POLICY 
		// ------------------------------------------------------------------------------------
		
		Route::any('audit/policy',										['uses' => 'AuditController@policy', 'as' => 'backend.report.audit.policy']);

		// ------------------------------------------------------------------------------------
		// AUDIT - POINT
		// ------------------------------------------------------------------------------------
		
		Route::any('audit/point',										['uses' => 'AuditController@point', 'as' => 'backend.report.audit.point']);

		// ------------------------------------------------------------------------------------
		// AUDIT - QUOTA
		// ------------------------------------------------------------------------------------
		
		Route::any('audit/quota',										['uses' => 'AuditController@quota', 'as' => 'backend.report.audit.quota']);
		});
	});

	Route::get('404',			['uses' => 'ErrorController@error_404', 'as' => 'backend.error.404']);
});