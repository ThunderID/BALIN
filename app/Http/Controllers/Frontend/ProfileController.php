<?php namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\BaseController;

use Input, Redirect, Auth, Carbon, Validator, DB, App;

use App\Models\Transaction;
use App\Jobs\ChangeStatus;

class ProfileController extends BaseController 
{
	protected $controller_name 					= 'profile';

	public function index()
	{		
		$this->layout->page 					= view('pages.frontend.user.index')
													->with('controller_name', $this->controller_name)
													->with('subnav_active', 'account_index')
													->with('title', 'Dashboard Saya');

		$this->layout->controller_name			= $this->controller_name;

		$this->layout->page->page_title 		= 'BALIN.ID';
		$this->layout->page->page_subtitle 		= 'Dashboard';

		return $this->layout;
	}

	public function edit()
	{		
		$this->layout->page 					= view('pages.frontend.user.edit')
													->with('controller_name', $this->controller_name)
													->with('subnav_active', 'account_setting')
													->with('title', 'Ubah Pengaturan Akun');

		$this->layout->controller_name			= $this->controller_name;

		$this->layout->page->page_title 		= 'BALIN.ID';
		$this->layout->page->page_subtitle 		= 'Pengaturan Akun';

		return $this->layout;
	}

	public function update()
	{		
		$inputs 								= Input::only('name', 'email', 'date_of_birth', 'gender');
		
		$data									= Auth::user();

		$dob 									= Carbon::createFromFormat('d-m-Y', $inputs['date_of_birth'])->format('Y-m-d H:i:s');

		if(Input::has('password'))
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

		$data->fill([
				'name' 							=> $inputs['name'],
				// 'email'							=> $inputs['email'],
				'date_of_birth'					=> $dob,
				'gender'						=> $inputs['gender'],
		]);

		if(Input::has('password'))
		{
			$data->password 					= Input::get('password');
		}

		if (!$data->save())
		{
			DB::rollback();

			return Redirect::back()
					->withInput()
					->withErrors($data->getError())
					->with('msg-type', 'danger');
		}
		else
		{
			DB::commit();

			return Redirect::route('frontend.profile.edit')
				->with('msg','Pengaturan akun sudah disimpan')
				->with('msg-type', 'success');
		}
	}

	public function point()
	{		
		$this->layout->page 					= view('pages.frontend.user.point')
													->with('controller_name', $this->controller_name)
													->with('subnav_active', 'account_point')
													->with('title', 'Buku Tabungan');

		$this->layout->controller_name			= $this->controller_name;

		$this->layout->page->page_title 		= 'BALIN.ID';
		$this->layout->page->page_subtitle 		= 'Buku Tabungan';

		return $this->layout;
	}	

	public function downline()
	{		
		$this->layout->page 					= view('pages.frontend.user.downline')
													->with('controller_name', $this->controller_name)
													->with('subnav_active', 'account_downline')
													->with('title', 'Daftar Downline');

		$this->layout->controller_name			= $this->controller_name;

		$this->layout->page->page_title 		= 'BALIN.ID';
		$this->layout->page->page_subtitle 		= 'Daftar Downline';

		return $this->layout;
	}	

	public function orders()
	{		
		$this->layout->page 					= view('pages.frontend.user.order.index')
													->with('controller_name', $this->controller_name)
													->with('subnav_active', 'account_order')
													->with('title', 'Riwayat Pesanan');

		$this->layout->controller_name			= $this->controller_name;

		$this->layout->page->page_title 		= 'BALIN.ID';
		$this->layout->page->page_subtitle 		= 'Riwayat Pesanan';
		
		return $this->layout;
	}

	public function order($ref = null)
	{		
		$transaction 							= Transaction::userid(Auth::user()->id)->type('sell')->refnumber($ref)->first();
		
		if(!$transaction)
		{
			App::abort(404);
		}
		
		$this->layout->page 					= view('pages.frontend.user.order.show')
													->with('controller_name', $this->controller_name)
													->with('subnav_active', 'account_order')
													->with('title', 'Riwayat Pesanan #'.$ref)
													->with('transaction', $transaction);

		$this->layout->page->page_title 		= 'BALIN.ID';
		$this->layout->page->page_subtitle 		= 'Riwayat Pesanan';
		
		$this->layout->controller_name			= $this->controller_name;

		return $this->layout;
	}

	public function orderdestroy($ref = null)
	{		
		$transaction 							= Transaction::userid(Auth::user()->id)->type('sell')->refnumber($ref)->first();
		
		if(!$transaction)
		{
			App::abort(404);
		}
		
		$result                         		= $this->dispatch(new ChangeStatus($transaction, 'canceled'));

		if($result->getStatus()=='success')
		{
			return Redirect::route('frontend.profile.order.index')
							->with('msg','Pembatalan sudah disimpan')
							->with('msg-type', 'success');
		}

		return Redirect::route('frontend.profile.order.index')
							->withErrors($result->getErrorMessage())
							->with('msg-type', 'danger');
	}
}