<?php namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\BaseController;

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
		$this->layout->page 					= view('pages.frontend.home.index')
													->with('controller_name', $this->controller_name);
		
		$this->layout->controller_name			= $this->controller_name;

		$this->layout->page->page_title 		= 'BALIN.ID';
		$this->layout->page->page_subtitle 		= 'Fashionable and Modern Batik';

		$this->layout->page->metas 				= 	[
														'og:type' 			=> 'website', 
														'og:title' 			=> 'BALIN.ID', 
														'og:description' 	=> 'Batik For Warrior',
														'og:url' 			=> $this->stores['url'],
														'og:image' 			=> $this->stores['logo'],
														'og:site_name' 		=> 'balin.id',
													];

		return $this->layout;
	}
}