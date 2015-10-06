<?php namespace App\Models\Traits\hasMany;

trait HasStocksTrait 
{

	/**
	 * boot
	 *
	 * @return void
	 * @author 
	 **/

	function HasStocksTraitConstructor()
	{
		//
	}

	/* ------------------------------------------------------------------- RELATIONSHIP TO SERVICE -------------------------------------------------------------------*/

	public function Stocks()
	{
		return $this->hasMany('App\Models\Stock');
	}

	public function scopeHasStocks($query, $variable)
	{
		return $query->whereHas('stocks', function($q)use($variable){$q;});
	}

	public function scopeStockID($query, $variable)
	{
		return $query->whereHas('stocks', function($q)use($variable){$q->id($variable);});
	}
}