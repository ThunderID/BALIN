<?php

namespace App\Jobs\Models\Image;

use App\Jobs\Job;
use App\Jobs\ImageIsValid;
use App\Jobs\ReferralPointIsGiven;
use App\Jobs\SendImageEmail;
use Illuminate\Contracts\Bus\SelfHandling;

use Illuminate\Foundation\Bus\DispatchesJobs;

use App\Models\Image;
use App\Libraries\JSend;

class ImageSaved extends Job implements SelfHandling
{
    use DispatchesJobs;

    protected $image;

    public function __construct(Image $image)
    {
        $this->image                      = $image;
    }

    public function handle()
    {
        return $result;
    }
}
