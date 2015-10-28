<?php namespace App\Http\Controllers\Backend;

use App\Http\Controllers\baseController;
use App\Models\User;
use Input, Session, DB, Redirect, Response, Auth, Validator;

class PasswordController extends baseController 
{
	/**
     * Instantiate a new UserController instance.
     */
    
    public function __construct()
    {
        $this->middleware('passwordneeded', ['only' => ['store']]);

    	parent::__construct();
    }

	protected $view_name 			= 'Password';

	public function create()
	{ 
		$breadcrumb					= ['Ganti Password' => 'backend.changePassword'];

		$this->layout->page 		= view('pages.backend.password.create')
										->with('WT_pagetitle', $this->view_name )
										->with('WT_pageSubTitle','Index')
										->with('WB_breadcrumbs', $breadcrumb)
										->with('nav_active', null)
										->with('subnav_active', null);

		return $this->layout;
	}

	public function store($id = null)
	{
		$input 						= Input::all();
		$rules 						= ['new_password' => 'required|min:8|confirmed'];

		$validator 					= Validator::make($input, $rules);

		if (!$validator->passes())
		{
			return Redirect::back()->withError($validator->errors())->with('msg-type', 'danger');
		}

		$user 						= Auth::user();

		$user->fill(['password' => $input['new_password']]);

		if($user->save())
		{
			return Redirect::route('backend.home')->with('msg', 'Password Baru sudah disimpan')->with('msg-type', 'success');
		}

		return Redirect::back()->withError($user->getError())->with('msg-type', 'danger');
	}
}