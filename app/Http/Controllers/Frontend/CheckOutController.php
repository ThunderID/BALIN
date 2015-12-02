<?php namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\BaseController;
use App\Models\Transaction;
use App\Models\Address;
use App\Models\Voucher;
use App\Models\Shipment;
use App\Models\ShippingCost;
use App\Models\Courier;
use App\Models\StoreSetting;
use App\Jobs\ChangeStatus;
use App\Jobs\CountShippingCost;
use App, Input, Response, Redirect, Session, Auth, Request, Carbon;

class CheckOutController extends BaseController 
{
	protected $controller_name 					= 'checkout';

	public function getCheckout()
	{	
		//get transaction
		$breadcrumb								= ['Checkout' => route('frontend.get.checkout')];

		$baskets 								= Session::get('baskets');
		$addresses 								= Address::oldershipmentbycustomer(Auth::user()->id)->get()->toArray();
		// $address 								= Address::ownerid(Auth::user()->id)->ownertype('App\Models\User')->first();
		// if($address)
		// {
		// 	$address 							= $address['attributes'];
		// 	$address['receiver_name']			= Auth::user()->name;
		// }

		// $addresses[]							= $address;

		$this->layout->page 					= view('pages.frontend.cart.checkout')
													->with('controller_name', $this->controller_name)
													->with('carts', $baskets)
													->with('addresses', $addresses)
													->with('breadcrumb', $breadcrumb);
													
		$this->layout->controller_name			= $this->controller_name;

		$this->layout->page->page_title 		= 'BALIN.ID';
		$this->layout->page->page_subtitle 		= 'Checkout';

		return $this->layout;
	}

	public function postCheckout()
	{
		if(!Input::has('term'))
		{
			return Redirect::back()->withInput()->withErrors('Anda harus menyetujui syarat dan ketentuan BALIN.ID.')->with('msg-type', 'danger');
		}

		$transaction           	 				= Transaction::userid(Auth::user()->id)->status('cart')->wherehas('transactiondetails', function($q){$q;})->with(['transactiondetails', 'transactiondetails.varian', 'transactiondetails.varian.product'])->orderby('transact_at', 'desc')->first();
		
		if(!$transaction)
		{
			return Redirect::back()->withInput()->withErrors('Tidak ada keranjang.');
		}

		if(Input::has('voucher_code') && Input::Get('voucher_code')!='')
		{
			$vouchers 							= Voucher::code(Input::get('voucher_code'))->ondate('now')->first();

			if(!$vouchers)
			{
				return Redirect::back()->withErrors('Tidak ada voucher.')->with('msg-type', 'danger');
			}

			if($vouchers->quota - 1 < 0)
			{
				return Redirect::back()->withErrors('Voucher tidak dapat digunakan.')->with('msg-type', 'danger');
			}

			$transaction->fill(['voucher_id' => $vouchers->id]);

			if(!$transaction->save())
			{
				return Redirect::back()->withInput()->withErrors($transaction->getError())->with('msg-type', 'danger');
			}
		}

		if(Input::has('address_id') && Input::Get('address_id')!=0)
		{
			if(Input::has('receiver_name'))
			{
				$receiver_name 					= Input::get('receiver_name');
			}
			else
			{
				$receiver_name 					= Auth::user()->name;
			}

			$address 							= Address::findorfail(Input::get('address_id'));
		}
		else
		{
			$input 								= Input::only('address', 'zipcode', 'phone', 'receiver_name');
			$address 							= new Address;
			$receiver_name 						= $input['receiver_name'];
			$address->fill($input);

			if(!$address->save())
			{
				return Redirect::back()->withInput()->withErrors($address->getError())->with('msg-type', 'danger');
			}
		}

		$courier 								= Courier::first();
		if(!$courier)
		{
			return Redirect::back()->withErrors('Tidak ada kurir.');
		}

		$shipment 								= new Shipment;

		$shipment->fill([
				'courier_id'					=> $courier->id,
				'transaction_id'				=> $transaction->id,
				'address_id'					=> $address->id,
				'receiver_name'					=> $receiver_name,
		]);

		if(!$shipment->save())
		{
			return Redirect::back()->withInput()->withErrors($shipment->getError())->with('msg-type', 'danger');
		}

		//bisa jadi setelah term and condition
		$result                         		= $this->dispatch(new ChangeStatus($transaction, 'wait'));

		if($result->getStatus()=='success')
		{
			$cookie = Session::forget('baskets');

			return Redirect::route('frontend.user.index', ['ref' => $transaction->ref_number]);
		}

		return Redirect::back()->withInput()->withErrors($result->getErrorMessage())->with('msg-type', 'danger');
	}

