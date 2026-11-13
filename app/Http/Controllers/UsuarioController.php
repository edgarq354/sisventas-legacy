<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\NotificacionRequest;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use App\Notificacion;
use App\Conductor;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use Exception;
use Illuminate\Support\Facades\Validator;


class UsuarioController extends Controller
{
    
    public function __construct() {
         $this->middleware('auth');
    }

  function index(){
        if(Auth::user()->privilegio == 0||Auth::user()->privilegio == 3){
            $buscar_usuario=DB::select("SELECT *FROM usuario order by nombre");
            $usuario=DB::table('usuario')->select('*')->orderby('nombre')->get();
            return view('usuario.index',compact('usuario',$usuario,'buscar_usuario',$buscar_usuario));                        
        } else {
            return view('errors.404');                                                
        }
  }

    function edit($id_usuario)
    {
      $usuario = DB::select("SELECT * FROM usuario WHERE id='".$id_usuario."' ");
     
       return view('usuario.edit',['usuario'=>$usuario]);
    }
  
   //ENVIAR NOTIFICACION A UN SOLO MOTISTA
    function notificacion_pasajero(Request $request){  

                $mPushNotification = getPush('Notificación',$request['detalle'],null,"usuario","","","0","0","7");  
                 $tokens = array(); 
                 array_push($tokens,$request['token_not']);        
                $sw_notificacion=send($tokens,$mPushNotification);


             if($sw_notificacion===FALSE)
             {
                Session::flash('message-error','NO SE ENVIO LA NOTIFICAION  error:'.$sw_notificacion." token: ".$request['token_not']." mensaje =".$request['detalle']);  
             }
             else
             {
              Session::flash('message','ENVIADO CORRECTAMENTE' );
             }
      

                return Redirect::to('/pasajero');            
    }

       //CARGAR PARA VERIFICAR SI EXISTE EL NUMERO DE CELULAR
    function verificar_numero_celular_pasajero($celular){
        $usuario=DB::select("SELECT * from usuario where celular=".$celular);
        $pedido=DB::select("SELECT * FROM pedido p, usuario u where p.id_usuario=u.id and u.celular='".$celular."' GROUP BY p.direccion_inicio  ORDER BY p.id DESC limit 10");
        $row = array('usuario' => $usuario,'pedido'=>$pedido );  
        return response($row);
    }




