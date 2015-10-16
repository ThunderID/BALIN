<?php namespace App\Http\Controllers\Backend\Data;
use App\Http\Controllers\baseController;

use App\Models\User;
use App\Models\shipment;
use App\Models\courier;
use App\Models\transaction;

use Input, Session, DB, Redirect;

class shipmentController extends baseController 
{
	protected $controller_name 				= 'Shipment';

	public function store()
	{
		$inputs 							= input::only('id','transaction_id','courier_id','receipt_number','ondate','name','phone','address','postal_code');

		if($inputs['id'])
		{
			$data 							= shipment::find($inputs['id']);
		}
		else
		{
			$data 							= new shipment;
		}

		// $transaction 						= transaction::find($inputs['transaction_id']);

		$transaction 						= transaction::find(23);

		if(empty($transaction) )
		{
			dd('transaction not found');
		}

		// $courier 						= courier::find($inputs['courier_id']);

		$courier 							= courier::find(1);

		if(empty($courier))
		{
			dd('courier not found');
		}

		// $data->fill([
		// 	'receipt_number'				=> $inputs['receipt_number'],
		// 	'ondate'						=> $inputs['ondate'],
		// 	'name'							=> $inputs['name'],
		// 	'phone'							=> $inputs['phone'],
		// 	'address'						=> $inputs['address'],
		// 	'postal_code'					=> $inputs['postal_code'],
		// ])


		$data->fill([
			'receipt_number'				=> '76df76sdfhsdhfj',
			'ondate'						=> date('Y-m-d H:i:s', strtotime('now')),
			'name'							=> 'BUDI',
			'phone'							=> '038624725647',
			'address'						=> 'jl.bambu, 12, malang',
			'postal_code'					=> '1200',
		]);

		$data->transaction()->associate($transaction);

		$data->courier()->associate($courier);

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