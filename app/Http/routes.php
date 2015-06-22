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

Route::get('/', ['as' => 'index', function()
{
	return Redirect::to('home');
}]);

Route::get('/home', ['as' => 'home', function()
{
    return view('pages/Frontend/home');
}]);

Route::get('/product', ['as' => 'product', function()
{
    return view('pages/Frontend/product');
}]);

Route::get('/join', ['as' => 'join', function()
{
    return view('pages/Frontend/join');
}]);

Route::get('/whyJoin', ['as' => 'whyJoin', function()
{
    return view('pages/Frontend/whyJoin');
}]);