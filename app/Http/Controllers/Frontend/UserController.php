<?php namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\BaseController;

use Input, Redirect, Auth, Carbon, Validator, DB, App;
use Illuminate\Support\MessageBag;

use App\Models\Transaction;
use App\Models\User;
use App\Models\Address;
use App\Jobs\ChangeStatus;

class UserController extends BaseController 
{
	protected $controller_name 					= 'user';

	public function index()
	{		
		$breadcrumb								= ['Profile' => route('frontend.user.index')];

		$this->layout->page 					= view('pages.frontend.user.index')
													->with('controller_name', $this->controller_name)
													->with('subnav_active', 'account_index')
													->with('title', 'Dashboard Saya')
													->with('breadcrumb', $breadcrumb);

		$this->layout->controller_name			= $this->controller_name;

		$this->layout->page->page_title 		= 'BALIN.ID';
		$this->layout->page->page_subtitle 		= 'Profile';

		return $this->layout;
	}

	public function store($id = null)
	{
		$inputs 								= Input::only('name', 'email', 'date_of_birth', 'gender', 'address');
		
		if (!is_null($id))
		{
			$data								= User::find($id);
		}
		else
		{
			$data								= new User;
		}
		
		$dob 									= Carbon::createFromFormat('d-m-Y', $inputs['date_of_birth'])->format('Y-m-d H:i:s');
		
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

		if (!$data->save())
		{
			$errors->add('Customer', $data->getError());
		}

		if(!$errors->count())
		{
			$address							= new Address;
			$address->fill([
				'address' 						=> $inputs['address'],
			]);

			$address->owner()->associate($data);
			
			if (!$address->save())
			{
				$errors->add('Address', $address->getError());
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

	public function edit()
	{		
		$breadcrumb								= ['Ubah Profile' => route('frontend.user.edit')];

		return  view('pages.frontend.user.edit')
													->with('controller_name', $this->controller_name)
													->with('subnav_active', 'account_setting')
													->with('title', 'Ubah Pengaturan Akun')
													->with('breadcrumb', $breadcrumb);

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

			return Redirect::route('frontend.user.edit')
				->with('msg','Pengaturan akun sudah disimpan')
				->with('msg-type', 'success');
		}
	}

	public function point()
	{		
		$breadcrumb								= ['Ubah Profile' => route('frontend.user.edit')];
		return  view('pages.frontend.user.point')
													->with('controller_name', $this->controller_name)
													->with('subnav_active', 'account_point')
													->with('title', 'Buku Tabungan')
													->with('breadcrumb', $breadcrumb);
	}	

	public function downline()
	{	
		$breadcrumb								= ['Ubah Profile' => route('frontend.user.edit')];
		return view('pages.frontend.user.downline')
													->with('controller_name', $this->controller_name)
													->with('subnav_active', 'account_downline')
													->with('title', 'Daftar Downline')
													->with('breadcrumb', $breadcrumb);

	}	

	public function orders()
	{		
		$breadcrumb								= ['Ubah Profile' => route('frontend.user.edit')];
		$this->layout->page 					= view('pages.frontend.user.order.index')
													->with('controller_name', $this->controller_name)
													->with('subnav_active', 'account_order')
													->with('title', 'Riwayat Pesanan')
													->with('breadcrumb', $breadcrumb);

		$this->layout->controller_name			= $this->controller_name;

		$this->layout->page->page_title 		= 'BALIN.ID';
		$this->layout->page->page_subtitle 		= 'Riwayat Pesanan';
		
		return $this->layout;
	}

	public function order($ref = null)
	{		
		$breadcrumb								= ['Ubah Profile' => route('frontend.user.edit')];
		$transaction 							= Transaction::userid(Auth::user()->id)->type('sell')->refnumber($ref)->first();
		
		if(!$transaction)
		{
			App::abort(404);
		}
		
		$this->layout->page 					= view('pages.frontend.user.order.show')
													->with('controller_name', $this->controller_name)
													->with('subnav_active', 'account_order')
													->with('title', 'Riwayat Pesanan #'.$ref)
													->with('transaction', $transaction)
													->with('breadcrumb', $breadcrumb);

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
			return Redirect::route('frontend.user.order.index')
							->with('msg','Pembatalan sudah disimpan')
							->with('msg-type', 'success');
		}

		return Redirect::route('frontend.user.order.index')
							->withErrors($result->getErrorMessage())
							->with('msg-type', 'danger');
	}
	public function changePassword()
	{		
		$breadcrumb								= ['Ubah Password' => route('frontend.user.edit')];

		return view('pages.frontend.user.change_password')
													->with('controller_name', $this->controller_name)
													->with('subnav_active', 'account_setting')
													->with('title', 'Ubah Password')
													->with('breadcrumb', $breadcrumb);
	}
}