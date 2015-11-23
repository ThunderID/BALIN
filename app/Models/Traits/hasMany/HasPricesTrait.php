<?php namespace App\Models\Traits\hasMany;

use DB;

trait HasPricesTrait 
{

	/**
	 * boot
	 *
	 * @return void
	 * @author 
	 **/

	function HasPricesTraitConstructor()
	{
		//
	}

	/* ------------------------------------------------------------------- RELATIONSHIP TO SERVICE -------------------------------------------------------------------*/

	public function Prices()
	{
		return $this->hasMany('App\Models\Price');
	}

	public function scopeHasPrices($query, $variable)
	{
		return $query->whereHas('prices', function($q)use($variable){$q;});
	}

	public function scopePriceID($query, $variable)
	{
		return $query->whereHas('prices', function($q)use($variable){$q->id($variable);});
	}

	public function scopeCurrentPrice($query, $variable)
	{
		return $query
			->selectraw('prices.price as current_price')
			->selectraw('prices.promo_price as current_promo_price')
			 ->leftjoin('prices', function ($join) use($variable) 
			 {
                                    $join->on ( 'prices.product_id', '=', 'products.id' )
									->on(DB::raw('(prices.started_at = (select max(started_at) from prices as tl2 where tl2.product_id = prices.product_id and tl2.deleted_at is null and tl2.started_at <= "'.date('Y-m-d H:i:s').'"))'), DB::raw(''), DB::raw(''))
                                    ->where('prices.started_at', '<=', date('Y-m-d H:i:s'))
                                    ->wherenull('prices.deleted_at')
                                    ;
			})
			 ;
		return $query->whereHas('prices', function($q)use($variable){$q->ondate('now');})->with(['prices' => function($q){$q->ondate('now');}]);
	}
}