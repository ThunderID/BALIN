<?php namespace Models;
use Validator;
use Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Eloquent {
	use  SoftDeletes;

	protected $guarded = array();
	protected $table = 'customers';
	protected $fillable = ['name','email','dob', 'address', 'zip_code', 'phone', 'gender', 'coupon_code', 'coupon_balance', 'profile_photo', 'join_date', 'sso_data', 'sso_type', 'sso_id', 'remember_token'];
	protected $errors = [];

	/* --------------------------------------------- RELATIONSHIP ---------------------------------------------*/
	//jamak untuk return jamak ('s')
		
	public function Credit_logs()
	{
	   return $this->HasMany('\Models\Credit_log');
	}

	public function Transactions()
	{
	   return $this->HasMany('\Models\Transaction');
	}	
}