<?php 

namespace App\Http\Controllers\Backend\Setting;

use App\Http\Controllers\BaseController;
use App\Models\User;
use Input, Session, DB, Redirect, Response, App, Validator, Carbon, Auth;

class AuthenticationController extends BaseController
{
	/**
	* Instantiate a new UserController instance.
	*/
	public function __construct()
	{
		$this->middleware('passwordneeded', ['only' => ['destroy']]);

		parent::__construct();
	}

	protected $view_name 		= 'Otentikasi';
	
	public function index()
	{
		$breadcrumb				= 	[	
										'Pengaturan Otentikasi'	=> route('backend.settings.authentication.index')
									];

		$filters 				= ['role' => ['store_manager', 'admin', 'staff']];

		if(Input::has('q'))
		{
			$filters['name'] 	= Input::get('q');

			$searchResult		= Input::get('q');
		}
		else
		{
			$searchResult		= null;
		}

		$this->layout->page 	= view('pages.backend.settings.user.index')
									->with('WT_pagetitle', $this->view_name )
									->with('WT_pageSubTitle','Index')
									->with('WB_breadcrumbs', $breadcrumb)
									->with('searchResult', $searchResult)
									->with('filters', $filters)
									->with('nav_active', 'settings')
									->with('subnav_active', 'authentication');
		return $this->layout;
	}

	public function show($id)
	{
		$authentication 				= User::id($id)->first();

		if(!$authentication)
		{
			App::abort(404);
		}

		if(Auth::user()->role!='admin' && $authentication->role=='admin')
		{
			App::abort(404);
		}

		$breadcrumb				= 	[ 	
										'Pengaturan Otentikasi'	=> route('backend.settings.authentication.index'),
										$authentication->name 		=> route('backend.settings.authentication.show', $id),
									];

		switch(strtolower($authentication->role))
		{
			case 'store_manager';
				$view 			= 'store_manager';
			break; 
			case 'admin';
				$view 			= 'admin';
			break; 
			default;
				$view 			= 'staff';
			break; 
		}

		if(Input::has('q'))
		{
			$searchResult		= $search;
		}
		else
		{
			$searchResult		= NULL;
		}

		$this->layout->page 	= view('pages.backend.settings.user.'.$view.'.show')
									->with('WT_pagetitle', $this->view_name )
									->with('WT_pageSubTitle',$authentication->name)
									->with('WB_breadcrumbs', $breadcrumb)
									->with('searchResult', $searchResult)
									->with('authentication', $authentication)
									->with('id', $id)
									->with('nav_active', 'settings')
									->with('subnav_active', 'authentication')
		;

		return $this->layout;
	}

	public function create($id = null)
	{
		if (is_null($id))
		{
			$authentication 			= new User;

			$breadcrumb			= 	[ 	
											'Pengaturan Otentikasi'	=> route('backend.settings.authentication.index'),
											'Baru' 				=> route('backend.settings.authentication.create')
										];
										
			$title 				= 'Baru';
		}
		else
		{
			$authentication 			= User::authentication(true)->id($id)->first();

			if(!$authentication)
			{
				App::abort(404);
			}
			
			$title 				= $authentication->name;

			$breadcrumb			= 	[ 	
											'Pengaturan Otentikasi' 		=> route('backend.settings.authentication.index'),
											'Edit '.$authentication->name => route('backend.settings.authentication.edit', $id)
										];
		}
		
		$this->layout->page 	= view('pages.backend.settings.user.create')
										->with('WT_pagetitle', $this->view_name )
										->with('WT_pageSubTitle', $title)
										->with('WB_breadcrumbs', $breadcrumb)
										->with('id', $id)
										->with('authentication', $authentication)
										->with('nav_active', 'settings')
										->with('subnav_active', 'authentication');
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

			return Redirect::route('backend.settings.authentication.index')
				->with('msg','Otentikasi sudah tersimpan')
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

			return Redirect::route('backend.settings.authentication.index')
					->with('msg', 'Pengaturan '.$data->name.' telah dihapus')
					->with('msg-type','success');
		}
	}
}
