<?php namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\baseController;
use App\Models\User;
use Input, Session, DB, Redirect, Response, Auth;

class authController extends baseController 
{
	// protected $view_name 			= 'Login';

	public function doLogin()
	{ 
		$email	 					= Input::get('email');
		$password 					= Input::get('password');
		$check 						= Auth::attempt(['email' => $email, 'password' => $password]);

		if ($check)
		{
			$redirect 				= Session::get('login_redirect');
			Session::forget('login_redirect');

			return Redirect::intended($redirect);
		}
		
		return Redirect::back()->withErrors(['Username dan password yang anda masukkan tidak cocok dengan data kami. Harap anda memeriksa data masukkan dan mencoba lagi.']);
	}

	public function doLogout()
	{
		Auth::logout();
		
		Session::flush();

		return Redirect::route('frontend.home.index');
	}
}