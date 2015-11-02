<?php namespace App\Models\Traits\MorphTo;

trait HasTransactionTrait 
{

	/**
	 * boot
	 *
	 * @return void
	 * @author 
	 **/

	function HasTransactionTraitConstructor()
	{
		//
	}

	public function Transaction()
	{
		return $this->morphTo();
	}

}