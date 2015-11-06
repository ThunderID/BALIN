<?php namespace App\Http\Controllers\Backend\Report;

use App\Http\Controllers\baseController;
use Input, Session, DB, Redirect, Response, Carbon;
use Illuminate\Support\MessageBag;
use App\Models\StoreSetting;

class DownlineController extends baseController 
{
	/**
     * Instantiate a new UserController instance.
     */
    
    public function __construct()
    {
        $this->middleware('passwordneeded', ['only' => ['destroy']]);

    	parent::__construct();
    }

	protected $view_name 						= 'Laporan Downline Kostumer';

	public function index()
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
}