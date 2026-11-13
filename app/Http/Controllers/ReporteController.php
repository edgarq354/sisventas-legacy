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


class ReporteController extends Controller
{
    public function __construct() {
         $this->middleware('auth');
    }
    public function index(Request $Request)
    {
      if($Request['fecha_inicio']!='' && $Request['fecha_fin']!=''){
          if($Request['id_conduc']!='' && $Request['id_usu']!=''){
          // $cobro=DB::select("SELECT u.nombre as usuario,c.ci,c.nombre,c.paterno,c.materno,a.codigo_empresa ,p.fecha,p.*,(select count(d.id_pago_frecuencia) from detalle_frecuencia d where d.id_pago_frecuencia=p.id )as cantidad  from users u, pago_frecuencia p, conductor c,asignacion a where u.id_empresa='".Auth::user()->id_empresa."' and p.id_conductor=c.ci and c.ci=a.id_conductor and p.id_login=u.id and u.id='".$Request['id_usu']."' and c.ci='".$Request['id_conduc']."' and p.fecha between '".$Request['fecha_inicio']."' and '".$Request['fecha_fin']."'  order by p.id desc limit 500" ); 
          }
          else if($Request['id_conduc']!=''){
          // $cobro=DB::select("SELECT u.nombre as usuario,c.ci,c.nombre,c.paterno,c.materno,a.codigo_empresa ,p.fecha,p.*,(select count(d.id_pago_frecuencia) from detalle_frecuencia d where d.id_pago_frecuencia=p.id )as cantidad  from users u, pago_frecuencia p, conductor c,asignacion a where u.id_empresa='".Auth::user()->id_empresa."' and p.id_conductor=c.ci and c.ci=a.id_conductor and p.id_login=u.id and c.ci='".$Request['id_conduc']."' and p.fecha between '".$Request['fecha_inicio']."' and '".$Request['fecha_fin']."'  order by p.id desc limit 500" ); 
          }else if($Request['id_usu']!=''){
          // $cobro=DB::select("SELECT u.nombre as usuario,c.ci,c.nombre,c.paterno,c.materno,a.codigo_empresa ,p.fecha,p.*,(select count(d.id_pago_frecuencia) from detalle_frecuencia d where d.id_pago_frecuencia=p.id )as cantidad  from users u, pago_frecuencia p, conductor c,asignacion a where u.id_empresa='".Auth::user()->id_empresa."' and p.id_conductor=c.ci and c.ci=a.id_conductor and p.id_login=u.id and u.id='".$Request['id_usu']."' and p.fecha between '".$Request['fecha_inicio']."' and '".$Request['fecha_fin']."'  order by p.id desc limit 500" );  
          }
          else
          {
           //  $cobro=DB::select("SELECT u.nombre as usuario,c.ci,c.nombre,c.paterno,c.materno,a.codigo_empresa ,p.fecha,p.*,(select count(d.id_pago_frecuencia) from detalle_frecuencia d where d.id_pago_frecuencia=p.id )as cantidad  from users u, pago_frecuencia p, conductor c,asignacion a where u.id_empresa='".Auth::user()->id_empresa."' and p.id_conductor=c.ci and c.ci=a.id_conductor and p.id_login=u.id  and p.fecha between '".$Request['fecha_inicio']."' and '".$Request['fecha_fin']."'  order by p.id desc limit 500" ); 
          }
        
      }
      else
      {
       // $cobro=DB::select("SELECT u.nombre as usuario,c.ci,c.nombre,c.paterno,c.materno,a.codigo_empresa ,p.fecha,p.*,(select count(d.id_pago_frecuencia) from detalle_frecuencia d where d.id_pago_frecuencia=p.id )as cantidad  from users u, pago_frecuencia p, conductor c,asignacion a where u.id_empresa='".Auth::user()->id_empresa."' and p.id_conductor=c.ci and c.ci=a.id_conductor and p.id_login=u.id order by p.id desc limit 500" );
      }


             $usuario=DB::select("SELECT * from users where id_empresa='".Auth::user()->id_empresa."'");
              $conductor=DB::select("SELECT c.nombre,c.paterno,c.materno,c.ci as 'ci',a.codigo_empresa from conductor c,asignacion a where c.ci=a.id_conductor and a.id_empresa='".Auth::user()->id_empresa."' order by c.nombre asc");

    return view('reporte.index',['usuario'=>$usuario,'conductor'=>$conductor]);


    }
    public function create()
    {
      return view('reporte.index');
    }
    public function update()
    {
      return view('reporte.index');
    }
    public function conductor_mas_carreras(Request $Request)
    {
        if($Request['fecha_inicio']!='' && $Request['fecha_fin']!=''){
          $carrera=DB::select("(SELECT count(ca.id_conductor) as 'cantidad',ca.id_conductor,c.nombre,c.paterno,c.materno,c.numero_movil as 'codigo_empresa' FROM pedido ca,conductor c where c.ci=ca.id_conductor and ca.estado=2 group by id_conductor)UNION (SELECT count(ca.id_conductor) as 'cantidad',ca.id_conductor,c.nombre,c.paterno,c.materno,c.numero_movil as 'codigo_empresa' FROM pedido ca,conductor c where c.ci=ca.id_conductor and ca.estado=2 and ca.fecha_pedido between '".$Request['fecha_inicio']."' and '".$Request['fecha_fin']."' group by id_conductor)" ); 
        }
        else
        {
      $carrera=DB::select("(SELECT count(ca.id_conductor) as 'cantidad',ca.id_conductor,c.nombre,c.paterno,c.materno,c.numero_movil as 'codigo_empresa'  FROM pedido ca,conductor c  where c.ci=ca.id_conductor   and ca.estado=2 group by id_conductor)UNION (SELECT count(ca.id_conductor) as 'cantidad',ca.id_conductor,c.nombre,c.paterno,c.materno,c.numero_movil as 'codigo_empresa' FROM pedido ca,conductor c  where c.ci=ca.id_conductor   and ca.estado=2 group by id_conductor)" );
            }
    

      return view("reporte.conductor_mas_carreras",['carrera'=>$carrera]);
      }

