<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SucursalesRequest extends FormRequest
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
                    'nombre' =>'required|string|max:255|unique:sys_02_sucursales',
                    'direccion'=>'required|string|max:255',
                    'casa_matriz'=>'required|numeric|min:0|max:1',
                    'codigo'=>'required|string|max:50|unique:sys_02_sucursales',
                    'latitud' =>'required|numeric',
                    'longitud'=>'required|numeric',
                    'clientes'=>'required|exists:sys_04_clientes,id_cliente',
                    'comuna'=>'required|exists:sys_08_comunas,id_comuna',
                ];
                break;
           case 'PUT':
                $rules = [
                   'id_sucursal'=>'exists:sys_02_sucursales,id_sucursal',
                   'nombre'=>'required|min:1|max:50|unique:sys_02_sucursales,nombre,'.trim($this->get('id_sucursal')).',id_sucursal',
                   'direccion'=>'required|string|max:255',
                   'casa_matriz'=>'required|numeric|min:0|max:1',
                   'codigo'=>'required|min:1|max:50|unique:sys_02_sucursales,codigo,'.trim($this->get('id_sucursal')).',id_sucursal',
                   'latitud' =>'required',
                   'longitud'=>'required',
                   'estado'=>'required|numeric|min:0|max:1',
                   'clientes'=>'required|exists:sys_04_clientes,id_cliente',
                   'comuna'=>'required|exists:sys_08_comunas,id_comuna',
                ];
            break;
          }
        return $rules;
    }
}