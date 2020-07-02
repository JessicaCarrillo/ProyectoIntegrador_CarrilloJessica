<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidacionSubirCronograma extends FormRequest
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
            'id_periodo'=> 'required',
            'id_carrera'=> 'required',
            'id_materia'=> 'required',
            'file'=> 'required|mimes:xlsx',
            //
        ];
    }

    public function messages()
    {
        return [
            'id_periodo.required' => 'Seleccionar el período es obligatorio*',
            'id_carrera.required' => 'Seleccionar la carrera es obligatorio*',
            'id_materia.required' => 'Seleccionar la materia es obligatorio*',
            'file.required' => 'Debe cargar un archivo tipo xlsx*',
            'file.mimes' => 'El formato no es el correcto asegurese que sea xlsx*',

        ];
    }
}
