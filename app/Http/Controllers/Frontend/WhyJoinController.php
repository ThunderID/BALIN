<?php namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\BaseController;

class WhyJoinController extends BaseController 
{
	/**
	* Instantiate a new UserController instance.
	*/
	public function __construct()
	{
		parent::__construct();
	}

	protected $controller_name 					= 'whyjoin';

	public function index()
	{		
		$breadcrumb								= ['Why Join' => route('frontend.whyjoin.index')];
		$this->layout->page 					= view('pages.frontend.why_join.index')
													->with('controller_name', $this->controller_name)
													->with('breadcrumb', $breadcrumb)
													;

		$this->layout->page->page_title 		= 'BALIN.ID';
		$this->layout->page->page_subtitle 		= 'Why Join ?';

		$this->layout->page->metas 				= 	[
														'og:type' 			=> 'website', 
														'og:title' 			=> 'BALIN.ID', 
														'og:description' 	=> 'Why Join ?',
														'og:url' 			=> route('frontend.whyjoin.index'),
														'og:image' 			=> $this->stores['logo'],
														'og:site_name' 		=> 'balin.id',
													];

		$this->layout->controller_name			= $this->controller_name;

		return $this->layout;
	}
}