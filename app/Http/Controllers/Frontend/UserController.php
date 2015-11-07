<?php namespace App\Http\Controllers\Frontend;

use Illuminate\Support\MessageBag;
use App\Http\Controllers\baseController;
use App\Models\User;
use App\Models\Address;
use Input, Carbon, Redirect, Validator, DB;
class UserController extends baseController 
{

	// protected $controller_name 					= 'join';

	public function index()
	{		
		$this->layout->page 							= view('pages.frontend.join')->with('controller_name', $this->controller_name);
		$this->layout->controller_name			= $this->controller_name;

		return $this->layout;
	}

	public function store($id = null)
	{
		$inputs 						= Input::only('name', 'email', 'date_of_birth', 'gender', 'address');
		
		if (!is_null($id))
		{
			$data						= User::find($id);
		}
		else
		{
			$data						= new User;
		}

		$dob 							= Carbon::createFromFormat('d-m-Y', $inputs['date_of_birth'])->format('Y-m-d H:i:s');

		if (Input::has('password') || is_null($id))
		{
			$validator 				= Validator::make(Input::only('password', 'password_confirmation'), ['password' => 'required|min:8|confirmed']);

			if (!$validator->passes())
			{
				return Redirect::back()
					->withInput()
					->withErrors($validator->errors())
					->with('msg-type', 'danger');
			}

		}
		DB::beginTransaction();

		$errors 						= new MessageBag();

		$data->fill([
				'name' 				=> $inputs['name'],
				'email'				=> $inputs['email'],
				'date_of_birth'		=> $dob,
				'role'				=> 'customer',
				'gender'			=> $inputs['gender'],
				'password'			=> Input::get('password'),
		]);

		if (!$data->save())
		{
			$errors->add('Customer', $data->getError());
		}

		$address					= new Address;

		$address->fill([			
			'address' 				=> $inputs['address'],
		]);

		$address->owner()->associate($data);
		
		if (!$address->save())
		{
			$errors->add('Address', $address->getError());
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

			return Redirect::route('frontend.profile.index')
								->with('msg', 'Kostumer sudah disimpan')
								->with('msg-type', 'success');
		}
	}
}