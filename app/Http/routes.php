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

// backend
// category
Route::get('cms/category', ['uses' => 'Backend\\categoryController@index', 'as' => 'backend.category.index']);
Route::get('cms/category/detail', ['uses' => 'Backend\\categoryController@detail', 'as' => 'backend.category.detail']);
Route::get('cms/category/create', ['uses' => 'Backend\\categoryController@create', 'as' => 'backend.category.create']);
Route::get('cms/category/edit', ['uses' => 'Backend\\categoryController@edit', 'as' => 'backend.category.edit']);
Route::post('cms/category/save', ['uses' => 'Backend\\categoryController@save', 'as' => 'backend.category.save']);
Route::post('cms/category/delete', ['uses' => 'Backend\\categoryController@delete', 'as' => 'backend.category.delete']);
// ajax
Route::get('cms/ajax/get-category', 'Backend\\categoryController@getCategoryByName');
Route::get('cms/ajax/get-categoryParent', 'Backend\\categoryController@getCategoryParentByName');


// product
Route::get('cms/product', ['uses' => 'Backend\\productController@index', 'as' => 'backend.product.index']);
Route::get('cms/product/create', ['uses' => 'Backend\\productController@create', 'as' => 'backend.product.create']);
Route::get('cms/product/edit', ['uses' => 'Backend\\productController@edit', 'as' => 'backend.product.edit']);
Route::get('cms/product/create', ['uses' => 'Backend\\productController@create', 'as' => 'backend.product.create']);
Route::post('cms/product/save', ['uses' => 'Backend\\productController@save', 'as' => 'backend.product.save']);
Route::post('cms/product/delete', ['uses' => 'Backend\\productController@delete', 'as' => 'backend.product.delete']);


Route::get('cms', ['uses' => 'Backend\\homeController@index', 'as' => 'backend.home']);
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