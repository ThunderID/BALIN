<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends GlobalCategory
{
	protected static $singleTableType = 'tag';
}
