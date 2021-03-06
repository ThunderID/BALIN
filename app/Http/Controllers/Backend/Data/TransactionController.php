<?php namespace App\Http\Controllers\Backend\Data;
use App\Http\Controllers\BaseController;

use App\Models\User;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Address;
use App\Models\Shipment;
use App\Models\Voucher;
use App\Jobs\ChangeStatus;
use App\Jobs\SendBillingEmail;
use App\Jobs\SendPaymentEmail;
use App\Jobs\SendShipmentEmail;
use App\Jobs\SendDeliveredEmail;
use App\Jobs\SendCanceledEmail;

use Illuminate\Support\MessageBag;
use App\Libraries\JSend;

use Input, DB, Redirect, Response, App;

class TransactionController extends BaseController 
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
		$breadcrumb								= 	[	
														'Transaksi' 	=> route('backend.data.transaction.index'),
													];

		$filters 								= null;
		if(Input::has('status') && Input::get('status') != '')
		{
			$filters 							= ['status' => Input::get('status')];
			$searchResult						= Input::get('status');
		}
		else
		{
			$filters 							= ['status' => ['cart', 'wait', 'abandoned', 'canceled', 'delivered', 'shipping', 'paid']];
			$searchResult						= null;
		}

		if(Input::has('q'))
		{
			$amount  							= str_replace('IDR ', '', str_replace('.', '', Input::get('q')));
			$filters 							= ['amount' => $amount];
			$searchResult						= Input::get('q');
		}
		else
		{
			$searchResult						= null;
		}

		$sub_subnav_active	 					= '';
		$title	 								= $this->view_name;

		if (Input::has('type'))
		{
			if (Input::get('type')=='sell')
			{
				$subnav_active 				= 'sell';
				$title 						= 'Penjualan';
				$breadcrumb					= 	[	
													'Data Penjualan' 	=> route('backend.data.transaction.index', ['type' => 'sell']),
												];

			}
			else
			{
				$subnav_active 				= 'buy';
				$title 						= 'Pembelian';
				$breadcrumb					= 	[	
													'Data Pembelian' 	=> route('backend.data.transaction.index', ['type' => 'buy']),
												];
			}
		}

		$this->layout->page 					= view('pages.backend.data.transaction.index')
													->with('WT_pagetitle', $title)
													->with('WT_pageSubTitle','Index')
													->with('WB_breadcrumbs', $breadcrumb)
													->with('searchResult', $searchResult)
													->with('type', Input::get('type'))
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
			$transaction 						= new Transaction;
			$breadcrumb							= 	[
														'Transaksi' 			=> route('backend.data.transaction.index'),
														'Baru' 					=> route('backend.data.transaction.create'),
													];
			$subtitle 							= 'Baru';
		}
		else
		{
			$transaction 						= Transaction::findorfail($id);
			$breadcrumb							= 	[
														'Transaksi' 						=> route('backend.data.transaction.index'),
														'Edit '.$transaction->ref_number 	=> route('backend.data.transaction.edit', $id),
													];
		
			$subtitle 							= $transaction->ref_number;
		}

		if (Input::has('type'))
		{
			if (Input::get('type')=='sell')
			{
				$subnav_active 				= 'sell';
				$title 						= 'Penjualan';
				if(!$id)
				{
					$transaction 			= new Transaction;
					$breadcrumb				= 	[
													'Data Penjualan' 		=> route('backend.data.transaction.index'),
													'Baru' 					=> route('backend.data.transaction.create'),
												];
				}
				else
				{
					$transaction 			= Transaction::findorfail($id);
					$breadcrumb				= 	[
													'Data Penjualan' 					=> route('backend.data.transaction.index'),
													'Edit '.$transaction->ref_number 	=> route('backend.data.transaction.edit', ['id' => $id, 'type' => 'sell']),
												];
				}
			}
			else
			{
				$subnav_active 				= 'buy';
				$title 						= 'Pembelian';
				if(!$id)
				{
					$transaction 			= new Transaction;
					$breadcrumb				= 	[
													'Data Pembelian' 		=> route('backend.data.transaction.index'),
													'Baru' 					=> route('backend.data.transaction.create'),
												];
				}
				else
				{
					$transaction 			= Transaction::findorfail($id);
					$breadcrumb				= 	[
													'Data Pembelian' 					=> route('backend.data.transaction.index'),
													'Edit '.$transaction->ref_number 	=> route('backend.data.transaction.edit', ['id' => $id, 'type' => 'buy']),
												];
				}
			}
		}

		$this->layout->page 					= view('pages.backend.data.transaction.create')
														->with('WT_pagetitle', $title )
														->with('WT_pageSubTitle',$subtitle)		
														->with('WB_breadcrumbs', $breadcrumb)
														->with('id', $id)
														->with('nav_active', 'data')
														->with('subnav_active', $subnav_active)
														;
		return $this->layout;
	}

	public function store($id = null)
	{
		$inputs 							= Input::only('type','status','supplier','customer','product','qty','price','discount');

		if($id)
		{
			$data							= Transaction::findornew($id);
		}
		else
		{
			$data 							= new Transaction;
		}

		$errors 							= new MessageBag();

		switch (strtolower($inputs['type'])) 
		{
			case 'buy':
				$data->fill([
					'supplier_id'			=> $inputs['supplier'],
					'type'					=> 'buy',
					]);
				break;
			default:
				if(Input::has('voucher_code'))
				{
					$vouchers 				= Voucher::code(Input::get('voucher_code'))->ondate('now')->currentquota(true)->first();

					if(!$vouchers)
					{
						$errors->add('Transaction', 'Kode voucher tidak terdaftar.');
					}
					elseif($vouchers->current_quota - 1 < 0)
					{
						$errors->add('Transaction', 'Quota voucher sudah habis.');
					}
					else
					{
						$voucher 			= $vouchers->id;
					}
				}
				else
				{
					$voucher 				= 0;
				}
				if(!$errors->count())
				{
					$data->fill([
						'voucher_id'			=> $voucher,
						'user_id'				=> $inputs['customer'],
						'type'					=> 'sell',
						]);
				}
				break;
		}

		DB::beginTransaction();

		//Clean Prev Transaction
		if($id)
		{
			$prev							= TransactionDetail::transactionid($data['id'])->get();

			foreach ($prev as $old) 
			{
				if(!$old->delete())
				{
					$errors->add('Transaction', $old->getError());
				}
			}
		}

		//cek apa punya error
		if(!$errors->count() && !$data->save())
		{
			$errors->add('Transaction', $data->getError());
		}

		if(!$errors->count())
		{
			//foreach data transaksi detail
			foreach ($inputs['product'] as $key => $value) 
			{
				if($value!='' || !empty($value))
				{
					$datatd							= new TransactionDetail;

					$datatd->fill([
						'transaction_id'			=> $data['id'],
						'varian_id'					=> $value,
						'quantity'					=> $inputs['qty'][$key],
						'price'						=> $inputs['price'][$key],
						'discount'					=> $inputs['discount'][$key],
					]);

					//cek apa punya error
					if(!$datatd->save())
					{
						$errors->add('Transaction', $datatd->getError());
					}
				}
			}
		}

		if(!$errors->count() && Input::has('address_choice') && Input::get('address_choice')==1)
		{
			$inputaddr 							= Input::only('address', 'phone', 'postal_code');

			$address 							= new Address;

			$address->fill([
				'address'						=> $inputaddr['address'],
				'phone'							=> $inputaddr['phone'],
				'zipcode'						=> $inputaddr['postal_code'],
				]);

			// $address->owner()->associate(User::findorfail($inputs['customer']));
			$receiver_name 						= Input::get('receiver_name');

			if(!$address->save())
			{
				$errors->add('Transaction', $address->getError());
			}
		}
		elseif(!$errors->count() && Input::has('address_choice') && Input::get('address_choice')==0)
		{
			$address 							= Address::findorfail(Input::get('address_id'));
			$receiver_name 						= User::findorfail($inputs['customer'])['name'];
		}

		if(isset($address) && !$errors->count())
		{
			$shipinput 							= Input::only('courier');

			$shipment 							= new Shipment;

			$shipment->fill([
				'courier_id'					=> $shipinput['courier'],
				'transaction_id'				=> $data->id,
				'address_id'					=> $address->id,
				'receiver_name'					=> $receiver_name,
				]);

			if(!$shipment->save())
			{
				$errors->add('Transaction', $shipment->getError());
			}
		}

		if($errors->count())
		{
			DB::rollback();

			return Redirect::route('backend.data.transaction.index', ['type' => Input::get('type')])
				->with('msg', $errors)
				->with('msg-type','danger');
		}

		//sukses
		DB::commit();

		return Redirect::route('backend.data.transaction.index', ['type' => Input::get('type')])
			->with('msg', 'Transaksi telah disimpan')
			->with('msg-type','success');
	}

	public function edit($id)
	{
		return $this->create($id);
	}

	public function update($id)
	{
		return $this->store($id);
	}

	public function show($id)
	{		
		if (Input::get('type')=='sell')
		{
			$subnav_active 				= 'sell';
			$title 						= 'Penjualan';
			$breadcrumb					= 	[	
												'Data Penjualan' 	=> route('backend.data.transaction.index', ['type' => 'sell']),
											];

		}
		else
		{
			$subnav_active 				= 'buy';
			$title 						= 'Pembelian';
			$breadcrumb					= 	[	
												'Data Pembelian' 	=> route('backend.data.transaction.index', ['type' => 'buy']),
											];
		}

		$transaction 					= Transaction::type($subnav_active)->id($id)->with(['transactiondetails', 'transactiondetails.varian', 'transactiondetails.varian.product'])->first();
		
		if(!$transaction)
		{
			App::abort(404);
		}

		$breadcrumb[$transaction->ref_number] = route('backend.data.transaction.show', ['id' => $id,'type' => $subnav_active]);

		$this->layout->page 					= view('pages.backend.data.transaction.'.$subnav_active.'.show')
													->with('WT_pagetitle', $title)
													->with('WT_pageSubTitle',$transaction->ref_number)
													->with('WB_breadcrumbs', $breadcrumb)
													->with('transaction', $transaction)
													->with('nav_active', 'data')
													->with('subnav_active', $subnav_active)
													;
		return $this->layout;	

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
				->with('msg', 'Transaksi telah dihapus')
				->with('msg-type','success');
		}
	}

	public function getTransactionByAmount()
	{
		$inputs 						= Input::only('name');

		$tmp 							= Transaction::amount($inputs['name'])
											->status('wait')
											->type('sell')
											->with(['user'])
											->get();

		return json_decode(json_encode($tmp));
	}

	public function ChangeStatus($id = null)
	{
		if(Input::has('notes'))
		{
			$notes 						= Input::get('notes');
		}
		else
		{
			$notes 						= '';
		}

		$transaction 					= Transaction::findorfail($id);

		$result                         = $this->dispatch(new ChangeStatus($transaction, strtolower(Input::get('status')), $notes));

		if($result->getStatus()=='success')
		{
			return Redirect::back()
					->with('msg', 'Data transaksi #'.$transaction->ref_number. ' sudah disimpan')
					->with('msg-type','success');
		}

		return Redirect::back()
				->withErrors($result->getErrorMessage())
				->with('msg-type','danger');
	}

	public function ResendEmail($id = null)
	{
		$transaction 					= Transaction::findorfail($id);

		if(Input::has('status'))
		{
			$status 					= Input::get('status');
		}
		else
		{
			App::abort(404);
		}

		$result 						= new JSend('error', (array)$transaction, 'Status tidak valid.');
		
		switch ($status) 
		{
			case 'wait':
				if(in_array($transaction->status, ['wait', 'paid', 'packed', 'shipping', 'delivered']))
				{
					$result					= $this->dispatch(new SendBillingEmail($transaction));
				}
				break;
			case 'paid': case 'packed' :
				if(in_array($transaction->status, ['paid', 'packed', 'shipping', 'delivered']))
				{
					$result					= $this->dispatch(new SendPaymentEmail($transaction));
				}
				break;
			case 'shipping':
				if(in_array($transaction->status, ['shipping', 'delivered']))
				{
					$result					= $this->dispatch(new SendShipmentEmail($transaction));
				}
				break;
			case 'delivered':
				if(in_array($transaction->status, ['delivered']))
				{
					$result					= $this->dispatch(new SendDeliveredEmail($transaction));
				}
				break;
			case 'canceled':
			if(in_array($transaction->status, ['canceled']))
				{
					$result					= $this->dispatch(new SendCanceledEmail($transaction));
				}
				break;
			default:
				$result 				= new JSend('success', (array)$transaction);
				break;
		}

		if($result->getStatus()=='success')
		{
			return Redirect::back()
					->with('msg', 'Email transaksi #'.$transaction->ref_number. ' sudah dikirim')
					->with('msg-type','success');
		}

		return Redirect::back()
				->withErrors($result->getErrorMessage())
				->with('msg-type','danger');
	}
}