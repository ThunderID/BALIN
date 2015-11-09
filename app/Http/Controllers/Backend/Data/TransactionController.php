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

use Illuminate\Support\MessageBag;

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

		if(Input::has('q'))
		{
			$filters 							= ['refnumber' => Input::get('q')];
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
					$vouchers 				= Voucher::code(Input::get('voucher_code'))->first();

					if(!$vouchers)
					{
						$errors->add('Transaction', 'Kode voucher tidak terdaftar.');
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

				$data->fill([
					'voucher_id'			=> $voucher,
					'user_id'				=> $inputs['customer'],
					'type'					=> 'sell',
					]);
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
				$datatd							= new TransactionDetail;

				$datatd->fill([
					'transaction_id'			=> $data['id'],
					'product_id'				=> $value,
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

		if(!$errors->count() && Input::has('address_choice') && Input::get('address_choice')==1)
		{
			$inputaddr 							= Input::only('address', 'phone', 'postal_code');

			$address 							= new Address;

			$address->fill([
				'address'						=> $inputaddr['address'],
				'phone'							=> $inputaddr['phone'],
				'zipcode'						=> $inputaddr['postal_code'],
				]);

			$address->owner()->associate(User::findorfail($inputs['customer']));

			if(!$address->save())
			{
				$errors->add('Transaction', $address->getError());
			}
		}
		elseif(!$errors->count() && Input::has('address_choice') && Input::get('address_choice')==2)
		{
			$address 							= Address::findorfail(Input::get('address_id'));
		}

		if(isset($address) && !$errors->count())
		{
			$shipinput 							= Input::only('courier');

			$shipment 							= new Shipment;

			$shipment->fill([
				'courier_id'					=> $shipinput['courier'],
				'transaction_id'				=> $data->id,
				'address_id'					=> $address->id,
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

		$transaction 					= Transaction::type($subnav_active)->id($id)->with(['transactiondetails', 'transactiondetails.product'])->first();
		
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
		$transaction 					= Transaction::findorfail($id);

		$result                         = $this->dispatch(new ChangeStatus($transaction, strtolower(Input::get('status'))));

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
}