<?php namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Models\user;

use App\Jobs\validateEmail;

use Mail;

class accountController extends BaseController 
{
	public function activateAccount($activation_link = null)
	{
		$input = user::where('activation_link', $activation_link)->first();

		if(empty($input))
		{
			dd('kosong');
		}

		$result = $this->dispatch(new validateEmail($input));

		dd($result);

	}
}