<?php namespace Models;
use Validator;
use Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class CourierBranches extends Eloquent {
	use  SoftDeletes;

	protected $guarded 				= array();
	protected $table 				= 'courier_branches';
	protected $fillable				= 	[
											'name',
											'status',
											'phone',
											'address'
										];
	protected $rules				= 	[
											'name' 						=> 'required|max:255',
											'status' 					=> 'required|numeric',
											'phone' 					=> 'max:255',
											'address' 					=> 'max:255'
										];													  
	protected $errors 				= 	[];

	/* --------------------------------------------- RELATIONSHIP ---------------------------------------------*/
	//jamak untuk return jamak ('s')

	public function Shippings()
	{
	   return $this->hasMany('\Models\Shipping');
	}

	public function Courier()
	{
	   return $this->belongsTo('\Models\Courier');
	}

	/* ---------------------------------------------------------------------------- SCOPE -------------------------------------------------------------------------------*/

	public function scopeId($query, $variable)
	{
		return $query->where('status', '=' , 1);
	}

	public function scopeStatus($query, $variable)
	{
		return $query->where('status', '=' , $variable);
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