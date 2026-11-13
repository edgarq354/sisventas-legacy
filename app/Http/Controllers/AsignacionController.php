<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AsignacionRequest;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use App\Asignacion;
use App\Notificacion;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Exception;
use Illuminate\Support\Facades\Validator;

class AsignacionController extends Controller
{
    public function __construct() {
         $this->middleware('auth');
    }

	function index(){
        //SELECT asignacion.id_conductor,conductor.expedido,CONCAT(conductor.nombre,' ',conductor.paterno,' ',conductor.materno) as conductor, conductor.celular, asignacion.id_vehiculo, vehiculo.marca,vehiculo.modelo,vehiculo.clase,vehiculo.tipo, empresa.nit, empresa.razon_social FROM asignacion,conductor,vehiculo,empresa WHERE conductor.ci=asignacion.id_conductor AND vehiculo.placa=asignacion.id_vehiculo AND asignacion.id_empresa=empresa.id AND asignacion.id_conductor=9687454 AND asignacion.id_vehiculo="1994GTV"

        $asignacion=DB::table('conductor')
        ->join('vehiculo','vehiculo.placa','=','conductor.id_vehiculo')
        ->select('conductor.ci',
         'conductor.expedido',
          'conductor.nombre',
          'conductor.paterno',
          'conductor.materno',
          'conductor.celular', 
          'conductor.id_vehiculo',
          'vehiculo.marca', 
          'vehiculo.clase' ,
          'vehiculo.modelo',
          'vehiculo.tipo',
          'conductor.id_empresa',
          'vehiculo.codigo_empresa',
          'conductor.estado_asignacion')
        ->orderby('conductor.nombre')
        ->get();
    return view('asignacion.index',["asignacion"=>$asignacion]);        

   


	}
  
  
	public function create(){
       $conductor=DB::select("SELECT expedido,ci,nombre,paterno,materno from conductor WHERE id_empresa=".Auth::user()->id_empresa);
       $vehiculo=DB::select("SELECT placa,modelo,marca,tipo,clase from vehiculo WHERE id_empresa=".Auth::user()->id_empresa);



     






       if(Auth::user()->privilegio==1){
          //ADMINISTRADOR DE TOD
          $empresa=DB::table('empresa')
                ->select('empresa.*')
                ->get();
         $buscar_conductor=DB::table('conductor')->select('conductor.expedido','conductor.ci','conductor.nombre','conductor.paterno','conductor.materno')->orderby('id_empresa')->get();
         $buscar_vehiculo=DB::table('vehiculo')->orderby('id_empresa')->select('vehiculo.placa','vehiculo.modelo','vehiculo.marca','vehiculo.tipo','vehiculo.clase')->get();

        }elseif(Auth::user()->privilegio==10){
          //FEDERACION
          $empresa=DB::table('empresa AS e')
                ->join('departamento AS dep','dep.id','=','e.id_departamento')
                ->where('e.id_asociacion','=',Auth::user()->id_empresa)
                ->select('e.*','dep.nombre AS departamento')
                ->get();
           $buscar_conductor=DB::table('conductor AS c')
                ->join('empresa AS e','e.id','=','c.id_empresa')
                ->join('empresa AS a','a.id','=','e.id_asociacion')
                ->where('a.id_asociacion','=',Auth::user()->id_empresa)
                ->select('conductor.expedido','conductor.ci','conductor.nombre','conductor.paterno','conductor.materno','e.razon_social')->get();   
           $buscar_vehiculo=DB::table('vehiculo AS c')
                ->join('empresa AS e','e.id','=','c.id_empresa')
                ->join('empresa AS a','a.id','=','e.id_asociacion')
                ->where('a.id_asociacion','=',Auth::user()->id_empresa)
                ->select('vehiculo.placa','vehiculo.modelo','vehiculo.marca','vehiculo.tipo','vehiculo.clase','e.razon_social')
                ->get();                  

        }elseif(Auth::user()->privilegio==11){
          //ASOCIACION
        
          $empresa=DB::table('empresa')
                ->where('empresa.id_asociacion','=',Auth::user()->id_empresa)
                ->select('empresa.*')
                ->get();
          $buscar_conductor=DB::table('conductor')
                ->join('empresa','empresa.id','=','conductor.id_empresa')
                ->where('empresa.id_asociacion','=',Auth::user()->id_empresa)
                ->select('conductor.expedido','conductor.ci','conductor.nombre','conductor.paterno','conductor.materno','empresa.razon_social')->get();
         $buscar_vehiculo=DB::table('vehiculo')
                ->join('empresa','empresa.id','=','vehiculo.id_empresa')
                ->where('empresa.id_asociacion','=',Auth::user()->id_empresa)
                ->select('vehiculo.placa','vehiculo.modelo','vehiculo.marca','vehiculo.tipo','vehiculo.clase','empresa.razon_social')
                ->get();       

      } elseif(Auth::user()->privilegio==12){
          //POLICIA
        
          $empresa=DB::table('empresa')
                ->where('empresa.id_asociacion','=',Auth::user()->id_empresa)
                ->select('empresa.*')
                ->get();
          $buscar_conductor=DB::table('conductor')
                ->join('empresa','empresa.id','=','conductor.id_empresa')
                ->where('empresa.id_asociacion','=',Auth::user()->id_empresa)
                ->select('conductor.expedido','conductor.ci','conductor.nombre','conductor.paterno','conductor.materno','empresa.razon_social')->get();   
         $buscar_vehiculo=DB::table('vehiculo')
                ->join('empresa','empresa.id','=','vehiculo.id_empresa')
                ->where('empresa.id_asociacion','=',Auth::user()->id_empresa)
                ->select('vehiculo.placa','vehiculo.modelo','vehiculo.marca','vehiculo.tipo','vehiculo.clase','empresa.razon_social')
                ->get();          
      } else {
       $empresa=DB::table('empresa')
                ->select('empresa.*')
                ->paginate(10);
          $buscar_conductor=DB::table('conductor')->select('conductor.expedido','conductor.ci','conductor.nombre','conductor.paterno','conductor.materno')->where('conductor.id_empresa', Auth::user()->id_empresa)->orderby('nombre')->get();
          $buscar_vehiculo=DB::table('vehiculo')->select('vehiculo.placa','vehiculo.modelo','vehiculo.marca','vehiculo.tipo','vehiculo.clase')->where('vehiculo.id_empresa', Auth::user()->id_empresa)->orderby('placa')->get();
         } 


        return view('asignacion.create',['conductor'=>$buscar_conductor,'vehiculo'=>$buscar_vehiculo,'empresa'=>$empresa]);	
    }
 
