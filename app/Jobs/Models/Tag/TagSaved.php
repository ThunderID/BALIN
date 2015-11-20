<?php

namespace App\Jobs\Models\Tag;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;

use App\Models\Tag;
use App\Libraries\JSend;

class TagSaved extends Job implements SelfHandling
{
    protected $category;

    public function __construct(Tag $category)
    {
        $this->category                 = $category;
    }
    
    public function handle()
    {
        return new JSend('success', (array)$this->category);
    }
}
