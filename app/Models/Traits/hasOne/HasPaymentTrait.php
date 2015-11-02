<?php namespace App\Models\Traits\hasOne;

trait HasPaymentTrait 
{

	/**
	 * boot
	 *
	 * @return void
	 * @author 
	 **/

	function HasPaymentTraitConstructor()
	{
		//
	}

	/* ------------------------------------------------------------------- RELATIONSHIP TO SERVICE -------------------------------------------------------------------*/

	public function Payment()
	{
		return $this->hasOne('App\Models\Payment');
	}

	public function scopeHasPayment($query, $variable)
	{
		return $query->whereHas('payment', function($q)use($variable){$q;});
	}

	public function scopePaymentID($query, $variable)
	{
		return $query->whereHas('payment', function($q)use($variable){$q->id($variable);});
	}
}