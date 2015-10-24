<?php

namespace App\Jobs\Models\User;

use App\Jobs\Job;
use App\Libraries\JSend;
use Illuminate\Contracts\Bus\SelfHandling;

use App\Models\User;

class UserDeleting extends Job implements SelfHandling
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user                 = $user;
    }

    public function handle()
    {
        if($this->user->transactions->count())
        {
            return new JSend('error', (array)$this->user, 'Tidak bisa menghapus User yang telah bertransaksi');
        }

        return new JSend('success', (array)$this->user);
    }
}