    function registrar_usuario_pedido(Request $request)
    {
        $mensaje="Ninguno";
        $nombre=$request['nombre'];
        $apellido=$request['apellidos'];
        $celular=$request['celular'];
        $correo=$request['correo'];
        $indicacion=$request['indicacion'];
        $latitud=$request['latitud'];
        $longitud=$request['longitud'];
        $clase_vehiculo=$request['clase_vehiculo'];
        $id_lugar=$request['id_lugar'];
        $monto_pedido=$request['monto_pedido'];
        $monto_envio=$request['monto_envio'];
        $que_necesitas=$request['que_necesitas'];
        $nombre_lugar=$request['nombre_lugar'];
        $direccion_lugar=$request['direccion_lugar'];
        $latitud_lugar=$request['latitud_lugar'];
        $longitud_lugar=$request['longitud_lugar'];
          /*
  $direccion=$dato['direccion'];
  $carrito=$dato['carrito'];
  $id_empresa=$dato['id_empresa'];
  $monto_envio=$dato['monto_envio'];
*/
        $usuario=DB::select("SELECT count(*) as 'cantidad',id from usuario where celular='".$celular."'");

        $cantidad_u=(int)$usuario[0]->cantidad;
        $id_usuario="";
        $sw=false;
        $total=0;

        

        
        $sw_numero=is_numeric($celular);

         $lugar=DB::select("SELECT id from lugar where latitud='".$latitud_lugar."' and longitud='".$longitud_lugar."' limit 1");

         foreach ($lugar as $key => $value) {
           $id_lugar=$value->id;
         }
         if(!is_numeric($id_lugar)){

          $id_lugar=DB::table('lugar')
                  ->insertGetId([
                    'nombre'=>$nombre_lugar,
                    'direccion'=>$direccion_lugar,
                    'latitud'=>$latitud_lugar,
                    'longitud'=>$longitud_lugar                    
                  ]);

         }



        //Verificamos si cumple con todos los requisitos de un celular..
        if (strlen($celular)>=8 && $sw_numero==true)
        {
 

          if($cantidad_u>0){
              $id_usuario=$usuario[0]->id;
          }else
          {
              //REGISTRO EL CONDUCTOR
              $id_usuario=DB::table('usuario')->insertGetId([ 'nombre' => $nombre, 'apellido' => $apellido,'celular'=>$celular,'correo'=>$correo]); 
          }

          if(is_numeric($id_usuario)==true){

          $pedido=DB::select("SELECT count(*) as 'cantidad', id from pedido where  id_usuario='".$id_usuario."' and id_conductor is not null and estado<=1 and tipo_reserva=0 limit 1");

          $pedido_solicitador=DB::select("SELECT count(*) as 'cantidad',id from pedido where  TIMESTAMPDIFF(MINUTE,pedido.fecha_pedido,now()) < 5 and tipo_reserva_auxiliar=0 and tipo_pedido_auxiliar=0 and id_usuario='".$id_usuario."'  and id_conductor is null and id_vehiculo is null and estado=0 limit 1"); //verificacmos si tiene alguna solicitud de Taxi que no halla sido aceptado.

              if((int)$pedido_solicitador[0]->cantidad==0)
              {
                 if((int)$pedido[0]->cantidad==0)
                 {
                  $mensaje="SE REGISTRO LA SOLICITUD CORRECTAMENTE";
                  //No tiene pedido. y se va a registrar una nueva solicitud.
                  $id_pedido_reg=DB::table('pedido')
                  ->insertGetId([
                    'id_usuario'=>$id_usuario,
                    'latitud'=>$latitud,
                    'longitud'=>$longitud,
                    'direccion'=>$indicacion,
                    'estado'=>'0',
                    'numero_casa'=>'0',
                    'imei'=>'000000000000000',
                    'clase_vehiculo'=>$clase_vehiculo,
                    'tipo_pedido_empresa'=>'0',
                    'direccion_inicio'=>'',
                    'monto_pedido'=>$monto_pedido,
                    'monto_total'=>$monto_envio,
                    'localidad'=>'MONTERO',
                    'notificacion_pedido_finalizado'=>1,
                    'id_lugar'=>$id_lugar,
                    'que_necesitas'=>$que_necesitas
                  ]);
/*
                  $consulta="INSERT into pedido (
      id_usuario,
      latitud,
      longitud,
      direccion,
      estado,
      numero_casa,
      imei,
      clase_vehiculo,
      tipo_pedido_empresa,
      direccion_inicio,
      id_lugar) 
      values(?,?,?,?,0,?,?,?,?,?,?)";
*/

                 $sw=true;
                 }else{
                  $mensaje="Ya tiene un servicio en camino";
                 }

              }else{
                if((int)$pedido[0]->cantidad==0 && is_numeric($pedido_solicitador[0]->id)==true)
                 {
                  $mensaje="SE VOLVIO A REGISTRAR LA SOLICITUD";

                  //No tiene pedido. y se va a registrar una nueva solicitud.
                  $id_pedido_reg=DB::table('pedido')
                  ->where('id','=',$pedido_solicitador[0]->id)
                  ->update([ 
                    'latitud'=>$latitud,
                    'longitud'=>$longitud,
                    'fecha_pedido'=>DB::raw('NOW()'),
                    'direccion'=>$indicacion,
                    'estado'=>'0',
                    'numero_casa'=>'0',
                    'imei'=>'000000000000000',
                    'clase_vehiculo'=>$clase_vehiculo,
                    'tipo_pedido_empresa'=>'0',
                    'direccion_inicio'=>'',
                    'monto_pedido'=>$monto_pedido,
                    'monto_total'=>$monto_envio,
                    'localidad'=>'MONTERO',
                    'notificacion_pedido_finalizado'=>1,
                    'id_lugar'=>$id_lugar,
                    'que_necesitas'=>$que_necesitas
                  ]);

                  /*
     $consulta="UPDATE pedido 
      set id_usuario=?,
      latitud=?,
      longitud=?,
      direccion=?,
      direccion_inicio=?,
      fecha_pedido=now(),
       estado=0,
       imei=?,
       clase_vehiculo=?,
       tipo_pedido_empresa=?,
       id_lugar=?
       where id=?";
                  */
                  $sw=true;
                 }else{
                  $mensaje="Ya tiene un servicio en camino";
                 }  
              }

        //una ves registrado la solicitud se lo enviara la notificacion a todos los conductores....

        if($sw==true)
        {
          $diametro=6000;
          switch ($clase_vehiculo) {
            case 1:
                //CUALQUIER MOVIL
                    $consulta="SELECT token,
                    distancia_entre_dos_puntos(".$latitud.",".$longitud.",c.latitud_asignacion,c.longitud_asignacion) as distancia 
                    FROM conductor c,vehiculo v where c.id_vehiculo=v.placa and c.estado=1 and c.login=1 and v.movil=1 and v.moto=0
                    and distancia_entre_dos_puntos(".$latitud.",".$longitud.",c.latitud_asignacion,c.longitud_asignacion)<=  ".$diametro." 
                    and c.ci not in (select id_conductor from pedido where estado<=1 and id_conductor is not null)  
                    order by distancia asc ";
                    break;
              case 2:
                //MOVILES DE LUJO
                    $consulta="SELECT token,distancia_entre_dos_puntos(".$latitud.",".$longitud.",c.latitud_asignacion,c.longitud_asignacion) as distancia 
                    FROM conductor c,vehiculo v where c.id_vehiculo=v.placa and c.estado=1 and c.login=1 and v.lujo=1 and moto=0
                    and distancia_entre_dos_puntos(".$latitud.",".$longitud.",c.latitud_asignacion,c.longitud_asignacion)<=  ".$diametro." 
                    and c.ci not in (select id_conductor from pedido where estado<=1 and id_conductor is not null)  
                    order by distancia asc ";
                    break;
              case 3:
                //MOVILES CON AIRE ACONDICIONADO
                    $consulta="SELECT token,distancia_entre_dos_puntos(".$latitud.",".$longitud.",c.latitud_asignacion,c.longitud_asignacion) as distancia 
                    FROM conductor c,vehiculo v where c.id_vehiculo=v.placa and c.estado=1 and c.login=1 and v.aire=1 and moto=0
                    and distancia_entre_dos_puntos(".$latitud.",".$longitud.",c.latitud_asignacion,c.longitud_asignacion)<=  ".$diametro." 
                    and c.ci not in (select id_conductor from pedido where estado<=1 and id_conductor is not null)  
                    order by distancia asc ";
                    break;
              case 4:
                //MOVILES CON MALETERO
                    $consulta="SELECT token,distancia_entre_dos_puntos(".$latitud.",".$longitud.",c.latitud_asignacion,c.longitud_asignacion) as distancia 
                    FROM conductor c,vehiculo v where c.id_vehiculo=v.placa and c.estado=1 and c.login=1 and v.maletero_libre=1 and moto=0
                    and distancia_entre_dos_puntos(".$latitud.",".$longitud.",c.latitud_asignacion,c.longitud_asignacion)<=  ".$diametro." 
                    and c.ci not in (select id_conductor from pedido where estado<=1 and id_conductor is not null)  
                    order by distancia asc ";
                    break;
              case 5:
                //CUALQUIER MOVIL 'PEDIDO DE ENCOMIENDA'.
                   
                    $consulta="SELECT token,distancia_entre_dos_puntos(".$latitud.",".$longitud.",c.latitud_asignacion,c.longitud_asignacion) as distancia 
                      FROM conductor c,vehiculo v where c.id_vehiculo=v.placa and c.estado=1 and c.login=1 
                      and distancia_entre_dos_puntos(".$latitud.",".$longitud.",c.latitud_asignacion,c.longitud_asignacion)<= ".$diametro."  
                      and c.ci not in (select id_conductor from pedido where estado<=1 and id_conductor is not null)  
                      order by distancia asc ";
                    break;  
                case 6:
                //CUALQUIER MOVIL 'RESERVAR UN MOVIL PARA OTRA FECHA.
                    $consulta="SELECT token,distancia_entre_dos_puntos(".$latitud.",".$longitud.",c.latitud_asignacion,c.longitud_asignacion) as distancia 
                    FROM conductor c,vehiculo v where c.id_vehiculo=v.placa and c.estado=1 and c.login=1 and v.movil=1 and moto=0
                    and distancia_entre_dos_puntos(".$latitud.",".$longitud.",c.latitud_asignacion,c.longitud_asignacion)<=  ".$diametro." 
                    and c.ci not in (select id_conductor from pedido where estado<=1 and id_conductor is not null)  
                    order by distancia asc ";
                    break;  
                case 7:
                //CUALQUIER MOTO
                    $consulta="SELECT token,distancia_entre_dos_puntos(".$latitud.",".$longitud.",c.latitud_asignacion,c.longitud_asignacion) as distancia 
                    FROM conductor c,vehiculo v where c.id_vehiculo=v.placa and c.estado=1 and c.login=1 and v.movil=1 and moto=1
                    and distancia_entre_dos_puntos(".$latitud.",".$longitud.",c.latitud_asignacion,c.longitud_asignacion)<=  ".$diametro." 
                    and c.ci not in (select id_conductor from pedido where estado<=1 and id_conductor is not null)  
                    order by distancia asc ";
                    break;  
                 case 8:
                //CUALQUIER MOTO
                    $consulta="SELECT token,distancia_entre_dos_puntos(".$latitud.",".$longitud.",c.latitud_asignacion,c.longitud_asignacion) as distancia 
                    FROM conductor c,vehiculo v where c.id_vehiculo=v.placa and c.estado=1 and c.login=1 and v.movil=1 and moto=1
                    and distancia_entre_dos_puntos(".$latitud.",".$longitud.",c.latitud_asignacion,c.longitud_asignacion)<= ".$diametro."  
                    and c.ci not in (select id_conductor from pedido where estado<=1 and id_conductor is not null)  
                    order by distancia asc ";
                    break;                          
            default:
              # code...
              break;
          }


        

        
        
           
             $tokens = array(); 
             $row=DB::select($consulta);
         
           foreach ($row as $key => $value) {
              array_push($tokens, $value->token);  
              $total+=1;
            }
       
   
    






        $p='Pedido de Delivery';
            if($clase_vehiculo>=7 && $clase_vehiculo<=8){
                $p='Pedido de Delivery';
            }
           
           $mPushNotification = getPush_pedido(
            'Pedido',
            $p,
            null,
            "taxi",
            $id_pedido_reg,
            $nombre,
            $latitud,
            $longitud,
            "2",
            $indicacion,
            
            $clase_vehiculo,
            "0");
         // obteniendo el empuje del objeto push
            $sw_notificacion=send($tokens,$mPushNotification);


             if($sw_notificacion===FALSE)
             {
                //envio la notificacion
             }

        }
      }


          return view("mensajes.msj_rechazado")->with("msj",$mensaje." b:".$total);
      }else{
         return view("mensajes.msj_rechazado")->with("msj",$mensaje." F:".$total);
      }
                    
    }



