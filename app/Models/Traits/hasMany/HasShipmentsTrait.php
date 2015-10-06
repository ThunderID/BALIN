<?php namespace App\Models\Traits\hasMany;

trait HasShipmentsTrait 
{

	/**
	 * boot
	 *
	 * @return void
	 * @author 
	 **/

	function HasShipmentsTraitConstructor()
	{
		//
	}

	/* ------------------------------------------------------------------- RELATIONSHIP TO SERVICE -------------------------------------------------------------------*/

	public function Shipments()
	{
		return $this->hasMany('App\Models\Shipment');
	}

	public function scopeHasShipments($query, $variable)
	{
		return $query->whereHas('shipments', function($q)use($variable){$q;});
	}

	public function scopeShipmentID($query, $variable)
	{
		return $query->whereHas('shipments', function($q)use($variable){$q->id($variable);});
	}
}