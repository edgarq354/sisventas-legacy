<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\HorarioRequest;
use Exception;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class HorarioController extends Controller
{
     public function __construct() {
         $this->middleware('auth');
    }

    public function index()
    {
    	if (Auth::user()->privilegio == 1 || Auth::user()->privilegio == 2 || Auth::user()->privilegio == 0) {
            
            $horario=DB::select("SELECT * from horario where id_empresa='".Auth::user()->id_empresa."'");
           
            return view('horario.index', ['horario'=>$horario,'buscar_horario'=>$horario]);            
        } else {
            return view('errors.404');                        
        }

    }
      public function store(HorarioRequest $request)
    {
    	   try {
      		DB::beginTransaction();
            DB::table('horario')->insert(['nombre' => $request['nombre'], 'tipo' =>$request['tipo'],'hora_ingreso'=>$request['hora_ingreso'],'hora_salida'=>$request['hora_salida'],'id_empresa'=>Auth::user()->id_empresa]); 
              DB::commit();     
            Session::flash('message','SE REGISTRO CORRECTAMENTE');
            return Redirect::to('/horario'); 
            
      }catch (Exception $e) {
          DB::rollback();
          return redirect('/horario')->with("message-error","ERROR INTENTE NUEVAMENTE");      
      }   

    }

}
