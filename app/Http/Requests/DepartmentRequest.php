<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DepartmentRequest extends FormRequest
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
     * Get the validation rules that apply to the request for departments table.
     * @author Thu Ta
     * 31/08/2020
     * @return array[department_name]
     */
    public function rules()
    {
        return [
            'department_name' => 'required|max:50'
        ];
    }
}