       public function buscar_cobro(Request $Request)
    {
      return "cass";
      }

     public function vehiculos_pdf(){ 
   $vehiculo=DB::select("SELECT * from vehiculo where  id_empresa='".Auth::user()->id_empresa."' ORDER BY marca ASC");
   $empresa=DB::select("SELECT * from empresa where id='".Auth::user()->id_empresa."'");
   $usuario=DB::select("SELECT * from users where id='".Auth::user()->id."' and id_empresa='".Auth::user()->id_empresa."'");

    $pdf=\PDF::loadView('reporte.vehiculos_pdf',['vehiculo'=>$vehiculo,'empresa'=>$empresa,'usuario'=>$usuario]);
    return  $pdf->stream();
  }

     

     public function conductores_pdf(){ 
   $conductor=DB::select("SELECT * from conductor where id_empresa='".Auth::user()->id_empresa."' ORDER BY  nombre ASC");
   $empresa=DB::select("SELECT * from empresa where id='".Auth::user()->id_empresa."'");
   $usuario=DB::select("SELECT * from users where id='".Auth::user()->id."' and id_empresa='".Auth::user()->id_empresa."'");

    $pdf=\PDF::loadView('reporte.conductores_pdf',['conductor'=>$conductor,'empresa'=>$empresa,'usuario'=>$usuario]);
    return   $pdf->stream();
  }
     public function asignaciones_pdf(){ 
   
   $asignacion=DB::select("SELECT c.ci,c.expedido,c.nombre,c.paterno,c.materno,c.celular,a.codigo_empresa,v.placa,v.modelo,v.marca,v.tipo from asignacion a,conductor c, vehiculo v where a.id_vehiculo=v.placa and a.id_conductor=c.ci and a.id_empresa='".Auth::user()->id_empresa."' ORDER BY a.codigo_empresa ASC");

   $empresa=DB::select("SELECT * from empresa where id='".Auth::user()->id_empresa."'");
   $usuario=DB::select("SELECT * from users where id='".Auth::user()->id."' and id_empresa='".Auth::user()->id_empresa."'");

    $pdf=\PDF::loadView('reporte.asignaciones_pdf',['asignacion'=>$asignacion,'empresa'=>$empresa,'usuario'=>$usuario]);
    return   $pdf->stream();
  }
   


