<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsuarioRequest extends FormRequest
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
        $rules = [];
        switch ($this->method()) {
           case 'POST':
                $rules = [
                    'name' => 'required|string|max:255',
                    'email' => 'required|string|email|max:255|unique:sys_00_users',
                    'password' => 'required|string|min:6|confirmed',
                    'perfil'=>'required|exists:sys_03_perfiles,id_perfil',
                ];
                break;
           case 'PUT':
                $rules = [
                   'id_user'=>'exists:sys_00_users,id_user',
                   'perfil'=>'exists:sys_03_perfiles,id_perfil',
                   'name' => 'required|string|max:255',
                   'email'=>'required|min:1|max:50|unique:sys_00_users,email,'.trim($this->get('id_user')).',id_user',
                   'estado'=>'required|numeric|min:0|max:1',
                ];
            break;
          }
        return $rules;
    }
}
