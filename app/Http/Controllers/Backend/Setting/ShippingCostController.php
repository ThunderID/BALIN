<?php namespace App\Http\Controllers\Backend\Setting;
use App\Http\Controllers\baseController;

use App\Models\ShippingCost;
use App\Models\Courier;

use Illuminate\Support\MessageBag;
use Input, Session, DB, Redirect, Carbon;

class ShippingCostController extends baseController 
{

    /**
     * Instantiate a new UserController instance.
     */
    
    public function __construct()
    {
        $this->middleware('passwordneeded', ['only' => ['destroy']]);

    	parent::__construct();
    }

	protected $view_name 								= 'Ongkos Kirim';

	public function index()
	{
		return Redirect::back();
	}

	public function create($cou_id = null, $id = null)
	{
		$courier 										= Courier::findorfail($cou_id);

		
		$breadcrumb										= 	[	
																$courier->name 	=> route('backend.settings.courier.show', $cou_id),
																'Ongkos Kirim' 	=> route('backend.settings.shippingCost.index', ['cou_id', $cou_id])
															];

		if($id) 
		{	
			$breadcrumb['Edit'] 						= route('backend.settings.shippingCost.edit', [$id, 'cou_id' => $cou_id]);

			$title 										= 	'Edit';
		}
		else
		{
			$breadcrumb['Baru'] 						= route('backend.settings.shippingCost.create', [$id, 'cou_id' => $cou_id]);

			$title 										= 	'Baru';
		}

		$this->layout->page 							= view('pages.backend.settings.shippingCost.create')
																->with('WT_pagetitle', $this->view_name )
																->with('WT_pageSubTitle', $title)		
																->with('WB_breadcrumbs', $breadcrumb)
																->with('id', $id)
																->with('courier', $courier)
																->with('cou_id', $cou_id)
																->with('nav_active', 'settings')
																->with('subnav_active', 'courier');

		return $this->layout;		
	}


	public function show($cou_id, $id)
	{
		return Redirect::back();
	}	

	public function edit($cou_id, $id)
	{
		return $this->create($cou_id, $id);
	}	

	public function store($cou_id = null, $id = null)
	{
		$cou_id 										= Input::get('courier_id');

		$inputs 										= Input::only('courier_id','start_postal_code','end_postal_code','cost','date','time');

		if (Input::get('id'))
		{
			$data 										= ShippingCost::findorfail(Input::get('id'));
		}
		else
		{
			$data 										= new ShippingCost;	
		}

		$started_at 									= Carbon::createFromFormat('Y-m-d', $inputs['date'])->format('Y-m-d').' '.Carbon::createFromFormat('H:i', $inputs['time'])->format('H:i:s');

		$data->fill([
			'courier_id' 								=> $inputs['courier_id'],
			'start_postal_code' 						=> $inputs['start_postal_code'],
			'end_postal_code' 							=> $inputs['end_postal_code'],
			'cost' 										=> $inputs['cost'],
			'started_at'								=> $started_at,
		]);

		DB::beginTransaction();

		if (!$data->save())
		{
			DB::rollback();
			
			return Redirect::back()
					->withErrors($data->getError())
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
		$data 								= ShippingCost::findorfail($id);

		$cou_id 							= Input::get('cou_id');

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

	public function Update($cou_id, $id)
	{
		return $this->store($cou_id, $id);		
	}

}