   public function vehiculos_excel(){ 
  

     Excel::create('Reporte de Vehiculos',function($excel){
      $excel->sheet('Vehiculo', function($sheet){
        //HEADER
        $sheet->mergeCells('A1:H1');
        $sheet->row(1,['LISTA DE VEHICULOS REGISTRADOS']);
        $sheet->row(2,['NRO','PLACA','MARCA','TIPO','COLOR','MODELO','C.I. PROPIETARIO','FECHA DE REGISTRO']);

        //DATA
        $vehiculo=DB::select("SELECT * from vehiculo where  id_empresa='".Auth::user()->id_empresa."' ORDER BY marca ASC");
$cant=1;
          foreach($vehiculo as $pago){
          $row=[];
          $row[0]=$cant;
          $row[1]=$pago->placa;
          $row[2]=$pago->marca;
          $row[3]=$pago->tipo;
          $row[4]=$pago->color;
          $row[5]=$pago->modelo;
          $row[6]=$pago->id_propietario;
          $row[7]=$pago->fecha_registrado;
          $sheet->appendRow($row);
          $cant++;
        }
             
              });
             })->export('xls');
    }

       public function conductores_excel(){ 
  

     Excel::create('Reporte de Conductores',function($excel){
      $excel->sheet('Conductores', function($sheet){
        //HEADER
        $sheet->mergeCells('A1:H1');
        $sheet->row(1,['LISTA DE CONDUCTORES REGISTRADOS']);
        $sheet->row(2,['NRO','CI','NOMBRE Y APELLIDO','CELULAR','DIRECCION','CATEGORIA','TIPO DE PAGO','FECHA DE REGISTRO']);

        //DATA
   $conductor=DB::select("SELECT * from conductor where id_empresa='".Auth::user()->id_empresa."' ORDER BY  nombre ASC");
        
$cant=1;
          foreach($conductor as $pago){
          $row=[];
          $row[0]=$cant;
          $row[1]=$pago->ci." ".$pago->expedido;
          $row[2]=$pago->nombre." ".$pago->paterno." ".$pago->materno;
          $row[3]=$pago->celular;
          $row[4]=$pago->direccion;
          $row[5]=$pago->categoria_licencia;
          $row[6]=$pago->tipo_de_pago;
          $row[7]=$pago->fecha_registro;
          $sheet->appendRow($row);
          $cant++;
        }
             
              });
             })->export('xls');
   }

  

