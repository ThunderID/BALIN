<?php 

namespace App\Http\Controllers\Backend\Data;

use App\Http\Controllers\BaseController;
use App\Models\User;
use Input, Session, DB, Redirect, Response, App, Validator, Carbon;

class CustomerController extends BaseController
{
	/**
	* Instantiate a new UserController instance.
	*/
	public function __construct()
	{
		$this->middleware('passwordneeded', ['only' => ['destroy']]);

		parent::__construct();
	}

	protected $view_name = 'Kostumer';
	
	public function index()
	{
		$breadcrumb				= 	[	
										'Data Kostumer' 	=> route('backend.data.customer.index')
									];

		$filters 				= ['customer' => true];

		if(Input::has('q'))
		{
			$filters['name'] 	= Input::get('q');

			$searchResult		= Input::get('q');
		}
		else
		{
			$searchResult		= null;
		}

		$this->layout->page 	= view('pages.backend.data.user.index')
									->with('WT_pagetitle', $this->view_name )
									->with('WT_pageSubTitle','Index')
									->with('WB_breadcrumbs', $breadcrumb)
									->with('searchResult', $searchResult)
									->with('filters', $filters)
									->with('nav_active', 'data')
									->with('subnav_active', 'customer');
		return $this->layout;
	}

	public function show($id)
	{
		$customer 				= User::id($id)->first();

		if(!$customer)
		{
			App::abort(404);
		}

		$breadcrumb				= 	[ 	
										'Data Kostumer' 	=> route('backend.data.customer.index'),
										$customer->name 	=> route('backend.data.customer.show', $id),
									];

		if(Input::has('q'))
		{
			$searchResult		= $search;
		}
		else
		{
			$searchResult		= NULL;
		}

		$this->layout->page 	= view('pages.backend.data.user.show')
									->with('WT_pagetitle', $this->view_name )
									->with('WT_pageSubTitle',$customer->name)
									->with('WB_breadcrumbs', $breadcrumb)
									->with('searchResult', $searchResult)
									->with('customer', $customer)
									->with('id', $id)
									->with('nav_active', 'data')
									->with('subnav_active', 'customer')
		;

		return $this->layout;
	}

	public function create($id = null)
	{
		if (is_null($id))
		{
			$customer 			= new User;

			$breadcrumb			= 	[ 	
											'Data Kostumer' 	=> route('backend.data.customer.index'),
											'Baru' 				=> route('backend.data.customer.create')
										];
										
			$title 				= 'Baru';
		}
		else
		{
			$customer 			= User::customer(true)->id($id)->first();

			if(!$customer)
			{
				App::abort(404);
			}
			
			$title 				= $customer->name;

			$breadcrumb			= 	[ 	
											'Data Kostumer' 		=> route('backend.data.customer.index'),
											'Edit '.$customer->name => route('backend.data.customer.edit', $id)
										];
		}
		
		$this->layout->page 	= view('pages.backend.data.user.create')
										->with('WT_pagetitle', $this->view_name )
										->with('WT_pageSubTitle', $title)
										->with('WB_breadcrumbs', $breadcrumb)
										->with('id', $id)
										->with('customer', $customer)
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
		$inputs 				= Input::only('name', 'email', 'date_of_birth', 'role', 'gender');
		
		if(!is_null($id))
		{
			$data				= User::find($id);
		}
		else
		{
			$data				= new User;
		}

		$dob 					= Carbon::createFromFormat('d-m-Y', $inputs['date_of_birth'])->format('Y-m-d H:i:s');

		if(Input::has('password') || is_null($id))
		{
			$validator 			= Validator::make(Input::only('password', 'password_confirmation'), ['password' => 'required|min:8|confirmed']);

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
				'name' 			=> $inputs['name'],
				'email'			=> $inputs['email'],
				'date_of_birth'	=> $dob,
				'role'			=> $inputs['role'],
				'gender'		=> $inputs['gender'],
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

			return Redirect::route('backend.data.customer.index')
				->with('msg','Kostumer sudah tersimpan')
				->with('msg-type', 'success');
		}
	}

	public function Update($id)
	{
		return $this->store($id);
	}

	public function destroy($id)
	{
		$data 					= User::findorfail($id);
		
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
					->with('msg', 'Data '.$data->name.' telah dihapus')
					->with('msg-type','success');
		}
	}

	public function getCustomerByName()
	{
		$inputs 			= Input::only('name');
		$tmp 				= User::select(['id', 'name'])
								->name($inputs['name'])
								->get();
								
		return Response::make($tmp);
	}
}
