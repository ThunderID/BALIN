<?php namespace Models;
use Validator;
use Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class Price extends Eloquent {
	use  SoftDeletes;

	protected $guarded 				= array();
	protected $table 				= 'prices';
	protected $fillable 			=	[
											'price',
											'start_date',
										];
	protected $rules				= 	[
											'price' 				=> 'required|numeric',
											'start_date' 			=> 'required|date',
										];										
	protected $errors 				=	[];

	/* --------------------------------------------- RELATIONSHIP ---------------------------------------------*/
	//jamak untuk return jamak ('s')
	public function product()
	{
	   return $this->belongsTo('\Models\product');
	}

	/* --------------------------------------------- SCOPE ---------------------------------------------*/
	public function scopeLatestPrice($query)
	{
		return $query
			->orderBy('start_date','desc')
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