       public function asignaciones_excel(){ 
  

     Excel::create('Reporte de Vehiculos',function($excel){
      $excel->sheet('Vehiculo', function($sheet){
        //HEADER
        $sheet->mergeCells('A1:H1');
        $sheet->row(1,['LISTA DE CONDUCTORES ASIGNADOS ']);
        $sheet->row(2,['NRO','CODIGO','C.I.','CONDUCTOR','CELULAR','PLACA','MARCA','MODELO']);

        //DATA
      //  $asignacion=DB::select("SELECT c.ci,c.expedido,c.nombre,c.paterno,c.materno,c.celular,a.codigo_empresa,v.placa,v.modelo,v.marca,v.tipo from asignacion a,conductor c, vehiculo v where a.id_vehiculo=v.placa and a.id_conductor=c.ci and a.id_empresa='".Auth::user()->id_empresa."' ORDER BY a.codigo_empresa ASC");

if(Auth::user()->privilegio==1){
          //ADMINISTRADOR DE TOD
        $asignacion=DB::table('asignacion')
        ->join('conductor','conductor.ci','=','asignacion.id_conductor')
        ->join('vehiculo','vehiculo.placa','=','asignacion.id_vehiculo')
        ->join('empresa','empresa.id','=','asignacion.id_empresa')
        ->select('asignacion.id_conductor', 'conductor.expedido', 'conductor.nombre','conductor.paterno','conductor.materno','conductor.celular', 'asignacion.id_vehiculo','vehiculo.placa','vehiculo.marca', 'vehiculo.clase' ,'vehiculo.modelo','vehiculo.tipo','asignacion.id_empresa','empresa.nit','empresa.razon_social','asignacion.codigo_empresa','asignacion.estado')
        ->orderby('empresa.razon_social')       
        ->get();
    return view('asignacion.administrador.index',["asignacion"=>$asignacion]);        

        }elseif(Auth::user()->privilegio==10){
          //FEDERACION
        $asignacion=DB::table('asignacion AS a')
        ->join('conductor AS c','c.ci','=','a.id_conductor')
        ->join('vehiculo AS v','v.placa','=','a.id_vehiculo')
        ->join('empresa AS e','e.id','=','a.id_empresa')
        ->join('empresa AS aso','aso.id','=','e.id_asociacion')
        ->where('aso.id_asociacion','=',Auth::user()->id_empresa)
        ->select('a.id_conductor', 'c.expedido', 'c.nombre','c.paterno','c.materno','c.celular', 'a.id_vehiculo','v.placa','v.marca', 'v.clase' ,'v.modelo','v.tipo','a.id_empresa','e.nit','e.razon_social','a.codigo_empresa','a.estado')
        ->orderby('e.razon_social')          
        ->get();
      return view('asignacion.administrador.index',["asignacion"=>$asignacion]);        

        }elseif(Auth::user()->privilegio==11){
          //ASOCIACION
        
        $asignacion=DB::table('asignacion')
        ->join('conductor','conductor.ci','=','asignacion.id_conductor')
        ->join('vehiculo','vehiculo.placa','=','asignacion.id_vehiculo')
        ->join('empresa','empresa.id','=','asignacion.id_empresa')
        ->where('empresa.id_asociacion','=',Auth::user()->id_empresa)
        ->select('asignacion.id_conductor', 'conductor.expedido', 'conductor.nombre','conductor.paterno','conductor.materno','conductor.celular', 'asignacion.id_vehiculo','vehiculo.marca', 'vehiculo.clase' ,'vehiculo.modelo','vehiculo.tipo','asignacion.id_empresa','empresa.nit','empresa.razon_social','asignacion.codigo_empresa','asignacion.estado')
        ->orderby('empresa.razon_social')         
        ->get();
    return view('asignacion.administrador.index',["asignacion"=>$asignacion]);        


    }elseif(Auth::user()->privilegio==12){
          //POLICIA
        
        $asignacion=DB::table('asignacion')
        ->join('conductor','conductor.ci','=','asignacion.id_conductor')
        ->join('vehiculo','vehiculo.placa','=','asignacion.id_vehiculo')
        ->join('empresa','empresa.id','=','asignacion.id_empresa')
        ->where('empresa.id_asociacion','=',Auth::user()->id_empresa)
        ->select('asignacion.id_conductor', 'conductor.expedido', 'conductor.nombre','conductor.paterno','conductor.materno','conductor.celular', 'asignacion.id_vehiculo','vehiculo.placa','vehiculo.marca', 'vehiculo.clase' ,'vehiculo.modelo','vehiculo.tipo','asignacion.id_empresa','empresa.nit','empresa.razon_social','asignacion.codigo_empresa','asignacion.estado')
        ->orderby('empresa.razon_social')        
        ->get();
    return view('asignacion.policia.index',["asignacion"=>$asignacion]);        


    } else {
        $asignacion=DB::table('asignacion')
        ->join('conductor','conductor.ci','=','asignacion.id_conductor')
        ->join('vehiculo','vehiculo.placa','=','asignacion.id_vehiculo')
        ->join('empresa','empresa.id','=','asignacion.id_empresa')
        ->select('asignacion.id_conductor', 'conductor.expedido','conductor.nombre','conductor.paterno','conductor.materno','conductor.celular', 'asignacion.id_vehiculo','vehiculo.placa','vehiculo.marca', 'vehiculo.clase' ,'vehiculo.modelo','vehiculo.tipo','asignacion.id_empresa','empresa.nit','empresa.razon_social','asignacion.codigo_empresa','asignacion.estado')
        ->where('asignacion.id_empresa', Auth::user()->id_empresa)
        ->orderby('conductor.nombre')
        ->get();
    return view('asignacion.index',["asignacion"=>$asignacion]);        

    }




$cant=1;
          foreach($asignacion as $pago){
          $row=[];
          $row[0]=$cant;
          $row[1]=$pago->codigo_empresa;
          $row[2]=$pago->ci." ".$pago->expedido;
          $row[3]=$pago->nombre." ".$pago->paterno." ".$pago->materno;
          $row[4]=$pago->celular;
          $row[5]=$pago->placa;
          $row[6]=$pago->marca;
          $row[7]=$pago->modelo;
          $sheet->appendRow($row);
          $cant++;
        }             
              });
             })->export('xls');
    }



    public function show()
    {
      return "error";
    }


