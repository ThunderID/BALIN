<?php namespace App\Http\Controllers\Backend;

use App\Http\Controllers\baseController;
use Models\product;
use Models\attribute;
use Input, Session, DB, Redirect;

class productController extends baseController 
{
	protected $view_name 						= 'Product';

	public function index()
	{	
		$breadcrumb								= array(
													'Produk' => 'backend.product.index',
													);

		if($search = Input::get('q'))
		{
			$datas 								= product::where('deleted_at',null)
													->FindProduct(Input::get('q'))
													->paginate()
													; 
			$searchResult						= $search;
		}
		else
		{
			$datas								= product::paginate();
			$searchResult						= NULL;
		}

		$this->layout->page 					= view('pages.backend.product.index')
													->with('WT_pageTitle', $this->view_name )
													->with('WT_pageSubTitle','Index')
													->with('WB_breadcrumbs', $breadcrumb)
													->with('datas', $datas)
													->with('searchResult', $searchResult)
													;

		return $this->layout;		
	}

	public function create()
	{
		$breadcrumb								= array(
													'Kategori' => 'backend.product.index',
													'Data Baru' => 'backend.product.create',
													 );

		$data									= NULL;


		$this->layout->page 					= view('pages.backend.product.create')
													->with('WT_pageTitle', $this->view_name )
													->with('WT_pageSubTitle','Create')		
													->with('WB_breadcrumbs', $breadcrumb)
													->with('data', $data)
													;

		return $this->layout;		
	}

	public function edit()
	{
		$breadcrumb								= array(
													'Kategori' => 'backend.product.index',
													'Edit Data' => 'backend.product.create',
													 );

		$data									= product::where('id', Input::get('id'))
													->with('_attributes')
													->with(['categories'=> function($q){$q->GetName();}])
													->first()
													;

		if(count($data) == 0)
		{
			App::abort(404);
		}													

		$this->layout->page 					= view('pages.backend.product.create')
													->with('WT_pageTitle', $this->view_name )
													->with('WT_pageSubTitle','Edit')		
													->with('WB_breadcrumbs', $breadcrumb)
													->with('data', $data)
													;

		return $this->layout;		
	}



	public function save()
	{
		$inputs 								= Input::only('id','category','name','sku','description','attribute','value');

		if(Input::get('id'))
		{
			$data 								= product::find(Input::get('id'));
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
		}else{
			// category
			$categories 						= explode(',', $inputs['category']);

			$data->categories()->sync($categories);

			// attributes
			$attributes						= attribute::where('product_id',$data['id'])
												->get()
												;

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
							->with('msg-type', 'danger')
							;
					}
				}
			}						

			DB::commit();
			if(Input::get('id'))
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

	public function delete()
	{
		if(Input::get('password'))
		{
			$data 								= product::find(Input::get('id'));

			if(count($data) == 0)
			{
				return Redirect::back()
					->withErrors('Data not exist')
					->with('msg-type','danger')
					;
			}

			DB::beginTransaction();

			if(!$data->delete())
			{
				DB::rollback();
				return Redirect::back()
					->withErrors($data->getError())
					->with('msg-type','danger')
					;
			}
			else
			{
				DB::commit();
				return Redirect::route('backend.product.index')
					->with('msg', 'Data telah dihapus')
					->with('msg-type','success')
					;
			}
		}
		else
		{
			return Redirect::back()
					->withErrors('Password tidak valid')
					->with('msg-type', 'danger')
					;
		}

	}

	public function generateSlug()
	{
		$result = "abc";
	    return $result;
	}	

	public function getProductBySku()
	{
	    $inputs = Input::only('name');
	    
	    $tmp =  product::select(array('id', 'sku', 'name'))
	    		->where('sku', 'like', "%" . $inputs['name'] . "%")
	    		->get();
	    		
	    return json_decode(json_encode($tmp));
	}	
}