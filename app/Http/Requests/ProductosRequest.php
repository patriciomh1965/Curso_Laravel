<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductosRequest extends FormRequest
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
                    'producto' =>'required|min:1|string|max:255|unique:sys_10_producto,producto',
                    'codigo' =>'required|min:1|string|max:50|unique:sys_10_producto',
                    'descripcion'=>'required|string|max:255',
                    'minstock'=>'required|numeric|min:1|max:1000000',
                    'precio'=>'required|numeric|min:1|max:90000000',
                    'categoria'=>'required|exists:sys_09_categorias,id_categoria',
                    'imagen'    => 'required|mimes:jpeg,png|unique:sys_10_producto,imagen',
                ];
                break; 
           case 'PUT':
                $rules = [
                   'id_producto'=>'exists:sys_10_producto,id_producto',
                   'producto'=>'required|min:1|max:50|unique:sys_10_producto,producto,'.trim($this->get('id_producto')).',id_producto',
                   'codigo'=>'required|min:1|max:50|unique:sys_10_producto,codigo,'.trim($this->get('id_producto')).',id_producto',
                   'descripcion'=>'required|string|max:255',
                   'minstock'=>'required|numeric|min:1|max:1000000',
                   'precio'=>'required|numeric|min:1|max:90000000',
                   'estado'=>'required|numeric|min:0|max:1',
                   'categoria'=>'required|exists:sys_09_categorias,id_categoria',
                   'imagen' =>'nullable|mimes:jpeg,png|unique:sys_10_producto,imagen',
                ];
            break;
          }
        return $rules;
    }
}