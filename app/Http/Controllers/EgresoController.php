<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\EgresoRequest;
use App\Http\Requests\EmpleadoRequest;
use Exception;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class EgresoController extends Controller
{
      public function __construct() {
         $this->middleware('auth');
      }
      function index(Request $request) {
        if (Auth::user()->privilegio == 1 || Auth::user()->privilegio == 2 || Auth::user()->privilegio == 0|| Auth::user()->privilegio == 10|| Auth::user()->privilegio == 11) {
            $fecha_inicio=$request['fecha_inicio'];
            $fecha_fin=$request['fecha_fin'];
            $id_usuario=$request['id_usuario'];
            $id_cliente=$request['id_cliente'];
            $id_empresa=Auth::user()->id_empresa;

            if($fecha_inicio!=''&&$fecha_fin!=''){
              if($id_usuario!='' && $id_cliente!=''){
                $egreso=DB::select("SELECT e.*,a.nombre as 'usuario',tp.nombre as 'tipo_egreso' from users a,egreso e,tipo_ingreso_egreso tp where a.id=e.id_login and e.id_tipo_ingreso_egreso=tp.id and date(e.fecha)>='".$fecha_inicio."' and date(e.fecha)<='".$fecha_fin."' and e.id_cliente='".$id_cliente."' and e.id_login='".$id_usuario."' and e.id_empresa='".$id_empresa."'");

              }else if($id_usuario!=''){
                $id_cliente='no';

                $egreso=DB::select("SELECT e.*,a.nombre as 'usuario',tp.nombre as 'tipo_egreso' from users a,egreso e,tipo_ingreso_egreso tp where a.id=e.id_login and e.id_tipo_ingreso_egreso=tp.id and date(e.fecha)>='".$fecha_inicio."' and date(e.fecha)<='".$fecha_fin."' and e.id_login='".$id_usuario."' and e.id_empresa='".$id_empresa."'");

              }else if($id_cliente!=''){
                $id_usuario='no';

                $egreso=DB::select("SELECT e.*,a.nombre as 'usuario',tp.nombre as 'tipo_egreso' from users a,egreso e,tipo_ingreso_egreso tp where a.id=e.id_login and e.id_tipo_ingreso_egreso=tp.id and date(e.fecha)>='".$fecha_inicio."' and date(e.fecha)<='".$fecha_fin."' and e.id_cliente='".$id_cliente."' and e.id_empresa='".$id_empresa."'");

              }else{
                $id_usuario='no';
                $id_cliente='no';

                $egreso=DB::select("SELECT e.*,a.nombre as 'usuario',tp.nombre as 'tipo_egreso' from users a,egreso e,tipo_ingreso_egreso tp where a.id=e.id_login and e.id_tipo_ingreso_egreso=tp.id and date(e.fecha)>='".$fecha_inicio."' and date(e.fecha)<='".$fecha_fin."' and e.id_empresa='".$id_empresa."'");
              }

            }else{
              $fecha_inicio=date('Y-m-j');
              $fecha_fin=date('Y-m-j');
              $id_usuario='no';
              $id_cliente='no';

            $egreso=DB::select("SELECT e.*,a.nombre as 'usuario',tp.nombre as 'tipo_egreso' from users a,egreso e,tipo_ingreso_egreso tp where a.id=e.id_login and e.id_tipo_ingreso_egreso=tp.id and date(e.fecha)>='".$fecha_inicio."' and date(e.fecha)<='".$fecha_fin."' and e.id_empresa='".$id_empresa."'");
            }

            $buscar_usuario=DB::select("SELECT * FROM users where id_empresa=".Auth::user()->id_empresa);
            $buscar_cliente=DB::select("SELECT * FROM cliente where id_empresa=".Auth::user()->id_empresa);
            return view('egreso.index', ['egreso'=>$egreso,'buscar_cliente'=>$buscar_cliente,'buscar_usuario'=>$buscar_usuario,'id_empresa'=>$id_empresa,'id_usuario'=>$id_usuario,'id_cliente'=>$id_cliente,'fecha_inicio'=>$fecha_inicio,'fecha_fin'=>$fecha_fin]);
        } else {
            return view('errors.404');
        }
    }



    public function create() {
         $buscar_empleado=DB::select("SELECT * from empleado ");
         $buscar_cliente=DB::select("SELECT * from cliente ");
         $buscar_tipo=DB::select("SELECT * FROM tipo_ingreso_egreso ");
        return view('egreso.create',['buscar_cliente'=>$buscar_cliente,'buscar_tipo'=>$buscar_tipo,'buscar_empleado'=>$buscar_empleado,'id_egreso'=>'']);
    }

    public function store(EgresoRequest $request){

        try {
      DB::beginTransaction();
            $id_egreso=DB::table('egreso')->insertGetId(['monto' => $request['monto'], 'debe' =>$request['debe'],'id_tipo_ingreso_egreso'=>$request['id_tipo'],'observacion'=>$request['observaciones'],'id_login'=>Auth::user()->id,'id_cliente'=>$request['id_cliente'],'id_empresa'=>Auth::user()->id_empresa]);


              DB::commit();
            Session::flash('message', __('egreso.registrado_correctamente'));



         $buscar_empleado=DB::select("SELECT * from empleado where id_empresa=".Auth::user()->id_empresa);
         $buscar_cliente=DB::select("SELECT * from cliente where id_empresa=".Auth::user()->id_empresa);
         $buscar_tipo=DB::select("SELECT * FROM tipo_ingreso_egreso where id_empresa=".Auth::user()->id_empresa);
        return view('egreso.create',['buscar_cliente'=>$buscar_cliente,'buscar_tipo'=>$buscar_tipo,'buscar_empleado'=>$buscar_empleado,'id_egreso'=>$id_egreso]);

      }catch (Exception $e) {
          DB::rollback();
          return redirect('/egreso/create')->with("message-error", __('egreso.error_intente_nuevamente'));
      }
    }

//TODO: estaba con egreso
//public function adelanto_empleado(Egreso_empleadoRequest $request){
  public function adelanto_empleado(EmpleadoRequest $request){

        try {
      DB::beginTransaction();
            DB::table('egreso')->insert(['monto' => $request['monto'], 'debe' =>$request['debe'],'id_tipo_ingreso_egreso'=>$request['id_tipo'],'observacion'=>$request['observaciones'],'id_login'=>Auth::user()->id,'id_empleado'=>$request['id_empleado'],'id_empresa'=>Auth::user()->id_empresa]);


              DB::commit();
            Session::flash('message', __('egreso.registrado_correctamente'));
            return Redirect::to('/egreso');

      }catch (Exception $e) {
          DB::rollback();
          return redirect('/egreso/create')->with("message-error", __('egreso.error_intente_nuevamente'));
      }
    }

    public function recibo_sueldo()
    {
      return view('egreso.recibo_pago');
    }

    public function show()
    {
     if (Auth::user()->privilegio == 1 || Auth::user()->privilegio == 2 || Auth::user()->privilegio == 0) {
            $egreso = DB::table('egreso')->select('*')->where("id_empresa",Auth::user()->id_empresa)->paginate(40);
            $buscar_egreso=DB::select("SELECT * FROM ingreso where id_empresa=".Auth::user()->id_empresa);
            return view('egreso.index', compact('egreso', $egreso,'buscar_egreso',$buscar_egreso));
        } else {
            return view('errors.404');
        }
    }

    public function get_egreso_semana(){



            $egreso=DB::select("SELECT date(fecha)as 'fecha_dia',sum(monto) as 'monto' from egreso where id_empresa='".Auth::user()->id_empresa."' group by  fecha_dia");
        return response($egreso);
      }

      public function comprobante_egreso_pdf($id_comprobante) {

              $egreso=DB::select("SELECT * from egreso e where  e.id='".$id_comprobante."'");
              $admin=DB::select("SELECT a.* from egreso e,users a where  e.id_login=a.id and e.id='".$id_comprobante."'");
              $tipo_ingreso_egreso=DB::select("SELECT tp.* from egreso e,tipo_ingreso_egreso tp where e.id_tipo_ingreso_egreso=tp.id and e.id='".$id_comprobante."'");
              $empresa=DB::select("SELECT emp.* from egreso e,empresa emp where e.id_empresa=emp.id and e.id='".$id_comprobante."'");
              $cliente=DB::select("SELECT c.* from egreso e,cliente c where e.id_cliente=c.id and e.id='".$id_comprobante."'");
               $conductor=DB::select("SELECT  c.* from conductor c, egreso e where  e.id_conductor=c.ci and e.id='".$id_comprobante."'");
              $numero_letra=ucfirst(self::convertir($egreso[0]->monto));




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
      $opcion=0;
      foreach ($egreso as $key => $value) {
       $opcion=$value->opcion;
      }

      if($opcion==2)
              {
                //CONDUCTOR
                $pdf=\PDF::loadView('egreso.comprobante_egreso_conductor_pdf', ['egreso'=>$egreso,'admin'=>$admin,'tipo_ingreso_egreso'=>$tipo_ingreso_egreso,'empresa'=>$empresa,'conductor'=>$conductor,'contenido'=>$id_imagen,'numero_letra'=>$numero_letra]);
              }else if($opcion==0)
              {
                 //cliente
                $pdf=\PDF::loadView('egreso.comprobante_egreso_pdf', ['egreso'=>$egreso,'admin'=>$admin,'tipo_ingreso_egreso'=>$tipo_ingreso_egreso,'empresa'=>$empresa,'cliente'=>$cliente,'contenido'=>$id_imagen,'numero_letra'=>$numero_letra]);
              }



     return   $pdf->stream();
     // return view('egreso.comprobante_egreso_pdf', ['egreso'=>$egreso,'admin'=>$admin,'tipo_ingreso_egreso'=>$tipo_ingreso_egreso,'empresa'=>$empresa,'cliente'=>$cliente,'contenido'=>$id_imagen,'numero_letra'=>$numero_letra]);
           // return   $pdf->stream();
    }



     public function pdf_egreso($id_empresa,$id_usuario,$id_cliente,$fecha_inicio,$fecha_fin) {

              if($id_usuario!='' && $id_cliente!='' && $id_usuario!='no' && $id_cliente!='no'){
                $egreso=DB::select("SELECT e.*,c.nombre as 'nombre',a.usuario from users a,egreso e,cliente c where a.id=e.id_login and e.id_cliente=c.id and date(e.fecha)>='".$fecha_inicio."' and date(e.fecha)<='".$fecha_fin."' and e.id_cliente='".$id_cliente."' and e.id_login='".$id_usuario."' and e.id_empresa='".$id_empresa."'");

              }else if($id_usuario!=''&&$id_usuario!='no' ){
                $egreso=DB::select("SELECT e.*,c.nombre as 'nombre',a.usuario from users a,egreso e,cliente c where a.id=e.id_login and e.id_cliente=c.id and date(e.fecha)>='".$fecha_inicio."' and date(e.fecha)<='".$fecha_fin."' and e.id_login='".$id_usuario."' and e.id_empresa='".$id_empresa."'");

              }else if($id_cliente!='' && $id_cliente!='no'){
                $egreso=DB::select("SELECT e.*,c.nombre as 'nombre',a.usuario from users a,egreso e,cliente c where a.id=e.id_login and e.id_cliente=c.id and date(e.fecha)>='".$fecha_inicio."' and date(e.fecha)<='".$fecha_fin."' and e.id_cliente='".$id_cliente."' and e.id_empresa='".$id_empresa."'");

              }else{
                $egreso=DB::select("SELECT e.*,c.nombre as 'nombre',a.usuario from users a,egreso e,cliente c where a.id=e.id_login and e.id_cliente=c.id and date(e.fecha)>='".$fecha_inicio."' and date(e.fecha)<='".$fecha_fin."' and e.id_empresa='".$id_empresa."'");
              }



            $pdf=\PDF::loadView('egreso.pdf_egreso', ['egreso'=>$egreso,'id_empresa'=>$id_empresa,'id_usuario'=>$id_usuario,'id_cliente'=>$id_cliente,'fecha_inicio'=>$fecha_inicio,'fecha_fin'=>$fecha_fin]);
            return   $pdf->stream();

    }


















//INICIO DE LAS FUNCIONES DE CONVERTIR DE NUMERO A LETRA.
 // FUNCIONES DE CONVERSION DE NUMEROS A LETRAS.
function basico($numero) {
$valor = array ('uno','dos','tres','cuatro','cinco','seis','siete','ocho',
'nueve','diez', 'once','doce','trece','catorce','quince','dies y sesis',
'dies y siete','dies y ocho','dies y nueve','veinte','veinti uno',
 'veinti dos','veinti tres','veinti cuatro','veinti cinco',
'veintiséis','veintisiete','veintiocho','veintinueve');
return $valor[$numero - 1];
}

function decenas($n) {
$decenas = array (30=>'treinta',40=>'cuarenta',50=>'cincuenta',60=>'sesenta',
70=>'setenta',80=>'ochenta',90=>'noventa');
if( $n <= 29) return self::basico($n);
$x = $n % 10;
if ( $x == 0 ) {
return $decenas[$n];
} else return $decenas[$n - $x].' y '. self::basico($x);
}

function centenas($n) {
$cientos = array (100 =>'cien',200 =>'doscientos',300=>'trecientos',
400=>'cuatrocientos', 500=>'quinientos',600=>'seiscientos',
700=>'setecientos',800=>'ochocientos', 900 =>'novecientos');
if( $n >= 100) {
if ( $n % 100 == 0 ) {
return $cientos[$n];
} else {
$u = (int) substr($n,0,1);
$d = (int) substr($n,1,2);
return (($u == 1)?'ciento':$cientos[$u*100]).' '.self::decenas($d);
}
} else return self::decenas($n);
}

function miles($n) {
if($n > 999) {
if( $n == 1000) {return 'mil';}
else {
$l = strlen($n);
$c = (int)substr($n,0,$l-3);
$x = (int)substr($n,-3);
if($c == 1) {$cadena = 'mil '.self::centenas($x);}
else if($x != 0) {$cadena = self::centenas($c).' mil '.self::centenas($x);}
else $cadena = self::centenas($c). ' mil';
return $cadena;
}
} else return self::centenas($n);
}

function millones($n) {
if($n == 1000000) {return 'un millón';}
else {
$l = strlen($n);
$c = (int)substr($n,0,$l-6);
$x = (int)substr($n,-6);
if($c == 1) {
$cadena = ' millón ';
} else {
$cadena = ' millones ';
}
return self::miles($c).$cadena.(($x > 0)?self::miles($x):'');
}
}
function convertir($n) {
  $n=str_replace(".00", "", $n);
  if($n==0){
    return "Cero";
  }else{
switch (true) {
case ( $n >= 1 && $n <= 29) : return self::basico($n); break;
case ( $n >= 30 && $n < 100) : return self::decenas($n); break;
case ( $n >= 100 && $n < 1000) : return self::centenas($n); break;
case ($n >= 1000 && $n <= 999999): return self::miles($n); break;
case ($n >= 1000000): return self::millones($n);
}
}
}















}



