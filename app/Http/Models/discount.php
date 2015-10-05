<?php namespace Models;
use Validator;
use Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class Discount extends Eloquent {
	use  SoftDeletes;

	protected $guarded 				= array();
	protected $table 				= 'discounts';
	protected $fillable 			=	[
											'promo_price',
											'start_date',
											'end_date',
										];
	protected $rules				= 	[
											'promo_price' 			=> 'required|numeric',
											'start_date' 			=> 'required|date',
											'end_date' 				=> 'required|date',
										];										
	protected $errors 				=	[];

	/* --------------------------------------------- RELATIONSHIP ---------------------------------------------*/
	//jamak untuk return jamak ('s')
	public function product()
	{
	   return $this->belongsTo('\Models\product');
	}

	/* --------------------------------------------- SCOPE ---------------------------------------------*/
	public function scopeLatestDiscount($query)
	{
		return $query
			->where('end_date', '>=' , date("Y-m-d", strtotime('NOW')))
			->where('start_date', '<=' , date("Y-m-d", strtotime('NOW')))
			->orderBy('id','desc')
		;
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