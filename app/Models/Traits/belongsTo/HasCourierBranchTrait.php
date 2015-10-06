<?php namespace App\Models\Traits\belongsTo;

trait HasCourierBranchTrait 
{

	/**
	 * boot
	 *
	 * @return void
	 * @author 
	 **/

	function HasCourierBranchTraitConstructor()
	{
		//
	}

	/* ------------------------------------------------------------------- RELATIONSHIP TO SERVICE -------------------------------------------------------------------*/

	public function CourierBranch()
	{
		return $this->belongsTo('App\Models\CourierBranch');
	}

	public function scopeHasCourierBranch($query, $variable)
	{
		return $query->whereHas('courierbranch', function($q)use($variable){$q;});
	}

	public function scopeCourierBranchID($query, $variable)
	{
		return $query->whereHas('courierbranch', function($q)use($variable){$q->id($variable);});
	}
}