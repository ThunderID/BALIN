<?php namespace App\Http\Controllers\Backend\Data;
use App\Http\Controllers\baseController;

use App\Models\User;

use Input, Session, DB, Redirect;

class userController extends baseController 
{
	protected $view_name 						= 'User';

	public function index()
	{	
		$breadcrumb								= array(
													'User' => 'backend.user.index',
													);

		if(Input::get('q'))
		{
			$datas								= user::where('name','like', '%'.Input::get('q').'%')
													->paginate();
			$searchResult						= "Menampilkan data pencarian '" .Input::get('q')."'";
		}
		else
		{
			$datas								= user::paginate()
													;

			$searchResult						= NUll;

		}


		$this->layout->page 					= view('pages.backend.data.user.index')
													->with('WT_pageTitle', $this->view_name )
													->with('WT_pageSubTitle','Index')
													->with('WB_breadcrumbs', $breadcrumb)
													->with('datas', $datas)
													->with('searchResult', $searchResult)
													->with('nav_active', 'user')
													;


		return $this->layout;
	}

	public function edit($id)
	{
		return $this->create($id);		
	}

	public function create($id = null)
	{
		if ($id) 
		{
			$breadcrumb									= ['User' => 'backend.user.index',
																'Edit Data' => 'backend.user.create'];

			$title 										= 'Edit';
		}
		else
		{
			$breadcrumb									= ['User' => 'backend.user.index',
																'Data Baru' => 'backend.user.create'];

			$title 										= 'Create';
		}

		$this->layout->page 							= view('pages.backend.data.user.create')
																->with('WT_pageTitle', $this->view_name )
																->with('WT_pageSubTitle', $title)		
																->with('WB_breadcrumbs', $breadcrumb)
																->with('id', $id)
																->with('nav_active', 'user')
																;

		return $this->layout;		
	}	


	public function store()
	{
		$inputs 							= input::only('id','name','email','password','role','is_active','gender','date_of_birth','address','phone','postal_code');
	
		if($inputs['id'])
		{
			$data 							= user::find($inputs['id']);
		}
		else
		{
			$data 							= new user;
		}

		// if($inputs['password'])
		// {
		// 	$inputs['password']				= 'abcd';
		// }

		if(empty($inputs['is_active']))
		{
			$inputs['is_active']			= FALSE;
		}


		$data->fill([
			'name'							=> $inputs['name'],
			'email'							=> $inputs['email'],
			// 'password'						=> $inputs['password'],
			'role'							=> $inputs['role'],
			'is_active'						=> $inputs['is_active'],
			'gender'						=> $inputs['gender'],
			'date_of_birth'					=> $inputs['date_of_birth'],
			'address'						=> $inputs['address'],
			'phone'							=> $inputs['phone'],
			'postal_code'					=> $inputs['postal_code'],
		]);

		DB::beginTransaction();
		if (!$data->save())
		{
			DB::rollback();
			// return Redirect::back()
			// 	->withInput()
			// 	->withErrors($data->getError())
			// 	->with('msg-type', 'danger');
			dd('error');
		}	
		else
		{
			DB::commit();
			// return Redirect::route('backend.price.index')
			// 	->with('msg','Data sudah ditambahkan')
			// 	->with('msg-type', 'success');
			dd('saved');
		}
	}

	public function destroy()
	{		
	}
}