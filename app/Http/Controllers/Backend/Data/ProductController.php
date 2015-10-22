<?php namespace App\Http\Controllers\Backend\Data;

use App\Http\Controllers\baseController;
use Illuminate\Support\MessageBag;
use Input, Session, DB, Redirect;
use App\Models\Product;

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
		if($id) 
		{
			$breadcrumb									= 	[	'Produk' => 'backend.data.product.index',
																'Edit Data' => 'backend.data.product.create'
																];

			$title 										= 	'Edit';
		}
		else
		{
			$breadcrumb									= 	[	'Produk' => 'backend.data.product.index',
																'Data Baru' => 'backend.data.product.create'
															];

			$title 										= 	'Create';
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
		$breadcrumb										= 	[	'Produk' => 'backend.data.product.index',
																'Detail' => 'backend.data.product.create',
															];

		if ($search = Input::get('q'))
		{
			$datas 										= Product::where('deleted_at',null)
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
		$inputs 										= Input::only('category','name','sku','description');

		if ($id)
		{
			$data 										= Product::find($id);
		}
		else
		{
			$data 										= new Product;	
		}

		$data->fill([
			'name' 										=> $inputs['name'],
			'sku' 										=> $inputs['sku'],
			'slug' 										=> $this->generateSlug(),
			'description' 								=> $inputs['description'],
		]);

		$errors 										= new MessageBag();

		DB::beginTransaction();
		if (!$data->save())
		{
			$errors->add('Product', $data->getError());
		}
		else
		{
			// category
			$categories 						= explode(',', $inputs['category']);

			if(!$data->categories()->sync($categories))
			{
				$errors->add('Product', $data->getError());
			}
		}
	
		if (!$errors->count())
		{
			DB::commit();
			
			return Redirect::route('backend.data.product.index')
					->withErrors($errors)
					->with('msg-type', 'danger')
					;
		}
		else
		{
			DB::rollback();

			return Redirect::route('backend.data.product.index')
					->with('msg','Produk sudah disimpan')
					->with('msg-type', 'success')
					;
		}
	}

	public function Update($id)
	{
		return $this->store($id);		
	}

	public function destroy($id)
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

			return Redirect::route('backend.data.product.index')
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
}