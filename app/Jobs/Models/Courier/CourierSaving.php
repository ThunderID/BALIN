<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Libraries\JSend;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Contracts\Bus\SelfHandling;

use App\Models\Courier;

class CourierSaving extends Job implements SelfHandling
{
    use DispatchesJobs, ValidatesRequests;

    protected $courier;

    public function __construct(Courier $courier)
    {
        $this->courier             = $courier;
    }

    public function handle()
    {
        //cek 
        if(isset($this->courier->getDirty()['name']) && $this->courier->shipments()->count())
        {
            $result                 = new Jsend('error', (array)$this->courier, ['Tidak dapat mengubah nama courier yang pernah melakukan transaksi']);
        }
        else
        {
            $result                 = new Jsend('success', (array)$this->courier);
        }

        return $result;
    }
}
