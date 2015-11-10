<?php namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\BaseController;

use Cookie, Response, Input;

class ProductController extends BaseController 
{

	protected $controller_name 					= 'product';

	public function index()
	{
		$filters 								= null;

		if(Input::has('q'))
		{
			$filters 							= ['categoriesname' => Input::get('q')];

			$searchResult						= Input::get('q');
		}
		else
		{
			$searchResult						= null;
		}

		if(Input::has('name'))
		{
			$filters['name']					= Input::get('name');
			$searchResult						= Input::get('name');
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

		$this->layout->page 					= view('pages.frontend.product.index')
													->with('controller_name', $this->controller_name)
													->with('filters', $filters)
													->with('searchResult', $searchResult)
													;
		$this->layout->controller_name			= $this->controller_name;

		return $this->layout;
	}


	public function show($slug = null)
	{
		$this->layout->page 					= view('pages.frontend.product.show')
														->with('controller_name', $this->controller_name)
														->with('slug', $slug)
														;
		$this->layout->controller_name			= $this->controller_name;

		return $this->layout;
	}

	public function detail()
	{
		$baskets = Cookie::get('basketss');

		dd($baskets);
	}	
}