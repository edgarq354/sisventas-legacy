<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\ContratoRequest;
use Exception;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ContratoController extends Controller
{
     public function __construct() {
         $this->middleware('auth');
    }

    public  function index()
    {
    	if (Auth::user()->privilegio == 1 || Auth::user()->privilegio == 2 || Auth::user()->privilegio == 0) {
            
            $contrato=DB::select("SELECT c.*,e.nombre,e.paterno,e.materno from contrato c,empleado e where c.id_empleado_contratado=e.ci and c.id_empresa='".Auth::user()->id_empresa."'");
            $horario=DB::select("SELECT * from horario where id_empresa='".Auth::user()->id_empresa."'");
            $empleado=DB::select("SELECT * from empleado where id_empresa='".Auth::user()->id_empresa."'");
           
            return view('contrato.index',['contrato'=>$contrato,'buscar_contrato'=>$contrato,'empleado'=>$empleado,'horario'=>$horario]);            
        } else {
            return view('errors.404');                        
        }

    }
      public function store(ContratoRequest $request)
    {
    	$empleado=DB::select("SELECT e.ci as 'id_administrador' from empleado e,users a where  a.id_empleado=e.ci and  a.id='".Auth::user()->id."'");
    	   try {
            DB::beginTransaction();
            DB::table('contrato')->insert(['sueldo' => $request['sueldo'], 'inicio_contrato' =>$request['inicio_contrato'],'fin_contrato'=>$request['fin_contrato'],'observaciones'=>$request['observaciones'],'id_horario'=>$request['id_horario'],'id_empleado_administrador'=>$empleado[0]->id_administrador,'id_empleado_contratado'=>$request['id_empleado_contratado'],'id_empresa'=>Auth::user()->id_empresa]); 
              DB::commit();     
            Session::flash('message','SE REGISTRO CORRECTAMENTE');
            return Redirect::to('/contrato'); 
            
      }catch (Exception $e) {
          DB::rollback();
          return redirect('/contrato')->with("message-error","ERROR INTENTE NUEVAMENTE");      
      }   

    }
 
}
