<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Eloquent implements AuthenticatableContract, CanResetPasswordContract 
{
    use Authenticatable, CanResetPassword;

	use SoftDeletes;

	/**
	 * The trait used by the model.
	 *
	 * @var string
	 */

	use \App\Models\Traits\hasMany\HasTransactionsTrait;
	use \App\Models\Traits\hasMany\HasPointLogsTrait;
	use \App\Models\Traits\MorphMany\HasImagesTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table				= 'users';

	// public $timestamps				= true;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */

	protected $fillable				=	[
											'name'							,
											'email'							,
											'password'						,
											'referral_code'					,
											'balance'						,
											'avatar'						,
											'role'							,
											'is_active'						,
											'sso_id'						,
											'sso_media'						,
											'sso_data'						,
											'gender'						,
											'date_of_birth'					,
											'address'						,
											'phone'							,
											'postal_code'					,
											'joined_at'						,
											'activation_link'				,
											'reset_password_link'			,
											'expired_at'					,
										];

	/**
	 * Timestamp field
	 *
	 * @var array
	 */
	protected $dates				=	['created_at', 'updated_at', 'deleted_at', 'joined_at', 'expired_at'];

	/**
	 * Basic rule of database
	 *
	 * @var array
	 */
	protected $rules				=	[
											'name'							=> 'required|max:255',
											'email'							=> 'required|max:255',
											'password'						=> 'required|max:255',
										];

	/**
	 * The appends attributes from mutator and accessor
	 *
	 * @var array
	 */
	protected $appends				=	[
										];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden 				= ['password', 'remember_token'];

	
	/* ---------------------------------------------------------------------------- MUTATOR ---------------------------------------------------------------------------------*/

	/* ---------------------------------------------------------------------------- ACCESSOR --------------------------------------------------------------------------------*/

	/* ---------------------------------------------------------------------------- FUNCTIONS -------------------------------------------------------------------------------*/
	
	/* ---------------------------------------------------------------------------- SCOPE -------------------------------------------------------------------------------*/

	/* ---------------------------------------------------------------------------- QUERY BUILDER ---------------------------------------------------------------------------*/

	public function scopeID($query, $variable)
	{
		if(is_array($variable))
		{
			return 	$query->whereIn('id', $variable);
		}

		return 	$query->where('id', $variable);
	}

	public function scopeCustomer($query, $variable)
	{
		return 	$query->where('role', 'customer');
	}

	public function scopeReferralCode($query, $variable)
	{
		return 	$query->where('referral_code', $variable);
	}

	public function scopeActive($query, $variable)
	{
		return 	$query->ReferralCode($variable)->where('is_active', true);
	}
}
