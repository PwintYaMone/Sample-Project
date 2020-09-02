<?php

namespace App\Repositories\Logics;
use Illuminate\Support\Facades\Log;

use App\Employee;
use App\Repositories\Interfaces\EmployeeDepartmentPositionRepositoryInterface;
/**
 * 
 */
class EmployeeRegistrationLogic
{
    public function __construct(EmployeeDepartmentPositionRepositoryInterface $empDepRepo)
    {       
        $this->empDepRepo = $empDepRepo;

    }

    public function savePrepareData($request)
    {
    
            if($request->position_id) {
                $pos_id=$request->position_id;
            } else {
                $pos_id=1;  //default position 1
            }

            if ($request->department_id) {
                $poss_id=$request->department_id;
            } else {
                $poss_id=1; //default position 1
            }

            $employeeId = Employee::max('id');
            Log::info($employeeId);
            $this->empDepRepo->saveEmployeeDep($employeeId, $pos_id, $poss_id);
            return true;
    }
    public function updatePrepareData($request)
    {
    
            if($request->position_id) {
                $pos_id=$request->position_id;
            } else {
                $pos_id=1;  //default position 1
            }

            if ($request->department_id) {
                $poss_id=$request->department_id;
            } else {
                $poss_id=1; //default position 1
            }

            
            $this->empDepRepo->updateEmployeeDep( $request,$pos_id, $poss_id);
            return true;
    }
}

    