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

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Yajra\Datatables\Facades\Datatables;



class Tipo_gastoController extends Controller
{
         public function __construct() {
         $this->middleware('auth');
    }
    
   function index()
    {
            //ADMINISTRADOR DE TOD
          $tipo_gasto=DB::table('tipo_gasto')->where('id_empresa',Auth::user()->id_empresa)->orderby('nombre')->get();
        
       return view('tipo_gasto.index',['tipo_gasto'=>$tipo_gasto]);   
    }

    public function store(Request $request){
        	DB::beginTransaction(); 
        try {
        
                DB::table('tipo_gasto')->insert([
                  'nombre'=>$request['nombre'], 
                  'id_empresa'=>Auth::user()->id_empresa
                  ]
                  );      
                DB::commit();
                return redirect('/tipo_gasto')->with("message","SE REGISTRO CORRECTAMENTE");  

        } catch (Exception $e) {
          DB::rollback();
          return redirect('/tipo_gasto')->with("message-error","ERROR INTENTE NUEVAMENTE");      
        }      
    	}

    	public function update(Request $request){
    	DB::beginTransaction(); 
        try {
          $estado=0;
          $estado_pedido=0;
          if($request['estado_edit']){
            $estado=1;
          }
 
	         $pedido = DB::table('tipo_gasto')
	         ->where('id',$request['id_tipo_gasto_edit'])
           ->update([
            'nombre'=>$request['nombre_edit'],
            'estado'=>$estado, 
              ]);

          
                DB::commit();
                return redirect('/tipo_gasto')->with("message","SE ACTUALIZO CORRECTAMENTE");  

        } catch (Exception $e) {
          DB::rollback();
          return redirect('/tipo_gasto')->with("message-error","ERROR INTENTE NUEVAMENTE");      
        }      	
    		 
    	}


   

    function cargar_tipo_gasto($id_video){
        $apoderado=DB::select("SELECT * FROM tipo_gasto WHERE id=".$id_video);
        return response($apoderado);
    }

    // Alta rápida de tipo de gasto (AJAX) desde el modal de "Nuevo gasto".
    public function store_rapido(Request $request){
        $nombre = trim((string) $request->input('nombre', ''));
        if ($nombre === '') {
            return response()->json(['ok' => false, 'mensaje' => 'Ingrese un nombre.']);
        }

        $existente = DB::table('tipo_gasto')
            ->where('id_empresa', Auth::user()->id_empresa)
            ->whereRaw('LOWER(nombre) = ?', [mb_strtolower($nombre)])
            ->first();
        if ($existente) {
            return response()->json(['ok' => true, 'id' => $existente->id, 'nombre' => $existente->nombre, 'nuevo' => false]);
        }

        $id = DB::table('tipo_gasto')->insertGetId([
            'nombre' => $nombre,
            'id_empresa' => Auth::user()->id_empresa,
        ]);

        return response()->json(['ok' => true, 'id' => $id, 'nombre' => $nombre, 'nuevo' => true]);
    }

        function tipo_gasto_imprimir()
    { 
          $tipo_gasto=DB::select("SELECT * from tipo_gasto  where id_empresa='".Auth::user()->id_empresa."'");
            $empresa=DB::select("SELECT * from empresa  where id='".Auth::user()->id_empresa."'");
            
       $pdf=\PDF::loadView('tipo_gasto.tipo_gasto_imprimir',[
        'tipo_gasto'=>$tipo_gasto,
        'empresa'=>$empresa
      ]);    
      return   $pdf->stream(); 
    }       
}
