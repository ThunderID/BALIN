<?php namespace App\Http\Controllers\Backend\Data;

use App\Http\Controllers\baseController;
use App\Models\User;
use Input, Session, DB, Redirect, Response;

class customerController extends baseController 
{
	protected $view_name 					= 'Customer';

	public function index()
	{		
		$breadcrumb								= ['Customer' => 'backend.data.customer.index'];

		if (Input::get('q'))
		{
			$searchResult						= Input::get('q');
		}
		else
		{
			$searchResult						= NULL;
		}

		$this->layout->page 					= view('pages.backend.data.user.index')
														->with('WT_pageTitle', $this->view_name )
														->with('WT_pageSubTitle','Index')
														->with('WB_breadcrumbs', $breadcrumb)
														->with('searchResult', $searchResult)
														->with('nav_active', 'data')
														->with('subnav_active', 'customer');
		return $this->layout;		
	}

	public function create($id = null)
	{
		if (!$id)
		{
			$breadcrumb							= ['Customer' => 'backend.data.customer.index',
														'Customer Baru' => 'backend.data.customer.create' ];
		}
		else
		{
			$breadcrumb							= ['Customer' => 'backend.data.customer.index',
														'Edit Data' => 'backend.data.customer.create' ];
		}

		$this->layout->page 					= view('pages.backend.data.user.create')
															->with('WT_pageTitle', $this->view_name )
															->with('WT_pageSubTitle','Create')		
															->with('WB_breadcrumbs', $breadcrumb)
															->with('id', $id)
															->with('nav_active', 'data')
															->with('subnav_active', 'customer');
		return $this->layout;		
	}

	public function edit($id)
	{

		return $this->create($id);
	}

	public function store($id = null)
	{
		$inputs 								= Input::only('id','name', 'phone', 'address', 'email', 'postal_code', 'role');
	
		if ($inputs['id'])
		{
			$data								= user::find($inputs['id']);
		}
		else
		{
			$data								= new user;
		}

		$data->fill([
			'name' 							=> $inputs['name'],
			'phone' 							=> $inputs['phone'],
			'address' 						=> $inputs['address'],
			'email'							=> $inputs['email'],
			'postal_code'					=> $inputs['postal_code'],
			'role'							=> $inputs['role'],
		]);

		DB::beginTransaction();
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

			if(Input::get('id'))
			{
				$msg = "Data sudah diperbarui";
			}
			else
			{
				$msg = "Data sudah ditambahkan";
			}

			return Redirect::route('backend.data.customer.index')
				->with('msg',$msg)
				->with('msg-type', 'success');
		}
	}

	public function destroy($id)
	{
		if (Input::get('password'))
		{		
			$data									= user::find($id);

			if (count($data) == 0)
			{
				App::abort(404);
			}

			DB::beginTransaction();

			if (!$data->delete())
			{
				DB::rollback();
				return Redirect::back()
					->withErrors($data->getError())
					->with('msg-type','danger');
			}
			else
			{
				DB::commit();
				return Redirect::route('backend.data.customer.index')
					->with('msg', 'Data telah dihapus')
					->with('msg-type','success');
			}
		}
		else
		{
			return Redirect::back()
					->withErrors('Password tidak valid')
					->with('msg-type', 'danger');
		}		
	}

}