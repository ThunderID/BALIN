<?php namespace App\Models\Traits\belongsTo;

trait HasCourierTrait 
{

	/**
	 * boot
	 *
	 * @return void
	 * @author 
	 **/

	function HasCourierTraitConstructor()
	{
		//
	}

	/* ------------------------------------------------------------------- RELATIONSHIP TO SERVICE -------------------------------------------------------------------*/

	public function Courier()
	{
		return $this->belongsTo('App\Models\Courier');
	}

	public function scopeHasCourier($query, $variable)
	{
		return $query->whereHas('courier', function($q)use($variable){$q;});
	}

	public function scopeCourierID($query, $variable)
	{
		return $query->whereHas('courier', function($q)use($variable){$q->id($variable);});
	}

	public function scopeCourierNotID($query, $variable)
	{
		return $query->whereDoesntHave('courier', function($q)use($variable){$q->id($variable);});
	}
}