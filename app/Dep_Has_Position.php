<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

	/**
    *@author Pwint Ya Mone
    *@date 27/08/2020
    */

class Dep_Has_Position extends Model

{
		use SoftDeletes;
		

    	public $fillable=['department_id','position_id'];
    	
}
