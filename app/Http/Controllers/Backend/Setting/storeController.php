<?php namespace App\Http\Controllers\Backend\Setting;

use App\Http\Controllers\baseController;
use Input, Session, DB, Redirect, Response;

class storeController extends baseController 
{
	protected $view_name 					= 'Store';

	public function index()
	{		
		$breadcrumb								= ['Setting Store' => 'backend.settings.store.index'];
		$searchResult							= NULL;

		$this->layout->page 					= view('pages.backend.settings.store.index')
													->with('WT_pageTitle', $this->view_name )
													->with('WT_pageSubTitle','Index')
													->with('WB_breadcrumbs', $breadcrumb)
													->with('searchResult', $searchResult)
													->with('nav_active', 'product')
													->with('subnav_active', 'category')
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
													->with('nav_active', 'product')
													->with('subnav_active', 'category')
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