    public function store(AsignacionRequest $request){
      try {
      DB::beginTransaction();
       $verificar=DB::select("SELECT COUNT(*)as contador from asignacion WHERE asignacion.id_conductor=".$request['ci']);
        foreach ($verificar as $key => $value) {
          $contador=$value->contador;
        }
        if ($contador==0) {  //SI EL CONTADOR ES IGUAL A  ESQ NO EXISTE ESE CARNET
             DB::table('asignacion')->insert([ 
             'id_conductor' => $request['ci'], 'id_vehiculo' => $request['placa'], 'id_empresa' => $request['id_empresa'], 'codigo_empresa' => $request['codigo_empresa'],'estado' => $request['estado'], 'latitud' => $request['latitud'],'longitud' => $request['longitud']
             ]); 
              DB::commit();          
            Session::flash('message','CREADO CORRECTAMENTE');
            return Redirect::to('/asignacion');                                                                 
           }         
        else {
            Session::flash('message-error','YA EXISTE UNO DE ESTOS DATOS, VERIFIQUE PORFAVOR');
            return Redirect::to('/asignacion/create'); 
        }     
      }catch (Exception $e) {
          DB::rollback();
          return redirect('/asignacion/create')->with("message-error","ERROR INTENTE NUEVAMENTE");      
      }   
    }

