<?php namespace App\Models\Traits\hasMany;

trait HasPointLogsTrait 
{

	/**
	 * boot
	 *
	 * @return void
	 * @author 
	 **/

	function HasPointLogsTraitConstructor()
	{
		//
	}

	/* ------------------------------------------------------------------- RELATIONSHIP TO SERVICE -------------------------------------------------------------------*/

	public function PointLogs()
	{
		return $this->hasMany('App\Models\PointLog');
	}

	public function scopeHasPointLogs($query, $variable)
	{
		return $query->whereHas('pointlogs', function($q)use($variable){$q;});
	}

	public function scopePointLogID($query, $variable)
	{
		return $query->whereHas('pointlogs', function($q)use($variable){$q->id($variable);});
	}
}