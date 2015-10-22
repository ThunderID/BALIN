<?php namespace App\Models\Traits\MorphTo;

trait HasProductTrait 
{

	/**
	 * boot
	 *
	 * @return void
	 * @author 
	 **/

	function HasProductTraitConstructor()
	{
		//
	}

	public function Product()
	{
		return $this->morphTo();
	}

}