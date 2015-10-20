<?php namespace App\Http\Controllers\Backend\Setting;

use App\Http\Controllers\baseController;
use App\Models\Courier;
use Input, Session, DB, Redirect, Response;

class courierController extends baseController 
{
	protected $view_name 							= 'Courier';

	public function index()
	{		
		$breadcrumb										= ['Kurir' => 'backend.settings.courier.index'];


		$this->layout->page 							= view('pages.backend.settings.courier.index')
																	->with('WT_pageTitle', $this->view_name )
																	->with('WT_pageSubTitle','Index')
																	->with('WB_breadcrumbs', $breadcrumb)
																	->with('nav_active', 'settings')
																	->with('subnav_active', 'courier');
		return $this->layout;		
	}

	public function show($id)
	{
		
	}


	public function create($id = null)
	{
		if (!$id)
		{
			$breadcrumb									= ['Kurir' => 'backend.settings.courier.index',
																'Kurir Baru' => 'backend.settings.courier.create'];
		}
		else
		{
			$breadcrumb									= ['Kurir' => 'backend.settings.courier.index',
																'Edit Data' => 'backend.settings.courier.create'];
		}

		$this->layout->page 							= view('pages.backend.settings.courier.create')
																	->with('WT_pageTitle', $this->view_name )
																	->with('WT_pageSubTitle','Create')		
																	->with('WB_breadcrumbs', $breadcrumb)
																	->with('id', $id)
																	->with('nav_active', 'settings')
																	->with('subnav_active', 'courier');
		return $this->layout;		
	}

	public function edit($id)
	{

		return $this->create($id);
	}

	public function store($id = null)
	{
		$inputs 								= Input::only('id','name', 'logo_url', 'address');
		
		if ($inputs['id'])
		{
			$data								= Courier::find($inputs['id']);
		}
		else
		{
			$data								= new Courier;
		}

		$data->fill([
			'name' 							=> $inputs['name'],
			'phone' 							=> $inputs['logo_url'],
			'address' 						=> $inputs['address'],
		]);

		DB::beginTransaction();
		if (!$data->save())
		{

			DB::rollback();
			return Redirect::back()
								->withInput()
								->withErrors($data->getError())
								->with('msg-type', 'danger');
		}	
		else
		{
			DB::commit();

			if ($id)
			{
				$msg = "Data sudah diperbarui";
			}
			else
			{
				$msg = "Data sudah ditambahkan";
			}

			return Redirect::route('backend.settings.courier.index')
								->with('msg', $msg)
								->with('msg-type', 'success');
		}	
	}

	public function destroy($id)
	{
		if (Input::get('password'))
		{		
			$data									= Courier::find($id);

			if (count($data) == 0)
			{
				App::abort(404);
			}

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
				return Redirect::route('backend.settings.courier.index')
					->with('msg', 'Data telah dihapus')
					->with('msg-type','success');
			}
		}
		else
		{
			return Redirect::back()
					->withErrors('Password tidak valid')
					->with('msg-type', 'danger');
		}		
	}

}