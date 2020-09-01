<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PositionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     **@author Pwint Ya Mone
     *@date 31/08/2020
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     **@author Pwint Ya Mone
     *@date 31/08/2020
     * @return array
     */
    public function rules()
    {
        return
         [
            'position_name' => 'required|max:100',
            'position_rank' =>  'required'   
         ];
    }
}
