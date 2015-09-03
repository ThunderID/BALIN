<?php namespace App\Http\Controllers\Backend;

use App\Http\Controllers\baseController;

class courierController extends baseController 
{
	protected $view_name 						= 'Kurir';

	public function index()
	{	
		$breadcrumb								= array(
													'Kurir' => 'backend.courier.index',
													 );	
		$this->layout->page 					= view('pages.backend.menu-shipping.courier.index')
													->with('WT_pageTitle', $this->view_name )
													->with('WT_pageSubTitle','Index')
													->with('WB_breadcrumbs', $breadcrumb)
													;

		return $this->layout;
	}
}