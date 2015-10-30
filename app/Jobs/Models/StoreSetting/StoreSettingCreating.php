<?php

namespace App\Jobs\Models\StoreSetting;

use App\Jobs\Job;
use App\Libraries\JSend;

use Illuminate\Contracts\Bus\SelfHandling;

use App\Models\StoreSetting;

class StoreSettingCreating extends Job implements SelfHandling
{
    protected $store;

    public function __construct(StoreSetting $store)
    {
        $this->store             = $store;
    }

    public function handle()
    {
        return new JSend('error', (array)$this->store, 'Tidak dapat menambahkan pengaturan toko.');
    }
}