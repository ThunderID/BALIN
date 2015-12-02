<?php namespace App\Http\Controllers\Backend\Report;

use App\Http\Controllers\BaseController;
use Input, Session, DB, Redirect, Response, Carbon;
use Illuminate\Support\MessageBag;
use App\Models\StoreSetting;

class WarehouseController extends BaseController 
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

	public function critical()
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
			$critical 							= 0 - $setting->value;
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

	public function stock()
	{		
		$breadcrumb								= 	[
														'Laporan Stok Gudang' 	=> route('backend.report.global.stock')
													];


		$searchResult							= NULL;


		$filters 								= ['globalstock' => true];

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
													->with('subnav_active', 'global')
													;

		return $this->layout;		
	}

	public function movement()
	{		
		$breadcrumb								= 	[
														'Laporan Perpindahan Stok' 	=> route('backend.report.movement.stock')
													];


		$searchResult							= NULL;


		$filters 								= ['stockmovement' => true];

		if(Input::has('q'))
		{
			$filters['transactionlogchangedat'] = Input::get('q');
			$searchResult						= Input::get('q');
		}


		$this->layout->page 					= view('pages.backend.report.inventory.movement')
													->with('WT_pagetitle', $this->view_name )
													->with('WT_pageSubTitle','Gudang')
													->with('WB_breadcrumbs', $breadcrumb)
													->with('searchResult', $searchResult)
													->with('filters', $filters)
													->with('nav_active', 'storage')
													->with('subnav_active', 'movement')
													;

		return $this->layout;		
	}
}