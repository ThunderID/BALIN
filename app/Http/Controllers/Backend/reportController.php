<?php namespace App\Http\Controllers\Backend;

use App\Http\Controllers\BaseController;
use App\Models\stock;

use Input, Session, DB, Redirect, Response;

class reportController extends BaseController 
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
														->with('WT_pagetitle', $this->view_name )
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
														->with('WT_pagetitle', $this->view_name )
														->with('WT_pageSubTitle','Transaksi Poin')
														->with('WB_breadcrumbs', $breadcrumb)
														->with('searchResult', $searchResult)
														->with('nav_active', 'storage')
														->with('start', Input::get('start_date'))
														->with('end', Input::get('end_date'))
														->with('subnav_active', 'pointlog');
		return $this->layout;	
	}

	public function TopSellingProduct()
	{	
		$breadcrumb								= [
													'Laporan Produk terlaris' => 'backend.report.topSellingProduct',
													];

		if (Input::get('start_date') && Input::get('end_date'))
		{
			$searchResult						= Input::get('start_date') . ' s/d ' . Input::get('end_date');
		}
		else
		{
			$searchResult						= NULL;
		}

		$this->layout->page 					= view('pages.backend.report.topSellingProduct')
														->with('WT_pagetitle', $this->view_name )
														->with('WT_pageSubTitle','Produk Terlaris')
														->with('WB_breadcrumbs', $breadcrumb)
														->with('searchResult', $searchResult)
														->with('nav_active', 'storage')
														->with('start', Input::get('start_date'))
														->with('end', Input::get('end_date'))
														->with('subnav_active', 'topSellingProduct');
		return $this->layout;	
	}	


	public function suppliedBy()
	{	
		$breadcrumb								= [
													'Suply Produk' => 'backend.report.suppliedby',
													];

		if (Input::get('start_date') && Input::get('end_date'))
		{
			$searchResult						= Input::get('start_date') . ' s/d ' . Input::get('end_date');
		}
		else
		{
			$searchResult						= NULL;
		}

		$this->layout->page 					= view('pages.backend.report.suppliedBy')
														->with('WT_pagetitle', $this->view_name )
														->with('WT_pageSubTitle','Suply Produk')
														->with('WB_breadcrumbs', $breadcrumb)
														->with('searchResult', $searchResult)
														->with('nav_active', 'storage')
														->with('subnav_active', 'suppliedby');
		return $this->layout;	
	}

	public function deadStock()
	{	
		$breadcrumb								= [
													'Stok Mengendap' => 'backend.report.deadstock',
													];

		$date 									= date("Y-m-d H:i:s",strtotime("-3 month"));;

		$this->layout->page 					= view('pages.backend.report.deadstock')
														->with('WT_pagetitle', $this->view_name )
														->with('WT_pageSubTitle','Stok Mengendap')
														->with('WB_breadcrumbs', $breadcrumb)
														->with('date', $date)
														->with('nav_active', 'storage')
														->with('subnav_active', 'deadstock');
		return $this->layout;	
	}		
}