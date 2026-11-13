<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Http\Requests\ActualizarAdministradorRequest;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use App\Usuario;
use Illuminate\Support\Facades\DB;

   
use Hash;
use Storage;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;



class LugarController extends Controller
{

     public function __construct() {
         $this->middleware('auth');
    }

   function index()
    {
            //ADMINISTRADOR DE TOD
         $lugar=DB::select("SELECT 
            0 as 'cantidad',
            0 as 'cantidad_whatsapp',
            lugar.*

            from lugar");
        
       return view('lugar.index',["lugar"=>$lugar]);   
    }

    function create()
    {
    	$categoria=DB::table('categoria')->where('id_empresa',Auth::user()->id_empresa)->get();
    	return view('lugar.create',['categoria'=>$categoria]);
    }

    function edit($id_lugar)
    {


      $consulta_deuda = 0;

            


            //ADMINISTRADOR DE TOD
          

          $lugar=DB::select("SELECT 
            0 as 'cantidad',
            0 as 'ganancia',
            0 as 'cantidad_whatsapp',
            lugar.*

            from lugar
            where  id=".$id_lugar);
 
 
          $producto=DB::select("SELECT p.*,c.nombre as 'nombre_tipo_producto' 
            from producto p
            inner join tipo_producto c 
            on (c.id=p.id_tipo_producto)
            where  p.id_lugar=".$id_lugar);
 


          
           $horario_lugar=DB::select("SELECT * 
            from horario_lugar
            where  id_lugar=".$id_lugar." order by dia asc");
 

          $tipo_producto=DB::table('tipo_producto') 
          ->get();

       $administrador=DB::select("SELECT u.* from usuario u, lugar e where e.id_administrador=u.id and e.id='".$id_lugar."'");
        $administrador_libres=DB::select("SELECT u.id,u.nombre,u.apellido,u.celular from usuario u where u.id not in(select e.id_administrador from lugar e)"); 

        $categoria=DB::table('categoria')->where('id_empresa',Auth::user()->id_empresa)->get();
       return view('lugar.edit',[
        "lugar"=>$lugar,
        "horario_lugar"=>$horario_lugar,
        'categoria'=>$categoria,
        'producto'=>$producto,
        'tipo_producto'=>$tipo_producto,
        'administrador'=>$administrador,
        'administrador_libres'=>$administrador_libres]);   
    }

    public function store(Request $request){
        	DB::beginTransaction(); 
        try {
           $estado=0;
            $estado_pedido=0;
            $solicitud_whatsapp=0;
            $solicitud_aplicacion=0;
          
            if($request['estado']){
              $estado=1;
            }

            if($request['estado_pedido']){
              $estado_pedido=1;
            }

            if($request['solicitud_whatsapp']){
              $solicitud_whatsapp=1;
            }

             if($request['solicitud_aplicacion']){
              $solicitud_aplicacion=1;
            }
            
        
                $id_lugar=DB::table('lugar')->insertGetId([
                  'nombre'=>$request['nombre'], 
                  'nit'=>$request['nit'], 
                  'direccion'=>$request['direccion'],
                  'titulo_imagen'=>$request['titulo_imagen'],
                  'facebook'=>$request['facebook'],
                  'telefono'=>$request['telefono'],
                  'whatsapp'=>$request['whatsapp'],
                  'latitud'=>$request['latitud'],
                  'longitud'=>$request['longitud'],
                  'tiempo_preparacion'=>$request['tiempo_preparacion'],
                  'prioridad'=>$request['prioridad'],
                  'monto_minimo'=>$request['monto_minimo'],
                  'porcentaje_pago'=>$request['porcentaje_pago'],
                   
                  'id_categoria'=>$request['id_categoria'],
                  'id_empresa'=>$request['id_empresa'],
                  'estado'=>$estado,
                  'estado_pedido'=>$estado_pedido,
                  'solicitud_whatsapp'=>$solicitud_whatsapp,
                  'solicitud_aplicacion'=>$solicitud_aplicacion
                  ]
                  );   

                //REGISTRAR HORARIO
                //LUNES
                DB::table('horario_lugar')->insert([
                  'nombre_dia'=>'Lunes', 
                  'dia'=>1, 
                  'id_lugar'=>$id_lugar, 
                  'hora_inicio'=>'08:00:00', 
                  'hora_fin'=>'12:00:00', 
                  ]
                  ); 
                //LUNES
                DB::table('horario_lugar')->insert([
                  'nombre_dia'=>'Lunes', 
                  'dia'=>1, 
                  'id_lugar'=>$id_lugar, 
                  'hora_inicio'=>'14:00:00', 
                  'hora_fin'=>'20:00:00', 
                  ]
                  ); 
                //MARTES
                DB::table('horario_lugar')->insert([
                  'nombre_dia'=>'Martes', 
                  'dia'=>2, 
                  'id_lugar'=>$id_lugar, 
                  'hora_inicio'=>'08:00:00', 
                  'hora_fin'=>'12:00:00', 
                  ]
                  ); 
                 //MARTES
                DB::table('horario_lugar')->insert([
                  'nombre_dia'=>'Martes', 
                  'dia'=>2, 
                  'id_lugar'=>$id_lugar, 
                  'hora_inicio'=>'14:00:00', 
                  'hora_fin'=>'20:00:00', 
                  ]
                  ); 
                //MIERCOLES
                DB::table('horario_lugar')->insert([
                  'nombre_dia'=>'Miercoles', 
                  'dia'=>3, 
                  'id_lugar'=>$id_lugar, 
                  'hora_inicio'=>'08:00:00', 
                  'hora_fin'=>'12:00:00', 
                  ]
                  );
                   //MIERCOLES
                DB::table('horario_lugar')->insert([
                  'nombre_dia'=>'Miercoles', 
                  'dia'=>3, 
                  'id_lugar'=>$id_lugar, 
                  'hora_inicio'=>'14:00:00', 
                  'hora_fin'=>'20:00:00', 
                  ]
                  ); 
                //JUEVES
                DB::table('horario_lugar')->insert([
                  'nombre_dia'=>'Jueves', 
                  'dia'=>4, 
                  'id_lugar'=>$id_lugar, 
                  'hora_inicio'=>'08:00:00', 
                  'hora_fin'=>'12:00:00', 
                  ]
                  );
                  //JUEVES 
                DB::table('horario_lugar')->insert([
                  'nombre_dia'=>'Jueves', 
                  'dia'=>4, 
                  'id_lugar'=>$id_lugar, 
                  'hora_inicio'=>'14:00:00', 
                  'hora_fin'=>'20:00:00', 
                  ]
                  ); 

                //VIERNES
                DB::table('horario_lugar')->insert([
                  'nombre_dia'=>'Viernes', 
                  'dia'=>5, 
                  'id_lugar'=>$id_lugar, 
                  'hora_inicio'=>'08:00:00', 
                  'hora_fin'=>'12:00:00', 
                  ]
                  ); 

                //VIERNES
                DB::table('horario_lugar')->insert([
                  'nombre_dia'=>'Viernes', 
                  'dia'=>5, 
                  'id_lugar'=>$id_lugar, 
                  'hora_inicio'=>'14:00:00', 
                  'hora_fin'=>'20:00:00', 
                  ]
                  );
                //SABADO
                DB::table('horario_lugar')->insert([
                  'nombre_dia'=>'Sabado', 
                  'dia'=>6, 
                  'id_lugar'=>$id_lugar, 
                  'hora_inicio'=>'08:00:00', 
                  'hora_fin'=>'12:00:00', 
                  ]
                  ); 
                //SABADO
                DB::table('horario_lugar')->insert([
                  'nombre_dia'=>'Sabado', 
                  'dia'=>6, 
                  'id_lugar'=>$id_lugar, 
                  'hora_inicio'=>'14:00:00', 
                  'hora_fin'=>'20:00:00', 
                  ]
                  ); 
                //DOMINGO
                DB::table('horario_lugar')->insert([
                  'nombre_dia'=>'Domingo', 
                  'dia'=>7, 
                  'id_lugar'=>$id_lugar, 
                  'hora_inicio'=>'08:00:00', 
                  'hora_fin'=>'12:00:00', 
                  ]
                  ); 

                //DOMINGO
                DB::table('horario_lugar')->insert([
                  'nombre_dia'=>'Domingo', 
                  'dia'=>7, 
                  'id_lugar'=>$id_lugar, 
                  'hora_inicio'=>'14:00:00', 
                  'hora_fin'=>'20:00:00', 
                  ]
                  ); 


                DB::commit();
                return redirect('/lugar')->with("message","SE REGISTRO CORRECTAMENTE");  

        } catch (Exception $e) {
          DB::rollback();
          return redirect('/lugar')->with("message-error","ERROR INTENTE NUEVAMENTE");      
        }      
    	}

    	public function update(Request $request){
    	DB::beginTransaction(); 
        try {
            $estado=0;
            $estado_pedido=0;
            $solicitud_whatsapp=0;
            $solicitud_aplicacion=0;
          
            if($request['estado']){
              $estado=1;
            }

            if($request['estado_pedido']){
              $estado_pedido=1;
            }

            if($request['solicitud_whatsapp']){
              $solicitud_whatsapp=1;
            }

             if($request['solicitud_aplicacion']){
              $solicitud_aplicacion=1;
            }

	         $pedido = DB::table('lugar')
	         ->where('id',$request['id_lugar'])
	         ->update([
            'nombre'=>$request['nombre'], 
	         	'nit'=>$request['nit'], 
                  'direccion'=>$request['direccion'],
                  'informacion'=>$request['informacion'],
                  'titulo_imagen'=>$request['titulo_imagen'],
                  'facebook'=>$request['facebook'],
                  'telefono'=>$request['telefono'],
                  'whatsapp'=>$request['whatsapp'],
                  'latitud'=>$request['latitud'],
                  'longitud'=>$request['longitud'],
                  'tiempo_preparacion'=>$request['tiempo_preparacion'],
                  'porcentaje_pago'=>$request['porcentaje_pago'],
                  
                  'prioridad'=>$request['prioridad'],
                  'monto_minimo'=>$request['monto_minimo'],
                  'id_categoria'=>$request['id_categoria'],
                  'estado'=>$estado,
                  'estado_pedido'=>$estado_pedido,
                  'solicitud_whatsapp'=>$solicitud_whatsapp,
                  'solicitud_aplicacion'=>$solicitud_aplicacion
	         	]);

            $horario_lugar=DB::select("SELECT * 
            from horario_lugar
            where  id_lugar=".$request['id_lugar']." order by dia asc");


          foreach ($horario_lugar as $value) {
             $estado_dia=0;
              if($request['estado'.$value->id]){
              $estado_dia=1;
            }
             //REGISTRAR HORARIO
               DB::table('horario_lugar')
                ->where('id',$value->id) 
                ->where('id_lugar',$request['id_lugar'])
                ->update([
                  'hora_inicio'=>$request['hora_inicio'.$value->id], 
                  'hora_fin'=>$request['hora_fin'.$value->id], 
                  'estado'=>$estado_dia
                  ]
                  ); 
                }

                DB::commit();
                return redirect('/lugar')->with("message","SE ACTUALIZO CORRECTAMENTE");  

        } catch (Exception $e) {
          DB::rollback();
          return redirect('/lugar')->with("message-error","ERROR INTENTE NUEVAMENTE");      
        }      	
    		 
    	}




      //SUBIR LOGO DE LOS LUGARES
    public function subir_logo_lugar(Request $request)
    {
       
          $archivo = $request->file('perfil_logo');
        $input  = array('image' => $archivo) ;
        $reglas = array('image' => 'required|image|mimes:jpeg,jpg,bmp,png,gif|max:10000');
        $validacion = Validator::make($input,  $reglas);
        if ($validacion->fails())
        {
          return view("mensajes.msj_rechazado")->with("msj","El archivo no es una imagen valida");
        }
        else
        {
              
             $id_lugar=$request['id_lugar'];
              $rutadelaimagen="";
     
                        $nombre_original=$archivo->getClientOriginalName();
                            $extension=$archivo->getClientOriginalExtension();

                            $nuevo_nombre="Imagen_LOGO-".$id_lugar.".".$extension;

                            $r1=Storage::disk('Imagen_Empresa')->put($nuevo_nombre,  \File::get($archivo) );
                            $rutadelaimagen="Imagen_Empresa/".$nuevo_nombre;


    
                    
                      DB::table('lugar')->where('id',$id_lugar)-> update(['direccion_logo'=>$rutadelaimagen]);    
                 
                   

                    
                    
                                return "../../../storage/".$rutadelaimagen;
            }
        }


              //SUBIR BANNER DE LOS LUGARES
    public function subir_banner_lugar(Request $request)
    {
       
          $archivo = $request->file('perfil_banner');
        $input  = array('image' => $archivo) ;
        $reglas = array('image' => 'required|image|mimes:jpeg,jpg,bmp,png,gif|max:10000');
        $validacion = Validator::make($input,  $reglas);
        if ($validacion->fails())
        {
          return view("mensajes.msj_rechazado")->with("msj","El archivo no es una imagen valida");
        }
        else
        {
              
             $id_lugar=$request['id_lugar'];
              $rutadelaimagen="";
     
                        $nombre_original=$archivo->getClientOriginalName();
                            $extension=$archivo->getClientOriginalExtension();

                            $nuevo_nombre="Imagen_BANNER-".$id_lugar.".".$extension;

                            $r1=Storage::disk('Imagen_Empresa')->put($nuevo_nombre,  \File::get($archivo) );
                            $rutadelaimagen="Imagen_Empresa/".$nuevo_nombre;


    
                    
                      DB::table('lugar')
                      ->where('id',$id_lugar)
                      -> update(['direccion_banner'=>$rutadelaimagen]); 
                    
                                return "../../../storage/".$rutadelaimagen;
            }
        }

  function Cambiar_Administrador_Lugar(ActualizarAdministradorRequest $request) {
        DB::table('lugar')->where('id', $request['id_empresa'])->update(['id_administrador' => $request['id_administrador']]);

                //enviar notificacion
                $mPushNotification = getPush('CENTRAL',"Señor Usuario: Ha sido registrado como Aministrador de su Empresa.",null,"taxi","","","0","0","7");        
                $tokens = array(); 
                $conductor=DB::select("SELECT token  from usuario WHERE  id=".$request['id_administrador']);    
                foreach ($conductor as $key => $con) {
                     array_push($tokens, $con->token); 
                    }    
                  $devicetoken = $tokens;                              
                $sw_notificacion=send($tokens,$mPushNotification);
                //fin de envio de notificacion

        Session::flash('message', 'ADMINISTRADOR MODIFICADO');
         return Redirect::to('/lugar/'.$request['id_empresa'].'/edit');
    }







            public function historial_pedidos_lugar_2(Request $Request )
    {                   
 
        $fecha_inicio=$Request['fecha_inicio'];
        $fecha_fin=$Request['fecha_fin'];
        $id_empresa=$Request['id_empresa'];
        $estado=$Request['estado_opcion'];
        if($estado==1){
            //BUSCAR TODOS LOS PEDIDOS.
        $consulta="SELECT pedido.id, conductor.ci,conductor.expedido,
         CONCAT(conductor.nombre,' ',conductor.paterno,' ',conductor.materno)as conductor,
         vehiculo.placa,vehiculo.marca, CONCAT(usuario.nombre,' ',usuario.apellido) as usuario, vehiculo.codigo_empresa,pedido.tipo_pedido_empresa,pedido.id_empresa_cliente,
         date_format(pedido.fecha_pedido,'%d-%m-%Y %h:%i %p')as fecha_pedido,pedido.direccion,pedido.monto_total,pedido.monto_pedido,pedido.monto_conductor,pedido.latitud,pedido.longitud,
         pedido.detalle_cancelo_usuario,pedido.detalle_cancelo_conductor,pedido.direccion,pedido.clase_vehiculo,pedido.estado,pedido.estado_pago_empresa,
         pedido.calificacion_conductor,pedido.calificacion_vehiculo
           from pedido,vehiculo,conductor,usuario 
         WHERE pedido.id_vehiculo=vehiculo.placa AND pedido.id_conductor=conductor.ci AND usuario.id=pedido.id_usuario  AND pedido.id_lugar=".$id_empresa." AND 
         date(pedido.fecha_pedido) >='".$fecha_inicio."' AND date(pedido.fecha_pedido) <='".$fecha_fin."' order by pedido.id desc";
        }else if($estado==2){
            //BUSCAR TODOS LOS PEDIDOS COMPLETADOS 
            $consulta="SELECT pedido.id, conductor.ci,conductor.expedido,
         CONCAT(conductor.nombre,' ',conductor.paterno,' ',conductor.materno)as conductor,
         vehiculo.placa,vehiculo.marca, CONCAT(usuario.nombre,' ',usuario.apellido) as usuario, vehiculo.codigo_empresa,pedido.tipo_pedido_empresa,pedido.id_empresa_cliente,
         date_format(pedido.fecha_pedido,'%d-%m-%Y %h:%i %p')as fecha_pedido,pedido.direccion,pedido.monto_total,pedido.monto_pedido,pedido.monto_conductor,pedido.latitud,pedido.longitud,
         pedido.detalle_cancelo_usuario,pedido.detalle_cancelo_conductor,pedido.direccion,pedido.clase_vehiculo,pedido.estado,pedido.estado_pago_empresa,
          pedido.calificacion_conductor,pedido.calificacion_vehiculo
            from pedido,vehiculo,conductor,usuario 
         WHERE pedido.estado=2 and pedido.id_vehiculo=vehiculo.placa AND pedido.id_conductor=conductor.ci AND usuario.id=pedido.id_usuario  AND pedido.id_lugar=".$id_empresa." AND 
         date(pedido.fecha_pedido) >='".$fecha_inicio."' AND date(pedido.fecha_pedido) <='".$fecha_fin."' order by pedido.id desc";

        }else if($estado==3){
            //BUSCAR TODOS LOS PEDIDOS CANCELADOS

            $consulta="SELECT pedido.id, conductor.ci,conductor.expedido,
         CONCAT(conductor.nombre,' ',conductor.paterno,' ',conductor.materno)as conductor,
         vehiculo.placa,vehiculo.marca, CONCAT(usuario.nombre,' ',usuario.apellido) as usuario, vehiculo.codigo_empresa,pedido.tipo_pedido_empresa,pedido.id_empresa_cliente,
         date_format(pedido.fecha_pedido,'%d-%m-%Y %h:%i %p')as fecha_pedido,pedido.direccion,pedido.monto_total,pedido.monto_pedido,pedido.monto_conductor,pedido.latitud,pedido.longitud,
         pedido.detalle_cancelo_usuario,pedido.detalle_cancelo_conductor,pedido.direccion,pedido.clase_vehiculo,pedido.estado,pedido.estado_pago_empresa,
          pedido.calificacion_conductor,pedido.calificacion_vehiculo
            from pedido,vehiculo,conductor,usuario 
         WHERE pedido.estado>=5 and pedido.id_vehiculo=vehiculo.placa AND pedido.id_conductor=conductor.ci AND usuario.id=pedido.id_usuario  AND pedido.id_lugar=".$id_empresa." AND 
         date(pedido.fecha_pedido) >='".$fecha_inicio."' AND date(pedido.fecha_pedido) <='".$fecha_fin."' order by pedido.id desc";

        }else if($estado==4){
            //BUSCAR TODOS LOS PEDIDOS CON DEUDA  INCLUIDO LOS CANCELADOS.
            $consulta="SELECT pedido.id, conductor.ci,conductor.expedido,
         CONCAT(conductor.nombre,' ',conductor.paterno,' ',conductor.materno)as conductor,
         vehiculo.placa,vehiculo.marca, CONCAT(usuario.nombre,' ',usuario.apellido) as usuario, vehiculo.codigo_empresa,pedido.tipo_pedido_empresa,pedido.id_empresa_cliente,
         date_format(pedido.fecha_pedido,'%d-%m-%Y %h:%i %p')as fecha_pedido,pedido.direccion,pedido.monto_total,pedido.monto_pedido,pedido.monto_conductor,pedido.latitud,pedido.longitud,
         pedido.detalle_cancelo_usuario,pedido.detalle_cancelo_conductor,pedido.direccion,pedido.clase_vehiculo,pedido.estado,pedido.estado_pago_empresa,
          pedido.calificacion_conductor,pedido.calificacion_vehiculo
            from pedido,vehiculo,conductor,usuario 
         WHERE pedido.estado_pago_empresa=0 and pedido.id_vehiculo=vehiculo.placa AND pedido.id_conductor=conductor.ci AND usuario.id=pedido.id_usuario  AND pedido.id_lugar=".$id_empresa." AND 
         date(pedido.fecha_pedido) >='".$fecha_inicio."' AND date(pedido.fecha_pedido) <='".$fecha_fin."' order by pedido.id desc";
        
        }else if($estado==5){
            //BUSCAR TODOS TODOS LOS PEDIDOS CON DEUDA PERO SIN LOS CANCELADOS
            $consulta="SELECT pedido.id, conductor.ci,conductor.expedido,
         CONCAT(conductor.nombre,' ',conductor.paterno,' ',conductor.materno)as conductor,
         vehiculo.placa,vehiculo.marca, CONCAT(usuario.nombre,' ',usuario.apellido) as usuario, vehiculo.codigo_empresa,pedido.tipo_pedido_empresa,pedido.id_empresa_cliente,
         date_format(pedido.fecha_pedido,'%d-%m-%Y %h:%i %p')as fecha_pedido,pedido.direccion,pedido.monto_total,pedido.monto_pedido,pedido.monto_conductor,pedido.latitud,pedido.longitud,
         pedido.detalle_cancelo_usuario,pedido.detalle_cancelo_conductor,pedido.direccion,pedido.clase_vehiculo,pedido.estado,pedido.estado_pago_empresa,
          pedido.calificacion_conductor,pedido.calificacion_vehiculo
            from pedido,vehiculo,conductor,usuario 
         WHERE  pedido.estado_pago_empresa=0 and pedido.estado=2 and pedido.id_vehiculo=vehiculo.placa AND pedido.id_conductor=conductor.ci AND usuario.id=pedido.id_usuario  AND pedido.id_lugar=".$id_empresa." AND 
         date(pedido.fecha_pedido) >='".$fecha_inicio."' AND date(pedido.fecha_pedido) <='".$fecha_fin."' order by pedido.id desc";

        }else if($estado==6){
            //BUSCA TODOS LOS PEDIDOS PAGADOS
            $consulta="SELECT pedido.id, conductor.ci,conductor.expedido,
         CONCAT(conductor.nombre,' ',conductor.paterno,' ',conductor.materno)as conductor,
         vehiculo.placa,vehiculo.marca, CONCAT(usuario.nombre,' ',usuario.apellido) as usuario, vehiculo.codigo_empresa,pedido.tipo_pedido_empresa,pedido.id_empresa_cliente,
         date_format(pedido.fecha_pedido,'%d-%m-%Y %h:%i %p')as fecha_pedido,pedido.direccion,pedido.monto_total,pedido.monto_pedido,pedido.monto_conductor,pedido.latitud,pedido.longitud,
         pedido.detalle_cancelo_usuario,pedido.detalle_cancelo_conductor,pedido.direccion,pedido.clase_vehiculo,pedido.estado,pedido.estado_pago_empresa,
          pedido.calificacion_conductor,pedido.calificacion_vehiculo
            from pedido,vehiculo,conductor,usuario 
         WHERE pedido.estado_pago_empresa=1 and  pedido.id_vehiculo=vehiculo.placa AND pedido.id_conductor=conductor.ci AND usuario.id=pedido.id_usuario  AND pedido.id_lugar=".$id_empresa." AND 
         date(pedido.fecha_pedido) >='".$fecha_inicio."' AND date(pedido.fecha_pedido) <='".$fecha_fin."' order by pedido.id desc";

        }
        
        
    $pedidos = DB::select($consulta);
    
      $administrador=DB::select("SELECT u.*,e.nombre as 'razon_social',e.id from usuario u, lugar e where e.id_administrador=u.id and e.id='".$id_empresa."'");
     $fechas = DB::select("SELECT date('".$fecha_inicio."') as fecha_inicio, date('".$fecha_fin."') as fecha_fin");   
      //
     

        return view('lugar.historial_pedidos',["fechas"=>$fechas,'pedidos'=>$pedidos,'administrador'=>$administrador,'estado'=>$estado,'otra'=>1]);
    }

    function historial_pedidos_lugar($id_empresa)
    {
    $pedidos = DB::select("SELECT pedido.id, conductor.ci,conductor.expedido,
         CONCAT(conductor.nombre,' ',conductor.paterno,' ',conductor.materno)as conductor,
         vehiculo.placa,vehiculo.marca, CONCAT(usuario.nombre,' ',usuario.apellido) as usuario, vehiculo.codigo_empresa,pedido.tipo_pedido_empresa,pedido.id_empresa_cliente,
         date_format(pedido.fecha_pedido,'%d-%m-%Y %h:%i %p')as fecha_pedido,pedido.direccion,pedido.monto_total,pedido.monto_pedido,pedido.monto_conductor,pedido.latitud,pedido.longitud,
         pedido.detalle_cancelo_usuario,pedido.detalle_cancelo_conductor,pedido.direccion,pedido.clase_vehiculo,pedido.estado,pedido.estado_pago_empresa,
          pedido.calificacion_conductor,pedido.calificacion_vehiculo
            from pedido,vehiculo,conductor,usuario 
         WHERE pedido.id_vehiculo=vehiculo.placa AND pedido.id_conductor=conductor.ci AND usuario.id=pedido.id_usuario  AND pedido.id_lugar=".$id_empresa." AND date(pedido.fecha_pedido) >= date( DATE_SUB(curdate(), INTERVAL + 29 DAY)) AND date(pedido.fecha_pedido) =date(now())  order by pedido.id desc");
      $administrador=DB::select("SELECT u.*,e.nombre as 'razon_social',e.id from usuario u, lugar e where e.id_administrador=u.id and e.id='".$id_empresa."'");
      $fechas = DB::select("SELECT date(DATE_SUB(curdate(), INTERVAL + 29 DAY)) as fecha_inicio, date(now()) as fecha_fin");   
      $estado=1;
      
       return view('lugar.historial_pedidos',["fechas"=>$fechas,'pedidos'=>$pedidos,'administrador'=>$administrador,'estado'=>$estado,'otra'=>0]);
    }
    



   public function get_historial_pedidos_excel($fecha_inicio,$fecha_fin,$estado,$id_empresa){ 
   //DATA
        if($estado==1){
            //BUSCAR TODOS LOS PEDIDOS.
        $consulta="SELECT pedido.id, conductor.ci,conductor.expedido,
         CONCAT(conductor.nombre,' ',conductor.paterno,' ',conductor.materno)as conductor,vehiculo.codigo_empresa,pedido.tipo_pedido_empresa,pedido.id_empresa_cliente,
         vehiculo.placa,vehiculo.marca, CONCAT(usuario.nombre,' ',usuario.apellido) as usuario, 
         date_format(pedido.fecha_pedido,'%d-%m-%Y %h:%i %p')as fecha_pedido,pedido.direccion,pedido.monto_total,pedido.monto_pedido,pedido.monto_conductor,pedido.latitud,pedido.longitud,
         pedido.detalle_cancelo_usuario,pedido.detalle_cancelo_conductor,pedido.direccion,pedido.clase_vehiculo,pedido.estado,pedido.estado_pago_empresa,
          pedido.calificacion_conductor,pedido.calificacion_vehiculo
            from pedido,vehiculo,conductor,usuario 
         WHERE pedido.id_vehiculo=vehiculo.placa AND pedido.id_conductor=conductor.ci AND usuario.id=pedido.id_usuario  AND pedido.id_lugar=".$id_empresa." AND 
         date(pedido.fecha_pedido) >='".$fecha_inicio."' AND date(pedido.fecha_pedido) <='".$fecha_fin."' order by pedido.id asc";
        }else if($estado==2){
            //BUSCAR TODOS LOS PEDIDOS COMPLETADOS 
            $consulta="SELECT pedido.id, conductor.ci,conductor.expedido,
         CONCAT(conductor.nombre,' ',conductor.paterno,' ',conductor.materno)as conductor,
         vehiculo.placa,vehiculo.marca, CONCAT(usuario.nombre,' ',usuario.apellido) as usuario, vehiculo.codigo_empresa,pedido.tipo_pedido_empresa,pedido.id_empresa_cliente,
         date_format(pedido.fecha_pedido,'%d-%m-%Y %h:%i %p')as fecha_pedido,pedido.direccion,pedido.monto_total,pedido.monto_pedido,pedido.monto_conductor,pedido.latitud,pedido.longitud,
         pedido.detalle_cancelo_usuario,pedido.detalle_cancelo_conductor,pedido.direccion,pedido.clase_vehiculo,pedido.estado,pedido.estado_pago_empresa,
          pedido.calificacion_conductor,pedido.calificacion_vehiculo
            from pedido,vehiculo,conductor,usuario 
         WHERE pedido.estado=2 and pedido.id_vehiculo=vehiculo.placa AND pedido.id_conductor=conductor.ci AND usuario.id=pedido.id_usuario  AND pedido.id_lugar=".$id_empresa." AND 
         date(pedido.fecha_pedido) >='".$fecha_inicio."' AND date(pedido.fecha_pedido) <='".$fecha_fin."' order by pedido.id asc";

        }else if($estado==3){
            //BUSCAR TODOS LOS PEDIDOS CANCELADOS

            $consulta="SELECT pedido.id, conductor.ci,conductor.expedido,
         CONCAT(conductor.nombre,' ',conductor.paterno,' ',conductor.materno)as conductor,vehiculo.codigo_empresa,pedido.tipo_pedido_empresa,pedido.id_empresa_cliente,
         vehiculo.placa,vehiculo.marca, CONCAT(usuario.nombre,' ',usuario.apellido) as usuario, 
         date_format(pedido.fecha_pedido,'%d-%m-%Y %h:%i %p')as fecha_pedido,pedido.direccion,pedido.monto_total,pedido.monto_pedido,pedido.monto_conductor,pedido.latitud,pedido.longitud,
         pedido.detalle_cancelo_usuario,pedido.detalle_cancelo_conductor,pedido.direccion,pedido.clase_vehiculo,pedido.estado,pedido.estado_pago_empresa,
          pedido.calificacion_conductor,pedido.calificacion_vehiculo
            from pedido,vehiculo,conductor,usuario 
         WHERE pedido.estado>=5 and pedido.id_vehiculo=vehiculo.placa AND pedido.id_conductor=conductor.ci AND usuario.id=pedido.id_usuario  AND pedido.id_lugar=".$id_empresa." AND 
         date(pedido.fecha_pedido) >='".$fecha_inicio."' AND date(pedido.fecha_pedido) <='".$fecha_fin."' order by pedido.id asc";

        }else if($estado==4){
            //BUSCAR TODOS LOS PEDIDOS CON DEUDA  INCLUIDO LOS CANCELADOS.
            $consulta="SELECT pedido.id, conductor.ci,conductor.expedido,
         CONCAT(conductor.nombre,' ',conductor.paterno,' ',conductor.materno)as conductor,vehiculo.codigo_empresa,pedido.tipo_pedido_empresa,pedido.id_empresa_cliente,
         vehiculo.placa,vehiculo.marca, CONCAT(usuario.nombre,' ',usuario.apellido) as usuario, 
         date_format(pedido.fecha_pedido,'%d-%m-%Y %h:%i %p')as fecha_pedido,pedido.direccion,pedido.monto_total,pedido.monto_pedido,pedido.monto_conductor,pedido.latitud,pedido.longitud,
         pedido.detalle_cancelo_usuario,pedido.detalle_cancelo_conductor,pedido.direccion,pedido.clase_vehiculo,pedido.estado,pedido.estado_pago_empresa,
          pedido.calificacion_conductor,pedido.calificacion_vehiculo
            from pedido,vehiculo,conductor,usuario 
         WHERE pedido.estado_pago_empresa=0 and pedido.id_vehiculo=vehiculo.placa AND pedido.id_conductor=conductor.ci AND usuario.id=pedido.id_usuario  AND pedido.id_lugar=".$id_empresa." AND 
         date(pedido.fecha_pedido) >='".$fecha_inicio."' AND date(pedido.fecha_pedido) <='".$fecha_fin."' order by pedido.id asc";
        
        }else if($estado==5){
            //BUSCAR TODOS TODOS LOS PEDIDOS CON DEUDA PERO SIN LOS CANCELADOS
            $consulta="SELECT pedido.id, conductor.ci,conductor.expedido,
         CONCAT(conductor.nombre,' ',conductor.paterno,' ',conductor.materno)as conductor,vehiculo.codigo_empresa,pedido.tipo_pedido_empresa,pedido.id_empresa_cliente,
         vehiculo.placa,vehiculo.marca, CONCAT(usuario.nombre,' ',usuario.apellido) as usuario, 
         date_format(pedido.fecha_pedido,'%d-%m-%Y %h:%i %p')as fecha_pedido,pedido.direccion,pedido.monto_total,pedido.monto_pedido,pedido.monto_conductor,pedido.latitud,pedido.longitud,
         pedido.detalle_cancelo_usuario,pedido.detalle_cancelo_conductor,pedido.direccion,pedido.clase_vehiculo,pedido.estado,pedido.estado_pago_empresa,
          pedido.calificacion_conductor,pedido.calificacion_vehiculo
            from pedido,vehiculo,conductor,usuario 
         WHERE  pedido.estado_pago_empresa=0 and pedido.estado=2 and pedido.id_vehiculo=vehiculo.placa AND pedido.id_conductor=conductor.ci AND usuario.id=pedido.id_usuario  AND pedido.id_lugar=".$id_empresa." AND 
         date(pedido.fecha_pedido) >='".$fecha_inicio."' AND date(pedido.fecha_pedido) <='".$fecha_fin."' order by pedido.id asc";

        }else if($estado==6){
            //BUSCA TODOS LOS PEDIDOS PAGADOS
            $consulta="SELECT pedido.id, conductor.ci,conductor.expedido,
         CONCAT(conductor.nombre,' ',conductor.paterno,' ',conductor.materno)as conductor,vehiculo.codigo_empresa,pedido.tipo_pedido_empresa,pedido.id_empresa_cliente,
         vehiculo.placa,vehiculo.marca, CONCAT(usuario.nombre,' ',usuario.apellido) as usuario, 
         date_format(pedido.fecha_pedido,'%d-%m-%Y %h:%i %p')as fecha_pedido,pedido.direccion,pedido.monto_total,pedido.monto_pedido,pedido.monto_conductor,pedido.latitud,pedido.longitud,
         date_format(pedido.fecha_pedido,'%d-%m-%Y %h:%i %p')as fecha_pedido,pedido.direccion,pedido.monto_total,pedido.monto_pedido,pedido.monto_conductor,
         pedido.detalle_cancelo_usuario,pedido.detalle_cancelo_conductor,pedido.direccion,pedido.clase_vehiculo,pedido.estado,pedido.estado_pago_empresa,
            pedido.calificacion_conductor,pedido.calificacion_vehiculo
           from pedido,vehiculo,conductor,usuario 
         WHERE pedido.estado_pago_empresa=1 and  pedido.id_vehiculo=vehiculo.placa AND pedido.id_conductor=conductor.ci AND usuario.id=pedido.id_usuario  AND pedido.id_lugar=".$id_empresa." AND 
         date(pedido.fecha_pedido) >='".$fecha_inicio."' AND date(pedido.fecha_pedido) <='".$fecha_fin."' order by pedido.id asc";

        }
        
        
    $pedidos = DB::select($consulta);

     Excel::create('Lista de dueda de empresa',function($excel)use ($pedidos,$fecha_inicio,$fecha_fin){
      $excel->sheet('Servicios', function($sheet)use ($pedidos,$fecha_inicio,$fecha_fin){
      
       
  //HEADER
        $sheet->mergeCells('A1:H1');
        $sheet->mergeCells('A2:H2');
        $sheet->mergeCells('A3:H3');

        $sheet->row(1,['LISTADO']);
        $sheet->row(2,['FECHA DE INICIO: '.$fecha_inicio]);
        $sheet->row(3,['FECHA FIN: '.$fecha_fin]);
        $sheet->row(4,['NRO','FECHA','MOVIL','CONDUCTOR','USUARIO','REFERENCIA','MONTO']);
 
$sumatoria=0;
          foreach($pedidos as $pago){
          $row=[];
          $row[0]=$pago->id;
          $row[1]=$pago->fecha_pedido;
          $row[2]=$pago->codigo_empresa;
          $row[3]=$pago->conductor;
          $row[4]=$pago->usuario;
          $row[5]=$pago->direccion;
          $row[6]=$pago->monto_pedido;
          $sheet->appendRow($row);
          $sumatoria+=$pago->monto_pedido;
        }
        $row=[];
        $row[0]="";
          $row[1]="";
          $row[2]="";
          $row[3]="";
          $row[4]="";
          $row[5]="TOTAL";
          $row[6]=$sumatoria;
          $sheet->appendRow($row);
             
              });
             })->export('xls');
    }



}
