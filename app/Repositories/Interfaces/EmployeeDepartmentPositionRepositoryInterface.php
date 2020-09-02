<?php

namespace App\Repositories\Interfaces;

interface EmployeeDepartmentPositionRepositoryInterface 
{
    public function saveEmployeeDep($employeeId,$pos_id,$poss_id);
    public function updateEmployeeDep($employeeId,$pos_id,$poss_id);

}