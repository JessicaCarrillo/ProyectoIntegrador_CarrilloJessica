<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidacionPeriodo extends FormRequest
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
        $periodo = $this->route('periodo');
        return [
            'periodo' => 'required|unique:SistemaEsfot.tbl_periodo,periodo,' . $periodo . ',id_periodo',
            'fecha_inicio' => 'required',
            'fecha_fin' => 'required',

        ];
    }

    public function messages()
    {
        return [
            'periodo.required' => 'El campo período es obligatorio*',
            'periodo.unique' => 'El período ya existe*',
            'fecha_inicio.required' => 'El campo fecha inicio es obligatorio*',
            'fecha_fin.required' => 'El campo fecha fin es obligatorio*',


        ];
    }
}
