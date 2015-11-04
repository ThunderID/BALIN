<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Models\User;

use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Support\MessageBag as MessageBag;

use App\Libraries\JSend;

class GenerateActivationLink extends Job implements SelfHandling
{
 protected $user;

	public function __construct(User $user)
	{
		$this->user						= $user;
	}

    public function handle()
    {
        //generate link
        $activation						= md5(uniqid(rand(), TRUE));

        $this->user->activation_link	= $activation;
        
        $result							= new JSend('success', (array)$this->user);

        return $result;
    }
}
