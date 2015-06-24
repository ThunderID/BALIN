<?php namespace Models;
use Validator;
use Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class Credit_log extends Eloquent {
	use  SoftDeletes;

	protected $guarded 				= array();
	protected $table 				= 'credit_logs';
	protected $fillable				=	[
											'name',
											'debet',
											'credit',
											'date',
											'expired_date'
										];
	protected $rules				= 	[
											'name' 							=> 'required|max:255',
											'debet' 						=> 'required',
											'credit' 						=> 'required',
											'date' 							=> 'required|date',
											'expired_date' 					=> 'required|date'
										];										
	protected $errors 				=	[];

	/* --------------------------------------------- RELATIONSHIP ---------------------------------------------*/
	//jamak untuk return jamak ('s')
		
	public function customer()
	{
	   return $this->belongsTo('\Models\Customer', 'coupon_code');
	}

	/* ---------------------------------------------------------------------------- SCOPE -------------------------------------------------------------------------------*/

	public function scopeCredit($query, $variable)
	{
		return $query->where('coupon_code', '=' ,$variable)->where('credit','>',0);
	}

	public function scopeDebet($query, $variable)
	{
		return $query->where('coupon_code', '=' ,$variable)->where('debet','>',0);
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