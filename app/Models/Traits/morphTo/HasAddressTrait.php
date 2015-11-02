<?php namespace App\Models\Traits\morphTo;

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

    public function owner()
    {
        return $this->morphTo();
    }
}