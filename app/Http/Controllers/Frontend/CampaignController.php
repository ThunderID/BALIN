<?php namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\BaseController;

use Input, Redirect, Auth, Carbon, Validator, DB, App;

use App\Models\User;
use App\Models\PointLog;
use App\Models\StoreSetting;
use App\Models\Voucher;

class CampaignController extends BaseController 
{
	protected $controller_name 					= 'profile';

	public function getreference()
	{
		$breadcrumb								= ['Referensi' => route('frontend.user.reference.get')];

		if(!is_null(Auth::user()->reference))
		{
			return Redirect::route('frontend.profile.index');
		}
		$breadcrumb								= ['Profile' => route('frontend.user.index')];

		return view('pages.frontend.user.reference')
													->with('controller_name', $this->controller_name)
													->with('subnav_active', 'account_reference')
													->with('title', 'Referensi')
													->with('breadcrumb', $breadcrumb);
	}

	public function postreference()
	{		
		$voucher 								= Voucher::code(Input::get('referral_code'))->type(['referral', 'promo_referral'])->first();

		if (is_null(Input::get('from')))
		{
			$from 								= 'frontend.user.index';
			$msg 								= 'Pemberi referensi sudah disimpan';
		}
		else 
		{
			$from 								= Input::get('from');
			$msg 								= 'Selamat anda mendapatkan Balin Point senilai IDR '.number_format($voucher['value'], 0, ',', '.');
		}

		if(!$voucher || $voucher->user_id==0)
		{
			return Redirect::back()
					->withInput()
					->withErrors('Referral code tidak terdaftar.')
					->with('msg-type', 'danger');
		}

		if($voucher->quota < 1)
		{
			return Redirect::back()
					->withInput()
					->withErrors('Quota referral sudah habis.')
					->with('msg-type', 'danger');
		}

		if($voucher->type=='promo_referral')
		{
			$reference 							= $voucher;
		}
		else
		{
			$reference 							= $voucher->user;
		}
		
		$store                    		= StoreSetting::type('voucher_point_expired')->Ondate('now')->first();

    	if($store)
    	{
        	$expired_at 				= new Carbon($store->value);
    	}
    	else
    	{
        	$expired_at 				= new Carbon('+ 3 months');
    	}

		DB::beginTransaction();

		$plog 									= new PointLog;

		$plog->fill([
				'user_id'						=> Auth::user()->id,
				'expired_at'					=> $expired_at->format('Y-m-d H:i:s'),
			]);

		$plog->reference()->associate($reference);

		if(!$plog->save())
		{
			DB::rollback();

			return Redirect::back()
					->withInput()
					->withErrors($plog->getError())
					->with('msg-type', 'danger');
		}
		else
		{
			$msg 								= 'Selamat anda mendapatkan Balin Point senilai IDR '.number_format($plog->amount, 0, ',', '.');
		}

		DB::commit();
			return Redirect::route($from)
				->with('msg', $msg)
				->with('msg-type', 'success');
	}
}