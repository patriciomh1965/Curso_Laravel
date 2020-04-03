<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientesRequest extends FormRequest
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
                    'nombre' =>'required|min:1|string|max:255|unique:sys_04_clientes,cliente',
                    'codigo' =>'required|min:1|string|max:50|unique:sys_04_clientes',
                    'descripcion'=>'required|string|max:255',
                    'imagen'    => 'required|mimes:jpeg,png|unique:sys_04_clientes,imagen',
                ];
                break;
           case 'PUT':
                $rules = [
                   'id_cliente'=>'required|exists:sys_04_clientes,id_cliente',
                   'nombre'=>'required|min:1|max:50|unique:sys_04_clientes,cliente,'.trim($this->get('id_cliente')).',id_cliente',
                   'codigo'=>'required|min:1|max:50|unique:sys_04_clientes,codigo,'.trim($this->get('id_cliente')).',id_cliente',
                   'descripcion'=>'required|string|max:255',
                   'estado'=>'required|numeric|min:0|max:1',
                   'imagen' =>'nullable|mimes:jpeg,png|unique:sys_04_clientes,imagen',
                ];
            break;
          }
        return $rules;
    }
}