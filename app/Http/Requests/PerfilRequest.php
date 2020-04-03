<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PerfilRequest extends FormRequest
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
                    'perfil'=>'required|min:1|max:50|unique:sys_03_perfiles,perfil',
                ];
                break;
           case 'PUT':
                $rules = [
                   'id_perfil'=>'required|exists:sys_03_perfiles,id_perfil',
                   'perfil'=>'required|min:1|max:50|unique:sys_03_perfiles,perfil,'.trim($this->get('id_perfil')).',id_perfil',
                   'estado'=>'required|numeric|min:0|max:1',
                ];
            break;
          }
        return $rules;
    }
}
