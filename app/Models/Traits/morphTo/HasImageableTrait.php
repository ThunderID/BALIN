<?php namespace App\Models\Traits\MorphTo;

trait HasImageableTrait 
{

	/**
	 * boot
	 *
	 * @return void
	 * @author 
	 **/

	function HasImageableTraitConstructor()
	{
		//
	}

    public function imageable()
    {
        return $this->morphTo();
    }
}