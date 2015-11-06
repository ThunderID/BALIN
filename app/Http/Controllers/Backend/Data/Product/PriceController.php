<?php namespace App\Http\Controllers\Backend\Data\Product;

use App\Http\Controllers\baseController;
use App\Models\Price;
use App\Models\Product;
use App\Models\Productuniversal;
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

	public function index($uid = null, $pid = null, $id = null)
	{
		$pu										= ProductUniversal::findorfail($uid);								

		$product 								= Product::findorfail($pid);


		$breadcrumb								= 	[	'Data Produk' 			=> route('backend.data.productuniversal.index'),
														$pu['name']				=> route('backend.data.productuniversal.show', ['uid' => $uid ]),
														$product['name']		=> route('backend.data.product.show', ['uid' => $uid, 'pid' => $pid]),
														'Histori Harga' 		=> route('backend.data.product.price.index', ['uid' => $uid, 'pid' => $pid])
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
														->with('pid', $pid)
														->with('uid', $uid)
														->with('searchResult', $searchResult)
														->with('nav_active', 'data')
														->with('subnav_active', 'products');

		return $this->layout;
	}

	public function show($id)
	{
		return Redirect::back();
	}

	public function create($uid = null, $pid = null, $id = null)
	{
		$pu										= ProductUniversal::findorfail($uid);								

		$product 								= Product::findorfail($pid);

		$breadcrumb								= 	[	
														$product->name	=> route('backend.data.product.show', $pid),
													];

		$breadcrumb								= 	[	'Data Produk' 			=> route('backend.data.productuniversal.index'),
														$pu['name']				=> route('backend.data.productuniversal.show', ['uid' => $uid ]),
														$product['name']		=> route('backend.data.product.show', ['uid' => $uid, 'pid' => $pid]),
														'Histori Harga' 		=> route('backend.data.product.price.index', ['uid' => $uid, 'pid' => $pid])
													];

		if ($id)
		{
			$breadcrumb['Edit Harga'] 			= route('backend.data.product.price.edit', ['id' => $id, 'uid' => $uid, 'pid' => $pid]);
 
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
														->with('uid', $uid)
														->with('nav_active', 'data')
														->with('subnav_active', 'products');
		return $this->layout;		
	}

	public function edit($id)
	{
		return $this->create($id);
	}

	public function store($uid = null, $pid = null, $id = null)
	{
		$inputs 								= Input::only('product_id','price', 'promo_price', 'start_at', 'time', 'label');
		
		if ($id)
		{
			$data								= Price::find($id);
		}
		else
		{
			$data 								= new Price;
		}


		$in_price  								=	str_replace('Rp ', '', str_replace('.', '', Input::get('price')));
		$in_promo_price  						=	str_replace('Rp ', '', str_replace('.', '', Input::get('promo_price')));
		$date 									= 	date('Y-m-d H:i:s', strtotime(Input::get('start_at')));

		$data->fill([
			'product_id'						=> $pid,
			'price' 							=> $in_price,
			'promo_price'						=> $in_promo_price,
			'started_at' 						=> $date,
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

			return Redirect::route('backend.data.product.price.index', ['pid' => $pid, 'uid' => $uid])
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