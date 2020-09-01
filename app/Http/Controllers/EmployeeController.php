<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Employee;
use App\Emp_Dep_Position;
use Maatwebsite\Excel\Facades\Excel; 
use App\Imports\EmployeesImport; 
use App\Exports\EmployeesExport; 
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Config;
use App\Http\Requests\EmployeeRequest;


    /**@description FileImport,FileExport,Search,Index,Show,Store,Update,destroy and ForceDelete
    *@author Pwint Ya Mone
    *@date 26/08/2020
    */

class EmployeeController extends Controller
{
   

    /**
    * Display the specified resource.
    *@author Pwint Ya Mone
    *@date 28/08/2020
    *@param $request
    */

     public function fileImport(Request $request)  // excel file import

    { 

        Excel::import(new EmployeesImport, $request->file('file')->store('temp')); 

        return back(); 

    } 

    /**
    * Display the specified resource.
    *@author Pwint Ya Mone
    *@date 28/08/2020
    *@param $request
    *@return excel download
    */

    public function fileExport(Request $request)  //download excel
    
    {   

            $search_data=[];

            if($request->id) //request employee id
            {
                
            $search_id=['employees.id',$request->id];

            array_push($search_data, $search_id);   //arraypush is array add otherarray
            }
             if($request->employee_name) //request employee name
            {

            $search_name=['employees.employee_name','like',$request->employee_name.'%'];
            array_push($search_data, $search_name);

            }

            return Excel::download(new EmployeesExport( $search_data), 'EmployeeList.xlsx');   

    }

    /**
    * Display search employee id and name.
    *@author Pwint Ya Mone
    *@date 27/08/2020
    *@param $request
    *@return \Illuminate\Http\Response
    */

    public function search(Request $request) 
    {

            $search_data=[];

            if($request->id) //request employee id
            {
                
            $search_id=['id',$request->id];

            array_push($search_data, $search_id);  //arraypush is array add otherarray
             
            }
             if($request->employee_name) //request employee name
            {

            $search_name=['employee_name','like',$request->employee_name.'%'];

            array_push($search_data, $search_name);

            }

            $limit=(int)env('limit');

            $employees=Employee::with(['department','position'])

            ->withTrashed()

            ->where($search_data)

            ->paginate($limit);

              

            return response()->json($employees,200);  

           
     }
     
    /**
    * Display a listing of the resource.
    *@author Pwint Ya Mone
    *@date 28/08/2020
    *@return $employees[]=(id,employee_name,email,dob,password,gender,department_id,position_id)
    */

    public function index() 
    {
        
        $perPage=Config::get('constants.per_page');  // make per_page

        $employees=Employee::with('department','position')->withTrashed()->paginate($perPage); //paginate
        
        return $employees;

     }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        

    }

    /**
     * Store a newly created resource in storage.
     *@author Pwint Ya Mone
     *@date 26/08/2020
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
    */

    public function store(EmployeeRequest $request) 
    {

        //validation with another way
         /*$data = $request->validate
        ([
            'employee_name' => 'required|max:20',
            'email'=>'required:max:20|unique:employees',
            'password'=>'required',
            'gender'=>'required:max:20',
           
        ]);*/

        try{

        $employee = new Employee();
        $employee->employee_name = $request['employee_name'];
        $employee->email= $request['email'];
        $employee->dob = $request['dob'];
        $employee->password=$request['password'];
        $employee->gender= $request['gender'];
        $employee->save();
        $lasttemp_id=Employee::max('id');

            if($request->position_id) //request position id
            {

                $pos_id=$request->position_id;

            }
            else
            {

                $pos_id=Config::get('constants.default_position');  //default position 1

            }
            if ($request->department_id) //request department id
             {

                $poss_id=$request->department_id;

             }
            else
            {
             
                $poss_id=Config::get('constants.default_department'); // default department 1

            }

            $emp_dep_position=new Emp_Dep_Position(); 
            $emp_dep_position->employee_id=$lasttemp_id;
            $emp_dep_position->department_id=$poss_id;
            $emp_dep_position->position_id=$pos_id;
            $emp_dep_position->save();


           Mail::raw('Your registration process is finish.',function($message)
           {

               $message->subject('Sample Project')->from('lonlon.blah@gmail.com')->to('pwintyamone588@gmail.com');

            });

                return response()->json
                ([

                    'message'=>'Success Employee Registration'

                ],200);
        } catch(QueryException $e)
             {
          

             }
    }

    /**
    *Display Employee Detail.
    *@author Pwint Ya Mone
    *@date 27/08/2020
    *@param $id
    *@return $employee[]=(id,employee_name,email,dob,password,gender,department_id,position_id)
     */

    public function show($id)
     {

       $employee=Employee::withTrashed()->whereId($id)->with('department','position')->first();

        return $employee;
     }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *@author Pwint Ya Mone
    *@date 26/08/2020
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, $id) 
    {
        try{
        $employee= Employee::whereId($id)->FirstOrFail();
        $employee->employee_name = $request['employee_name'];
        $employee->email= $request['email'];
        $employee->dob = $request['dob'];
        $employee->password=$request['password'];
        $employee->gender= $request['gender'];
        $employee->update();

            if($request->position_id) //request position id
            {
            $pos_id=$request->position_id;
            }
            else
            {
                $pos_id=Config::get('constants.default_position');
            }

    
           
            $emp_dep_position=Emp_Dep_Position::where('id',$id)->first();

            if($emp_dep_position) // employee id
            {

                if($request->department_id) //request department id
                {
                    $emp_dep_position->department_id=$request->department_id;
                }
                if ($request->position_id) //request position id
                 {

                    $emp_dep_position->position_id=$pos_id;
               
                }
                $emp_dep_position->update();

            }

            return response()->json
                ([

                'message'=>'Success Update'

                ],200);

            } catch(QueryException $e)
             {

            return response()->json
            
                ([

                $message=>$e->getMessage()

                ]);

             }



        }

    /**
    * Remove updated deleted at with timestamp
    **@author  Pwint Ya Mone
    *@date 26/08/2020
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */

    public function destroy($id) 
    {
        try{
            $employee= Employee::whereId($id)->FirstOrFail();

            $employee->delete();
            
            $emp_dep_position=Emp_Dep_Position::where('id',$id)->first();

            if($emp_dep_position) //employee id

            {

                $emp_dep_position->delete();

            }
             return response()->json
             ([

                'message'=>'Success '

              ],200);

             } catch(QueryException $e)
             {

                return response()->json
            
                 ([

                     $message=>$e->getMessage()

                 ]);

           }



    }

    /**
    * Remove deleteted row.
    **@author  Pwint Ya Mone
    *@date 26/08/2020
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */

    public function forceDelete($id) 
    {

        try
            {
               $emp_dep_position=Emp_Dep_Position::where('id',$id)->forceDelete();
               $employee= Employee::withTrashed()->find($id);
               $employee->forceDelete();
              return response()->json
                ([

                    'message'=>'Success '

                ],200);
            } catch(QueryException $e)
                {

                return response()->json
            
                ([

                 $message=>$e->getMessage()

                ]);

           }

    }

}
