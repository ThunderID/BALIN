<?php namespace App\Models\Traits\hasMany;

trait HasProductImagesTrait 
{

	/**
	 * boot
	 *
	 * @return void
	 * @author 
	 **/

	function HasProductImagesTraitConstructor()
	{
		//
	}

	/* ------------------------------------------------------------------- RELATIONSHIP TO SERVICE -------------------------------------------------------------------*/

	public function ProductImages()
	{
		return $this->hasMany('App\Models\ProductImage');
	}

	public function scopeHasProductImages($query, $variable)
	{
		return $query->whereHas('productimages', function($q)use($variable){$q;});
	}

	public function scopeProductImageID($query, $variable)
	{
		return $query->whereHas('productimages', function($q)use($variable){$q->id($variable);});
	}
}