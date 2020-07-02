<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidacionDocente extends FormRequest
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
        $docente = $this->route('docente');
        if($this->route('docente')){
            return [
                'id_biometrico' => 'required|unique:SistemaEsfot.users,id_biometrico,' . $docente . ',id',
                'name' => 'required',
                'email' => 'required|unique:SistemaEsfot.users,email,' . $docente . ',id',
                'password' => 'nullable|min:5',
                'tipo_rol' => 'required',

            ];
        }else{
            return [
                'id_biometrico' => 'required|unique:SistemaEsfot.users,id_biometrico,' . $docente . ',id',
                'name' => 'required',
                'email' => 'required|unique:SistemaEsfot.users,email,' . $docente . ',id',
                'password' => 'required',
                'tipo_rol' => 'required',

            ];

        }

    }
    public function messages()
    {
        return [
            'id_biometrico.required' => 'El campo Id-Biométrico es obligatorio*',
            'id_biometrico.unique' => 'El Id-Biométrico ya existe*',
            'name.required' => 'El campo nombre es obligatorio*',
            'email.required' => 'El campo correo electrónico es obligatorio*',
            'email.unique' => 'El correo electrónico ya existe*',
            'password.required' => 'El campo contraseña es obligatorio*',
            'password.required' => 'La contraseña debe contener mas de 5 caracteres*',
            'tipo_rol.required' => 'Seleccionar un tipo de rol es obligatorio*',



        ];
    }
}
