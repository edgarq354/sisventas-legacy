<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\IngresoRequest;
use Exception;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class IngresoController extends Controller
{
    public function __construct() {
         $this->middleware('auth');
    }

      function index(Request $request) {          
 
             $ingreso = DB::select("SELECT i.*,a.nombre as 'usuario',tp.nombre as tipo_gasto , c.caja, s.nombre as sucursal
             from ingreso i,tipo_gasto tp,users a,caja c, sucursal s
             where i.id_tipo_gasto=tp.id 
             and a.id=i.id_usuario  
             and s.id=i.id_sucursal  
             and c.id=i.id_caja   
             and i.id_empresa=".Auth::user()->id_empresa);
       
            return view('ingreso.index', ['ingreso'=> $ingreso]);            
         
    }
    public function create() {   
         $buscar_cliente=DB::select("SELECT * from cliente ");
         $buscar_tipo=DB::select("SELECT * from tipo_gasto ");
         $id_caja="";
         $caja=DB::select("SELECT id from caja where  estado ='Abierta' and id_usuario=".Auth::user()->id." and  id_empresa= ".Auth::user()->id_empresa." order by id desc limit 1 ");

       foreach ($caja as $key => $value) {
            $id_caja= $value->id;   
        }
        return view('ingreso.create',[
          'buscar_cliente'=>$buscar_cliente,
          'id_caja'=>$id_caja,
          'buscar_tipo'=>$buscar_tipo]);         
    }

    public function store(IngresoRequest $request){

        try {
          $persona=DB::select("SELECT id,nombre, paterno, materno from cliente where    id=".$request['id_cliente']);
                $nombre_empleado=""; 
                foreach ($persona as $key => $value) { 
                  $nombre_empleado= $value->nombre." ".$value->paterno." ".$value->materno;    
                }


      DB::beginTransaction();
      DB::table('ingreso')
      ->insert(['monto' => $request['monto'],  
      'concepto'=>$request['concepto'],
      'id_cliente'=>$request['id_cliente'],
      'nombre_cliente'=>$nombre_empleado,
      'id_usuario'=>Auth::user()->id,  
      'id_caja'=>$request['id_caja'],  
      'id_tipo_gasto'=>$request['id_tipo'],  
      'id_sucursal'=>Auth::user()->id_sucursal,  
      'id_empresa'=>Auth::user()->id_empresa]);         
            

              DB::commit();     
            Session::flash('message', __('ingreso.registrado_correctamente'));
            return Redirect::to('/ingreso');

      }catch (Exception $e) {
          DB::rollback();
          return redirect('/ingreso/create')->with("message-error", __('ingreso.error_intente_nuevamente').$e);
      }
    }

    public function show()
    { 
            return view('errors.404');      
    }
   


    public function imprimir($id){

      $empresa=DB::select("SELECT * from empresa e where e.id=".Auth::user()->id_empresa);
      $ingreso = DB::select("SELECT i.*,
      a.nombre as 'usuario',
      tp.nombre as tipo_gasto , 
      c.caja, 
      s.nombre as sucursal
      from ingreso i,tipo_gasto tp,users a,caja c, sucursal s
      where i.id_tipo_gasto=tp.id 
      and a.id=i.id_usuario  
      and s.id=i.id_sucursal  
      and c.id=i.id_caja    
      and i.id=".$id." 
             and i.id_empresa=".Auth::user()->id_empresa);
  
      $sucursal=DB::select("SELECT * from sucursal e where  e.id=".Auth::user()->id_sucursal); 
     
        $customPaper = array(0,0,1567.00,226.77); 
        //$customPaper = array(0,0,0,0); 
                $pdf=\PDF::loadView('ingreso.imprimir',  [
                  'ingreso'=>$ingreso, 
                  'empresa'=>$empresa,
                  'sucursal'=>$sucursal
                ])->setPaper($customPaper, 'landscape'); 
               
        return   $pdf->stream();          
    }       
  
    public  function historial($fechaInicio,$fechaFinal)
    { 
      $ingreso = DB::select("SELECT i.*,a.nombre as 'usuario',tp.nombre as tipo_gasto , c.caja, s.nombre as sucursal
      from ingreso i,tipo_gasto tp,users a,caja c, sucursal s
      where i.id_tipo_gasto=tp.id 
      and a.id=i.id_usuario  
      and s.id=i.id_sucursal  
      and c.id=i.id_caja    
      and date(i.fecha) between date('".$fechaInicio."') and date('".$fechaFinal."') and i.id_empresa=".Auth::user()->id_empresa); 
        
       return view('ingreso.historial',[
        'ingreso'=>$ingreso,
        'fechaInicio'=>$fechaInicio,
        'fechaFinal'=>$fechaFinal
         ]);   
    }
  
    
    public  function historial_imprimir($fechaInicio,$fechaFinal)
    { 
      $ingreso = DB::select("SELECT i.*,a.nombre as 'usuario',tp.nombre as tipo_gasto , c.caja, s.nombre as sucursal
      from ingreso i,tipo_gasto tp,users a,caja c, sucursal s
      where i.id_tipo_gasto=tp.id 
      and a.id=i.id_usuario  
      and s.id=i.id_sucursal  
      and c.id=i.id_caja    
      and date(i.fecha) between date('".$fechaInicio."') and date('".$fechaFinal."') and i.id_empresa=".Auth::user()->id_empresa); 
          $empresa=DB::select("SELECT * from empresa  where id='".Auth::user()->id_empresa."'");  
  
         $pdf=\PDF::loadView('ingreso.historial_imprimir',[
          'ingreso'=>$ingreso,
          'fechaInicio'=>$fechaInicio,
          'fechaFinal'=>$fechaFinal,
          'empresa'=>$empresa
           ]);
        return   $pdf->stream();
  
       
    }
   



     function pdf_get_recibo_ingreso($id){
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
             pedido.calificacion_vehiculo
               from pedido,vehiculo,conductor,usuario 
             WHERE pedido.id_vehiculo=vehiculo.placa 
             AND pedido.id_conductor=conductor.ci 
             AND usuario.id=pedido.id_usuario  
             and pedido.id_ingreso='".$id."'  
             order by pedido.id asc";
              
            
        $pedidos = DB::select($consulta);

        $ingresos = DB::select("SELECT i.*,u.nombre as 'usuario',e.nombre as 'razon_social',
        tp.nombre as 'tipo_ingreso_egreso' 
          from ingreso i, users u,lugar e, tipo_ingreso_egreso tp 
          where e.id=i.id_lugar 
          and i.id_login=u.id 
          and tp.id=i.id_tipo_ingreso_egreso
          and i.id='".$id."'");


             return View('lugar.get_pago_deuda_pdf',['pedidos'=>$pedidos,'ingresos'=>$ingresos]);
              $pdf=\PDF::loadView('lugar.get_pago_deuda_pdf',['pedidos'=>$pedidos,'ingresos'=>$ingresos]);
            //return   $pdf->stream();
              // return redirect('/empresa')->with("message","SE REGISTRO EXITOSAMENTE" );
 
    }
   
      //cancelar Ingreso
function cancelar($id_ingreso){
  $mensaje="No se realizo la cancelación"; 
  $ok=0;
try{
      DB::beginTransaction(); 
      $caja=DB::select("SELECT c.estado from caja c, ingreso g  where g.id_caja=c.id  and g.id=".$id_ingreso); 
      $estado_caja="Abierta";
      foreach ($caja as $key => $value) {
        $estado_caja = $value->estado;
      }
      //Cancelar ingreso
        if($estado_caja=="Abierta"){
          DB::table("ingreso")
          ->whereRaw('id='.$id_ingreso) 
          ->update(['estado'=>'Cancelado',
        'id_usuario_cancelo'=>Auth::user()->id]);
          $mensaje=__('ingreso.cancelado_correctamente');
          $ok=1;
        }else{
          $mensaje=__('ingreso.caja_cerrada_no_cancelar');
        }
        DB::commit();
       self::registrar_bitacora('cancelar_ingreso',$id_ingreso);

       if($ok==1){
        return redirect('/ingreso')->with("message", $mensaje);
       }else{
        return redirect('/ingreso')->with("message-error", $mensaje);
       }

    } catch (Exception $e) {
      DB::rollback();
      self::registrar_bitacora('cancelar_ingreso',$e);
      return redirect('/ingreso')->with("message-error", $mensaje);
    }
 
}

public function registrar_bitacora($titulo,$mensaje){
  //registrar en BITACORA su inicio de sesion.
        try {
              //aqui obtenenos la IP
                  $ip=$_SERVER['REMOTE_ADDR']; //A la variable ip le asignamos la ip remota
              //Aquí le preguntamos por los navegadores más conocidos
                      $navegador=$_SERVER["HTTP_USER_AGENT"];
                          DB::beginTransaction();
                               DB::table('bitacora')->insert([
                                      'id_usuario'=>Auth::user()->id,
                                      'id_empresa'=> Auth::user()->id_empresa ,
                                      'nombre'=> Auth::user()->nombre,
                                      'mensaje'=> $mensaje,
                                      'ip'=> $ip,
                                      'detalle'=>$titulo,
                                      ]);
                                
                                   DB::commit();
                          } catch (Exception $e) { 
                          }
          //FIN DE REGISTRO DE BITACORA
}
}
