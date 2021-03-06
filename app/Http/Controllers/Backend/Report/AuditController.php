<?php namespace App\Http\Controllers\Backend\Report;

use App\Http\Controllers\BaseController;
use Input, Session, DB, Redirect, Response, Carbon;
use Illuminate\Support\MessageBag;
use App\Models\StoreSetting;

class AuditController extends BaseController 
{
	/**
     * Instantiate a new UserController instance.
     */
    
    public function __construct()
    {
        $this->middleware('passwordneeded', ['only' => ['destroy']]);

    	parent::__construct();
    }

	protected $view_name 						= 'Laporan Audit';

	public function abandoned()
	{		
		$breadcrumb								= 	[
														'Laporan Abandoned Cart' 	=> route('backend.report.audit.abandoned')
													];

		$filters 								= ['type' => 'abandoned_cart'];

		$searchResult							= NULL;

		if(Input::has('q'))
		{
			$filters['ondate']					= [Input::get('q'), Input::get('q').' + 1 day'];

			$searchResult 						= Input::get('q');
		}

		$this->layout->page 					= view('pages.backend.report.audit.index')
													->with('WT_pagetitle', $this->view_name )
													->with('WT_pageSubTitle','Abandoned Cart')
													->with('WB_breadcrumbs', $breadcrumb)
													->with('searchResult', $searchResult)
													->with('filters', $filters)
													->with('nav_active', 'audit')
													->with('subnav_active', 'abandoned')
													;

		return $this->layout;		
	}

	public function paid()
	{		
		$breadcrumb								= 	[
														'Laporan Penanganan Pembayaran' 	=> route('backend.report.audit.paid')
													];

		$filters 								= ['type' => 'transaction_paid'];

		$searchResult							= NULL;

		if(Input::has('q'))
		{
			$filters['ondate']					= [Input::get('q'), Input::get('q').' + 1 day'];
			
			$searchResult 						= Input::get('q');
		}

		$this->layout->page 					= view('pages.backend.report.audit.index')
													->with('WT_pagetitle', $this->view_name )
													->with('WT_pageSubTitle','Penanganan Pembayaran')
													->with('WB_breadcrumbs', $breadcrumb)
													->with('searchResult', $searchResult)
													->with('filters', $filters)
													->with('nav_active', 'audit')
													->with('subnav_active', 'paid')
													;

		return $this->layout;		
	}

	public function ship()
	{		
		$breadcrumb								= 	[
														'Laporan Penanganan Pengiriman' 	=> route('backend.report.audit.ship')
													];

		$filters 								= ['type' => 'transaction_shipping'];

		$searchResult							= NULL;

		if(Input::has('q'))
		{
			$filters['ondate']					= [Input::get('q'), Input::get('q').' + 1 day'];
			
			$searchResult 						= Input::get('q');
		}

		$this->layout->page 					= view('pages.backend.report.audit.index')
													->with('WT_pagetitle', $this->view_name )
													->with('WT_pageSubTitle','Penanganan Pengiriman')
													->with('WB_breadcrumbs', $breadcrumb)
													->with('searchResult', $searchResult)
													->with('filters', $filters)
													->with('nav_active', 'audit')
													->with('subnav_active', 'ship')
													;

		return $this->layout;		
	}

	public function deliver()
	{		
		$breadcrumb								= 	[
														'Laporan Pesanan Lengkap' 	=> route('backend.report.audit.deliver')
													];

		$filters 								= ['type' => 'transaction_delivered'];

		$searchResult							= NULL;

		if(Input::has('q'))
		{
			$filters['ondate']					= [Input::get('q'), Input::get('q').' + 1 day'];
			
			$searchResult 						= Input::get('q');
		}

		$this->layout->page 					= view('pages.backend.report.audit.index')
													->with('WT_pagetitle', $this->view_name )
													->with('WT_pageSubTitle','Pesanan Lengkap')
													->with('WB_breadcrumbs', $breadcrumb)
													->with('searchResult', $searchResult)
													->with('filters', $filters)
													->with('nav_active', 'audit')
													->with('subnav_active', 'deliver')
													;

		return $this->layout;		
	}

	public function cancel()
	{		
		$breadcrumb								= 	[
														'Laporan Pembatalan Pesanan' 	=> route('backend.report.audit.cancel')
													];

		$filters 								= ['type' => 'transaction_canceled'];

		$searchResult							= NULL;

		if(Input::has('q'))
		{
			$filters['ondate']					= [Input::get('q'), Input::get('q').' + 1 day'];
			
			$searchResult 						= Input::get('q');
		}

		$this->layout->page 					= view('pages.backend.report.audit.index')
													->with('WT_pagetitle', $this->view_name )
													->with('WT_pageSubTitle','Pembatalan Pesanan')
													->with('WB_breadcrumbs', $breadcrumb)
													->with('searchResult', $searchResult)
													->with('filters', $filters)
													->with('nav_active', 'audit')
													->with('subnav_active', 'cancel')
													;

		return $this->layout;		
	}

