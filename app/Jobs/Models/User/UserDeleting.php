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
            return new JSend('error', (array)$this->user, 'Tidak bisa menghapus User yang telah bertransaksi.');
        }

        if($this->user->pointlogs->count())
        {
            return new JSend('error', (array)$this->user, 'Tidak bisa menghapus User yang memiliki point.');
        }

        if($this->user->quotalogs->count())
        {
            return new JSend('error', (array)$this->user, 'Tidak bisa menghapus User yang memiliki quota.');
        }

        if($this->user->auditors->count())
        {
            return new JSend('error', (array)$this->user, 'Tidak bisa menghapus User yang terlibat dalam sistem.');
        }

        return new JSend('success', (array)$this->user);
    }
}
