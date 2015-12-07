<?php namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\BaseController;

use Cookie, Response, Input, Auth, App, Config;
use App\Models\Product;
use App\Models\Category;
use App\Models\Tag;

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
		if($page && $page > 1)
		{
			$breadcrumb							= 	[
														'Produk' => route('frontend.product.index'),
														'Page ' . $page  => route('frontend.product.index', ['page' => $page])
													];
		}
		else
		{
			$breadcrumb							= ['Produk' => route('frontend.product.index')];
		}


		$filters 								= null;
		$searchResult							= [];
		$links									= [];
		$sorts									= [];
		$tagparent								= [];

		$inputOnly 								= ['categoriesslug','tagging','name','sort'];

		$inputs 								= Input::all();

		foreach ($inputs as $key => $input) 
		{
			if(in_array($key, $inputOnly))
			{
				$filters[$key] 					= $input;
				array_push($links, ["page" => $page, 'id' => $key] );

				switch ($key) 
				{
					case 'categoriesslug':
						$searchResult[]			= Category::slug($input)->first()['name'];
						break;
					case 'tagging':
						$tagid 					= explode('##', $input);
						$sr 					= '';
						foreach ($tagid as $key2 => $value) 
						{
							$tag 				= Tag::slug($value)->with(['category'])->first();
							$sr					= $sr.' '.$tag['category']['name'].' '.$tag['name'];
							$tagparent[$tag['slug']]= $tag['category_id'];
						}
						$searchResult[]			= $sr;
						break;
					case 'name':
						$searchResult[]			= $input;
						break;	
					case 'sort':
						$tmp 					= explode('-', $input);

						switch ($tmp[0]) {
							case 'name':
								if($tmp[1] == 'asc')
								{
									$searchResult[]			= 'urutan nama produk A-Z';
								}
								else if($tmp[1] == 'desc')
								{
									$searchResult[]			= 'urutan nama produk Z-A';
								}
								break;
							case 'price':

								if($tmp[1] == 'asc')
								{
									$searchResult[]			= 'urutan produk termurah';
								}
								else if($tmp[1] == 'desc')
								{
									$searchResult[]			= 'urutan produk termahal';
								}	
								break;
							case 'date':
								if($tmp[1] == 'asc')
								{
									$searchResult[]			= 'urutan produk terlama';
								}
								else if($tmp[1] == 'desc')
								{
									$searchResult[]			= 'urutan produk terbaru';
								}															
								break;								
							default:
								$searchResult[]			= 'urutan ' . $tmp[0];
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
													->with('tagparent', $tagparent)
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