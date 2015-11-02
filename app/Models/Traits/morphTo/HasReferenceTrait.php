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
}