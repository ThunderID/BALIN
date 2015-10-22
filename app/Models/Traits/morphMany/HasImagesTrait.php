<?php namespace App\Models\Traits\MorphMany;

trait HasImagesTrait 
{

	/**
	 * boot
	 *
	 * @return void
	 * @author 
	 **/

	function HasImagesTraitConstructor()
	{
		//
	}

	public function Images()
	{
		return $this->morphMany('App\Models\Image', 'imageable');
	}
}