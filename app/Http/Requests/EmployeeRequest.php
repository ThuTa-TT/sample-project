<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request for employees table.
     * @author Thu Ta
     * 31/08/2020
     * @return array[employee_name,email,password,dob,gender]
     */
    public function rules()
    {
        return [
            'employee_name' => 'required|max:255',
            'email' => 'required|email|unique:employees',
            'password'=>'required|min:8',
            'dob'=>'date_format:Y/m/d',
            'gender'=>'required'
        ];
    }
}
