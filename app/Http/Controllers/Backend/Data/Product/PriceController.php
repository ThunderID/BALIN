<?php namespace App\Http\Controllers\Backend\Data\Product;

use App\Http\Controllers\baseController;
use App\Models\Price;
use App\Models\Product;
use Input, Session, DB, Redirect, Response, Carbon, App;

class PriceController extends baseController 
{
	/**
     * Instantiate a new UserController instance.
     */
    
    public function __construct()
    {
        $this->middleware('passwordneeded', ['only' => ['destroy']]);

    	parent::__construct();
    }

	protected $view_name 						= 'Histori Harga';

	public function index()
	{
		if(Input::has('product_id'))
		{
			$product_id 						= Input::get('product_id');

			$product 							= Product::findorfail(Input::get('product_id'));
		}
		else
		{
			App::abort(404);
		}

		$breadcrumb								= 	[	
														$product->name	=> route('backend.data.product.show', $product_id),
														'Histori Harga' => route('backend.data.product.price.index', ['product_id', $product_id])
													];

		$filters 								= Null;
		
		if (Input::has('q'))
		{
			$filters							= ['ondate' => Input::get('q')];

			$searchResult						= Input::get('q');
		}
		else
		{
			$filters							= NULL;

			$searchResult						= NULL;
		}



		$this->layout->page 					= view('pages.backend.data.product.price.index')
														->with('WT_pagetitle', $this->view_name )
														->with('WT_pageSubTitle',$product->name)
														->with('WB_breadcrumbs', $breadcrumb)
														->with('filters', $filters)
														->with('searchResult', $searchResult)
														->with('product_id', $product_id)
														->with('nav_active', 'data')
														->with('subnav_active', 'products');

		return $this->layout;
	}

	public function show($id)
	{
		return Redirect::back();
	}

	public function create($id = null)
	{

		if(Input::has('product_id'))
		{
			$product_id 						= Input::get('product_id');

			$product 							= Product::findorfail(Input::get('product_id'));
		}
		else
		{
			App::abort(404);
		}

		$breadcrumb								= 	[	
														$product->name	=> route('backend.data.product.show', $product_id),
													];


		if ($id)
		{
			$breadcrumb['Edit Harga'] 			= route('backend.data.product.price.edit', $id);

			$title 								= 'Edit';
		}
		else
		{
			$breadcrumb['Harga Baru'] 			= route('backend.data.product.price.create');
		
			$title 								= 'Baru';
		}

		$this->layout->page 					= view('pages.backend.data.product.price.create')
														->with('WT_pagetitle', $this->view_name )
														->with('WT_pageSubTitle',$title)		
														->with('WB_breadcrumbs', $breadcrumb)
														->with('id', $id)
														->with('product_id', $product_id)
														->with('nav_active', 'data')
														->with('subnav_active', 'products');
		return $this->layout;		
	}

	public function edit($id)
	{
		return $this->create($id);
	}

	public function store($id = null)
	{
		$inputs 								= Input::only('product_id','price', 'promo_price', 'date', 'time', 'label');
		dD($inputs);
		if ($id)
		{
			$data								= Price::find($id);
		}
		else
		{
			$data 								= new Price;
		}

		$started_at 							= Carbon::createFromFormat('d-m-Y', $inputs['date'])->format('Y-m-d').' '.Carbon::createFromFormat('H:i', $inputs['time'])->format('H:i:s');

		$data->fill([
			'product_id'						=> $inputs['product_id'],
			'price' 							=> $inputs['price'],
			'promo_price'						=> $inputs['promo_price'],
			'started_at' 						=> $started_at,
			'label'								=> $inputs['label'],
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

			return Redirect::route('backend.data.product.price.index', ['product_id' => $inputs['product_id']])
				->with('msg','Histori harga sudah disimpan')
				->with('msg-type', 'success');
		}
	}

	public function Update($id)
	{
		return $this->store($id);		
	}

	public function destroy($id)
	{
		$data 					= Price::findorfail($id);

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

			return Redirect::route('backend.data.product.price.index', ['product_id' => $data->product_id])
				->with('msg', 'Harga telah dihapus')
				->with('msg-type','success');
		}
	}
}