  //CODIGO PARA AJAX  REGISTRAR UN NUEVO USUARIO

    function asignar_usuario_pedido(Request $request){
        $mensaje="No se pudo realizar la asignación.";
        $id_conductor=$request['id_conductor'];
        $id_pedido=$request['id_pedido'];
        $id_vehiculo=$request['id_vehiculo'];
        $aceptado=false;

        $pedido=DB::select("SELECT count(*) as 'cantidad',id_vehiculo,id_conductor from pedido where id=".$id_pedido." and id_vehiculo='".$id_vehiculo."' and id_conductor='".$id_conductor."' and tipo_reserva=0");
        if($pedido[0]->cantidad==0)
        {
            try{
            DB::beginTransaction();

             DB::table("pedido")
             ->whereRaw('id_vehiculo is NULL AND id_conductor is NULL and id='.$id_pedido)
             ->update(['id_vehiculo'=>$id_vehiculo,'id_conductor'=>$id_conductor,'estado'=>0,'fecha_proceso'=>DB::raw('now()')]);

           /*   "UPDATE pedido p,conductor c,vehiculo v set p.id_vehiculo=".$id_vehiculo.",p.id_conductor=".$id_conductor.", p.estado=0,p.fecha_proceso=now()
                 where p.id=".$id_pedido." and TIMESTAMPDIFF(MINUTE,p.fecha_pedido,now())<=1 and p.estado=0 and c.id_vehiculo=v.placa
                and c.credito>0 and c.estado=1 and c.bloqueo=0 and p.id_vehiculo is null and p.id_conductor is null";
             */
                  $aceptado=true;
 
             DB::commit(); 
          } catch (Exception $e) {
            DB::rollback();
            $aceptado=false;
            $mensaje="La solicitud ya no esta disponible";
              }
        }
      //si no hubo ningun problema al actualizar entonces verificamos si el id_taxi esta en el pedido
            if($aceptado==true)
            {
                $pedido_ver=DB::select("SELECT count(*) as 'cantidad',id_vehiculo,id_conductor from pedido where id=".$id_pedido );
                if($pedido_ver[0]->cantidad>0)
                {
                    if($pedido_ver[0]->id_vehiculo==$id_vehiculo && $pedido_ver[0]->id_conductor==$id_conductor)
                    {
                     DB::table("conductor")
                     ->where('ci',$id_conductor)
                     ->update(['estado'=>2]);

                       $consulta_conductor=DB::select("SELECT c.token as 'token_conductor',c.numero_movil,u.token as 'token_usuario' from conductor c, usuario u, pedido p where p.id_conductor=c.ci and p.id_usuario=u.id and p.id=".$id_pedido);
                       $consulta_pedido=DB::select("SELECT concat(c.nombre,' ',c.paterno) as 'nombre_taxi',c.celular,c.ci as 'id_taxi',v.marca,v.placa,c.numero_movil,
                        p.id as 'id_pedido',u.id as 'id_usuario',v.color,p.latitud,p.longitud,p.estado,p.abordo,
                        c.calificacion as 'calificacion_conductor',v.calificacion as'calificacion_vehiculo',
                        e.razon_social as 'empresa',e.id as 'id_empresa' from pedido p,conductor c,vehiculo v,usuario u,empresa e 
                        where v.placa=p.id_vehiculo and c.ci=p.id_conductor and p.id_usuario=u.id and c.id_empresa=e.id  
                        and c.id_vehiculo=v.placa and p.id=".$id_pedido);

                   

                         $token_usuario = array(); 
                         $token_conductor = array(); 
                          array_push($token_usuario,$consulta_conductor[0]->token_usuario);
                          array_push($token_conductor,$consulta_conductor[0]->token_conductor);

                          // obtener el token del objeto de base de datos
                             $mPushNotification_cond= getPush_pedido('Pedido de Sistema','Su Movil esta en camino.',null,"usuario",$id_pedido,"","0","0","6","0","0","0");
                             $mPushNotification_usu = getPush_pedido_usuario('Pedido de Sistema','Su Movil esta en camino.',null,"usuario",$id_pedido,"","0","0","1","0","0","0",array($consulta_pedido));
                         // obteniendo el empuje del objeto push
                            $sw_notificacion=send($token_usuario,$mPushNotification_usu);
                            $sw_notificacion_cond=send($token_conductor,$mPushNotification_cond);
                            $mensaje="Solicitud asignada con el conductor :".$consulta_conductor[0]->numero_movil;
                      }else
                      {
                        $mensaje="Ha sido aceptado por otro Movil";
                      }

                  }else{
                    $mensaje="El pedido ya no esta disponible";  
                  }

              }else
              {
                $mensaje="La solicitud no se pudo asignar el Movil";
              }

       return view("mensajes.msj_rechazado")->with("msj",$mensaje);
      }

 

   




    public function historial_pedidos_2(Request $Request )
    {                   
 
        $fecha_inicio=$Request['fecha_inicio'];
        $fecha_fin=$Request['fecha_fin'];
        $id_usuario=$Request['id_usuario'];
        $estado=$Request['estado_opcion'];
        if($estado==1){
            //BUSCAR TODOS LOS PEDIDOS.
        $consulta="SELECT pedido.id, conductor.ci,conductor.expedido,
         CONCAT(conductor.nombre,' ',conductor.paterno,' ',conductor.materno)as conductor,pedido.latitud,pedido.longitud, 
         vehiculo.placa,vehiculo.marca, CONCAT(usuario.nombre,' ',usuario.apellido) as usuario, vehiculo.codigo_empresa,pedido.id_empresa_cliente,pedido.tipo_pedido_empresa,
         date_format(pedido.fecha_pedido,'%d-%m-%Y %h:%i %p')as fecha_pedido,pedido.direccion,pedido.monto_total,pedido.monto_empresa,pedido.monto_conductor,
         pedido.detalle_cancelo_usuario,pedido.detalle_cancelo_conductor,pedido.direccion,pedido.clase_vehiculo,pedido.estado,pedido.estado_pago_empresa,
         pedido.calificacion_conductor,pedido.calificacion_vehiculo
           from pedido,vehiculo,conductor,usuario 
         WHERE pedido.id_vehiculo=vehiculo.placa AND pedido.id_conductor=conductor.ci AND usuario.id=pedido.id_usuario  AND pedido.id_usuario=".$id_usuario." AND 
         date(pedido.fecha_pedido) >='".$fecha_inicio."' AND date(pedido.fecha_pedido) <='".$fecha_fin."' order by pedido.id desc";
        }else if($estado==2){
            //BUSCAR TODOS LOS PEDIDOS COMPLETADOS 
            $consulta="SELECT pedido.id, conductor.ci,conductor.expedido,
         CONCAT(conductor.nombre,' ',conductor.paterno,' ',conductor.materno)as conductor,pedido.latitud,pedido.longitud, 
         vehiculo.placa,vehiculo.marca, CONCAT(usuario.nombre,' ',usuario.apellido) as usuario, vehiculo.codigo_empresa,pedido.id_empresa_cliente,pedido.tipo_pedido_empresa,
         date_format(pedido.fecha_pedido,'%d-%m-%Y %h:%i %p')as fecha_pedido,pedido.direccion,pedido.monto_total,pedido.monto_empresa,pedido.monto_conductor,
         pedido.detalle_cancelo_usuario,pedido.detalle_cancelo_conductor,pedido.direccion,pedido.clase_vehiculo,pedido.estado,pedido.estado_pago_empresa,
         pedido.calificacion_conductor,pedido.calificacion_vehiculo
           from pedido,vehiculo,conductor,usuario 
         WHERE pedido.estado=2 and pedido.id_vehiculo=vehiculo.placa AND pedido.id_conductor=conductor.ci AND usuario.id=pedido.id_usuario  AND pedido.id_usuario='".$id_usuario."' AND 
         date(pedido.fecha_pedido) >='".$fecha_inicio."' AND date(pedido.fecha_pedido) <='".$fecha_fin."' order by pedido.id desc";

        }else if($estado==3){
            //BUSCAR TODOS LOS PEDIDOS CANCELADOS
            $consulta="SELECT pedido.id, conductor.ci,conductor.expedido,
         CONCAT(conductor.nombre,' ',conductor.paterno,' ',conductor.materno)as conductor,pedido.latitud,pedido.longitud, 
         vehiculo.placa,vehiculo.marca, CONCAT(usuario.nombre,' ',usuario.apellido) as usuario, vehiculo.codigo_empresa,pedido.id_empresa_cliente,pedido.tipo_pedido_empresa,
         date_format(pedido.fecha_pedido,'%d-%m-%Y %h:%i %p')as fecha_pedido,pedido.direccion,pedido.monto_total,pedido.monto_empresa,pedido.monto_conductor,
         pedido.detalle_cancelo_usuario,pedido.detalle_cancelo_conductor,pedido.direccion,pedido.clase_vehiculo,pedido.estado,pedido.estado_pago_empresa,
         pedido.calificacion_conductor,pedido.calificacion_vehiculo
           from pedido,vehiculo,conductor,usuario 
         WHERE pedido.estado>=4 and pedido.id_vehiculo=vehiculo.placa AND pedido.id_conductor=conductor.ci AND usuario.id=pedido.id_usuario  AND pedido.id_usuario=".$id_usuario." AND 
         date(pedido.fecha_pedido) >='".$fecha_inicio."' AND date(pedido.fecha_pedido) <='".$fecha_fin."' order by pedido.id desc";
        }else{
             $pedidos = DB::select("SELECT pedido.id, conductor.ci,conductor.expedido,pedido.latitud,pedido.longitud, 
         CONCAT(conductor.nombre,' ',conductor.paterno,' ',conductor.materno)as conductor,
         vehiculo.placa,vehiculo.marca, CONCAT(usuario.nombre,' ',usuario.apellido) as usuario, vehiculo.codigo_empresa,pedido.id_empresa_cliente,
         date_format(pedido.fecha_pedido,'%d-%m-%Y %h:%i %p')as fecha_pedido,pedido.direccion,pedido.monto_total,pedido.monto_empresa,pedido.monto_conductor,
         pedido.detalle_cancelo_usuario,pedido.detalle_cancelo_conductor,pedido.direccion,pedido.clase_vehiculo,pedido.estado,pedido.estado_pago_empresa,
         pedido.calificacion_conductor,pedido.calificacion_vehiculo
           from pedido,vehiculo,conductor,usuario 
         WHERE pedido.id_vehiculo=vehiculo.placa AND pedido.id_conductor=conductor.ci AND usuario.id=pedido.id_usuario  AND pedido.id_usuario=".$id_usuario." AND date(pedido.fecha_pedido) >= date( DATE_SUB(curdate(), INTERVAL + 29 DAY)) AND date(pedido.fecha_pedido) <=date(now())  order by pedido.id desc");
        } 
        
        
    $pedidos = DB::select($consulta);
    
     $fechas = DB::select("SELECT date('".$fecha_inicio."') as fecha_inicio, date('".$fecha_fin."') as fecha_fin");   
      //
     

        return view('usuario.historial_servicio',["fechas"=>$fechas,'pedidos'=>$pedidos,'estado'=>$estado,'otra'=>1,'id_usuario'=>$id_usuario]);
    }

    function historial_pedidos($id_usuario)
    {
    $pedidos = DB::select("SELECT pedido.id, conductor.ci,conductor.expedido,pedido.latitud,pedido.longitud, 
         CONCAT(conductor.nombre,' ',conductor.paterno,' ',conductor.materno)as conductor,
         vehiculo.placa,vehiculo.marca, CONCAT(usuario.nombre,' ',usuario.apellido) as usuario, vehiculo.codigo_empresa,pedido.id_empresa_cliente,pedido.tipo_pedido_empresa,
         date_format(pedido.fecha_pedido,'%d-%m-%Y %h:%i %p')as fecha_pedido,pedido.direccion,pedido.monto_total,pedido.monto_empresa,pedido.monto_conductor,
         pedido.detalle_cancelo_usuario,pedido.detalle_cancelo_conductor,pedido.direccion,pedido.clase_vehiculo,pedido.estado,pedido.estado_pago_empresa,
         pedido.calificacion_conductor,pedido.calificacion_vehiculo
           from pedido,vehiculo,conductor,usuario 
         WHERE pedido.id_vehiculo=vehiculo.placa AND pedido.id_conductor=conductor.ci AND usuario.id=pedido.id_usuario  AND pedido.id_usuario=".$id_usuario." AND date(pedido.fecha_pedido) >= date( DATE_SUB(curdate(), INTERVAL + 29 DAY)) AND date(pedido.fecha_pedido) <=date(now())  order by pedido.id desc");
      $fechas = DB::select("SELECT date(DATE_SUB(curdate(), INTERVAL + 29 DAY)) as fecha_inicio, date(now()) as fecha_fin");   
      $estado=1;
      
       return view('usuario.historial_servicio',["fechas"=>$fechas,'pedidos'=>$pedidos,'estado'=>$estado,'otra'=>0,'id_usuario'=>$id_usuario]);
    }

   public function historial_bloqueo_pasajero($id_pasajero){
    $historial=DB::select("SELECT h.*,u.nombre as 'usuario' FROM historial_baja_alta h, users u where  u.id=h.id_login and h.id_pasajero='".$id_pasajero."'");
    return View('usuario.historial_bloqueo',['historial'=>$historial]);
   }

    public function cargar_estado_bloqueo(Request $Request )
    {                   
 
        $id_pasajero=$Request['id_usuario'];
        $mensaje=$Request['descripcion_usu']; 
        $estado=0;
 
        try {
          
           
            if($Request['estado_edit']){
                $estado=1;
             } 
      
            DB::beginTransaction();
             $id_pago_ingreso=DB::table('historial_baja_alta')->insertGetId([
                'id_pasajero'=>$id_pasajero,
                'descripcion'=>$mensaje,
                'tipo'=>$estado, 
                'id_login'=>Auth::user()->id,
                ]);     

               DB::table('usuario')
                ->where('id',$id_pasajero)
                ->update([
                'estado'=>$estado,
                'descripcion_estado'=>$mensaje,
                ]);  

             DB::commit(); 

             return redirect('/pasajero')->with("message","SE ACTUALIZO CORRECTAMENTE."); 

        } catch (Exception $e) {
          DB::rollback();
          return redirect('/pasajero')->with("message-error","ERROR INTENTE NUEVAMENTE.".$e);      
        }
   
   
    }

     public function actualizar_usuario_contrasenia(Request $request){ 
            try{
                DB::table('usuario')
                ->where('id', $request['id_administrador'])
                ->update(['codigo'=>$request['codigo'],
                  'contrasenia'=>$request['contrasenia']]);
                Session::flash('message','SE ACTUALIZO LA CONTRASEÑA');
                }
                catch(Exception $e)
                {
                   Session::flash('message-error','NO SE PUEDO ACTUALIZAR');
                }
                
             return Redirect::to('/pasajero');  
       }
    


     public function usuarios_completo(){   
        $usuario=DB::select("SELECT *,(SELECT COUNT(c.id_usuario) 
          from chat c WHERE  c.id_usuario=usuario.id GROUP BY c.id_usuario) as cantidad 
          from usuario WHERE cantidad>0 ORDER BY cantidad DESC ");   
         
        $row = array('usuario'=>$usuario);       
        return response($row);
    }

    public function chat_completo_conductor($id_usuario,$id_conductor){   
        $chat=DB::select("SELECT * from chat c where c.id_usuario=".$id_usuario." 
            AND c.id_conductor=".$id_conductor);   
         
        $row = array('chat'=>$chat);       
        return response($row);
    }

       public function enviar_mensaje(Request $Request ){   
           echo "ingreso";
        // TODO: se aumento $id_ conductor, $id_usuario
        $id_conductor=$Request["id_conductor"];
        $id_usuario=$Request["id_usuario"];

        $id_pasajero=$Request["id_pasajero"];
        $titulo=$Request["titulo"];
        $mensaje=$Request["mensaje"];
        $remitente=$Request["remitente"];
        $id_administrador=$Request["id_administrador"];
             
             try {
           
            DB::beginTransaction();
             $sw_chat=DB::table('chat')->insertGetId([
                'id_usuario'=>$id_pasajero,
                'id_administrador'=>$id_administrador,
                'yo'=>$remitente,
                'mensaje'=>$mensaje,
                'titulo'=>$titulo
                ]);     
             DB::commit(); 

        } catch (Exception $e) {
          DB::rollback();
        }


        $chat=DB::select("SELECT * from chat c where c.id_usuario=".$id_usuario." 
            AND c.id_conductor=".$id_conductor);   
         
        $row = array('chat'=>$chat);       
        return response($row);
    }



     public function chat_completo($id_usuario,$id_administrador){   
        $chat=DB::select("SELECT * from chat c where c.id_usuario=".$id_usuario." 
            AND c.id_administrador=".$id_administrador);   
         
        $row = array('chat'=>$chat);       
        return response($row);
    }


}
