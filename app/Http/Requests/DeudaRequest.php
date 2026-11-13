<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class DeudaRequest extends Request
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
            'id_tipo_deuda'=>'required',           
            'id_conductor'=>'required',           
            'monto'=>'required',                
        ];
    }
}
