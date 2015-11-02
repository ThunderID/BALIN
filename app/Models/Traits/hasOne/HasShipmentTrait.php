<?php namespace App\Models\Traits\hasOne;

trait HasShipmentTrait 
{

	/**
	 * boot
	 *
	 * @return void
	 * @author 
	 **/

	function HasShipmentTraitConstructor()
	{
		//
	}

	/* ------------------------------------------------------------------- RELATIONSHIP TO SERVICE -------------------------------------------------------------------*/

	public function Shipment()
	{
		return $this->hasOne('App\Models\Shipment');
	}

	public function scopeHasShipment($query, $variable)
	{
		return $query->whereHas('shipment', function($q)use($variable){$q;});
	}

	public function scopeShipmentID($query, $variable)
	{
		return $query->whereHas('shipment', function($q)use($variable){$q->id($variable);});
	}
}