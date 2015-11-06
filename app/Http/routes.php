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

// ------------------------------------------------------------------------------------
// BACKEND
// ------------------------------------------------------------------------------------

// ------------------------------------------------------------------------------------
// LOGIN PAGE
// ------------------------------------------------------------------------------------
Route::group(['prefix' => 'cms', 'namespace' => 'Backend\\'], function()
{
	Route::post('/login',												['uses' => 'AuthController@doLogin', 	'as' => 'backend.dologin']);
});

Route::group(['prefix' => 'cms', 'namespace' => 'Backend\\', 'middleware' => 'auth'], function()
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

		Route::resource('product',  	'ProductUniversalController',			['names' => ['index' => 'backend.data.productuniversal.index', 'create' => 'backend.data.productuniversal.create', 'store' => 'backend.data.productuniversal.store', 'show' => 'backend.data.productuniversal.show', 'edit' => 'backend.data.productuniversal.edit', 'update' => 'backend.data.productuniversal.update', 'destroy' => 'backend.data.productuniversal.destroy']]);

		Route::resource('product/{uid?}/varian',  	'ProductController',		['names' => ['index' => 'backend.data.product.index', 'create' => 'backend.data.product.create', 'store' => 'backend.data.product.store', 'show' => 'backend.data.product.show', 'edit' => 'backend.data.product.edit', 'update' => 'backend.data.product.update', 'destroy' => 'backend.data.product.destroy']]);
		
		Route::any('ajax/get-product-by-name',							['uses' => 'ProductController@getProductByName', 'as' => 'backend.product.ajax.getProductByName']);

		Route::group(['namespace' => 'Product\\'], function()
		{
			// ------------------------------------------------------------------------------------
			// PRICE (pending crud)
			// ------------------------------------------------------------------------------------
		
			Route::resource('prices',  		'PriceController',				['names' => ['index' => 'backend.data.product.price.index', 'create' => 'backend.data.product.price.create', 'store' => 'backend.data.product.price.store', 'show' => 'backend.data.product.price.show', 'edit' => 'backend.data.product.price.edit', 'update' => 'backend.data.product.price.update', 'destroy' => 'backend.data.product.price.destroy']]);

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

		// ------------------------------------------------------------------------------------
		// POINTLOG
		// ------------------------------------------------------------------------------------
		Route::resource('users/{user_id?}/point/log', 'PointLogController',		['names' => ['index' => 'backend.data.pointlog.index', 'create' => 'backend.data.pointlog.create', 'store' => 'backend.data.pointlog.store', 'show' => 'backend.data.pointlog.show', 'edit' => 'backend.data.pointlog.edit', 'update' => 'backend.data.pointlog.update', 'destroy' => 'backend.data.pointlog.destroy']]);

		// ------------------------------------------------------------------------------------
		// TRANSACTION (pending, crud)
		// ------------------------------------------------------------------------------------

		Route::resource('transactions',	'TransactionController',		['names' => ['index' => 'backend.data.transaction.index', 'create' => 'backend.data.transaction.create', 'store' => 'backend.data.transaction.store', 'show' => 'backend.data.transaction.show', 'edit' => 'backend.data.transaction.edit', 'update' => 'backend.data.transaction.update', 'destroy' => 'backend.data.transaction.destroy']]);
		
		Route::any('transactions/change/status/{id}',					['uses' => 'TransactionController@changeStatus', 'as' => 'backend.data.transaction.status']);
		
		Route::any('ajax/get-transaction-by-amount',					['uses' => 'TransactionController@getTransactionByAmount', 'as' => 'backend.transaction.ajax.getByAmount']);
		
		// ------------------------------------------------------------------------------------
		// PAYMENT
		// ------------------------------------------------------------------------------------
		
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
		// CATEGORY (CHECK)
		// ------------------------------------------------------------------------------------
		
		Route::resource('categories', 	'CategoryController', 			['names' => ['index' => 'backend.settings.category.index', 'create' => 'backend.settings.category.create', 'store' => 'backend.settings.category.store', 'show' => 'backend.settings.category.show', 'edit' => 'backend.settings.category.edit', 'update' => 'backend.settings.category.update', 'destroy' => 'backend.settings.category.destroy']]);
		
		Route::any('ajax/get-category',									['uses' => 'CategoryController@getCategoryByName', 'as' => 'backend.category.ajax.getByName']);

		Route::any('ajax/get-category-parent',							['uses' => 'CategoryController@getCategoryParentByName', 'as' => 'backend.category.ajax.getParent']);

		// ------------------------------------------------------------------------------------
		// VOUCHER
		// ------------------------------------------------------------------------------------
		
		Route::resource('vouchers', 	'VoucherController', 			['names' => ['index' => 'backend.settings.voucher.index', 'create' => 'backend.settings.voucher.create', 'store' => 'backend.settings.voucher.store', 'show' => 'backend.settings.voucher.show', 'edit' => 'backend.settings.voucher.edit', 'update' => 'backend.settings.voucher.update', 'destroy' => 'backend.settings.voucher.destroy']]);

		// ------------------------------------------------------------------------------------
		// COURIER (Store, save image only if there were upload image. Need to sync with job)
		// ------------------------------------------------------------------------------------

		Route::resource('couriers',  	'CourierController',			['names' => ['index' => 'backend.settings.courier.index', 'create' => 'backend.settings.courier.create', 'store' => 'backend.settings.courier.store', 'show' => 'backend.settings.courier.show', 'edit' => 'backend.settings.courier.edit', 'update' => 'backend.settings.courier.update', 'destroy' => 'backend.settings.courier.destroy']]);
		
		Route::resource('couriers/{cou_id?}/shipping/cost',				'ShippingCostController',			['names' => ['index' => 'backend.settings.shippingCost.index', 'create' => 'backend.settings.shippingCost.create', 'store' => 'backend.settings.shippingCost.store', 'show' => 'backend.settings.shippingCost.show', 'edit' => 'backend.settings.shippingCost.edit', 'update' => 'backend.settings.shippingCost.update', 'destroy' => 'backend.settings.shippingCost.destroy']]);

		Route::any('ajax/get-courier-by-name',							['uses' => 'CourierController@getCourierByName', 'as' => 'backend.courier.ajax.getCourierByName']);

		// ------------------------------------------------------------------------------------
		// STORE
		// ------------------------------------------------------------------------------------

		Route::resource('store',  		'StoreController',				['names' => ['index' => 'backend.settings.store.index', 'create' => 'backend.settings.store.create', 'store' => 'backend.settings.store.store', 'show' => 'backend.settings.store.show', 'edit' => 'backend.settings.store.edit', 'update' => 'backend.settings.store.update', 'destroy' => 'backend.settings.store.destroy']]);

		// ------------------------------------------------------------------------------------
		// FEATURED PRODUCT
		// ------------------------------------------------------------------------------------

		Route::resource('features',		'FeatureController',			['names' => ['index' => 'backend.settings.feature.index', 'create' => 'backend.settings.feature.create', 'store' => 'backend.settings.feature.store', 'show' => 'backend.settings.feature.show', 'edit' => 'backend.settings.feature.edit', 'update' => 'backend.settings.feature.update', 'destroy' => 'backend.settings.feature.destroy']]);

		// ------------------------------------------------------------------------------------
		// POLICY
		// ------------------------------------------------------------------------------------

		Route::resource('policies',		'PolicyController',				['names' => ['index' => 'backend.settings.policies.index', 'create' => 'backend.settings.policies.create', 'store' => 'backend.settings.policies.store', 'show' => 'backend.settings.policies.show', 'edit' => 'backend.settings.policies.edit', 'update' => 'backend.settings.policies.update', 'destroy' => 'backend.settings.policies.destroy']]);

		// ------------------------------------------------------------------------------------
		// AUTHENTICATION
		// ------------------------------------------------------------------------------------

		Route::resource('authentications', 'AuthenticationController',	['names' => ['index' => 'backend.settings.authentication.index', 'create' => 'backend.settings.authentication.create', 'store' => 'backend.settings.authentication.store', 'show' => 'backend.settings.authentication.show', 'edit' => 'backend.settings.authentication.edit', 'update' => 'backend.settings.authentication.update', 'destroy' => 'backend.settings.authentication.destroy']]);
	});

	// ------------------------------------------------------------------------------------
	// REPORT
	// ------------------------------------------------------------------------------------
	Route::group(['namespace' => 'Report\\'], function()
	{
		// ------------------------------------------------------------------------------------
		// GUDANG - CRITICAL STOCK
		// ------------------------------------------------------------------------------------
		
		Route::any('criticals',											['uses' => 'CriticalController@index', 'as' => 'backend.report.critical.stock']);
	});
});

