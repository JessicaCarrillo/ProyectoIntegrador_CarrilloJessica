<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidacionMateria extends FormRequest
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
        $materia = $this->route('materia');
        return [
            'materia' => 'required',
            'id_carrera_fk' => 'required',

        ];
    }

    public function messages()
    {
        return [
            'materia.required' => 'El campo materia es obligatorio*',
            'id_carrera_fk.required' => 'Es obligatorio seleccionar una carrera*',
        ];
    }
}
