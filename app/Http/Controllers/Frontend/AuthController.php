<?php namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\BaseController;
use App\Models\User;
use App\Models\Transaction;
use App\Jobs\CheckValidationLink;
use App\Jobs\SaveCampaign;
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

					if ($redirect=='frontend.get.checkout')
					{
						return Redirect::intended(route($redirect));
					}
					else
					{
						return Redirect::intended(route('frontend.redeem.index'));
					}

					Session::put('baskets', $baskets);
                }
                else
                {
					return Redirect::back()->withErrors(['Tidak bisa login.'])->with('msg-type', 'danger')->with('msg-from', 'login');
                }
            }
			return Redirect::intended(route('frontend.redeem.index'));


			// return Redirect::intended($redirect);
		}
		
		return Redirect::back()->withErrors(['Username dan password yang anda masukkan tidak cocok dengan data kami. Harap anda memeriksa data masukkan dan mencoba lagi.'])->with('msg-type', 'danger')->with('msg-from', 'login');
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
		if(Session::has('is_campaign'))
		{
			$is_active 					= true;
		}
		else
		{
			$is_active 					= false;
		}

		$user 							= Socialite::driver('facebook')->user();

		$registered 					= User::email($user->email)->first();

		if($registered)
		{
			// $registered->fill([
			// 	'sso_id' 				=> $user->id,
			// 	'sso_media' 			=> 'facebook',
			// 	'sso_data' 				=> json_encode($user->user),
			// 	]);

			if($registered->sso_id != $user->id)
			{
				return Redirect::back()->withErrors($registered->getError())
									->with('msg', 'Email sudah terdaftar')
									->with('msg-type', 'danger')
									->with('msg-from', 'login');
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
				'is_active'				=> $is_active,
				]);

			if(!$registered->save())
			{
				return Redirect::back()->withErrors($registered->getError())->with('msg-type', 'danger')->with('msg-from', 'login');
			}

			if($is_active)
			{
				$result                 				= $this->dispatch(new SaveCampaign($registered, 'promo_referral'));
				if($result->getStatus()!='success')
				{
					return Redirect::back()->withErrors($result->getErrorMessage())->with('msg-type', 'danger')->with('msg-from', 'login');
				}
			}
		}

		Auth::loginUsingId($registered->id);

		$redirect 					= Session::get('login_redirect');

		Session::forget('login_redirect');
		
        $transaction           	 	= Transaction::userid(Auth::user()->id)->status('cart')->wherehas('transactiondetails', function($q){$q;})->with(['transactiondetails', 'transactiondetails.varian', 'transactiondetails.varian.product'])->first();

        if($transaction)
        {
            $result             	= $this->dispatch(new SaveToCookie($transaction));

            if($result->getStatus()=='success' && !is_null($result->getData()))
            {
            	$baskets 			= $result->getData();

            	if ($redirect=='frontend.get.checkout')
            	{
            		return Redirect::intended(route($redirect));
            	}
            	else
            	{
            		return Redirect::intended(route('frontend.redeem.index'));
            	}

            	Session::put('baskets', $baskets);

				// return Redirect::intended(route($redirect));
            }
            else
            {
				return Redirect::back()->withErrors(['Tidak bisa login.'])->with('msg-type', 'danger')->with('msg-from', 'login');
            }
        }

		return Redirect::intended(route('frontend.redeem.index'))
							->with('msg', 'Terima kasih sudah mendaftar diwebsite kami.')
							->with('msg-type', 'success');
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
			return Redirect::back()->withErrors('Expired Link')->with('msg-type', 'danger');
		}
		
		$result							= $this->dispatch(new CheckValidationLink($user));

		if ($result->getStatus()=='success')
		{
			$this->layout->page 					= view('pages.frontend.login.activation')
														->with('controller_name', $this->controller_name)
														->with('amount', $result->getData()['amount'])
														;

			$this->layout->controller_name			= $this->controller_name;

			return $this->layout;
		}

		return Redirect::route('frontend.home.index')->withErrors($result->getErrorMessage())->with('msg-type', 'danger');
	}

	public function doForgot()
	{
		$email 							= Input::Get('email');
		$user 							= User::email($email)->first();

		if(!$user)
		{
			return Redirect::back()->withErrors('Email tidak terdaftar')->with('msg-type', 'danger');
		}
		
		$result							= $this->dispatch(new SendResetPasswordEmail($user));

		if ($result->getStatus()=='success')
		{
			return Redirect::route('frontend.home.index')
				->with('msg','Permintaan reset password sudah dikirim')
				->with('msg-type', 'success');
		}

		return Redirect::route('frontend.home.index')->withErrors($result->getErrorMessage())->with('msg-type', 'danger');
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
			return Redirect::route('frontend.home.index')->withErrors('Link Expired')->with('msg-type', 'danger');
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