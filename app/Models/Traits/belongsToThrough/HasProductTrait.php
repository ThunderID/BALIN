<?php namespace App\Models\Traits\belongsToThrough;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Product;
use DB;

trait HasProductTrait 
{

	/**
	 * boot
	 *
	 * @return void
	 * @author 
	 **/

	function HasProductTraitConstructor()
	{
		//
	}

	/* ------------------------------------------------------------------- RELATIONSHIP TO SERVICE -------------------------------------------------------------------*/

	public function Product()
	{
	    $instance = new Product();
	    $instance->setTable('varians');
	    $query = $instance->newQuery();

	    return (new BelongsTo($query, $this, 'varian_id', $instance->getKeyName(), 'product'))
	        ->join('products', 'products.id', '=', 'varians.product_id')
	        ->select(DB::raw('products.*'));
	}

	public function scopeHasProduct($query, $variable)
	{
		return $query->whereHas('product', function($q)use($variable){$q;});
	}

	public function scopeProductID($query, $variable)
	{
		return $query->whereHas('product', function($q)use($variable){$q->id($variable);});
	}

	public function scopeProductName($query, $variable)
	{
		return $query->whereHas('product', function($q)use($variable){$q->name($variable);});
	}
}