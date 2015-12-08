<?php namespace App\Models\Traits\morphMany;

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

	public function PointLogs()
	{
		return $this->morphMany('App\Models\PointLog', 'reference');
	}

	public function scopeOfPointLogUserId($q, $v)
	{
		return $this->whereHas('PointLogs', function($q) use ($v) { 
			$q->where('point_logs.user_id', '=', $v);
		});
	}
}