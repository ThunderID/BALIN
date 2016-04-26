<?php

namespace App\Jobs\Models\GlobalCategory;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;

use App\Models\GlobalCategory;
use App\Libraries\JSend;

class GlobalCategoryRestoring extends Job implements SelfHandling
{
    protected $category;

    public function __construct(GlobalCategory $category)
    {
        $this->category                 = $category;
    }


    public function handle()
    {
        if($this->category->products()->count())
        {
            return new Jsend('error', (array)$this->category,  'Tidak bisa menghapus kategori yang memiliki produk');
        }

        $childs                         = GlobalCategory::orderBy('path','desc')
                                            ->where('path','like',$this->category->path . ',%')
                                            ->get();

        foreach ($childs as $child) 
        {
            if($child->products()->count())
            {
                return new Jsend('error', (array)$this->category,  'Tidak bisa menghapus kategori yang memiliki produk');
            }
            else
            {
                $child->delete();
            }
        }

        $result                         = new JSend('success', (array)$this->category);

        return $result;
    }
}
