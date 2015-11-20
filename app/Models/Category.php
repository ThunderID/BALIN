<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends GlobalCategory
{
	protected static $singleTableType = 'category';
}
