<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ContratoRequest extends Request
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
        return [                
            //REQUEST DEL CONDUCTOR
            'id_empleado_contratado'=>'required',           
            'id_horario'=>'required',           
            'sueldo'=>'required',           
            'inicio_contrato'=>'required',           
            'fin_contrato'=>'required',           
           
        ];
    }
}
