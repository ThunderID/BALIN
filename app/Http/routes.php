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

Route::get('/', function () {
    // return view('pages/Frontend/home');
    // return view('template/Frontend/index');
    return view('template/Frontend/layout');

    //'shippings' => nama function di relations
 	// $tes = \Models\Courier::with(['Shippings'])->get();
  //   print_r($tes);
});
