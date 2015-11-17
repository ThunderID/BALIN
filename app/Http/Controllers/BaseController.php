<?php namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\StoreSetting;

abstract class BaseController extends Controller 
{
	protected $layout;
	protected $stores;

    use DispatchesJobs, ValidatesRequests, AuthorizesRequests;

	function __construct() 
	{
		$store 									= StoreSetting::storeinfo(true)->get();

		$this->stores 							= null;
		foreach ($store as $key => $value) 
		{
			$this->stores[$value->type] 		= $value->value;
		}

		$this->layout = view('template.layout');
	}

}
