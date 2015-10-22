<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Libraries\JSend;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Contracts\Bus\SelfHandling;

use App\Models\Supplier;

class SupplierSaving extends Job implements SelfHandling
{
    use DispatchesJobs, ValidatesRequests;

    public function __construct(Supplier $supplier)
    {
        $this->supplier             = $supplier;
    }

    public function handle()
    {
        //cek 
        if(isset($this->supplier->getDirty()['name']) && $this->supplier->transactions()->count())
        {
            $result                 = new Jsend('error', (array)$this->supplier, ['Tidak dapat mengubah nama supplier yang pernah melakukan transaksi']);
        }
        else
        {
            $result                 = new Jsend('success', (array)$this->supplier);
        }

        return $result;
    }
}
