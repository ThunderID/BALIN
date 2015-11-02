<?php namespace App\Models\Traits\belongsTo;

trait HasPointLogTrait 
{

	/**
	 * boot
	 *
	 * @return void
	 * @author 
	 **/

	function HasPointLogTraitConstructor()
	{
		//
	}

	/* ------------------------------------------------------------------- RELATIONSHIP TO SERVICE -------------------------------------------------------------------*/

	public function PointLog()
	{
		return $this->belongsTo('App\Models\PointLog');
	}

	public function scopeHasPointLog($query, $variable)
	{
		return $query->whereHas('pointlog', function($q)use($variable){$q;});
	}

	public function scopePointLogID($query, $variable)
	{
		return $query->whereHas('pointlog', function($q)use($variable){$q->id($variable);});
	}
}