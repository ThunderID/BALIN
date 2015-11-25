<?php namespace App\Models\Traits\hasMany;

trait HasLablesTrait 
{

	/**
	 * boot
	 *
	 * @return void
	 * @author 
	 **/

	function HasLablesTraitConstructor()
	{
		//
	}

	/* ------------------------------------------------------------------- RELATIONSHIP TO SERVICE -------------------------------------------------------------------*/

	public function Lables()
	{
		return $this->hasMany('App\Models\Lable');
	}

	public function ScopeCurrentLables($query, $variable)
	{
		return $query->whereHas('lables', function($q)use($variable){$q->ondate('now');})->with(['lables' => function($q){$q->ondate('now');}]);
	}
}