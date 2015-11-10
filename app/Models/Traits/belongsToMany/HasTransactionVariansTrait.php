<?php namespace App\Models\Traits\belongsToMany;

trait HasTransactionVariansTrait 
{

	/**
	 * boot
	 *
	 * @return void
	 * @author 
	 **/

	function HasTransactionVariansTraitConstructor()
	{
		//
	}

	/* ------------------------------------------------------------------- RELATIONSHIP TO SERVICE -------------------------------------------------------------------*/

	public function Varians()
	{
		return $this->belongsToMany('App\Models\Varian', 'transaction_details');
	}
}