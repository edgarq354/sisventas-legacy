<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class EmpresasClienteRequest extends Request
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
            'nit'=>'required',
            //'tipo'=>'required',                   
            //'nro_licencia_funcionamiento'=>'required',                   
            'razon_social'=>'required',                   
            //'id_pais'=>'required',                   
            //'id_departamento'=>'required',                   
            //'id_asociacion'=>'required',                   
            'direccion'=>'required',                   
            'longitud'=>'required',                   
            'latitud'=>'required',                   
            'id_administrador'=>'required',                   
            //'correo'=>'required',                   
            //'facebook'=>'required',                   
            //'whatsapp'=>'required',                                  
            'estado'=>'required',                   
            //'credito'=>'required',                   
            //'ci_representante_legal'=>'required',                   
            //'nro_constitucion_de_empresa'=>'required',                   
            //'nro_poder_del_representante'=>'required',                   
            //'nro_registro_fundaempresa'=>'required',                   
            //'nro_resolucion_administrativa_att'=>'required',                   
            //'nro_registro_senapi'=>'required',                   
            /*'id_fotocopia_constitucion_de_empresa'=>'required',                   
            'id_fotocopia_poder_del_representante_legal'=>'required',                   
            'id_fotocopia_registro_fundaempresa'=>'required',                   
            'id_fotocopia_ci_del_representante_legal'=>'required',                   
            'id_fotocopia_licencia_funcionamiento_gmlp'=>'required',                   
            'id_fotocopia_nit'=>'required',                   
            'id_fotocopia_resolucion_administrativa_att'=>'required',                   
            'id_fotocopia_factura_luz_agua_de_oficinas'=>'required',                   
            'id_imagen_corporativa'=>'required',                   
            'id_fotocopia_registro_senapi'=>'required', */               
            //REQUEST DEL REPRESENTANTE LEGAL DE LA EMPRESA
            //'ci'=>'required',//|unique:duenio',
            //'expedido'=>'required',
            //'titulo'=>'required',
            //'nombre'=>'required',
            //'paterno'=>'required',
            //'materno'=>'required',
            //'correo_dueño'=>'required',
            //'fecha_nacimiento'=>'required',                  
        ];
    }
}
