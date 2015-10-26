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
													->with('WT_pageTitle', $this->view_name )
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
														->with('WT_pageTitle', $this->view_name )
														->with('WT_pageSubTitle','Create')		
														->with('WB_breadcrumbs', $breadcrumb)
														->with('id', $id)
														->with('nav_active', 'data')
														->with('subnav_active', $subnav_active)
														;
		return $this->layout;
	}

	public function store()
	{		
		if($this->inputs['id'])
		{
			$data							= transaction::find($this->inputs['id']);
		}
		else
		{
			$data 							= new transaction;
		}

		$data->fill([
			'id'							=> $this->inputs['id'],
			'user_id'						=> (int)$this->inputs['user_id'],
			'supplier_id'					=> (int)$this->inputs['supplier_id'],
			'ref_number'					=> $this->inputs['ref_number'],
			'referral_code'					=> $this->inputs['referral_code'],
			'status'						=> $this->inputs['status'],
			'type'							=> $this->inputs['type'],
			'transacted_at'					=> $this->inputs['transacted_at'],
			'unique_number'					=> (int)$this->inputs['unique_number'],
			'shipping_cost'					=> (float)$this->inputs['shipping_cost'],
			'referral_discount'				=> (float)$this->inputs['referral_discount'],
			'amount'						=> (float)$this->inputs['amount'],
		]);

		DB::beginTransaction();

		if (!$data->save())
		{
			DB::rollback();
			dd('error');
		}	
		else
		{
			foreach ($this->inputs['products'] as $product) 
			{
				$details 					= new transactionDetail;

				$product_data 				= product::find($product['id']);

				$details->fill([
					'transaction_id'		=> $data['id'],	
					'product_id'			=> $product_data['id'],	
					'price'					=> $product_data['price'],
					'quantity'				=> $product['quantity'],
					'discount'				=> $product_data['discount'],
				]);

				if (!$details->save())
				{
					DB::rollback();
					dd('error');
				}	
			}

			if($this->inputs['status'] == 'draft' && $this->inputs['type'] == 'sell')
			{
				$data->fill([
					'status'				=> 'waiting',
				]);

				if (!$data->save())
				{
					DB::rollback();
					dd('error');
				}
			}

			DB::commit();
			dd('saved');
		}
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