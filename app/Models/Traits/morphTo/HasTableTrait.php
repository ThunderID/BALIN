<?php namespace App\Models\Traits\morphTo;

trait HasTableTrait 
{

	/**
	 * boot
	 *
	 * @return void
	 * @author 
	 **/

	function HasTableTraitConstructor()
	{
		//
	}

    public function table()
    {
        return $this->morphTo();
    }

    public function tablereference()
    {
        return $this->morphTo('table');
    }
}