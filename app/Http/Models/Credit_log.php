<?php namespace Models;
use Validator;
use Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class Credit_logs extends Eloquent {
	use  SoftDeletes;

	protected $guarded = array();
	protected $table = 'credit_logs';
	protected $fillable = ['transaction_name','ammount','date', 'expired_date'];
	protected $errors = [];

	/* --------------------------------------------- RELATIONSHIP ---------------------------------------------*/
	//jamak untuk return jamak ('s')
		
	public function customer()
	{
	   return $this->belongsTo('\Models\Customer');
	}
}