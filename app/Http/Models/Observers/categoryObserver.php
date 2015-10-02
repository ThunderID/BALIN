<?php namespace Models\Observers;

use \Validator;
use Models\category;

/* ----------------------------------------------------------------------
 * Event:
 * 	Saving		
 * 	Updating
 * 	Created
 * 	Deleting						
 * ---------------------------------------------------------------------- */

class categoryObserver 
{
	public function saving($model)
	{
		$validator 				= Validator::make($model['attributes'], $model['rules']);

		if ($validator->passes())
		{
			$ruleUniq			= [
									'prefix' 	=>	'unique:categories,prefix,'.(isset($model['attributes']['id']) ? $model['attributes']['id'] : '')
								  ];

			$validator		= Validator::make($model['attributes'], $ruleUniq);
			
			if($validator->passes())
			{
				return true;
			}
			else 
			{
				$model['errors'] 	= $validator->errors();

				return false;
			}
		}
		else
		{
			$model['errors'] 	= $validator->errors();

			return false;
		}
	}

	public function updating($model)
	{
		if(isset($model->getDirty()['parent_id']) || !isset($model->getDirty()['path']))
		{
			if($model->category()->count())
			{
				$model->path = $model->category->path . "," . $model->id;
			}
			else
			{
				$model->path = $model->id;
			}

			if(isset($model->getOriginal()['path']))
			{
				$childs							= Category::orderBy('path','asc')
													->where('path','like',$model->getOriginal()['path'] . ',%')
													->get();
				foreach ($childs as $child) 
				{
					$child->update(['path' => preg_replace('/'. $model->getOriginal()['path'].',/', $model->path . ',', $child->path,1)]);	
					print_r($child->path);
				}
			}
			return true;
		}
	}

	public function created($model)
	{
		$model->path = $model->id;
		$model->save();
		return true;
	}	

	public function deleting($model)
	{
		if($model->categoryProducts()->count())
		{
			$model['errors'] 	= 'Tidak bisa menghapus kategori yang memiliki produk';

			return false;
		}

		$childs							= Category::orderBy('path','desc')
											->where('path','like',$model->path . ',%')
											->get();

		foreach ($childs as $child) 
		{
			if($child->categoryProducts()->count())
			{
				$model['errors'] 	= 'Tidak bisa menghapus kategori yang memiliki produk';

				return false;
			}
			else
			{
				$child->delete();
			}
		}
		return true;
	}

}