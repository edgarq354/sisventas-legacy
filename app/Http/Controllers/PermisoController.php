<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

use App\Http\Requests;	
use App\Ajuste;	
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
class PermisoController extends Controller
{

  public function __construct() {
         $this->middleware('auth');
    }

    public function index(Request $Request )
    {					
    if($Request->isMethod('GET') && $Request['fecha_inicio']!=''){
    $pago_frecuencia = DB::select("SELECT p.id as 'nro',date(p.fecha) as 'fecha',v.codigo_empresa,
      concat(c.nombre,' ',c.paterno,' ',c.materno) as 'nombre_conductor',p.monto_frecuencia,p.monto_retraso,p.pro_accidente,
      p.pro_navidad,p.ahorro,p.monto_total,p.observaciones FROM pago_frecuencia p,conductor c,vehiculo v WHERE p.permiso=1 
      and  v.placa=c.id_vehiculo and p.id_conductor=c.ci and c.id_empresa='".Auth::user()->id_empresa."' 
      and date(p.fecha) BETWEEN '".$Request['fecha_inicio']."' and '".$Request['fecha_fin']."' ORDER by p.id desc ");
    }else{		
        	$pago_frecuencia = DB::select("SELECT p.id as 'nro',date(p.fecha) as 'fecha',v.codigo_empresa,
            concat(c.nombre,' ',c.paterno,' ',c.materno) as 'nombre_conductor',p.monto_frecuencia,p.monto_retraso,
            p.pro_accidente,p.pro_navidad,p.ahorro,p.monto_total,p.observaciones FROM pago_frecuencia p,conductor c,vehiculo v
            WHERE p.permiso=1 and  v.placa=c.id_vehiculo and p.id_conductor=c.ci and c.id_empresa='".Auth::user()->id_empresa."' 
            ORDER by p.id desc limit 80");
    }

     	return view('ajuste.permiso.index',["pago_frecuencia"=>$pago_frecuencia]);
    }
    public function create(Request $Request )
    {
    	$frecuencia=DB::select("SELECT f.id,f.id_empresa,f.fecha_inicio,f.fecha_fin,f.numero,c.monto_frecuencia as 'monto',f.tipo 
        from frecuencia f,conductor c where c.ci='".$Request['ci']."' AND c.id_empresa='".Auth::user()->id_empresa."' 
        and f.tipo=c.tipo_de_pago and  f.fecha_fin<ADDDATE(now(), INTERVAL 30 DAY) and f.fecha_inicio>c.fecha_inicio_pago 
        and f.id not in(SELECT df.id_frecuencia from pago_frecuencia pf,detalle_frecuencia df,conductor c where c.ci=pf.id_conductor 
          and pf.id=df.id_pago_frecuencia and pf.id_conductor='".$Request['ci']."' and c.id_empresa='".Auth::user()->id_empresa."' 
          and f.fecha_inicio>c.fecha_inicio_pago )");

    	$conductor=DB::select("SELECT ci,nombre,paterno,materno from conductor where ci='".$Request['ci']."' 
        and id_empresa='".Auth::user()->id_empresa."'");

    	$ajuste=DB::select("SELECT * from ajuste where id_empresa='".Auth::user()->id_empresa."' order by anio desc limit 1");

      $buscar_conductor=DB::select("SELECT c.ci,c.nombre,c.paterno,c.materno,c.numero_movil as 'codigo' 
        FROM conductor c  where  c.id_empresa='".Auth::user()->id_empresa."'");

    	return view('ajuste.permiso.create',["frecuencia"=>$frecuencia,'ajuste'=>$ajuste,'conductor'=>$conductor],compact('buscar_conductor',$buscar_conductor));
    }

    function verificar_deuda_frecuencia($ci){

        $conductor=DB::select("SELECT f.* from frecuencia f, conductor c,detalle_frecuencia df where c.tipo_de_pago=f.tipo and f.fecha_fin<=now() and df.id_frecuencia<>f.id and c.id_empresa'".Auth::user()->id_empresa."' and c.ci='".$ci."'");
        return response($conductor);
    }
    

//////////////// P D F
  public function pago_pdf($nro){ 
  
   $frecuencia=DB::select("SELECT f.* from detalle_frecuencia df, frecuencia f where  f.id=df.id_frecuencia 
    and df.id_pago_frecuencia='".$nro."'");

    	$pago_frecuencia=DB::select("SELECT c.ci,c.nombre,c.paterno,c.materno,c.expedido,pf.*,
        a.id_vehiculo as 'placa',a.codigo_empresa from conductor c,pago_frecuencia pf,vehiculo v 
        where v.placa=c.id_vehiculo  and c.ci=pf.id_conductor and pf.id='".$nro."'");

    	$empresa=DB::select("SELECT razon_social,nit,direccion,correo,id_imagen_corporativa 
        from empresa where id='".Auth::user()->id_empresa."' ");

      $id_imagen="";
      foreach ($empresa as $key => $value) {
        $id_imagen=$value->id_imagen_corporativa;
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
       $frecuencia_deuda=DB::select("SELECT f.id,f.numero from frecuencia f,conductor c 
        where c.ci='".$ci."' AND c.id_empresa='".Auth::user()->id_empresa."' and f.tipo=c.tipo_de_pago 
        and  f.fecha_fin<now() and f.fecha_inicio>c.fecha_inicio_pago and f.id not in(SELECT df.id_frecuencia 
          from pago_frecuencia pf,detalle_frecuencia df,conductor c where c.ci=pf.id_conductor and pf.id=df.id_pago_frecuencia 
          and pf.id_conductor='".$ci."' and c.id_empresa='".Auth::user()->id_empresa."' and f.fecha_inicio>c.fecha_inicio_pago )");
      
        

   

    $pdf=\PDF::loadView('pago_frecuencia.pago_pdf',['frecuencia'=>$frecuencia,'pago_frecuencia'=>$pago_frecuencia,'empresa'=>$empresa,'contenido'=>$id_imagen,'deuda_frecuencia'=>$frecuencia_deuda]);
   // return view('pago_frecuencia.pago_pdf',['frecuencia'=>$frecuencia,'pago_frecuencia'=>$pago_frecuencia,'empresa'=>$empresa,'contenido'=>$id_imagen,'deuda_frecuencia'=>$frecuencia_deuda]);
    return   $pdf->stream();
  }

    public function detalle($nro)
    {
    	$frecuencia=DB::select("SELECT f.* from detalle_frecuencia df, frecuencia f where  f.id=df.id_frecuencia 
        and df.id_pago_frecuencia='".$nro."'");

    	$pago_frecuencia=DB::select("SELECT c.ci,c.nombre,c.paterno,c.materno,c.expedido,pf.* from conductor c,pago_frecuencia pf
       where c.ci=pf.id_conductor and pf.id='".$nro."'");

    	return view('pago_frecuencia.detalle',['frecuencia'=>$frecuencia,'pago_frecuencia'=>$pago_frecuencia]);
    }
public function deudores($nro)
    {
      $deudores=DB::select("SELECT c.ci,c.nombre,c.paterno,c.materno,v.codigo_empresa from frecuencia f,conductor c,vehiculo v
        where a.id_conductor=c.ci and c.id_empresa='".Auth::user()->id_empresa."' and f.tipo=c.tipo_de_pago and  f.fecha_fin<now() 
        and f.fecha_inicio>c.fecha_inicio_pago and f.id not in(SELECT df.id_frecuencia from pago_frecuencia pf,detalle_frecuencia df,
          conductor cc where cc.ci=pf.id_conductor and pf.id=df.id_pago_frecuencia and pf.id_conductor=c.ci 
          and cc.id_empresa='".Auth::user()->id_empresa."' and f.fecha_inicio>c.fecha_inicio_pago) 
      GROUP BY c.ci,c.nombre,c.paterno,c.materno ");

      return view('pago_frecuencia.deudores',['deudores'=>$deudores]);
    }

public function create_pago_general($tipo)
    {
      $frecuencia=DB::select("SELECT f.* from frecuencia f where f.tipo like '".$tipo."' and  f.fecha_fin<=now()  
        and f.id_empresa='".Auth::user()->id_empresa."' ");

      $sumatoria=DB::select("SELECT sum(f.monto)as 'monto' from frecuencia f where f.tipo like '".$tipo."' 
        and  f.fecha_fin<=now()  and f.id_empresa='".Auth::user()->id_empresa."' ");

      $ajuste=DB::select("SELECT * from ajuste where   id_empresa='".Auth::user()->id_empresa."' order by anio desc limit 1");
      

      return view('pago_frecuencia.create_pago_general',[
        'frecuencia'=>$frecuencia,
        'ajuste'=>$ajuste,
        'sumatoria'=>$sumatoria,
        'tipo'=>$tipo]);
    }


    public function store(Request $Request){
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
		     	'id_conductor'=>$Request['ci'],
		     	'id_login'=>Auth::user()->id,
		     	]);

    		  
    

    		  $frecuencia=DB::select("SELECT f.* from frecuencia f, conductor c where c.tipo_de_pago=f.tipo and f.fecha_fin<=ADDDATE(now(), 
            INTERVAL 31 DAY) and c.id_empresa='".Auth::user()->id_empresa."' and c.ci='".$Request['ci']."'");

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
            Session::flash('message','SU PERMISO SE REGISTRO CORRECTAMENTE');
//una ves realizado el pago se genera el PDF
            $nro=$id_pago;
    $frecuencia=DB::select("SELECT f.* from detalle_frecuencia df, frecuencia f where  f.id=df.id_frecuencia 
      and df.id_pago_frecuencia='".$nro."'");

      $pago_frecuencia=DB::select("SELECT c.ci,c.nombre,c.paterno,c.materno,c.expedido,pf.*,c.id_vehiculo as 'placa',v.codigo_empresa 
        from conductor c,pago_frecuencia pf,vehiculo v where v.placa=c.id_vehiculo  and c.ci=pf.id_conductor and pf.id='".$nro."'");

      $empresa=DB::select("SELECT razon_social,nit,direccion,correo,id_imagen_corporativa from empresa 
        where id='".Auth::user()->id_empresa."' ");

      $id_imagen="";
      foreach ($empresa as $key => $value) {
        $id_imagen=$value->id_imagen_corporativa;
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
        AND c.id_empresa='".Auth::user()->id_empresa."' and f.tipo=c.tipo_de_pago and  f.fecha_fin<now() 
        and f.fecha_inicio>c.fecha_inicio_pago and f.id not in(SELECT df.id_frecuencia from pago_frecuencia pf,detalle_frecuencia df,
          conductor c where c.ci=pf.id_conductor and pf.id=df.id_pago_frecuencia and pf.id_conductor='".$Request['ci']."' 
          and c.id_empresa='".Auth::user()->id_empresa."' and f.fecha_inicio>c.fecha_inicio_pago )");


          return redirect('/gestionar_permiso/create');      
        
    //return view('pago_frecuencia.pago_pdf',['frecuencia'=>$frecuencia,'pago_frecuencia'=>$pago_frecuencia,'empresa'=>$empresa,'contenido'=>$id_imagen,'deuda_frecuencia'=>$frecuencia_deuda]);
//finalizacion del pago de PDF


          //  return redirect::to('/pago_frecuencia'); 
 		} catch (Exception $e) {
          DB::rollback();
          return redirect('/gestionar_permiso')->with("message-error","ERROR INTENTE NUEVAMENTE".$e);      
        }
   
    }


    public function store_pago_general(Request $Request){
       $total=0;
       $registrado=0; 
     
         $verificar=DB::select("SELECT id_conductor as ci from vehiculo,conductor c WHERE v.placa=c.id_vehiculo
          and c.tipo_de_pago like '".$Request['tipo']."' and c.id_empresa='".Auth::user()->id_empresa."'");
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

          
    

          $frecuencia=DB::select("SELECT f.* from frecuencia f, conductor c where c.tipo_de_pago=f.tipo and f.fecha_fin<=now() 
            and c.id_empresa='".Auth::user()->id_empresa."' and c.ci='".$cond->ci."'");

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
}
