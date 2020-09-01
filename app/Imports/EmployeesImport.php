<?php

namespace App\Imports;

use App\Employee;
use Maatwebsite\Excel\Concerns\ToModel;

class EmployeesImport implements ToModel
{
    /**
    * @param array $row
    **@author Pwint Ya Mone
    *@date 28/08/2020
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
         return new Employee
         ([

            'employee_name'      => $row[0], 
            'email'     => $row[1], 
            'dob'     => $row[2], 
            'password'    => $row[3], 
            'gender'    => $row[4]
  
                

          ]);
    }
}
