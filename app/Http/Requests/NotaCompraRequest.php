<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class NotaCompraRequest extends Request
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
            'id_comprador'=>'required',           
            'id_proveedor'=>'required',
            'id_caja'=>'required',           
            'monto_total'=>'required',   
            'idCarrito'=>'required',              
           
        ];
    }
}
