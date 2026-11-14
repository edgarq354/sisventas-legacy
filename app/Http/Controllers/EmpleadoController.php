<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\EmpleadoRequest;
use Exception;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
class EmpleadoController extends Controller
{
    public function __construct() {
         $this->middleware('auth');
    }

    public function index()
    {
    	if (Auth::user()->privilegio == 1 || Auth::user()->privilegio == 2 || Auth::user()->privilegio == 0) {
            
           $empleado=DB::table('empleado')->select('*')->where('empleado.id_empresa', Auth::user()->id_empresa)->orderby('nombre')->paginate(40);

            return view('empleado.index', ['empleado'=>$empleado,'buscar_empleado'=>$empleado]);            
        } else {
            return view('errors.404');                        
        }

    }
      public function store(EmpleadoRequest $request)
    {
    	   try {
      		DB::beginTransaction();
            DB::table('empleado')->insert(['ci' => $request['ci'],'nombre' => $request['nombre'], 'paterno' =>$request['paterno'],'materno'=>$request['materno'],'fecha_nacimiento'=>$request['fecha_nacimiento'],'expedido'=>$request['expedido'],'celular'=>$request['celular'],'garante'=>$request['garante'],'direccion'=>$request['direccion'],'id_empresa'=>Auth::user()->id_empresa]); 
              DB::commit();     
            Session::flash('message', __('empleado.registrado_correctamente'));
            return Redirect::to('/empleado');

	      }catch (Exception $e) {
	          DB::rollback();
	          return redirect('/empleado')->with("message-error", __('empleado.error_intente_nuevamente'));
	      }

    }
}
