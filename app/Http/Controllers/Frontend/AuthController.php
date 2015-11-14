<?php namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\BaseController;
use App\Models\User;
use App\Models\Transaction;
use App\Jobs\CheckValidationLink;
use App\Jobs\SaveToCookie;
use App\Jobs\SaveToTransactionDetail;
use App\Jobs\SendResetPasswordEmail;
use Input, Session, DB, Redirect, Response, Auth, Socialite, App, Validator, Carbon, Cookie;
use App\Libraries\JSend;

class AuthController extends BaseController 
{
	protected $controller_name 			= 'Login';

	public function doLogin()
	{ 
		$email	 						= Input::get('email');
		$password 						= Input::get('password');
		
		$check 							= Auth::attempt(['email' => $email, 'password' => $password]);

		if ($check)
		{
			$redirect 					= Session::get('login_redirect');
			Session::forget('login_redirect');

            $transaction           	 	= Transaction::userid(Auth::user()->id)->status('cart')->wherehas('transactiondetails', function($q){$q;})->with(['transactiondetails', 'transactiondetails.varian', 'transactiondetails.varian.product'])->first();

            if($transaction)
            {
                $result             	= $this->dispatch(new SaveToCookie($transaction));

                if($result->getStatus()=='success' && !is_null($result->getData()))
                {
                	$baskets 			= $result->getData();

					return Redirect::intended($redirect)->withCookie(Cookie::make('baskets', $baskets, 1440));
                }
                else
                {
					return Redirect::back()->withErrors(['Tidak bisa login.']);
                }
            }

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
				'gender'				=> $user->user['gender'],
				'sso_id' 				=> $user->id,
				'sso_media' 			=> 'facebook',
				'sso_data' 				=> json_encode($user->user),
				'role' 					=> 'customer',
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

	public function activateAccount($activation_link)
	{
		$user 							= User::activationlink($activation_link)->first();

		if(!$user)
		{
			App::abort(404);
		}

		if($user->is_active)
		{
			return Redirect::back()->withErrors('Expired Link');
		}
		
		$result							= $this->dispatch(new CheckValidationLink($user));

		if ($result->getStatus()=='success')
		{
			$this->layout->page 					= view('pages.frontend.login.activation')
														->with('controller_name', $this->controller_name);

			$this->layout->controller_name			= $this->controller_name;

			return $this->layout;
		}

		return Redirect::route('frontend.home.index')->withErrors($result->getErrorMessage());
	}

	public function doForgot()
	{
		$email 							= Input::Get('email');
		$user 							= User::email($email)->first();

		if(!$user)
		{
			return Redirect::back()->withErrors('Email tidak terdaftar');
		}
		
		$result							= $this->dispatch(new SendResetPasswordEmail($user));

		if ($result->getStatus()=='success')
		{
			return Redirect::route('frontend.home.index')
				->with('msg','Permintaan reset password sudah dikirim')
				->with('msg-type', 'success');
		}

		return Redirect::route('frontend.home.index')->withErrors($result->getErrorMessage());
	}

	public function getForgot($link = null)
	{
		$user 								= User::resetpasswordlink($link)->first();

		if(!$user)
		{
			App::abort(404);
		}

		$dateexpired						= Carbon::now();

		if($user->expired_at->lt($dateexpired))
		{
			return Redirect::route('frontend.home.index')->withErrors('Link Expired');
		}

		$this->layout->page					= view('pages.frontend.login.reset')
												->with('controller_name', $this->controller_name)
												->with('email', $user->email);

		$this->layout->controller_name		= $this->controller_name;

		return $this->layout;
	}

	public function postForgot()
	{
		$email 								= Input::get('email');

		$user 								= User::email($email)->first();

		if(!$user)
		{
			App::abort(404);
		}

		if(Input::has('password'))
		{
			$validator 						= Validator::make(Input::only('password', 'password_confirmation'), ['password' => 'required|min:8|confirmed']);

			if (!$validator->passes())
			{
				return Redirect::back()
					->withInput()
					->withErrors($validator->errors())
					->with('msg-type', 'danger');
			}

		}

		DB::beginTransaction();

		$user->fill([
				'password'					=> Input::get('password'),
				'reset_password_link'		=> '',
				'expired_at' 				=> NULL,
		]);


		if (!$user->save())
		{
			DB::rollback();

			return Redirect::back()
					->withInput()
					->withErrors($user->getError())
					->with('msg-type', 'danger');
		}
		else
		{
			DB::commit();

			return Redirect::route('frontend.home.index')
				->with('msg','Password sudah berhasil diubah silahkan login dengan menggunakan password yang baru.')
				->with('msg-type', 'success');
		}
	}
}