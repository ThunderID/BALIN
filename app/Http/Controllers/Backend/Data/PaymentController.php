<?php namespace App\Http\Controllers\Backend\Data;

use App\Http\Controllers\baseController;
use App\Models\User;
use App\Models\Payment;
use Illuminate\Support\MessageBag;
use Input, Session, DB, Redirect;

class PaymentController extends baseController
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
		$breadcrumb				= ['Nota Bayar' => 'backend.data.payment.index'];

		$filters 				= ['doesnthavetransaction' => true];
		
		if(Input::has('q'))
		{
			$filters['amount'] 	= Input::get('q');
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
			$breadcrumb			= 	[ 	'Nota Bayar' => 'backend.data.payment.index',
										'Nota Bayar Baru' => 'backend.data.payment.create'
									];
		}
		else
		{
			$breadcrumb			= 	[ 	'Nota Bayar' => 'backend.data.payment.index',
										'Edit Data' => 'backend.data.payment.create'
									];
		}

		$this->layout->page 	= view('pages.backend.data.payment.create')
									->with('WT_pagetitle', $this->view_name )
									->with('WT_pageSubTitle','Create')
									->with('WB_breadcrumbs', $breadcrumb)
									->with('id', $id)
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
		$inputs 				= Input::only('account_name', 'account_number', 'amount', 'destination', 'ondate', 'transaction_id');
		
		if(!is_null($id))
		{
			$data				= Payment::find($id);
		}
		else
		{
			$data				= new Payment;
		}

		$data->fill([
			'transaction_id' 	=> 0,
			'account_name' 		=> $inputs['account_name'],
			'account_number' 	=> $inputs['account_number'],
			'amount' 			=> $inputs['amount'],
			'ondate' 			=> date('Y-m-d', strtotime($inputs['ondate'])),
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
							->with('msg', 'Nota Bayar sudah disimpan')
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
}