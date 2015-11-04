<?php namespace App\Models\Traits\belongsTo;

trait HasAddressTrait 
{

	/**
	 * boot
	 *
	 * @return void
	 * @author 
	 **/

	function HasAddressTraitConstructor()
	{
		//
	}

	/* ------------------------------------------------------------------- RELATIONSHIP TO SERVICE -------------------------------------------------------------------*/

	public function Address()
	{
		return $this->belongsTo('App\Models\Address');
	}

	public function scopeHasAddress($query, $variable)
	{
		return $query->whereHas('address', function($q)use($variable){$q;});
	}

	public function scopeAddressID($query, $variable)
	{
		return $query->whereHas('address', function($q)use($variable){$q->id($variable);});
	}
}