<?php

namespace App\Jobs\Models\Courier;

use App\Jobs\Job;
use App\Libraries\JSend;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Contracts\Bus\SelfHandling;

use App\Models\Courier;

class CourierDeleting extends Job implements SelfHandling
{
    use DispatchesJobs, ValidatesRequests;

    protected $courier;

    public function __construct(Courier $courier)
    {
        $this->courier             = $courier;
    }


    public function handle()
    {
        if($this->courier->shipments()->count() || $this->courier->shippingcosts()->count())
        {
            $result                 = new JSend('error', (array)$this->courier, 'Tidak dapat menghapus kurir yang pernah melakukan transaksi atau memiliki daftar biaya pengiriman');
        }
        else
        {
            $result                 = new JSend('success', (array)$this->courier);
        }

        return $result;
    }
}
