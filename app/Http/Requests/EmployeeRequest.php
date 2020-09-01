<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequest extends FormRequest
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
        return [
            'employee_name' => 'required|max:100',
            'email' => 'required|email|unique:employees',
            'password' => 'required',
            'gender'=>'required'
        ];
    }
}
