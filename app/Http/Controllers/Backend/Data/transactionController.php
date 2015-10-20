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
	protected $controller_name 				= 'Points';
	protected $inputs						= [
												'id',
												'user_id',
												'supplier_id',
												'ref_number',
												'refferal_code',
												'type',
												'status',
												'transacted_at',
												'unique_number',
												'shipping_cost',
												'referral_discount',
												'amount',	
												'products',	
												];


	public function index()
	{		

	}

	public function buy()
	{		
		$this->inputs['id']					= Input::get('id');
		$this->inputs['user_id']			= Input::get('user_id');
		$this->inputs['ref_number']			= Input::get('ref_number');
		$this->inputs['refferal_code']		= Input::get('refferal_code');
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
	// 	$this->inputs['id']					= Input::get('id');
	// 	$this->inputs['user_id']			= Input::get('user_id');
	// 	$this->inputs['ref_number']			= Input::get('ref_number');
	// 	$this->inputs['refferal_code']		= Input::get('refferal_code');
	// 	$this->inputs['type']				= 'sell';
	// 	$this->inputs['status']				= Input::get('status');
	// 	$this->inputs['transacted_at']		= Input::get('transacted_at');
	// 	$this->inputs['unique_number']		= Input::get('unique_number');
	// 	$this->inputs['shipping_cost']		= Input::get('shipping_cost');
	// 	$this->inputs['referral_discount']	= Input::get('referral_discount');
	// 	$this->inputs['amount']				= Input::get('amount');
	// 	$this->inputs['products']			= Input::get('products');


		$this->inputs['id']					= Null;
		$this->inputs['user_id']			= 1;
		$this->inputs['ref_number']			= 'B00124';
		$this->inputs['refferal_code']		= Null;
		$this->inputs['type']				= 'sell';
		$this->inputs['status']				= 'waiting';
		$this->inputs['transacted_at']		= date('Y-m-d H:i:s', strtotime('now'));
		$this->inputs['unique_number']		= 0;
		$this->inputs['shipping_cost']		= 4000;
		$this->inputs['referral_discount']	= 0;
		$this->inputs['amount']				= 4000;
		$this->inputs['products']			= [
												'0' => ['id' => '5', 'quantity' => '2'],
												'1' => ['id' => '6', 'quantity' => '3'],
												'2' => ['id' => '7', 'quantity' => '1'],
												'3' => ['id' => '8', 'quantity' => '4'],
												];



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
			'user_id'						=> $this->inputs['user_id'],
			'ref_number'					=> $this->inputs['ref_number'],
			'refferal_code'					=> $this->inputs['refferal_code'],
			'status'						=> $this->inputs['status'],
			'type'							=> $this->inputs['type'],
			'transacted_at'					=> $this->inputs['transacted_at'],
			'unique_number'					=> $this->inputs['unique_number'],
			'shipping_cost'					=> $this->inputs['shipping_cost'],
			'referral_discount'				=> $this->inputs['referral_discount'],
			'amount'						=> $this->inputs['amount'],
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

			DB::commit();
			dd('saved');
		}
	}
}