<?php namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\BaseController;
use Config;

class AboutUsController extends BaseController 
{
	/**
	* Instantiate a new UserController instance.
	*/
	public function __construct()
	{
		parent::__construct();
	}

	protected $controller_name 					= 'aboutus';

	public function index()
	{		
		$breadcrumb								= ['About Us' => route('frontend.aboutus.index')];
		$this->layout->page 					= view('pages.frontend.about_us.index')
													->with('controller_name', $this->controller_name)
													->with('breadcrumb', $breadcrumb)
													;

		$this->layout->page->page_title 		= 'BALIN.ID';
		$this->layout->page->page_subtitle 		= 'About Us';

		$this->layout->page->metas 				= 	[
														'og:type' 			=> 'website', 
														'og:title' 			=> 'BALIN.ID', 
														'og:description' 	=> 'About Us',
														'og:url' 			=> route('frontend.aboutus.index'),
														'og:image' 			=> $this->stores['logo'],
														'og:site_name' 		=> 'balin.id',
														'fb:app_id' 		=> Config::get('fb_app.id'),
													];

		$this->layout->controller_name			= $this->controller_name;

		return $this->layout;
	}
}