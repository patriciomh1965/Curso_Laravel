<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PresupuestoActualizarRequest extends FormRequest
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
                    'id_presupuesto' =>'required|exists:sys_16_presupuesto,id_presupuesto',
                    'valor'=>'required|numeric|min:0',
                    'estado'=>'required|exists:sys_11_estado,id_estado',
                    'archivo'=> 'unique:sys_16_presupuesto,archivo',
                ];
                break; 
          }
        return $rules;
    }
}