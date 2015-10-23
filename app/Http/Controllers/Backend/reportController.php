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
														->with('nav_active', 'storage')
														->with('subnav_active', 'criticalstock');
		return $this->layout;	
	}

	public function pointLog()
	{	
		$breadcrumb								= [
													'Laporan Transaksi Poin' => 'backend.report.pointlog',
													];

		if (Input::get('start_date') && Input::get('end_date'))
		{
			$searchResult						= Input::get('start_date') . ' s/d ' . Input::get('end_date');
		}
		else
		{
			$searchResult						= NULL;
		}

		$this->layout->page 					= view('pages.backend.report.pointlog')
														->with('WT_pageTitle', $this->view_name )
														->with('WT_pageSubTitle','Transaksi Poin')
														->with('WB_breadcrumbs', $breadcrumb)
														->with('searchResult', $searchResult)
														->with('nav_active', 'storage')
														->with('start', Input::get('start_date'))
														->with('end', Input::get('end_date'))
														->with('subnav_active', 'pointlog');
		return $this->layout;	
	}	
}