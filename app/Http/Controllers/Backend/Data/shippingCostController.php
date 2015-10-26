<?php namespace App\Http\Controllers\Backend\Data;
use App\Http\Controllers\baseController;

use App\Models\shippingCost;

use Illuminate\Support\MessageBag;
use Input, Session, DB, Redirect;

class shippingCostController extends baseController 
{
	protected $view_name 						= 'Ongkos Kirim';

	public function index()
	{
		$breadcrumb								= [
													'Ongkos Kirim' => 'backend.data.shippingCost.index',
													];

		if (Input::get('q'))
		{
			$searchResult						= Input::get('q');
		}
		else
		{
			$searchResult						= NULL;
		}

		$this->layout->page 					= view('pages.backend.data.shippingCost.index')
														->with('WT_pageTitle', $this->view_name )
														->with('WT_pageSubTitle','Ongkos Kirim')
														->with('WB_breadcrumbs', $breadcrumb)
														->with('searchResult', $searchResult)
														->with('nav_active', 'data')
														->with('subnav_active', 'shippingcost');
		return $this->layout;	
	}

	public function create($id = null)
	{
		if($id) 
		{
		$breadcrumb										= 	[	'Ongkos Kirim' => 'backend.data.shippingCost.index',
																'Edit Data' => 'backend.data.shippingCost.index'
															];

			$title 										= 	'Edit';
		}
		else
		{
			$breadcrumb									= 	[	'Ongkos Kirim' => 'backend.data.shippingCost.index',
																'Data Baru' => 'backend.data.shippingCost.index'
															];

			$title 										= 	'Create';
		}

		$this->layout->page 							= view('pages.backend.data.shippingCost.create')
																->with('WT_pageTitle', $this->view_name )
																->with('WT_pageSubTitle', $title)		
																->with('WB_breadcrumbs', $breadcrumb)
																->with('id', $id)
																->with('nav_active', 'data')
																->with('subnav_active', 'shippingcost');

		return $this->layout;		
	}

	public function edit($id)
	{
		return $this->create($id);		
	}	

	public function store($id = null)
	{
		$inputs 										= Input::only('courier_id','start_postal_code','end_postal_code','cost');

		if ($id)
		{
			$data 										= shippingcost::find($id);
		}
		else
		{
			$data 										= new shippingcost;	
		}

		$data->fill([
			'courier_id' 								=> $inputs['courier_id'],
			'start_postal_code' 						=> $inputs['start_postal_code'],
			'end_postal_code' 							=> $inputs['end_postal_code'],
			'cost' 										=> $inputs['cost'],
		]);

		$errors 										= new MessageBag();

		DB::beginTransaction();

		if (!$data->save())
		{
			DB::rollback();
			
			return Redirect::route('backend.data.shippingCost.index')
					->withErrors($errors)
					->with('msg-type', 'danger')
					;
		}
		else
		{
			DB::commit();

			return Redirect::route('backend.data.shippingCost.index')
					->with('msg','Produk sudah disimpan')
					->with('msg-type', 'success')
					;
		}
	}

	public function destroy($id)
	{
		$data 								= shippingCost::findorfail($id);

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

			return Redirect::route('backend.data.shippingCost.index')
				->with('msg', 'Produk telah dihapus')
				->with('msg-type','success');
		}
	}	

	public function Update($id)
	{
		return $this->store($id);		
	}

}