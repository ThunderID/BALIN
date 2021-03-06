<?php namespace App\Models\Traits\morphTo;

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

    public function scopeImageableID($query, $variable)
    {
		return $query->where('imageable_id', $variable);
    }

    public function scopeImageableType($query, $variable)
    {
		return $query->where('imageable_type', $variable);
    }
}