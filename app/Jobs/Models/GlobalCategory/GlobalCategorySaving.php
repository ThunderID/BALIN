<?php

namespace App\Jobs\Models\GlobalCategory;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;

use App\Models\GlobalCategory;
use App\Libraries\JSend;

class GlobalCategorySaving extends Job implements SelfHandling
{
    protected $category;

    public function __construct(GlobalCategory $category)
    {
        $this->category                     = $category;
    }

    public function handle()
    {
        $result                             = new JSend('success', (array)$this->category);

        return $result;
    }
}
