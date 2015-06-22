<?php namespace Models;
use Validator;
use Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Eloquent {
	use  SoftDeletes;

	protected $guarded = array();
	protected $table = 'transactions';
	protected $fillable = ['date', 'coupon_code','unique_number', 'shipping_cost', 'total_payment', 'status'];
	protected $errors = [];

	/* --------------------------------------------- RELATIONSHIP ---------------------------------------------*/
	//jamak untuk return jamak ('s')
		
	public function Transaction_details()
	{
	   return $this->hasMany('\Models\Transaction_detail');
	}

	public function Customer()
	{
	   return $this->belongsTo('\Models\Customer');
	}

	public function Shipping()
	{
	   return $this->hasOne('\Models\Shipping');
	}

	public function Payment()
	{
	   return $this->hasOne('\Models\Payment');
	}	
}