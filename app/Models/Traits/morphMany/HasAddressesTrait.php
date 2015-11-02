<?php namespace App\Models\Traits\morphMany;

trait HasAddressesTrait 
{

	/**
	 * boot
	 *
	 * @return void
	 * @author 
	 **/

	function HasAddressesTraitConstructor()
	{
		//
	}

	public function Addresses()
	{
		return $this->morphMany('App\Models\Address', 'owner');
	}


}