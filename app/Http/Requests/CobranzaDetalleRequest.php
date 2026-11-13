<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CobranzaDetalleRequest extends Request
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
            'numero_documento'=>'required',
            'razon_social'=>'required',           
            'monto'=>'required',  
            'id_caja'=>'required',             
            'id_cobranza'=>'required',             
            'detalle'=>'required',             
           
        ];
    }
}
