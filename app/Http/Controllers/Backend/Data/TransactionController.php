<?php namespace App\Http\Controllers\Backend\Data;
use App\Http\Controllers\baseController;

use App\Models\User;
use App\Models\product;
use App\Models\transaction;
use App\Models\transactionDetail;

// use App\Jobs\PointIsAvailable;

use Input, DB;

class transactionController extends baseController 
{
	protected $view_name 					= 'Transaksi';
	
	protected $controller_name 				= 'Points';
	
	protected $inputs						= [
												'id',
												'user_id',
												'supplier_id',
												'ref_number',
												'referral_code',
												'type',
												'status',
												'transacted_at',
												'unique_number',
												'shipping_cost',
												'referral_discount',
												'amount',	
												'products',	
												];


	public function index($type = null)
	{		
		$breadcrumb								= ['Supplier' => 'backend.data.transaction.index'];

		if (Input::get('q'))
		{
			$searchResult						= Input::get('q');
		}
		else
		{
			$searchResult						= NUll;
		}

		$sub_subnav_active	 				= '';

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


	public function buy()
	{		
		$this->inputs['id']					= Input::get('id');
		$this->inputs['user_id']			= 0;
		$this->inputs['supplier_id']		= Input::get('supplier_id');
		$this->inputs['ref_number']			= Input::get('ref_number');
		$this->inputs['referral_code']		= Input::get('referral_code');
		$this->inputs['type']				= 'buy';
		$this->inputs['status']				= Input::get('status');
		$this->inputs['transacted_at']		= Input::get('transacted_at');
		$this->inputs['unique_number']		= Input::get('unique_number');
		$this->inputs['shipping_cost']		= Input::get('shipping_cost');
		$this->inputs['referral_discount']	= Input::get('referral_discount');
		$this->inputs['amount']				= Input::get('amount');
		$this->inputs['products']			= Input::get('products');

		$this->store();
	}

	public function sell()
	{		
		$this->inputs['id']					= Input::get('id');
		$this->inputs['user_id']			= Input::get('user_id');
		$this->inputs['supplier_id']		= 0;
		$this->inputs['ref_number']			= Input::get('ref_number');
		$this->inputs['referral_code']		= Input::get('referral_code');
		$this->inputs['type']				= 'sell';
		$this->inputs['status']				= Input::get('status');
		$this->inputs['transacted_at']		= Input::get('transacted_at');
		$this->inputs['unique_number']		= Input::get('unique_number');
		$this->inputs['shipping_cost']		= Input::get('shipping_cost');
		$this->inputs['referral_discount']	= Input::get('referral_discount');
		$this->inputs['amount']				= Input::get('amount');
		$this->inputs['products']			= Input::get('products');


		// $this->inputs['id']					= Null;
		// $this->inputs['user_id']			= 1;
		// $this->inputs['ref_number']			= 'B00124';
		// $this->inputs['referral_code']		= Null;
		// $this->inputs['type']				= 'sell';
		// $this->inputs['status']				= 'waiting';
		// $this->inputs['transacted_at']		= date('Y-m-d H:i:s', strtotime('now'));
		// $this->inputs['unique_number']		= 0;
		// $this->inputs['shipping_cost']		= 4000;
		// $this->inputs['referral_discount']	= 0;
		// $this->inputs['amount']				= 4000;
		// $this->inputs['products']			= [
		// 										'0' => ['id' => '5', 'quantity' => '2'],
		// 										'1' => ['id' => '6', 'quantity' => '3'],
		// 										'2' => ['id' => '7', 'quantity' => '1'],
		// 										'3' => ['id' => '8', 'quantity' => '4'],
		// 										];



		$this->store();
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
}