<?php

namespace App\Repositories;

use App\Repositories\Interfaces\EmployeeDepartmentPositionRepositoryInterface;
use App\Emp_Dep_Position;
//use Your Model

/**
 * Class EmployeeRepository.
 */
class EmployeeDepartmentPositionRepository implements EmployeeDepartmentPositionRepositoryInterface
{
  public function saveEmployeeDep($employeeId,$pos_id,$poss_id)
  {
  	$emp_dep_pos=new Emp_Dep_Position();
  	$emp_dep_pos->employee_id=$employeeId;
  	$emp_dep_pos->department_id=$pos_id;
  	$emp_dep_pos->position_id=$poss_id;  	
  	$emp_dep_pos->save();
  	
  }
  public function updateEmployeeDep($request,$pos_id,$poss_id)
  {
  		$emp_dep_pos=Emp_Dep_Position::where('employee_id',$request->id)->first();
        $emp_dep_pos->department_id=$pos_id;
        $emp_dep_pos->position_id=$poss_id;
        $emp_dep_pos->update();
  	
  }
}
