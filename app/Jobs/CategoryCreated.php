<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;

use App\Models\Category;
use App\Libraries\JSend;

class CategoryCreated extends Job implements SelfHandling
{
    
    public function __construct(category $category)
    {
        $this->category                 = $category;
    }

    public function handle()
    {
        $this->category->path           = $this->category->id;

        $this->category->save();

        $result                         = new JSend('success', array($this->category));

        return $result;
    }
}