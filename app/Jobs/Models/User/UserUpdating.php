<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Libraries\JSend;
use Illuminate\Contracts\Bus\SelfHandling;

use App\Models\User;

class UserUpdating extends Job implements SelfHandling
{
    protected $user;

    public function __construct(user $user)
    {
        $this->user                 = $user;
    }

    public function handle()
    {
        return new json('success', (array)$this->user);
    }
}
