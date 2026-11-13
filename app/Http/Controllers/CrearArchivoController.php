<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use App\Fotocopia;
use App\Foto;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Exception;
use Illuminate\Support\Facades\Validator;



class CrearArchivoController extends Controller
{
   /* public function __construct() {
         $this->middleware('auth');
    }*/

	function index(){
        return view('crear_archivo.index');        
	}
  
    public function store(Request $request){
        try {
            DB::beginTransaction();        
            //SE REGISTRA LAS DIRECCIONES DE LA EMPRESA Y USUARIO
            $nombre_fotocopia = $request->get('nombre_fotocopia');
            $imagenes = $request['imagen'];
            $cont=0;
            $id_fotocopia=null;

            while ( $cont < count($nombre_fotocopia)) {  
                if ($nombre_fotocopia[$cont] != "" && $imagenes[$cont] != "" ) {

                    $this->crear_archivos($imagenes[$cont], $request['ci'], $cont);
                    $direccion_fotocopias = "Imagen_Conductor/".$request['ci']."(".$cont.").txt";                

                    $id_fotocopia = DB::table('fotocopia')->insert([
                     'nombre' => $nombre_fotocopia[$cont], 
                     'numero' => $request['ci']
                     ]); 

                    $id_fotocopia = DB::select("SELECT @@identity AS id FROM fotocopia");

                    DB::table('foto')->insert([ // SE INSERTA AL CONDUCTOR
                     'id_fotocopia' => $id_fotocopia[0]->id, 
                     'direccion' => $direccion_fotocopias
                     ]);   

                }elseif ($imagenes[$cont] != "") {
                    $this->crear_archivos($imagenes[$cont], $request['ci'], $cont);
                    $direccion_fotocopias = "Imagen_Conductor/".$request['ci']."(".$cont.").txt";                                    
                    //GUARDO LAS FOTO
                    DB::table('foto')->insert([
                     'id_fotocopia' => $id_fotocopia[0]->id, 
                     'direccion' => $direccion_fotocopias
                    ]);                
                }
                $cont=$cont+1;
             }
            DB::commit();
            Session::flash('message','CREADO CORRECTAMENTE');
            return Redirect::to('/crear_archivo'); 
        } catch (Exception $e) {
          DB::rollback();
          return redirect('/empresa')->with("message-error","ERROR INTENTE NUEVAMENTE");            
        }             
    }


    function crear_archivos($imagen, $ci, $cont){
        //$imagen64 = $imagenes[$cont];
        $gestor = fopen($imagen, "r");
        $contenido = fread($gestor, filesize($imagen));
        $contenido = base64_encode($contenido);
        fclose($gestor);      
        $direccion_fotocopias_aux = "Imagen_Conductor/".$ci."(".$cont.").txt";                
        file_put_contents($direccion_fotocopias_aux, $contenido);  
    }


public function guardar()
    {

        $sql="INSERT into servicio_mantenimiento(codigo,fecha,firma_invetsa,firma_jefe_planta,hora_ingreso,hora_salidas,id_compania,id_maquina,id_tecnico,revision,id_sqlite,imei,formulario,jefe_planta,encargado_maquina,ultima_visita,planta_de_incubacion)values('$this->codigo','$this->fecha','$this->firma_invetsa','$this->firma_jefe_planta','$this->hora_ingreso','$this->hora_salidas','$this->id_compania','$this->id_maquina','$this->id_tecnico','$this->revision','$this->id_sqlite','$this->imei','$this->formulario','$this->jefe_planta','$this->encargado_maquina','$this->ultima_visita','$this->planta_de_incubacion')";
        
        $id_servicio_mantenimiento=parent::ejecutar_obtener_id($sql);
        

        if($id_servicio_mantenimiento!="-1")
        {
        $direccion_firma_invetsa="servicio_mantenimiento/firma/".$id_servicio_mantenimiento."firma_invetsa".$this->fecha.".txt";
        $direccion_firma_empresa="servicio_mantenimiento/firma/".$id_servicio_mantenimiento."firma_empresa".$this->fecha.".txt";
        $direccion_foto_jefe="servicio_mantenimiento/imagen/".$id_servicio_mantenimiento."foto_jefe".$this->fecha.".txt";
        
        $this->guardar_imagen($this->firma_invetsa,$direccion_firma_invetsa);
        $this->guardar_imagen($this->firma_jefe_planta,$direccion_firma_empresa);
        $this->guardar_imagen($this->imagen_jefe,$direccion_foto_jefe);
        $actualizar="UPDATE servicio_mantenimiento set firma_invetsa='$direccion_firma_invetsa', firma_jefe_planta='$direccion_firma_empresa',imagen_jefe='$direccion_foto_jefe' where id='$id_servicio_mantenimiento'";
        
        $actualizado=parent::ejecutar($actualizar);

            return true;
        }
        else
            return false;
    }



}






    /*

                $imagen64 = $imagenes[$cont];
                $gestor = fopen($imagen64, "r");
                $contenido = fread($gestor, filesize($imagen64));
                $contenido = base64_encode($contenido);
                fclose($gestor);      
                $direccion_fotocopias = "Imagen_Conductor/".$request['ci']."(".$cont.").txt";                
                file_put_contents($direccion_fotocopias, $contenido);    



                $id_fotocopia = DB::table('fotocopia')->insert([ // SE INSERTA AL CONDUCTOR
                 'nombre' => $nombre_fotocopia[$cont], 
                 'numero' => $request['ci']
                 ]); 

                $id_fotocopia = DB::select("SELECT @@identity AS id FROM fotocopia");

                DB::table('foto')->insert([ // SE INSERTA AL CONDUCTOR
                 'id_fotocopia' => $id_fotocopia[0]->id, 
                 'direccion' => $direccion_fotocopias
                 ]);  
                 $cont++;  
    */