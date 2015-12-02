<?php

namespace App\Jobs\Models\Tag;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;

use App\Models\Tag;
use App\Libraries\JSend;
use Str;

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

        if(isset($this->category->category_id) && $this->category->category_id != 0 )
        {
            $this->category->slug           = Str::slug($this->category->category->name.' '.$this->category->name);
        }
        else
        {
            $this->category->slug           = Str::slug($this->category->name);
        }

        if(is_null($this->category->id))
        {
            $id                             = 0;
        }
        else
        {
            $id                             = $this->category->id;
        }

        $category                           = Tag::slug($this->category->slug)->notid($id)->first();

        if($category)
        {
            $result                         = new JSend('error', (array)$this->category, 'Kategori sudah terdaftar');
        }

        return $result;
    }
}
