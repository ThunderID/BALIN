<?php namespace Models;
use Validator;
use Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class Setting extends Eloquent {
	use  SoftDeletes;

	protected $guarded = array();
	protected $table = 'settings';
	protected $fillable = ['setting','value'];
	protected $errors = [];
}