<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

  /**@description employees,positions
    *@author Pwint Ya Mone
    *@date 27/08/2020
    */
  
class Department extends Model
{
	use SoftDeletes;

	public $fillable=['department_name'];

	 public function employee()

   {

    	return $this->belongsToMany('App\Employee','emp__dep__positions','department_id','employee_id');

   		
    }
    public function position()

    {


    	return $this->belongsToMany('App\Position','emp__dep__positions','department_id','position_id');

    	
    	}



 }
