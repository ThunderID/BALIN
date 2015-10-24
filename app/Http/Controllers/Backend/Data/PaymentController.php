<?php namespace App\Http\Controllers\Backend\Data;
use App\Http\Controllers\baseController;

use App\Models\User;
use App\Models\payment;
use App\Models\pointlog;
use App\Models\transaction;

use Input, Session, DB, Redirect;

class paymentController extends baseController 
{
	protected $controller_name 				= 'Pembayaran';

	public function store()
	{
		$inputs 							= input::only('id','transaction_id','method','destination','account_name','account_number','ondate','ammount');

		if($inputs['id'])
		{
			$data 							= payment::find($inputs['id']);
		}
		else
		{
			$data 							= new payment;
		}

		// $data->fill([
		// 	'method'						=> $inputs['method'],
		// 	'destination'					=> $inputs['destination'],
		// 	'account_name'					=> $inputs['account_name'],
		// 	'account_number'				=> $inputs['account_number'],
		// 	'ondate'						=> $inputs['ondate'],
		// 	'ammount'						=> $inputs['account_number'],
		// ])

		// $transaction 						= transaction::find($inputs['transaction']);

		$transaction 						= transaction::find(23);

		if(empty($transaction))
		{
			dd('transaction not found');
		}

		$data->fill([
			'method'						=> 'Bank Transfer',
			'destination'					=> 'BCA',
			'account_name'					=> 'BUDI',
			'account_number'				=> 'gdsahgdadsya6ydgbjbaj87',
			'ondate'						=> date('Y-m-d H:i:s', strtotime('now')),
			'ammount'						=> 120000,
		]);

		$data->transaction()->associate($transaction);

		DB::beginTransaction();
		if (!$data->save())
		{
			DB::rollback();
			// return Redirect::back()
			// 	->withInput()
			// 	->withErrors($data->getError())
			// 	->with('msg-type', 'danger');
			dd('error');
		}	
		else
		{
			DB::commit();
			// return Redirect::route('backend.price.index')
			// 	->with('msg','Data sudah ditambahkan')
			// 	->with('msg-type', 'success');
			dd('saved');
		}
	}
}