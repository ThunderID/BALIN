<?php namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\BaseController;

use Cookie, Response, Input, Auth, App;
use App\Models\Product;

class ProductController extends BaseController 
{
	/**
	* Instantiate a new UserController instance.
	*/
	public function __construct()
	{
		parent::__construct();
	}
	
	protected $controller_name 					= 'product';


	public function index($page = 1)
	{
		$breadcrumb								= ['Produk' => route('frontend.product.index')];

		$filters 								= null;
		$searchResult							= null;

		if(Input::has('q'))
		{
			$filters 							= ['categoriesname' => Input::get('q')];

			$searchResult						= $searchResult.'kategori '.Input::get('q').' ';
		}

		if(Input::has('name'))
		{
			$filters['name']					= Input::get('name');
			$searchResult						= $searchResult.'nama '.Input::get('name').' ';
		}

		if(Input::has('sort') && Input::get('sort')=='desc')
		{
			$filters['orderbyraw']				= 'name desc';
			$searchResult						= $searchResult.' di urutkan Z-A';
		}
		elseif(Input::has('sort') && Input::get('sort')=='asc')
		{
			$filters['orderbyraw']				= 'name asc';
			$searchResult						= $searchResult.' di urutkan A-Z';
		}

		if(Auth::check())
		{
			$balance 							= Auth::user()->cart_balance;
		}
		else
		{
			$balance 							= 0;
		}

		$this->layout->page 					= view('pages.frontend.product.index')
													->with('controller_name', $this->controller_name)
													->with('filters', $filters)
													->with('searchResult', $searchResult)
													->with('breadcrumb', $breadcrumb)
													->with('balance', $balance)
													->with('page', $page)
													;
		$this->layout->controller_name			= $this->controller_name;

		$this->layout->page->page_title 		= 'BALIN.ID';
		$this->layout->page->page_subtitle 		= 'Produk Batik Modern - ' . $page;

		$this->layout->page->metas 				= 	[
														'og:type' 			=> 'website', 
														'og:title' 			=> 'BALIN.ID', 
														'og:description' 	=> 'Produk Batik Modern - '. $page,
														'og:url' 			=> route('frontend.product.index'),
														'og:image' 			=> $this->stores['logo'],
														'og:site_name' 		=> 'balin.id',
													];

		return $this->layout;
	}


	public function show($slug = null)
	{
		$data          							= Product::slug($slug)->sellable(true)->first();

		if(!$data)
		{
			App::abort(404);
		}

		$breadcrumb								= 	[
														'Produk' 			=> route('frontend.product.index'),
														$data['name'] 		=> route('frontend.product.show', $slug)
													];

		if(Auth::check())
		{
			$balance 							= Auth::user()->cart_balance;
		}
		else
		{
			$balance 							= 0;
		}
		
		$this->layout->page 					= view('pages.frontend.product.show')
														->with('controller_name', $this->controller_name)
														->with('slug', $slug)
														->with('breadcrumb', $breadcrumb)
														->with('balance', $balance)
														->with('data', $data)
														;
		$this->layout->controller_name			= $this->controller_name;

		$this->layout->page->page_title 		= 'BALIN.ID';
		$this->layout->page->page_subtitle 		= $data->name;

		$this->layout->page->metas 				= 	[
														'og:type' 			=> 'website', 
														'og:title' 			=> 'BALIN.ID', 
														'og:description' 	=> $data->name,
														'og:url' 			=> route('frontend.product.show', $data->slug),
														'og:image' 			=> $data->default_image,
														'og:site_name' 		=> 'balin.id',
													];
		return $this->layout;
	}

	public function detail()
	{
		$baskets = Cookie::get('basketss');

		dd($baskets);
	}	
}