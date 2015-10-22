<?php namespace App\Models\Traits\MorphTo;

trait HasUserTrait 
{

	/**
	 * boot
	 *
	 * @return void
	 * @author 
	 **/

	function HasUserTraitConstructor()
	{
		//
	}

	public function User()
	{
		return $this->morphTo();
	}

}