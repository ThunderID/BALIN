<?php namespace App\Http\Controllers\Backend\Setting;

use App\Http\Controllers\baseController;
use Input, Session, DB, Redirect, Response;

class PolicyController extends baseController 
{
	protected $view_name 					= 'Store';

	public function index()
	{		
		$breadcrumb								= ['Setting Store' => 'backend.settings.policies.index'];
		$searchResult							= NULL;

		$this->layout->page 					= view('pages.backend.settings.policy.index')
													->with('WT_pageTitle', $this->view_name )
													->with('WT_pageSubTitle','Index')
													->with('WB_breadcrumbs', $breadcrumb)
													->with('searchResult', $searchResult)
													->with('nav_active', 'settings')
													->with('subnav_active', 'policy')
													;

		return $this->layout;		
	}

	public function show($id)
	{
		
	}


	public function create($id = null)
	{
		if ($id)
		{
			$breadcrumb							= ['Kategori' => 'backend.settings.store.index',
														'Edit Data' => 'backend.settings.store.create' ];
		}
		else
		{
			$breadcrumb							= ['Kategori' => 'backend.settings.store.index',
														'Data Baru' => 'backend.settings.store.create' ];
		}

		$this->layout->page 					= view('pages.backend.settings.store.create')
													->with('WT_pageTitle', $this->view_name )
													->with('WT_pageSubTitle','Index')
													->with('WB_breadcrumbs', $breadcrumb)
													->with('id', $id)
													->with('nav_active', 'settings')
													->with('subnav_active', 'store')
													;

		return $this->layout;
				
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