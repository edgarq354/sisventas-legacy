<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use App\Usuario;
use Illuminate\Support\Facades\DB;

   
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


class Producto_tipoController extends Controller
{

     public function __construct() {
         $this->middleware('auth');
    }
 
    public function create()
    {
     
     $tipo_producto=DB::select("SELECT * from tipo_producto  where id_empresa=".Auth::user()->id_empresa);
    	return view('producto_tipo.create',['tipo_producto'=>$tipo_producto] );
    }

    public function index(Request $Request)
    {
     $id_tipo_producto=$Request['id_tipo_producto'];

      if($id_tipo_producto=="0"||$id_tipo_producto==""){
    
           $producto=DB::select("SELECT * from producto where id_lugar is null and id_empresa=".Auth::user()->id_empresa ); 
        }
          else
          {
               $producto=DB::select("SELECT * from producto where id_tipo_producto=".$id_tipo_producto . " and id_empresa=".Auth::user()->id_empresa ); 
          }

          $tipo=DB::select("SELECT * from tipo_producto where id_empresa=".Auth::user()->id_empresa);
         return view('producto_tipo.index',['producto_tipo'=>$producto,'tipo'=>$tipo]);

    }


      public function Actualizar_producto_tipo(Request $request){
      DB::beginTransaction(); 
       
        try {

          $id_producto=$request['id_producto'];
          $cantidad_agregar=$request['cantidad_agregar'];
          $cantidad_actual=$request['cantidad_actual'];

          $cantidad=$cantidad_actual+$cantidad_agregar;

           $pedido = DB::table('producto')
           ->where('id',$request['id_producto'])
           ->update([
         
                  'cantidad'=>$cantidad,
            ]);
                DB::commit();
               return redirect('/producto_tipo')->with("message","SE REGISTRO CORRECTAMENTE");  

        } catch (Exception $e) {
          DB::rollback();
          return redirect('/producto_tipo')->with("message-error","ERROR INTENTE NUEVAMENTE");      
        }       
         
      }

      public function Actualizar_producto_tipo_menos(Request $request){
      DB::beginTransaction(); 
       
        try {

          $id_producto=$request['id_producto_2'];
          $cantidad_agregar=$request['cantidad_agregar_2'];
          $cantidad_actual=$request['cantidad_actual_2'];

          $cantidad=(int)$cantidad_actual-(int)$cantidad_agregar;

           $pedido = DB::table('producto')
           ->where('id',$request['id_producto_2'])
           ->update([
         
                  'cantidad'=>$cantidad,
            ]);
                DB::commit();
               return redirect('/producto_tipo')->with("message","SE REGISTRO CORRECTAMENTE");  

        } catch (Exception $e) {
          DB::rollback();
          return redirect('/producto_tipo')->with("message-error","ERROR INTENTE NUEVAMENTE");      
        }       
         
      }

    public function edit($id_producto)
    {
            //ADMINISTRADOR DE TOD
          $producto=DB::select("SELECT * from producto where id=".$id_producto . "  and id_empresa=".Auth::user()->id_empresa); 

        $tipo=DB::select("SELECT * from tipo_producto where id_empresa=".Auth::user()->id_empresa );

       return view('producto_tipo.edit',["producto"=>$producto,'tipo_producto'=>$tipo ]);   
    }

    public function store(Request $request){
        	DB::beginTransaction(); 
          
        try {
        
                DB::table('producto')->insert([
                  'nombre'=>$request['nombre'], 
                  'descripcion'=>$request['descripcion'],
                  'precio'=>$request['precio'],
                  'cantidad'=>$request['cantidad'],
                  'id_tipo_producto'=>$request['id_tipo_producto'],
                  'nombre_tipo'=>$request['nombre_tipo_producto'],
                  'imei'=>$request['imei'],
                  'id_tipo_producto'=>$request['id_tipo_producto']
                  
                  ]
                  );      
                DB::commit();
                return redirect('/producto_tipo')->with("message","SE REGISTRO CORRECTAMENTE");  

        } catch (Exception $e) {
          DB::rollback();
          return redirect('/producto_tipo')->with("message-error","ERROR INTENTE NUEVAMENTE");      
        }      
    	}

     




















      //SUBIR LOGO DE LOS productoES
    public function subir_imagen1(Request $request)
    {
       
          $archivo = $request->file('perfil_imagen1');
        $input  = array('image' => $archivo) ;
        $reglas = array('image' => 'required|image|mimes:jpeg,jpg,bmp,png,gif|max:10000');
        $validacion = Validator::make($input,  $reglas);
        if ($validacion->fails())
        {
          return view("mensajes.msj_rechazado")->with("msj","El archivo no es una imagen valida");
        }
        else
        {
              
             $id_producto=$request['id_producto'];
              $rutadelaimagen="";
     
                        $nombre_original=$archivo->getClientOriginalName();
                            $extension=$archivo->getClientOriginalExtension();

                            $nuevo_nombre="Imagen_PRODUCTO-1-".$id_producto.".".$extension;

                            $r1=Storage::disk('Imagen_Empresa')->put($nuevo_nombre,  \File::get($archivo) );
                            $rutadelaimagen="Imagen_Empresa/".$nuevo_nombre;


    
                    
                      DB::table('producto')->where('id',$id_producto)-> update(['imagen1'=>$rutadelaimagen]);    
                 
                   

                    
                    
                                return "../../../storage/".$rutadelaimagen;
            }
        }

