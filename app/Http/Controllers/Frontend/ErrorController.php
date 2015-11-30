<?php namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\BaseController;
use Config;

class ErrorController extends BaseController 
{
	/**
	* Instantiate a new UserController instance.
	*/
	public function __construct()
	{
		parent::__construct();
	}

	protected $controller_name 					= 'error';

	public function er404()
	{		
		$breadcrumb								= [];
		$this->layout->page 					= view('pages.frontend.errors.404')
													->with('controller_name', $this->controller_name)
													->with('breadcrumb', $breadcrumb)
													;

		$this->layout->page->page_title 		= 'BALIN.ID';
		$this->layout->page->page_subtitle 		= '404';

		$this->layout->page->metas 				= 	[
														'og:type' 			=> 'website', 
														'og:title' 			=> 'BALIN.ID', 
														'og:description' 	=> 'About Us',
														'og:url' 			=> '',
														'og:image' 			=> $this->stores['logo'],
														'og:site_name' 		=> 'balin.id',
														'fb:app_id' 		=> Config::get('fb_app.id'),
													];

		$this->layout->controller_name			= $this->controller_name;

		return $this->layout;
	}
}