<?php namespace App\Http\Controllers\Backend;

use App\Http\Controllers\baseController;
use App\Models\User;
use Input, Session, DB, Redirect, Response, Auth;

class authController extends baseController 
{
	protected $view_name 			= 'Login';

	public function index()
	{		
		if (!Auth::User())
		{
			$this->layout->page 	= view('pages.backend.login.index');
		}
		else
		{
			$this->layout->page 	= view('pages.backend.settings.category.index');
		}

		return $this->layout;		
	}

	public function doLogin()
	{ 
		$email	 					= Input::get('email');
		$password 					= Input::get('password');
		$check 						= Auth::attempt(['email' => $email, 'password' => $password]);

		if ($check)
		{
			// Session::put('logged_user', $content->data->id);
			return Redirect::intended(route('backend.settings.category.index'));
		}
		
		return Redirect::back()->withErrors(['Username dan password yang anda masukkan tidak cocok dengan data kami. Harap anda memeriksa data masukkan dan mencoba lagi.']);
	}

	public function doLogout()
	{
		Session::flush();

		return Redirect::route('backend.login');
	}
}