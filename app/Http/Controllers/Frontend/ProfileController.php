<?php namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\BaseController;

use Input, Redirect, Auth, Carbon, Validator, DB;

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

		return $this->layout;
	}

	public function edit()
	{		
		$this->layout->page 					= view('pages.frontend.user.edit')
													->with('controller_name', $this->controller_name)
													->with('subnav_active', 'account_setting')
													->with('title', 'Ubah Pengaturan Akun');

		$this->layout->controller_name			= $this->controller_name;

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

	public function changePassword()
	{		
		$this->layout->page 					= view('pages.frontend.user.index')
													->with('controller_name', $this->controller_name)
													->with('sub_page', 'profile_change_password');

		$this->layout->controller_name			= $this->controller_name;

		return $this->layout;
	}	

	public function changeProfile()
	{		
		$this->layout->page 					= view('pages.frontend.user.index')
													->with('controller_name', $this->controller_name)
													->with('sub_page', 'profile_edit');

		$this->layout->controller_name			= $this->controller_name;

		return $this->layout;
	}	
}