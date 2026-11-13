<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class VehiculoUpdateRequest extends Request
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
            //REQUEST DEL VEHICULO
            'placa'=>'required',           
            /*'marca'=>'required',           
            'modelo'=>'required',           
            'cilindrada'=>'required',           
            'color'=>'required',           
            'tipo'=>'required',           
            'clase'=>'required',           
            'nro_poliza'=>'required',*/           
            //'traccion'=>'required',           
            //'nro_chasis'=>'required',           
            /*'direccion_imagen_adelante'=>'required',           
            'direccion_imagen_atras'=>'required',           
            'direccion_imagen_interior_adelante'=>'required',           
            'direccion_imagen_interior_atras'=>'required',           
            'nro_rua'=>'required',                   
            'nro_documento_propiedad'=>'required',           
            'nro_soat'=>'required',           
            'nro_inspeccion_tecnica'=>'required', */          
            //'id_empresa'=>'required',   
            'nro_puertas'=>'required',   
            'nro_asientos'=>'required',   
            //'clasificacion_vehiculo'=>'required',   
           /* 'servicio'=>'required',   
            'radicatoria'=>'required',*/

           /* 'id_fotocopia_rua'=>'required', 
            'id_fotocopia_ci_titular_del_rua'=>'required', 
            'id_fotocopia_documento_de_propiedad'=>'required', 
            'id_fotocopia_soat'=>'required', 
            'id_foto_inspeccion_tecnica'=>'required', */

            //REQUEST DEL PROPIETARIO
            'ci_propietario'=>'required',   
            'expedido_propietario'=>'required',
            'nombre_propietario'=>'required',
            //'paterno_propietario'=>'required',
            //'materno_propietario'=>'required',
            //'titulo_propietario'=>'required',
            //'correo_propietario'=>'required',
           // 'fecha_nacimiento_propietario'=>'required', 

            //REQUEST DEL APODERADO
            /*'ci_apoderado'=>'required',   
            'expedido_apoderado'=>'required',
            'nombre_apoderado'=>'required',
            'paterno_apoderado'=>'required',
            'materno_apoderado'=>'required',
            'titulo_apoderado'=>'required',
            'correo_apoderado'=>'required',
            'fecha_nacimiento__apoderado'=>'required',*/              
        ];
    }
}
