<?php namespace App\Http\Controllers\Backend\Report;

use App\Http\Controllers\BaseController;
use Input, Session, DB, Redirect, Response, Carbon;
use Illuminate\Support\MessageBag;
use App\Models\StoreSetting;

class CriticalController extends BaseController 
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

		$setting               					= StoreSetting::ondate('now')->type('critical_stock')->first();

		$searchResult							= NULL;
		
		if(!$setting)
		{
			$critical 							= 0;
		}
		else
		{
			$critical 							= $setting->value;
		}

		$filters 								= ['critical' => $critical];

		if(Input::has('q'))
		{
			$filters['transactionlogchangedat'] = Input::get('q');
			$searchResult						= Input::get('q');
		}


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