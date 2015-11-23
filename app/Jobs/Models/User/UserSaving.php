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
		
		if(is_null($this->user->id))
		{
			$id 							= 0;
		}
		else
		{
			$id 							= $this->user->id;
		}

		$user 								= User::email($this->user->email)->notid($id)->first();

		if($user->count())
		{
			$result							= new JSend('error', (array)$this->user, 'Email sudah terdaftar.');
		}


		if (Hash::needsRehash($this->user->password))
		{
			$this->user->password			= bcrypt($this->user->password);
		}

	    return $result;
	}
}
