<?php namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\baseController;
use App\Models\User;
use Input, Session, DB, Redirect, Response, Auth, Socialite;

class AuthController extends baseController 
{
	// protected $view_name 			= 'Login';

	public function doLogin()
	{ 
		$email	 						= Input::get('email');
		$password 						= Input::get('password');
		
		$check 							= Auth::attempt(['email' => $email, 'password' => $password]);

		if ($check)
		{
			$redirect 					= Session::get('login_redirect');
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

	public function doSso()
	{ 
		return Socialite::driver('facebook')->redirect();
	}

	public function getSso()
	{ 
		$user 							= Socialite::driver('facebook')->user();

		$registered 					= User::email($user->email)->first();

		if($registered)
		{
			$registered->fill([
				'sso_id' 				=> $user->id,
				'sso_media' 			=> 'facebook',
				'sso_data' 				=> json_encode($user->user),
				]);

			if(!$registered->save())
			{
				return Redirect::back()->withErrors($registered->getError());
			}
		}
		else
		{
			$registered 				= new User;
			$registered->fill([
				'name'					=> $user->name,
				'email'					=> $user->email,
				'gender'				=> $user->user->gender,
				'sso_id' 				=> $user->id,
				'sso_media' 			=> 'facebook',
				'sso_data' 				=> json_encode($user->user),
				]);

			if(!$registered->save())
			{
				return Redirect::back()->withErrors($registered->getError());
			}
		}

		Auth::loginUsingId($registered->id);

		$redirect 						= Session::get('login_redirect');

		Session::forget('login_redirect');

		return Redirect::intended($redirect);
	}
}