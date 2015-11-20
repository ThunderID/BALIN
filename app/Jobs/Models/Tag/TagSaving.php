<?php

namespace App\Jobs\Models\Tag;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;

use App\Models\Tag;
use App\Libraries\JSend;

class TagSaving extends Job implements SelfHandling
{
    protected $category;

    public function __construct(Tag $category)
    {
        $this->category                     = $category;
    }

    public function handle()
    {
        $result                             = new JSend('success', (array)$this->category);

        return $result;
    }
}
