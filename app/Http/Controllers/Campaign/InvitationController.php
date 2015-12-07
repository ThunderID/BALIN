<?php namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\BaseController;

use Input, Redirect, Auth, Carbon, Validator, DB, App;
use Illuminate\Support\MessageBag;

use App\Models\User;
use App\Models\PointLog;
use App\Models\StoreSetting;

class InvitationController extends BaseController 
{
	protected $controller_name 					= 'join';

	public function getinvitation()
	{	
		if(Auth::check())
		{
			return Redirect::route('frontend.user.index');
		}

		$breadcrumb										= ['Sign In By Invitation' => route('frontend.join.get')];
		$this->layout->page 							= view('pages.frontend.login.invitation')
																->with('controller_name', $this->controller_name)
																->with('breadcrumb', $breadcrumb)
																;
		$this->layout->controller_name			= $this->controller_name;

		$this->layout->page->page_title 		= 'BALIN.ID';
		$this->layout->page->page_subtitle 		= 'Sign In By Invitation';

		return $this->layout;
	}

	public function postinvitation($id = null)
	{
		if(Auth::check())
		{
			return Redirect::route('frontend.user.index');
		}
		
		$inputs 								= Input::only('name', 'email', 'date_of_birth', 'gender', 'voucher');
		
		if (!is_null($id))
		{
			$data								= User::find($id);
		}
		else
		{
			$data								= new User;
		}

		$voucher 								= Voucher::code(Input::get('voucher'))->type('promo_referral')->first();

		if(!$voucher || $voucher->user_id==0)
		{
			return Redirect::back()
					->withInput()
					->withErrors('Promo Referral code tidak terdaftar.')
					->with('msg-type', 'danger');
		}

		if($voucher->quota - 1 < 0)
		{
			return Redirect::back()
					->withInput()
					->withErrors('Quota referral sudah habis.')
					->with('msg-type', 'danger');
		}
		
		if(preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]))
		{
			$dob								= Carbon::createFromFormat('Y-m-d', $inputs['date_of_birth'])->format('Y-m-d H:i:s');
		}
		else
		{
			$dob								= Carbon::createFromFormat('d-m-Y', $inputs['date_of_birth'])->format('Y-m-d H:i:s');
		}
		
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
			'date_of_birth'						=> $dob,
			'role'								=> 'customer',
			'gender'							=> $inputs['gender'],
			'password'							=> Input::get('password'),
		]);

		$data->is_invited 						= true;

		if (!$data->save())
		{
			$errors->add('Customer', $data->getError());
		}

		if(!$errors->count())
		{
			$store                    		= StoreSetting::type('voucher_point_expired')->Ondate('now')->first();

	    	if($store)
	    	{
	        	$expired_at 				= new Carbon($store->value);
	    	}
	    	else
	    	{
	        	$expired_at 				= new Carbon('+ 3 months');
	    	}

			$plog 									= new PointLog;

			$plog->fill([
					'user_id'						=> $data->id,
					'expired_at'					=> $expired_at->format('Y-m-d H:i:s'),
				]);

			$plog->reference()->associate($voucher);

			if(!$plog->save())
			{
				$errors->add('Customer', $plog->getError());
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
			return Redirect::route('frontend.user.index')
				->with('msg', 'Data sudah disimpan')
				->with('msg-type', 'success');
		}
	}
}