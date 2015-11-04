<?php namespace App\Models\Traits\morphTo;

trait HasReferenceTrait 
{

	/**
	 * boot
	 *
	 * @return void
	 * @author 
	 **/

	function HasReferenceTraitConstructor()
	{
		//
	}

    public function reference()
    {
        return $this->morphTo();
    }

    public function scopeReferenceID($query, $variable)
    {
		return $query->where('reference_id', $variable);
    }

    public function scopeReferenceType($query, $variable)
    {
		return $query->where('reference_type', $variable);
    }
}