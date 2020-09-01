<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
    /**@description departments,employees
    *@author Pwint Ya Mone
    *@date 27/08/2020
    */

class Position extends Model

{
	    use SoftDeletes;

    	public $fillable=['position_name','position_rank'];

    	 public function department()
       {

    		return $this->belongsToMany('App\Department','emp__dep__positions','position_id','department_id');

   		
   		 }
   		 public function employee()
       {


    		return $this->belongsToMany('App\Employee','emp__dep__positions','position_id','employee_id');

    	
    	}


    	
}
