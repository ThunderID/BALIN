<?php namespace App\Http\Controllers\Backend;

use App\Http\Controllers\baseController;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\Supplier;
use Input, Session, DB, Redirect, Response;

class supplierController extends baseController 
{
	protected $view_name 						= 'Supplier';

	public function index()
	{		
		$product 								= Product::find(1);
		dd($product);
		$transaction 							= Transaction::type('sell')->status('shipped')->first();

		$result = $transaction->save();
		dd($result);
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
			$searchResult						= NULL;
		}

		$this->layout->page 					= view('pages.backend.supplier.index')
													->with('WT_pageTitle', $this->view_name )
													->with('WT_pageSubTitle','Index')
													->with('WB_breadcrumbs', $breadcrumb)
													->with('searchResult', $searchResult)
													->with('nav_active', 'supplier');
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
		}
		else
		{
			$breadcrumb							= [ 'Supplier' => 'backend.supplier.index',
													'Edit Data' => 'backend.supplier.create' ];
		}

		$this->layout->page 					= view('pages.backend.supplier.create')
													->with('WT_pageTitle', $this->view_name )
													->with('WT_pageSubTitle','Create')		
													->with('WB_breadcrumbs', $breadcrumb)
													->with('id', $id)
													->with('nav_active', 'supplier');
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