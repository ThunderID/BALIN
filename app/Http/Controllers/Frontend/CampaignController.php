<?php namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\BaseController;

use Input, Redirect, Auth, Carbon, Validator, DB, App;

use App\Models\User;
use App\Models\PointLog;

class CampaignController extends BaseController 
{
	protected $controller_name 					= 'profile';

	public function getreference()
	{
		if(!is_null(Auth::user()->reference))
		{
			return Redirect::route('frontend.profile.index');
		}

		$this->layout->page 					= view('pages.frontend.user.reference')
													->with('controller_name', $this->controller_name)
													->with('subnav_active', 'account_reference')
													->with('title', 'Referensi');

		$this->layout->controller_name			= $this->controller_name;

		$this->layout->page->page_title 		= 'BALIN.ID';
		$this->layout->page->page_subtitle 		= 'Referensi';

		return $this->layout;
	}

	public function postreference()
	{		
		$reference 								= User::referralcode(Input::get('referral_code'))->first();

		if(!$reference)
		{
			return Redirect::back()
					->withInput()
					->withErrors('Referral code tidak terdaftar')
					->with('msg-type', 'danger');
		}

		$expired_at 							=  new Carbon('+ 3 months');

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

		DB::commit();

			return Redirect::route('frontend.profile.index')
				->with('msg','Pemberi referensi sudah disimpan')
				->with('msg-type', 'success');
	}
}