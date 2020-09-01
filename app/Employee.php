<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

    /**@description departments,positions
    *@author Pwint Ya Mone
    *@date 27/08/2020
    */

class Employee extends Model

{
		use SoftDeletes;

    	public $fillable=['employee_name','email','dob','password','gender'];

    	public function department()

    	{

    	return $this->belongsToMany('App\Department','emp__dep__positions','employee_id','department_id');

   		}


    	public function position()

    	{

    	return $this->belongsToMany('App\Position','emp__dep__positions','employee_id','position_id');

   		}

    	
}
