<?php namespace App\Http\Controllers\Backend\Data;

use App\Http\Controllers\BaseController;
use App\Models\User;
use App\Models\Shipment;
use Illuminate\Support\MessageBag;
use Input, Session, DB, Redirect, Carbon, App;

class ShipmentController extends BaseController
{
	/**
	* Instantiate a new UserController instance.
	*/
	public function __construct()
	{
		$this->middleware('passwordneeded', ['only' => ['destroy']]);

		parent::__construct();
	}

	protected $view_name 		= 'Resi Pengiriman';

	public function index()
	{
		$breadcrumb				= 	[
										'Resi Pengiriman' 		=> route('backend.data.shipment.index'),
									];

		// $filters 				= ['doesnthavetransaction' => true];
		$filters 				= null;

		if(Input::has('q'))
		{
			$filters['amount'] 	= Input::get('q');
			$searchResult		= Input::get('q');
		}
		else
		{
			$searchResult		= null;
		}

		$this->layout->page 	= view('pages.backend.data.shipment.index')
									->with('WT_pagetitle', $this->view_name )
									->with('WT_pageSubTitle','Index')
									->with('WB_breadcrumbs', $breadcrumb)
									->with('searchResult', $searchResult)
									->with('filters', $filters)
									->with('nav_active', 'data')
									->with('subnav_active', 'shipment');
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
			App::abort(404);
			$shipment 			= new Shipment;
			
			$breadcrumb			= 	[ 	
										'Resi Pengiriman' 				=> route('backend.data.shipment.index'),
										'Baru' 							=> route('backend.data.shipment.create'),
									];

			$title 				= 'Baru';
		}
		else
		{
			$shipment 			= Shipment::findorfail($id);

			$breadcrumb			= 	[ 	
										'Resi Pengiriman' 					=> route('backend.data.shipment.index'),
										'Edit '.$shipment->receipt_number 	=> route('backend.data.shipment.edit', $id),
									];

			$title 				= $shipment->receipt_number;
		}

		$this->layout->page 	= view('pages.backend.data.shipment.create')
									->with('WT_pagetitle', $this->view_name )
									->with('WT_pageSubTitle',$title)
									->with('WB_breadcrumbs', $breadcrumb)
									->with('id', $id)
									->with('shipment', $shipment)
									->with('nav_active', 'data')
									->with('subnav_active', 'shipment');
		return $this->layout;
	}

	public function edit($id)
	{
		return $this->create($id);
	}
	
	public function store($id = null)
	{
		$inputs 				= Input::only('receipt_number');
		
		if(!is_null($id))
		{
			$data				= Shipment::find($id);
		}
		else
		{
			$data				= new Shipment;
		}

		$data->fill([
			'receipt_number' 	=> $inputs['receipt_number'],
		]);

		DB::beginTransaction();

		$errors 				= new MessageBag();

		if(!$data->save())
		{
			$errors->add('Shipment', $data->getError());
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
		
			return Redirect::route('backend.data.shipment.index')
							->with('msg', 'Resi Pengiriman sudah disimpan. Kembali ke <a href="'.route('backend.home').'"> Home </a>')
							->with('msg-type', 'success');
		}
	}

	public function Update($id)
	{
		return $this->store($id);
	}

	public function destroy($id)
	{
		$data					= Shipment::findorfail($id);
		
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
			
			return Redirect::route('backend.data.shipment.index')
							->with('msg', 'Resi Pengiriman sudah dihapus')
							->with('msg-type','success');
		}
	}
}