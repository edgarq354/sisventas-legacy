<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
 

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth; 
use App\Notificacion;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Exception;
use Storage;
use Illuminate\Support\Facades\Validator;


class DesaparecidoController extends Controller
{
    public function __construct() {
         $this->middleware('auth');
    }

	function index(){
       $desaparecido=DB::select("SELECT  * from desaparecido order by id desc");
    return view('desaparecido.index',["desaparecido"=>$desaparecido ]);        
	}

   

      public function create(){
       return view('desaparecido.create');
    }
 
    public function store(Request $request){
      try {

            $estado=0;
          if($request['estado']){
            $estado=1;
          }
      DB::beginTransaction();

             DB::table('desaparecido')->insert([ // SE INSERTA AL CONDUCTOR
             'nombre' => ucfirst(strtolower($request['nombre'])), 
             'descripcion' =>  $request['descripcion'], 
             'direccion' =>  $request['direccion'], 
             'fecha_nacimiento' => $request['fecha_nacimiento'],
             'fecha_desaparecido' => $request['fecha_desaparecido'],
             'sexo' => $request['sexo'],
             'latitud' => $request['latitud'],
             'longitud' => $request['longitud'],
             'celular_referencia_1' => $request['celular_referencia_1'],
             'celular_referencia_2' => $request['celular_referencia_2'],
             'nombre_referencia_1' => $request['nombre_referencia_1'],
             'nombre_referencia_2' => $request['nombre_referencia_2'],
             'id_login' =>'0',
              'estado'=>$estado
               ]); 



              DB::commit();          
            Session::flash('message','CREADO CORRECTAMENTE');
            return Redirect::to('/desaparecido');                                                                 
              
      }catch (Exception $e) {
          DB::rollback();
          return redirect('/desaparecido/create')->with("message-error","ERROR INTENTE NUEVAMENTE");      
      }   
    }


 



    public function edit($id){
  
       $desaparecido = DB::select("SELECT * from desaparecido where id=".$id);
       $mensaje = DB::select("SELECT * from chat c, usuario u where c.id_usuario=u.id and c.id_desaparecido=".$id." ORDER BY c.id desc");
        $usuario = DB::select("SELECT u.* from chat c, usuario u where c.id_usuario=u.id  and c.id_desaparecido=".$id." group by u.id   ORDER BY u.id desc");

       return view('desaparecido.edit',[
        'desaparecido'=>$desaparecido,
        'mensaje'=>$mensaje,
        'usuario'=>$usuario
      ]);
    }

      function detalle_chat_por_id_usuario($id_usuario,$id_desaparecido){
         $mensaje = DB::select("SELECT * from chat c, usuario u 
          where  u.id=".$id_usuario." 
          and c.id_usuario=u.id 
          and c.id_desaparecido=".$id_desaparecido." ORDER BY c.id asc");
        return response($mensaje);
    }

 
    public function Actualizar_Desaparecido(Request $request){
        $estado=0;
          if($request['estado']){
            $estado=1;
          }
          
                //ACTUALIZA CUANDO NO TIENE IMAGEN
                      DB::table('desaparecido')->where('id', $request['id_desaparecido'])->update([
             'nombre' => ucfirst(strtolower($request['nombre'])), 
             'descripcion' =>  $request['descripcion'], 
             'direccion' =>  $request['direccion'], 
             'direccion_imagen' =>  $request['direccion_imagen'], 
             'fecha_nacimiento' => $request['fecha_nacimiento'],
             'fecha_desaparecido' => $request['fecha_desaparecido'],
             'fecha_encontrado' => $request['fecha_encontrado'],
             'detalle_encontrado' => $request['detalle_encontrado'],
             'sexo' => $request['sexo'],
             'latitud' => $request['latitud'],
             'longitud' => $request['longitud'],
             'celular_referencia_1' => $request['celular_referencia_1'],
             'celular_referencia_2' => $request['celular_referencia_2'],
             'nombre_referencia_1' => $request['nombre_referencia_1'],
             'nombre_referencia_2' => $request['nombre_referencia_2'],
             'estado'=>$estado
                         ]);             
            
          
            Session::flash('message','ACTUALIZADO CORRECTAMENTE');
            return Redirect::to('/desaparecido');          
    }

 
 
 
  //CODIGO PARA AJAX. SUBIR IMAGENES DE PERFIL
    public function subir_imagen_perfil(Request $request)
    {
        $archivo = $request->file('perfil_imagen_perfil');
        $input  = array('image' => $archivo) ;
        $reglas = array('image' => 'required|image|mimes:jpeg,jpg,bmp,png,gif|max:10000');
        $validacion = Validator::make($input,  $reglas);
        if ($validacion->fails())
        {
          return view("mensajes.msj_rechazado")->with("msj","El archivo no es una imagen valida");
        }
        else
        {
             
                        $nombre_original=$archivo->getClientOriginalName();
                            $extension=$archivo->getClientOriginalExtension();
                            $nuevo_nombre="Imagen_PERFIL-".$request['id_desaparecido'].".".$extension;
                           // $r1=Storage::disk('Imagen_Desaparecido')->put($nuevo_nombre,  \File::get($archivo) );
                           $rutadelaimagen="Imagen_Desaparecido/".$nuevo_nombre;


//implementado para modificar la direccion de la imagen en el conductor.
                            $gestor = fopen($archivo, "r");
                            $contenido = fread($gestor, filesize($archivo));
                            fclose($gestor);      
                            $direccion_perfil = "Imagen_Desaparecido/Perfil-".$request['id_desaparecido'].".png"; 
                            file_put_contents("../storage/".$direccion_perfil, $contenido);   
//fin de la odificacion de la imagen

                    DB::table('desaparecido')->where('id',$request['id_desaparecido'])->update(['direccion_imagen'=>$direccion_perfil]); //ACTUALIZO LOS FOREIGN KEY DEL VEHICULO

                    
                                return "../../storage/".$rutadelaimagen;
                            
          
        }
    }
 
}
