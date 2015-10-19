<?php namespace App\Models;

use Illuminate\Foundation\Bus\DispatchesJobs;

use Validator, Event;

/* ----------------------------------------------------------------------
 * Event:
 * 	Saving						
 * ---------------------------------------------------------------------- */

class BaseObserver
{
    use DispatchesJobs;

	public function saved($model)
	{
		$class = get_class($model);
		$class2 = explode( '\\', $class );
		$lastnameclass = end( $class2 );
		$class 	= str_replace('Models', 'Jobs', $class);
		$class 	= str_replace($lastnameclass, $lastnameclass.'Saved', $class);

		if (class_exists($class)) 
		{
        $result                         = $this->dispatch(new $class($model));
        dD($result);
	    }
	    else
	    {
	        trigger_error("Unable to load class: $class", E_USER_WARNING);
	    	
	    }


        return false;
	}
}
