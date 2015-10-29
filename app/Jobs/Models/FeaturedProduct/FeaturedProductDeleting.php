<?php

namespace App\Jobs\Models\FeaturedProduct;

use App\Jobs\Job;
use App\Libraries\JSend;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Contracts\Bus\SelfHandling;

use App\Models\FeaturedProduct;

class FeaturedProductDeleting extends Job implements SelfHandling
{
    use DispatchesJobs, ValidatesRequests;

    protected $featured;

    public function __construct(FeaturedProduct $featured)
    {
        $this->featured             = $featured;
    }


    public function handle()
    {
        $result                 = new JSend('success', (array)$this->featured);

        return $result;
    }
}