    public function edit($ci,$placa){
       $asignacion = DB::select("SELECT * FROM conductor,vehiculo,asignacion where asignacion.id_conductor=conductor.ci AND asignacion.id_vehiculo=vehiculo.placa AND conductor.ci=".$ci." AND vehiculo.placa='".$placa."'");

       $buscar_conductor=DB::select("SELECT expedido,ci,nombre,paterno,materno from conductor WHERE id_empresa=".Auth::user()->id_empresa);
       $buscar_vehiculo=DB::select("SELECT placa,modelo,marca,tipo,clase from vehiculo WHERE id_empresa=".Auth::user()->id_empresa);




       //DATOS DE EMPRESAS
        if(Auth::user()->privilegio==1){
          //ADMINISTRADOR DE TOD
          $empresa=DB::table('empresa')
                ->select('empresa.*')
                ->get();
        }elseif(Auth::user()->privilegio==10){
          //FEDERACION
          $empresa=DB::table('empresa AS e')
                ->join('departamento AS dep','dep.id','=','e.id_departamento')
                ->where('e.id_asociacion','=',Auth::user()->id_empresa)
                ->select('e.*','dep.nombre AS departamento')
                ->get();

        }elseif(Auth::user()->privilegio==11){
          //ASOCIACION
        
          $empresa=DB::table('empresa')
                ->where('empresa.id_asociacion','=',Auth::user()->id_empresa)
                ->select('empresa.*')
                ->get();

      } elseif(Auth::user()->privilegio==12){
          //POLICIA
        
          $empresa=DB::table('empresa')
                ->where('empresa.id_asociacion','=',Auth::user()->id_empresa)
                ->select('empresa.*')
                ->get();
      } else {
       $empresa=DB::table('empresa')
                ->select('empresa.*')
                ->paginate(10);
         }  



       return view('asignacion.edit',['asignacion'=>$asignacion,'buscar_conductor'=>$buscar_conductor,'buscar_vehiculo'=>$buscar_vehiculo,'empresa'=>$empresa]);
    }

    public function update(Request $request){
      $id_conductor=$request->get("ci");
      $id_vehiculo=$request->get("placa");

$conductor = DB::select("SELECT c.token,concat(c.nombre,' ',c.paterno,' ',c.materno) as conductor,a.estado as 'estado' FROM conductor c,asignacion a where a.id_conductor=c.ci and ci='".$id_conductor."' limit 1");
 

      DB::table('asignacion')->where('id_conductor', $id_conductor)->where('id_vehiculo',$id_vehiculo)->update(['codigo_empresa' => $request['codigo_empresa'],'estado'=>$request['estado'] ]);
      Session::flash('message','ACTUALIZADO CORRECTAMENTE');
 


      $tokens=array();
      $nombre="";
      $estado="";
      foreach ($conductor as $key => $value) {
        array_push($tokens,$value->token);
        $nombre=$value->conductor;
        $estado=$value->estado;
      }
      try{
      if($estado!=$request['estado']){
        if($request['estado']=="0"){
        enviar_notificacion("Taxi-Corp","Señor ".$nombre." su cuenta esta INACTIVA. Por favor contactece con el administrador de la empresa de Radio Taxi.","6",$tokens);
      }else {
        enviar_notificacion("Taxi-Corp","Señor ".$nombre." su cuenta esta ACTIVA. Ahora puedes continuar con nuestros servicios.","6",$tokens);
      }}
      }catch(Exception $e)
      {

      }

      return Redirect::to('/asignacion'); 
    }
    
    public function destroy($id, Request $request){
        $Asignacion=Asignacion::find($id);
        $Asignacion->delete();
        Session::flash('message','Asignacion Eliminado Correctamente');
       return Redirect::to('/Asignacion');
    }

    //CARGAR PARA VERIFICAR SI EXISTE EL CI DEL CUNDUCTOR
    function verificar_ci_Asignacion($ci,$expedido){
        $Asignacion=DB::select("SELECT count(*)as contador,Asignacion.* FROM Asignacion where Asignacion.ci=".$ci. " AND Asignacion.expedido='".$expedido."'");
        return response($Asignacion);
    }

    //CARGAR PARA VERIFICAR SI EXISTE LA PLACA DEL VEHICULO
    function verificar_placa_asignacion($placa){
      $vehiculo=DB::select("SELECT COUNT(*)as contador, vehiculo.* from vehiculo WHERE vehiculo.placa='".$placa."'");
      return response($vehiculo);
    }    

    function cargar_asignacion($ci){
      $asignacion=DB::select("SELECT asignacion.id_conductor,conductor.expedido,CONCAT(conductor.nombre,' ',conductor.paterno,' ',conductor.materno) as conductor, conductor.celular,asignacion.codigo_empresa, asignacion.id_vehiculo, vehiculo.marca,vehiculo.modelo,vehiculo.clase,vehiculo.tipo, empresa.nit, empresa.razon_social FROM asignacion,conductor,vehiculo,empresa WHERE conductor.ci=asignacion.id_conductor AND vehiculo.placa=asignacion.id_vehiculo and asignacion.estado<2 AND asignacion.id_empresa=empresa.id AND conductor.ci=".$ci);
      return response($asignacion);
    } 
 
}
