<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;

use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class User extends Eloquent implements AuthenticatableContract, CanResetPasswordContract, AuthorizableContract 
{
    use Authenticatable, CanResetPassword, Authorizable;

	use SoftDeletes;

	/**
	 * The trait used by the model.
	 *
	 * @var string
	 */

	use \App\Models\Traits\hasMany\HasTransactionsTrait;
	use \App\Models\Traits\hasMany\HasPointLogsTrait;
	use \App\Models\Traits\hasMany\HasQuotaLogsTrait;
	use \App\Models\Traits\hasMany\HasAuditorsTrait;
	use \App\Models\Traits\morphMany\HasImagesTrait;
	use \App\Models\Traits\morphMany\HasAddressesTrait;

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
											'role'							,
											'is_active'						,
											'sso_id'						,
											'sso_media'						,
											'sso_data'						,
											'gender'						,
											'date_of_birth'					,
											'activation_link'				,
											'reset_password_link'			,
											'expired_at'					,
										];

	/**
	 * Timestamp field
	 *
	 * @var array
	 */
	protected $dates				=	['created_at', 'updated_at', 'deleted_at', 'joined_at', 'expired_at', 'date_of_birth'];

	/**
	 * Basic rule of database
	 *
	 * @var array
	 */
	protected $rules				=	[
											'name'							=> 'required|max:255',
											'email'							=> 'max:255|email',
											'role'							=> 'required|max:255',
											'referral_code'					=> 'max:8',
											// 'date_of_birth'					=> 'date_format:"Y-m-d H:i:s"|before:now'
										];

	/**
	 * The appends attributes from mutator and accessor
	 *
	 * @var array
	 */
	protected $appends				=	[
											'balance',
											'quota',
											'downline',
											'avatar',
											'phone',
											'address',
											'zipcode',
											'reference',
										];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden 				= ['password', 'remember_token'];

	
	/* ---------------------------------------------------------------------------- MUTATOR ---------------------------------------------------------------------------------*/

	/* ---------------------------------------------------------------------------- ACCESSOR --------------------------------------------------------------------------------*/

	public function getReferenceAttribute($value)
	{
		$reference 						= PointLog::userid($this->id)->referencetype('App\Models\User')->first();

		if($reference)
		{
			return $reference->reference->name;
		}

		return null;
	}

	public function getDownlineAttribute($value)
	{
		$quota 							= PointLog::referenceid($this->id)->referencetype('App\Models\User')->count();

		return $quota;
	}

	public function getQuotaAttribute($value)
	{
		$quota 							= QuotaLog::userid($this->id)->sum('amount');

		return $quota;
	}

	public function getBalanceAttribute($value)
	{
		$balance 						= PointLog::userid($this->id)->onactive('now')->sum('amount');

		return $balance;
	}

	public function getPhoneAttribute($value)
	{
		$phone 							= '';

		if($this->addresses->count())
		{
			$phone 						= $this->addresses[0]->phone;
		}

		return $phone;
	}

	public function getAddressAttribute($value)
	{
		$address 						= '';

		if($this->addresses->count())
		{
			$address 					= $this->addresses[0]->address;
		}

		return $address;
	}

	public function getZipcodeAttribute($value)
	{
		$zipcode 						= '';

		if($this->addresses->count())
		{
			$zipcode 					= $this->addresses[0]->zipcode;
		}

		return $zipcode;
	}

	public function getAvatarAttribute($value)
	{
		$avatar 						= 'https://browshot.com/static/images/not-found.png';

		if($this->images->count())
		{
			$avatar 					= $this->images[0]->image_xs;
		}

		return $avatar;
	}

	/* ---------------------------------------------------------------------------- FUNCTIONS -------------------------------------------------------------------------------*/
	
	/**
	 * return errors
	 *
	 * @return MessageBag
	 * @author 
	 **/
	public function getError()
	{
		return $this->errors;
	}

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

	public function scopeRole($query, $variable)
	{
		if(is_array($variable))
		{
			return 	$query->whereIn('role', $variable);
		}

		return 	$query->where('role', $variable);
	}

	public function scopeCustomer($query, $variable)
	{
		return 	$query->where('role', 'customer');
	}

	public function scopeEmail($query, $variable)
	{
		return 	$query->where('email', $variable);
	}
	
	public function scopeName($query, $variable)
	{
		return 	$query->where('name', 'like', '%'.$variable.'%');
	}

	public function scopeActive($query, $variable)
	{
		return 	$query->ReferralCode($variable)->where('is_active', true);
	}

	public function scopeReferralCode($query, $variable)
	{
		return 	$query->where('referral_code', $variable);
	}

	public function scopeBalance($query, $variable)
	{
		$expired 				= date('Y-m-d H:i:s', strtotime($variable));

		return 	$query->selectraw('users.*')
						->selectraw('(SELECT sum(amount) from point_logs where point_logs.user_id = users.id and users.deleted_at is null and expired_at <= "'.$expired.'") as total_balance')
						->orderby('total_balance', 'desc')
						;
	}
}
