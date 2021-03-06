<?php namespace App\Models\Traits\hasOne;

trait HasVoucherTrait 
{

	/**
	 * boot
	 *
	 * @return void
	 * @author 
	 **/

	function HasVoucherTraitConstructor()
	{
		//
	}

	/* ------------------------------------------------------------------- RELATIONSHIP TO SERVICE -------------------------------------------------------------------*/

	public function Voucher()
	{
		return $this->hasOne('App\Models\Voucher');
	}

	public function scopeHasVoucher($query, $variable)
	{
		return $query->whereHas('voucher', function($q)use($variable){$q;});
	}

	public function scopeVoucherID($query, $variable)
	{
		return $query->whereHas('voucher', function($q)use($variable){$q->id($variable);});
	}

	public function scopeVoucherCode($query, $variable)
	{
		return $query->whereHas('voucher', function($q)use($variable){$q->code($variable);});
	}
}