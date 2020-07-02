<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidacionCarrera extends FormRequest
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
        $carrera = $this->route('carrera');
        return [
            'carrera' => 'required|unique:SistemaEsfot.tbl_carrera,carrera,' . $carrera . ',id_carrera',

        ];
    }
    public function messages()
    {
        return [
            'carrera.required' => 'El campo carrera es obligatorio*',
            'carrera.unique' => 'La carrera ya existe*',
        ];
    }
}
