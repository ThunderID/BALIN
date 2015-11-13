<?php namespace App\Http\Controllers\Backend\Setting;
use App\Http\Controllers\BaseController;

use App\Models\QuotaLog;
use App\Models\Voucher;

use Illuminate\Support\MessageBag;
use Input, Session, DB, Redirect, Carbon;

class QuotaController extends BaseController 
{

    /**
     * Instantiate a new UserController instance.
     */
    
    public function __construct()
    {
        $this->middleware('passwordneeded', ['only' => ['destroy']]);

    	parent::__construct();
    }

	protected $view_name 								= 'Quota';

	public function index($vou_id = null)
	{
		$voucher 										= Voucher::findorfail($vou_id);

		if($voucher->user()->count())
		{
			$title 										= 'Voucher '.$voucher->user->name;
			if($voucher->user->role=='customer')
			{
				$url 									= route('backend.data.customer.show', $voucher->user->id);
			}
			else
			{
				$url 									= route('backend.settings.authentication.show', $voucher->user->id);
			}
		}
		else
		{
			$title 										= $voucher->code;
			$url 										= route('backend.settings.voucher.show', $vou_id);
		}

		$breadcrumb										= 	[	
																$title 			=> $url,
																'Quota' 		=> route('backend.settings.quota.index', ['vou_id', $vou_id])
															];


		$this->layout->page 							= view('pages.backend.settings.quota.index')
																->with('WT_pagetitle', $this->view_name )
																->with('WT_pageSubTitle', $title)		
																->with('WB_breadcrumbs', $breadcrumb)
																->with('voucher', $voucher)
																->with('vou_id', $vou_id)
																->with('nav_active', 'settings')
																->with('subnav_active', 'voucher');

		return $this->layout;
	}

	public function create($vou_id = null, $id = null)
	{
		$voucher 										= Voucher::findorfail($vou_id);

		if($voucher->user()->count())
		{
			$title 										= 'Voucher '.$voucher->user->name;
		}
		else
		{
			$title 										= $voucher->code;
		}

		$breadcrumb										= 	[	
																$title 		=> route('backend.settings.voucher.show', $vou_id),
																'Quota' 	=> route('backend.settings.quota.index', ['vou_id', $vou_id])
															];

		if($id) 
		{	
			$breadcrumb['Edit'] 						= route('backend.settings.quota.edit', [$id, 'vou_id' => $vou_id]);

			$title 										= 	'Edit';
		}
		else
		{
			$breadcrumb['Baru'] 						= route('backend.settings.quota.create', [$id, 'vou_id' => $vou_id]);

			$title 										= 	'Baru';
		}

		$this->layout->page 							= view('pages.backend.settings.quota.create')
																->with('WT_pagetitle', $this->view_name )
																->with('WT_pageSubTitle', $title)		
																->with('WB_breadcrumbs', $breadcrumb)
																->with('id', $id)
																->with('voucher', $voucher)
																->with('vou_id', $vou_id)
																->with('nav_active', 'settings')
																->with('subnav_active', 'voucher');

		return $this->layout;
	}


	public function show($vou_id, $id)
	{
		return Redirect::back();
	}	

	public function edit($vou_id, $id)
	{
		return $this->create($vou_id, $id);
	}	

	public function store($vou_id = null, $id = null)
	{
		$vou_id 										= Input::get('voucher_id');

		$inputs 										= Input::only('voucher_id','amount','notes');

		if (!is_null($id))
		{
			$data 										= QuotaLog::findorfail($id);
		}
		else
		{
			$data 										= new QuotaLog;	
		}


		$data->fill([
			'voucher_id' 								=> $inputs['voucher_id'],
			'amount' 									=> $inputs['amount'],
			'notes' 									=> $inputs['notes'],
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

			return Redirect::route('backend.settings.quota.index', ['vou_id' => $vou_id])
					->with('msg','Data sudah disimpan')
					->with('msg-type', 'success')
					;
		}
	}

	public function destroy($vou_id = null, $id = null)
	{
		$data 								= QuotaLog::findorfail($id);

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

			return Redirect::route('backend.settings.quota.index', ['vou_id' => $vou_id])
				->with('msg', 'Quota telah dihapus')
				->with('msg-type','success');
		}
	}	

	public function Update($vou_id, $id)
	{
		return $this->store($vou_id, $id);		
	}

}