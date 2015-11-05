<?php namespace App\Models\Traits\belongsTo;

trait HasProductUniversalTrait 
{

	/**
	 * boot
	 *
	 * @return void
	 * @author 
	 **/

	function HasProductUniversalTraitConstructor()
	{
		//
	}

	/* ------------------------------------------------------------------- RELATIONSHIP TO SERVICE -------------------------------------------------------------------*/

	public function ProductUniversal()
	{
		return $this->belongsTo('App\Models\Product');
	}
}