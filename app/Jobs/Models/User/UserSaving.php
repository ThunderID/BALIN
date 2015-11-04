<?php

namespace App\Jobs\Models\User;

use App\Jobs\Job;
use App\Jobs\GenerateRefferalCode;

use App\Libraries\JSend;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Foundation\Bus\DispatchesJobs;

use App\Models\User;
use Hash;

class UserSaving extends Job implements SelfHandling
{
    use DispatchesJobs;

	protected $user;

	public function __construct(User $user)
	{
		$this->user							= $user;
	}

	public function handle()
	{
		$result								= new JSend('success', (array)$this->user);

		if (Hash::needsRehash($this->user->password))
		{
			$this->user->password			= bcrypt($this->user->password);
		}

		if($this->user->email!='' && $this->user->referral_code=='')
		{
			$result							= $this->dispatch(new GenerateRefferalCode($this->user));;
		}

	    return $result;
	}
}
