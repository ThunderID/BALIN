<?php namespace App\Http\Controllers\Backend\Setting;

use App\Http\Controllers\baseController;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\Supplier;
use Input, Session, DB, Redirect, Response;

class courierController extends baseController 
{
	protected $view_name 							= 'Courier';

	public function index()
	{		
		$breadcrumb										= ['Kurir' => 'backend.settings.courier.index'];


		$this->layout->page 							= view('pages.backend.settings.courier.index')
																	->with('WT_pageTitle', $this->view_name )
																	->with('WT_pageSubTitle','Index')
																	->with('WB_breadcrumbs', $breadcrumb)
																	->with('nav_active', 'supplier');
		return $this->layout;		
	}

	public function show($id)
	{
		
	}


	public function create($id = null)
	{
		if (!$id)
		{
			$breadcrumb									= ['Kurir' => 'backend.settings.courier.index',
																'Kurir Baru' => 'backend.settings.courier.create'];
		}
		else
		{
			$breadcrumb									= ['Kurir' => 'backend.settings.courier.index',
																'Edit Data' => 'backend.settings.courier.create'];
		}

		$this->layout->page 							= view('pages.backend.settings.courier.create')
																	->with('WT_pageTitle', $this->view_name )
																	->with('WT_pageSubTitle','Create')		
																	->with('WB_breadcrumbs', $breadcrumb)
																	->with('id', $id)
																	->with('nav_active', 'supplier');
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