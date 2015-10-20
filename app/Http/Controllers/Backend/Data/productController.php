<?php namespace App\Http\Controllers\Backend\Data;

use App\Http\Controllers\baseController;
use Input, Session, DB, Redirect;

class productController extends baseController 
{
	protected $view_name 							= 'Product';

	public function index()
	{	
		$breadcrumb										= ['Produk' => 'backend.data.product.index'];

		if ($search = Input::get('q'))
		{
			$datas 										= product::where('deleted_at',null)
																		->FindProduct(Input::get('q'))
																		->paginate()
																		; 
			$searchResult								= $search;
		}
		else
		{
			$searchResult								= NULL;
		}

		$this->layout->page 							= view('pages.backend.data.product.index')
																		->with('WT_pageTitle', $this->view_name )
																		->with('WT_pageSubTitle','Index')
																		->with('WB_breadcrumbs', $breadcrumb)
																		->with('searchResult', $searchResult)
																		->with('nav_active', 'data')
																		->with('subnav_active', 'products');

		return $this->layout;		
	}

	public function create($id = null)
	{
		if ($id) 
		{
			$breadcrumb									= ['Produk' => 'backend.data.product.index',
																'Edit Data' => 'backend.data.product.create'];

			$title 										= 'Edit';
		}
		else
		{
			$breadcrumb									= ['Produk' => 'backend.data.product.index',
																'Data Baru' => 'backend.data.product.create'];

			$title 										= 'Create';
		}

		$this->layout->page 							= view('pages.backend.data.product.create')
																->with('WT_pageTitle', $this->view_name )
																->with('WT_pageSubTitle', $title)		
																->with('WB_breadcrumbs', $breadcrumb)
																->with('id', $id)
																->with('nav_active', 'data')
																->with('subnav_active', 'products');

		return $this->layout;		
	}

	public function edit($id)
	{
		return $this->create($id);		
	}

	public function show($id)
	{
		$breadcrumb										= ['Produk' => 'backend.data.product.index',
																'Detail' => 'backend.data.product.create',
															];

		if ($search = Input::get('q'))
		{
			$datas 										= product::where('deleted_at',null)
																		->FindProduct(Input::get('q'))
																		->paginate()
																		; 
			$searchResult								= $search;
		}
		else
		{
			$searchResult								= NULL;
		}

		$this->layout->page 							= view('pages.backend.data.product.show')
																		->with('WT_pageTitle', $this->view_name )
																		->with('WT_pageSubTitle','Show')
																		->with('WB_breadcrumbs', $breadcrumb)
																		->with('searchResult', $searchResult)
																		->with('id', $id)
																		->with('nav_active', 'product')
																		->with('subnav_active', 'product')
																		;

		return $this->layout;
	}

	public function store($id = null)
	{
		$inputs 											= Input::only('id','category','name','sku','description','attribute','value');

		if ($inputs['id'])
		{
			$data 										= product::find($id);
		}
		else
		{
			$data 										= new product;	
		}

		$data->fill([
			'name' 								=> $inputs['name'],
			'sku' 								=> $inputs['sku'],
			'slug' 								=> $this->generateSlug(),
			'description' 						=> $inputs['description'],
		]);

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
			// category
			$categories 						= explode(',', $inputs['category']);

			$data->categories()->sync($categories);

			// attributes
			$attributes							= attribute::where('product_id',$data['id'])->get();

			foreach ($attributes as $attribute) 
			{
				if(!$attribute->delete())
				{
					DB::rollback();
					return Redirect::back()
						->withInput()
						->withErrors($attributes->getError())
						->with('msg-type', 'danger')
						;
				}
			}


			for ($i=0; $i < count($inputs['attribute']); $i++) { 
				if($inputs['attribute'][$i] != "" && $inputs['value'][$i] != "" )
				{
					$attribute 				= new attribute;

					$attribute->fill([
						'attribute' 		=> $inputs['attribute'][$i],
						'value' 			=> $inputs['value'][$i],
					]);

					$attribute->product()->associate($data['id']);

					if(!$attribute->save())
					{
						DB::rollback();
						return Redirect::back()
							->withInput()
							->withErrors($attribute->getError())
							->with('msg-type', 'danger');
					}
				}
			}						

			DB::commit();
			if ($id)
			{
				return Redirect::route('backend.data.product.index')
					->with('msg','Data sudah diperbarui')
					->with('msg-type', 'success')
					;
			}
			else
			{
				return Redirect::route('backend.data.product.index')
					->with('msg','Data sudah ditambahkan')
					->with('msg-type', 'success')
					;
			}
		}
	}

	public function destroy($id)
	{
		if (Input::get('password'))
		{
			$data 								= product::find($id);

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
				return Redirect::route('backend.data.product.index')
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

	public function generateSlug()
	{
		$result = "abc";
	    return $result;
	}	

	public function getProductBySKU()
	{
	    $inputs 	= Input::only('name');
	    
	    $tmp 		=  product::select(array('id', 'sku', 'name'))
	    				->where('sku', 'like', "%" . $inputs['name'] . "%")
	    				->get();
	    		
	    return json_decode(json_encode($tmp));
	}	
}