    public function conductor_con_mas_servicios(){
      $conductor=DB::select("SELECT c.ci,c.expedido,c.nombre,c.paterno,c.materno,c.numero_movil,c.celular,c.categoria_licencia,c.credito,(SELECT count(*) from pedido p where year(p.fecha_pedido)=year(now()) and p.estado=2 and p.id_conductor=c.ci) as 'cantidad' from conductor c");

       $fechas = DB::select("SELECT date(DATE_SUB(curdate(), INTERVAL + 29 DAY)) as fecha_inicio, date(now()) as fecha_fin");   

      return View("reporte.conductor_con_mas_servicios",["conductor"=>$conductor,'fechas'=>$fechas]);
    }
    public function conductor_con_mas_servicios_2(Request $request){
       $fecha_inicio=$request['fecha_inicio'];
        $fecha_fin=$request['fecha_fin'];
       $conductor=DB::select("SELECT c.ci,c.expedido,c.nombre,c.paterno,c.materno,c.numero_movil,c.celular,c.categoria_licencia,c.credito,(SELECT count(*) from pedido p where date(p.fecha_pedido)>=date('".$fecha_inicio."') and date(p.fecha_pedido)<= date('".$fecha_fin."') and p.estado=2 and p.id_conductor=c.ci) as 'cantidad' from conductor c");

        $fechas = DB::select("SELECT date('".$fecha_inicio."') as fecha_inicio, date('".$fecha_fin."') as fecha_fin");   

      return View("reporte.conductor_con_mas_servicios",["conductor"=>$conductor,'fechas'=>$fechas]);
    }

    public function pasajero_con_mas_servicios(){
      $pasajero=DB::select("SELECT u.direccion_imagen,u.nombre,u.apellido,u.celular,u.correo,u.fecha_registro,(SELECT count(*) from pedido p where year(p.fecha_pedido)=year(now()) and p.estado=2 and p.id_usuario=u.id) as 'cantidad' from usuario u");

       $fechas = DB::select("SELECT date(DATE_SUB(curdate(), INTERVAL + 29 DAY)) as fecha_inicio, date(now()) as fecha_fin");   

      return View("reporte.pasajero_con_mas_servicios",["pasajero"=>$pasajero,'fechas'=>$fechas]);
    }

    public function pasajero_con_mas_servicios_2(Request $request){
       $fecha_inicio=$request['fecha_inicio'];
        $fecha_fin=$request['fecha_fin'];

       $pasajero=DB::select("SELECT u.direccion_imagen,u.nombre,u.apellido,u.celular,u.correo,u.fecha_registro,(SELECT count(*) from pedido p where date(p.fecha_pedido)>=date('".$fecha_inicio."') and date(p.fecha_pedido)<= date('".$fecha_inicio."') and p.estado=2 and p.id_usuario=u.id) as 'cantidad' from usuario u");

        $fechas = DB::select("SELECT date('".$fecha_inicio."') as fecha_inicio, date('".$fecha_fin."') as fecha_fin");   

      return View("reporte.pasajero_con_mas_servicios",["pasajero"=>$pasajero,'fechas'=>$fechas]);
    }

     public function conductor_con_mas_cancelacion(){
      $conductor=DB::select("SELECT c.ci,c.expedido,c.nombre,c.paterno,c.materno,c.numero_movil,c.celular,c.categoria_licencia,c.credito,(SELECT count(*) from pedido p where year(p.fecha_pedido)=year(now()) and p.estado=5 and p.id_conductor=c.ci) as 'cantidad_conductor',(SELECT count(*) from pedido p where year(p.fecha_pedido)=year(now()) and p.estado=4 and p.id_conductor=c.ci) as 'cantidad_pasajero' from conductor c");

       $fechas = DB::select("SELECT date(DATE_SUB(curdate(), INTERVAL + 29 DAY)) as fecha_inicio, date(now()) as fecha_fin");   

      return View("reporte.conductor_con_mas_cancelacion",["conductor"=>$conductor,'fechas'=>$fechas]);
    }
    public function conductor_con_mas_cancelacion_2(Request $request){
       $fecha_inicio=$request['fecha_inicio'];
        $fecha_fin=$request['fecha_fin'];
       $conductor=DB::select("SELECT c.ci,c.expedido,c.nombre,c.paterno,c.materno,c.numero_movil,c.celular,c.categoria_licencia,c.credito,(SELECT count(*) from pedido p where date(p.fecha_pedido)>=date('".$fecha_inicio."') and date(p.fecha_pedido)<= date('".$fecha_inicio."') and p.estado=5 and p.id_conductor=c.ci) as 'cantidad_conductor' ,(SELECT count(*) from pedido p where date(p.fecha_pedido)>=date('".$fecha_inicio."') and date(p.fecha_pedido)<= date('".$fecha_inicio."') and p.estado=4 and p.id_conductor=c.ci) as 'cantidad_pasajero' from conductor c");

        $fechas = DB::select("SELECT date('".$fecha_inicio."') as fecha_inicio, date('".$fecha_fin."') as fecha_fin");   

      return View("reporte.conductor_con_mas_cancelacion",["conductor"=>$conductor,'fechas'=>$fechas]);
    }

