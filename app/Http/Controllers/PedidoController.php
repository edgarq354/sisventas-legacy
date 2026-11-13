<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;

class PedidoController extends Controller
{
	 public function __construct() {
         $this->middleware('auth');
    }
    public function index(Request $Request){

        if($Request->isMethod('GET') && $Request['fecha_inicio']!=''){
            if($Request['filtro']==0){
                //TODOS
            $pedido=DB::select("SELECT p.id,p.id_vehiculo,p.id_conductor,p.calificacion_conductor,p.calificacion_vehiculo,p.direccion,p.latitud,p.longitud,p.tipo_reserva_auxiliar,
            p.panico,p.distancia,p.abordo,p.compartido, p.fecha_pedido,p.estado,p.clase_vehiculo,p.tipo_pedido_empresa,p.id_empresa_cliente, p.monto_total,v.codigo_empresa,c.nombre,
            c.paterno,c.materno,c.celular as 'celular_conductor',concat(u.nombre,' ',u.apellido)as 'pasajero',p.fecha_reserva,
            u.celular as 'celular_pasajero'  from pedido p, conductor c, usuario u,vehiculo v  where u.id=p.id_usuario  
            and  c.ci=p.id_conductor  and v.placa=p.id_vehiculo  and date(p.fecha_pedido)>='".$Request['fecha_inicio']."' and date(p.fecha_pedido)<='".$Request['fecha_fin']."' and   c.id_empresa='".Auth::user()->id_empresa."'  order by p.id desc  " );

            }else if($Request['filtro']==1){
                //COMPLETADOS
                  $pedido=DB::select("SELECT p.id,p.id_vehiculo,p.id_conductor,p.calificacion_conductor,p.calificacion_vehiculo,p.direccion,p.latitud,p.longitud,p.tipo_reserva_auxiliar,
            p.panico,p.distancia,p.abordo,p.compartido, p.fecha_pedido,p.estado,p.clase_vehiculo,p.tipo_pedido_empresa,p.id_empresa_cliente, p.monto_total,v.codigo_empresa,c.nombre,
            c.paterno,c.materno,c.celular as 'celular_conductor',concat(u.nombre,' ',u.apellido)as 'pasajero',p.fecha_reserva,
            u.celular as 'celular_pasajero'  from pedido p, conductor c, usuario u,vehiculo v  where u.id=p.id_usuario  
            and  c.ci=p.id_conductor  and v.placa=p.id_vehiculo and p.estado=2 and date(p.fecha_pedido)>='".$Request['fecha_inicio']."' and date(p.fecha_pedido)<='".$Request['fecha_fin']."' and   c.id_empresa='".Auth::user()->id_empresa."'  order by p.id desc  " );

            }else if($Request['filtro']==2){
                //cancelados
                  $pedido=DB::select("SELECT p.id,p.id_vehiculo,p.id_conductor,p.calificacion_conductor,p.calificacion_vehiculo,p.direccion,p.latitud,p.longitud,p.tipo_reserva_auxiliar,
            p.panico,p.distancia,p.abordo,p.compartido, p.fecha_pedido,p.estado,p.clase_vehiculo,p.tipo_pedido_empresa,p.id_empresa_cliente, p.monto_total,v.codigo_empresa,c.nombre,
            c.paterno,c.materno,c.celular as 'celular_conductor',concat(u.nombre,' ',u.apellido)as 'pasajero',p.fecha_reserva,
            u.celular as 'celular_pasajero'  from pedido p, conductor c, usuario u,vehiculo v  where u.id=p.id_usuario  
            and  c.ci=p.id_conductor  and v.placa=p.id_vehiculo and p.estado>=4 and date(p.fecha_pedido)>='".$Request['fecha_inicio']."' and date(p.fecha_pedido)<='".$Request['fecha_fin']."' and   c.id_empresa='".Auth::user()->id_empresa."'  order by p.id desc " );

            }else if($Request['filtro']==3){
                //TODOS UN MOVIL
            $pedido=DB::select("SELECT p.id,p.id_vehiculo,p.id_conductor,p.calificacion_conductor,p.calificacion_vehiculo,p.direccion,p.latitud,p.longitud,p.tipo_reserva_auxiliar,
            p.panico,p.distancia,p.abordo,p.compartido, p.fecha_pedido,p.estado,p.clase_vehiculo,p.tipo_pedido_empresa,p.id_empresa_cliente, p.monto_total,v.codigo_empresa,c.nombre,
            c.paterno,c.materno,c.celular as 'celular_conductor',concat(u.nombre,' ',u.apellido)as 'pasajero',p.fecha_reserva,
            u.celular as 'celular_pasajero'  from pedido p, conductor c, usuario u,vehiculo v  where u.id=p.id_usuario  
            and  c.ci=p.id_conductor  and v.placa=p.id_vehiculo and p.clase_vehiculo=1 and date(p.fecha_pedido)>='".$Request['fecha_inicio']."' and date(p.fecha_pedido)<='".$Request['fecha_fin']."' and   c.id_empresa='".Auth::user()->id_empresa."'  order by p.id desc  " );

            }else if($Request['filtro']==4){
                //TODOS DE LUJO
            $pedido=DB::select("SELECT p.id,p.id_vehiculo,p.id_conductor,p.calificacion_conductor,p.calificacion_vehiculo,p.direccion,p.latitud,p.longitud,p.tipo_reserva_auxiliar,
            p.panico,p.distancia,p.abordo,p.compartido, p.fecha_pedido,p.estado,p.clase_vehiculo,p.tipo_pedido_empresa,p.id_empresa_cliente, p.monto_total,v.codigo_empresa,c.nombre,
            c.paterno,c.materno,c.celular as 'celular_conductor',concat(u.nombre,' ',u.apellido)as 'pasajero',p.fecha_reserva,
            u.celular as 'celular_pasajero'  from pedido p, conductor c, usuario u,vehiculo v  where u.id=p.id_usuario  
            and  c.ci=p.id_conductor  and v.placa=p.id_vehiculo and p.clase_vehiculo=2 and date(p.fecha_pedido)>='".$Request['fecha_inicio']."' and date(p.fecha_pedido)<='".$Request['fecha_fin']."' and   c.id_empresa='".Auth::user()->id_empresa."'  order by p.id desc  " );

            }else if($Request['filtro']==5){
                //TODOS CON AIRE
            $pedido=DB::select("SELECT p.id,p.id_vehiculo,p.id_conductor,p.calificacion_conductor,p.calificacion_vehiculo,p.direccion,p.latitud,p.longitud,p.tipo_reserva_auxiliar,
            p.panico,p.distancia,p.abordo,p.compartido, p.fecha_pedido,p.estado,p.clase_vehiculo,p.tipo_pedido_empresa,p.id_empresa_cliente, p.monto_total,v.codigo_empresa,c.nombre,
            c.paterno,c.materno,c.celular as 'celular_conductor',concat(u.nombre,' ',u.apellido)as 'pasajero',p.fecha_reserva,
            u.celular as 'celular_pasajero'  from pedido p, conductor c, usuario u,vehiculo v  where u.id=p.id_usuario  
            and  c.ci=p.id_conductor  and v.placa=p.id_vehiculo and p.clase_vehiculo=3 and date(p.fecha_pedido)>='".$Request['fecha_inicio']."' and date(p.fecha_pedido)<='".$Request['fecha_fin']."' and   c.id_empresa='".Auth::user()->id_empresa."'  order by p.id desc  " );

            }else if($Request['filtro']==6){
                //TODOS CON MALETERO
            $pedido=DB::select("SELECT p.id,p.id_vehiculo,p.id_conductor,p.calificacion_conductor,p.calificacion_vehiculo,p.direccion,p.latitud,p.longitud,p.tipo_reserva_auxiliar,
            p.panico,p.distancia,p.abordo,p.compartido, p.fecha_pedido,p.estado,p.clase_vehiculo,p.tipo_pedido_empresa,p.id_empresa_cliente, p.monto_total,v.codigo_empresa,c.nombre,
            c.paterno,c.materno,c.celular as 'celular_conductor',concat(u.nombre,' ',u.apellido)as 'pasajero',p.fecha_reserva,
            u.celular as 'celular_pasajero'  from pedido p, conductor c, usuario u,vehiculo v  where u.id=p.id_usuario  
            and  c.ci=p.id_conductor  and v.placa=p.id_vehiculo and p.clase_vehiculo=4 and date(p.fecha_pedido)>='".$Request['fecha_inicio']."' and date(p.fecha_pedido)<='".$Request['fecha_fin']."' and   c.id_empresa='".Auth::user()->id_empresa."'  order by p.id desc  " );

            }else if($Request['filtro']==7){
                //reservas
                  $pedido=DB::select("SELECT p.id,p.id_vehiculo,p.id_conductor,p.calificacion_conductor,p.calificacion_vehiculo,p.direccion,p.latitud,p.longitud,p.tipo_reserva_auxiliar,
            p.panico,p.distancia,p.abordo,p.compartido, p.fecha_pedido,p.estado,p.clase_vehiculo,p.tipo_pedido_empresa,p.id_empresa_cliente, p.monto_total,v.codigo_empresa,c.nombre,
            c.paterno,c.materno,c.celular as 'celular_conductor',concat(u.nombre,' ',u.apellido)as 'pasajero',p.fecha_reserva,
            u.celular as 'celular_pasajero'  from pedido p, conductor c, usuario u,vehiculo v  where u.id=p.id_usuario  
            and  c.ci=p.id_conductor  and v.placa=p.id_vehiculo and p.tipo_reserva_auxiliar=1 and date(p.fecha_pedido)>='".$Request['fecha_inicio']."' and date(p.fecha_pedido)<='".$Request['fecha_fin']."' and   c.id_empresa='".Auth::user()->id_empresa."'  order by p.id desc " );

            }
            else if($Request['filtro']==8){
                //moto
                  $pedido=DB::select("SELECT p.id,p.id_vehiculo,p.id_conductor,p.calificacion_conductor,p.calificacion_vehiculo,p.direccion,p.latitud,p.longitud,p.tipo_reserva_auxiliar,
            p.panico,p.distancia,p.abordo,p.compartido, p.fecha_pedido,p.estado,p.clase_vehiculo,p.tipo_pedido_empresa,p.id_empresa_cliente, p.monto_total,v.codigo_empresa,c.nombre,
            c.paterno,c.materno,c.celular as 'celular_conductor',concat(u.nombre,' ',u.apellido)as 'pasajero',p.fecha_reserva,
            u.celular as 'celular_pasajero'  from pedido p, conductor c, usuario u,vehiculo v  where u.id=p.id_usuario  
            and  c.ci=p.id_conductor  and v.placa=p.id_vehiculo and p.clase_vehiculo>=7 and p.clase_vehiculo<=8 and date(p.fecha_pedido)>='".$Request['fecha_inicio']."' and date(p.fecha_pedido)<='".$Request['fecha_fin']."' and   c.id_empresa='".Auth::user()->id_empresa."'  order by p.id desc " );

            }
            else if($Request['filtro']==9){
                //pedidos en vehiculo
                  $pedido=DB::select("SELECT p.id,p.id_vehiculo,p.id_conductor,p.calificacion_conductor,p.calificacion_vehiculo,p.direccion,p.latitud,p.longitud,p.tipo_reserva_auxiliar,
            p.panico,p.distancia,p.abordo,p.compartido, p.fecha_pedido,p.estado,p.clase_vehiculo,p.tipo_pedido_empresa,p.id_empresa_cliente, p.monto_total,v.codigo_empresa,c.nombre,
            c.paterno,c.materno,c.celular as 'celular_conductor',concat(u.nombre,' ',u.apellido)as 'pasajero',p.fecha_reserva,
            u.celular as 'celular_pasajero'  from pedido p, conductor c, usuario u,vehiculo v  where u.id=p.id_usuario  
            and  c.ci=p.id_conductor  and v.placa=p.id_vehiculo and p.clase_vehiculo=5 and date(p.fecha_pedido)>='".$Request['fecha_inicio']."' and date(p.fecha_pedido)<='".$Request['fecha_fin']."' and   c.id_empresa='".Auth::user()->id_empresa."'  order by p.id desc " );

            }else if($Request['filtro']==10){
                //pedidos en moto
                  $pedido=DB::select("SELECT p.id,p.id_vehiculo,p.id_conductor,p.calificacion_conductor,p.calificacion_vehiculo,p.direccion,p.latitud,p.longitud,p.tipo_reserva_auxiliar,
            p.panico,p.distancia,p.abordo,p.compartido, p.fecha_pedido,p.estado,p.clase_vehiculo,p.tipo_pedido_empresa,p.id_empresa_cliente, p.monto_total,v.codigo_empresa,c.nombre,
            c.paterno,c.materno,c.celular as 'celular_conductor',concat(u.nombre,' ',u.apellido)as 'pasajero',p.fecha_reserva,
            u.celular as 'celular_pasajero'  from pedido p, conductor c, usuario u,vehiculo v  where u.id=p.id_usuario  
            and  c.ci=p.id_conductor  and v.placa=p.id_vehiculo and p.clase_vehiculo=8 and date(p.fecha_pedido)>='".$Request['fecha_inicio']."' and date(p.fecha_pedido)<='".$Request['fecha_fin']."' and   c.id_empresa='".Auth::user()->id_empresa."'  order by p.id desc " );

            }
            else{
            $pedido=DB::select("SELECT p.id,p.id_vehiculo,p.id_conductor,p.calificacion_conductor,p.calificacion_vehiculo,p.direccion,p.latitud,p.longitud,p.tipo_reserva_auxiliar,
            p.panico,p.distancia,p.abordo,p.compartido, p.fecha_pedido,p.estado,p.clase_vehiculo,p.tipo_pedido_empresa,p.id_empresa_cliente, p.monto_total,v.codigo_empresa,c.nombre,
            c.paterno,c.materno,c.celular as 'celular_conductor',concat(u.nombre,' ',u.apellido)as 'pasajero',p.fecha_reserva,
            u.celular as 'celular_pasajero'  from pedido p, conductor c, usuario u,vehiculo v  where u.id=p.id_usuario  
            and  c.ci=p.id_conductor  and v.placa=p.id_vehiculo and date(p.fecha_pedido)>='".$Request['fecha_inicio']."' and date(p.fecha_pedido)<='".$Request['fecha_fin']."' and   c.id_empresa='".Auth::user()->id_empresa."'  order by p.id desc limit 50" );
            }
    }else{      
          $pedido=DB::select("SELECT p.id,p.id_vehiculo,p.id_conductor,p.calificacion_conductor,p.calificacion_vehiculo,p.direccion,p.latitud,p.longitud,p.tipo_reserva_auxiliar,
            p.panico,p.distancia,p.abordo,p.compartido, p.fecha_pedido,p.estado,p.clase_vehiculo,p.tipo_pedido_empresa,p.id_empresa_cliente, p.monto_total,v.codigo_empresa,c.nombre,
            c.paterno,c.materno,c.celular as 'celular_conductor',concat(u.nombre,' ',u.apellido)as 'pasajero',p.fecha_reserva,
            u.celular as 'celular_pasajero'  from pedido p, conductor c, usuario u,vehiculo v  where u.id=p.id_usuario  
            and  c.ci=p.id_conductor  and v.placa=p.id_vehiculo and   c.id_empresa='".Auth::user()->id_empresa."'  order by p.id desc limit 50" );
    }
    		

    	return view('pedido.index',['pedido'=>$pedido]);
    }


    function ver_detalle_pedido_por_id($id_pedido)
    {
        $pedido=DB::select("SELECT pedido.*,
            IFNULL(lugar.latitud,'0') as 'latitud_lugar',
            IFNULL(lugar.longitud,'0') as 'longitud_lugar'
            from pedido 
            left join(lugar)
            on(lugar.id=pedido.id_lugar)
            where pedido.id='".$id_pedido."'  
             limit 1" );
        $pasajero=DB::select("SELECT u.* from pedido p, usuario u where u.id=p.id_usuario and p.id='".$id_pedido."'   limit 1" );
        $conductor=DB::select("SELECT u.* from pedido p, conductor u where u.ci=p.id_conductor and p.id='".$id_pedido."'   limit 1" );
        $vehiculo=DB::select("SELECT u.* from pedido p, vehiculo u where u.placa=p.id_vehiculo and p.id='".$id_pedido."'   limit 1" );
        $carrera=DB::select("SELECT * from carrera where  id_pedido='".$id_pedido."'  order by id asc" );
        $mensaje = DB::select("SELECT c.* from chat c,pedido p where c.id_usuario=p.id_usuario and c.id_conductor=p.id_conductor and p.id=".$id_pedido." ORDER BY c.id asc");
        $lugar = DB::select("SELECT c.* from lugar c,pedido p where c.id=p.id_lugar and p.id=".$id_pedido." limit 1");
        $carrito = DB::select("SELECT pr.id,pr.nombre,pr.descripcion,pr.precio,pr.imagen1,c.cantidad,c.monto_unidad,c.monto_total from producto pr,carrito c  where pr.id=c.id_producto and c.id_pedido=".$id_pedido);
        return View('pedido.detalle_pedido',[
            'pedido'=>$pedido,
            'carrera'=>$carrera,
            'pasajero'=>$pasajero,
            'conductor'=>$conductor,
            'vehiculo'=>$vehiculo,
            'mensaje'=>$mensaje,
            'lugar'=>$lugar,
            'carrito'=>$carrito
        ]);
    }

     function ver_linea_ruta($id_carrera,$id_pedido){
        $pedido=DB::select("SELECT * from ruta where id_carrera='".$id_carrera."' and id_pedido='".$id_pedido."' order by numero asc");
        return response($pedido);
    }


    function detalle_pedido($id_pedido){
        $pedido=DB::select("SELECT concat(c.nombre,' ',c.paterno,' ',c.materno)as 'nombre_conductor',c.ci,c.expedido,c.celular as 'celular_conductor',
            c.categoria_licencia,c.direccion,c.direccion_imagen as 'direccion_imagen_conductor',v.direccion_imagen_adelante,
            concat(u.nombre,' ',u.apellido) as 'nombre_pasajero',u.celular as 'celular_pasajero',u.correo,p.latitud,p.longitud,p.tipo_reserva_auxiliar,
            u.direccion_imagen as 'direccion_imagen_pasajero',v.codigo_empresa,v.placa,v.modelo,v.marca,v.color,p.* 
            from pedido p, usuario u,conductor c,vehiculo v where p.id_conductor=c.ci and p.id_vehiculo=v.placa 
              and  u.id=p.id_usuario and  p.id='".$id_pedido."'");
        return response($pedido);
    }
    function detalle_pedido_reserva_sin_aceptar($id_pedido){
        $pedido=DB::select("SELECT   concat(u.nombre,' ',u.apellido) as 'nombre_pasajero',u.celular as 'celular_pasajero',u.correo , u.direccion_imagen as 'direccion_imagen_pasajero',p.* 
            from pedido p, usuario u where u.id=p.id_usuario and  p.id='".$id_pedido."'");
        return response($pedido);
    }

      function detalle_cancelacion_usuario($id_pedido){
        $pedido=DB::select("SELECT direccion,detalle_cancelo_usuario,fecha_pedido,fecha_proceso,fecha_finalizado from pedido where id='".$id_pedido."'");
        return response($pedido);
    }

      function detalle_cancelacion_conductor($id_pedido){
        $pedido=DB::select("SELECT direccion,detalle_cancelo_conductor,fecha_pedido,fecha_proceso,fecha_finalizado from pedido where id='".$id_pedido."'");
        return response($pedido);
    }
    public function ver_reservas(Request $Request)
    {
        $fecha_inicio=date('Y-m-j');
        $fecha_fin=date('Y-m-j');
        if($Request->isMethod('GET') && $Request['fecha_inicio']!=''){
            $fecha_inicio=$Request['fecha_inicio'];
            $fecha_fin=$Request['fecha_fin'];
        }
        $reservas=DB::select("SELECT * from pedido where  fecha_reserva>='".$fecha_inicio."' and fecha_reserva<='".$fecha_fin."' tipo_reserva_auxiliar=1");
        
        return View('pedido.index_reserva',['pedido'=>$reservas,'fecha_inicio'=>$fecha_inicio,'fecha_fin'=>$fecha_fin]);
    }
    public  function solicitudes_sin_aceptar(Request $Request)
    {
        $fecha_inicio=date('Y-m-j');
        $fecha_fin=date('Y-m-j');
        $filtro=0;
        if($Request->isMethod('GET') && $Request['fecha_inicio']!=''){
            $fecha_inicio=$Request['fecha_inicio'];
            $fecha_fin=$Request['fecha_fin'];
            $filtro=$Request['filtro'];
        }
        if($filtro==1){
            //PEDIDOS
            $reservas=DB::select("SELECT p.*,u.celular as 'celular_pasajero',concat(u.nombre,' ',u.apellido)as 'pasajero' from pedido p,usuario u where p.id_usuario=u.id and date(p.fecha_pedido)>='".$fecha_inicio."' and date(p.fecha_pedido)<='".$fecha_fin."' and p.tipo_reserva_auxiliar=0  and p.id_conductor is NULL");
        }else if($filtro==2){
            //RESERVAS
            $reservas=DB::select("SELECT p.*,u.celular as 'celular_pasajero',concat(u.nombre,' ',u.apellido)as 'pasajero' from pedido p,usuario u where p.id_usuario=u.id and date(p.fecha_reserva)>='".$fecha_inicio."' and date(p.fecha_reserva)<='".$fecha_fin."' and p.tipo_reserva_auxiliar=1  and p.id_conductor is NULL");
        }else{
         $reservas=DB::select("SELECT p.*,u.celular as 'celular_pasajero',concat(u.nombre,' ',u.apellido)as 'pasajero' from pedido p,usuario u where p.id_usuario=u.id and date(p.fecha_pedido)>='".$fecha_inicio."' and date(p.fecha_pedido)<='".$fecha_fin."' and p.id_conductor is NULL ");   
        }
        
        
        return View('pedido.index_pedido',['pedido'=>$reservas,'fecha_inicio'=>$fecha_inicio,'fecha_fin'=>$fecha_fin]);
    }

     function ver_ubicacion_conductor($id_conductor){
        $conductor=DB::select("SELECT latitud_asignacion,longitud_asignacion from conductor where ci='".$id_conductor."'");
        return response($conductor);
    }
}
