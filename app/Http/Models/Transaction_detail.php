<?php namespace Models;
use Validator;
use Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction_detail extends Eloquent {
	use  SoftDeletes;

	protected $guarded = array();
	protected $table = 'transaction_details';
	protected $fillable = ['qty','price'];
	protected $errors = [];

	/* --------------------------------------------- RELATIONSHIP ---------------------------------------------*/
	//jamak untuk return jamak ('s')
		
	public function Product()
	{
	   return $this->belongsTo('\Models\Product');
	}

	public function Transaction()
	{
	   return $this->belongsTo('\Models\Transaction');
	}
}