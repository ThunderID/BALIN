<?php 
namespace App\Http\Controllers\Backend\Data;

use App\Http\Controllers\baseController;
use App\Models\User;
use Input, Session, DB, Redirect, Response;

class CustomerController extends baseController
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
		$breadcrumb				= 	[	'Data Kostumer' 	=> route('backend.data.customer.index')
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
									->with('WT_pageTitle', $this->view_name )
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
		$customer 				= User::customer(true)->id($id)->first();

		if(!$customer)
		{
			App::abort(404);
		}

		$breadcrumb				= 	[ 	'Kostumer' 			=> route('backend.data.customer.index'),
										$customer->name 	=> route('backend.data.customer.show', $id),
									];

		if(Input::has('q'))
		{
			$searchResult			= $search;
		}
		else
		{
			$searchResult			= NULL;
		}

		$this->layout->page 		= view('pages.backend.data.user.show')
									->with('WT_pageTitle', $this->view_name )
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
			$customer 				= new User;

			$breadcrumb				= 	[ 	'Kostumer' 		=> route('backend.data.customer.index'),
											'Baru' 			=> route('backend.data.customer.create')
										];
										
			$title 					= 'Baru';
		}
		else
		{
			$customer 				= User::customer(true)->id($id)->first();

			if(!$customer)
			{
				App::abort(404);
			}
			
			$title 					= $customer->name;

			$breadcrumb				= 	[ 	'Kostumer' 				=> route('backend.data.customer.index'),
											'Edit '.$customer->name => route('backend.data.customer.edit', $id)
										];
		}
		
		$this->layout->page 		= view('pages.backend.data.user.create')
										->with('WT_pageTitle', $this->view_name )
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
		$inputs 					= Input::only('name', 'phone', 'address', 'email', 'postal_code');
		
		if(!is_null($id))
		{
			$data					= User::find($id);
		}
		else
		{
			$data					= new User;
		}

		$data->fill([
				'name' 				=> $inputs['name'],
				'phone' 			=> $inputs['phone'],
				'address' 			=> $inputs['address'],
				'email'				=> $inputs['email'],
				'postal_code'		=> $inputs['postal_code'],
				'role'				=>'customer',
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
		$data = User::findorfail($id);
		
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

	public function getCustomerByName()
	{
		$inputs 			= Input::only('name');
		$tmp 				= User::select(['id', 'name'])
								->name($inputs['name'])
								->get();
								
		return json_decode(json_encode($tmp));
	}
}