     public function pasajero_con_mas_cancelacion(){
      $pasajero=DB::select("SELECT u.direccion_imagen,u.nombre,u.apellido,u.celular,u.correo,u.fecha_registro,(SELECT count(*) from pedido p where year(p.fecha_pedido)=year(now()) and p.estado=5 and p.id_usuario=u.id) as 'cantidad_conductor',(SELECT count(*) from pedido p where year(p.fecha_pedido)=year(now()) and p.estado=4 and p.id_usuario=u.id) as 'cantidad_pasajero' from usuario u");

       $fechas = DB::select("SELECT date(DATE_SUB(curdate(), INTERVAL + 29 DAY)) as fecha_inicio, date(now()) as fecha_fin");   

      return View("reporte.pasajero_con_mas_cancelacion",["pasajero"=>$pasajero,'fechas'=>$fechas]);
    }

    public function pasajero_con_mas_cancelacion_2(Request $request){
       $fecha_inicio=$request['fecha_inicio'];
        $fecha_fin=$request['fecha_fin'];

       $pasajero=DB::select("SELECT u.direccion_imagen,u.nombre,u.apellido,u.celular,u.correo,u.fecha_registro,(SELECT count(*) from pedido p where date(p.fecha_pedido)>=date('".$fecha_inicio."') and date(p.fecha_pedido)<= date('".$fecha_inicio."') and p.estado=5 and p.id_usuario=u.id) as 'cantidad_conductor',(SELECT count(*) from pedido p where date(p.fecha_pedido)>=date('".$fecha_inicio."') and date(p.fecha_pedido)<= date('".$fecha_inicio."') and p.estado=4 and p.id_usuario=u.id) as 'cantidad_pasajero' from usuario u");

        $fechas = DB::select("SELECT date('".$fecha_inicio."') as fecha_inicio, date('".$fecha_fin."') as fecha_fin");   

      return View("reporte.pasajero_con_mas_cancelacion",["pasajero"=>$pasajero,'fechas'=>$fechas]);
    }






        public function conductor_con_mas_estrellas(){
      $conductor=DB::select("SELECT c.ci,c.expedido,c.nombre,c.paterno,c.materno,c.numero_movil,c.celular,c.categoria_licencia,c.credito,c.calificacion from conductor c");
   
      return View("reporte.conductor_con_mas_estrellas",["conductor"=>$conductor ]);
    }
   

    public function vehiculo_con_mas_estrellas(){
      $vehiculo=DB::select("SELECT * from vehiculo");
      return View("reporte.vehiculo_con_mas_estrellas",["vehiculo"=>$vehiculo ]);
    }

    public function cumpleanieros()
    {
      $cum=DB::select("(select 'id',c.ci,c.nombre,c.paterno,c.materno,c.celular,c.fecha_nacimiento,date(now())as 'fecha_actual', FLOOR(DATEDIFF(date(now()),c.fecha_nacimiento)/365) as 'edad',datediff(concat(year(now()),'-',month(c.fecha_nacimiento),'-',day(c.fecha_nacimiento)), date(now())) as 'dias',1 as 'conductor',0 as 'personal',concat(year(now()),'-',month(c.fecha_nacimiento),'-',day(c.fecha_nacimiento)) as 'fecha_cumpleanio'  from conductor c)union (select c.id,c.ci_nit,c.nombre,c.paterno,c.materno,c.telefono as 'celular',c.fecha_nacimiento,date(now())as 'fecha_actual', FLOOR(DATEDIFF(date(now()),c.fecha_nacimiento)/365) as 'edad',datediff(concat(year(now()),'-',month(c.fecha_nacimiento),'-',day(c.fecha_nacimiento)), date(now())) as 'dias',0 as 'conductor',1 as 'personal',concat(year(now()),'-',month(c.fecha_nacimiento),'-',day(c.fecha_nacimiento)) as 'fecha_cumpleanio'  from cliente c)  ");

      return View('reporte.cumpleanieros',['cumpleanieros'=>$cum]);
    }
 
}
