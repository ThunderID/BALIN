<?php namespace App\Models\Observers;

use \Validator;

/* ----------------------------------------------------------------------
 * Event:
 * 	Saving		
 * 	Updating
 * 	Created
 * 	Deleting						
 * ---------------------------------------------------------------------- */

class TransactionObserver 
{
	public function saved($model)
	{
		return false;
	}

}