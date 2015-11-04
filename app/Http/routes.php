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

		Route::resource('products',  	'ProductController',			['names' => ['index' => 'backend.data.product.index', 'create' => 'backend.data.product.create', 'store' => 'backend.data.product.store', 'show' => 'backend.data.product.show', 'edit' => 'backend.data.product.edit', 'update' => 'backend.data.product.update', 'destroy' => 'backend.data.product.destroy']]);
		
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
		// CUSTOMER (pending, crud)
		// ------------------------------------------------------------------------------------

		Route::resource('customers',  	'CustomerController',			['names' => ['index' => 'backend.data.customer.index', 'create' => 'backend.data.customer.create', 'store' => 'backend.data.customer.store', 'show' => 'backend.data.customer.show', 'edit' => 'backend.data.customer.edit', 'update' => 'backend.data.customer.update', 'destroy' => 'backend.data.customer.destroy']]);
	
		Route::any('ajax/get-customer-by-name',							['uses' => 'CustomerController@getCustomerByName', 'as' => 'backend.customer.ajax.getCustomerByName']);

		// ------------------------------------------------------------------------------------
		// TRANSACTION (pending, crud)
		// ------------------------------------------------------------------------------------

		Route::resource('transactions',	'TransactionController',		['names' => ['index' => 'backend.data.transaction.index', 'create' => 'backend.data.transaction.create', 'store' => 'backend.data.transaction.store', 'show' => 'backend.data.transaction.show', 'edit' => 'backend.data.transaction.edit', 'update' => 'backend.data.transaction.update', 'destroy' => 'backend.data.transaction.destroy']]);
		
		// ------------------------------------------------------------------------------------
		// PAYMENT
		// ------------------------------------------------------------------------------------
		
		Route::resource('payments',		'PaymentController',			['names' => ['index' => 'backend.data.payment.index', 'create' => 'backend.data.payment.create', 'store' => 'backend.data.payment.store', 'show' => 'backend.data.payment.show', 'edit' => 'backend.data.payment.edit', 'update' => 'backend.data.payment.update', 'destroy' => 'backend.data.payment.destroy']]);
		
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
	});
});

Route::get('/mail/activation/{activation_link}', 						['uses' => 'accountcontroller@activateAccount' ,'as' => 'balin.email.activation']);

/*Route::get('cms/category', ['uses' => 'Backend\\categoryController@index', 'as' => 'backend.category.index']);
Route::get('cms/category/detail', ['uses' => 'Backend\\categoryController@detail', 'as' => 'backend.category.detail']);
Route::get('cms/category/create', ['uses' => 'Backend\\categoryController@create', 'as' => 'backend.category.create']);
Route::get('cms/category/edit', ['uses' => 'Backend\\categoryController@edit', 'as' => 'backend.category.edit']);
Route::post('cms/category/save', ['uses' => 'Backend\\categoryController@save', 'as' => 'backend.category.save']);
Route::post('cms/category/delete', ['uses' => 'Backend\\categoryController@delete', 'as' => 'backend.category.delete']);
// ajax
Route::get('cms/ajax/get-category', 'Backend\\categoryController@getCategoryByName');
Route::get('cms/ajax/get-categoryParent', 'Backend\\categoryController@getCategoryParentByName');*/


// product
// Route::get('cms/product', ['uses' => 'Backend\\productController@index', 'as' => 'backend.product.index']);
// Route::get('cms/product/create', ['uses' => 'Backend\\productController@create', 'as' => 'backend.product.create']);
// Route::get('cms/product/edit', ['uses' => 'Backend\\productController@edit', 'as' => 'backend.product.edit']);
// Route::get('cms/product/create', ['uses' => 'Backend\\productController@create', 'as' => 'backend.product.create']);
// Route::post('cms/product/save', ['uses' => 'Backend\\productController@save', 'as' => 'backend.product.save']);
// Route::post('cms/product/delete', ['uses' => 'Backend\\productController@delete', 'as' => 'backend.product.delete']);
// // ajax
// Route::get('cms/ajax/get-product', 'Backend\\productController@getproductBySku');


// price
// Route::get('cms/price', ['uses' => 'Backend\\priceController@index', 'as' => 'backend.price.index']);
// Route::get('cms/price/detail', ['uses' => 'Backend\\priceController@detail', 'as' => 'backend.price.detail']);
// Route::get('cms/price/create', ['uses' => 'Backend\\priceController@create', 'as' => 'backend.price.create']);
// Route::get('cms/price/edit', ['uses' => 'Backend\\priceController@edit', 'as' => 'backend.price.edit']);
// Route::post('cms/price/save', ['uses' => 'Backend\\priceController@save', 'as' => 'backend.price.save']);
// Route::post('cms/price/delete', ['uses' => 'Backend\\priceController@delete', 'as' => 'backend.price.delete']);


