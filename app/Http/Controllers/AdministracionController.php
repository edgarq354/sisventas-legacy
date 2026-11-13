<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

use App\Http\Requests;	
use App\Ajuste;	
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AdministracionController extends Controller
{
	public function __construct() {
         $this->middleware('auth');
    }
	public function index()
	{
		if(Auth::user()->privilegio==1||Auth::user()->privilegio==10||Auth::user()->privilegio==11){

			$egreso=DB::select("SELECT e.*, t.nombre as 'tipo_egreso',c.nombre as 'cliente' from egreso e, tipo_ingreso_egreso t,cliente c where e.id_cliente=c.id and e.id_empleado is null and e.id_tipo_ingreso_egreso=t.id  and date(e.fecha)=date(now()) and e.id_empresa='".Auth::user()->id_empresa."'"); 

            $egreso_sueldo=DB::select("SELECT e.*, t.nombre as 'tipo_egreso',concat(c.nombre,' ',c.paterno,' ',c.materno) as 'usuario' from egreso e, tipo_ingreso_egreso t,empleado c where e.id_empleado=c.ci and e.id_cliente is null and e.id_tipo_ingreso_egreso=t.id and date(e.fecha)= date(now()) and e.id_empresa='".Auth::user()->id_empresa."' "); 
            
             $ingreso=DB::select("SELECT i.*, t.nombre as 'tipo_ingreso',c.nombre as 'cliente' from ingreso i, tipo_ingreso_egreso t,cliente c where i.id_cliente=c.id  and i.id_tipo_ingreso_egreso=t.id  and date(i.fecha) =date(now()) and i.id_empresa='".Auth::user()->id_empresa."'");
			 
			 //TODO: verificar luego
			 $pago_frecuencia=DB::select("SELECT i.*, t.nombre as 'tipo_ingreso',c.nombre as 'cliente' from ingreso i, tipo_ingreso_egreso t,cliente c where i.id_cliente=c.id  and i.id_tipo_ingreso_egreso=t.id  and date(i.fecha) =date(now()) and i.id_empresa='".Auth::user()->id_empresa."'");

             
              
            

			$monto_total_frecuencia=0;
			foreach ($pago_frecuencia as $key => $pago) {
				$monto_total_frecuencia+=$pago->monto_total;
			}

			$monto_ingreso=0; 
			foreach ($ingreso as $key => $ing) {
				$monto_ingreso+=$ing->monto;
			}

			$monto_egreso=0;
			foreach ($egreso as $key => $ing) {
				$monto_egreso+=$ing->monto;
			}

			$monto_egreso_sueldo=0;
			foreach ($egreso_sueldo as $key => $ing) {
				$monto_egreso_sueldo+=$ing->monto;
			}

			$monto_total_ingreso=$monto_ingreso+$monto_total_frecuencia;
		 	$monto_total_egreso=$monto_egreso+$monto_egreso_sueldo;

		 	$caja=$monto_total_ingreso-$monto_total_egreso;


		 return view('administracion.index',['monto'=>$caja]);
		}else{
			return view('errors.404'); 
		}
	}
	public function ajuste()
	{
		 return view('administracion');
	}
    //
}
