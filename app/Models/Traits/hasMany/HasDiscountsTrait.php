<?php namespace App\Models\Traits\hasMany;

trait HasDiscountsTrait 
{

	/**
	 * boot
	 *
	 * @return void
	 * @author 
	 **/

	function HasDiscountsTraitConstructor()
	{
		//
	}

	/* ------------------------------------------------------------------- RELATIONSHIP TO SERVICE -------------------------------------------------------------------*/

	public function Discounts()
	{
		return $this->hasMany('App\Models\Discount');
	}

	public function scopeHasDiscounts($query, $variable)
	{
		return $query->whereHas('discounts', function($q)use($variable){$q;});
	}

	public function scopeDiscountID($query, $variable)
	{
		return $query->whereHas('discounts', function($q)use($variable){$q->id($variable);});
	}
}