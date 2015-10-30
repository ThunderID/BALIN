<?php

namespace App\Jobs\Models\Image;

use App\Jobs\Job;
use App\Jobs\ImageIsValid;
use App\Jobs\ReferralPointIsGiven;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Foundation\Bus\DispatchesJobs;
use App\Libraries\JSend;

use App\Models\Image;

class ImageSaving extends Job implements SelfHandling
{
    use DispatchesJobs;
    
    protected $image;

    public function __construct(Image $image)
    {
        $this->image                  = $image;
    }
    
    public function handle()
    {
        $result                         = new JSend('success', (array)$this->image);
        
        return $result;
    }
}
