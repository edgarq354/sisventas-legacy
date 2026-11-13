<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Auth;
use App\Usuario;
use DB;

   
use Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator; 
use App\Http\Requests\ProductoRequest;


class ProductoController extends Controller
{

     public function __construct() {
         $this->middleware('auth');
    }
 
    function index()
    {
  
          $producto=DB::select("SELECT p.*,c.nombre as 'nombre_tipo_producto' 
            from producto p
            inner join tipo_producto c 
            on (c.id=p.id_tipo_producto)
            where  p.id_lugar=".Auth::user()->id_empresa);
 

          $tipo_producto=DB::table('tipo_producto') 
          ->where('id_empresa',Auth::user()->id_empresa)->orderby('nombre')->get();


       return view('producto.index',[
        'producto'=>$producto,
        'tipo_producto'=>$tipo_producto,
        'id_empresa'=>Auth::user()->id_empresa
      ]);   

    }

     function inventario()
    {
  
          $producto=DB::select("SELECT p.*,c.nombre as 'nombre_tipo_producto' 
            from producto p
            inner join tipo_producto c 
            on (c.id=p.id_tipo_producto)
            where  p.id_lugar=".Auth::user()->id_empresa);
 

          $tipo_producto=DB::table('tipo_producto') 
          ->where('id_empresa',Auth::user()->id_empresa)->orderby('nombre')->get();


       return view('producto.inventario',[
        'producto'=>$producto,
        'tipo_producto'=>$tipo_producto,
        'id_empresa'=>Auth::user()->id_empresa
      ]);    
    }


    public function inventario_imprimir()
    {
  
          $producto=DB::select("SELECT p.*,c.nombre as 'nombre_tipo_producto'
            from producto p
            inner join tipo_producto c 
            on (c.id=p.id_tipo_producto)
            where  p.id_lugar=".Auth::user()->id_empresa);
 

           $empresa=DB::select("SELECT * from empresa  where id='".Auth::user()->id_empresa."'");


        $pdf=\PDF::loadView('producto.inventario_imprimir',[
        'producto'=>$producto, 
        'empresa'=>$empresa
      ]);    
      return   $pdf->stream(); 
    }


    function producto_imprimir()
    { 
          $producto=DB::select("SELECT p.*,c.nombre as 'nombre_tipo_producto' 
            from producto p
            inner join tipo_producto c 
            on (c.id=p.id_tipo_producto)
            where  p.id_lugar=".Auth::user()->id_empresa);
 
            $empresa=DB::select("SELECT * from empresa  where id='".Auth::user()->id_empresa."'");


      $pdf=\PDF::loadView('producto.producto_imprimir',[
        'producto'=>$producto, 
        'empresa'=>$empresa
      ]);    
      return   $pdf->stream();
    }



    function producto_utilidad_imprimir()
    {
       if(Auth::user()->privilegio==0){
      $producto=DB::select("SELECT p.*,c.nombre as 'nombre_tipo_producto' ,
      p.precio,  p.precio_compra, p.cantidad,p.precio_mayorista ,
      (p.peso * (p.precio_compra)) as inversion
        from producto p
        inner join tipo_producto c on (c.id=p.id_tipo_producto)  
        where  p.id_empresa=".Auth::user()->id_empresa." 
        ORDER BY p.id_tipo_producto ASC");

       

      }else{
        $producto=DB::select("SELECT p.*,c.nombre as 'nombre_tipo_producto' ,
        p.precio,  p.precio_compra, p.cantidad,p.precio_mayorista ,
        (p.peso * (p.precio_compra)) as inversion
          from producto p
          inner join tipo_producto c on (c.id=p.id_tipo_producto)  
          where  p.id_empresa=".Auth::user()->id_empresa." 
        ORDER BY p.id_tipo_producto ASC");

      }

      $sucursal=DB::select("SELECT  s.*
      from   sucursal s  
      where  s.id_empresa=".Auth::user()->id_empresa);
      $empresa=DB::select("SELECT * from empresa  where id='".Auth::user()->id_empresa."'");


      $pdf=\PDF::loadView('producto.producto_utilidad_imprimir',[
        'producto'=>$producto, 
        'empresa'=>$empresa,
        'sucursal'=>$sucursal
      ]);    
      return   $pdf->stream();
    }
//CARGAR PARA PODER ACTUALIZAR EN LA PARTE DEL MODAL
public function get_lista_producto($id_lugar){
  $producto=DB::select("SELECT p.*,c.nombre as 'nombre_tipo_producto' 
  from producto p
  inner join tipo_producto c 
  on (c.id=p.id_tipo_producto)
  where  p.id_lugar=".Auth::user()->id_empresa);

  return response($producto);
}

    function producto_lugar($id_lugar)
    {
      $id_lugar=Auth::user()->id_empresa;
  
          $producto=DB::select("SELECT p.*,c.nombre as 'nombre_tipo_producto' 
            from producto p
            inner join tipo_producto c 
            on (c.id=p.id_tipo_producto)
            where  p.id_lugar=".$id_lugar);
 

          $tipo_producto=DB::table('tipo_producto') 
          ->where('id_empresa',Auth::user()->id_empresa)->orderby('nombre')->get();


       return view('producto.index',[
        'producto'=>$producto,
        'tipo_producto'=>$tipo_producto,
        'id_empresa'=>$id_lugar
      ]);   

    }



    function create()
    {
     
    	return view('producto.create' );
    }

    function edit($id_producto)
    {
            //ADMINISTRADOR DE TOD
          $producto=DB::table('producto')
          ->where('id',$id_producto)
          ->get();

           $tipo_producto=DB::table('tipo_producto') 
           ->where('id_empresa',Auth::user()->id_empresa)->orderby('nombre')->get();

 
       return view('producto.edit',[
        "producto"=>$producto,
        "tipo_producto"=>$tipo_producto ]);   
    }

    public function store(ProductoRequest $request){
        	DB::beginTransaction(); 
          $id_lugar=Auth::user()->id_empresa;

           $estado_pedido=0;
            if($request['estado_pedido_producto']){
              $estado_pedido=1;
            }


        try {
          $id_lugar=$request['id_lugar'];
        
                $id_producto=DB::table('producto')->insertGetId([
                  'nombre'=>$request['nombre'], 
                  'numero_serie'=>$request['numero_serie'], 
		  'codigo_producto'=>$request['codigo_producto'], 
                  'modelo'=>$request['modelo'], 
                  'marca'=>$request['marca'], 
                  'descripcion'=>$request['descripcion'],
                  'precio'=>$request['precio'],
                  'precio_compra'=>$request['precio_compra'],
                  'cantidad'=>$request['cantidad'],
                  'cantidad_minima'=>$request['cantidad_minima'],
                  'peso'=>$request['peso'],
                  'peso_minimo'=>$request['peso_minimo'],
                  'id_lugar'=>Auth::user()->id_empresa,
                  'id_empresa'=>Auth::user()->id_empresa,
                  'estado_pedido'=>$estado_pedido,
                  'id_tipo_producto'=>$request['id_tipo_producto'],
                  'precio_mayorista'=>$request['precio_mayorista'],
                  'precio_venta_2'=>$request['precio_venta_2'],
                  'precio_compra_sus'=>$request['precio_compra_sus']
                  ]
                  );      

            //ACTUALIZAR LA FOTO DEL PRODUCTO
            $archivo = $request->file('imagen1_producto');
            $input  = array('image' => $archivo) ;
            $reglas = array('image' => 'required|image|mimes:jpeg,jpg,bmp,png,gif|max:900');
            $validacion = Validator::make($input,  $reglas);
            if ($validacion->fails())
            {
             // return view("mensajes.msj_rechazado")->with("msj","El archivo no es una imagen valida");
            }
            else
            {
                     $rutadelaimagen="";
                          $nombre_original=$archivo->getClientOriginalName();
                          $extension=$archivo->getClientOriginalExtension();
                          $nuevo_nombre="Imagen_PRODUCTO-1-".$id_producto.".".$extension;
                          $r1=Storage::disk('Imagen_Empresa')->put($nuevo_nombre,  \File::get($archivo) );
                          $rutadelaimagen="Imagen_Empresa/".$nuevo_nombre;
                          
                            

                DB::table('producto')
                ->where('id',$id_producto)
                ->update(['imagen1'=>$rutadelaimagen]);              
                      }
              

                DB::commit();
                return redirect('/producto')->with("message","SE REGISTRO CORRECTAMENTE");  

        } catch (Exception $e) {
          DB::rollback();
          return redirect('/lugar')->with("message-error","ERROR INTENTE NUEVAMENTE");      
        }      
    	}

    	public function update(ProductoRequest $request){
    	DB::beginTransaction(); 
        $id_lugar=Auth::user()->id_empresa;

            $estado_pedido=0;
            if($request['estado_pedido']){
              $estado_pedido=1;
            }

        try {
            
          $id_lugar=Auth::user()->id_empresa;

	         $pedido = DB::table('producto')
	         ->where('id',$request['id_producto'])
	         ->update([
	         	'nombre'=>$request['nombre'], 
	         	'numero_serie'=>$request['numero_serie'], 
			'codigo_producto'=>$request['codigo_producto'], 
	         	'marca'=>$request['marca'], 
	         	'modelo'=>$request['modelo'], 
                  'descripcion'=>$request['descripcion'],
                  'precio'=>$request['precio'],
                  'precio_compra'=>$request['precio_compra'],
                  'cantidad_minima'=>$request['cantidad_minima'],
                   'cantidad'=>$request['cantidad'],
                   'peso'=>$request['peso'],
                   'peso_minimo'=>$request['peso_minimo'],
                   'estado_pedido'=>$estado_pedido,
                   'id_tipo_producto'=>$request['id_tipo_producto'],
                   'precio_mayorista'=>$request['precio_mayorista'],
                   'precio_mayorista'=>$request['precio_mayorista'],
                  'precio_venta_2'=>$request['precio_venta_2'],
                  'precio_compra_sus'=>$request['precio_compra_sus']
	         	]);


                DB::commit();
               return redirect('/producto')->with("message","SE REGISTRO CORRECTAMENTE");  

        } catch (Exception $e) {
          DB::rollback();
          return redirect('/producto')->with("message-error","ERROR INTENTE NUEVAMENTE");      
        }      	
    		 
    	}




    	public function eliminar_producto($id){
 
         
          $producto=DB::select("SELECT p.* 
          from producto p 
          where  p.id=".$id);
           $eliminado = DB::table('producto')->where('id', $id)->delete();
          if ($eliminado) {
              // El producto se eliminó correctamente
              //aqui obtenenos la IP
              $ip=$_SERVER['REMOTE_ADDR']; //A la variable ip le asignamos la ip remota
              $json = json_encode($producto);
              DB::table('bitacora')->insert([
                'id_usuario'=>Auth::user()->id,
                'id_empresa'=> Auth::user()->id_empresa ,
                'nombre'=> Auth::user()->nombre,
                'mensaje'=> "Eliminacion de Producto",
                'ip'=>$ip ,
                'detalle'=>$json,
                ]);
              return redirect('/producto')->with("message","SE ELIMINO CORRECTAMENTE");  
          } else {
              // El producto no se pudo eliminar
              return redirect('/producto')->with("message-error","ERROR INTENTE NUEVAMENTE");   
          }
        }
  
  
  







//actualizar producto

      public function actualizar_producto(ProductoRequest $request){
      DB::beginTransaction(); 
        $id_lugar="";

            $estado_pedido=0;
            if($request['estado_pedido']){
              $estado_pedido=1;
            }

        try {
            
          $id_lugar=$request['id_lugar'];

           $pedido = DB::table('producto')
           ->where('id',$request['id_producto'])
           ->update([
            'nombre'=>$request['nombre'], 
            'numero_serie'=>$request['numero_serie'], 
	    'codigo_producto'=>$request['codigo_producto'], 
            'marca'=>$request['marca'], 
            'modelo'=>$request['modelo'], 
                  'descripcion'=>$request['descripcion'],
                  'precio'=>$request['precio'],
                  'precio_compra'=>$request['precio_compra'],
                  'cantidad_minima'=>$request['cantidad_minima'],
                  'cantidad'=>$request['cantidad'],
                  'peso_minimo'=>$request['peso_minimo'],
                  'peso'=>$request['peso'],
                   'estado_pedido'=>$estado_pedido,
                   'id_tipo_producto'=>$request['id_tipo_producto'],
                   'precio_mayorista'=>$request['precio_mayorista'],
                   'precio_mayorista'=>$request['precio_mayorista'],
                  'precio_venta_2'=>$request['precio_venta_2'],
                  'precio_compra_sus'=>$request['precio_compra_sus']
            ]);


              //ACTUALIZAR LA FOTO DEL PRODUCTO
              $archivo = $request->file('imagen1_producto');
              $input  = array('image' => $archivo) ;
              $reglas = array('image' => 'required|image|mimes:jpeg,jpg,png|max:900');
              $validacion = Validator::make($input,  $reglas);
              if ($validacion->fails())
              {
               // return view("mensajes.msj_rechazado")->with("msj","El archivo no es una imagen valida");
              }
              else
              {
                       $rutadelaimagen="";
                            $nombre_original=$archivo->getClientOriginalName();
                            $extension=$archivo->getClientOriginalExtension();
                            $nuevo_nombre="Imagen_PRODUCTO-1-".$request['id_producto'].".".$extension;
                            $r1=Storage::disk('Imagen_Empresa')->put($nuevo_nombre,  \File::get($archivo) );
                            $rutadelaimagen="Imagen_Empresa/".$nuevo_nombre;
                            
                              

                  DB::table('producto')
                  ->where('id',$request['id_producto'])
                  ->update(['imagen1'=>$rutadelaimagen]);              
                        }

                  
              


                DB::commit();
               return redirect('/producto')->with("message","SE REGISTRO CORRECTAMENTE");  

        } catch (Exception $e) {
          DB::rollback();
          return redirect('/producto')->with("message-error","ERROR INTENTE NUEVAMENTE");      
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


    //CARGAR PARA PODER ACTUALIZAR EN LA PARTE DEL MODAL
    public function get_producto_por_id($id_producto){
        $producto=DB::select("SELECT *from producto where id=".$id_producto);
        return response($producto);
    }


    public function ProductosMinimos()
    {
  
          $producto=DB::select("SELECT p.*,c.nombre as 'nombre_tipo_producto' 
            from producto p
            inner join tipo_producto c 
            on (c.id=p.id_tipo_producto)
            where p.peso_minimo>=p.peso and  p.id_lugar=".Auth::user()->id_empresa." ORDER BY nombre_tipo_producto,nombre asc");
  
            $empresa=DB::select("SELECT * from empresa  where id='".Auth::user()->id_empresa."'");
      $pdf=\PDF::loadView('producto.rptMinimos',[
        'producto'=>$producto,
        'empresa'=>$empresa
      ]);   
      return   $pdf->stream(); 
    }
}