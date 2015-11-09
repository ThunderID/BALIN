<?php namespace App\Http\Controllers\Backend;

use App\Http\Controllers\BaseController;
use App\Models\User;
use Input, Session, DB, Redirect, Response, Auth;

class AuthController extends BaseController 
{
	protected $view_name 			= 'Login';

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

		return Redirect::route('backend.home');
	}
}