          //SUBIR LOGO DE LOS productoES
    public function subir_imagen2(Request $request)
    {
       
          $archivo = $request->file('perfil_imagen2');
        $input  = array('image' => $archivo) ;
        $reglas = array('image' => 'required|image|mimes:jpeg,jpg,bmp,png,gif|max:10000');
        $validacion = Validator::make($input,  $reglas);
        if ($validacion->fails())
        {
          return view("mensajes.msj_rechazado")->with("msj","El archivo no es una imagen valida");
        }
        else
        {
              
             $id_producto=$request['id_producto'];
              $rutadelaimagen="";
     
                        $nombre_original=$archivo->getClientOriginalName();
                            $extension=$archivo->getClientOriginalExtension();

                            $nuevo_nombre="Imagen_PRODUCTO-2-".$id_producto.".".$extension;

                            $r1=Storage::disk('Imagen_Empresa')->put($nuevo_nombre,  \File::get($archivo) );
                            $rutadelaimagen="Imagen_Empresa/".$nuevo_nombre;


    
                    
                      DB::table('producto')->where('id',$id_producto)-> update(['imagen2'=>$rutadelaimagen]);    
                 
                   

                    
                    
                                return "../../../storage/".$rutadelaimagen;
            }
        }

          //SUBIR LOGO DE LOS productoES
    public function subir_imagen3(Request $request)
    {
       
          $archivo = $request->file('perfil_imagen3');
        $input  = array('image' => $archivo) ;
        $reglas = array('image' => 'required|image|mimes:jpeg,jpg,bmp,png,gif|max:10000');
        $validacion = Validator::make($input,  $reglas);
        if ($validacion->fails())
        {
          return view("mensajes.msj_rechazado")->with("msj","El archivo no es una imagen valida");
        }
        else
        {
              
             $id_producto=$request['id_producto'];
              $rutadelaimagen="";
     
                        $nombre_original=$archivo->getClientOriginalName();
                            $extension=$archivo->getClientOriginalExtension();

                            $nuevo_nombre="Imagen_PRODUCTO-3-".$id_producto.".".$extension;

                            $r1=Storage::disk('Imagen_Empresa')->put($nuevo_nombre,  \File::get($archivo) );
                            $rutadelaimagen="Imagen_Empresa/".$nuevo_nombre;


    
                    
                      DB::table('producto')->where('id',$id_producto)-> update(['imagen3'=>$rutadelaimagen]);    
                 
                   

                    
                    
                                return "../../../storage/".$rutadelaimagen;
            }
        }

          //SUBIR LOGO DE LOS productoES
    public function subir_imagen4(Request $request)
    {
       
          $archivo = $request->file('perfil_imagen4');
        $input  = array('image' => $archivo) ;
        $reglas = array('image' => 'required|image|mimes:jpeg,jpg,bmp,png,gif|max:10000');
        $validacion = Validator::make($input,  $reglas);
        if ($validacion->fails())
        {
          return view("mensajes.msj_rechazado")->with("msj","El archivo no es una imagen valida");
        }
        else
        {
              
             $id_producto=$request['id_producto'];
              $rutadelaimagen="";
     
                        $nombre_original=$archivo->getClientOriginalName();
                            $extension=$archivo->getClientOriginalExtension();

                            $nuevo_nombre="Imagen_PRODUCTO-4-".$id_producto.".".$extension;

                            $r1=Storage::disk('Imagen_Empresa')->put($nuevo_nombre,  \File::get($archivo) );
                            $rutadelaimagen="Imagen_Empresa/".$nuevo_nombre;


    
                    
                      DB::table('producto')->where('id',$id_producto)-> update(['imagen4'=>$rutadelaimagen]);    
                 
                   

                    
                    
                                return "../../../storage/".$rutadelaimagen;
            }
        }

          //SUBIR LOGO DE LOS productoES
    public function subir_imagen5(Request $request)
    {
       
          $archivo = $request->file('perfil_imagen5');
        $input  = array('image' => $archivo) ;
        $reglas = array('image' => 'required|image|mimes:jpeg,jpg,bmp,png,gif|max:10000');
        $validacion = Validator::make($input,  $reglas);
        if ($validacion->fails())
        {
          return view("mensajes.msj_rechazado")->with("msj","El archivo no es una imagen valida");
        }
        else
        {
              
             $id_producto=$request['id_producto'];
              $rutadelaimagen="";
     
                        $nombre_original=$archivo->getClientOriginalName();
                            $extension=$archivo->getClientOriginalExtension();

                            $nuevo_nombre="Imagen_PRODUCTO-5-".$id_producto.".".$extension;

                            $r1=Storage::disk('Imagen_Empresa')->put($nuevo_nombre,  \File::get($archivo) );
                            $rutadelaimagen="Imagen_Empresa/".$nuevo_nombre;


    
                    
                      DB::table('producto')->where('id',$id_producto)-> update(['imagen5'=>$rutadelaimagen]);    
                 
                   

                    
                    
                                return "../../../storage/".$rutadelaimagen;
            }
        }

    



}
