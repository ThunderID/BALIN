<?php namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;

abstract class baseController extends Controller {
	protected $layout;

    use DispatchesJobs, ValidatesRequests;

	function __construct() 
	{
		$this->layout = view('template.layout');
	}

}
