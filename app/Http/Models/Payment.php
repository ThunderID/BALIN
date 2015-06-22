<?php namespace Models;
use Validator;
use Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Eloquent {
	use  SoftDeletes;

	protected $guarded = array();
	protected $table = 'payments';
	protected $fillable = ['name','bank','account_number', 'date'];
	protected $errors = [];

	/* --------------------------------------------- RELATIONSHIP ---------------------------------------------*/
	//jamak untuk return jamak ('s')
		
	public function courier()
	{
	   return $this->belongsTo('\Models\Transaction');
	}
}