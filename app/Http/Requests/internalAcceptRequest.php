<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class internalAcceptRequest extends FormRequest
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
            'department'=>'required|string|max:255',
            'doctor'=>'required|string|max:255',
            'operation'=>'required|string|max:255',
            'patient'=>'required|string|max:255',
            'folder_id'=>'required|integer',
           // 'room_id'=> 'required|integer',
            //'internalAccept_id'=>'required|integer',
        ];
    }
}
