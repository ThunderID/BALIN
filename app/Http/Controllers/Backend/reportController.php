<?php namespace App\Http\Controllers\Backend;

use App\Http\Controllers\baseController;
use App\Models\stock;

use Input, Session, DB, Redirect, Response;

class reportController extends baseController 
{
	protected $view_name 						= 'Report';

	public function index()
	{

	}

	public function criticalStock()
	{	
		$breadcrumb								= [
													'Laporan Stock Kritis' => 'backend.report.criticalstock',
													];

		if (Input::get('q'))
		{
			$searchResult						= Input::get('q');
		}
		else
		{
			$searchResult						= NULL;
		}

		$this->layout->page 					= view('pages.backend.report.criticalStock')
														->with('WT_pageTitle', $this->view_name )
														->with('WT_pageSubTitle','Stok Kritis')
														->with('WB_breadcrumbs', $breadcrumb)
														->with('searchResult', $searchResult)
														->with('nav_active', 'data')
														->with('subnav_active', 'customer');
		return $this->layout;	
	}
}