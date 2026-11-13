<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\NotificacionRequest;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use App\Notificacion;
use App\Conductor; 
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use Exception;

class NotificacionController extends Controller
{
    public function __construct() {
         $this->middleware('auth');
    }

  function index(){
    
    $notificacion=DB::table('notificacion')->select('*')->where('notificacion.id_empresa', Auth::user()->id_empresa)->orderby('fecha')->get();

    if(Auth::user()->privilegio==1){
          //ADMINISTRADOR DE TOD
          return view("notificacion.administrador.index",compact('notificacion',$notificacion));        
        
        }elseif(Auth::user()->privilegio==10){
          //FEDERACION     
          return view("notificacion.administrador.index",compact('notificacion',$notificacion));
        }elseif(Auth::user()->privilegio==11){
          //ASOCIACION
          return view("notificacion.administrador.index",compact('notificacion',$notificacion));
        }else{ 
          //OTROS
          return view("notificacion.index",compact('notificacion',$notificacion));
        }
       
  }

    function index_dia(){
           
        $agenda=DB::select("SELECT * from agenda where id_empresa='".Auth::user()->id_empresa."'");
        return view("notificacion.index_dia",['agenda'=>$agenda]);
    }
  
  
  public function create(){
      return view('moto.create'); 
    }
 