	public function price()
	{		
		$breadcrumb								= 	[
														'Laporan Perubahan Harga' 	=> route('backend.report.audit.price')
													];

		$filters 								= ['type' => 'price_changed'];

		$searchResult							= NULL;

		if(Input::has('q'))
		{
			$filters['ondate']					= [Input::get('q'), Input::get('q').' + 1 day'];
			
			$searchResult 						= Input::get('q');
		}

		$this->layout->page 					= view('pages.backend.report.audit.index')
													->with('WT_pagetitle', $this->view_name )
													->with('WT_pageSubTitle','Perubahan Harga')
													->with('WB_breadcrumbs', $breadcrumb)
													->with('searchResult', $searchResult)
													->with('filters', $filters)
													->with('nav_active', 'audit')
													->with('subnav_active', 'price')
													;

		return $this->layout;		
	}

	public function voucher()
	{		
		$breadcrumb								= 	[
														'Laporan Penambahan Voucher' 	=> route('backend.report.audit.voucher')
													];

		$filters 								= ['type' => 'voucher_added'];

		$searchResult							= NULL;

		if(Input::has('q'))
		{
			$filters['ondate']					= [Input::get('q'), Input::get('q').' + 1 day'];
			
			$searchResult 						= Input::get('q');
		}

		$this->layout->page 					= view('pages.backend.report.audit.index')
													->with('WT_pagetitle', $this->view_name )
													->with('WT_pageSubTitle','Penambahan Voucher')
													->with('WB_breadcrumbs', $breadcrumb)
													->with('searchResult', $searchResult)
													->with('filters', $filters)
													->with('nav_active', 'audit')
													->with('subnav_active', 'voucher')
													;

		return $this->layout;		
	}

	public function policy()
	{		
		$breadcrumb								= 	[
														'Laporan Perubahan Policy' 	=> route('backend.report.audit.policy')
													];

		$filters 								= ['type' => 'policy_changed'];

		$searchResult							= NULL;

		if(Input::has('q'))
		{
			$filters['ondate']					= [Input::get('q'), Input::get('q').' + 1 day'];
			
			$searchResult 						= Input::get('q');
		}

		$this->layout->page 					= view('pages.backend.report.audit.index')
													->with('WT_pagetitle', $this->view_name )
													->with('WT_pageSubTitle','Perubahan Policy')
													->with('WB_breadcrumbs', $breadcrumb)
													->with('searchResult', $searchResult)
													->with('filters', $filters)
													->with('nav_active', 'audit')
													->with('subnav_active', 'policy')
													;

		return $this->layout;		
	}

	public function point()
	{		
		$breadcrumb								= 	[
														'Laporan Penambahan Point' 	=> route('backend.report.audit.point')
													];

		$filters 								= ['type' => 'point_added'];

		$searchResult							= NULL;

		if(Input::has('q'))
		{
			$filters['ondate']					= [Input::get('q'), Input::get('q').' + 1 day'];
			
			$searchResult 						= Input::get('q');
		}

		$this->layout->page 					= view('pages.backend.report.audit.index')
													->with('WT_pagetitle', $this->view_name )
													->with('WT_pageSubTitle','Penambahan Point')
													->with('WB_breadcrumbs', $breadcrumb)
													->with('searchResult', $searchResult)
													->with('filters', $filters)
													->with('nav_active', 'audit')
													->with('subnav_active', 'point')
													;

		return $this->layout;		
	}


	public function quota()
	{		
		$breadcrumb								= 	[
														'Laporan Penambahan Quota' 	=> route('backend.report.audit.quota')
													];

		$filters 								= ['type' => 'quota_added'];

		$searchResult							= NULL;

		if(Input::has('q'))
		{
			$filters['ondate']					= [Input::get('q'), Input::get('q').' + 1 day'];
			
			$searchResult 						= Input::get('q');
		}

		$this->layout->page 					= view('pages.backend.report.audit.index')
													->with('WT_pagetitle', $this->view_name )
													->with('WT_pageSubTitle','Penambahan Quota')
													->with('WB_breadcrumbs', $breadcrumb)
													->with('searchResult', $searchResult)
													->with('filters', $filters)
													->with('nav_active', 'audit')
													->with('subnav_active', 'quota')
													;

		return $this->layout;		
	}
}