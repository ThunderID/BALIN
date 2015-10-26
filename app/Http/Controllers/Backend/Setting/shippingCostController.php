<?php namespace App\Http\Controllers\Backend\Setting;
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
													'Ongkos Kirim' => 'backend.settings.shippingCost.index',
													];

		if (Input::get('q'))
		{
			$searchResult						= Input::get('q');
		}
		else
		{
			$searchResult						= NULL;
		}

		$this->layout->page 					= view('pages.backend.settings.shippingCost.index')
														->with('WT_pageTitle', $this->view_name )
														->with('WT_pageSubTitle','Ongkos Kirim')
														->with('WB_breadcrumbs', $breadcrumb)
														->with('searchResult', $searchResult)
														->with('nav_active', 'data')
														->with('subnav_active', 'shippingcost');
		return $this->layout;	
	}

	public function create($cou_id = null, $id = null)
	{
		if($id) 
		{
			$breadcrumb									= 	[	'Ongkos Kirim' => 'backend.settings.shippingCost.index',
																'Edit Data' => 'backend.settings.shippingCost.index'
															];

			$title 										= 	'Edit';
		}
		else
		{
			$breadcrumb									= 	[	'Ongkos Kirim' => 'backend.settings.shippingCost.index',
																'Data Baru' => 'backend.settings.shippingCost.index'
															];

			$title 										= 	'Create';
		}

		$this->layout->page 							= view('pages.backend.settings.shippingCost.create')
																->with('WT_pageTitle', $this->view_name )
																->with('WT_pageSubTitle', $title)		
																->with('WB_breadcrumbs', $breadcrumb)
																->with('id', $id)
																->with('cou_id', $cou_id)
																->with('nav_active', 'data')
																->with('subnav_active', 'shippingcost');

		return $this->layout;		
	}

	public function edit($cou_id, $id)
	{
		return $this->create($cou_id, $id);
	}	

	public function store($cou_id = null, $id = null)
	{
		$cou_id 										= Input::get('courier_id');
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
			
			return Redirect::back()
					->withErrors($errors)
					->with('msg-type', 'danger')
					;
		}
		else
		{
			DB::commit();

			return Redirect::route('backend.settings.courier.show', $cou_id)
					->with('msg','Data sudah disimpan')
					->with('msg-type', 'success')
					;
		}
	}

	public function destroy($id)
	{
		$data 								= shippingCost::findorfail($id);

		$cou_id 							= input::get('cou_id');

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

			return Redirect::route('backend.settings.shippingCost.index', $cou_id)
				->with('msg', 'Produk telah dihapus')
				->with('msg-type','success');
		}
	}	

	public function Update($id)
	{
		return $this->store($id);		
	}

}