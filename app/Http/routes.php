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
Route::get('join', ['uses' => 'Frontend\\joinController@index', 'as' => 'frontend.join.index']);
Route::get('whyJoin', ['uses' => 'Frontend\\whyjoinController@index', 'as' => 'frontend.whyjoin.index']);
Route::get('cart', ['uses' => 'Frontend\\cartController@index', 'as' => 'frontend.cart.index']);
Route::get('profile', ['uses' => 'Frontend\\profileController@index', 'as' => 'frontend.profile.index']);
Route::get('profile/membershipDetail', ['uses' => 'Frontend\\profileController@membershipDetail', 'as' => 'frontend.profile.membershipDetail']);
Route::get('profile/changePassword', ['uses' => 'Frontend\\profileController@changePassword', 'as' => 'frontend.profile.changePassword']);
Route::get('profile/changeProfile', ['uses' => 'Frontend\\profileController@changeProfile', 'as' => 'frontend.profile.changeProfile']);

Route::get('test/error', ['uses' => 'testController@error', 'as' => 'ftest.error']);

/*========================BACKEND-CMS=============================*/
Route::group(['prefix' => 'cms', 'namespace' => 'Backend\\'], function()
{
	/*--------------LOGIN--------------*/
	Route::get('/', 																				['uses' => 'authController@index', 													'as' => 'backend.login']);

	/*--------------HOME--------------*/
	Route::get('/dashboard', 																['uses' => 'homeController@index', 													'as' => 'backend.home']);

	/*--------------DATA PRODUCT---------------*/
	Route::resource('product',  'Data\\productController',					['names' => ['index' => 'backend.data.product.index', 'create' => 'backend.data.product.create', 'store' => 'backend.data.product.store', 'show' => 'backend.data.product.show', 'edit' => 'backend.data.product.edit', 'update' => 'backend.data.product.update', 'destroy' => 'backend.data.product.destroy']]);

	/*-----------DATA AJAX-[PRODUCT]----------*/
	Route::any('ajax/get-product', 													['uses' => 'Data\\productController@getProductBySKU' ,						'as' => 'backend.product.ajax.getProduct']);
	
	/*--------------DATA CUSTOMER---------------*/
	Route::resource('customer',  'Data\\customerController',							['names' => ['index' => 'backend.data.customer.index', 'create' => 'backend.data.customer.create', 'store' => 'backend.data.customer.store', 'show' => 'backend.data.customer.show', 'edit' => 'backend.data.customer.edit', 'update' => 'backend.data.customer.update', 'destroy' => 'backend.data.customer.destroy']]);

	/*--------------PRICE---------------*/
	Route::resource('price',  'priceController',						['names' => ['index' => 'backend.price.index', 'create' => 'backend.price.create', 'store' => 'backend.price.store', 'show' => 'backend.price.show', 'edit' => 'backend.price.edit', 'update' => 'backend.price.update', 'destroy' => 'backend.price.destroy']]);

	/*--------------DISCOUNT---------------*/
	Route::resource('discount',  'discountController',			['names' => ['index' => 'backend.discount.index', 'create' => 'backend.discount.create', 'store' => 'backend.discount.store', 'show' => 'backend.discount.show', 'edit' => 'backend.discount.edit', 'update' => 'backend.discount.update', 'destroy' => 'backend.discount.destroy']]);

	/*--------------SUPPLIER---------------*/
	Route::resource('supplier',  'supplierController',			['names' => ['index' => 'backend.supplier.index', 'create' => 'backend.supplier.create', 'store' => 'backend.supplier.store', 'show' => 'backend.supplier.show', 'edit' => 'backend.supplier.edit', 'update' => 'backend.supplier.update', 'destroy' => 'backend.supplier.destroy']]);


	/*--------------SETTING STORE---------------*/
	Route::resource('store',  'Setting\\storeController',						['names' => ['index' => 'backend.settings.store.index', 'create' => 'backend.settings.store.create', 'store' => 'backend.settings.store.store', 'show' => 'backend.settings.store.show', 'edit' => 'backend.settings.store.edit', 'update' => 'backend.settings.store.update', 'destroy' => 'backend.settings.store.destroy']]);

	/*--------------SETTING COURIER---------------*/
	Route::resource('courier',  'Setting\\courierController',				['names' => ['index' => 'backend.settings.courier.index', 'create' => 'backend.settings.courier.create', 'store' => 'backend.settings.courier.store', 'show' => 'backend.settings.courier.show', 'edit' => 'backend.settings.courier.edit', 'update' => 'backend.settings.courier.update', 'destroy' => 'backend.settings.courier.destroy']]);

	/*--------------SETTING CATEGORY--------------*/
	Route::resource('category', 'Setting\\categoryController', 				['names' => ['index' => 'backend.settings.category.index', 'create' => 'backend.settings.category.create', 'store' => 'backend.settings.category.store', 'show' => 'backend.settings.category.show', 'edit' => 'backend.settings.category.edit', 'update' => 'backend.settings.category.update', 'destroy' => 'backend.settings.category.destroy']]);

	/*-----------SETTING AJAX-[CATEGORY]----------*/
	Route::any('ajax/get-category',													['uses' => 'Setting\\categoryController@getCategoryByName', 					'as' => 'backend.category.ajax.getByName']);
	Route::any('ajax/get-category-parent',											['uses' => 'Setting\\categoryController@getCategoryParentByName', 		'as' => 'backend.category.ajax.getParent']);

});

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

// Route::get('cms/transaction', ['uses' => 'Backend\\transactionController@index', 'as' => 'backend.transaction.index']);


// ajax
// Route::get('cms/ajax/get-invoice', 'Backend\\transactionController@getTransactionByName');
// Route::get('cms/ajax/get-courierBranch', 'Backend\\courierBranchesController@getCourierBranchByName');



// test
Route::get('test/sendActivationEmail', ['uses' => 'testController@sendActivationEmail', 'as' => 'backend.test.sendActivationEmail']);
Route::get('test/sendBillingEmail', ['uses' => 'testController@sendBillingEmail', 'as' => 'backend.test.sendBillingEmail']);
Route::get('test/sendTransactionValidatedEmail', ['uses' => 'testController@sendTransactionValidatedEmail', 'as' => 'backend.test.sendTransactionValidatedEmail']);
Route::get('test/sendShipmentEmail', ['uses' => 'testController@sendShipmentEmail', 'as' => 'backend.test.sendShipmentEmail']);
Route::get('test/testlab', ['uses' => 'testController@testlab', 'as' => 'backend.test.testlab']);
Route::get('test/testcontroller', ['uses' => 'backend\\data\\paymentController@store', 'as' => 'backend.test.testcontroller']);
