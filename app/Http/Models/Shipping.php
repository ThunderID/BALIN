<?php namespace Models;
use Validator;
use Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class Shipping extends Eloquent {
	use  SoftDeletes;

	protected $guarded = array();
	protected $table = 'shippings';
	protected $fillable = ['name','code','address', 'zip_code', 'phone', 'date'];
	protected $errors = [];

	/* --------------------------------------------- RELATIONSHIP ---------------------------------------------*/
	//jamak untuk return jamak ('s')
		
	public function courier()
	{
	   return $this->belongsTo('\Models\Courier');
	}

	public function Transaction()
	{
	   return $this->belongsTo('\Models\Transaction');
	}	
}