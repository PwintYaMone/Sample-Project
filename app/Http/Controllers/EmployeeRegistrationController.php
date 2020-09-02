<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\EmployeeRegistrationValidationRequest;
use App\Repositories\Interfaces\EmployeeRepositoryInterface;
use App\Repositories\Logics\EmployeeRegistrationLogic;
use App\Http\Requests\EmployeeValidationRequest;



class EmployeeRegistrationController extends Controller
{
	public function __construct(EmployeeRepositoryInterface $employeeRepo, EmployeeRegistrationLogic $employeelogic)
    {       
        $this->employeeRepo = $employeeRepo;
        $this->employeelogic = $employeelogic;

    }
    public function save(EmployeeRegistrationValidationRequest $request)
    {

    	$this->employeeRepo->saveEmployee($request);
    	$this->employeelogic->savePrepareData($request);


    }
     public function update(EmployeeValidationRequest $request)
    {        
        $employee = $this->employeeRepo->checkEmployee($request);

        if($employee->isEmpty()) {
            return response()->json(['message'=>"Data is not found!"],200);

        } else {
            $this->employeeRepo->updateEmployee($request);
            $this->employeelogic->updatePrepareData($request);

            // $this->employeeRepo->updatePrepareData($request);

        }
    }

}
