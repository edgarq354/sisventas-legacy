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


class Pago_empresaController extends Controller
{
	public function __construct() {
         $this->middleware('auth');
    }
    
      public function index(Request $Request )
    {	

     $conductor=DB::table('pago_empresa')
                ->where('pago_empresa.id_empresa_administrador','=',Auth::user()->id_empresa)
                ->select('pago_empresa.*')
                ->paginate(30);

    if($Request->isMethod('GET') && $Request['fecha_inicio']!=''){
    $pago_frecuencia = DB::select("SELECT p.id as 'nro',p.numero,date(p.fecha) as 'fecha',a.codigo_empresa,concat(c.nombre,' ',c.paterno,' ',c.materno) as 'nombre_conductor',p.monto_frecuencia,p.monto_retraso,p.pro_accidente,p.pro_navidad,p.ahorro,p.monto_total,p.permiso as 'permiso',a.id_vehiculo as 'placa',c.direccion_imagen FROM pago_frecuencia p,conductor c,asignacion a WHERE  a.id_conductor=c.ci and a.estado<2 and p.id_conductor=c.ci and c.id_empresa='".Auth::user()->id_empresa."' and date(p.fecha) BETWEEN '".$Request['fecha_inicio']."' and '".$Request['fecha_fin']."' ORDER by p.id desc ");
    }else{		
        	$pago_frecuencia = DB::select("SELECT p.id as 'nro',p.numero,date(p.fecha) as 'fecha',a.codigo_empresa,concat(c.nombre,' ',c.paterno,' ',c.materno) as 'nombre_conductor',p.monto_frecuencia,p.monto_retraso,p.pro_accidente,p.pro_navidad,p.ahorro,p.monto_total,p.permiso as 'permiso',a.id_vehiculo as 'placa',c.direccion_imagen FROM pago_frecuencia p,conductor c,asignacion a WHERE  a.id_conductor=c.ci and a.estado=1 and p.id_conductor=c.ci and a.estado<2 and c.id_empresa='".Auth::user()->id_empresa."' ORDER by p.id desc limit 30");
    }

     	return view('pago_empresa.index',["pago_frecuencia"=>$pago_frecuencia]);
    }
}
