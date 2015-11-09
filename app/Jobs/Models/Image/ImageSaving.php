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
        $this->image                 = $image;
    }
    
    public function handle()
    {
        if(isset($this->image->imageable_id) )
        {
            $model                     = Image::where('imageable_id', $this->image->imageable_id)
                                            ->where('imageable_type','App\Models\Product')
                                            ->where('is_default', 1)
                                            ->count();
            if($model == 0)
            {
                $this->image->is_default     = 1;
            }
        }


        $result                       = new JSend('success', (array)$this->image);
        
        return $result;
    }
}
