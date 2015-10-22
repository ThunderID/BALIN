<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;

use App\Models\Category;

class CategorySaving extends Job implements SelfHandling
{
    protected $category;

    public function __construct(category $category)
    {
        $this->category                     = $category;
    }

    public function handle()
    {
        $result                             = new Jsend('success', ['message' => 'Success']);
        return $result;
    }
}
