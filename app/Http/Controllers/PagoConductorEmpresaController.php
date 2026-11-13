<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\EgresoRequest;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class PagoConductorEmpresaController extends Controller
{
     public function __construct() {
         $this->middleware('auth');
    }

      function index(Request $request) {          
        if (Auth::user()->privilegio == 1 || Auth::user()->privilegio == 2 || Auth::user()->privilegio == 0|| Auth::user()->privilegio == 10|| Auth::user()->privilegio == 11) {
            $fecha_inicio=$request['fecha_inicio'];
            $fecha_fin=$request['fecha_fin'];
            $id_usuario=$request['id_usuario'];
            $id_conductor=$request['id_conductor'];
            $id_empresa=Auth::user()->id_empresa;

            if($fecha_inicio!=''&&$fecha_fin!=''){
              if($id_usuario!='' && $id_conductor!=''){
                $egreso=DB::select("SELECT e.*,c.nombre as 'nombre',a.usuario from users a,egreso e,cliente c where a.id=e.id_login and e.id_conductor=c.id and date(e.fecha)>='".$fecha_inicio."' and date(e.fecha)<='".$fecha_fin."' and e.id_conductor='".$id_conductor."' and e.id_login='".$id_usuario."' and e.id_empresa='".$id_empresa."'");

              }else if($id_usuario!=''){
                $id_conductor='no';

                $egreso=DB::select("SELECT e.*,c.nombre as 'nombre',a.usuario from users a,egreso e,cliente c where a.id=e.id_login and e.id_conductor=c.id and date(e.fecha)>='".$fecha_inicio."' and date(e.fecha)<='".$fecha_fin."' and e.id_login='".$id_usuario."' and e.id_empresa='".$id_empresa."'");

              }else if($id_conductor!=''){
                $id_usuario='no';

                $egreso=DB::select("SELECT e.*,c.nombre as 'nombre',a.usuario from users a,egreso e,cliente c where a.id=e.id_login and e.id_conductor=c.id and date(e.fecha)>='".$fecha_inicio."' and date(e.fecha)<='".$fecha_fin."' and e.id_conductor='".$id_conductor."' and e.id_empresa='".$id_empresa."'");

              }else{
                $id_usuario='no';
                $id_conductor='no';

                $egreso=DB::select("SELECT e.*,c.nombre as 'nombre',a.usuario from users a,egreso e,cliente c where a.id=e.id_login and e.id_conductor=c.id and date(e.fecha)>='".$fecha_inicio."' and date(e.fecha)<='".$fecha_fin."' and e.id_empresa='".$id_empresa."'");
              }
        
            }else{
              $fecha_inicio=date('Y-m-j');
              $fecha_fin=date('Y-m-j');
              $id_usuario='no';
              $id_conductor='no';

            $egreso=DB::select("SELECT e.*,c.nombre as 'nombre',a.usuario from users a,egreso e,cliente c where a.id=e.id_login and e.id_conductor=c.id and date(e.fecha)>='".$fecha_inicio."' and date(e.fecha)<='".$fecha_fin."' and e.id_empresa='".$id_empresa."'");
            }

            $buscar_usuario=DB::select("SELECT * FROM users where id_empresa=".Auth::user()->id_empresa);
             $buscar_conductor=DB::select("(SELECT c.*,'1'as 'tipo_asignacion',v.codigo_empresa from conductor c, vehiculo v where c.id_vehiculo=v.placa) 
            union( SELECT cc.*,'0'as 'tipo_asignacion',''  from conductor cc where cc.id_vehiculo not in (SELECT placa from vehiculo))");
            return view('conductor.pago_empresa.index', ['egreso'=>$egreso,'buscar_conductor'=>$buscar_conductor,'buscar_usuario'=>$buscar_usuario,'id_empresa'=>$id_empresa,'id_usuario'=>$id_usuario,'id_conductor'=>$id_conductor,'fecha_inicio'=>$fecha_inicio,'fecha_fin'=>$fecha_fin]);            
        } else {
            return view('errors.404');                        
        }
    }

     public function create() {   
         $buscar_empleado=DB::select("SELECT * from empleado ");
         $buscar_conductor=DB::select("(SELECT c.*,'1'as 'tipo_asignacion',v.codigo_empresa from conductor c, vehiculo v where c.id_vehiculo=v.placa) 
            union( SELECT cc.*,'0'as 'tipo_asignacion',''  from conductor cc where cc.id_vehiculo not in (SELECT placa from vehiculo))");
         $buscar_tipo=DB::select("SELECT * FROM tipo_ingreso_egreso ");
        return view('egreso.create',['buscar_conductor'=>$buscar_conductor,'buscar_tipo'=>$buscar_tipo,'buscar_empleado'=>$buscar_empleado,'id_egreso'=>'']);         
    }

    public function store(EgresoRequest $request){

        try {
      DB::beginTransaction();
            $id_egreso=DB::table('egreso')->insertGetId(['monto' => $request['monto'], 'debe' =>$request['debe'],'id_tipo_ingreso_egreso'=>$request['id_tipo'],'observacion'=>$request['observaciones'],'id_login'=>Auth::user()->id,'id_cliente'=>$request['id_cliente'],'id_empresa'=>Auth::user()->id_empresa]);           
            

              DB::commit();     
            Session::flash('message','SE REGISTRO CORRECTAMENTE');



         $buscar_empleado=DB::select("SELECT * from empleado where id_empresa=".Auth::user()->id_empresa);
         $buscar_cliente=DB::select("SELECT * from cliente where id_empresa=".Auth::user()->id_empresa);
         $buscar_tipo=DB::select("SELECT * FROM tipo_ingreso_egreso where id_empresa=".Auth::user()->id_empresa);
        return view('egreso.create',['buscar_cliente'=>$buscar_cliente,'buscar_tipo'=>$buscar_tipo,'buscar_empleado'=>$buscar_empleado,'id_egreso'=>$id_egreso]);
            
      }catch (Exception $e) {
          DB::rollback();
          return redirect('/egreso/create')->with("message-error","ERROR INTENTE NUEVAMENTE");      
      }   
    }


}
