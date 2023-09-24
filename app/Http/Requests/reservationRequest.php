<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class reservationRequest extends FormRequest
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
            'doctor'=>'required|string|max:255',
            'specialization'=>'string|max:255',
            'patient'=>'required|string|max:255',
            'motherName'=>'required|string|max:255',
            'opration'=>'required|string|max:255',
            'narcosis'=>'required|string|max:255',
            'medical_diagnosis'=>'string|max:255',
            'room_id'=>'required|integer',
            'date'=>'required',
            'hourNum'=>'string|max:255',
            'timeStart'=>'string|max:255',
           // 'calendar_id'=>'required|integer',
          //  'folder_id'=>'required|integer',
        ];
    }
}
