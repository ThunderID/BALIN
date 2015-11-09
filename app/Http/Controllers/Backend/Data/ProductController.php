<?php namespace App\Http\Controllers\Backend\Data;

use App\Http\Controllers\baseController;
use App\Models\Product;
use App\Models\ProductUniversal;
use App\Models\Price;
use App\Models\Image;
use App\Models\Lable;
use Illuminate\Support\MessageBag;
use Input, Session, DB, Redirect, Str;

class ProductController extends baseController 
{
    /**
     * Instantiate a new UserController instance.
     */
    
    public function __construct()
    {
        $this->middleware('passwordneeded', ['only' => ['destroy']]);

    	parent::__construct();
    }

	protected $view_name 								= 'Varian';


	public function index()
	{	
		$breadcrumb										= ['Data Produk' => route('backend.data.product.index')];
		
		$filters 										= null;

		if(Input::has('q'))
		{
			$filters 									= ['name' => Input::get('q')];
			$searchResult								= Input::get('q');
		}
		else
		{
			$searchResult								= null;
		}

		$this->layout->page 							= view('pages.backend.data.product.index')
																		->with('WT_pagetitle', $this->view_name )
																		->with('WT_pageSubTitle','Index')
																		->with('WB_breadcrumbs', $breadcrumb)
																		->with('filters', $filters)
																		->with('searchResult', $searchResult)
																		->with('nav_active', 'data')
																		->with('subnav_active', 'products');

		return $this->layout;		
	}

	public function create($uid = null, $id = null)
	{
		$pu												= ProductUniversal::findorfail($uid);								

		if($id) 
		{
			$product 									= Product::findorfail($id);

			$breadcrumb									= 	[	'Data Produk' 			=> route('backend.data.productuniversal.index'),
																$pu['name']				=> route('backend.data.productuniversal.show', ['uid' => $pu['id'] ]),
																'Edit '	.$product->name	=> route('backend.data.product.create', ['uid' => $pu['id']] ),
															];															

			$title 										= 	'Edit '.$product->name;
		}
		else
		{
			$product 									= new Product;

			$breadcrumb									= 	[	'Data Produk' 			=> route('backend.data.productuniversal.index'),
																$pu['name']				=> route('backend.data.productuniversal.show', ['uid' => $pu['id'] ]),
																'Varian Baru' 			=> route('backend.data.product.create', ['uid' => $pu['id']] ),
															];

			$title 										= 	'Baru';
		}

		$this->layout->page 							= view('pages.backend.data.product.create')
																->with('WT_pagetitle', $this->view_name )
																->with('WT_pageSubTitle', $title)		
																->with('WB_breadcrumbs', $breadcrumb)
																->with('id', $id)
																->with('uid', $uid)
																->with('nav_active', 'data')
																->with('product', $product)
																->with('subnav_active', 'products');

		return $this->layout;		
	}

	public function edit($uid, $id)
	{
		return $this->create($uid, $id);		
	}

	public function show($uid = null, $id = null)
	{
		$pu												= ProductUniversal::findorfail($uid);								

		$product 										= Product::findorfail($id);


		$breadcrumb										= 	[	'Data Produk' 			=> route('backend.data.productuniversal.index'),
																$pu['name']				=> route('backend.data.productuniversal.show', ['uid' => $pu['id'] ]),
																$product['name']		=> route('backend.data.product.show', ['uid' => $pu['id'], 'id' => $id]),
															];

		if ($search = Input::get('q'))
		{
			$searchResult								= $search;
		}
		else
		{
			$searchResult								= NULL;
		}

		$this->layout->page 							= view('pages.backend.data.product.show')
																		->with('WT_pagetitle', $this->view_name )
																		->with('WT_pageSubTitle', $product->name)
																		->with('WB_breadcrumbs', $breadcrumb)
																		->with('searchResult', $searchResult)
																		->with('id', $id)
																		->with('uid', $uid)
																		->with('nav_active', 'data')
																		->with('subnav_active', 'products')
																		->with('product', $product)
																		;

		return $this->layout;
	}

