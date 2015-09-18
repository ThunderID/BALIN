<?php namespace Models;
use Validator;
use Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Eloquent {
	use  SoftDeletes;

	protected $guarded 			= array();
	protected $table 			= 'transactions';
	protected $fillable 		=	[
										'date', 
										'invoice_no',
										'coupon_code',
										'unique_number',
										'total_product_price', 
										'shipping_cost', 
										'total_discount',
										'total_price', 
										'status'
									];
	protected $rules			= 	[
										'date' 							=> 'required|date',
										'invoice_no'					=> 'required',
										'coupon_code' 					=> 'max:255',
										'unique_number' 				=> 'required',
										'total_product_price'			=> 'required',
										'total_price' 					=> 'required',
										'status' 						=> 'required'
									];										
	protected $errors 			=	[];

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

	/* ---------------------------------------------------------------------------- ERRORS ----------------------------------------------------------------------------*/
	/**
	 * return errors
	 *
	 * @return MessageBag
	 * @author 
	 **/
	function getError()
	{
		return $this->errors;
	}	
}