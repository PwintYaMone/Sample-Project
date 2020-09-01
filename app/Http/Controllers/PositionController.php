<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Position;
use App\Emp_Dep_Position;
use App\Http\Requests\PositionRequest;

    /**@description Index,Show,Store,Update,destroy and ForceDelete
    *@author Pwint Ya Mone
    *@date 26/08/2020
    */

class PositionController extends Controller
{
     /**
     * Display the specified resource.
    *@author Pwint Ya Mone
    *@date 28/08/2020
    *@return $position[]=(position_name,position_rank)
     */


    public function index() 
    {
        

        $limit=(int)env('limit');

        $position = Position::withTrashed()->paginate($limit);

        return $position;  

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

    //position registration
    public function store(PositionRequest $request) //validation position
    {
        try{
        $position = new Position();
        $position->position_name = $request['position_name'];
        $position->position_rank = $request['position_rank'];
        $position->save(); 
         return response()->json
                ([

                    'message'=>'Success Position Registration'

                ],200);
            } catch(QueryException $e)
             {

           

             }


     }

   /**
    * Display position detail.
    *@author  Pwint Ya Mone
    *@date 27/08/2020
    *@param $id
    *@return $position[]=(position_name,position_rank)
     */

    public function show($id) 
    {
         $position=Position::whereId($id)->first();
        return $position;    

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
     *@date 26/08/2020
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     */

    public function update(Request $request, $id)
    {
        try{
        $position = Position::whereId($id)->FirstOrFail();
        $position->position_name=$request->position_name;
        $position->position_rank=$request->position_rank;
        $position->update();
         return response()->json
                ([

                    'message'=>'Success '

                ],200);
            } catch(QueryException $e)
             {

           

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
        
        $position= Position::withTrashed()->whereId($id);

        $position->delete();
        return response()->json([

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
     *@date 26/08/2020
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function forceDelete($id)    
    {

            try{
            $position= Position::withTrashed()->whereId($id);

            $position->forcedelete();
            return response()->json([

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

