<?php namespace Models;
use Validator;
use Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Eloquent {
	use  SoftDeletes;

	protected $guarded 				= array();
	protected $table 				= 'customers';
	protected $fillable 			=	[
											'name',
											'email',
											'dob', 
											'address',
											'zip_code', 
											'phone', 
											'gender', 
											'coupon_code', 
											'coupon_balance', 
											'profile_photo', 
											'join_date', 
											'sso_data', 
											'sso_type', 
											'sso_id',
											'password', 
											'remember_token'
										];
	protected $rules				= 	[
											'name' 						=> 'required|max:255',
											'email' 					=> 'required|max:255',
											'dob' 						=> 'required|date',
											'address' 					=> 'required',
											'phone' 					=> 'required',
											'gender'					=> 'required', 
											'password' 					=> 'max:255',
											'join_date' 				=> 'required|date'
										];										
	protected $errors 				=	[];

	/* --------------------------------------------- RELATIONSHIP ---------------------------------------------*/
	//jamak untuk return jamak ('s')
		
	public function Credit_logs()
	{
	   return $this->HasMany('\Models\Credit_log','coupon_code');
	}

	public function Transactions()
	{
	   return $this->HasMany('\Models\Transaction');
	}	

	/* ---------------------------------------------------------------------------- SCOPE -------------------------------------------------------------------------------*/

	public function scopeCouponCode($query, $variable)
	{
		return $query->where('coupon_code', '=' ,$variable);
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