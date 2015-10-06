<?php namespace App\Models\Traits\hasMany;

trait HasProductAttributesTrait 
{

	/**
	 * boot
	 *
	 * @return void
	 * @author 
	 **/

	function HasProductAttributesTraitConstructor()
	{
		//
	}

	/* ------------------------------------------------------------------- RELATIONSHIP TO SERVICE -------------------------------------------------------------------*/

	public function ProductAttributes()
	{
		return $this->hasMany('App\Models\ProductAttribute');
	}

	public function scopeHasProductAttributes($query, $variable)
	{
		return $query->whereHas('productattributes', function($q)use($variable){$q;});
	}

	public function scopeProductAttributeID($query, $variable)
	{
		return $query->whereHas('productattributes', function($q)use($variable){$q->id($variable);});
	}
}