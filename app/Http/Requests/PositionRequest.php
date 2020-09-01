<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PositionRequest extends FormRequest
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
     * Get the validation rules that apply to the request for positions table.
     * @author Thu Ta
     * 31/08/2020
     * @return array[position_name,position_rank]
     */
    public function rules()
    {
        return [
            'position_name'=>'required|max:50',
            'position_rank'=>'required'

        ];
    }
}
