
<?php namespace App\Models;

use Validator, Event;

/* ----------------------------------------------------------------------
 * Event:
 * 	Saving						
 * ---------------------------------------------------------------------- */

class BaseObserver
{
	public function saved($model)
	{
		$class = get_class($model);
		// $class = explode( '\\', $class );
		$lastnameclass = end( $class );
		$class 	= str_replace('Models', 'Jobs', $class);
		$class 	= str_replace($lastnameclass, $lastnameclass.'Saved', $class);

		if (!class_exists($class, false)) 
		{
	        trigger_error("Unable to load class: $class", E_USER_WARNING);
	    }

        $result                         = $this->dispatch(new $class($model));
        dD($result);

        return false;
	}
}
