<?php namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

abstract class BaseController extends Controller 
{
	protected $layout;

    use DispatchesJobs, ValidatesRequests, AuthorizesRequests;

	function __construct() 
	{
		$this->layout = view('template.layout');
	}

}