Route::get('/mail/activation/{activation_link}', 						['uses' => 'accountcontroller@activateAccount' ,'as' => 'balin.email.activation']);

// test
Route::get('test/sendActivationEmail', ['uses' => 'testController@sendActivationEmail', 'as' => 'backend.test.sendActivationEmail']);
Route::get('test/sendBillingEmail', ['uses' => 'testController@sendBillingEmail', 'as' => 'backend.test.sendBillingEmail']);
Route::get('test/sendTransactionValidatedEmail', ['uses' => 'testController@sendTransactionValidatedEmail', 'as' => 'backend.test.sendTransactionValidatedEmail']);
Route::get('test/sendShipmentEmail', ['uses' => 'testController@sendShipmentEmail', 'as' => 'backend.test.sendShipmentEmail']);
Route::get('test/testlab', ['uses' => 'testController@testlab', 'as' => 'backend.test.testlab']);
Route::get('test/testcontroller', ['uses' => 'backend\\data\\transactionController@createsell', 'as' => 'backend.test.testcontroller']);
Route::post('test/testcontroller', ['uses' => 'backend\\data\\transactionController@sell', 'as' => 'backend.test.testcontroller.post']);
Route::get('test/generatePassword', function()
{
	echo Hash::make('admin');
});

Route::get('report/criticalStock', ['uses' => 'backend\\reportController@criticalStock', 'as' => 'backend.report.criticalstock']);
Route::get('report/pointlog', ['uses' => 'backend\\reportController@pointlog', 'as' => 'backend.report.pointlog']);
Route::get('report/topsellingproduct', ['uses' => 'backend\\reportController@topSellingProduct', 'as' => 'backend.report.topSellingProduct']);
Route::get('report/suppliedby', ['uses' => 'backend\\reportController@suppliedby', 'as' => 'backend.report.suppliedby']);
Route::get('report/deadstock', ['uses' => 'backend\\reportController@deadstock', 'as' => 'backend.report.deadstock']);
Route::get('report', ['uses' => 'backend\\reportController@index', 'as' => 'backend.report.index']);


