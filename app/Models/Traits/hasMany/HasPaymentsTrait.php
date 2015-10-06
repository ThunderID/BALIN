<?php namespace App\Models\Traits\hasMany;

trait HasPaymentsTrait 
{

	/**
	 * boot
	 *
	 * @return void
	 * @author 
	 **/

	function HasPaymentsTraitConstructor()
	{
		//
	}

	/* ------------------------------------------------------------------- RELATIONSHIP TO SERVICE -------------------------------------------------------------------*/

	public function Payments()
	{
		return $this->hasMany('App\Models\Payment');
	}

	public function scopeHasPayments($query, $variable)
	{
		return $query->whereHas('payments', function($q)use($variable){$q;});
	}

	public function scopePaymentID($query, $variable)
	{
		return $query->whereHas('payments', function($q)use($variable){$q->id($variable);});
	}
}