<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Libraries\JSend;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Contracts\Bus\SelfHandling;

use App\Models\Supplier;

class SupplierRstored extends Job implements SelfHandling
{
    use DispatchesJobs, ValidatesRequests;

    protected $supplier;

    public function __construct(Supplier $supplier)
    {
        $this->supplier             = $supplier;
    }

    public function handle()
    {
        //cek 
        if($this->supplier->transactions()->count())
        {
            $result                 = new JSend('error', (array)$this->supplier, 'Tidak dapat menghapus supplier yang pernah melakukan transaksi');
        }
        else
        {
            $result                 = new JSend('success', (array)$this->supplier);
        }

        return $result;
    }
}
