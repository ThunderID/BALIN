<?php namespace App\Http\Controllers\Campaign;

use App\Http\Controllers\BaseController;

use Input, Redirect, Auth, Carbon, Validator, DB, App, Socialite, Session;
use Illuminate\Support\MessageBag;

use App\Models\User;
use App\Models\PointLog;
use App\Models\Voucher;
use App\Jobs\SaveCampaign;

class EarlySignUpController extends BaseController 
{
	protected $controller_name 					= 'join';

	public function getearlier()
	{	
		if(Auth::check())
		{
			return Redirect::route('campaign.promo.get');
		}

		$breadcrumb										= ['Early Sign Up' => route('campaign.early.get')];
		$this->layout->page 							= view('pages.campaign.softlaunch.index')
																->with('controller_name', $this->controller_name)
																->with('breadcrumb', $breadcrumb)
																;
		$this->layout->controller_name			= $this->controller_name;

		$this->layout->page->page_title 		= 'BALIN.ID';
		$this->layout->page->page_subtitle 		= 'Early Sign Up';

		return $this->layout;
	}

	public function postearlier($id = null)
	{
		if(Auth::check())
		{
			return Redirect::route('campaign.promo.get');
		}
		// if(!Input::has('term'))
		// {
			// return Redirect::back()->withInput()->withErrors('Anda harus menyetujui syarat dan ketentuan BALIN.ID.')->with('msg-type', 'danger');
		// }

		$inputs 								= Input::only('name', 'email');
		
		if (!is_null($id))
		{
			$data								= User::find($id);
		}
		else
		{
			$data								= new User;
		}
		
		// if(preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]))
		// {
		// 	$dob								= Carbon::createFromFormat('Y-m-d', $inputs['date_of_birth'])->format('Y-m-d H:i:s');
		// }
		// else
		// {
		// 	$dob								= Carbon::createFromFormat('d-m-Y', $inputs['date_of_birth'])->format('Y-m-d H:i:s');
		// }
		
		if (Input::has('password') || is_null($id))
		{
			$validator 							= Validator::make(Input::only('password', 'password_confirmation'), ['password' => 'required|min:8|confirmed']);

			if (!$validator->passes())
			{
				return Redirect::back()
					->withInput()
					->withErrors($validator->errors())
					->with('msg-type', 'danger');
			}
		}

		DB::beginTransaction();
		
		$errors 								= new MessageBag();
		
		$data->fill([
			'name' 								=> $inputs['name'],
			'email'								=> $inputs['email'],
			// 'date_of_birth'						=> $dob,
			'role'								=> 'customer',
			// 'gender'							=> $inputs['gender'],
			'password'							=> Input::get('password'),
			'is_active'							=> true,
		]);

		if (!$data->save())
		{
			$errors->add('Customer', $data->getError());
		}
		else
		{
			$result                 				= $this->dispatch(new SaveCampaign($data, 'promo_referral'));
			if($result->getStatus()!='success')
			{
				$errors->add('Customer', $result->getErrorMessage());
			}
		}


		if ($errors->count())
		{
			DB::rollback();

			return Redirect::back()
				->withInput()
				->withErrors($errors)
				->with('msg-type', 'danger');
		}
		else
		{
			DB::commit();

			Auth::loginusingid($data->id);

			return Redirect::route('campaign.promo.get')
								->with('msg', 'Selamat anda sudah terdaftar diwebsite balin')
								->with('msg-type', 'success');
		}
	}

	public function postearliersso()
	{
		Session::put('login_redirect', route('campaign.promo.get'));
		Session::put('is_campaign', true);

		return Socialite::driver('facebook')->redirect();
	}

	// public function postearliersso()
	// { 
	// 	$user 							= Socialite::driver('facebook')->user();

	// 	$registered 					= User::email($user->email)->first();

	// 	if($registered)
	// 	{
	// 		return Redirect::back()->withErrors('Anda sudah terdaftar.')->with('msg-type', 'danger');
	// 	}
	// 	else
	// 	{
	// 		$registered 				= new User;
	// 		$registered->fill([
	// 			'name'					=> $user->name,
	// 			'email'					=> $user->email,
	// 			'gender'				=> $user->user['gender'],
	// 			'sso_id' 				=> $user->id,
	// 			'sso_media' 			=> 'facebook',
	// 			'sso_data' 				=> json_encode($user->user),
	// 			'role' 					=> 'customer',
	// 			]);

	// 		if(!$registered->save())
	// 		{
	// 			return Redirect::back()->withErrors($registered->getError())->with('msg-type', 'danger');
	// 		}
	// 	}

	// 	Auth::loginUsingId($registered->id);

	// 	return Redirect::route('campaign.promo.get');
	// }

	public function getpromo()
	{	
		if(!Auth::check())
		{
			return Redirect::route('campaign.promo.get');
		}

		$breadcrumb										= ['Redeem Code' => route('campaign.join.get')];
		$this->layout->page 							= view('pages.campaign.softlaunch.show')
																->with('controller_name', $this->controller_name)
																->with('breadcrumb', $breadcrumb)
																;
		$this->layout->controller_name			= $this->controller_name;

		$this->layout->page->page_title 		= 'BALIN.ID';
		$this->layout->page->page_subtitle 		= 'Redeem Code';

		return $this->layout;
	}

	public function postpromo($id = null)
	{
		$voucher 								= Voucher::code(Input::get('voucher'))->type('promo_referral')->first();

		if(!$voucher || $voucher->user_id==0)
		{
			return Redirect::back()
					->withInput()
					->withErrors('Promo code tidak terdaftar.')
					->with('msg-type', 'danger');
		}

		if($voucher->quota - 1 < 0)
		{
			return Redirect::back()
					->withInput()
					->withErrors('Quota Promo sudah habis.')
					->with('msg-type', 'danger');
		}

		$expired_at 							=  new Carbon('+ 3 months');

		$errors 								= new MessageBag();
		$plog 									= new PointLog;

		$plog->fill([
				'user_id'						=> Auth::user()->id,
				'expired_at'					=> $expired_at->format('Y-m-d H:i:s'),
			]);

		$plog->reference()->associate($voucher);

		if(!$plog->save())
		{
			$errors->add('Customer', $plog->getError());
		}

		if ($errors->count())
		{
			DB::rollback();

			return Redirect::back()
				->withInput()
				->withErrors($errors)
				->with('msg-type', 'danger');
		}
		else
		{
			DB::commit();
			Auth::logout();
			return Redirect::route('campaign.early.get')
				->with('msg', 'Selamat!<br> Anda mendapat Balin Point senilai '.number_format($voucher['value'], 0, ',', '.').'. Dapat digunakan mulai Senin, 7 Desember 2015')
				->with('msg-type', 'success');
		}
	}
}