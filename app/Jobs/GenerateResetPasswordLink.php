<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Models\User;

use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Support\MessageBag as MessageBag;

use App\Libraries\JSend;

use Carbon;

class GenerateResetPasswordLink extends Job implements SelfHandling
{
 protected $user;

	public function __construct(User $user)
	{
		$this->user							= $user;
	}

	public function handle()
	{
		//generate link
		$reset								= md5(uniqid(rand(), TRUE));
		$expired_at							= new Carbon('+ 2 months');

		$this->user->reset_password_link	= $reset;
		$this->user->expired_at				= $expired_at->format('Y-m-d H:i:s');

		$result								= new JSend('success', (array)$this->user);

		if(!$this->user->save())
		{
		    $result							= new JSend('error', (array)$this->user, $this->user->getError());
		}

		return $result;
    }
}
