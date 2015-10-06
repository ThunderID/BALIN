<?php namespace App\Http\Controllers\Backend;

use App\Http\Controllers\baseController;
use Models\supplier;
use Input, Session, DB, Redirect, Response;

class supplierController extends baseController 
{
	protected $view_name 						= 'Supplier';

	public function index()
	{		
		$breadcrumb								= ['Supllier' => 'backend.supplier.index'];

		if (Input::get('q'))
		{
			$datas 								= supplier::where('name','like','%'.Input::get('q').'%')
															->where('deleted_at',null)
															->paginate(); 
			$searchResult						= Input::get('q');
		}
		else
		{
			$datas								= supplier::paginate(); 
			$searchResult						= NULL;
		}

		$this->layout->page 					= view('pages.backend.supplier.index')
													->with('WT_pageTitle', $this->view_name )
													->with('WT_pageSubTitle','Index')
													->with('WB_breadcrumbs', $breadcrumb)
													->with('datas', $datas)
													->with('searchResult', $searchResult);
		return $this->layout;		
	}

	public function show($id)
	{
		
	}


	public function create($id = null)
	{
		if (!$id)
		{
			$breadcrumb							= [	'Supplier' => 'backend.supplier.index',
													'Supplier Baru' => 'backend.supplier.create' ];
			$data								= NULL;
		}
		else
		{
			$breadcrumb							= [ 'Supplier' => 'backend.supplier.index',
													'Edit Data' => 'backend.supplier.create' ];
			$data								= supplier::find($id);

			if (count($data) == 0)
			{
				App::abort(404);
			}
		}

		$this->layout->page 					= view('pages.backend.supplier.create')
													->with('WT_pageTitle', $this->view_name )
													->with('WT_pageSubTitle','Create')		
													->with('WB_breadcrumbs', $breadcrumb)
													->with('data', $data);
		return $this->layout;		
	}

	public function edit($id)
	{

		return $this->create($id);
	}

	public function store($id = null)
	{
		$inputs 								= Input::only('id','name', 'phone', 'address');
	
		if ($id)
		{
			$data								= supplier::find($id);
		}
		else
		{
			$data								= new supplier;
		}

		$data->fill([
			'name' 								=> $inputs['name'],
			'phone' 							=> $inputs['phone'],
			'address' 							=> $inputs['address'],
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

			if(Input::get('id'))
			{
				$msg = "Data sudah diperbarui";
			}
			else
			{
				$msg = "Data sudah ditambahkan";
			}

			return Redirect::route('backend.supplier.index')
				->with('msg',$msg)
				->with('msg-type', 'success');
		}
	}

	public function destroy($id)
	{
		if (Input::get('password'))
		{		
			$data									= supplier::find($id);

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
				return Redirect::route('backend.supplier.index')
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