<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class AsignacionRequest extends Request
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
            'ci'=>'required',           
            'placa'=>'required',           
            'id_empresa'=>'required',           
            //'latitud'=>'required',           
            //'longitud'=>'required',           
            //'codigo_empresa'=>'required',           
            'estado'=>'required',

           // 'nombre'=>'required',                                
          
           // 'paterno'=>'required',                                
           // 'materno'=>'required',
           // 'fecha_nacimiento'=>'required',
          
          //  'celular'=>'required',
          
           // 'categoria_licencia'=>'required',

            /*'marca'=>'required',                                
            'modelo'=>'required',                                
            'color'=>'required',                                             
            'tipo'=>'required',                                             
            'clase'=>'required',                                             
            'nro_chasis'=>'required',                                             
            'nro_soat'=>'required',*/                                             
        ];
    }
}
