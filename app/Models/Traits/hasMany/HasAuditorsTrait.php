<?php namespace App\Models\Traits\hasMany;

trait HasAuditorsTrait 
{

	/**
	 * boot
	 *
	 * @return void
	 * @author 
	 **/

	function HasAuditorsTraitConstructor()
	{
		//
	}

	/* ------------------------------------------------------------------- RELATIONSHIP TO SERVICE -------------------------------------------------------------------*/

	public function Auditors()
	{
		return $this->hasMany('App\Models\Auditor');
	}

	public function scopeHasAuditors($query, $variable)
	{
		return $query->whereHas('auditors', function($q)use($variable){$q;});
	}

	public function scopeAuditorID($query, $variable)
	{
		return $query->whereHas('auditors', function($q)use($variable){$q->id($variable);});
	}
}