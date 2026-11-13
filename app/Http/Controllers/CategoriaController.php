<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use App\Usuario;
use App\Notificacion;
use Exception;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Storage;
use Yajra\Datatables\Facades\Datatables;
use Illuminate\Support\Facades\Validator;



class CategoriaController extends Controller
{
         public function __construct() {
         $this->middleware('auth');
    }
    
   function index()
    {
            //ADMINISTRADOR DE TOD
          $categoria=DB::table('categoria')->where('id_empresa',Auth::user()->id_empresa)->orderby('id_empresa')->get();
        
       return view('categoria.index',['categoria'=>$categoria]);   
    }

    public function store(Request $request){
        	DB::beginTransaction(); 
        try {
        
                DB::table('categoria')->insert([
                  'nombre'=>$request['nombre'], 
                  'id_empresa'=>$request['id_empresa']
                  ]
                  );      
                DB::commit();
                return redirect('/categoria')->with("message","SE REGISTRO CORRECTAMENTE");  

        } catch (Exception $e) {
          DB::rollback();
          return redirect('/categoria')->with("message-error","ERROR INTENTE NUEVAMENTE");      
        }      
    	}

    	public function update(Request $request){
    	DB::beginTransaction(); 
        try {
          $estado=0;
          $estado_pedido=0;
          if($request['estado_edit']){
            $estado=1;
          }
          
           if($request['estado_pedido_edit']){
            $estado_pedido=1;
          }

	         $pedido = DB::table('categoria')
	         ->where('id',$request['id_categoria_edit'])
           ->update(['nombre'=>$request['nombre_edit'],
            'estado'=>$estado,
             'estado_pedido'=>$estado_pedido    ]);
                DB::commit();
                return redirect('/categoria')->with("message","SE ACTUALIZO CORRECTAMENTE");  

        } catch (Exception $e) {
          DB::rollback();
          return redirect('/categoria')->with("message-error","ERROR INTENTE NUEVAMENTE");      
        }      	
    		 
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
                            $nuevo_nombre="Imagen_PERFIL-".$request['id_categoria'].".".$extension;
                       //     $r1=Storage::disk('Imagen_Categoria')->put($nuevo_nombre,  \File::get($archivo) );
                           $rutadelaimagen="Imagen_Categoria/".$nuevo_nombre;


//implementado para modificar la direccion de la imagen en el conductor.
                            $gestor = fopen($archivo, "r");
                            $contenido = fread($gestor, filesize($archivo));
                            fclose($gestor);      
                            $direccion_perfil = "Imagen_Categoria/Perfil-".$request['id_categoria'].".png"; 
                            file_put_contents("../storage/".$direccion_perfil, $contenido);   
//fin de la odificacion de la imagen

                   
                   
                    DB::table('categoria')->where('id',$request['id_categoria'])->update(['direccion_imagen'=>$direccion_perfil]); //ACTUALIZO LOS FOREIGN KEY DEL VEHICULO

                    
                                return "../../storage/".$rutadelaimagen;
                            
          
        }
    }





    function cargar_categoria($id_video){
        $apoderado=DB::select("SELECT * FROM categoria WHERE id=".$id_video);
        return response($apoderado);
    }         
}
