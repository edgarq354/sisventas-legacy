<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use App\Notificacion;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;

class BusquedaController extends Controller
{
    public function __construct() {
         $this->middleware('auth');
    }

    function index(){
   
        $conductor_vehiculo=DB::select("SELECT c.ci,c.nombre,c.paterno,c.materno,c.sexo,c.celular,c.direccion,c.estado,
            c.token,c.direccion_imagen,c.bloqueo,c.panico,c.id_vehiculo, c.id_empresa,c.estado_asignacion,v.moto FROM conductor c,vehiculo v 
            WHERE v.placa=c.id_vehiculo AND c.estado=1 AND c.id_empresa=".Auth::user()->id_empresa);    

        $tienda=DB::select("SELECT t.* from lugar t where t.id_empresa=".Auth::user()->id_empresa);    

  
    return view('busqueda.busqueda',['conductor_vehiculo'=>$conductor_vehiculo,'empresa'=>$tienda]);        
    }

    function index_conductor(){
    
        $conductor_vehiculo=DB::select("SELECT c.ci,c.nombre,c.paterno,c.materno,c.sexo,c.celular,c.direccion,c.estado,c.estado_asignacion,
            c.token,c.direccion_imagen,c.bloqueo,c.panico,c.id_vehiculo, c.id_empresa,c.estado,v.codigo_empresa,v.moto FROM conductor c,vehiculo v 
            WHERE v.placa=c.id_vehiculo AND c.estado=1 AND c.id_empresa=".Auth::user()->id_empresa); 

    return view('busqueda.busqueda_un_conductor',compact('conductor_vehiculo',$conductor_vehiculo));        
    }

   function index_busqueda_pedido(){
      
        $conductor_vehiculo=DB::select("SELECT c.ci,c.nombre,c.paterno,c.materno,c.sexo,c.celular,c.direccion,c.estado,c.token,c.estado_asignacion,
            c.direccion_imagen,c.bloqueo,c.panico,c.id_vehiculo, c.id_empresa,c.estado,v.codigo_empresa,c.fecha_ultimo,v.moto FROM conductor c,vehiculo v 
            WHERE v.placa=c.id_vehiculo AND c.estado=1  AND  c.id_empresa=".Auth::user()->id_empresa); 
  
    return view('busqueda.busqueda_pedidos',compact('conductor_vehiculo',$conductor_vehiculo));        
    }
  
  function buscar_un_conductor($ci){ 

    
        $conductor=DB::select("SELECT c.ci,c.expedido,CONCAT(c.nombre,' ',c.paterno,' ',c.materno)as conductor,
            c.direccion_imagen,c.direccion,c.celular,c.estado, v.placa,v.marca,
            v.clase,c.token,c.latitud_asignacion,c.longitud_asignacion,c.rotacion,v.codigo_empresa,
            c.estado_asignacion,c.fecha_ultimo,v.moto FROM conductor c,vehiculo v WHERE c.id_vehiculo=v.placa
            AND c.id_empresa='".Auth::user()->id_empresa."' AND c.ci=".$ci." limit 1");
    
    return response($conductor);
  }


    //MUESTRA LOS CONDUCTORES ACTIVOS
    public function buscar_activos_conductor(){ 
     
            $activos=DB::select("SELECT  c.ci,c.expedido,CONCAT(c.nombre,' ',c.paterno,' ',c.materno)as conductor,
                c.direccion_imagen,c.direccion,c.celular,c.estado, v.placa,v.marca,
                v.clase,c.token,c.latitud_asignacion,c.longitud_asignacion,c.rotacion,v.codigo_empresa,
                c.estado_asignacion,c.fecha_ultimo,v.moto FROM conductor c,vehiculo v WHERE  v.placa=c.id_vehiculo 
                and  c.estado=1  AND  c.id_empresa=".Auth::user()->id_empresa);                    
                    
        return response($activos);
    }

     //MUESTRA LOS CONDUCTORES ACTIVOS POR TIEMPO
    public function buscar_activos_conductor_tiempo(){ 
     
            $activos=DB::select("SELECT  c.ci,c.expedido,CONCAT(c.nombre,' ',c.paterno,' ',c.materno)as conductor,
                c.direccion_imagen,c.direccion,c.celular,c.estado, v.placa,v.marca,
                v.clase,c.token,c.latitud_asignacion,c.longitud_asignacion,c.rotacion,v.codigo_empresa,
                c.estado_asignacion,c.fecha_ultimo,v.moto,TIMESTAMPDIFF(MINUTE,c.fecha_ultimo,now()) as 'minuto' FROM conductor c,vehiculo v,ajuste a WHERE  v.placa=c.id_vehiculo 
                and  c.estado=1  AND TIMESTAMPDIFF(MINUTE,c.fecha_ultimo,now())<=a.tiempo_visualizacion_conductor and a.anio=".date('Y')."  and   c.id_empresa=".Auth::user()->id_empresa);                    
                    
        return response($activos);
    }

    //MUESTRA LOS MOTISTAS ACTIVOS
    public function buscar_inactivos_conductor(){  
     
            $inactivos=DB::select("SELECT conductor.ci,conductor.expedido,CONCAT(conductor.nombre,' ',conductor.paterno,' ',conductor.materno)as conductor,
                conductor.direccion_imagen,conductor.direccion,conductor.celular,conductor.estado , vehiculo.placa,vehiculo.marca,vehiculo.clase,
                conductor.token,conductor.latitud_asignacion,conductor.longitud_asignacion,conductor.rotacion,vehiculo.codigo_empresa,conductor.estado_asignacion,
                 conductor.fecha_ultimo,vehiculo.moto FROM conductor,vehiculo,empresa WHERE conductor.id_vehiculo=vehiculo.placa  
                 AND  empresa.id=conductor.id_empresa AND conductor.estado<1 and conductor.estado=0 and conductor.id_empresa=".Auth::user()->id_empresa);                    
              
        return response($inactivos);
    }

    //MUESTRA LOS MOTISTAS ACTIVOS
    public function buscar_todo_los_conductor(){   
        $todos=DB::select("SELECT c.ci,c.expedido,CONCAT(c.nombre,' ',c.paterno,' ',c.materno)as conductor,
                c.direccion_imagen,c.direccion,c.celular,c.estado_asignacion , v.placa,v.marca,
                v.clase,c.token,c.latitud_asignacion,c.longitud_asignacion,c.rotacion,v.codigo_empresa,
                c.estado,c.fecha_ultimo,v.moto FROM conductor c,vehiculo v WHERE c.id_vehiculo=v.placa
                AND c.id_empresa=".Auth::user()->id_empresa);   
        $pedido=DB::select("SELECT p.*,u.nombre,u.apellido,u.correo,u.celular from pedido p, usuario u where p.id_usuario=u.id and p.estado=0 and p.id_vehiculo is NULL ");                         
                           
        
        $row = array('conductor' => $todos,'pedido'=>$pedido );       
        return response($row);
    }

    //MUESTRA LOS MOTISTAS ACTIVOS
    public function buscar_todo_los_conductor_tiempo(){   
        $todos=DB::select("SELECT c.ci,c.expedido,CONCAT(c.nombre,' ',c.paterno,' ',c.materno)as conductor,
                c.direccion_imagen,c.direccion,c.celular,c.estado_asignacion , v.placa,v.marca,
                c.numero_movil,c.categoria_licencia,c.credito,
                v.clase,c.token,c.latitud_asignacion,c.longitud_asignacion,c.rotacion,v.codigo_empresa,
                c.estado,c.fecha_ultimo,v.moto,TIMESTAMPDIFF(MINUTE,fecha_ultimo,now()) as 'minuto' FROM conductor c,vehiculo v,ajuste a WHERE  TIMESTAMPDIFF(MINUTE,c.fecha_ultimo,now())<=a.tiempo_visualizacion_conductor and a.anio=".date('Y')."  and  c.id_vehiculo=v.placa
                ");   
        $pedido=DB::select("SELECT p.*,u.nombre,u.apellido,u.correo,u.celular from pedido p, usuario u where p.id_usuario=u.id and p.estado=0 and TIMESTAMPDIFF(MINUTE,p.fecha_pedido,now())<=1 and p.id_vehiculo is NULL ");                         
                           
        
        $row = array('conductor' => $todos,'pedido'=>$pedido );       
        return response($row);
    }

    //MUESTRA LOS MOTISTAS ACTIVOS
    public function buscar_carrera_conductor(){ 

          $carrera=DB::select("SELECT conductor.ci,conductor.expedido,CONCAT(conductor.nombre,' ',conductor.paterno,' ',conductor.materno)as conductor,
            conductor.direccion_imagen,conductor.direccion,conductor.celular,conductor.estado, vehiculo.placa,vehiculo.marca,vehiculo.clase,
             empresa.razon_social,conductor.token,conductor.latitud_asignacion,conductor.longitud_asignacion,conductor.rotacion,vehiculo.codigo_empresa,conductor.fecha_ultimo,vehiculo.moto 
             FROM conductor,vehiculo,empresa WHERE conductor.id_vehiculo=vehiculo.placa 
             AND empresa.id=conductor.id_empresa and conductor.estado>2 AND conductor.estado=2 and conductor.id_empresa=".Auth::user()->id_empresa);        
                 
        return response($carrera);
    }

    public function buscar_todos_pedidos(){ 
     
          $conductor=DB::select("SELECT c.ci,c.expedido,CONCAT(c.nombre,' ',c.paterno,' ',c.materno)as conductor,
            c.direccion_imagen,c.direccion,c.celular,c.estado, v.placa,v.marca,v.clase,
            c.token,c.latitud_asignacion,c.longitud_asignacion,c.rotacion,v.codigo_empresa,c.fecha_ultimo,v.moto 
            FROM conductor c,vehiculo v WHERE v.placa=c.id_vehiculo 
             AND c.estado=1  and c.id_empresa=".Auth::user()->id_empresa);        
        
        $pedido=DB::select("SELECT p.latitud,p.longitud,p.direccion,p.mensaje,p.fecha_pedido,p.numero_casa,u.nombre,u.apellido,u.celular,u.direccion_imagen,
            'fecha_ultimo',p.clase_vehiculo from pedido p,usuario u where p.id_conductor is null and TIMESTAMPDIFF(MINUTE,p.fecha_pedido,now())<=1 and p.id_usuario=u.id"); 

        $row = array('conductor' => $conductor,'pedido'=>$pedido );       
        return response($row);
    }

    public function ver_solicitudes(){ 
     
          $pedido=DB::select("SELECT p.*,u.nombre,u.apellido,u.correo,u.celular from pedido p, usuario u where p.id_usuario=u.id and p.estado=0  and TIMESTAMPDIFF(MINUTE,p.fecha_pedido,now())<=1 and p.id_vehiculo is NULL ");        
            
        return response($pedido);
    }

    public function ver_servicios_en_proceso(){ 
     
          $pedido=DB::select("SELECT p.*, CONCAT(u.nombre,' ',u.apellido) as 'pasajero',u.correo,u.celular as 'celular_pasajero',c.numero_movil,CONCAT(c.nombre,' ',c.paterno,' ',c.materno) as 'conductor',c.celular as 'celular_conductor',v.marca,v.color  from pedido p, usuario u, vehiculo v, conductor c where p.id_usuario=u.id and p.estado<2  and c.ci=p.id_conductor and v.placa=p.id_vehiculo  order by p.id desc limit 10 ");        
        return response($pedido);
    }

    public function ver_servicios_concluidos(){ 
     
          $pedido=DB::select("SELECT p.*, CONCAT(u.nombre,' ',u.apellido) as 'pasajero',u.correo,u.celular as 'celular_pasajero',c.numero_movil,CONCAT(c.nombre,' ',c.paterno,' ',c.materno) as 'conductor',c.celular as 'celular_conductor',v.marca,v.color  from pedido p, usuario u, vehiculo v, conductor c where p.id_usuario=u.id and p.estado=2  and c.ci=p.id_conductor and v.placa=p.id_vehiculo  order by id desc limit 10 ");        
            
        return response($pedido);
    }

    public function puntos_de_solicitud($fecha_inicio,$fecha_fin,$opcion){ 
        
        if($opcion==1){
            //CANCELADOS
        $pedido=DB::select("SELECT p.latitud,p.longitud,p.direccion,p.mensaje,p.fecha_pedido,p.numero_casa, 
            'fecha_ultimo',p.clase_vehiculo,p.estado from pedido p  where estado>=4 and fecha_pedido>='".$fecha_inicio."' and fecha_pedido<='".$fecha_fin."' "); 
        }else if($opcion==2){
            //COMPLETOS
        $pedido=DB::select("SELECT p.latitud,p.longitud,p.direccion,p.mensaje,p.fecha_pedido,p.numero_casa, 
            'fecha_ultimo',p.clase_vehiculo,p.estado from pedido p  where estado=2 and fecha_pedido>='".$fecha_inicio."' and fecha_pedido<='".$fecha_fin."' "); 
        }else if($opcion==3){
            // SIN ACEPTAR
          $pedido=DB::select("SELECT p.latitud,p.longitud,p.direccion,p.mensaje,p.fecha_pedido,p.numero_casa, 
            'fecha_ultimo',p.clase_vehiculo,p.estado from pedido p  where estado=0 and fecha_pedido>='".$fecha_inicio."' and fecha_pedido<='".$fecha_fin."' ");   
        }else{
            //TODOS
             $pedido=DB::select("SELECT p.latitud,p.longitud,p.direccion,p.mensaje,p.fecha_pedido,p.numero_casa, 
            'fecha_ultimo',p.clase_vehiculo,p.estado from pedido p  where fecha_pedido>='".$fecha_inicio."' and fecha_pedido<='".$fecha_fin."' "); 
        }
         

        $row = array( 'conductor'=>$pedido );       
        return response($row);
        }
/////BUSCAR conductorSTAS POR EMPRESA
    //MUESTRA LOS conductorSTA ACTIVOS DE UNA EMPRESA
    public function buscar_activos_conductor_adm($id_emp){
       
        $activos=DB::select("SELECT conductor.ci,conductor.expedido,CONCAT(conductor.nombre,' ',conductor.paterno,' ',conductor.materno)as conductor,
            conductor.direccion_imagen,conductor.direccion,conductor.celular,conductor.estado, vehiculo.placa,vehiculo.marca,
            vehiculo.clase, empresa.razon_social,conductor.token,asignacion.latitud,asignacion.longitud,asignacion.rotacion,asignacion.codigo_empresa,
        conductor.estado_asignacion,conductor.fecha_ultimo,vehiculo.moto FROM conductor,vehiculo,asignacion,empresa WHERE conductor.ci=asignacion.id_conductor 
            AND vehiculo.placa=asignacion.id_vehiculo AND empresa.id=asignacion.id_empresa AND conductor.estado=1 
            AND conductor.id_empresa=".$id_emp);  
                                    
        return response($activos);
    }
    //MUESTRA LOS conductorSTA ACTIVOS
    public function buscar_inactivos_conductor_adm($id_emp){      
      
            $inactivos=DB::select("SELECT conductor.ci,conductor.expedido,CONCAT(conductor.nombre,' ',conductor.paterno,' ',conductor.materno)as conductor,
                conductor.direccion_imagen,conductor.direccion,conductor.celular,conductor.estado as 'estado_conductor', vehiculo.placa,vehiculo.marca,
                vehiculo.clase, empresa.razon_social,conductor.token,asignacion.latitud,asignacion.longitud,asignacion.rotacion,asignacion.codigo_empresa,
                asignacion.estado,asignacion.fecha_ultimo,vehiculo.moto FROM conductor,vehiculo,asignacion,empresa WHERE conductor.ci=asignacion.id_conductor 
                AND vehiculo.placa=asignacion.id_vehiculo AND empresa.id=asignacion.id_empresa AND conductor.estado=0 and asignacion.estado<2 
                and conductor.id_empresa=".$id_emp); 
                            
        return response($inactivos);
    }

    //MUESTRA LOS conductorSTA ACTIVOS
    public function buscar_todo_los_conductor_adm($id_emp){

        $todos=DB::select("SELECT conductor.ci,conductor.expedido,CONCAT(conductor.nombre,' ',conductor.paterno,' ',conductor.materno)as conductor,
            conductor.direccion_imagen,conductor.direccion,conductor.celular,conductor.estado as 'estado_conductor', vehiculo.placa,vehiculo.marca,
            vehiculo.clase, empresa.razon_social,conductor.token,asignacion.latitud,asignacion.longitud,asignacion.rotacion,asignacion.codigo_empresa,
            asignacion.estado,asignacion.fecha_ultimo,vehiculo.moto FROM conductor,vehiculo,asignacion,empresa WHERE conductor.ci=asignacion.id_conductor 
            AND vehiculo.placa=asignacion.id_vehiculo AND empresa.id=asignacion.id_empresa  and asignacion.estado<2 AND  conductor.id_empresa=".$id_emp);   
                                        
        return response($todos);
    }

    //MUESTRA LOS MOTISTAS ACTIVOS
    public function buscar_carrera_conductor_adm($id_emp){   
       
        $carrera=DB::select("SELECT conductor.ci,conductor.expedido,CONCAT(conductor.nombre,' ',conductor.paterno,' ',conductor.materno)as conductor,
            conductor.direccion_imagen,conductor.direccion,conductor.celular,conductor.estado as 'estado_conductor', vehiculo.placa,vehiculo.marca,
            vehiculo.clase, empresa.razon_social,conductor.token,asignacion.latitud,asignacion.longitud,asignacion.rotacion,asignacion.codigo_empresa,
            asignacion.estado,asignacion.fecha_ultimo,vehiculo.moto FROM conductor,vehiculo,asignacion,empresa WHERE conductor.ci=asignacion.id_conductor 
            AND vehiculo.placa=asignacion.id_vehiculo AND empresa.id=asignacion.id_empresa and asignacion.estado<2 AND conductor.estado=2 
            and conductor.id_empresa=".$id_emp);   
           
        return response($carrera);
    }

    //ENVIAR NOTIFICACION A VARIOS taxiSTA EN BUSQUEDA
    function notificacion_conductores(Request $request){ 
        $mPushNotification = getPush("TAXICORP",$request['detalle_msn'],null,"","","","","","20");        
        $id_conductor=$request->get('id_conductor');
        $token=$request->get('token_not');
        $cont=0;
        $tokens = array(); 
        while ( $cont < count($id_conductor)) {
          if ( ($token[$cont] != "0") && ($token[$cont] != "") ) {     
            array_push($tokens, $token[$cont]);                            
          }
            $cont=$cont+1;                    
        }     
        send($tokens,$mPushNotification);        

       /* Notificacion::create([
            'titulo' => "ASAPP",
            'mensaje' => $request['detalle_msn'],
            'tipo' => 1,
            'id_administrador' => $request->user()->id,
        ]);*/

        Session::flash('message','ENVIADO CORRECTAMENTE');
        return Redirect::to('/busqueda_vehiculo');     
    }



     public function ver_datos_pedido($id_pedido,$clase_vehiculo,$latitud,$longitud){   $consulta="";
          $distancia=10000;
        switch ($clase_vehiculo) {
        case '1':
        //CUALQUIER MOVIL
            $consulta="SELECT ci,id_vehiculo,nombre,paterno,materno,numero_movil,credito,distancia_entre_dos_puntos(".$latitud.",".$longitud.",c.latitud_asignacion,c.longitud_asignacion) as distancia 
            FROM conductor c,vehiculo v where c.id_vehiculo=v.placa and c.estado=1 and c.login=1 and v.movil=1 and v.moto=0
            and distancia_entre_dos_puntos(".$latitud.",".$longitud.",c.latitud_asignacion,c.longitud_asignacion)<= ".$distancia."  
            and c.ci not in (select id_conductor from pedido where estado<=1 and id_conductor is not null)  
            order by distancia asc   limit 10";
            break;
        case 2:
        //MOVILES DE LUJO
            $consulta="SELECT nombre,paterno,materno,numero_movil,credito,distancia_entre_dos_puntos(".$latitud.",".$longitud.",c.latitud_asignacion,c.longitud_asignacion) as distancia 
            FROM conductor c,vehiculo v where c.id_vehiculo=v.placa and c.estado=1 and c.login=1 and v.lujo=1 and moto=0
            and distancia_entre_dos_puntos(".$latitud.",".$longitud.",c.latitud_asignacion,c.longitud_asignacion)<= ".$distancia."    
            and c.ci not in (select id_conductor from pedido where estado<=1 and id_conductor is not null)  
            order by distancia asc  limit 10";
            break;
        case 3:
        //MOVILES CON AIRE ACONDICIONADO
            $consulta="SELECT nombre,paterno,materno,numero_movil,credito,distancia_entre_dos_puntos(".$latitud.",".$longitud.",c.latitud_asignacion,c.longitud_asignacion) as distancia 
            FROM conductor c,vehiculo v where c.id_vehiculo=v.placa and c.estado=1 and c.login=1 and v.aire=1 and moto=0
            and distancia_entre_dos_puntos(".$latitud.",".$longitud.",c.latitud_asignacion,c.longitud_asignacion)<=".$distancia."    
            and c.ci not in (select id_conductor from pedido where estado<=1 and id_conductor is not null)  
            order by distancia asc  limit 10";
            break;
        case 4:
        //MOVILES CON MALETERO
            $consulta="SELECT nombre,paterno,materno,numero_movil,credito,distancia_entre_dos_puntos(".$latitud.",".$longitud.",c.latitud_asignacion,c.longitud_asignacion) as distancia 
            FROM conductor c,vehiculo v where c.id_vehiculo=v.placa and c.estado=1 and c.login=1 and v.maletero_libre=1 and moto=0
            and distancia_entre_dos_puntos(".$latitud.",".$longitud.",c.latitud_asignacion,c.longitud_asignacion)<=".$distancia."    
            and c.ci not in (select id_conductor from pedido where estado<=1 and id_conductor is not null)  
            order by distancia asc  limit 10";
            break;
        case 5:
        //CUALQUIER MOVIL 'PEDIDO DE ENCOMIENDA'.
            $consulta="SELECT nombre,paterno,materno,numero_movil,credito,distancia_entre_dos_puntos(".$latitud.",".$longitud.",c.latitud_asignacion,c.longitud_asignacion) as distancia 
            FROM conductor c,vehiculo v where c.id_vehiculo=v.placa and c.estado=1 and c.login=1 and v.movil=1 and moto=0
            and distancia_entre_dos_puntos(".$latitud.",".$longitud.",c.latitud_asignacion,c.longitud_asignacion)<=".$distancia."    
            and c.ci not in (select id_conductor from pedido where estado<=1 and id_conductor is not null)  
            order by distancia asc  limit 10";
            break;  
        case 6:
        //CUALQUIER MOVIL 'RESERVAR UN MOVIL PARA OTRA FECHA.
            $consulta="SELECT nombre,paterno,materno,numero_movil,credito,distancia_entre_dos_puntos(".$latitud.",".$longitud.",c.latitud_asignacion,c.longitud_asignacion) as distancia 
            FROM conductor c,vehiculo v where c.id_vehiculo=v.placa and c.estado=1 and c.login=1 and v.movil=1 and moto=0
            and distancia_entre_dos_puntos(".$latitud.",".$longitud.",c.latitud_asignacion,c.longitud_asignacion)<=".$distancia."    
            and c.ci not in (select id_conductor from pedido where estado<=1 and id_conductor is not null)  
            order by distancia asc  limit 10";
            break;  
        case 7:
        //CUALQUIER MOTO
            $consulta="SELECT nombre,paterno,materno,numero_movil,credito,distancia_entre_dos_puntos(".$latitud.",".$longitud.",c.latitud_asignacion,c.longitud_asignacion) as distancia 
            FROM conductor c,vehiculo v where c.id_vehiculo=v.placa and c.estado=1 and c.login=1 and v.movil=1 and moto=1
            and distancia_entre_dos_puntos(".$latitud.",".$longitud.",c.latitud_asignacion,c.longitud_asignacion)<=".$distancia."   
            and c.ci not in (select id_conductor from pedido where estado<=1 and id_conductor is not null)  
            order by distancia asc  limit 10";
            break;  
         case 8:
        //CUALQUIER MOTO
            $consulta="SELECT  nombre,paterno,materno,numero_movil,credito,distancia_entre_dos_puntos(".$latitud.",".$longitud.",c.latitud_asignacion,c.longitud_asignacion) as distancia 
            FROM conductor c,vnombre,paterno,materno,numero_movil,creditolo v where c.id_vehiculo=v.placa and c.estado=1 and c.login=1 and v.movil=1 and moto=1
            and distancia_entre_dos_puntos(".$latitud.",".$longitud.",c.latitud_asignacion,c.longitud_asignacion)<=".$distancia."   
            and c.ci not in (select id_conductor from pedido where estado<=1 and id_conductor is not null)  
            order by distancia asc  limit 10";
            break;                          
             }
        $conductor=DB::select($consulta); 
        $usuario=DB::select("SELECT p.*,concat(u.nombre,' ',u.apellido)as 'nombre',u.correo,u.celular,u.id_facebook,u.id_google,TIMESTAMPDIFF(MINUTE,p.fecha_pedido,now()) as 'minuto',concat(hour(p.fecha_pedido),':',minute(p.fecha_pedido),':',second(p.fecha_pedido)) as 'hora' from pedido p, usuario u where p.id_usuario=u.id and p.id=".$id_pedido);                         
                           
        
        $row = array('usuario' => $usuario,'conductor'=>$conductor,'clase_vehiculo'=>$clase_vehiculo,'latitud'=>$latitud,'longitud'=>$longitud,'consulta'=>$consulta );       
        return response($row);
    }

}
