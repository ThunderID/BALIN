<?php namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\BaseController;
use App\Models\Product;
use Config;

class HomeController extends BaseController 
{
	/**
	* Instantiate a new UserController instance.
	*/
	public function __construct()
	{
		parent::__construct();
	}
	
	protected $controller_name 					= 'home';

	public function index()
	{
		//get data
		$Product 								= new Product;

		$datas['batik_wanita']					= $Product->take(4)->get();
		$datas['batik_pria']					= $Product->skip(4)->take(4)->get();
		$datas['all']							= $Product->skip(8)->take(4)->get();

		$this->layout->page 					= view('pages.frontend.home.index')
													->with('controller_name', $this->controller_name);
		
		$this->layout->controller_name			= $this->controller_name;

		$this->layout->page->page_title 		= 'BALIN.ID';
		$this->layout->page->page_subtitle 		= 'Fashionable and Modern Batik';
		$this->layout->page->datas 				= $datas;

		$this->layout->page->metas 				= 	[
														'og:type' 			=> 'website', 
														'og:title' 			=> 'BALIN.ID', 
														'og:description' 	=> 'Fashionable and Modern Batik',
														'og:url' 			=> $this->stores['url'],
														'og:image' 			=> $this->stores['logo'],
														'og:site_name' 		=> 'balin.id',
														'fb:app_id' 		=> Config::get('fb_app.id'),
													];

		return $this->layout;
	}
}