<?php namespace App\Http\Controllers\Backend;

use App\Http\Controllers\baseController;
use App\Models\product;
use App\Models\attribute;
use Input, Session, DB, Redirect;

class productController extends baseController 
{
	protected $view_name 						= 'Product';

	public function index()
	{	
		$breadcrumb								= ['Produk' => 'backend.product.index'];

		if ($search = Input::get('q'))
		{
			$datas 								= product::where('deleted_at',null)
													->FindProduct(Input::get('q'))
													->paginate()
													; 
			$searchResult						= $search;
		}
		else
		{
			$searchResult						= NULL;
		}

		$this->layout->page 					= view('pages.backend.product.index')
													->with('WT_pageTitle', $this->view_name )
													->with('WT_pageSubTitle','Index')
													->with('WB_breadcrumbs', $breadcrumb)
													->with('searchResult', $searchResult)
													->with('nav_active', 'product')
													->with('subnav_active', 'product')
													;

		return $this->layout;		
	}

	public function create($id = null)
	{
		if ($id) 
		{
			$breadcrumb							= [	'Kategori' => 'backend.product.index',
													'Data Baru' => 'backend.product.create',
													];
			$title 								= 'Edit';
			$data 								= product::where('id', $id)
													->with('_attributes')
													->with(['categories'=> function($q){$q->GetName();}])
													->first();
			if (count($data) == 0)
			{
				\App::abort(404);
			}	
		}
		else
		{
			$breadcrumb							= [ 'Kategori' => 'backend.product.index',
													'Edit Data' => 'backend.product.create',
													];
			$title 								= 'Create';
			$data								= NULL;
		}

		$this->layout->page 					= view('pages.backend.product.create')
													->with('WT_pageTitle', $this->view_name )
													->with('WT_pageSubTitle', $title)		
													->with('WB_breadcrumbs', $breadcrumb)
													->with('data', $data)
													;

		return $this->layout;		
	}

	public function edit($id)
	{
		return $this->create($id);		
	}

	public function store($id = null)
	{
		$inputs 								= Input::only('id','category','name','sku','description','attribute','value');

		if ($id)
		{
			$data 								= product::find($id);
		}
		else
		{
			$data 								= new product;	
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
				return Redirect::route('backend.product.index')
					->with('msg','Data sudah diperbarui')
					->with('msg-type', 'success')
					;
			}
			else
			{
				return Redirect::route('backend.product.index')
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
				return Redirect::route('backend.product.index')
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