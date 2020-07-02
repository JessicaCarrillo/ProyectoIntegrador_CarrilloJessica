<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidacionReservarProyector extends FormRequest
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
            'hora_entrega' => 'required',
            //
        ];
    }
    public function messages()
    {
        return [
            'hora_entrega.required' => 'El campo hora entrega es obligatorio*',

        ];
    }
}
