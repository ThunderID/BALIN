<?php

namespace App\Jobs\Models\Category;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;

use App\Models\Category;
use App\Libraries\JSend;

class CategoryCreated extends Job implements SelfHandling
{
    protected $category;

    public function __construct(Category $category)
    {
        $this->category                 = $category;
    }

    public function handle()
    {
        $this->category->path           = $this->category->id;

        $this->category->save();

        return new JSend('success', (array)$this->category);
    }
}
