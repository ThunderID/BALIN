<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Libraries\JSend;
use Illuminate\Contracts\Bus\SelfHandling;

use App\Models\User;

class UserDeleting extends Job implements SelfHandling
{
    protected $user;

    public function __construct(user $user)
    {
        $this->user                 = $user;
    }

    public function handle()
    {
        if($this->user->transactions->count())
        {
            return new json('error', (array)$this->user, ['message' => 'Tidak bisa menghapus User yang telah bertransaksi']);
        }

        return new json('success', (array)$this->user);
    }
}
