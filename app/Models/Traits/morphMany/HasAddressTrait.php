<?php namespace App\Models\Traits\morphMany;

trait HasAddressTrait 
{

	/**
	 * boot
	 *
	 * @return void
	 * @author 
	 **/

	function HassAddressTraitConstructor()
	{
		//
	}

	public function Addreses()
	{
		return $this->morphMany('App\Models\Address', 'address');
	}
}