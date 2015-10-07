<?php namespace App\Models\Traits\hasMany;

trait HasShippingCostsTrait 
{

	/**
	 * boot
	 *
	 * @return void
	 * @author 
	 **/

	function HasShippingCostsTraitConstructor()
	{
		//
	}

	/* ------------------------------------------------------------------- RELATIONSHIP TO SERVICE -------------------------------------------------------------------*/

	public function ShippingCosts()
	{
		return $this->hasMany('App\Models\ShippingCost');
	}

	public function scopeHasShippingCosts($query, $variable)
	{
		return $query->whereHas('shippingcosts', function($q)use($variable){$q;});
	}

	public function scopeShippingCostID($query, $variable)
	{
		return $query->whereHas('shippingcosts', function($q)use($variable){$q->id($variable);});
	}
}