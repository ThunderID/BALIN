<?php namespace App\Http\Controllers\Backend\Report;

use App\Http\Controllers\BaseController;
use Input, Session, DB, Redirect, Response, Carbon;
use Illuminate\Support\MessageBag;
use App\Models\StoreSetting;

class CustomerController extends BaseController 
{
	/**
     * Instantiate a new UserController instance.
     */
    
    public function __construct()
    {
        $this->middleware('passwordneeded', ['only' => ['destroy']]);

    	parent::__construct();
    }

	protected $view_name 						= 'Laporan Pasar';

	public function downline()
	{		
		$breadcrumb								= 	[
														'Laporan Downline Kostumer' 	=> route('backend.report.customer.downline')
													];

		$filters 								= ['downline' => ['first day of this month', 'last day of this month']];

		if(Input::has('q'))
		{
			$filters 							= ['downline' => Input::get('q')];
		}

		$searchResult							= NULL;

		$this->layout->page 					= view('pages.backend.report.market.downline')
													->with('WT_pagetitle', $this->view_name )
													->with('WT_pageSubTitle','Kostumer')
													->with('WB_breadcrumbs', $breadcrumb)
													->with('searchResult', $searchResult)
													->with('filters', $filters)
													->with('nav_active', 'market')
													->with('subnav_active', 'downline')
													;

		return $this->layout;		
	}

	public function mostbuy()
	{		
		$breadcrumb								= 	[
														'Laporan Kostumer Paling Banyak Belanja' 	=> route('backend.report.customer.mostbuy')
													];

		$filters 								= ['mostbuy' => ['first day of this month', 'last day of this month']];

		if(Input::has('q'))
		{
			$filters 							= ['mostbuy' => Input::get('q')];
		}

		$searchResult							= NULL;

		$this->layout->page 					= view('pages.backend.report.market.customer')
													->with('WT_pagetitle', $this->view_name )
													->with('WT_pageSubTitle','Kostumer')
													->with('WB_breadcrumbs', $breadcrumb)
													->with('searchResult', $searchResult)
													->with('filters', $filters)
													->with('nav_active', 'market')
													->with('subnav_active', 'customermostbuy')
													;

		return $this->layout;		
	}

	public function frequentbuy()
	{		
		$breadcrumb								= 	[
														'Laporan Kostumer Paling Sering Belanja' 	=> route('backend.report.customer.frequentbuy')
													];

		$filters 								= ['frequentbuy' => ['first day of this month', 'last day of this month']];

		if(Input::has('q'))
		{
			$filters 							= ['frequentbuy' => Input::get('q')];
		}

		$searchResult							= NULL;

		$this->layout->page 					= view('pages.backend.report.market.customer')
													->with('WT_pagetitle', $this->view_name )
													->with('WT_pageSubTitle','Kostumer')
													->with('WB_breadcrumbs', $breadcrumb)
													->with('searchResult', $searchResult)
													->with('filters', $filters)
													->with('nav_active', 'market')
													->with('subnav_active', 'customerfrequentbuy')
													;

		return $this->layout;		
	}

	public function balance()
	{		
		$breadcrumb								= 	[
														'Laporan Balance Kostumer' 	=> route('backend.report.customer.balance')
													];

		$filters 								= ['balance' => 'today'];

		if(Input::has('q'))
		{
			$filters 							= ['balance' => Input::get('q')];
		}

		$searchResult							= NULL;

		$this->layout->page 					= view('pages.backend.report.market.balance')
													->with('WT_pagetitle', $this->view_name )
													->with('WT_pageSubTitle','Kostumer')
													->with('WB_breadcrumbs', $breadcrumb)
													->with('searchResult', $searchResult)
													->with('filters', $filters)
													->with('nav_active', 'market')
													->with('subnav_active', 'balance')
													;

		return $this->layout;		
	}

}