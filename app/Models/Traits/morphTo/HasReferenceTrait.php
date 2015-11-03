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
		return $query->whereHas('reference', function($q)use($variable){$q->id($variable);});
    }
}