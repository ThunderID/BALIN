<?php

namespace App\Jobs\Models\Supplier;

use App\Jobs\Job;
use App\Libraries\JSend;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Contracts\Bus\SelfHandling;

use App\Models\Supplier;

class SupplierDeleting extends Job implements SelfHandling
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
            $result                 = new Jsend('error', (array)$this->supplier, ['Tidak dapat menghapus supplier yang pernah melakukan transaksi']);
        }
        else
        {
            $result                 = new Jsend('success', (array)$this->supplier);
        }

        return $result;
    }
}
