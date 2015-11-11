<?php namespace App\Http\Controllers\Backend\Data\Product;

use App\Http\Controllers\BaseController;
use App\Models\Varian;
use App\Models\Product;
use Input, Session, DB, Redirect, Response, Carbon, App;

class varianController extends BaseController 
{
	/**
     * Instantiate a new UserController instance.
     */
    
    public function __construct()
    {
        $this->middleware('passwordneeded', ['only' => ['destroy']]);

    	parent::__construct();
    }

	protected $view_name 						= 'Varian';

	public function index()
	{
		return Redirect::back();
	}

	public function show($pid = null, $id = null)
	{
		$product 								= Product::findorfail($pid);
		$varian 								= Varian::findorfail($id);

		$breadcrumb								= 	[	'Data Produk' 					=> route('backend.data.product.index'),
														$product['name']				=> route('backend.data.product.show', ['pid' => $pid]),
														'Ukuran ' .$varian['size']		=> route('backend.data.product.varian.show', ['pid' => $pid, 'id' => $id]),
													];

		$this->layout->page 					= view('pages.backend.data.product.varian.show')
														->with('WT_pagetitle', $this->view_name )
														->with('WT_pageSubTitle', $product->name)		
														->with('WB_breadcrumbs', $breadcrumb)
														->with('id', $id)
														->with('pid', $pid)
														->with('nav_active', 'data')
														->with('subnav_active', 'products');
		return $this->layout;														
	}

	public function create($pid = null, $id = null)
	{
		$product 								= Product::findorfail($pid);


		$breadcrumb								= 	[	'Data Produk' 			=> route('backend.data.product.index'),
														$product['name']		=> route('backend.data.product.show', ['pid' => $pid]),
													];

		if ($id)
		{
			$breadcrumb['Edit Varian'] 			= route('backend.data.product.varian.edit', ['pid' => $pid, 'id' => $id]);
 
			$title 								= 'Edit';
		}
		else
		{
			$breadcrumb['Varian Baru'] 			= route('backend.data.product.varian.create', ['pid' => $pid]);

		
			$title 								= 'Baru';
		}

		$this->layout->page 					= view('pages.backend.data.product.varian.create')
														->with('WT_pagetitle', $this->view_name )
														->with('WT_pageSubTitle',$title)		
														->with('WB_breadcrumbs', $breadcrumb)
														->with('id', $id)
														->with('pid', $pid)
														->with('nav_active', 'data')
														->with('subnav_active', 'products');
		return $this->layout;		
	}

	public function edit($uid = null, $pid = null, $id = null)
	{
		return $this->create($uid, $pid, $id);
	}

	public function store($pid = null, $id = null)
	{
		$inputs 								= Input::only('sku','size');

		product::findorfail($pid);
		
		if ($id)
		{
			$data								= Varian::find($id);
		}
		else
		{
			$data 								= new Varian;
		}

		$data->fill([
			'product_id'						=> $pid,
			'sku' 								=> $inputs['sku'],
			'size'								=> $inputs['size'],
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

			return Redirect::route('backend.data.product.show', ['id' => $pid])
				->with('msg','Histori harga sudah disimpan')
				->with('msg-type', 'success');
		}
	}

	public function Update($uid = null, $pid = null, $id = null)
	{
		return $this->store($uid, $pid, $id);		
	}

	public function destroy($pid = null, $id = null)
	{
		$data 					= varian::findorfail($id);

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

			return Redirect::route('backend.data.product.show', ['id' => $pid])
				->with('msg', 'Harga telah dihapus')
				->with('msg-type','success');
		}
	}
}