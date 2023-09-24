<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use phpDocumentor\Reflection\Types\String_;

class PatientRequest extends FormRequest
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
            'fullName'=>'required|string|max:255',
             'motherName'=>'required|string|max:255',
            'age'=>'required',
            'gender'=>'required|string|max:255',
              'address'=>'required|string|max:255',

        ];
    }
}
