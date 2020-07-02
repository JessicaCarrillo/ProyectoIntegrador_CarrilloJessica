<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidacionProyector extends FormRequest
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
            'proyector' => 'required',
            'id_estado_devolucion' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'proyector.required' => 'El campo nombre proyector es obligatorio*',
            'id_estado_devolucion.required' => 'Es obligatorio seleccionar*',

        ];
    }
}
