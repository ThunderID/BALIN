<?php namespace App\Http\Controllers\Backend\Data;

use App\Http\Controllers\BaseController;
use App\Models\User;
use App\Models\Payment;
use App\Models\Transaction;
use Illuminate\Support\MessageBag;
use Input, Session, DB, Redirect, Carbon, App;

class PaymentController extends BaseController
{
	/**
	* Instantiate a new UserController instance.
	*/
	public function __construct()
	{
		$this->middleware('passwordneeded', ['only' => ['destroy']]);

		parent::__construct();
	}

	protected $view_name 		= 'Nota Bayar';

	public function index()
	{
		$breadcrumb				= 	[
										'Nota Bayar' 	=> route('backend.data.payment.index'),
									];

		// $filters 				= ['doesnthavetransaction' => true];
		$filters 				= null;

		if(Input::has('q'))
		{
			$amount  			= str_replace('IDR ', '', str_replace('.', '', Input::get('q')));
			$filters 			= ['amount' => $amount];
			$searchResult		= Input::get('q');
		}
		else
		{
			$searchResult		= null;
		}

		$this->layout->page 	= view('pages.backend.data.payment.index')
									->with('WT_pagetitle', $this->view_name )
									->with('WT_pageSubTitle','Index')
									->with('WB_breadcrumbs', $breadcrumb)
									->with('searchResult', $searchResult)
									->with('filters', $filters)
									->with('nav_active', 'data')
									->with('subnav_active', 'payment');
		return $this->layout;
	}

	public function show($id)
	{
		return Redirect::back();
	}

	public function create($id = null)
	{
		if (is_null($id))
		{
			$payment 			= new Payment;
			
			$breadcrumb			= 	[ 	
										'Nota Bayar' 					=> route('backend.data.payment.index'),
										'Baru' 							=> route('backend.data.payment.create'),
									];
			$title 				= 'Baru';
			$transaction 		= new Transaction;
		}
		else
		{
			$payment 			= Payment::findorfail($id);
			$transaction 		= $payment->transaction;

			$breadcrumb			= 	[ 	
										'Nota Bayar' 					=> route('backend.data.payment.index'),
										'Edit '.$payment->account_name 	=> route('backend.data.payment.edit', $id),
									];
									
			$title 				= $payment->account_name;
		}

		$this->layout->page 	= view('pages.backend.data.payment.create')
									->with('WT_pagetitle', $this->view_name )
									->with('WT_pageSubTitle',$title)
									->with('WB_breadcrumbs', $breadcrumb)
									->with('id', $id)
									->with('payment', $payment)
									->with('transaction', $transaction)
									->with('nav_active', 'data')
									->with('subnav_active', 'payment');
		return $this->layout;
	}

	public function edit($id)
	{
		return $this->create($id);
	}
	
	public function store($id = null)
	{
		$inputs 				= Input::only('account_name', 'account_number', 'amount', 'destination', 'ondate');
		
		if(!is_null($id))
		{
			$data				= Payment::find($id);
		}
		else
		{
			$data				= new Payment;
		}

		if(Input::has('transaction'))
		{
			$trs 				= Input::get('transaction');
		}
		else
		{
			$trs 				= 0;
		}

		$transaction 			= Transaction::type('sell')->status('wait')->id($trs)->first();

		if(!$transaction)
		{
			App::abort(404);
		}

		$ondate 				= Carbon::createFromFormat('d-m-Y', $inputs['ondate'])->format('Y-m-d H:i:s');

		$data->fill([
			'transaction_id' 	=> $trs,
			'account_name' 		=> $inputs['account_name'],
			'account_number' 	=> $inputs['account_number'],
			'amount' 			=> $transaction['amount'],
			'ondate' 			=> $ondate,
			'destination' 		=> $inputs['destination'],
			'method' 			=> 'Bank Transfer',
		]);

		DB::beginTransaction();

		$errors 				= new MessageBag();

		if(!$data->save())
		{
			$errors->add('Payment', $data->getError());
		}

		if ($errors->count())
		{
			DB::rollback();
			
			return Redirect::back()
							->withInput()
							->withErrors($errors)
							->with('msg-type', 'danger');
		}
		else
		{
			DB::commit();
		
			return Redirect::route('backend.data.payment.index')
							->with('msg', 'Nota Bayar sudah disimpan. Kembali ke <a href="'.route('backend.home').'"> Home </a>')
							->with('msg-type', 'success');
		}
	}

	public function Update($id)
	{
		return $this->store($id);
	}

	public function destroy($id)
	{
		$data					= Payment::findorfail($id);
		
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
			
			return Redirect::route('backend.data.payment.index')
							->with('msg', 'Nota bayar sudah dihapus')
							->with('msg-type','success');
		}
	}

	public function getpaid()
	{
		$breadcrumb				= 	[ 	
										'Nota Bayar' 					=> route('backend.data.payment.index'),
										'Baru' 							=> route('backend.data.payment.create'),
									];
		$title 					= 'Baru';

		$trsid 					= Input::get('trs_id');

		$transaction 			= Transaction::type('sell')->status('wait')->id($trsid)->first();

		if(!$transaction)
		{
			App::abort(404);
		}

		$payment				= new Payment;
		$id 					= null;

		$this->layout->page 	= view('pages.backend.data.payment.create')
									->with('WT_pagetitle', $this->view_name )
									->with('WT_pageSubTitle',$title)
									->with('WB_breadcrumbs', $breadcrumb)
									->with('id', $id)
									->with('transaction', $transaction)
									->with('payment', $payment)
									->with('nav_active', 'data')
									->with('subnav_active', 'payment');
		return $this->layout;
	}
}