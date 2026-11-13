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

class TarifaController extends Controller
{
         public function __construct() {
         $this->middleware('auth');
    }
    
   function index()
    { 
            //ADMINISTRADOR DE TOD
          $tarifa=DB::table('tarifa')->where('id_empresa',Auth::user()->id_empresa)->orderby('id_empresa')->get();
        
       return view('tarifa.index',["tarifa"=>$tarifa]);   
    }

        function edit($id_tarifa)
    {
            //ADMINISTRADOR DE TOD
          $tarifa=DB::table('tarifa')
          ->where('id',$id_tarifa)
          ->get();


 
       return view('tarifa.edit',[
        "tarifa"=>$tarifa ]);   
    }
    function update(Request $request){
        $mostrar_tarifa_vallegrande=0;
        $mostrar_tarifa_montero=0;
        $mostrar_tarifa_camiri=0;
        $mostrar_tarifa_guarayo=0;
        
        if($request['mostrar_tarifa_vallegrande']){
           $mostrar_tarifa_vallegrande=1;
        }

        if($request['mostrar_tarifa_montero']){
           $mostrar_tarifa_montero=1;
        }
        
        if($request['mostrar_tarifa_camiri']){
           $mostrar_tarifa_camiri=1;
        }

        if($request['mostrar_tarifa_guarayo']){
           $mostrar_tarifa_guarayo=1;
        }



    	DB::beginTransaction(); 
        try {
	         $tarifa = DB::table('tarifa')
	         ->where('id',$request['id'])
	         ->update([
                'basica'=>$request['basica'],
	         	'distancia'=>$request['distancia'],
                'monto_distancia'=>$request['monto_distancia'],
	         	'tarifa_minima'=>$request['tarifa_minima'],
	         	'tiempo'=>$request['tiempo'],
                'monto_tiempo'=>$request['monto_tiempo'],
            'movil'=>$request['movil'],
            'lujo'=>$request['lujo'],
            'aire'=>$request['aire'],
            'maletero'=>$request['maletero'],
            'pedido'=>$request['pedido'],
            'reservar'=>$request['reservar'],
            'hora_inicio'=>$request['hora_inicio'],
            'hora_fin'=>$request['hora_fin'], 
            'monto_hora_nocturna'=>$request['monto_hora_nocturna'], 
            'basica_moto'=>$request['basica_moto'], 
            'distancia_moto'=>$request['distancia_moto'], 
            'monto_distancia_moto'=>$request['monto_distancia_moto'], 
            'tiempo_moto'=>$request['tiempo_moto'], 
            'monto_tiempo_moto'=>$request['monto_tiempo_moto'], 
            'pedido_moto'=>$request['pedido_moto'], 
            'hora_inicio_moto'=>$request['hora_inicio_moto'], 
            'hora_fin_moto'=>$request['hora_fin_moto'], 
            'monto_hora_nocturna_moto'=>$request['monto_hora_nocturna_moto'],
            'mostrar_tarifa_vallegrande'=>$mostrar_tarifa_vallegrande,
            'mostrar_tarifa_montero'=>$mostrar_tarifa_montero,
            'mostrar_tarifa_camiri'=>$mostrar_tarifa_camiri,
            'mostrar_tarifa_guarayo'=>$mostrar_tarifa_guarayo,

                'basica_pedido_moto'=>$request['basica_pedido_moto'],
                'distancia_pedido_moto'=>$request['distancia_pedido_moto'],
                'monto_distancia_pedido_moto'=>$request['monto_distancia_pedido_moto'],
                'tarifa_minima_pedido_moto'=>$request['tarifa_minima_pedido_moto'],
                'tiempo_pedido_moto'=>$request['tiempo_pedido_moto'],
                'monto_tiempo_pedido_moto'=>$request['monto_tiempo_pedido_moto'],
                'monto_hora_nocturna_moto'=>$request['monto_hora_nocturna_moto'],
                
                'monto_loquesea'=>$request['monto_loquesea'],
                'hora_inicio_loquesea'=>$request['hora_inicio_loquesea'],
                'hora_fin_loquesea'=>$request['hora_fin_loquesea'],

                'latitud'=>$request['latitud'],
                'longitud'=>$request['longitud'],
                'distancia_rango'=>$request['distancia_rango']
	         	 ]);

 

                DB::commit();
                return redirect('/tarifa')->with("message","SE ACTUALIZO CORRECTAMENTE");  

        } catch (Exception $e) {
          DB::rollback();
          return redirect('/tarifa')->with("message-error","ERROR INTENTE NUEVAMENTE");      
        }      	
    		 
    }
}