// Route::get('/', function () {
//     // return view('pages/Frontend/product');
//     // return view('template/Frontend/index');
//     // return view('template/Frontend/layout');

//     //'shippings' => nama function di relations
//  	// $tes = \Models\Courier::with(['Shippings'])->get();
//   //   print_r($tes);
// });

// ------------------------------------------------------------------------------------
// FRONTEND
// ------------------------------------------------------------------------------------
// 
Route::get('/', ['as' => 'frontend.index', function(){ return Redirect::route('frontend.home.index'); }]);

Route::group(['namespace' => 'Frontend\\'], function() {
	Route::post('do-login',				['uses' => 'authController@doLogin', 'as' => 'frontend.dologin']);
	Route::get('do-logout',				['uses' => 'authController@doLogout', 'as' => 'frontend.dologout']);

	Route::get('home', 					['uses' => 'homeController@index', 'as' => 'frontend.home.index']);

	Route::get('products', 				['uses' => 'productController@index', 'as' => 'frontend.product.index']);
	Route::get('products/{id}/detail', 	['uses' => 'productController@show', 'as' => 'frontend.product.show']);

	Route::get('join', 					['uses' => 'joinController@index', 'as' => 'frontend.join.index']);
	Route::get('whyJoin', 				['uses' => 'whyjoinController@index', 'as' => 'frontend.whyjoin.index']);
	
	Route::get('cart', 					['uses' => 'cartController@index', 'as' => 'frontend.cart.index']);
	Route::post('addtocart', 			['uses' => 'cartController@store', 'as' => 'frontend.cart.store']);
	Route::get('removetocart', 			['uses' => 'cartController@destroy', 'as' => 'frontend.cart.destroy']);

	Route::get('profile', 				['uses' => 'profileController@index', 'as' => 'frontend.profile.index']);

	Route::group(['prefix' => 'profile'], function() 
	{
		Route::get('membership-detail', 		['uses' => 'profileController@membershipDetail', 'as' => 'frontend.profile.membershipDetail']);
		Route::get('change-password', 			['uses' => 'profileController@changePassword', 'as' => 'frontend.profile.changePassword']);
		Route::get('change-rofile', 			['uses' => 'profileController@changeProfile', 'as' => 'frontend.profile.changeProfile']);
	});
	
});

Route::get('testsso/{provider?}', ['uses' => 'Frontend\\authSocialController@getSocialAuth', 'as' => 'frontend.sso.login']);
Route::get('testgetcookie', ['uses' => 'Frontend\\productController@detail', 'as' => 'frontend.home.test']);
Route::get('testcookie', ['uses' => 'Frontend\\productController@removeFromCart', 'as' => 'frontend.home.test2']);


Route::get('test/error', ['uses' => 'testController@error', 'as' => 'ftest.error']);
Route::get('test/email', ['uses' => 'testController@testEmail', 'as' => 'test.email']);

Route::get('/b', 													['uses' => 'HomeController@index', 		'as' => 'balin.about.us']);
Route::get('/a', 													['uses' => 'HomeController@index', 		'as' => 'balin.term.condition']);
Route::get('/c', 													['uses' => 'HomeController@index', 		'as' => 'balin.claim.voucher']);

// Route::get('cookieset', function()
// {
//     $foreverCookie = Cookie::forever('forever', 'Success');
//     $tempCookie = Cookie::make('temporary', 'Victory', 5);
//     return Response::make()->withCookie($foreverCookie)->withCookie($tempCookie);
// });


// Route::get('cookietest', function()
// {
//      $forever = Cookie::get('forever');
//      $temporary = Cookie::get('temporary');
//      dd($forever);
//      return View::make('cookietest', array('forever' => $forever, 'temporary' => $temporary, 'variableTest' => 'works'));
// });
