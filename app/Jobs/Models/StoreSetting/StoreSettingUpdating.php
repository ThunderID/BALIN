<?php

namespace App\Jobs\Models\StoreSetting;

use App\Jobs\Job;
use App\Libraries\JSend;

use Illuminate\Contracts\Bus\SelfHandling;

use App\Models\StoreSetting;

class StoreSettingUpdating extends Job implements SelfHandling
{
    protected $store;

    public function __construct(StoreSetting $store)
    {
        $this->store             = $store;
    }

    public function handle()
    {
		if(isset($this->store->getDirty()['type']))
        {
            return new JSend('error', (array)$this->store, 'Tidak dapat mengubah tipe pengaturan.');
        }

        return new JSend('success', (array)$this->store);
    }
}
