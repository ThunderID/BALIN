<?php namespace App\Http\Controllers\Backend\Data\Product;

use App\Http\Controllers\baseController;
use App\Models\Price;
use App\Models\Product;
use Input, Session, DB, Redirect, Response;

class PriceController extends baseController 
{
	protected $view_name 						= 'Price';

	public function index()
	{		
		$breadcrumb								= ['Harga' => 'backend.data.product.price.index'];

		$filters 								= Null;
		
		if (Input::has('q'))
		{
		// 	$datas 								= product::FindProduct(Input::get('q'))
		// 											->where('deleted_at',null)
		// 											->with(['price'=> function($q){$q->LatestPrice();}])
		// 											->paginate(); 
			$searchResult						= Input::get('q');
		}
		else
		{
		// 	$datas								= product::with(['price'=> function($q){$q->LatestPrice();}])
		// 											->paginate(); 
			$searchResult						= NULL;
		}

		if (Input::has('product_id'))
		{
			$product_id 						= Input::get('product_id');
		}
		else
		{
			$product_id							= Null;
		}

		$this->layout->page 					= view('pages.backend.data.product.price.index')
														->with('WT_pageTitle', $this->view_name )
														->with('WT_pageSubTitle','Index')
														->with('WB_breadcrumbs', $breadcrumb)
														->with('filters', $filters)
														->with('searchResult', $searchResult)
														->with('product_id', $product_id)
														->with('nav_active', 'data')
														->with('subnav_active', 'products');

		return $this->layout;
	}

	public function create($id = null)
	{

		if ($id)
		{
			$breadcrumb							= ['Harga' => 'backend.data.product.price.index',
														'Edit Harga' => 'backend.data.product.price.create'];
		}
		else
		{
			$breadcrumb							= ['Harga' => 'backend.data.product.price.index',
														'Harga Baru' => 'backend.data.product.price.create'];
		}

		$product_id								= Null;

		if (Input::has('product_id'))
		{
			$product_id 						= Input::get('product_id');
		}

		$this->layout->page 					= view('pages.backend.data.product.price.create')
														->with('WT_pageTitle', $this->view_name )
														->with('WT_pageSubTitle','Create')		
														->with('WB_breadcrumbs', $breadcrumb)
														->with('id', $id)
														->with('product_id', $product_id)
														->with('nav_active', 'data')
														->with('subnav_active', 'product');
		return $this->layout;		
	}

	public function edit($id)
	{
		return $this->create($id);
	}

	public function store($id = null)
	{
		$inputs 								= Input::only('product_id','price', 'promo_price', 'started_at', 'label');
	
		$data 									= new price;

		$data->fill([
			'price' 							=> $inputs['price'],
			'promo_price'					=> $inputs['promo_price'],
			'started_at' 					=> $inputs['started_at'],
			'label'							=> $inputs['label'],
		]);

		$data->product()->associate($inputs['product_id']);

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
			return Redirect::route('backend.data.product.price.index')
				->with('msg','Data sudah ditambahkan')
				->with('msg-type', 'success');
		}
	}

	public function destroy($id)
	{
		if (Input::get('password'))
		{
			$data 					= Price::find($id);

			if (count($data) == 0)
			{
				return Redirect::back()
					->withErrors('Data not exist')
					->with('msg-type','danger');
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
				return Redirect::route('backend.data.product.price.index')
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