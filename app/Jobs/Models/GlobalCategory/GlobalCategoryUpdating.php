<?php

namespace App\Jobs\Models\GlobalCategory;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;

use App\Models\GlobalCategory;
use App\Libraries\JSend;

class GlobalCategoryUpdating extends Job implements SelfHandling
{
    protected $category;

    public function __construct(GlobalCategory $category)
    {
        $this->category                     = $category;
    }

    public function handle()
    {
        if(isset($this->category->getDirty()['category_id']) || !isset($this->category ->getDirty()['path']))
        {
            if($this->category->category()->count())
            {
                $this->category->path = $this->category->category->path . "," . $this->category ->id;
            }
            else
            {
                $this->category ->path = $this->category ->id;
            }

            if(isset($this->category ->getOriginal()['path']))
            {
                $childs                         = GlobalCategory::orderBy('path','asc')
                                                    ->where('path','like',$this->category->getOriginal()['path'] . ',%')
                                                    ->get();
                foreach ($childs as $child) 
                {
                    $child->update(['path' => preg_replace('/'. $this->category ->getOriginal()['path'].',/', $this->category ->path . ',', $child->path,1)]);  
                }
            }
        }

        return new JSend('success', (array)$this->category);
    }
}
