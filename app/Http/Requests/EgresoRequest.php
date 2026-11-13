<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class EgresoRequest extends Request
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
            'monto'=>'required',           
            'id_cliente'=>'required',           
            'id_tipo'=>'required',           
           
        ];
    }
}

class Egreso_sueldoRequest extends Request
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
            'monto'=>'required',           
            'id_empleado'=>'required',           
            'id_tipo'=>'required',           
           
        ];
    }
}
