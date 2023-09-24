<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class operatingRoomRequest extends FormRequest
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
            'operatingRoom'=>'required|string|max:255',
            'type'=>'required|string|max:255',
            'day'=>'required|string|max:255',
            'date'=>'required',

        ];
    }
}
