<?php namespace App\Http\Controllers\Backend\Report;

use App\Http\Controllers\baseController;
use Input, Session, DB, Redirect, Response, Carbon;
use Illuminate\Support\MessageBag;
use App\Models\StoreSetting;

class FinanceController extends baseController 
{
	/**
     * Instantiate a new UserController instance.
     */
    
    public function __construct()
    {
        $this->middleware('passwordneeded', ['only' => ['destroy']]);

    	parent::__construct();
    }

	protected $view_name 						= 'Laporan Finance';

	public function point()
	{		
		$breadcrumb								= 	[
														'Laporan Pemberian Point' 	=> route('backend.report.finance.point')
													];

		$filters 								= ['ondate' => ['first day of this month', 'last day of this month']];

		if(Input::has('q'))
		{
			$filters 							= ['ondate' => Input::get('q')];
		}

		$searchResult							= NULL;

		$this->layout->page 					= view('pages.backend.report.finance.point')
													->with('WT_pagetitle', $this->view_name )
													->with('WT_pageSubTitle','Point')
													->with('WB_breadcrumbs', $breadcrumb)
													->with('searchResult', $searchResult)
													->with('filters', $filters)
													->with('nav_active', 'finance')
													->with('subnav_active', 'point')
													;

		return $this->layout;		
	}

	public function transaction()
	{		
		$breadcrumb								= 	[
														'Laporan Transaksi Jual/Beli' 	=> route('backend.report.finance.transaction')
													];

		$filters 								= ['ondate' => ['first day of this month', 'last day of this month']];

		if(Input::has('q'))
		{
			$filters 							= ['ondate' => Input::get('q')];
		}

		$searchResult							= NULL;

		$this->layout->page 					= view('pages.backend.report.finance.transaction')
													->with('WT_pagetitle', $this->view_name )
													->with('WT_pageSubTitle','Transaksi')
													->with('WB_breadcrumbs', $breadcrumb)
													->with('searchResult', $searchResult)
													->with('filters', $filters)
													->with('nav_active', 'finance')
													->with('subnav_active', 'transaction')
													;

		return $this->layout;		
	}

	public function price()
	{		
		$breadcrumb								= 	[
														'Laporan HPP/HJ Product' 	=> route('backend.report.finance.price')
													];

		$filters 								= ['hpp' => ['first day of this month', 'last day of this month']];

		if(Input::has('q'))
		{
			$filters 							= ['hpp' => Input::get('q')];
		}

		$searchResult							= NULL;

		$this->layout->page 					= view('pages.backend.report.finance.price')
													->with('WT_pagetitle', $this->view_name )
													->with('WT_pageSubTitle','Transaksi')
													->with('WB_breadcrumbs', $breadcrumb)
													->with('searchResult', $searchResult)
													->with('filters', $filters)
													->with('nav_active', 'finance')
													->with('subnav_active', 'price')
													;

		return $this->layout;		
	}
}