	public function getShippingCost()
	{	
		//get shipping cost
		if(Input::has('zipcode'))
		{
			$zipcode 			= Input::get('zipcode');
		}
		elseif(Input::has('address'))
		{
			if(Input::get('address') == 0)
			{
			    return json_decode(json_encode('IDR '.number_format(0, 0, ',', '.')));
			}

			$address 			= Address::id(Input::get('address'))->first();
			$zipcode 			= $address['zipcode'];
		}
		else
		{
			App::abort(404);
		}
		
		$courier 				= Courier::first();
    	$shippingcost 			= ShippingCost::courierid($courier->id)->postalcode($zipcode)->first();

		$transaction    		= Transaction::userid(Auth::user()->id)->status('cart')->first();

		if(!$transaction)
		{
			App::abort(404);
		}

		if($shippingcost['attributes']['cost']==0)
		{
			$cost 				= 20000;
		}
		else
		{
			$cost 				= $shippingcost['attributes']['cost'];
		}
        
        $result                	= $this->dispatch(new CountShippingCost($transaction->transactiondetails, $cost));
    	
    	if(!$result->getStatus()=='success')
    	{
    		App::abort();
    	}
    	else
    	{
		    return json_decode(json_encode('IDR '.number_format($result->getData()['shipping_cost'], 0, ',', '.')));
    	}
	}

	public function checkedout($ref = null)
	{		
		$breadcrumb								= ['Ubah Profile' => route('frontend.user.edit')];
		$transaction 							= Transaction::userid(Auth::user()->id)->type('sell')->refnumber($ref)->first();
		$expire 								= StoreSetting::type('expired_paid')->ondate('now')->first();

		$dateexpire 							= new Carbon(str_replace('-', '+', $expire->value));

		if(!$transaction)
		{
			App::abort(404);
		}
		
		return view('pages.frontend.user.order.checked')
													->with('controller_name', $this->controller_name)
													->with('subnav_active', 'account_order')
													->with('title', 'Riwayat Pesanan #'.$ref)
													->with('transaction', $transaction)
													->with('dateexpire', $dateexpire)
													->with('breadcrumb', $breadcrumb);

	}

	public function checkvoucher()
	{	
		//get shipping cost
		if(Input::has('voucher'))
		{
			$code 				= Input::get('voucher');
		}
		else
		{
			App::abort(404);
		}

		$voucher 				= Voucher::code($code)->type(['free_shipping_cost', 'debit_point'])->ondate('now')->first();

		if(!$voucher)
		{
			return Response::json(['type' => 'error', 'msg' => 'Voucher Tidak valid!'], 200);
		    // return json_decode(json_encode('Voucher Tidak valid!'));
		}
		elseif($voucher->quota - 1 < 0)
		{
			return Response::json(['type' => 'error', 'msg' => 'Voucher Tidak dapat dipakai.'], 200);
		    // return json_decode(json_encode('Voucher Tidak dapat dipakai.'));
		}
		else
		{
			if($voucher->type=='free_shipping_cost')
			{
				return Response::json(['type' => 'success', 'msg' => 'Selamat! Anda mendapat potongan : gratis biaya pengiriman.'], 200);
			    // return json_decode(json_encode('Selamat! Anda mendapat potongan : gratis biaya pengiriman.'));
			}
			else
			{
				return Response::json(['type' => 'success', 'msg' => 'Selamat! Anda mendapat bonus point sebesar '.$voucher->value.' (Point akan ditambahkan jika pesanan sudah dibayar)'], 200);
			    // return json_decode(json_encode('Selamat! Anda mendapat bonus point sebesar '.$voucher->value.' (Point akan ditambahkan jika pesanan sudah dibayar)'));
			}
		}
	}

	public function getAddress($id)
	{
		$addresses 								= Address::find($id);

		return Response::json(['address' => $addresses], 200);
	}
}