// discount
// Route::get('cms/discount', ['uses' => 'Backend\\discountController@index', 'as' => 'backend.discount.index']);
// Route::get('cms/discount/detail', ['uses' => 'Backend\\discountController@detail', 'as' => 'backend.discount.detail']);
// Route::get('cms/discount/create', ['uses' => 'Backend\\discountController@create', 'as' => 'backend.discount.create']);
// Route::get('cms/discount/edit', ['uses' => 'Backend\\discountController@edit', 'as' => 'backend.discount.edit']);
// Route::post('cms/discount/save', ['uses' => 'Backend\\discountController@save', 'as' => 'backend.discount.save']);
// Route::post('cms/discount/delete', ['uses' => 'Backend\\discountController@delete', 'as' => 'backend.discount.delete']);

// supplier
// Route::get('cms/supplier', ['uses' => 'Backend\\supplierController@index', 'as' => 'backend.supplier.index']);
// Route::get('cms/supplier/detail', ['uses' => 'Backend\\supplierController@detail', 'as' => 'backend.supplier.detail']);
// Route::get('cms/supplier/create', ['uses' => 'Backend\\supplierController@create', 'as' => 'backend.supplier.create']);
// Route::get('cms/supplier/edit', ['uses' => 'Backend\\supplierController@edit', 'as' => 'backend.supplier.edit']);
// Route::post('cms/supplier/save', ['uses' => 'Backend\\supplierController@save', 'as' => 'backend.supplier.save']);
// Route::post('cms/supplier/delete', ['uses' => 'Backend\\supplierController@delete', 'as' => 'backend.supplier.delete']);


// Route::get('cms', ['uses' => 'Backend\\homeController@index', 'as' => 'backend.home']);
// Route::get('cms/courier', ['uses' => 'Backend\\courierController@index', 'as' => 'backend.courier.index']);
// Route::post('cms/courier/delete', ['uses' => 'Backend\\courierController@delete', 'as' => 'backend.courier.delete']);
// Route::post('cms/courier/save', ['uses' => 'Backend\\courierController@save', 'as' => 'backend.courier.save']);

// Route::get('cms/courier/detail', ['uses' => 'Backend\\courierController@detail', 'as' => 'backend.courier.detail']);
// Route::post('cms/courier/detail/save', ['uses' => 'Backend\\courierBranchesController@save', 'as' => 'backend.courier.detail.save']);
// Route::post('cms/courier/detail/delete', ['uses' => 'Backend\\courierBranchesController@delete', 'as' => 'backend.courier.detail.delete']);

// Route::get('cms/customer', ['uses' => 'Backend\\customerController@index', 'as' => 'backend.customer.index']);
// Route::post('cms/customer/delete', ['uses' => 'Backend\\customerController@delete', 'as' => 'backend.customer.delete']);

// Route::get('cms/shipping', ['uses' => 'Backend\\shippingController@index', 'as' => 'backend.shipping.index']);
// Route::post('cms/shipping/delete', ['uses' => 'Backend\\shippingController@delete', 'as' => 'backend.shipping.delete']);
// Route::post('cms/shipping/save', ['uses' => 'Backend\\shippingController@save', 'as' => 'backend.shipping.save']);

// Route::get('cms/payment', ['uses' => 'Backend\\paymentController@index', 'as' => 'backend.payment.index']);

// Route::get('cms/payment', ['uses' => 'Backend\\transactionController@index', 'as' => 'backend.transaction.index']);


// ajax
// Route::get('cms/ajax/get-invoice', 'Backend\\transactionController@getTransactionByName');
// Route::get('cms/ajax/get-courierBranch', 'Backend\\courierBranchesController@getCourierBranchByName');



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

// frontend
Route::get('/', ['as' => 'frontend.index', function(){return Redirect::route('frontend.home.index');}]);
Route::get('home', ['uses' => 'Frontend\\homeController@index', 'as' => 'frontend.home.index']);
Route::get('products', ['uses' => 'Frontend\\productController@index', 'as' => 'frontend.product.index']);
Route::get('products/{id}/detail', ['uses' => 'Frontend\\productController@show', 'as' => 'frontend.product.show']);
Route::get('join', ['uses' => 'Frontend\\joinController@index', 'as' => 'frontend.join.index']);
Route::get('whyJoin', ['uses' => 'Frontend\\whyjoinController@index', 'as' => 'frontend.whyjoin.index']);
Route::get('cart', ['uses' => 'Frontend\\cartController@index', 'as' => 'frontend.cart.index']);
Route::get('profile', ['uses' => 'Frontend\\profileController@index', 'as' => 'frontend.profile.index']);
Route::get('profile/membershipDetail', ['uses' => 'Frontend\\profileController@membershipDetail', 'as' => 'frontend.profile.membershipDetail']);
Route::get('profile/changePassword', ['uses' => 'Frontend\\profileController@changePassword', 'as' => 'frontend.profile.changePassword']);
Route::get('profile/changeProfile', ['uses' => 'Frontend\\profileController@changeProfile', 'as' => 'frontend.profile.changeProfile']);


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
