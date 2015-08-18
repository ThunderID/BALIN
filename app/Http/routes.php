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
