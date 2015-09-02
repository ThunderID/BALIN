<?php namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;

abstract class baseController extends Controller {
	protected $layout;

	function __construct() 
	{
		$this->layout = view('template.layout');
	}

}
