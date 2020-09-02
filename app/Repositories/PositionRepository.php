<?php

namespace App\Repositories;

use App\Repositories\Interfaces\PositionRepositoryInterface;
use App\Position;
//use Your Model

/**
 * Class EmployeeRepository.
 */
class PositionRepository implements PositionRepositoryInterface
{
    /**
     * @return string
     *  Return the model
     */
    public function savePosition($request)
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
}
