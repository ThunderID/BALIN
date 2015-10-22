<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;

use App\Models\Category;

class CategoryCreated extends Job implements SelfHandling
{
    
    public function __construct(category $Category)
    {
        $this->category                 = $category;
    }

    public function handle()
    {
        $this->category->path           = $this->category->id;
        $this->category->save();

        $result                         = new Jsend('success', ['message' => 'Success']);
        return $result;
    }
}
