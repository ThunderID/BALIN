<?php namespace App\Models\Traits\hasMany;

trait HasVouchersTrait 
{

	/**
	 * boot
	 *
	 * @return void
	 * @author 
	 **/

	function HasVouchersTraitConstructor()
	{
		//
	}

	/* ------------------------------------------------------------------- RELATIONSHIP TO SERVICE -------------------------------------------------------------------*/

	public function Vouchers()
	{
		return $this->hasMany('App\Models\Voucher');
	}

	public function scopeHasVouchers($query, $variable)
	{
		return $query->whereHas('vouchers', function($q)use($variable){$q;});
	}
}