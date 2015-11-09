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

    public function scopeOwnerID($query, $variable)
    {
		return $query->where('owner_id', $variable);
    }

    public function scopeOwnerType($query, $variable)
    {
		return $query->where('owner_type', $variable);
    }
}