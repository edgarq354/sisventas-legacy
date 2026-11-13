<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Tipo_ingreso_egresoRequest;
use App\Http\Requests;
use Exception;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Tipo_ingreso_egresoController extends Controller
{
    public function __construct() {
         $this->middleware('auth');
    }

    public function index() {    
        if (Auth::user()->privilegio == 1 || Auth::user()->privilegio == 2 || Auth::user()->privilegio == 0 || Auth::user()->privilegio == 10|| Auth::user()->privilegio == 11) {
            $tipo = DB::table('tipo_ingreso_egreso')->select('*')->where('id_empresa',Auth::user()->id_empresa)->get();
            
            return view('tipo_ingreso_egreso.index', compact('tipo', $tipo));            
        } else {
            return view('errors.404');                        
        }
    }

    public function create() {            
        return view('tipo_ingreso_egreso.create');
    }

    public function store(Tipo_ingreso_egresoRequest $request){

        try {
      DB::beginTransaction();
        
            DB::table('tipo_ingreso_egreso')->insert(['nombre' => $request['nombre'], 'detalle' =>$request['detalle'],'id_empresa'=>Auth::user()->id_empresa]);           
            

              DB::commit();     
            Session::flash('message','SE REGISTRO CORRECTAMENTE');
            return Redirect::to('/tipo_ingreso_egreso/index'); 
            
      }catch (Exception $e) {
          DB::rollback();
          return redirect('/tipo_ingreso_egreso/create')->with("message-error","ERROR INTENTE NUEVAMENTE");      
      }   
    }
    public function show()
    {    if (Auth::user()->privilegio == 1 || Auth::user()->privilegio == 2 || Auth::user()->privilegio == 0) {
            $tipo = DB::table('tipo_ingreso_egreso')->select('*')->where('id_empresa',Auth::user()->id_empresa)->paginate(40);
            $buscar_tipo=DB::select("SELECT * FROM tipo_ingreso_egreso WHERE id_empresa='".Auth::user()->id_empresa."' order by fecha asc");
            return view('tipo_ingreso_egreso.index', compact('tipo', $tipo,'buscar_tipo',$buscar_tipo));            
        } else {
            return view('errors.404');                        
        }
    }
}
