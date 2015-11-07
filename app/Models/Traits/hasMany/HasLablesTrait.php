<?php namespace App\Models\Traits\hasMany;

trait HasLablesTrait 
{

	/**
	 * boot
	 *
	 * @return void
	 * @author 
	 **/

	function HasLablesTraitConstructor()
	{
		//
	}

	/* ------------------------------------------------------------------- RELATIONSHIP TO SERVICE -------------------------------------------------------------------*/

	public function Lables()
	{
		return $this->hasMany('App\Models\Lable');
	}
}