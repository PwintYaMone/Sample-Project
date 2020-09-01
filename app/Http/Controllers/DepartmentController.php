<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Department;
use App\Emp_Dep_Position;
use App\Employee;
use Maatwebsite\Excel\Facades\Excel; 
use App\Imports\DepartmentsImport; 
use App\Exports\DepartmentsExport; 
use PDF;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Config;
use App\Http\Requests\DepartmentRequest;

    /**@description FileImport,FileExport,Index,Show,Store,Update,destroy and ForceDelete
    *@author Pwint Ya Mone
    *@date 26/08/2020
    */

class DepartmentController extends Controller
{
    /**
     **@author pwint ya mone
     * @date 28.8.2020
     * @return \Illuminate\Http\Response
     */

         public function createPDF() //download pdf
        { 

            $data = Department::all();

            $pdf = PDF::loadView('pdf_view', $data); 
 
            return $pdf->download('pdf_file.pdf');
        }

    /**
    * Display the specified resource.
    *@author  Pwint Ya Mone
    *@date 28/08/2020
    *@param $request
     */

     public function fileImport(Request $request)  
    { 

        Excel::import(new DepartmentsImport, $request->file('file')->store('temp')); 

        return back(); 

    } 

    /**
     * Display the specified resource.
    *@author  Pwint Ya Mone
    *@date 28/08/2020
    *@param $request
    *@return excel download
     */

    public function fileExport(Request $request)  //download excel
    
    {   

            $search_data=[];
            if($request->id)
            {
                
            $search_id=['id',$request->id];
            array_push($search_data, $search_id);//arraypush is array add otherarray
            }
             if($request->department_name)
            {

            $search_name=['department_name','like',$request->department_name.'%'];
            array_push($search_data, $search_name);

            }

            return Excel::download(new DepartmentsExport( $search_data), 'DepartmentList.xlsx');

            


    }

    /**
     * Display a listing of the resource.
    *@author Pwint Ya Mone
    *@date 28/08/2020
    *@return $department[]=(id,department_name)
     */

    public function index() 
    {
        $limit=(int)env('limit');
        $department = Department::withTrashed()->paginate($limit);
        return $department;   
     }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *@author  Pwint Ya Mone
     *@date 26/08/2020
     * @param  \Illuminate\Http\Request  $request
     */

    //department registration
    public function store(DepartmentRequest $request) //validation department
    {
        try{
         $department = new Department();

        $department->department_name = $request['department_name'];
        
        $department->save();
         return response()->json
                ([

                    'message'=>'Success Department Registration'

                ],200);
            } catch(QueryException $e)
             {

           

             }

     }

    /**
    * Display Department Detail.
    *@author  Pwint Ya Mone
    *@date 27/08/2020
    *@param $id
    *@return $$department[]=(id,department_name)
     */

    public function show($id)  //department detail
    {

     $department=Department::whereId($id)->first();
        return $department; 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
    * Update the specified resource in storage.
    *@author Pwint Ya Mone
    *@dat 26/08/2020
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */

    public function update(Request $request, $id)   
    {
       
       try{

        $department= Department::whereId($id)->FirstOrFail();

        $department->department_name=$request->department_name;

        $department->update();

        
          return response()->json
                ([

                    'message'=>'Success '

                ],200);
            } catch(QueryException $e)
             {

           

             }

       }

    /**
    * Remove //updated deleted at with timestamp
    **@author  Pwint Ya Mone
    *@date 26/08/2020
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */

    public function destroy($id)     {
        try{

        $department= Department::withTrashed()->whereId($id);

        $department->delete();

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
     * Remove deleted row
     **@author Pwint Ya Mone
     *@date 26/08/2020
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

     public function forceDelete($id)  
        {
            try{
        
             $department= Department::withTrashed()->whereId($id);

             $department->forcedelete();

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
