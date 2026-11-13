<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

use App\Http\Requests;  
use App\Ajuste; 
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;



class Pago_frecuenciaController extends Controller
{

  public function __construct() {
         $this->middleware('auth');
    }

    public function index(Request $Request )
    {   
    
    if($Request->isMethod('GET') && $Request['fecha_inicio']!=''){
    $pago_frecuencia = DB::select("SELECT p.id as 'nro',p.numero,date(p.fecha) as 'fecha',v.codigo_empresa,c.numero_movil,p.observaciones,p.retraso,
      concat(c.nombre,' ',c.paterno,' ',c.materno) as 'nombre_conductor',p.monto_frecuencia,p.monto_retraso,p.pro_accidente,p.ahorro,
      p.pro_navidad,p.ahorro,p.monto_total,p.permiso as 'permiso',C.id_vehiculo as 'placa',c.direccion_imagen ,a.nombre as 'usuario'
      FROM pago_frecuencia p,conductor c,vehiculo v,users a WHERE  a.id=p.id_login and v.placa=c.id_vehiculo and p.id_conductor=c.ci 
      and c.id_empresa='".Auth::user()->id_empresa."' and date(p.fecha) BETWEEN '".$Request['fecha_inicio']."' and '".$Request['fecha_fin']."' 
      ORDER by p.id desc ");
   
    
    }else{    
          $pago_frecuencia = DB::select("SELECT p.id as 'nro',p.numero,date(p.fecha) as 'fecha',v.codigo_empresa,c.numero_movil,p.ahorro,p.observaciones,p.retraso,
            concat(c.nombre,' ',c.paterno,' ',c.materno) as 'nombre_conductor',p.monto_frecuencia,p.monto_retraso,a.nombre as 'usuario',
            p.pro_accidente,p.pro_navidad,p.ahorro,p.monto_total,p.permiso as 'permiso',c.id_vehiculo as 'placa',c.direccion_imagen 
            FROM pago_frecuencia p,conductor c,vehiculo v,users a WHERE a.id=p.id_login and v.placa=c.id_vehiculo and c.estado=1 and p.id_conductor=c.ci 
            and c.id_empresa='".Auth::user()->id_empresa."' ORDER by p.id desc limit 80");
    }

      return view('pago_frecuencia.index',["pago_frecuencia"=>$pago_frecuencia]);
    }
    public function create(Request $Request )
    {

      $conductor=DB::select("SELECT ci,nombre,paterno,materno,direccion_imagen,tipo_de_pago, ahorro from conductor 
        where ci='".$Request['ci']."'  ");
        
        $cantidad=0;
        $otras_deudas=0; 
        /*
        SELECT id,
        id_empresa,
        fecha_inicio,
        fecha_fin,
        numero,
        monto,
        tipo,
        monto_retraso_dia*cantidad_dias_multa as monto_frecuencia_multa,
        monto_retraso_dia,
        cantidad_tolerancia_cobro,
        dia_cobro,
        fecha,
        fecha_fin_tolerancia,cantidad_dias_multa 
        from(
        select *,
        if(datediff(fecha,fecha_fin_tolerancia )>0,datediff(fecha,fecha_fin_tolerancia ),0) as 'cantidad_dias_multa' 
        from
        (select *,
        date_add(fecha_fin,interval cantidad_tolerancia_cobro day) AS 'fecha_fin_tolerancia'
        from(
        SELECT f.id,
        f.id_empresa,
        f.fecha_inicio,
        f.fecha_fin,
        f.numero,
        c.monto_frecuencia as 'monto',
        f.tipo,
        0 as 'monto_frecuencia_multa',
        (select a.retraso_dia from ajuste a where a.anio=year(now()) and a.id_empresa=6 limit 1) as 'monto_retraso_dia',
        (select a.cantidad_tolerancia_cobro from ajuste a where a.anio=year(now()) and a.id_empresa=6 limit 1) as 'cantidad_tolerancia_cobro',
        (select a.dia_cobro from ajuste a where a.anio=year(now()) and a.id_empresa=6 limit 1) as 'dia_cobro',
        date(now()) as 'fecha'
        from frecuencia f,conductor c 
        where c.ci='82135291' 
        AND c.id_empresa=6 
        and f.tipo=c.tipo_de_pago 
        and  f.fecha_fin<=date(now()) 
        and f.fecha_inicio>=c.fecha_inicio_pago 
        and f.id not in(SELECT df.id_frecuencia from pago_frecuencia pf,detalle_frecuencia df,conductor c where c.ci=pf.id_conductor and pf.id=df.id_pago_frecuencia and pf.id_conductor='82135291' 
        and c.id_empresa=6 and f.fecha_inicio>=c.fecha_inicio_pago)) tabla )as tabla2)tabla3;
        */    

        foreach ($conductor as $key => $value) {
         
            $frecuencia=DB::select("SELECT id,
            id_empresa,
            fecha_inicio,
            fecha_fin,
            numero,
            monto,
            tipo,
            monto_retraso_dia*cantidad_dias_multa as monto_frecuencia_multa,
            monto_retraso_dia,
            cantidad_tolerancia_cobro,
            dia_cobro,
            fecha,
            fecha_fin_tolerancia,
            cantidad_dias_multa 
            from(
            select *,
            if(datediff(fecha,fecha_fin_tolerancia )>0,datediff(fecha,fecha_fin_tolerancia ),0) as 'cantidad_dias_multa' 
            from
            (select *,
            date_add(fecha_fin,interval cantidad_tolerancia_cobro day) AS 'fecha_fin_tolerancia'
            from(
            SELECT f.id,
            f.id_empresa,
            f.fecha_inicio,
            f.fecha_fin,
            f.numero,
            c.monto_frecuencia as 'monto',
            f.tipo,
            0 as 'monto_frecuencia_multa',
            (select a.retraso_dia from ajuste a where a.anio=year(now()) and a.id_empresa=6 limit 1) as 'monto_retraso_dia',
            (select a.cantidad_tolerancia_cobro from ajuste a where a.anio=year(now()) and a.id_empresa=6 limit 1) as 'cantidad_tolerancia_cobro',
            (select a.dia_cobro from ajuste a where a.anio=year(now()) and a.id_empresa=6 limit 1) as 'dia_cobro',
            date(now()) as 'fecha'
            from frecuencia f,conductor c 
            where c.ci='".$Request['ci']."' 
            AND c.id_empresa='".Auth::user()->id_empresa."'  
            and f.tipo=c.tipo_de_pago 
            and f.fecha_fin<=date_add(now(), interval 5 WEEK) 
            and f.fecha_inicio>=c.fecha_inicio_pago 
            and f.id not in(SELECT df.id_frecuencia from pago_frecuencia pf,detalle_frecuencia df,conductor c where c.ci=pf.id_conductor and pf.id=df.id_pago_frecuencia and pf.id_conductor='".$Request['ci']."' 
            and c.id_empresa='".Auth::user()->id_empresa."' and f.fecha_inicio>=c.fecha_inicio_pago)) tabla )as tabla2) AS tabla3
            ");
             $deudas=DB::select("SELECT sum(monto_pagar) as 'monto' from deuda where id_conductor='".$Request['ci']."'");
             foreach ($deudas as $key => $value) {
               $otras_deudas+=$value->monto;
             }
         
          $cantidad++;
        }

        if($cantidad==0){
          $frecuencia=DB::select("SELECT f.id,f.id_empresa,f.fecha_inicio,f.fecha_fin,f.numero,c.monto_frecuencia as 'monto',f.tipo, 
            '0' as monto_frecuencia_multa from frecuencia f,conductor c where c.ci='".$Request['ci']."' AND c.id_empresa='".Auth::user()->id_empresa."' 
            and f.tipo=c.tipo_de_pago and  f.fecha_fin<=date(now()) and f.fecha_inicio>=c.fecha_inicio_pago 
            and f.id not in(SELECT df.id_frecuencia from pago_frecuencia pf,detalle_frecuencia df,conductor c 
              where c.ci=pf.id_conductor and pf.id=df.id_pago_frecuencia and pf.id_conductor='".$Request['ci']."' 
              and c.id_empresa='".Auth::user()->id_empresa."' and f.fecha_inicio>=c.fecha_inicio_pago )");
        }
        

      $ajuste=DB::select("SELECT * from ajuste where id_empresa='".Auth::user()->id_empresa."' order by anio desc limit 1");

      $buscar_conductor=DB::select("SELECT c.ci,nombre,c.paterno,c.materno,c.numero_movil as 'codigo' FROM conductor c  where    c.id_empresa='".Auth::user()->id_empresa."' GROUP BY c.ci");

      $numero=self::get_ultimo_numero_recibo_interno();
       

      return view('pago_frecuencia.create',["frecuencia"=>$frecuencia,'ajuste'=>$ajuste,'conductor'=>$conductor,'pdf'=>0,'placa'=>'','nro_recibo'=>$numero,'otras_deudas'=>$otras_deudas],compact('buscar_conductor',$buscar_conductor));
    }

    function verificar_deuda_frecuencia($ci){

        $conductor=DB::select("SELECT f.* from frecuencia f, conductor c,detalle_frecuencia df where c.tipo_de_pago=f.tipo 
          and f.fecha_fin<=date(now()) and df.id_frecuencia<>f.id and c.id_empresa='".Auth::user()->id_empresa."' and c.ci='".$ci."'");
        return response($conductor);
    }

    function get_historial_deuda_pdf($ci){
        $frecuencia=DB::select("SELECT f.id,f.id_empresa,f.fecha_inicio,f.fecha_fin,f.numero,c.monto_frecuencia as 'monto',f.tipo 
          from frecuencia f,conductor c where c.ci='".$ci."' and f.tipo=c.tipo_de_pago and  f.fecha_fin<=date(now()) 
          and f.fecha_inicio>=c.fecha_inicio_pago and f.id not in(SELECT df.id_frecuencia 
            from pago_frecuencia pf,detalle_frecuencia df,conductor c where c.ci=pf.id_conductor and pf.id=df.id_pago_frecuencia 
            and pf.id_conductor='".$ci."'  and f.fecha_inicio>=c.fecha_inicio_pago )");

      $conductor=DB::select("SELECT * from conductor where ci='".$ci."'");
      $empresa=DB::select("SELECT e.* from empresa e,conductor c where e.id=c.id_empresa and c.ci='".$ci."'");


        $pdf=\PDF::loadView('pago_frecuencia.get_historial_deuda_pdf',['frecuencia'=>$frecuencia,'conductor'=>$conductor,'empresa'=>$empresa]);
         return   $pdf->stream();
    }
    function historial($ci){
      $conductor=DB::select("SELECT tipo_de_pago from conductor where ci='".$ci."'");
        
        $cantidad=0;

        foreach ($conductor as $key => $value) {

           $pago_frecuencia = DB::select("(SELECT f.numero,f.fecha_inicio,f.fecha_fin,df.costo_por_frecuencia as 'monto',
            pf.id as 'id_pago',pf.permiso as 'permiso',pf.monto_total,pf.fecha,ad.nombre,f.tipo,pf.numero as 'nro_pago' 
            from conductor c,detalle_frecuencia df, frecuencia f,pago_frecuencia pf,users ad  where df.id_pago_frecuencia=pf.id 
            and df.id_frecuencia=f.id and c.ci=pf.id_conductor and year(pf.fecha)=year(now()) and ad.id=pf.id_login and c.ci='".$ci."' 
            and c.id_empresa='".Auth::user()->id_empresa."' ORDER by f.numero DESC) union (SELECT f.numero as 'numero',f.fecha_inicio,
            f.fecha_fin,f.monto as 'monto','','-1','0','','',f.tipo,'' from frecuencia f,conductor c where c.ci='".$ci."' 
            AND c.id_empresa='".Auth::user()->id_empresa."' and f.tipo=c.tipo_de_pago and f.fecha_fin<=date(now()) 
            and f.fecha_inicio>=c.fecha_inicio_pago and f.id not in(SELECT df.id_frecuencia from pago_frecuencia pf,detalle_frecuencia df,
              conductor c where c.ci=pf.id_conductor and pf.id=df.id_pago_frecuencia and pf.id_conductor='".$ci."' 
              and c.id_empresa='".Auth::user()->id_empresa."' and f.fecha_inicio>=c.fecha_inicio_pago )) ORDER by numero asc");
         
          $cantidad++;
        }
        
 
      $conductor=DB::select("SELECT * from conductor where ci='".$ci."'");
        return view('pago_frecuencia.historial',['pago_frecuencia'=>$pago_frecuencia,'conductor'=>$conductor]);
    }

        function historial_conductor_pdf($ci){
        $pago_frecuencia = DB::select("(SELECT f.numero,f.fecha_inicio,f.fecha_fin,df.costo_por_frecuencia as 'monto',
          pf.id as 'id_pago',pf.permiso as 'permiso',pf.monto_total,pf.fecha,ad.nombre,f.tipo,pf.numero as 'nro_pago' 
          from conductor c,detalle_frecuencia df, frecuencia f,pago_frecuencia pf,users ad where df.id_pago_frecuencia=pf.id 
          and df.id_frecuencia=f.id and c.ci=pf.id_conductor and year(pf.fecha)=year(now()) and ad.id=pf.id_login and c.ci='".$ci."' 
          and c.id_empresa='".Auth::user()->id_empresa."' ORDER by f.numero DESC ) union (SELECT f.numero as 'numero',f.fecha_inicio,
          f.fecha_fin,f.monto as 'monto','','-1','0','','',f.tipo,'' from frecuencia f,conductor c where c.ci='".$ci."' 
          AND c.id_empresa='".Auth::user()->id_empresa."' and f.tipo=c.tipo_de_pago and f.fecha_fin<=date(now()) 
          and f.fecha_inicio>=c.fecha_inicio_pago and f.id not in(SELECT df.id_frecuencia from pago_frecuencia pf,detalle_frecuencia df,
            conductor c where c.ci=pf.id_conductor and pf.id=df.id_pago_frecuencia and pf.id_conductor='".$ci."' 
            and c.id_empresa='".Auth::user()->id_empresa."' and f.fecha_inicio>=c.fecha_inicio_pago )) ORDER by numero asc");
 
          $conductor=DB::select("SELECT c.*,e.razon_social,e.nit from conductor c,empresa e where e.id=c.id_empresa AND  c.ci='".$ci."'");
        
       // $pdf=\PDF::loadView('pago_frecuencia.historial_conductor_pdf',['pago_frecuencia'=>$pago_frecuencia,'conductor'=>$conductor]);
       //  return   $pdf->stream();
         return view('pago_frecuencia.historial_conductor_pdf',['pago_frecuencia'=>$pago_frecuencia,'conductor'=>$conductor]);
  
    }

public function existe_numero_recibo($numero)
{
  $existe=false;

   $recibo=DB::select("SELECT f.numero from pago_frecuencia f where  f.id_empresa='".Auth::user()->id_empresa."' and f.numero='".$numero."'");
  foreach ($recibo as $key => $value) {
   $existe=true;
  }
   return $existe;
}

//////////////// P D F
  public function pago_pdf($nro,$placa){ 
  
   $frecuencia=DB::select("SELECT f.* from detalle_frecuencia df, frecuencia f where  f.id=df.id_frecuencia and df.id_pago_frecuencia='".$nro."'");
      $pago_frecuencia=DB::select("SELECT c.numero_movil,c.ci,c.nombre,c.paterno,c.materno,c.expedido,pf.*,c.id_vehiculo as 'placa',v.codigo_empresa,pf.id_login as 'id_login' 
        from conductor c,pago_frecuencia pf,vehiculo v where v.placa=c.id_vehiculo  and pf.permiso=0 and c.ci=pf.id_conductor and pf.id='".$nro."' and v.placa='".$placa."'");
      $empresa=DB::select("SELECT razon_social,nit,direccion,correo,id_imagen_corporativa from empresa where id='".Auth::user()->id_empresa."' ");
      $id_imagen="";
      foreach ($empresa as $key => $value) {
        $id_imagen=$value->id_imagen_corporativa;
      }
      //obtiene el dato del que registro el pago de freciencia.
      $usuario="";
      $nombre_usuario="";
      foreach ($pago_frecuencia as $key => $value) {
        $usuario=DB::select("SELECT nombre from users where id_empresa='".Auth::user()->id_empresa."' and id='".$value->id_login."' limit 1 ");
        foreach ($usuario as $key => $value) {
          $nombre_usuario=$value->nombre;
        }
      }
      
      
      

      $corporativa="";
      $contenido="";
      if($id_imagen!="")
      {
        $corporativa=DB::select("SELECT direccion from foto where id_fotocopia='".$id_imagen."' ");
        foreach ($corporativa as $key => $value) {
        $id_imagen=$value->direccion;
        }
          /*
          if(file_exists($id_imagen))
        {
          $contenido=file_get_contents($id_imagen);
        }
        */
      }

      $ci="";
foreach ($pago_frecuencia as $key => $value) {
         $ci=$value->ci;
        }
//verificar deudas
       $frecuencia_deuda=DB::select("SELECT f.id,f.numero,f.fecha_inicio from frecuencia f,conductor c where c.ci='".$ci."' 
        AND c.id_empresa='".Auth::user()->id_empresa."' and f.tipo=c.tipo_de_pago and  f.fecha_fin<=date(now()) 
        and f.fecha_inicio>=c.fecha_inicio_pago and f.id not in(SELECT df.id_frecuencia from pago_frecuencia pf,
          detalle_frecuencia df,conductor c where c.ci=pf.id_conductor and pf.id=df.id_pago_frecuencia 
          and pf.id_conductor='".$ci."' and c.id_empresa='".Auth::user()->id_empresa."' and f.fecha_inicio>=c.fecha_inicio_pago )");
      
        

   

    //$pdf=\PDF::loadView('pago_frecuencia.pago_pdf',['frecuencia'=>$frecuencia,'pago_frecuencia'=>$pago_frecuencia,'empresa'=>$empresa,'contenido'=>$id_imagen,'deuda_frecuencia'=>$frecuencia_deuda,'usuario'=>$nombre_usuario]);
    return view('pago_frecuencia.pago_pdf',['frecuencia'=>$frecuencia,'pago_frecuencia'=>$pago_frecuencia,'empresa'=>$empresa,'contenido'=>$id_imagen,'deuda_frecuencia'=>$frecuencia_deuda,'usuario'=>$nombre_usuario]);
  //return   $pdf->stream();
  }

    public function detalle($nro,$placa)
    {
      $frecuencia=DB::select("SELECT f.* from detalle_frecuencia df, frecuencia f where  f.id=df.id_frecuencia and df.id_pago_frecuencia='".$nro."'");
      $pago_frecuencia=DB::select("SELECT c.ci,c.nombre,c.paterno,c.materno,c.expedido,pf.* from conductor c,pago_frecuencia pf where c.ci=pf.id_conductor and pf.id='".$nro."'");

      return view('pago_frecuencia.detalle',['frecuencia'=>$frecuencia,'pago_frecuencia'=>$pago_frecuencia]);
    }
public function deudores($nro)
    {
     
      $deudores=DB::select("SELECT c.ci,c.nombre,c.paterno,c.materno,v.codigo_empresa,c.celular,c.direccion_imagen,'-'as 'numero',
        c.tipo_de_pago as 'tipo' from frecuencia f,conductor c,vehiculo v where v.placa=c.id_vehiculo 
        and c.id_empresa='".Auth::user()->id_empresa."' and f.tipo=c.tipo_de_pago and  f.fecha_fin<=date(now()) 
        and f.fecha_inicio>=c.fecha_inicio_pago and c.fecha_fin_pago>=date(now()) and f.id not in(SELECT df.id_frecuencia 
          from pago_frecuencia pf,detalle_frecuencia df,conductor cc where cc.ci=pf.id_conductor and pf.id=df.id_pago_frecuencia 
          and pf.id_conductor=c.ci and cc.id_empresa='".Auth::user()->id_empresa."' and f.fecha_inicio>=c.fecha_inicio_pago ) 
      GROUP BY c.ci,c.nombre,c.paterno,c.materno  order by v.codigo_empresa asc");

      return view('pago_frecuencia.deudores',['deudores'=>$deudores]);
      
    }
    public function buscar_deudores($nro,Request $request)
    {
      $todo=1;
      $dia=0;

      $id_dia=0;
      $id_todo=date('Y-m-j');




       if($nro==1){
     $deudores=DB::select("SELECT c.ci,c.nombre,c.paterno,c.materno,v.codigo_empresa,c.celular,c.direccion_imagen,'-'as'numero',
      c.tipo_de_pago as 'tipo' from frecuencia f,conductor c,vehiculo v where v.placa=c.id_vehiculo 
      and c.id_empresa='".Auth::user()->id_empresa."' and f.tipo=c.tipo_de_pago and  f.fecha_fin<='".$id_todo."' 
      and f.fecha_inicio>=c.fecha_inicio_pago and c.fecha_fin_pago>='".$id_todo."' and f.id not in(SELECT df.id_frecuencia 
        from pago_frecuencia pf,detalle_frecuencia df,conductor cc where cc.ci=pf.id_conductor and pf.id=df.id_pago_frecuencia 
        and pf.id_conductor=c.ci and cc.id_empresa='".Auth::user()->id_empresa."' and f.fecha_inicio>=c.fecha_inicio_pago ) 
     GROUP BY c.ci,c.nombre,c.paterno,c.materno  order by v.codigo_empresa asc");
      }else {
        $fecha="";
        $tipo="";
        $todo=0;
          if($request['todo']){
            $todo=1;
            $id_todo=$request['fecha_todo'];
            $fecha=$id_todo;
          }else if($request['dia']){
            $dia=1;
            $id_dia=$request['buscar_fecha_dia'];
            $fecha=$id_dia;
            $tipo="DIA";

          }

          if($todo==1){
       $deudores=DB::select("SELECT c.ci,c.nombre,c.paterno,c.materno,v.codigo_empresa,c.celular,c.direccion_imagen,'-'as'numero',
        c.tipo_de_pago as 'tipo' from frecuencia f,conductor c,vehiculo v where v.placa=c.id_vehiculo
        and c.id_empresa='".Auth::user()->id_empresa."' and f.tipo=c.tipo_de_pago and  f.fecha_fin<='".$fecha."' 
        and f.fecha_inicio>=c.fecha_inicio_pago and c.fecha_fin_pago>='".$fecha."' and f.id not in(SELECT df.id_frecuencia 
          from pago_frecuencia pf,detalle_frecuencia df,conductor cc where cc.ci=pf.id_conductor and pf.id=df.id_pago_frecuencia 
          and pf.id_conductor=c.ci and cc.id_empresa='".Auth::user()->id_empresa."' and f.fecha_inicio>=c.fecha_inicio_pago ) 
       GROUP BY c.ci,c.nombre,c.paterno,c.materno  order by v.codigo_empresa asc");
      }
      else{
       $fecha_dia=DB::select("SELECT max(id)as 'id_frecuencia' from frecuencia where tipo='".$tipo."' and fecha_fin<='".$fecha."'  ");

     

        $deudores=DB::select("SELECT c.ci,c.nombre,c.paterno,c.materno,c.numero_movil as 'codigo_empresa',c.celular,c.direccion_imagen,(SELECT frec.numero from frecuencia frec where frec.id ='".$fecha_dia[0]->id_frecuencia."')as 'numero',c.tipo_de_pago as'tipo' from  conductor c where c.tipo_de_pago='".$tipo."'  and c.estado_asignacion<2 and c.id_empresa='".Auth::user()->id_empresa."' and c.ci not in(SELECT pf.id_conductor from pago_frecuencia pf,detalle_frecuencia df where c.ci=pf.id_conductor and pf.id=df.id_pago_frecuencia and  df.id_frecuencia='".$fecha_dia[0]->id_frecuencia."' ) GROUP BY c.ci,c.nombre,c.paterno,c.materno order by  codigo_empresa asc");
      }
      }
      
      $fecha_dia=DB::select("SELECT * from frecuencia where tipo='DIA' and fecha_fin<=date(now()) and year(fecha_fin)=year(now()) and id_empresa='".Auth::user()->id_empresa."' order by numero desc ");


      return view('pago_frecuencia.buscar_deudores',['deudores'=>$deudores,'fecha_dia'=>$fecha_dia,'todo'=>$todo,'dia'=>$dia,'id_dia'=>$id_dia,'id_todo'=>$id_todo]);
    }



public function excel_deudores_ultima_frecuencia($cb_todo,$cb_dia,$fecha_todo,$fecha_dia)
    {
      $fecha="";
      $tipo="";
      if($cb_todo==1){
        $fecha=$fecha_todo;


      }else if($cb_dia==1){
        $fecha=$fecha_dia;
        $tipo="DIA";
      }

      if($cb_todo==1){
        $deudores=DB::select("SELECT c.ci,c.nombre,c.paterno,c.materno,v.codigo_empresa,c.celular,c.direccion_imagen,'-'as'numero',
          c.tipo_de_pago as 'tipo',c.monto_frecuencia from frecuencia f,conductor c,vehiculo v where v.placa=c.id_vehiculo 
          and c.id_empresa='".Auth::user()->id_empresa."' and f.tipo=c.tipo_de_pago and  f.fecha_fin<='".$fecha."' 
          and f.fecha_inicio>=c.fecha_inicio_pago and c.fecha_fin_pago>='".$fecha."' and f.id not in(SELECT df.id_frecuencia 
            from pago_frecuencia pf,detalle_frecuencia df,conductor cc where cc.ci=pf.id_conductor and pf.id=df.id_pago_frecuencia 
            and pf.id_conductor=c.ci and cc.id_empresa='".Auth::user()->id_empresa."' and f.fecha_inicio>=c.fecha_inicio_pago ) 
        GROUP BY c.ci,c.nombre,c.paterno,c.materno  order by v.codigo_empresa asc");
      }
      else{
       $fecha_dia=DB::select("SELECT max(id)as 'id_frecuencia' from frecuencia where tipo='".$tipo."' and fecha_fin<='".$fecha."'  ");

     

        $deudores=DB::select("SELECT c.ci,c.nombre,c.paterno,c.materno,c.numero_movil as 'codigo_empresa',c.celular,c.direccion_imagen,(SELECT frec.numero from frecuencia frec where frec.id ='".$fecha_dia[0]->id_frecuencia."')as 'numero',c.tipo_de_pago as'tipo' from  conductor c where c.tipo_de_pago='".$tipo."'  and c.estado_asignacion<2 and c.id_empresa='".Auth::user()->id_empresa."' and c.ci not in(SELECT pf.id_conductor from pago_frecuencia pf,detalle_frecuencia df where c.ci=pf.id_conductor and pf.id=df.id_pago_frecuencia and  df.id_frecuencia='".$fecha_dia[0]->id_frecuencia."' ) GROUP BY c.ci,c.nombre,c.paterno,c.materno order by  codigo_empresa asc");
      }
  


          Excel::create('Lista de deudores',function($excel) use ($deudores){
      $excel->sheet('Deudores', function($sheet) use ($deudores){
        //HEADER
        $sheet->mergeCells('A1:H1');
        $sheet->row(1,['LISTA DE DEUDORES']);
        $sheet->row(5,['Nº','CODIGO','C.I.','NOMBRE','CELULAR','NUMERO','MONTO X F','TIPO DE PAGO']);

        //DATA
$cantidad=0;
$sum_deuda=0;

          foreach($deudores as $conductor){
          $row=[];
          $cantidad++;
          $row[0]=$cantidad;
          $row[1]=$conductor->codigo_empresa;
          $row[2]=$conductor->ci;
          $row[3]=$conductor->nombre." ".$conductor->paterno." ".$conductor->materno;
          $row[4]=$conductor->celular;
          $row[5]=$conductor->numero;
          $row[6]=$conductor->monto_frecuencia;
          $row[7]=$conductor->tipo;
          $sheet->appendRow($row);
          
          $sum_deuda=$sum_deuda+ $conductor->monto_frecuencia;
            
        }  


$sheet->mergeCells('A1:H1');
$sheet->row(2,["Cant. de deudores:".$cantidad]);

$sheet->mergeCells('A1:H1');
$sheet->row(3,["Monto total:".$sum_deuda." Bs"]);


          
              });
             })->export('xls');
    }



public function pdf_deudores_ultima_frecuencia($cb_todo,$cb_dia,$fecha_todo,$fecha_dia)
    {
      $fecha="";
      $tipo="";
      if($cb_todo==1){
        $fecha=$fecha_todo;


      }else if($cb_dia==1){
        $fecha=$fecha_dia;
        $tipo="DIA";
      }
      
      if($cb_todo==1){
        $deudores=DB::select("SELECT c.ci,c.nombre,c.paterno,c.materno,v.codigo_empresa,c.celular,c.direccion_imagen,'-'as'numero',
          c.tipo_de_pago as 'tipo',c.monto_frecuencia from frecuencia f,conductor c,vehiculo v where v.placa=c.id_vehiculo 
          and c.id_empresa='".Auth::user()->id_empresa."' and f.tipo=c.tipo_de_pago and  f.fecha_fin<='".$fecha."' 
          and f.fecha_inicio>=c.fecha_inicio_pago and c.fecha_fin_pago>='".$fecha."' and f.id not in(SELECT df.id_frecuencia 
            from pago_frecuencia pf,detalle_frecuencia df,conductor cc where cc.ci=pf.id_conductor and pf.id=df.id_pago_frecuencia 
            and pf.id_conductor=c.ci and cc.id_empresa='".Auth::user()->id_empresa."' and f.fecha_inicio>=c.fecha_inicio_pago ) 
        GROUP BY c.ci,c.nombre,c.paterno,c.materno  order by v.codigo_empresa asc");
      }
      else{
        $fecha_dia=DB::select("SELECT max(id)as 'id_frecuencia' from frecuencia where tipo='".$tipo."' and fecha_fin<='".$fecha."'  ");

     

        $deudores=DB::select("SELECT c.ci,c.nombre,c.paterno,c.materno,c.numero_movil as 'codigo_empresa',c.celular,c.direccion_imagen,(SELECT frec.numero from frecuencia frec where frec.id ='".$fecha_dia[0]->id_frecuencia."')as 'numero',c.tipo_de_pago as'tipo' from  conductor c where c.tipo_de_pago='".$tipo."'  and c.estado_asignacion<2 and c.id_empresa='".Auth::user()->id_empresa."' and c.ci not in(SELECT pf.id_conductor from pago_frecuencia pf,detalle_frecuencia df where c.ci=pf.id_conductor and pf.id=df.id_pago_frecuencia and  df.id_frecuencia='".$fecha_dia[0]->id_frecuencia."' ) GROUP BY c.ci,c.nombre,c.paterno,c.materno order by  codigo_empresa asc");
      }
      //return view('pago_frecuencia.pdf_deudores_ultima',['deudores'=>$deudores]);
      $pdf=\PDF::loadView('pago_frecuencia.pdf_deudores_ultima',['deudores'=>$deudores]);
     return   $pdf->stream();
    }


    public function buscar_pagos_realizados($nro,Request $request)
    {
       $fecha_dia=DB::select("SELECT * from frecuencia where tipo='DIA' and fecha_fin<=date(now()) and year(fecha_fin)=year(now()) 
        and id_empresa='".Auth::user()->id_empresa."' order by numero desc limit 1 ");


$id_dia=$fecha_dia[0]->id;



        $deudores=DB::select("SELECT c.ci,c.nombre,c.paterno,c.materno,v.codigo_empresa,c.celular,c.direccion_imagen,
          f.numero as 'numero',c.tipo_de_pago as 'tipo',c.monto_frecuencia,'0' as 'nuevo' from detalle_frecuencia df,
          pago_frecuencia pf, frecuencia f,conductor c,vehiculo v where v.placa=c.id_vehiculo 
          and f.tipo=c.tipo_de_pago and pf.id=df.id_pago_frecuencia and pf.id_conductor=c.ci and df.id_frecuencia=f.id 
          and c.id_empresa='".Auth::user()->id_empresa."'  and f.id='".$id_dia."' ");
    
      
      $fecha_dia=DB::select("SELECT * from frecuencia where tipo='DIA' and fecha_fin<=date(now()) and year(fecha_fin)=year(now()) 
        and id_empresa='".Auth::user()->id_empresa."' order by numero desc ");

    
      return view('pago_frecuencia.buscar_pagos_realizados',['deudores'=>$deudores,'fecha_dia'=>$fecha_dia]);
    }

public function excel_pagos_realizados($cb_todo,$cb_dia,$fecha_todo,$fecha_dia)
    {
    }



public function create_pago_general($tipo)
    {
      $frecuencia=DB::select("SELECT f.* from frecuencia f where f.tipo like '".$tipo."' and  f.fecha_fin<=date(now())  
        and f.id_empresa='".Auth::user()->id_empresa."' ");
      $sumatoria=DB::select("SELECT sum(f.monto)as 'monto' from frecuencia f where f.tipo like '".$tipo."' and  f.fecha_fin<=date(now())  
        and f.id_empresa='".Auth::user()->id_empresa."' ");

      $ajuste=DB::select("SELECT * from ajuste where   id_empresa='".Auth::user()->id_empresa."' order by anio desc limit 1");
      

      return view('pago_frecuencia.create_pago_general',['frecuencia'=>$frecuencia,'ajuste'=>$ajuste,'sumatoria'=>$sumatoria,'tipo'=>$tipo]);
    }


    public function store(Request $Request){
       $tipo_de_pago="";
        try {
           DB::beginTransaction();
           $permiso=$Request['permiso'];
          $registrar=false;

             $monto_total=$Request['monto_total'];
             $monto_frecuencia=$Request['monto_frecuencia'];
             $monto_detalle=$Request['monto_detalle'];
             $ahorro=$Request['ahorro'];
             $permiso=$Request['permiso']; 
             $monto_retraso=$Request['monto_retraso'];
             $numero_pago=$Request['numero_pago'];
             $tipo_de_pago=$Request['tipo_de_pago'];
            
             if(self::existe_numero_recibo($numero_pago)==false){
              $registrar=true;
             }
         


           
          
      if($registrar==true){
    
         $id_pago=DB::table('pago_frecuencia')->insertGetId([
          'monto_frecuencia'=>$monto_frecuencia,
          'monto_total'=>$monto_total,
          'monto_retraso'=>$monto_retraso,
          'ahorro'=>$ahorro,
          'observaciones'=>$Request['observaciones'],
          'permiso'=>$permiso,
          'numero'=>$numero_pago,
          'id_conductor'=>$Request['ci'],
          'id_login'=>Auth::user()->id,
          'id_empresa'=>Auth::user()->id_empresa,
          ]);

          
        if($permiso==1){
            $frecuencia=DB::select("SELECT f.* from frecuencia f, conductor c where c.tipo_de_pago=f.tipo and f.fecha_fin<=date(now()) 
              and c.id_empresa='".Auth::user()->id_empresa."' and c.ci='".$Request['ci']."'");
        }else{
             $numero_pago=$Request['numero_pago'];
            $frecuencia=DB::select("SELECT f.* from frecuencia f,conductor c where c.ci='".$Request['ci']."' 
              AND c.id_empresa='".Auth::user()->id_empresa."' and f.tipo=c.tipo_de_pago and f.fecha_fin<=date(now()) 
              and f.fecha_inicio>=c.fecha_inicio_pago and f.id not in(SELECT df.id_frecuencia from pago_frecuencia pf,
                detalle_frecuencia df,conductor c where c.ci=pf.id_conductor and pf.id=df.id_pago_frecuencia 
                and pf.id_conductor='".$Request['ci']."' and c.id_empresa='".Auth::user()->id_empresa."' 
                and f.fecha_inicio>=c.fecha_inicio_pago )");
        }

        $cantidad_registro=0;


         
        foreach ($Request['frecuencia'] as $val) {

          echo $val . ",";  
          DB::table('detalle_frecuencia')->insert([
            'id_frecuencia'=>$val,
            'id_pago_frecuencia'=>$id_pago,
            'costo_por_frecuencia'=>$monto_detalle,
          ]);
          $cantidad_registro++;
      }
/*
           foreach ($frecuencia as $key => $value) {

            if($Request[$value->id]=='1'){
                  DB::table('detalle_frecuencia')->insert([
                    'id_frecuencia'=>$value->id,
                    'id_pago_frecuencia'=>$id_pago,
                    'costo_por_frecuencia'=>$monto_detalle,
                  ]);
                  $cantidad_registro++;
                  
                 }
            }
*/

            if($cantidad_registro==0){
              DB::table('pago_frecuencia')->where('id', $id_pago)->delete();
               return redirect('/pago_frecuencia')->with("message-error","ERROR INTENTE NUEVAMENTE");
            }else{
              $conductor= DB::select("SELECT ahorro from conductor where ci='".$Request['ci']."'");
              $ahorro+=$conductor[0]->ahorro;
               DB::table('conductor')->where('ci', $Request['ci'])->update(['ahorro'=>$ahorro]);
            }


           //REGISTRAR FRECUENCIA DE DIA AL AÑO
            DB::commit();   
          
           
//una ves realizado el pago se genera el PDF
            $nro=$id_pago;
        $frecuencia=DB::select("SELECT f.* from detalle_frecuencia df, frecuencia f where  f.id=df.id_frecuencia and df.id_pago_frecuencia='".$nro."'");

          
      $pago_frecuencia=DB::select("SELECT c.ci,c.nombre,c.paterno,c.materno,c.expedido,pf.*,c.id_vehiculo as 'placa',v.codigo_empresa 
        from conductor c,pago_frecuencia pf,vehiculo v where v.placa=c.id_vehiculo  and c.ci=pf.id_conductor and pf.id='".$nro."'");
      $empresa=DB::select("SELECT razon_social,nit,direccion,correo,id_imagen_corporativa from empresa where id='".Auth::user()->id_empresa."' ");
      $id_imagen="";
      foreach ($empresa as $key => $value) {
        $id_imagen=$value->id_imagen_corporativa;
      }
     
      $usuario="";
      $nombre_usuario="";
      $placa="";
      foreach ($pago_frecuencia as $key => $value) {
        $usuario=DB::select("SELECT nombre from users where id_empresa='".Auth::user()->id_empresa."' and id='".$value->id_login."' limit 1 ");
        $placa=$value->placa;
        
        foreach ($usuario as $key => $value) {
          $nombre_usuario=$value->nombre;
        }
        
      }

       $corporativa="";
      $contenido="";
      if($id_imagen!="")
      {
        $corporativa=DB::select("SELECT direccion from foto where id_fotocopia='".$id_imagen."' ");
        foreach ($corporativa as $key => $value) {
        $id_imagen=$value->direccion;
        }

          if(file_exists($id_imagen))
        {
          $contenido=file_get_contents($id_imagen);
        }
      }

      $frecuencia_deuda=DB::select("SELECT f.id,f.numero from frecuencia f,conductor c where c.ci='".$Request['ci']."' 
        AND c.id_empresa='".Auth::user()->id_empresa."' and f.tipo=c.tipo_de_pago and  f.fecha_fin<=date(now()) 
        and f.fecha_inicio>=c.fecha_inicio_pago and f.id not in(SELECT df.id_frecuencia 
          from pago_frecuencia pf,detalle_frecuencia df,conductor c where c.ci=pf.id_conductor and pf.id=df.id_pago_frecuencia 
          and pf.id_conductor='".$Request['ci']."' and c.id_empresa='".Auth::user()->id_empresa."' and f.fecha_inicio>=c.fecha_inicio_pago )");


//PREPARA LOS DATOS PARA ENVIAR LAS NOTIFICAIONES.
      $str_frecuencia="";
      foreach ($frecuencia as $key => $value) {
           $str_frecuencia.=$value->fecha_inicio.",";
          }
          if($permiso==1){
             Session::flash('message','SU PERMISO SE REGISTRO CORRECTAMENTE');
            self::enviar_notificacion($Request['ci'],'Señor Conductor: Su permiso se ha realizado correctamente.  Gracias por contribuir con la Empresa.  Seguiremos trabajando.');
           }else{
             Session::flash('message','EL PAGO DE FRECUENCIA SE REGISTRO CORRECTAMENTE');
              self::enviar_notificacion($Request['ci'],'Señor Conductor: Su pago de frecuencia se ha realizado correctamente. Nro de Recibo:'.$numero_pago.'. Nro de Frecuencia:'.$str_frecuencia.'.  Gracias por contribuir con la Empresa.  Seguiremos trabajando.');
             
           }  
//FIN DEL ENVIO DE NOTIFICACIONES A LOS CELULARES.



    //$pdf=\PDF::loadView('pago_frecuencia.pago_pdf',['frecuencia'=>$frecuencia,'pago_frecuencia'=>$pago_frecuencia,'empresa'=>$empresa,'contenido'=>$id_imagen,'deuda_frecuencia'=>$frecuencia_deuda,'usuario'=>$nombre_usuario]);
   // return   $pdf->stream();
    //return view('pago_frecuencia.pago_pdf',['frecuencia'=>$frecuencia,'pago_frecuencia'=>$pago_frecuencia,'empresa'=>$empresa,'contenido'=>$id_imagen,'deuda_frecuencia'=>$frecuencia_deuda]);
//finalizacion del pago de PDF



    $frecuencia=DB::select("SELECT f.id,f.id_empresa,f.fecha_inicio,f.fecha_fin,f.numero,c.monto_frecuencia as 'monto',f.tipo 
      from frecuencia f,conductor c where c.ci='".$Request['ci']."' AND c.id_empresa='".Auth::user()->id_empresa."' 
      and f.tipo=c.tipo_de_pago and  f.fecha_fin<=date(now()) and f.fecha_inicio>=c.fecha_inicio_pago 
      and f.id not in(SELECT df.id_frecuencia from pago_frecuencia pf,detalle_frecuencia df,conductor c where c.ci=pf.id_conductor 
        and pf.id=df.id_pago_frecuencia and pf.id_conductor='".$Request['ci']."' and c.id_empresa='".Auth::user()->id_empresa."' 
        and f.fecha_inicio>=c.fecha_inicio_pago)");

      $conductor=DB::select("SELECT * from conductor where ci='".$Request['ci']."' ");
      $ajuste=DB::select("SELECT * from ajuste where id_empresa='".Auth::user()->id_empresa."' order by anio desc limit 1");
      $buscar_conductor=DB::select("SELECT c.ci,c.nombre,c.paterno,c.materno,v.codigo_empresa as 'codigo',c.tipo_de_pago 
        FROM conductor c,vehiculo v where v.placa=c.id_vehiculo and c.id_empresa='".Auth::user()->id_empresa."' GROUP BY c.ci");

       $otras_deudas=0;
         $deudas=DB::select("SELECT sum(monto_pagar) as 'monto' from deuda where id_conductor='".$Request['ci']."'");
             foreach ($deudas as $key => $value) {
               $otras_deudas+=$value->monto;
             }

      if($permiso==1){
      return view('pago_frecuencia.create',["frecuencia"=>$frecuencia,'ajuste'=>$ajuste,'conductor'=>$conductor,'pdf'=>0,'placa'=>$placa,'nro_recibo'=>$nro,'otras_deudas'=>$otras_deudas],compact('buscar_conductor',$buscar_conductor));
      }else if($permiso==0){
      return view('pago_frecuencia.create',["frecuencia"=>$frecuencia,'ajuste'=>$ajuste,'conductor'=>$conductor,'pdf'=>1,'placa'=>$placa,'nro_recibo'=>$nro,'otras_deudas'=>$otras_deudas],compact('buscar_conductor',$buscar_conductor));
    }else{
      return redirect('/pago_frecuencia')->with("message-error","ERROR INTENTE NUEVAMENTE");
    }

          //  return redirect::to('/pago_frecuencia'); 
  }
  else
  {
     return redirect('/pago_frecuencia/create')->with("message-error","El número de recibo ya existe.");
  }
    } catch (Exception $e) {
          DB::rollback();
          return redirect('/pago_frecuencia')->with("message-error","ERROR INTENTE NUEVAMENTE");      
        }
   
    }


    public function store_pago_general(Request $Request){
       $total=0;
       $registrado=0; 
     
         $verificar=DB::select("SELECT id_conductor as ci from vehiculo v,conductor c WHERE c.id_vehiculo=v.placa and c.tipo_de_pago like '".$Request['tipo']."' and c.id_empresa='".Auth::user()->id_empresa."'");
        foreach ($verificar as $conductor => $cond) {
   
   try {
        DB::beginTransaction();
         $id_pago=DB::table('pago_frecuencia')->insertGetId([
          'monto_frecuencia'=>$Request['monto_frecuencia'],
          'monto_total'=>$Request['monto_total'],
          'monto_retraso'=>$Request['monto_retraso'],
          'pro_navidad'=>$Request['pro_navidad'],
          'pro_accidente'=>$Request['pro_accidente'],
          'ahorro'=>$Request['ahorro'],
          'observaciones'=>$Request['observaciones'],
          'permiso'=>$Request['permiso'],
          'id_conductor'=>$cond->ci,
          'id_login'=>Auth::user()->id,
          ]);

          
    

          $frecuencia=DB::select("SELECT f.* from frecuencia f, conductor c where c.tipo_de_pago=f.tipo and f.fecha_fin<=date(now()) and c.id_empresa='".Auth::user()->id_empresa."' and c.ci='".$cond->ci."'");
           foreach ($frecuencia as $key => $value) {

            if($Request[$value->id]=='1'){
                  DB::table('detalle_frecuencia')->insert([
            'id_frecuencia'=>$value->id,
            'id_pago_frecuencia'=>$id_pago,
            ]);
                 }
            }
           //REGISTRAR FRECUENCIA DE DIA AL AÑO
              DB::commit(); 
              $registrado+=1;

            } catch (Exception $e) {
             DB::rollback();
            }

            $total+=1;
            }

               if($total==$registrado)
               {
                 Session::flash('message','Los Pagos de Frecuencia se registraron correctamente '.$registrado."/".$total);
                 return redirect::to('/pago_frecuencia'); 
               }
               else
               {
                 return redirect('/pago_frecuencia')->with("message-error","ERROR INTENTE NUEVAMENTE");      
               }
    }
       public function show($id){
       return "hshow";  
    }

    public function get_cobro_frecuencia_semana(){
            $ingreso=DB::select("SELECT date(fecha)as 'fecha_dia',sum(monto_total) as 'monto' from pago_frecuencia where date(fecha) BETWEEN date_add(NOW(), INTERVAL -12 DAY) and date(now()) and id_empresa='".Auth::user()->id_empresa."' and permiso='0' group by  fecha_dia");
        return response($ingreso);
      }

   public function get_ultimo_numero_recibo(){
    $numero=DB::select("SELECT max(numero) as numero from pago_frecuencia where id_empresa='".Auth::user()->id_empresa."'");
    $num=0;


    foreach ($numero as $key => $value) {
      $num=$value->numero;
    }
    $num+=1;

     $ajuste=DB::select("SELECT anio,numero_inicio_recibo from ajuste where id_empresa='".Auth::user()->id_empresa."' order by anio desc ");
      $numero_inicio=$ajuste[0]->numero_inicio_recibo;


    if($num<$numero_inicio){
     $num=$numero_inicio;
    }

    $numero = array('numero' => $num);
    return response($numero);
   }   

      public function get_ultimo_numero_recibo_interno(){
    $numero=DB::select("SELECT max(numero) as numero from pago_frecuencia where id_empresa='".Auth::user()->id_empresa."'");
    $num=0;


    foreach ($numero as $key => $value) {
      $num=$value->numero;
    }
    $num+=1;

     $ajuste=DB::select("SELECT anio,numero_inicio_recibo from ajuste where id_empresa='".Auth::user()->id_empresa."' order by anio desc ");
      $numero_inicio=$ajuste[0]->numero_inicio_recibo;


    if($num<$numero_inicio){
     $num=$numero_inicio;
    }

    $numero =$num;
    return $numero;
   } 

    public function enviar_notificacion($ci_conductor,$mensaje)
    {   
        $conductor=DB::select("SELECT c.ci,c.nombre,c.paterno,c.materno,c.token from conductor c where c.ci='".$ci_conductor."'");
       
        $tokens = array();
        
        foreach ($conductor as $key => $value) {
           array_push($tokens, $value->token);  
              $mPushNotification = getPush('Info',$mensaje,null,"taxi","","","0","0","6");
               $sw_notificacion=send($tokens,$mPushNotification);
     }
    }

}