	public function store($uid = null, $id = null)
	{
		$inputs 										= Input::only('category','name','sku','description','color','size');
		$labels											= Input::only('label');
		$images											= Input::only('thumbnail', 'image_xs', 'image_sm', 'image_md', 'image_lg', 'default');

		if($id)
		{
			$data 										= Product::find($id);
		}
		else
		{
			$data 										= new Product;	
		}

		$pu 											= ProductUniversal::findorfail($uid);

		$data->fill([
			'name' 										=> $inputs['name'],
			'color' 									=> $inputs['color'],
			'size' 										=> $inputs['size'],
			'sku' 										=> $inputs['sku'],
			'slug' 										=> Str::slug($inputs['name'] . $inputs['sku']),
			'description' 								=> $inputs['description'],
		]);


		$data->ProductUniversal()->associate($pu);

		$errors 										= new MessageBag();

		DB::beginTransaction();

		if (!$data->save())
		{
			$errors->add('Product', $data->getError());
		}
		else
		{
			// category
			$categories 								= explode(',', $inputs['category']);

			if(!$data->categories()->sync($categories))
			{
				$errors->add('Product', $data->getError());
			}

			$in_price  			=	str_replace('Rp ', '', str_replace('.', '', Input::get('price')));
			$in_promo_price  	=	str_replace('Rp ', '', str_replace('.', '', Input::get('promo_price')));

			if($data->price != $in_price || $data->promo_price != $in_promo_price)
			{
				$price 									= new Price;
				$price->fill([
					'product_id'						=> $data->id,
					'price'								=> (integer)$in_price,
					'promo_price'						=> (integer)$in_promo_price,
					'started_at'						=> date('Y-m-d H:i:s', strtotime(Input::get('started_at'))),
					'ended_at'							=> null,
					'label'								=> Input::get('label'),
				]);

				if(!$price->save())
				{
					$errors->add('Product', $price->getError());
				}
			}

			//label
			//label clear previous
			$Label 									 	= Lable::where('product_id', $data->id)->get();
			foreach ($Label as $value) {
				if(!$value->delete())
				{
					$errors->add('Product', $value->getError());
				}
			}

			//label save
			if($labels['label'])
			{
				foreach ($labels['label'] as $value) 
				{
					$label 									= new Lable;

					$label->fill([
						'product_id'						=> $data->id,
						'lable'								=> $value,
						'value'								=> 'value',
						'started_at'						=> date('Y-m-d H:i:s'),
					]);

					if(!$label->save())
					{
						$errors->add('Product', $label->getError());
					}
				}
			}

			//save image
			//ref. producttableseeder line 114

			//clear previous images
			$prev_images								= Image::where('imageable_id', $data['id'])->where('imageable_type', 'App\Models\Product')->get();
			foreach ($prev_images as $prev_image) 
			{
				if (!$prev_image->delete())
				{
					$errors->add('Courier', $prev_image->getError());
				}
			}

			//get all images input
			foreach ($images['thumbnail'] as $key => $tmp) 
			{
				//cek apa ada isinya di pointer ini kalo tidak ada ga usah di entri ya
				if(!empty($tmp))
				{
					$image 											= new Image;
					$image->fill([
							'thumbnail'								=> $images['thumbnail'][$key],
							'image_xs'								=> $images['image_xs'][$key],
							'image_sm'								=> $images['image_sm'][$key],
							'image_md'								=> $images['image_md'][$key],
							'image_lg'								=> $images['image_lg'][$key],
							'is_default'							=> $images['default'][$key],
							'published_at'							=> date('Y-m-d H:i:s'),
					]);

					//save

					if (!$image->save())
					{
						$errors->add('Courier', $image->getError());
					}

					$image->imageable()->associate($data);
					
					if (!$image->save())
					{
						$errors->add('Courier', $image->getError());
					}
				}
			}
		}
	
		if ($errors->count())
		{
			DB::rollback();
			
			return Redirect::back()
					->withErrors($errors)
					->with('msg-type', 'danger')
					;
		}
		else
		{
			DB::commit();

			return Redirect::route('backend.data.productuniversal.show', ['uid' => $uid])
					->with('msg','Produk sudah disimpan')
					->with('msg-type', 'success')
					;
		}
	}

	public function Update($uid = null, $id = null)
	{
		return $this->store($uid,$id);		
	}

	public function destroy($uid = null, $id = null)
	{
		$data 								= Product::findorfail($id);

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

			return Redirect::route('backend.data.productuniversal.show', ['uid' => $uid])
				->with('msg', 'Produk telah dihapus')
				->with('msg-type','success');
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

	public function getProductByName()
	{
		$inputs		= Input::only('name');
		$tmp 		= Product::select(['id', 'name'])
								->where('name', 'like', '%'. $inputs['name'].'%')
								->get();

		return json_decode(json_encode($tmp));
	}
}