<?php namespace App\Models\Traits\belongsTo;

trait HasCategoryTrait 
{

	/**
	 * boot
	 *
	 * @return void
	 * @author 
	 **/

	function HasCategoryTraitConstructor()
	{
		//
	}

	/* ------------------------------------------------------------------- RELATIONSHIP TO SERVICE -------------------------------------------------------------------*/

	public function Category()
	{
		return $this->belongsTo('App\Models\GlobalCategory');
	}

	public function scopeHasCategory($query, $variable)
	{
		return $query->whereHas('category', function($q)use($variable){$q;});
	}

	public function scopeCategoryID($query, $variable)
	{
		return $query->whereHas('category', function($q)use($variable){$q->id($variable);});
	}
}