    //ENVIAR NOTIFICACION A LOS MOVILES
    function store(NotificacionRequest $request){  

                $mPushNotification = getPush($request['titulo'],$request['mensaje'],null,"taxi","","","0","0","6");        

                $tokens = array(); 
                $tokens_pasajero = array(); 
                
              $tc_conductor=0;
              $tc_conductor_moto=0;
              $tc_conductor_torito=0;
              $tc_conductor_movil=0;
              $tc_pasajero=0;
              $tc_deudor=0;
              $total_pasajero=0;
              $total=0;

            
                if($request['cb_conductor_movil']){
                    $tc_conductor_movil=1;

                    $conductor_movil=DB::select("
                      SELECT c.token 
                      from conductor c, vehiculo v 
                      where 
                      c.id_vehiculo=v.placa and v.moto=0 
                      and c.login=1 and c.token is not null limit 998 ");

                     foreach ($conductor_movil as $key => $value) {
                     array_push($tokens, $value->token);  
                     $total+=1;
                    }


                     //ENVIAR NOTIFICACION A LOS CONDUCTORES
                   $sw_notificacion=send($tokens,$mPushNotification);
                } 
                if($request['cb_conductor_moto']){
                    $tc_conductor_moto=1;

                    $tokens = array();  

                    $conductor_moto=DB::select("SELECT c.token 
                      from conductor c, vehiculo v 
                      where 
                      c.id_vehiculo=v.placa and v.moto=1 
                      and c.login=1 and c.token is not null limit 998 ");

                     foreach ($conductor_moto as $key => $value) {
                     array_push($tokens, $value->token);  
                     $total+=1;
                    }

                     //ENVIAR NOTIFICACION A LOS CONDUCTORES
                   $sw_notificacion=send($tokens,$mPushNotification);
                } 


                if($request['cb_conductor_torito']){
                    $tc_conductor_torito=1;

                    $tokens = array(); 
                
                    $conductor_torito=DB::select("SELECT c.token 
                      from conductor c, vehiculo v 
                      where 
                      c.id_vehiculo=v.placa and v.moto=2 
                      and c.login=1 and c.token is not null limit 998  ");

                     foreach ($conductor_torito as $key => $value) {
                     array_push($tokens, $value->token);  
                     $total+=1;
                    }

                     //ENVIAR NOTIFICACION A LOS CONDUCTORES
                   $sw_notificacion=send($tokens,$mPushNotification);
                } 

                 if($request['cb_cliente']){
                  $tc_pasajero=1;
                  $inicio=0;
                  $fin=950;
                  $cantidad_cliente=0;


                  $tokens_pasajero = array(); 
                  $consulta_cliente=DB::select("SELECT count(*) as 'cantidad'  from usuario where token is not null  ");

                    foreach ($consulta_cliente as $key => $value) {
                     $cantidad_cliente=$value->cantidad;    
                    }

                    while ($inicio<=$cantidad_cliente)
                    {
                      $tokens_pasajero = array(); 

                      $pasajero=DB::select("SELECT token from usuario 
                        where token is not null 
                        group by token
                         limit  ".$inicio.",".$fin);
                      $inicio=$fin;
                      $fin+=995;
                        foreach ($pasajero as $key => $value) {
                         array_push($tokens_pasajero, $value->token);  
                         $total+=1;
                        }



                        $sw_notificacion=send($tokens_pasajero,$mPushNotification);
                    }

                    

                }

                 if($request['cb_cliente_pedido']){
                  $tc_pedido=1;

                  $inicio=0;
                  $fin=800;
                  $cantidad_cliente=0;

                  $tokens_pedido = array(); 
                  
                  $consulta_cliente=DB::select("SELECT count(*) as 'cantidad'  from usuario where token_traigo is not null  ");

                    foreach ($consulta_cliente as $key => $value) {
                     $cantidad_cliente=$value->cantidad;  
                    }

                    while ($inicio<=$cantidad_cliente)
                    {
                      $tokens_pedido = array(); 
                      
                      $pasajero=DB::select("SELECT token_traigo from usuario 
                        where token_traigo is not null 
                        group by token_traigo 
                        limit  ".$inicio.",".$fin);
                      $inicio=$fin;
                      $fin+=800;
                        foreach ($pasajero as $key => $value) {
                         array_push($tokens_pedido, $value->token_traigo);  
                         $total+=1;
                        }

                         $sw_notificacion=send($tokens_pedido,$mPushNotification);
                    }

                   
                }


                if($request['cb_deudor']){
                  $tc_deudor=1;
                  
                   


                     //ENVIAR NOTIFICACION A LOS CONDUCTORES
                   $sw_notificacion=send($tokens,$mPushNotification);
                }
                

             

             if($sw_notificacion===FALSE)
             {
                Session::flash('message-error','NO SE ENVIO LA NOTIFICAION  error:'.$sw_notificacion." mensaje =".$request['mensaje']);  
             }
             else
             {

              $obj = json_decode($sw_notificacion);
              $enviado=0;
              $error=0;
              try{
              $enviado=$obj->{'success'};
              $error=$obj->{'failure'}; 
              }catch(Exception $e)
              {
                 $enviado=0;
                 $error=0;
              }
             
             
              $total=$enviado+$error;
  

              Session::flash('message','ENVIADO CORRECTAMENTE. Correcto:'.$enviado." Error:".$error);

              //REGISTRAR EL ENVIO DE NOTIFICACION.
             try {
                  DB::beginTransaction();

                        DB::table('notificacion')->insert([
                          'titulo' => $request['titulo'], 
                          'mensaje' =>$request['mensaje'],
                          'enviado'=>$enviado,
                          'error'=>$error,
                          'total'=>$total,
                          'tp_pasajero'=>$tc_pasajero,
                          'tp_conductor'=>$tc_conductor,
                          'tp_conductor_moto'=>$tc_conductor_moto,
                          'tp_conductor_torito'=>$tc_conductor_torito,
                          'tp_conductor_movil'=>$tc_conductor_movil,
                          'tp_deudor'=>$tc_deudor,
                          'id_empresa'=>Auth::user()->id_empresa
                        ]); 

                          DB::commit();  

                  }catch (Exception $e) {
                      DB::rollback();
                  }   
             }
      

                return Redirect::to('/notificacion');            
    }
    


        //MUESTRA UN SOLO MOTISTA ESPESIFICO
    public function Cargar_Notificacion($fecha_inicio, $fecha_fin){      
        $lista=DB::select("SELECT notificacion.id,notificacion.titulo,notificacion.mensaje,DATE_FORMAT(notificacion.fecha, '%d-%m-%Y %h:%i %p')as fecha,notificacion.tipo,notificacion.id_administrador,CONCAT(users.nombre,' ',users.apellido)as administrador FROM notificacion,users WHERE users.id=notificacion.id_administrador and notificacion.fecha BETWEEN '".$fecha_inicio."' AND DATE_SUB('".$fecha_fin."', INTERVAL -1 DAY) ORDER BY notificacion.fecha ASC");        
        return response($lista);
    }

}
