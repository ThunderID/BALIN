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
        $this->image                    = $image;
    }

    public function handle()
    {
        if(isset($this->image->imageable_id) && $this->image->is_default == 1)
        {
            $models                     = Image::where('imageable_id', $this->image->imageable_id)
                                            ->where('imageable_type','App\Models\Product')
                                            ->where('is_default', 1)
                                            ->where('id','!=', $this->image->id)
                                            ->get();

            foreach ($models as $model) 
            {
               $model->fill([
                    'is_default'        => 0,
                ]);

               if(!$model->save())
               {
                    return new JSend('error', (array)$this->image, (array)$this->image->geterror());
               }
            }
        }

        $result                          = new JSend('success', (array)$this->image);
        
        return $result;
    }
}
