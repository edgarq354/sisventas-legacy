<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Libro_diarioController extends Controller
{
    public function __construct() {
         $this->middleware('auth');
    }

    public function index(Request $request){
        $fecha=$request['fecha'];
        $id_usuario=$request['id_usuario'];
        $id_empresa=Auth::user()->id_empresa;

        $usuario=DB::select("SELECT * from users where id_empresa ='".Auth::user()->id_empresa."'");

        if($fecha!=''){
            if($id_usuario!='' && $id_usuario!='no'){
            $egreso=DB::select("SELECT e.*,a.nombre as 'usuario',tp.nombre as 'tipo_egreso' from users a,egreso e,tipo_ingreso_egreso tp where a.id=e.id_login and e.id_tipo_ingreso_egreso=tp.id and date(e.fecha)='".$fecha."' and e.id_login='".$id_usuario."'  ");

              
            $ingreso = DB::select("SELECT i.*,a.nombre as 'usuario',tp.nombre as tipo_ingreso from ingreso i,tipo_ingreso_egreso tp,users a where i.id_tipo_ingreso_egreso=tp.id and a.id=i.id_login and date(i.fecha) ='".$fecha."' and i.id_login='".$id_usuario."'  ");

            $pago_frecuencia=DB::select("SELECT  p.*,c.ci,c.nombre,c.paterno,c.materno,v.codigo_empresa,
                (SELECT count(d.costo_por_frecuencia) from  detalle_frecuencia d where d.id_pago_frecuencia=p.id 
                    group by  d.costo_por_frecuencia) as 'cantidad',ad.usuario as 'usuario' 
            from users ad,pago_frecuencia p,conductor c,vehiculo v
            where c.ci=p.id_conductor and  v.placa=c.id_vehiculo and p.permiso=0 and ad.id=p.id_login 
            and p.id_login='".$id_usuario."' and date(p.fecha) = '".$fecha."' group by id order by id asc");

             $detalle_frecuencia=DB::select("SELECT  df.id_pago_frecuencia,f.numero from detalle_frecuencia df,pago_frecuencia p,
                frecuencia f where df.id_pago_frecuencia=p.id  and f.id=df.id_frecuencia 
                and p.id_login='".$id_usuario."' and date(p.fecha) = '".$fecha."' ");

            }else
            {
                $id_usuario='no';
              $egreso=DB::select("SELECT e.*,a.nombre as 'usuario',tp.nombre as 'tipo_egreso' from users a,egreso e,tipo_ingreso_egreso tp where a.id=e.id_login and e.id_tipo_ingreso_egreso=tp.id and date(e.fecha)='".$fecha."'    ");

               $ingreso = DB::select("SELECT i.*,a.nombre as 'usuario',tp.nombre as tipo_ingreso from ingreso i,tipo_ingreso_egreso tp,users a where i.id_tipo_ingreso_egreso=tp.id and a.id=i.id_login and date(i.fecha) ='".$fecha."'   ");

            $pago_frecuencia=DB::select("SELECT  p.*,c.ci,c.nombre,c.paterno,c.materno,v.codigo_empresa,
                (SELECT count(d.costo_por_frecuencia) from  detalle_frecuencia d where d.id_pago_frecuencia=p.id 
                    group by  d.costo_por_frecuencia) as 'cantidad',ad.usuario as 'usuario' from pago_frecuencia p,conductor c,
            vehiculo v,users ad where  c.ci=p.id_conductor and v.placa=c.id_vehiculo  and p.permiso=0  and ad.id=p.id_login and date(p.fecha) = '".$fecha."' and p.id_empresa='".Auth::user()->id_empresa."' group by id order by id asc");

             $detalle_frecuencia=DB::select("SELECT  df.id_pago_frecuencia,f.numero 
                from detalle_frecuencia df,pago_frecuencia p,frecuencia f where df.id_pago_frecuencia=p.id  and f.id=df.id_frecuencia 
                and date(p.fecha) = '".$fecha."' and p.id_empresa='".Auth::user()->id_empresa."'");
         }

           return view('libro_diario.index',['pago_frecuencia'=>$pago_frecuencia,'detalle_frecuencia'=>$detalle_frecuencia,'ingreso'=>$ingreso,'egreso'=>$egreso ,'usuario'=>$usuario,'id_usuario'=>$id_usuario,'fecha'=>$fecha,'id_empresa'=>$id_empresa]);
        }else 
        {
            $fecha=date('Y-m-j');
            $id_usuario='no';

             $egreso=DB::select("SELECT e.*,a.nombre as 'usuario',tp.nombre as 'tipo_egreso' from users a,egreso e,tipo_ingreso_egreso tp where a.id=e.id_login and e.id_tipo_ingreso_egreso=tp.id and date(e.fecha)='".$fecha."'    ");
  
              $ingreso = DB::select("SELECT i.*,a.nombre as 'usuario',tp.nombre as tipo_ingreso from ingreso i,tipo_ingreso_egreso tp,users a where i.id_tipo_ingreso_egreso=tp.id and a.id=i.id_login and date(i.fecha) ='".$fecha."'   ");

            $pago_frecuencia=DB::select("SELECT  p.*,c.ci,c.nombre,c.paterno,c.materno,v.codigo_empresa,
                (SELECT count(d.costo_por_frecuencia) from  detalle_frecuencia d where d.id_pago_frecuencia=p.id 
                    group by  d.costo_por_frecuencia) as 'cantidad',ad.usuario as 'usuario' from pago_frecuencia p,conductor c,
            vehiculo v,users ad where  c.ci=p.id_conductor and v.placa=c.id_vehiculo  and p.permiso=0  
            and ad.id=p.id_login and date(p.fecha) = '".$fecha."' and p.id_empresa='".Auth::user()->id_empresa."' group by id 
            order by id asc");

             $detalle_frecuencia=DB::select("SELECT  df.id_pago_frecuencia,f.numero from detalle_frecuencia df,pago_frecuencia p,
                frecuencia f where df.id_pago_frecuencia=p.id  and f.id=df.id_frecuencia and date(p.fecha) = '".$fecha."' 
                and p.id_empresa='".Auth::user()->id_empresa."'");

           return view('libro_diario.index',[
            'pago_frecuencia'=>$pago_frecuencia,
            'detalle_frecuencia'=>$detalle_frecuencia,
            'ingreso'=>$ingreso,
            'egreso'=>$egreso,
            'usuario'=>$usuario,
            'id_usuario'=>$id_usuario,
            'fecha'=>$fecha,
            'id_empresa'=>$id_empresa]);

        }

    }


    public function pdf_libro_diario($id_empresa,$id_usuario,$fecha){

        $usuario=DB::select("SELECT * from users where id_empresa ='".$id_empresa."'");

        if($fecha!=''){
            if($id_usuario!='no' && $id_usuario!='' ){
            $egreso=DB::select("SELECT e.*,a.nombre as 'usuario',tp.nombre as 'tipo_egreso' from users a,egreso e,tipo_ingreso_egreso tp where a.id=e.id_login and e.id_tipo_ingreso_egreso=tp.id and date(e.fecha)='".$fecha."' and e.id_login='".$id_usuario."'  ");

              
            $ingreso = DB::select("SELECT i.*,a.nombre as 'usuario',tp.nombre as tipo_ingreso from ingreso i,tipo_ingreso_egreso tp,users a where i.id_tipo_ingreso_egreso=tp.id and a.id=i.id_login and date(i.fecha) ='".$fecha."' and i.id_login='".$id_usuario."'  ");

            $pago_frecuencia=DB::select("SELECT  p.*,c.ci,c.nombre,c.paterno,c.materno,v.codigo_empresa,
                (SELECT count(d.costo_por_frecuencia) from  detalle_frecuencia d where d.id_pago_frecuencia=p.id 
                    group by  d.costo_por_frecuencia) as 'cantidad',ad.usuario as 'usuario' 
            from users ad,pago_frecuencia p,conductor c,vehiculo v
            where c.ci=p.id_conductor and  v.placa=c.id_vehiculo and p.permiso=0 and ad.id=p.id_login 
            and p.id_login='".$id_usuario."' and date(p.fecha) = '".$fecha."' group by id order by id asc");

             $detalle_frecuencia=DB::select("SELECT  df.id_pago_frecuencia,f.numero from detalle_frecuencia df,pago_frecuencia p,
                frecuencia f where df.id_pago_frecuencia=p.id  and f.id=df.id_frecuencia 
                and p.id_login='".$id_usuario."' and date(p.fecha) = '".$fecha."' ");
            }else
            {
             
                $id_usuario='no';
              $egreso=DB::select("SELECT e.*,a.nombre as 'usuario',tp.nombre as 'tipo_egreso' from users a,egreso e,tipo_ingreso_egreso tp where a.id=e.id_login and e.id_tipo_ingreso_egreso=tp.id and date(e.fecha)='".$fecha."'    ");

               $ingreso = DB::select("SELECT i.*,a.nombre as 'usuario',tp.nombre as tipo_ingreso from ingreso i,tipo_ingreso_egreso tp,users a where i.id_tipo_ingreso_egreso=tp.id and a.id=i.id_login and date(i.fecha) ='".$fecha."'   ");

            $pago_frecuencia=DB::select("SELECT  p.*,c.ci,c.nombre,c.paterno,c.materno,v.codigo_empresa,
                (SELECT count(d.costo_por_frecuencia) from  detalle_frecuencia d where d.id_pago_frecuencia=p.id 
                    group by  d.costo_por_frecuencia) as 'cantidad',ad.usuario as 'usuario' from pago_frecuencia p,conductor c,
            vehiculo v,users ad where  c.ci=p.id_conductor and v.placa=c.id_vehiculo  and p.permiso=0  and ad.id=p.id_login and date(p.fecha) = '".$fecha."' and p.id_empresa='".Auth::user()->id_empresa."' group by id order by id asc");

             $detalle_frecuencia=DB::select("SELECT  df.id_pago_frecuencia,f.numero 
                from detalle_frecuencia df,pago_frecuencia p,frecuencia f where df.id_pago_frecuencia=p.id  and f.id=df.id_frecuencia 
                and date(p.fecha) = '".$fecha."' and p.id_empresa='".Auth::user()->id_empresa."'");
         }

           $pdf=\PDF::loadView('libro_diario.pdf_libro_diario',['pago_frecuencia'=>$pago_frecuencia,'detalle_frecuencia'=>$detalle_frecuencia,
            'ingreso'=>$ingreso,'egreso'=>$egreso,  'usuario'=>$usuario,'id_usuario'=>$id_usuario,
            'fecha'=>$fecha,'id_empresa'=>$id_empresa]);
            return   $pdf->stream();
        }else 
        {
            $fecha=date('Y-m-j');

          $egreso=DB::select("SELECT e.*,a.nombre as 'usuario',tp.nombre as 'tipo_egreso' from users a,egreso e,tipo_ingreso_egreso tp where a.id=e.id_login and e.id_tipo_ingreso_egreso=tp.id and date(e.fecha)='".$fecha."'    ");
  
              $ingreso = DB::select("SELECT i.*,a.nombre as 'usuario',tp.nombre as tipo_ingreso from ingreso i,tipo_ingreso_egreso tp,users a where i.id_tipo_ingreso_egreso=tp.id and a.id=i.id_login and date(i.fecha) ='".$fecha."'   ");

            $pago_frecuencia=DB::select("SELECT  p.*,c.ci,c.nombre,c.paterno,c.materno,v.codigo_empresa,
                (SELECT count(d.costo_por_frecuencia) from  detalle_frecuencia d where d.id_pago_frecuencia=p.id 
                    group by  d.costo_por_frecuencia) as 'cantidad',ad.usuario as 'usuario' from pago_frecuencia p,conductor c,
            vehiculo v,users ad where  c.ci=p.id_conductor and v.placa=c.id_vehiculo  and p.permiso=0  
            and ad.id=p.id_login and date(p.fecha) = '".$fecha."' and p.id_empresa='".Auth::user()->id_empresa."' group by id 
            order by id asc");

             $detalle_frecuencia=DB::select("SELECT  df.id_pago_frecuencia,f.numero from detalle_frecuencia df,pago_frecuencia p,
                frecuencia f where df.id_pago_frecuencia=p.id  and f.id=df.id_frecuencia and date(p.fecha) = '".$fecha."' 
                and p.id_empresa='".Auth::user()->id_empresa."'");

        

           $pdf=\PDF::loadView('libro_diario.pdf_libro_diario',[
            'pago_frecuencia'=>$pago_frecuencia,
            'detalle_frecuencia'=>$detalle_frecuencia,
            'ingreso'=>$ingreso,'egreso'=>$egreso,
            'usuario'=>$usuario,
            'id_usuario'=>$id_usuario,
            'fecha'=>$fecha,
            'id_empresa'=>$id_empresa]);
            return   $pdf->stream();

        }

    }


}
