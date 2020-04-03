<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoriasRequest extends FormRequest
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
                    'categoria' =>'required|min:1|string|max:255|unique:sys_09_categorias,nombre',
                    'codigo' =>'required|min:1|string|max:50|unique:sys_09_categorias',
                    'descripcion'=>'required|string|max:255',
                ];
                break;
           case 'PUT':
                $rules = [
                   'id_categoria'=>'exists:sys_09_categorias,id_categoria',
                   'categoria'=>'required|min:1|max:50|unique:sys_09_categorias,nombre,'.trim($this->get('id_categoria')).',id_categoria',
                   'codigo'=>'required|min:1|max:50|unique:sys_09_categorias,codigo,'.trim($this->get('id_categoria')).',id_categoria',
                   'descripcion'=>'required|string|max:255',
                   'estado'=>'required|numeric|min:0|max:1',
                ];
            break;
          }
        return $rules;
    }
}