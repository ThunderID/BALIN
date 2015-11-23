<?php namespace App\Http\Controllers\Backend\Setting;

use App\Http\Controllers\BaseController;
use Illuminate\Support\MessageBag;
use App\Models\Voucher;
use App\Models\User;
use App\Models\StoreSetting;
use App\Jobs\Mailman;
use Input, Session, DB, Redirect, Response, Carbon;

class VoucherController extends BaseController 
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
			$filters 								= ['code' => Input::get('q')];
			
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

		if($voucher->user()->count())
		{
			$title 									= 'Voucher Referral '.$voucher->user->name;
			if($voucher->user->role=='customer')
			{
				$url 								= route('backend.data.customer.show', $voucher->user->id);
			}
			else
			{
				$url 								= route('backend.settings.authentication.show', $voucher->user->id);
			}
		}
		else
		{
			$title 									= 'Voucher';
			$url 									= route('backend.settings.voucher.show', $id);
		}

		$breadcrumb									= 	[	
															'Pengaturan Voucher' 	=> route('backend.settings.voucher.index'),
															$title 					=> $url,
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
																		->with('WT_pagetitle', $title )
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
															'Baru'							=> route('backend.settings.voucher.create'),
														];

			$title 									= 'Baru';
		}
		else
		{
			$voucher 								= Voucher::findorfail($id);

			if($voucher->user()->count())
			{
				$title 									= 'Voucher Referral '.$voucher->user->name;
				if($voucher->user->role=='customer')
				{
					$url 								= route('backend.data.customer.show', $voucher->user->id);
				}
				else
				{
					$url 								= route('backend.settings.authentication.show', $voucher->user->id);
				}
			}
			else
			{
				$title 									= $voucher->code;
				$url 									= route('backend.settings.voucher.show', $id);
			}

			$breadcrumb								= 	[
															'Pengaturan Voucher' 			=> route('backend.settings.voucher.index'),
															'Edit '.$title 					=> $url,
														];

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
		$inputs 										= Input::only('code', 'type', 'value');

		if(!is_null($id))
		{
			$data										= Voucher::find($id);
		}
		else
		{
			$data										= new Voucher;
		}

		if(Input::has('started_at') && Input::has('expired_at'))
		{
			$started_at 								= Carbon::createFromFormat('d-m-Y H:i', Input::get('started_at'))->format('Y-m-d H:i:s');
			$expired_at 								= Carbon::createFromFormat('d-m-Y H:i', Input::get('expired_at'))->format('Y-m-d H:i:s');
		}
		else
		{
			$started_at 								= null;
			$expired_at 								= null;
		}

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

	public function getmail($id)
	{
		$voucher 									= Voucher::findorfail($id);

		$title 										= 'Voucher';
		$url 										= route('backend.settings.voucher.show', $id);

		$breadcrumb									= 	[	
															'Pengaturan Voucher' 	=> route('backend.settings.voucher.index'),
															$title 					=> $url,
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

		$this->layout->page 							= view('pages.backend.settings.voucher.mail')
																		->with('WT_pagetitle', $title )
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

	public function postmail($id)
	{
		$voucher 									= Voucher::findorfail($id);

		$inputs 									= Input::only('customer', 'description');

		$custids									= explode(',', $inputs['customer']);

		$users 										= User::id($custids)->get();

        $info           							= StoreSetting::storeinfo(true)->take(8)->get();
        $infos          							= [];

        foreach ($info as $key => $value) 
        {
            $infos[$value->type]   				 	= $value->value;
        }

        foreach ($users as $key => $value) 
        {
			$datas         							= ['user' => (array)$value['attributes'], 'balin' => $infos, 'content' => $inputs['description']];

	        $mail_data      						= [
								                           'view'          => 'emails.voucher', 
								                           'datas'         => $datas, 
								                           'dest_email'    => $value['email'], 
								                           'dest_name'     => $value['name'], 
								                           'subject'       => 'Promo Voucher', 
								                       ];   

	        // call email send job
	        $this->dispatch(new Mailman($mail_data));
        }

        return Redirect::route('backend.settings.voucher.index', $id);
	}
}