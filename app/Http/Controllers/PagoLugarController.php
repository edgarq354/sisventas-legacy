<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Empresa;
use App\Telefono;
use App\Http\Requests;
use App\Notificacion;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;




class PagoLugarController extends Controller
{

    public function __construct() {
         $this->middleware('auth');
    }

     public function crear_pago_2(Request $Request )
    {                   
 
        $fecha_inicio=$Request['fecha_inicio'];
        $fecha_fin=$Request['fecha_fin'];
        $id_lugar=$Request['id_lugar'];
        $estado=$Request['estado_opcion'];
        if($estado==1){
            //BUSCAR TODOS LOS PEDIDOS.
        $consulta="SELECT pedido.id, 
        conductor.ci,
        conductor.expedido,
         CONCAT(conductor.nombre,' ',conductor.paterno,' ',conductor.materno)as conductor,
         vehiculo.placa,
         vehiculo.marca, 
         CONCAT(usuario.nombre,' ',usuario.apellido) as usuario, 
         vehiculo.codigo_empresa,
         pedido.latitud,
         pedido.longitud,
         date_format(pedido.fecha_pedido,'%d-%m-%Y %h:%i %p')as fecha_pedido,
         pedido.direccion,
         pedido.monto_total,
         pedido.monto_pedido,
         pedido.monto_empresa,
         pedido.monto_deuda_lugar,
         pedido.monto_conductor,
         pedido.detalle_cancelo_usuario,
         pedido.detalle_cancelo_conductor,
         pedido.direccion,
         pedido.clase_vehiculo,
         pedido.estado,
         pedido.estado_pago_empresa,
         pedido.estado_deuda_lugar,
         pedido.calificacion_conductor,
         pedido.calificacion_vehiculo,
         pedido.porcentaje_pago_lugar 
           from pedido,vehiculo,conductor,usuario 
         WHERE pedido.id_vehiculo=vehiculo.placa 
         AND pedido.id_conductor=conductor.ci 
         AND usuario.id=pedido.id_usuario  
         AND pedido.id_lugar=".$id_lugar." 
         AND date(pedido.fecha_pedido) >='".$fecha_inicio."' 
         AND date(pedido.fecha_pedido) <='".$fecha_fin."' 
         order by pedido.id desc";
        }else if($estado==2){
            //BUSCAR TODOS LOS PEDIDOS COMPLETADOS 
            $consulta="SELECT pedido.id, 
            conductor.ci,
            conductor.expedido,
         CONCAT(conductor.nombre,' ',conductor.paterno,' ',conductor.materno)as conductor,
         vehiculo.placa,vehiculo.marca, CONCAT(usuario.nombre,' ',usuario.apellido) as usuario, 
         vehiculo.codigo_empresa,
         pedido.latitud,
         pedido.longitud,
         date_format(pedido.fecha_pedido,'%d-%m-%Y %h:%i %p')as fecha_pedido,
         pedido.direccion,
         pedido.monto_total,
         pedido.monto_pedido,
         pedido.monto_empresa,
         pedido.monto_deuda_lugar,
         pedido.monto_conductor,
         pedido.detalle_cancelo_usuario,
         pedido.detalle_cancelo_conductor,
         pedido.direccion,
         pedido.clase_vehiculo,
         pedido.estado,
         pedido.estado_pago_empresa,
         pedido.estado_deuda_lugar,
         pedido.calificacion_conductor,
         pedido.calificacion_vehiculo,
         pedido.porcentaje_pago_lugar 
           from pedido,vehiculo,conductor,usuario 
         WHERE pedido.estado=2 
         and pedido.id_vehiculo=vehiculo.placa 
         AND pedido.id_conductor=conductor.ci 
         AND usuario.id=pedido.id_usuario  
         AND pedido.id_lugar=".$id_lugar." 
         AND 
         date(pedido.fecha_pedido) >='".$fecha_inicio."' 
         AND date(pedido.fecha_pedido) <='".$fecha_fin."' 
         order by pedido.id desc";

        }else if($estado==3){
            //BUSCAR TODOS LOS PEDIDOS CANCELADOS

            $consulta="SELECT pedido.id, 
            conductor.ci,
            conductor.expedido,
         CONCAT(conductor.nombre,' ',conductor.paterno,' ',conductor.materno)as conductor,
         vehiculo.placa,vehiculo.marca, CONCAT(usuario.nombre,' ',usuario.apellido) as usuario, 
         vehiculo.codigo_empresa,
         pedido.latitud,
         pedido.longitud,
         date_format(pedido.fecha_pedido,'%d-%m-%Y %h:%i %p')as fecha_pedido,
         pedido.direccion,
         pedido.monto_total,
         pedido.monto_pedido,
         pedido.monto_empresa,
         pedido.monto_deuda_lugar,
         pedido.monto_conductor,
         pedido.detalle_cancelo_usuario,
         pedido.detalle_cancelo_conductor,
         pedido.direccion,
         pedido.clase_vehiculo,
         pedido.estado,
         pedido.estado_pago_empresa,
         pedido.estado_deuda_lugar,
         pedido.calificacion_conductor,
         pedido.calificacion_vehiculo,
         pedido.porcentaje_pago_lugar 
           from pedido,vehiculo,conductor,usuario 
         WHERE pedido.estado>=5 
         and pedido.id_vehiculo=vehiculo.placa 
         AND pedido.id_conductor=conductor.ci 
         AND usuario.id=pedido.id_usuario  
         AND pedido.id_lugar=".$id_lugar." 
         AND 
         date(pedido.fecha_pedido) >='".$fecha_inicio."' 
         AND date(pedido.fecha_pedido) <='".$fecha_fin."' 
         order by pedido.id desc";

        }else if($estado==4){
            //BUSCAR TODOS LOS PEDIDOS CON DEUDA  INCLUIDO LOS CANCELADOS.
            $consulta="SELECT pedido.id, 
            conductor.ci,
            conductor.expedido,
         CONCAT(conductor.nombre,' ',conductor.paterno,' ',conductor.materno)as conductor,
         vehiculo.placa,vehiculo.marca, CONCAT(usuario.nombre,' ',usuario.apellido) as usuario, 
         vehiculo.codigo_empresa,
         pedido.latitud,
         pedido.longitud,
         date_format(pedido.fecha_pedido,'%d-%m-%Y %h:%i %p')as fecha_pedido,
         pedido.direccion,
         pedido.monto_total,
         pedido.monto_pedido,
         pedido.monto_empresa,
         pedido.monto_deuda_lugar,
         pedido.monto_conductor,
         pedido.detalle_cancelo_usuario,
         pedido.detalle_cancelo_conductor,
         pedido.direccion,
         pedido.clase_vehiculo,
         pedido.estado,
         pedido.estado_pago_empresa,
         pedido.estado_deuda_lugar,
         pedido.calificacion_conductor,
         pedido.calificacion_vehiculo,
         pedido.porcentaje_pago_lugar 
           from pedido,vehiculo,conductor,usuario 
         WHERE pedido.estado_deuda_lugar=1 
         and pedido.id_vehiculo=vehiculo.placa 
         AND pedido.id_conductor=conductor.ci 
         AND usuario.id=pedido.id_usuario  
         AND pedido.id_lugar=".$id_lugar." AND 
         date(pedido.fecha_pedido) >='".$fecha_inicio."' AND date(pedido.fecha_pedido) <='".$fecha_fin."' order by pedido.id desc";
        
        }else if($estado==5){
            //BUSCAR TODOS TODOS LOS PEDIDOS CON DEUDA PERO SIN LOS CANCELADOS
            $consulta="SELECT pedido.id, 
            conductor.ci,
            conductor.expedido,
         CONCAT(conductor.nombre,' ',conductor.paterno,' ',conductor.materno)as conductor,
         vehiculo.placa,vehiculo.marca, CONCAT(usuario.nombre,' ',usuario.apellido) as usuario, 
         vehiculo.codigo_empresa,
         pedido.latitud,
         pedido.longitud,
         date_format(pedido.fecha_pedido,'%d-%m-%Y %h:%i %p')as fecha_pedido,
         pedido.direccion,
         pedido.monto_total,
         pedido.monto_pedido,
         pedido.monto_empresa,
         pedido.monto_deuda_lugar,
         pedido.monto_conductor,
         pedido.detalle_cancelo_usuario,
         pedido.detalle_cancelo_conductor,
         pedido.direccion,
         pedido.clase_vehiculo,
         pedido.estado,
         pedido.estado_pago_empresa,
         pedido.estado_deuda_lugar,
         pedido.calificacion_conductor,
         pedido.calificacion_vehiculo,
         pedido.porcentaje_pago_lugar 
           from pedido,vehiculo,conductor,usuario 
         WHERE  pedido.estado_deuda_lugar=1 
         and pedido.estado=2 
         and pedido.id_vehiculo=vehiculo.placa 
         AND pedido.id_conductor=conductor.ci 
         AND usuario.id=pedido.id_usuario  
         AND pedido.id_lugar=".$id_lugar." 
         AND 
         date(pedido.fecha_pedido) >='".$fecha_inicio."' 
         AND date(pedido.fecha_pedido) <='".$fecha_fin."' 
         order by pedido.id desc";

        }else if($estado==6){
            //BUSCA TODOS LOS PEDIDOS PAGADOS
            $consulta="SELECT pedido.id, 
            conductor.ci,
            conductor.expedido,
         CONCAT(conductor.nombre,' ',conductor.paterno,' ',conductor.materno)as conductor,
         vehiculo.placa,vehiculo.marca, CONCAT(usuario.nombre,' ',usuario.apellido) as usuario, 
         vehiculo.codigo_empresa,
         pedido.latitud,
         pedido.longitud,
         date_format(pedido.fecha_pedido,'%d-%m-%Y %h:%i %p')as fecha_pedido,
         pedido.direccion,
         pedido.monto_total,
         pedido.monto_pedido,
         pedido.monto_empresa,
         pedido.monto_deuda_lugar,
         pedido.monto_conductor,
         pedido.detalle_cancelo_usuario,
         pedido.detalle_cancelo_conductor,
         pedido.direccion,
         pedido.clase_vehiculo,
         pedido.estado,
         pedido.estado_pago_empresa,
         pedido.estado_deuda_lugar,
         pedido.calificacion_conductor,
         pedido.calificacion_vehiculo,
         pedido.porcentaje_pago_lugar 
           from pedido,vehiculo,conductor,usuario 
         WHERE pedido.estado_pago_empresa=1 
         and  pedido.id_vehiculo=vehiculo.placa 
         AND pedido.id_conductor=conductor.ci 
         AND usuario.id=pedido.id_usuario  
         AND pedido.id_lugar=".$id_lugar." 
         AND 
         date(pedido.fecha_pedido) >='".$fecha_inicio."' 
         AND date(pedido.fecha_pedido) <='".$fecha_fin."' 
         order by pedido.id desc";

        }
        
        
    $pedidos = DB::select($consulta);
    
      $administrador=DB::select("SELECT u.*,e.nombre as 'razon_social',e.id as 'id_lugar' 
        from  lugar e 
        left join usuario u
        on(e.id_administrador=u.id )
        where 
        e.id='".$id_lugar."'");
     $fechas = DB::select("SELECT date('".$fecha_inicio."') as fecha_inicio, date('".$fecha_fin."') as fecha_fin");   
     $tipo=DB::select("SELECT * from tipo_ingreso_egreso where id_empresa='".Auth::user()->id_empresa."'");
      //
     

        return view('lugar.pago_lugar',["fechas"=>$fechas,'pedidos'=>$pedidos,'administrador'=>$administrador,'estado'=>$estado,'otra'=>1,'tipo'=>$tipo]);
    }

    function crear_pago($id_empresa)
    {
    $pedidos = DB::select("SELECT pedido.id, 
      conductor.ci,
    conductor.expedido,
         CONCAT(conductor.nombre,' ',conductor.paterno,' ',conductor.materno)as conductor,
         vehiculo.placa,vehiculo.marca, CONCAT(usuario.nombre,' ',usuario.apellido) as usuario, 
         vehiculo.codigo_empresa,
         pedido.latitud,
         pedido.longitud,
         date_format(pedido.fecha_pedido,'%d-%m-%Y %h:%i %p')as fecha_pedido,
         pedido.direccion,
         pedido.monto_total,
         pedido.monto_pedido,
         pedido.monto_empresa,
         pedido.monto_deuda_lugar,
         pedido.monto_conductor,
         pedido.detalle_cancelo_usuario,
         pedido.detalle_cancelo_conductor,
         pedido.direccion,
         pedido.clase_vehiculo,
         pedido.estado,
         pedido.estado_pago_empresa,
         pedido.estado_deuda_lugar,
         pedido.calificacion_conductor,
         pedido.calificacion_vehiculo,
         pedido.porcentaje_pago_lugar 
           from pedido,vehiculo,conductor,usuario 
         WHERE pedido.estado_pago_empresa=0 
         and pedido.id_vehiculo=vehiculo.placa   
         AND pedido.id_conductor=conductor.ci 
          AND usuario.id=pedido.id_usuario  
         AND pedido.id_lugar=".$id_empresa." 
         AND date(pedido.fecha_pedido) >= date( DATE_SUB(curdate(), INTERVAL + 29 DAY)) 
         AND date(pedido.fecha_pedido) <=date(now())  
         order by pedido.id desc");
       $administrador=DB::select("SELECT u.*,e.nombre as 'razon_social',e.id as 'id_lugar' 
        from  lugar e 
        left join usuario u
        on(e.id_administrador=u.id )
        where 
        e.id='".$id_empresa."'");
      $fechas = DB::select("SELECT date(DATE_SUB(curdate(), INTERVAL + 29 DAY)) as fecha_inicio, date(now()) as fecha_fin");   
      $tipo=DB::select("SELECT * from tipo_ingreso_egreso 
        where id_empresa='".Auth::user()->id_empresa."'");
      $estado=4;
      
       return view('lugar.pago_lugar',["fechas"=>$fechas,'pedidos'=>$pedidos,'administrador'=>$administrador,'estado'=>$estado,'otra'=>0,'tipo'=>$tipo]);
    }


   public function get_historial_pedidos_excel($id_ingreso,$id_empresa){ 
   //DATA
        
            //BUSCAR TODOS LOS PEDIDOS.
        $consulta="SELECT pedido.id, 
        conductor.ci,
        conductor.expedido,
         CONCAT(conductor.nombre,' ',conductor.paterno,' ',conductor.materno)as conductor,
         vehiculo.codigo_empresa,
         pedido.latitud,
         pedido.longitud,
         vehiculo.placa,vehiculo.marca, CONCAT(usuario.nombre,' ',usuario.apellido) as usuario, 
         date_format(pedido.fecha_pedido,'%d-%m-%Y %h:%i %p')as fecha_pedido,
         pedido.direccion,
         pedido.monto_total,
         pedido.monto_pedido,
         pedido.monto_empresa,
         pedido.monto_deuda_lugar,
         pedido.monto_conductor,
         pedido.detalle_cancelo_usuario,
         pedido.detalle_cancelo_conductor,
         pedido.direccion,
         pedido.clase_vehiculo,
         pedido.estado,
         pedido.estado_pago_empresa,
         pedido.estado_deuda_lugar,
         pedido.calificacion_conductor,
         pedido.calificacion_vehiculo,
         pedido.porcentaje_pago_lugar 
           from pedido,vehiculo,conductor,usuario 
         WHERE pedido.id_vehiculo=vehiculo.placa 
         AND pedido.id_conductor=conductor.ci 
         AND usuario.id=pedido.id_usuario  
         and pedido.id_ingreso='".$id_ingreso."' 
         AND pedido.id_lugar=".$id_empresa."  
         order by pedido.id asc";
      
        
    $pedidos = DB::select($consulta);

    $ingresos = DB::select("SELECT 
      i.*,
      u.usuario,
      e.razon_social 
      from ingreso i, users u,empresa e 
    where e.id=i.id_lugar 
    and i.id_login=u.id 
    and i.id='".$id_ingreso."'");

     Excel::create('Lista de dueda pagadaspor la empresa',function($excel)use ($pedidos,$ingresos){
      $excel->sheet('Servicios', function($sheet)use ($pedidos,$ingresos){
      
       
  //HEADER
        $sheet->mergeCells('A1:H1');
        $sheet->mergeCells('A2:H2');
        $sheet->mergeCells('A3:H3');
        $sheet->mergeCells('A4:H4');
        $sheet->mergeCells('A5:H5');
        $sheet->mergeCells('A6:H6');
        $sheet->mergeCells('A7:H7');

        $sheet->row(1,['LISTADO']);
        $sheet->row(2,['USUARIO: '.$ingresos[0]->usuario]);
        $sheet->row(3,['PAGADOR: '.$ingresos[0]->nombre_pagador]);
        $sheet->row(4,['EMPRESA: '.$ingresos[0]->razon_social]);
        $sheet->row(5,['FECHA DE REGISTRO: '.$ingresos[0]->fecha]);
        $sheet->row(6,['OBSERVACIONES: '.$ingresos[0]->observacion]);
        $sheet->row(7,['NRO','FECHA','MOVIL','CONDUCTOR','USUARIO','REFERENCIA','MONTO']);
 
$sumatoria=1;
          foreach($pedidos as $pago){
          $row=[];
          $row[0]=$pago->id;
          $row[1]=$pago->fecha_pedido;
          $row[2]=$pago->codigo_empresa;
          $row[3]=$pago->conductor;
          $row[4]=$pago->usuario;
          $row[5]=$pago->direccion;
          $row[6]=$pago->monto_deuda_lugar;
          $sheet->appendRow($row);
          $sumatoria+=$pago->monto_deuda_lugar;
        }
        $row=[];
        $row[0]="";
          $row[1]="";
          $row[2]="";
          $row[3]="";
          $row[4]="";
          $row[5]="TOTAL";
          $row[6]=$ingresos[0]->monto;
          $sheet->appendRow($row);
             
              });
             })->export('xls');
    }


   public  function store(Request $Request)
    { 
        try {
           DB::beginTransaction();
           $permiso=$Request['ingreso'];
          $registrar=false;

             $monto_total=$Request['monto_total'];
             $observaciones=$Request['observacion'];
             $id_tipo_ingreso_egreso=$Request['id_tipo_ingreso_egreso'];
             $nombre_pagador=$Request['nombre_pagador'];
             $id_lugar=$Request['id_lugar'];
            
      
    
    		 $id_pago_ingreso=DB::table('ingreso')->insertGetId([
		     	'monto'=>$monto_total,
		     	'observacion'=>$observaciones,
		     	'id_tipo_ingreso_egreso'=>$id_tipo_ingreso_egreso,
		     	'nombre_pagador'=>$nombre_pagador,
           'id_login'=>Auth::user()->id,
		       'opcion'=>3,
		     	'id_empresa'=>Auth::user()->id_empresa,
		     	'id_lugar'=>$id_lugar
		     	]);  		 
 DB::commit(); 

            $consulta="SELECT  id from pedido WHERE estado_deuda_lugar=1 and id_lugar='".$id_lugar."'   order by  id asc";
          $pedidos = DB::select($consulta);

        $cantidad_registro=0;
    		 
     			 foreach ($pedidos as $key => $value) {
     			 		
     			 	if($Request[$value->id]=="1"){
     			 		
	          			DB::table('pedido')
	       				  ->where('id',$value->id)
         				  ->update(['estado_deuda_lugar'=>'0','id_ingreso'=>$id_pago_ingreso  ]);
                  $cantidad_registro++;
                  
          		   }
       		 	}
            if($cantidad_registro==0){
              DB::table('ingreso')->where('id', $id_pago_ingreso)->delete();
               return redirect('/lugar')->with("message-error","NO SE REGISTRO NINGUN ITEM DE PAGO");
            }else{
            	

            	 $consulta="SELECT pedido.id, 
               conductor.ci,
               conductor.expedido,
		         CONCAT(conductor.nombre,' ',conductor.paterno,' ',conductor.materno)as conductor,
             vehiculo.codigo_empresa,
             pedido.latitud,
             pedido.longitud,
		         vehiculo.placa,vehiculo.marca, CONCAT(usuario.nombre,' ',usuario.apellido) as usuario, 
		         date_format(pedido.fecha_pedido,'%d-%m-%Y %h:%i %p')as fecha_pedido,
             pedido.direccion,
             pedido.monto_total,
             pedido.monto_pedido,
             pedido.monto_empresa,
             pedido.monto_deuda_lugar,
             pedido.monto_conductor,
		         pedido.detalle_cancelo_usuario,
             pedido.detalle_cancelo_conductor,
             pedido.direccion,
             pedido.clase_vehiculo,pedido.estado,
             pedido.estado_pago_empresa,
             pedido.estado_deuda_lugar,
             pedido.calificacion_conductor,
             pedido.calificacion_vehiculo,
             pedido.porcentaje_pago_lugar 
               from pedido,vehiculo,conductor,usuario 
		         WHERE pedido.id_vehiculo=vehiculo.placa 
             AND pedido.id_conductor=conductor.ci 
             AND usuario.id=pedido.id_usuario  
             and pedido.id_ingreso='".$id_pago_ingreso."' 
             AND pedido.id_lugar=".$id_lugar."  
             order by pedido.id asc";
				      
		        
		    $pedidos = DB::select($consulta);

		    $ingresos = DB::select("SELECT i.*,u.nombre as 'usuario',e.nombre as 'razon_social',
        tp.nombre as 'tipo_ingreso_egreso' 
          from ingreso i, users u,lugar e, tipo_ingreso_egreso tp 
          where e.id=i.id_lugar 
          and i.id_login=u.id 
          and tp.id=i.id_tipo_ingreso_egreso
          and i.id='".$id_pago_ingreso."'");


            //ACTUALIZAR EL MONTO DE DEUDA

            $consulta_deuda = DB::select("SELECT sum(monto_deuda_lugar)as 'monto' 
                from pedido 
                where estado_deuda_lugar=1 
                and estado=2
                and id_conductor is not null 
                and id_lugar='".$id_lugar."'");

            DB::table('lugar')
            ->where('id',$id_lugar)
            ->update(['monto_deuda'=>$consulta_deuda[0]->monto]);
            //FIN DE LA ACTUALIZACION DEL MONTO DE DEUDA

            	return View('lugar.get_pago_deuda_pdf',['pedidos'=>$pedidos,'ingresos'=>$ingresos]);
            	//$pdf=\PDF::loadView('lugar.get_pago_deuda_pdf',['pedidos'=>$pedidos,'ingresos'=>$ingresos]);
         		//return   $pdf->stream();
            	// return redirect('/empresa')->with("message","SE REGISTRO EXITOSAMENTE" );

            }


     			 //REGISTRAR FRECUENCIA DE DIA AL AÑO
           
          
 
 		} catch (Exception $e) {
          DB::rollback();
          return redirect('/lugar')->with("message-error","ERROR INTENTE NUEVAMENTE.".$e);      
        }
    }


 

    

}
