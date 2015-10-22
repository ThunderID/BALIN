<?php namespace App\Models\Traits\MorphTo;

trait HasCourierTrait 
{

	/**
	 * boot
	 *
	 * @return void
	 * @author 
	 **/

	function HasCourierTraitConstructor()
	{
		//
	}

	public function Courier()
	{
		return $this->morphTo();
	}

}