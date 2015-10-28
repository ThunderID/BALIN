<?php namespace App\Http\Controllers\Backend\Data;
use App\Http\Controllers\baseController;

use App\Models\User;
use App\Models\product;
use App\Models\transaction;
use App\Models\transactionDetail;
// use App\Jobs\PointIsAvailable;

use Input, DB, Redirect, Response;

class TransactionController extends baseController 
{
	/**
     * Instantiate a new UserController instance.
     */
    
    public function __construct()
    {
        $this->middleware('passwordneeded', ['only' => ['destroy']]);

    	parent::__construct();
    }

	protected $view_name 						= 'Transaksi';

	public function index($type = null)
	{		
		$breadcrumb								= [	'Transaksi' => 'backend.data.transaction.index'];

		$filters 								= null;

		if(Input::has('q'))
		{
			$filters 							= ['status' => Input::get('q')];
			$searchResult						= Input::get('q');
		}
		else
		{
			$searchResult						= null;
		}

		$sub_subnav_active	 					= '';

		if (Input::has('type'))
		{
			if (Input::get('type')=='sell')
			{
				$subnav_active 				= 'sell';
			}
			else
			{
				$subnav_active 				= 'buy';
			}
		}

		$this->layout->page 					= view('pages.backend.data.transaction.index')
													->with('WT_pagetitle', $this->view_name )
													->with('WT_pageSubTitle','Index')
													->with('WB_breadcrumbs', $breadcrumb)
													->with('searchResult', $searchResult)
													->with('filters', $filters)
													->with('nav_active', 'data')
													->with('subnav_active', $subnav_active)
													;
		return $this->layout;	

	}

	public function create($id = null)
	{
		if(!$id)
		{
			$breadcrumb							= ['Transaksi' => 'backend.test.testcontroller',
														'Transaksi Baru' => 'backend.test.testcontroller'];
		}
		else
		{
			$breadcrumb							= ['Transaksi' => 'backend.test.testcontroller',
														'Edit Transaksi' => 'backend.test.testcontroller'];
		}

		if (Input::has('type'))
		{
			if (Input::get('type')=='sell')
			{
				$subnav_active 				= 'sell';
			}
			else
			{
				$subnav_active 				= 'buy';
			}
		}

		$this->layout->page 					= view('pages.backend.data.transaction.create')
														->with('WT_pagetitle', $this->view_name )
														->with('WT_pageSubTitle','Create')		
														->with('WB_breadcrumbs', $breadcrumb)
														->with('id', $id)
														->with('nav_active', 'data')
														->with('subnav_active', $subnav_active)
														;
		return $this->layout;
	}

	public function store($id = null)
	{		
		if($id)
		{
			$data							= Transaction::find($id);
		}
		else
		{
			$data 							= new Transaction;
		}
		dd(Input::all());
	}

	public function destroy($id)
	{
		$data 						= Transaction::findorfail($id);

		DB::beginTransaction();

		if (!$data->delete())
		{
			DB::rollback();
			
			return Redirect::back()
				->withErrors($data->getError())
				->with('msg-type','danger');
		}
		else
		{
			DB::commit();

			return Redirect::route('backend.data.transaction.index', ['type' => Input::get('type')])
				->with('msg', 'Transaction telah dihapus')
				->with('msg-type','success');
		}
	}
}