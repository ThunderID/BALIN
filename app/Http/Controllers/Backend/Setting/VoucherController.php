<?php namespace App\Http\Controllers\Backend\Setting;

use App\Http\Controllers\baseController;
use Illuminate\Support\MessageBag;
use App\Models\Voucher;
use App\Models\Address;
use App\Models\Image;
use Input, Session, DB, Redirect, Response, Carbon;

class VoucherController extends baseController 
{
    /**
     * Instantiate a new VoucherController instance.
     */
    
    public function __construct()
    {
        $this->middleware('passwordneeded', ['only' => ['destroy']]);

    	parent::__construct();
    }

	protected $view_name 							= 'Voucher';

	public function index()
	{		
		$breadcrumb									= 	[
															'Pengaturan Voucher' => route('backend.settings.voucher.index')
														];

		$filters 									= null;

		if(Input::has('q'))
		{
			$filters 								= ['name' => Input::get('q')];
			
			$searchResult							= Input::get('q');
		}
		else
		{
			$searchResult							= null;
		}

		$this->layout->page 						= view('pages.backend.settings.voucher.index')
																	->with('WT_pagetitle', $this->view_name )
																	->with('WT_pageSubTitle','Index')
																	->with('WB_breadcrumbs', $breadcrumb)
																	->with('nav_active', 'settings')
																	->with('filters', $filters)
																	->with('searchResult', $searchResult)
																	->with('subnav_active', 'voucher');
		return $this->layout;		
	}

	public function show($id)
	{
		$voucher 									= Voucher::findorfail($id);

		$breadcrumb									= 	[
															'Pengaturan Voucher' 	=> route('backend.settings.voucher.index'),
															$voucher->code 			=> route('backend.settings.voucher.show', $id),
														];

		$filters 									= null;

		if(Input::has('q'))
		{
			$filters 								= ['code' => Input::get('q')];
			
			$searchResult							= Input::get('q');
		}
		else
		{
			$searchResult							= null;
		}

		$this->layout->page 							= view('pages.backend.settings.voucher.show')
																		->with('WT_pagetitle', $this->view_name )
																		->with('WT_pageSubTitle',$voucher->code)
																		->with('WB_breadcrumbs', $breadcrumb)
																		->with('searchResult', $searchResult)
																		->with('id', $id)
																		->with('Voucher', $voucher)
																		->with('filters', $filters)
																		->with('nav_active', 'settings')
																		->with('subnav_active', 'voucher')
																		;

		return $this->layout;
	}


	public function create($id = null)
	{
		if (is_null($id))
		{
			$voucher 								= new Voucher;

			$breadcrumb								= 	[
															'Pengaturan Voucher' 			=> route('backend.settings.voucher.index'),
															'Baru'						=> route('backend.settings.voucher.create'),
														];

			$title 									= 'Baru';
		}
		else
		{
			$voucher 								= Voucher::findorfail($id);

			$breadcrumb								= 	[
															'Pengaturan Voucher' 			=> route('backend.settings.voucher.index'),
															'Edit '.$voucher->code 		=> route('backend.settings.voucher.edit', $id),
														];

			$title 									= $voucher->code;
		}

		$this->layout->page 						= view('pages.backend.settings.voucher.create')
																	->with('WT_pagetitle', $this->view_name )
																	->with('WT_pageSubTitle',$title)		
																	->with('WB_breadcrumbs', $breadcrumb)
																	->with('id', $id)
																	->with('Voucher', $voucher)
																	->with('nav_active', 'settings')
																	->with('subnav_active', 'voucher');
		return $this->layout;		
	}

	public function edit($id)
	{
		return $this->create($id);
	}

	public function store($id = null)
	{
		$inputs 										= Input::only('code', 'started_at', 'expired_at', 'type', 'value');

		if(!is_null($id))
		{
			$data										= Voucher::find($id);
		}
		else
		{
			$data										= new Voucher;
		}

		$started_at 									= Carbon::createFromFormat('Y-m-d', $inputs['started_at'])->format('Y-m-d H:i:s');
		$expired_at 									= Carbon::createFromFormat('Y-m-d', $inputs['expired_at'])->format('Y-m-d H:i:s');

		$data->fill([
			'code' 										=> $inputs['code'],
			'type' 										=> $inputs['type'],
			'value' 									=> $inputs['value'],
			'started_at' 								=> $started_at,
			'expired_at' 								=> $expired_at,
		]);


		DB::beginTransaction();
		
		$errors 										= new MessageBag();

		if(!$data->save())
		{
			$errors->add('Voucher', $data->getError());
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

			return Redirect::route('backend.settings.voucher.index')
								->with('msg', 'Voucher sudah disimpan')
								->with('msg-type', 'success');
		}	
	}

	public function Update($id)
	{
		return $this->store($id);		
	}

	public function destroy($id)
	{
		$data											= Voucher::findorfail($id);

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

			return Redirect::route('backend.settings.voucher.index')
				->with('msg', 'Voucher sudah dihapus')
				->with('msg-type','success');
		}
	}
}