<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;

use App\Models\Category;
use App\Libraries\JSend;

class CategoryDeleting extends Job implements SelfHandling
{

    public function __construct(category $category)
    {
        $this->category                 = $category;
    }


    public function handle()
    {
        if($this->category->products()->count())
        {
            return new Jsend('error', (array)$this->category,  ['message' => 'Tidak bisa menghapus kategori yang memiliki produk']);
        }

        $childs                         = Category::orderBy('path','desc')
                                            ->where('path','like',$this->category->path . ',%')
                                            ->get();

        foreach ($childs as $child) 
        {
            if($child->products()->count())
            {
                return new Jsend('error', (array)$this->category,  ['message' => 'Tidak bisa menghapus kategori yang memiliki produk']);
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
