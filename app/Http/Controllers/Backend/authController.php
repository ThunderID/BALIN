<?php namespace App\Http\Controllers\Backend;

use App\Http\Controllers\baseController;
use Input, Session, DB, Redirect, Response;

class authController extends baseController 
{
	protected $view_name 						= 'Login';

	public function index()
	{		
		$this->layout->page 					= view('pages.backend.login.index');

		return $this->layout;		
	}

	public function show($id)
	{
		
	}


	public function create($id = null)
	{
		
	}

	public function edit($id)
	{

		return $this->create($id);
	}

	public function store($id = null)
	{
		
	}

	public function destroy($id)
	{

	}

}