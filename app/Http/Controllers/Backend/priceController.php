<?php namespace App\Http\Controllers\Backend;

use App\Http\Controllers\baseController;
use Models\price;
use Models\product;
use Input, Session, DB, Redirect, Response;

class priceController extends baseController 
{
	protected $view_name 						= 'Price';

	public function index()
	{		
		$breadcrumb								= array(
													'Harga' => 'backend.price.index',
													);

		if(Input::get('q'))
		{
			$datas 								= product::FindProduct(Input::get('q'))
													->where('deleted_at',null)
													->with(['price'=> function($q){$q->LatestPrice();}])
													->paginate()
													; 
			$searchResult						= Input::get('q');
		}
		else
		{
			$datas								= product::with(['price'=> function($q){$q->LatestPrice();}])
													->paginate()
													; 
			$searchResult						= NULL;
		}


		$this->layout->page 					= view('pages.backend.price.index')
													->with('WT_pageTitle', $this->view_name )
													->with('WT_pageSubTitle','Index')
													->with('WB_breadcrumbs', $breadcrumb)
													->with('datas', $datas)
													->with('searchResult', $searchResult)
													;

		return $this->layout;		
	}

	public function detail()
	{
		
	}


	public function create()
	{
		$breadcrumb								= array(
													'Harga' => 'backend.price.index',
													'Harga Baru' => 'backend.price.create',
													 );

		$data									= NULL;


		$this->layout->page 					= view('pages.backend.price.create')
													->with('WT_pageTitle', $this->view_name )
													->with('WT_pageSubTitle','Create')		
													->with('WB_breadcrumbs', $breadcrumb)
													->with('data', $data)
													;

		return $this->layout;		
	}

	public function edit()
	{
		
	}

	public function save()
	{
		$inputs 								= Input::only('product','price', 'start_date');
	
		$data 									= new price;

		$data->fill([
			'price' 							=> $inputs['price'],
			'start_date' 						=> $inputs['start_date'],
		]);

		$data->product()->associate($inputs['product']);

		DB::beginTransaction();
		if (!$data->save())
		{
			DB::rollback();
			return Redirect::back()
				->withInput()
				->withErrors($data->getError())
				->with('msg-type', 'danger')
				;
		}	
		else
		{
			DB::commit();

			return Redirect::route('backend.price.index')
				->with('msg','Data sudah ditambahkan')
				->with('msg-type', 'success')
				;
		}
	}

	public function delete()
	{
		
	}

}