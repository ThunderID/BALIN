<?php namespace App\Http\Controllers\Backend\Data\Product;

use App\Http\Controllers\BaseController;
use App\Models\Price;
use App\Models\Product;
use Input, Session, DB, Redirect, Response, Carbon, App;

class PriceController extends BaseController 
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

	public function index($pid = null, $id = null)
	{
		$product 								= Product::findorfail($pid);


		$breadcrumb								= 	[	'Data Produk' 			=> route('backend.data.product.index'),
														$product['name']		=> route('backend.data.product.show', ['pid' => $pid]),
														'Histori Harga' 		=> route('backend.data.product.price.index', ['pid' => $pid])
													];

		$filters 								= Null;

		if (Input::has('q'))
		{
			$filters							= ['ondate' => Input::get('q')];

			$searchResult						= date('d-m-Y', strtotime(Input::get('q')));
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
														->with('pid', $pid)
														->with('searchResult', $searchResult)
														->with('nav_active', 'data')
														->with('subnav_active', 'products');

		return $this->layout;
	}

	public function show($id)
	{
		return Redirect::back();
	}

	public function create($pid = null, $id = null)
	{
		$product 								= Product::findorfail($pid);


		$breadcrumb								= 	[	'Data Produk' 			=> route('backend.data.product.index'),
														$product['name']		=> route('backend.data.product.show', ['pid' => $pid]),
														'Histori Harga' 		=> route('backend.data.product.price.index', ['pid' => $pid])
													];

		if ($id)
		{
			$breadcrumb['Edit Harga'] 			= route('backend.data.product.price.edit', ['id' => $id, 'pid' => $pid]);
 
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
														->with('pid', $pid)
														->with('nav_active', 'data')
														->with('subnav_active', 'products');
		return $this->layout;		
	}

	public function edit($pid = null, $id = null)
	{
		return $this->create($pid, $id);
	}

	public function store($pid = null, $id = null)
	{
		$inputs 								= Input::only('price', 'promo_price', 'start_at', 'time', 'label');
		
		if ($id)
		{
			$data								= Price::find($id);
		}
		else
		{
			$data 								= new Price;
		}


		$in_price  								=	str_replace('IDR ', '', str_replace('.', '', Input::get('price')));
		$in_promo_price  						=	str_replace('IDR ', '', str_replace('.', '', Input::get('promo_price')));
		$date 									= 	date('Y-m-d H:i:s', strtotime(Input::get('start_at')));

		$data->fill([
			'product_id'						=> $pid,
			'price' 							=> $in_price,
			'promo_price'						=> $in_promo_price,
			'started_at' 						=> $date,
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

			return Redirect::route('backend.data.product.price.index', ['pid' => $pid])
				->with('msg','Histori harga sudah disimpan')
				->with('msg-type', 'success');
		}
	}

	public function Update($pid = null, $id = null)
	{
		return $this->store($pid, $id);		
	}

	public function destroy($pid = null, $id = null)
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

			return Redirect::route('backend.data.product.price.index', ['pid' => $pid])
				->with('msg', 'Harga telah dihapus')
				->with('msg-type','success');
		}
	}
}