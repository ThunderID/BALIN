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
		$inputs 							= input::only('type','status','supplier','customer','product','qty','price','total_price','discount','tot_price');

		if($id)
		{
			$data							= Transaction::find($id);
		}
		else
		{
			$data 							= new Transaction;

			if($inputs['type'] == 'buy')
			{
				$inputs['status'] = 'delivered';
			}
			else
			{
				$inputs['status'] = 'waiting';
			}
		}

		$data->fill([
			'supplier_id'					=> $inputs['supplier'],
			'customer'						=> $inputs['customer'],
			'type'							=> $inputs['type'],
			'amount'						=> $inputs['total_price'],
			'status'						=> $inputs['status'],
		]);

		// error
		// ga bisa save transac detail -> Tidak dapat menambahkan item baru. Silahkan membuat nota baru
		// ref-> transaction detail creating

		//simpan data transaksi
		DB::beginTransaction();
		$data->save();

		//cek apa punya error
		if($data->getError())
		{
			DB::rollback();

			return Redirect::back()
				->withErrors($data->getError())
				->with('msg-type','danger');					
		}

		//empty prev transaksi detail
		if($id)
		{
			$olds							= transactionDetail::where('transaction_id', $data['id']);

			foreach ($olds as $old) 
			{
				$old->delete();

				if($old->getError())
				{
					DB::rollback();

					return Redirect::back()
						->withErrors($old->getError())
						->with('msg-type','danger');
				}
			}
		}


		//foreach data transaksi detail
		foreach ($inputs['product'] as $key => $value) 
		{
			$datatd							= new transactionDetail;

			$datatd->fill([
				'transaction_id'			=> $data['id'],
				'product_id'				=> $value,
				'quantity'					=> $inputs['qty'][$key],
				'price'						=> $inputs['price'][$key],
				'discount'					=> $inputs['discount'][$key],
			]);

			//simpan data transaksi detail
			$datatd->save();

			//cek apa punya error
			if($datatd->getError())
			{
				DB::rollback();

				return Redirect::back()
					->withErrors($datatd->getError())
					->with('msg-type','danger');
			}
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