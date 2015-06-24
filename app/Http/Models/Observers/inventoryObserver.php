<?php namespace Models\Observers;

use \Validator;

/* ----------------------------------------------------------------------
 * Event:
 * 	Saving		
 * 	Deleting						
 * ---------------------------------------------------------------------- */

class InventoryObserver 
{
	public function saving($model)
	{
		$validator 					= Validator::make($model['attributes'], $model['rules']);

		if ($validator->passes())
		{
			if(make($model['attributes']['number_of_Stock'] > 0)
			{
				return true;
			}else{
				$model['errors'] 	= 'Stok harus lebih besar dari 0';

				return false;
			}
		}
		else
		{
			$model['errors'] 		= $validator->errors();

			return false;
		}
	}

	public function deleting($model)
	{
		if($model->Product->count())
		{
			$model['errors'] 	= ['Tidak dapat menghapus data inventori'];

			return false;
		}

		return true;
	}

}