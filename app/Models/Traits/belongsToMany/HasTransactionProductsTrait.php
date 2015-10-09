<?php namespace App\Models\Traits\belongsToMany;

trait HasTransactionProductsTrait 
{

	/**
	 * boot
	 *
	 * @return void
	 * @author 
	 **/

	function HasTransactionProductsTraitConstructor()
	{
		//
	}

	/* ------------------------------------------------------------------- RELATIONSHIP TO SERVICE -------------------------------------------------------------------*/

	public function Products()
	{
		return $this->belongsToMany('App\Models\Product', 'transaction_details');
	}
}