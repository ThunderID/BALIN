<?php

namespace App\Jobs\Models\GlobalCategory;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;

use App\Models\GlobalCategory;
use App\Libraries\JSend;

class GlobalCategoryCreated extends Job implements SelfHandling
{
    protected $category;

    public function __construct(GlobalCategory $category)
    {
        $this->category                 = $category;
    }

    public function handle()
    {
        if($this->category->category()->count())
        {
            $this->category->path           = $this->category->category->path.','.$this->category->id;
        }
        else
        {
            $this->category->path           = $this->category->id;
        }

        $this->category->save();

        return new JSend('success', (array)$this->category);
    }
}
