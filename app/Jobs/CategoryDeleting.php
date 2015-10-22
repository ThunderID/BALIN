<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;

use App\Models\Category;

class CategoryDeleting extends Job implements SelfHandling
{

    public function __construct(category $category)
    {
        $this->Category                 = $category;
    }


    public function handle()
    {
        if($this->Category->categoryProducts()->count())
        {
            return new Jsend('error', (array)$customer,  ['message' => 'Tidak bisa menghapus kategori yang memiliki produk']);
        }

        $childs                         = Category::orderBy('path','desc')
                                            ->where('path','like',$this->Category->path . ',%')
                                            ->get();

        foreach ($childs as $child) 
        {
            if($child->categoryProducts()->count())
            {
                return new Jsend('error', (array)$customer,  ['message' => 'Tidak bisa menghapus kategori yang memiliki produk']);
            }
            else
            {
                $child->delete();
            }
        }

        $result                         = new Jsend('success', ['message' => 'Success']);
        return $result;
    }
}
