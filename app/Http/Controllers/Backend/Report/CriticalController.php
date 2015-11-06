<?php namespace App\Http\Controllers\Backend\Report;

use App\Http\Controllers\baseController;
use Input, Session, DB, Redirect, Response, Carbon;
use Illuminate\Support\MessageBag;
use App\Models\StoreSetting;

class CriticalController extends baseController 
{
	/**
     * Instantiate a new UserController instance.
     */
    
    public function __construct()
    {
        $this->middleware('passwordneeded', ['only' => ['destroy']]);

    	parent::__construct();
    }

	protected $view_name 						= 'Laporan Stok Kritis';

	public function index()
	{		
		$breadcrumb								= 	[
														'Laporan Gudang Stok Kritis' 	=> route('backend.report.critical.stock')
													];

		$filters 								= ['critical' => ['first day of this month', 'last day of this month']];

		if(Input::has('q'))
		{
			$filters 							= ['critical' => Input::get('q')];
		}

		$searchResult							= NULL;

		$this->layout->page 					= view('pages.backend.report.inventory.stock')
													->with('WT_pagetitle', $this->view_name )
													->with('WT_pageSubTitle','Gudang')
													->with('WB_breadcrumbs', $breadcrumb)
													->with('searchResult', $searchResult)
													->with('filters', $filters)
													->with('nav_active', 'storage')
													->with('subnav_active', 'critical')
													;

		return $this->layout;		
	}
}