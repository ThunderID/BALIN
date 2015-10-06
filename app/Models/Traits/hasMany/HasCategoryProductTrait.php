<?php namespace App\Models\Traits\hasMany;

trait HasCategoryProductTrait 
{

	/**
	 * boot
	 *
	 * @return void
	 * @author 
	 **/

	function HasCategoryProductTraitConstructor()
	{
		//
	}

	/* ------------------------------------------------------------------- RELATIONSHIP TO SERVICE -------------------------------------------------------------------*/

	public function CategoryProduct()
	{
		return $this->hasMany('App\Models\CategoryProduct');
	}

	public function scopeHasCategoryProduct($query, $variable)
	{
		return $query->whereHas('categoryproduct', function($q)use($variable){$q;});
	}

	public function scopeCategoryProductID($query, $variable)
	{
		return $query->whereHas('categoryproduct', function($q)use($variable){$q->id($variable);});
	}
}