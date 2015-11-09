<?php namespace App\Http\Controllers\Backend\Report;

use App\Http\Controllers\BaseController;
use Input, Session, DB, Redirect, Response, Carbon;
use Illuminate\Support\MessageBag;
use App\Models\StoreSetting;

class ProductController extends BaseController 
{
	/**
     * Instantiate a new UserController instance.
     */
    
    public function __construct()
    {
        $this->middleware('passwordneeded', ['only' => ['destroy']]);

    	parent::__construct();
    }

	protected $view_name 						= 'Laporan Market';

	public function mostbuy()
	{		
		$breadcrumb								= 	[
														'Laporan Produk Paling Banyak Dibeli' 	=> route('backend.report.product.mostbuy')
													];

		$filters 								= ['mostbuy' => ['first day of this month', 'last day of this month']];

		if(Input::has('q'))
		{
			$filters 							= ['mostbuy' => Input::get('q')];
		}

		$searchResult							= NULL;

		$this->layout->page 					= view('pages.backend.report.market.product')
													->with('WT_pagetitle', $this->view_name )
													->with('WT_pageSubTitle','Kostumer')
													->with('WB_breadcrumbs', $breadcrumb)
													->with('searchResult', $searchResult)
													->with('filters', $filters)
													->with('nav_active', 'market')
													->with('subnav_active', 'productmostbuy')
													;

		return $this->layout;		
	}

	public function frequentbuy()
	{		
		$breadcrumb								= 	[
														'Laporan Produk Paling Sering Dibeli' 	=> route('backend.report.product.frequentbuy')
													];

		$filters 								= ['frequentbuy' => ['first day of this month', 'last day of this month']];

		if(Input::has('q'))
		{
			$filters 							= ['frequentbuy' => Input::get('q')];
		}

		$searchResult							= NULL;

		$this->layout->page 					= view('pages.backend.report.market.product')
													->with('WT_pagetitle', $this->view_name )
													->with('WT_pageSubTitle','Kostumer')
													->with('WB_breadcrumbs', $breadcrumb)
													->with('searchResult', $searchResult)
													->with('filters', $filters)
													->with('nav_active', 'market')
													->with('subnav_active', 'productfrequentbuy')
													;

		return $this->layout;		
	}
}