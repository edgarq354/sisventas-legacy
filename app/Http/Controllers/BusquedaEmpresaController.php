<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use App\Notificacion;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;

class BusquedaEmpresaController extends Controller
{
    public function __construct() {
         $this->middleware('auth');
    }

	function index(){
       if(Auth::user()->privilegio == 1){
            $empresa=DB::select("SELECT * FROM empresa");  
            return view('busqueda.busqueda_empresa',compact('empresa',$empresa));                
        }else if(Auth::user()->privilegio==10){
            $empresa=DB::select("SELECT empresa.* FROM empresa,empresa aso where empresa.id_asociacion=aso.id and aso.id_asociacion=".Auth::user()->id_empresa);  
            return view('busqueda.busqueda_empresa',compact('empresa',$empresa));                
        }else if(Auth::user()->privilegio==11){
            $empresa=DB::select("SELECT * FROM empresa where id_asociacion=".Auth::user()->id_empresa);  
            return view('busqueda.busqueda_empresa',compact('empresa',$empresa));                
        }else if(Auth::user()->privilegio==12){
            $empresa=DB::select("SELECT * FROM empresa where id_asociacion=".Auth::user()->id_empresa);  
            return view('busqueda.busqueda_empresa',compact('empresa',$empresa));                
        }else{
            return view('errors.404');            
        }
	}
  
  //BUSCAR UNA EMPRESA ESPECIFICA
  function buscar_empresa($id){    
    $empresa=DB::select("SELECT * FROM empresa WHERE empresa.id=".$id);
    return response($empresa);
  }



 //BUSCAR TODAS LAS EMPRESAS
    public function buscar_todas_las_empresas(){  
        if(Auth::user()->privilegio == 1){
            $empresa=DB::select("SELECT * FROM empresa");
            return response($empresa);  
        }else if(Auth::user()->privilegio==10){
            $empresa=DB::select("SELECT empresa.* FROM empresa,empresa aso where empresa.id_asociacion=aso.id and aso.id_asociacion=".Auth::user()->id_empresa);  
            return response($empresa);
        }else if(Auth::user()->privilegio==11){
            $empresa=DB::select("SELECT * FROM empresa where id_asociacion=".Auth::user()->id_empresa);  
          return response($empresa);
        }else if(Auth::user()->privilegio==12){
            $empresa=DB::select("SELECT * FROM empresa where id_asociacion=".Auth::user()->id_empresa);  
          return response($empresa);
        }
        else{
            return view('errors.404');            
        }                                       
    }


    //ENVIAR NOTIFICACION A VARIOS taxiSTA EN BusquedaEmpresa
    function notificacion_conductores(Request $request){ 
        $mPushNotification = getPush("TAXICORP",$request['detalle_msn'],null,"","","","","","20");        
        $id_conductor=$request->get('id_conductor');
        $token=$request->get('token_not');
        $cont=0;
        $tokens = array(); 
        while ( $cont < count($id_conductor)) {
          if ( ($token[$cont] != "0") && ($token[$cont] != "") ) {     
            array_push($tokens, $token[$cont]);                            
          }
            $cont=$cont+1;                    
        }     
        send($tokens,$mPushNotification);        

       /* Notificacion::create([
            'titulo' => "ASAPP",
            'mensaje' => $request['detalle_msn'],
            'tipo' => 1,
            'id_administrador' => $request->user()->id,
        ]);*/

        Session::flash('message','ENVIADO CORRECTAMENTE');
        return Redirect::to('/BusquedaEmpresa_vehiculo');     
    }
}
