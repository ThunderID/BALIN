<?php

namespace App\Jobs\Models\Image;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;

use App\Libraries\JSend;

use App\Models\Image;

class ImageRestored extends Job implements SelfHandling
{
    protected $image;

    public function __construct(Image $image)
    {
        $this->image                  = $image;
    }
    
    public function handle()
    {
        $result                          = new JSend('success', (array)$this->image);

        return $result;
    }
}
