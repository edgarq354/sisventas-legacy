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
use Illuminate\Support\Facades\Validator;
use Yajra\Datatables\Facades\Datatables;



class Tipo_productoController extends Controller
{
         public function __construct() {
         $this->middleware('auth');
    }
    
   function index()
    {
            //ADMINISTRADOR DE TOD
          $tipo_producto=DB::table('tipo_producto')->where('id_empresa',Auth::user()->id_empresa)->orderby('nombre')->get();
        
       return view('tipo_producto.index',['tipo_producto'=>$tipo_producto]);   
    }

    public function store(Request $request){
        	DB::beginTransaction(); 
        try {
        
                DB::table('tipo_producto')->insert([
                  'nombre'=>$request['nombre'], 
                  'id_empresa'=>Auth::user()->id_empresa
                  ]
                  );      
                DB::commit();
                return redirect('/tipo_producto')->with("message","SE REGISTRO CORRECTAMENTE");  

        } catch (Exception $e) {
          DB::rollback();
          return redirect('/tipo_producto')->with("message-error","ERROR INTENTE NUEVAMENTE");      
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
          
	         $pedido = DB::table('tipo_producto')
	         ->where('id',$request['id_tipo_producto_edit'])
           ->update([
            'nombre'=>$request['nombre_edit'],
            'estado'=>$estado,
            'estado_pedido'=>$estado_pedido,
              ]);

           $producto_tipo = DB::table('producto')
           ->where('id_tipo_producto',$request['id_tipo_producto_edit'])
           ->update(['nombre_tipo'=>$request['nombre_edit']  ]);

                DB::commit();
                return redirect('/tipo_producto')->with("message","SE ACTUALIZO CORRECTAMENTE");  

        } catch (Exception $e) {
          DB::rollback();
          return redirect('/tipo_producto')->with("message-error","ERROR INTENTE NUEVAMENTE");      
        }      	
    		 
    	}


    public function subir_imagen_tipo(Request $request)
    {
        $archivo = $request->file('perfil_imagen_tipo');
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
                            $nuevo_nombre="Imagen_PERFIL-".$request['id_tipo_producto_edit_2'].".".$extension;
                       //     $r1=Storage::disk('Imagen_Categoria')->put($nuevo_nombre,  \File::get($archivo) );
                           $rutadelaimagen="Imagen_Tipo_Producto/".$nuevo_nombre;


//implementado para modificar la direccion de la imagen en el conductor.
                            $gestor = fopen($archivo, "r");
                            $contenido = fread($gestor, filesize($archivo));
                            fclose($gestor);      
                            $direccion_perfil = "Imagen_Tipo_Producto/Perfil-".$request['id_tipo_producto_edit_2'].".png"; 
                            file_put_contents("../storage/".$direccion_perfil, $contenido);   
//fin de la odificacion de la imagen

                   
                   
                    DB::table('tipo_producto')->where('id',$request['id_tipo_producto_edit_2'])->update(['direccion_imagen'=>$direccion_perfil]); //ACTUALIZO LOS FOREIGN KEY DEL VEHICULO

                    
                                return "../../storage/".$rutadelaimagen;
                            
          
        }
    }   

    function cargar_tipo_producto($id_video){
        $apoderado=DB::select("SELECT * FROM tipo_producto WHERE id=".$id_video);
        return response($apoderado);
    }  

        function categoria_imprimir()
    { 
          $tipo_producto=DB::select("SELECT * from tipo_producto  where id_empresa='".Auth::user()->id_empresa."'");
            $empresa=DB::select("SELECT * from empresa  where id='".Auth::user()->id_empresa."'");
            
       $pdf=\PDF::loadView('tipo_producto.categoria_imprimir',[
        'tipo_producto'=>$tipo_producto,
        'empresa'=>$empresa
      ]);    
      return   $pdf->stream(); 
    }       
}
