<?php

namespace App\Jobs\Models\User;

use App\Jobs\Job;
use App\Libraries\JSend;
use Illuminate\Contracts\Bus\SelfHandling;

use App\Models\User;
use Hash;

class UserSaving extends Job implements SelfHandling
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user                 = $user;
    }

    public function handle()
    {
    	if (Hash::needsRehash($this->user->password))
		{
			$this->user->password            = bcrypt($this->user->password);
		}

        if($this->user->email!='' && $this->user->referral_code=='')
        {
            $this->user->referral_code      = bin2hex(openssl_random_pseudo_bytes(4));
            $this->user->is_active          = true;
        }

        return new JSend('success', (array)$this->user);
    }
}
