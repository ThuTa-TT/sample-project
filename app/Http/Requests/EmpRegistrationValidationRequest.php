<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;


class EmpRegistrationValidationRequest extends FormRequest
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
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
     public function rules()
    {
        return [
            'employee_name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees',
            'password'=>'required|min:8',
            'dob'=>'date_format:"Y/m/d"',
            'gender'=>'required|in:1,2'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(['message'=>$validator->errors()], 400));
    }


    public function messages()
    {     
        return [
            'employee_name.required' => "Employee name is required!",
            'employee_name.string' => "Employee name must be string!",
            'dob.required' => "Date of Birth is required!",
            'dob.date_format' => "Date Format is invalid!",
            'email.required' => "Email is required!",
            'email.email' => "Email Format is invalid!",
            'email.unique' => "Email is already exists!",
            'password.required' => "Password is required!",
            'password.min' => "Password must be minimum 10 characters!",
            'gender.required' => "Gender is required!",
            'gender.in' => "Gender must be 1 or 2!",
        ];
    }
}
