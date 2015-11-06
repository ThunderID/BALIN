<?php namespace App\Models\Traits\hasMany;

trait HasProductsTrait 
{

	/**
	 * boot
	 *
	 * @return void
	 * @author 
	 **/

	function HasProductsTraitConstructor()
	{
		//
	}

	/* ------------------------------------------------------------------- RELATIONSHIP TO SERVICE -------------------------------------------------------------------*/

	public function Products()
	{
		return $this->hasMany('App\Models\Product');
	}
}