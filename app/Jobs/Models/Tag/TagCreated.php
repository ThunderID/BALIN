<?php

namespace App\Jobs\Models\Tag;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;

use App\Models\Tag;
use App\Libraries\JSend;

class TagCreated extends Job implements SelfHandling
{
    protected $category;

    public function __construct(Tag $category)
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
