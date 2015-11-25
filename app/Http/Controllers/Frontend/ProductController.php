<?php namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\BaseController;

use Cookie, Response, Input, Auth, App, Config;
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
		$searchResult							= [];
		$links									= [];
		$sorts									= [];

		$inputOnly 								= ['categoriesname','tagsname','name','sort'];

		$inputs 								= Input::all();

		foreach ($inputs as $key => $input) 
		{
			if(in_array($key, $inputOnly))
			{
				$filters[$key] 					= $input;
				array_push($links, ["page" => $page, 'id' => $key] );

				switch ($key) {
					case 'categoriesname':
						$searchResult[]			= 'kategori '. $input;
						break;
					case 'tagsname':
						$searchResult[]			= 'tag '. $input;
						break;
					case 'name':
						$searchResult[]			= 'nama '. $input;
						break;	
					case 'sort':
						$tmp 					= explode('-', $input);

						switch ($tmp[0]) {
							case 'name':
								if($tmp[1] == 'asc')
								{
									$searchResult[]			= 'mengurutkan nama produk A-Z';
								}
								else if($tmp[1] == 'desc')
								{
									$searchResult[]			= 'mengurutkan nama produk Z-A';
								}
								break;
							case 'price':

								if($tmp[1] == 'asc')
								{
									$searchResult[]			= 'mengurutkan produk termurah';
								}
								else if($tmp[1] == 'desc')
								{
									$searchResult[]			= 'mengurutkan produk termahal';
								}	
								break;
							case 'date':
								if($tmp[1] == 'asc')
								{
									$searchResult[]			= 'mengurutkan produk terlama';
								}
								else if($tmp[1] == 'desc')
								{
									$searchResult[]			= 'mengurutkan produk terbaru';
								}															
								break;								
							default:
								$searchResult[]			= 'mengurutkan ' . $tmp[0];
								break;
						}
						break;																		
					default:
						$searchResult[]			= null;
						break;
				}
			}
		}

		foreach ($links as $key => $link) 
		{
			$tmplink							= [];
			foreach ($filters as $key2 => $filter) 
			{
				if($link['id'] != $key2)
				{
					$tmplink[$key2] 			= $filter; 
				}
			}
			$links[$key] 						= array_merge($links[$key], $tmplink);
			unset($links[$key]['id']);
		}

		// dd($links);
		// if(Input::has('categoriesname'))
		// {
		// 	$filters['categoriesname'] 			= Input::get('categoriesname');

		// 	$searchResult[]						= 'kategori '.Input::get('categoriesname');
		// 	// array_push($searchResult, 'kategori '.Input::get('categoriesname') );
		// 	$filters2 							= $filters;
		// 	unset($filters2['categoriesname']);
		// 	$link[]								= array_merge(["page" => $page], $filters2);
		// }

		// if(Input::has('tagsname'))
		// {
		// 	$filters['tagsname'] 				= Input::get('tagsname');

		// 	$searchResult[]						= 'tag '.Input::get('tagsname');
		// 	// array_push($searchResult, 'tag '.Input::get('tagsname') );
		// 	$filters2 							= $filters;
		// 	unset($filters2['tagsname']);
		// 	$link[]								= array_merge(["page" => $page], $filters2);
		// }

		// if(Input::has('name'))
		// {
		// 	$filters['name']					= Input::get('name');
		// 	array_push($searchResult, 'nama '.Input::get('name') );
		// }

		// if(Input::has('sort') && Input::get('sort')=='desc')
		// {
		// 	$filters['orderbyraw']				= 'name desc';
		// 	array_push($searchResult, 'di urutkan Z-A' );
		// }
		// elseif(Input::has('sort') && Input::get('sort')=='asc')
		// {
		// 	$filters['orderbyraw']				= 'name asc';
		// 	array_push($searchResult, 'di urutkan A-Z' );
		// }

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
													->with('links', $links)
													;

		$this->layout->controller_name			= $this->controller_name;

		$this->layout->page->page_title 		= 'BALIN.ID';
		$this->layout->page->page_subtitle 		= 'Produk Batik Modern - ' . $page;

		$meta_desc								= null;
		if(count($searchResult) > 0)
		{
			foreach ($filters as $key => $filter) 
			{
				$meta_desc						= $meta_desc . $filter ;

				if (end($filters) != $filter)
				{
					$meta_desc 					= $meta_desc . ' - ';
				}
			}

			$meta_desc 							= ' - ' . $meta_desc;
		}

		$this->layout->page->metas 				= 	[
														'og:type' 			=> 'website', 
														'og:title' 			=> 'BALIN.ID', 
														'og:description' 	=> 'Produk Batik Modern - '. $page . $meta_desc,
														'og:url' 			=> route('frontend.product.index'),
														'og:image' 			=> $this->stores['logo'],
														'og:site_name' 		=> 'balin.id',
														'fb:app_id' 		=> Config::get('fb_app.id'),
													];

		return $this->layout;
	}


	public function show($slug = null)
	{
		$data          							= Product::slug($slug)->sellable(true)->currentprice(true)->with('varians')->with('images')->first();

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
														'fb:app_id' 		=> Config::get('fb_app.id'),
													];
		return $this->layout;
	}
}