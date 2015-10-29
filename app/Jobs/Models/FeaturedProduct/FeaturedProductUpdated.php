<?php

namespace App\Jobs\Models\FeaturedProduct;

use App\Jobs\Job;
use App\Libraries\JSend;

use Illuminate\Contracts\Bus\SelfHandling;

use App\Models\FeaturedProduct;

class FeaturedProductUpdated extends Job implements SelfHandling
{
    protected $featured;

    public function __construct(FeaturedProduct $featured)
    {
        $this->featured             = $featured;
    }

    public function handle()
    {
        return new JSend('success', (array)$this->featured);
    }
}
