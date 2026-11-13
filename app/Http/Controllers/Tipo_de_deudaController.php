<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use App\Usuario;
use App\Notificacion;
use Exception;
use Illuminate\Support\Facades\DB;



class Tipo_de_deudaController extends Controller
{
         public function __construct() {
         $this->middleware('auth');
    }
    
   function index()
    {
            //ADMINISTRADOR DE TOD
          $tipo_de_deuda=DB::table('tipo_de_deuda')->where('id_empresa',Auth::user()->id_empresa)->orderby('id_empresa')->get();
        
       return view('tipo_de_deuda.index',['tipo_de_deuda'=>$tipo_de_deuda]);   
    }

    public function store(Request $request){
        	DB::beginTransaction(); 
        try {
        
                DB::table('tipo_de_deuda')->insert([
                  'nombre'=>$request['nombre'], 
                  'id_empresa'=>$request['id_empresa']
                  ]
                  );      
                DB::commit();
                return redirect('/tipo_de_deuda')->with("message","SE REGISTRO CORRECTAMENTE");  

        } catch (Exception $e) {
          DB::rollback();
          return redirect('/tipo_de_deuda')->with("message-error","ERROR INTENTE NUEVAMENTE");      
        }      
    	}

    	public function update(Request $request){
    		$estado=0;
    		if($request['estado_edit']){
    			$estado=1;
    		}

    	DB::beginTransaction(); 
        try {
	         $pedido = DB::table('tipo_de_deuda')
	         ->where('id',$request['id_tipo_de_deuda_edit'])
	         ->update(['nombre'=>$request['nombre_edit'],
	         	'estado'=>$estado ]);
                DB::commit();
                return redirect('/tipo_de_deuda')->with("message","SE ACTUALIZO CORRECTAMENTE");  

        } catch (Exception $e) {
          DB::rollback();
          return redirect('/tipo_de_deuda')->with("message-error","ERROR INTENTE NUEVAMENTE");      
        }      	
    		 
    	}

    function cargar_tipo_de_deuda($id_video){
        $apoderado=DB::select("SELECT * FROM tipo_de_deuda WHERE id=".$id_video);
        return response($apoderado);
    }         
}
