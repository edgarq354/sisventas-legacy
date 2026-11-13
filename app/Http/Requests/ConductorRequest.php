<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ConductorRequest extends Request
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
            'ci'=>'required|unique:conductor',   

           // 'expedido'=>'required',     

            'nombre'=>'required',  

            //'paterno'=>'required',           
            //'materno'=>'required',     

/*
            'fecha_nacimiento'=>'required',           
            'sexo'=>'required',           
            'celular'=>'required|min:8|max:8|unique:conductor', 
*/

            //'imei'=>'required',           
            //'correo'=>'required',          
            'usuario'=>'required|unique:conductor',           
            'contrasenia'=>'required|unique:conductor',  

 /*         
            'direccion'=>'required',           
            'latitud'=>'required',                   
            'longitud'=>'required',           
            'estado'=>'required',           
            'login'=>'required',    
*/

            //'credito'=>'required',   
            //'token'=>'required', 
            //'perfil'=>'required', //ESTE ES EL PERFIL DEL CONDUCTOR
            //'direccion_imagen'=>'required', 

            //'categoria_licencia'=>'required',

            //'tipo'=>'required',
            //'bloqueo'=>'required',
            //'aceptar_condiciones'=>'required',

            //'id_empresa'=>'required',

            /*'id_fotocopia_ci'=>'required',
            'id_fotocopia_licencia'=>'required',
            'id_fotocopia_tarjeta_de_identificacion_de_ham'=>'required',
            'id_fotocopia_tarjeta_de_identificacion_de_transito'=>'required',
            'id_fotocopia_factura_de_agua_luz'=>'required',
            'id_fotocopia_certificado_de_antecedentes_del_transito'=>'required',
            'id_fotocopia_certificado_de_antecedentes_del_felcc'=>'required',*/
           
        ];
    }
}
