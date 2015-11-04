<?php namespace App\Http\Controllers\Backend\Data;
use App\Http\Controllers\baseController;

use App\Models\User;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Address;
use App\Models\Shipment;
use App\Jobs\ChangeStatus;

use Illuminate\Support\MessageBag;

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
		$transaction 							= Transaction::findorfail(5010);

        $result                             = $this->dispatch(new ChangeStatus($transaction, 'wait'));
		dd($result);
		$breadcrumb								= [	'Transaksi' => 'backend.data.transaction.index'];

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
		$inputs 							= Input::only('type','status','supplier','customer','product','qty','price','discount');

		if($id)
		{
			$data							= Transaction::findornew($id);
		}
		else
		{
			$data 							= new Transaction;
		}

		switch (strtolower($inputs['type'])) 
		{
			case 'buy':
				$data->fill([
					'supplier_id'			=> $inputs['supplier'],
					'type'					=> 'buy',
					]);
				break;
			default:
				$data->fill([
					'user_id'				=> $inputs['customer'],
					'type'					=> 'sell',
					]);
				break;
		}

		DB::beginTransaction();

		$errors 							= new MessageBag();

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