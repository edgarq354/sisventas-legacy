<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ConductorRequest;
use App\Http\Requests\ConductorUpdateRequest;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use App\Conductor;
use App\Fotocopia;
use App\Foto;
use App\Notificacion;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Exception;
use Yajra\Datatables\Facades\Datatables;


use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


class ConductorController extends Controller
{
    public function __construct() {
         $this->middleware('auth');
    }

	function index(){

       $conductor=DB::select("(SELECT c.*,'1'as 'tipo_asignacion',v.codigo_empresa from conductor c, vehiculo v where c.estado_asignacion<>6 and c.id_vehiculo=v.placa) 
            union( SELECT cc.*,'0'as 'tipo_asignacion',''  from conductor cc where cc.estado_asignacion<>6 and cc.id_vehiculo not in (SELECT placa from vehiculo))");
       $tipo=DB::select("SELECT * from tipo_ingreso_egreso  where estado=1");
     
    return view('conductor.index',["conductor"=>$conductor,'tipo'=>$tipo]);        
    
	}

  public function conductor_retirado(){
        $conductor=DB::select("(SELECT c.*,'1'as 'tipo_asignacion',v.codigo_empresa from conductor c, vehiculo v where c.estado_asignacion=6 and c.pre_registro=0 and c.id_vehiculo=v.placa) 
            union( SELECT cc.*,'0'as 'tipo_asignacion',''  from conductor cc where cc.estado_asignacion=6 and cc.pre_registro=0 and cc.id_vehiculo not in (SELECT placa from vehiculo))");
       
       
     
    return view('conductor.index_retirado',["conductor"=>$conductor]);  
  }

     public function conductor_pre_registro(){
        $conductor=DB::select("(SELECT c.*,'1'as 'tipo_asignacion',v.codigo_empresa from conductor c, vehiculo v where c.estado_asignacion=6 and c.id_vehiculo=v.placa and c.pre_registro=1) 
            union( SELECT cc.*,'0'as 'tipo_asignacion',''  from conductor cc where cc.estado_asignacion=6 and cc.pre_registro=1 and cc.id_vehiculo not in (SELECT placa from vehiculo))");
       
     
    return view('conductor.index_pre_registro',["conductor"=>$conductor]);  
  }


  public function conductorcalles(){
    return DataTables::of(DB::table('conductor')->select('*')->where('conductor.id_empresa', Auth::user()->id_empresa)->orderby('nombre')->get())->make(true);
  }
  

public function create(){
    
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
                ->get();
         }            
         $numero_movil=DB::table('numero_movil')
         ->select('numero_movil.*')
         ->where('estado','=','DISPONIBLE')
         ->get();

       return view('conductor.create',['empresa'=>$empresa,'numero_movil'=>$numero_movil]);
    }
 
public function store(ConductorRequest $request){
      try {
      DB::beginTransaction();
       $verificar=DB::select("SELECT COUNT(*)as contador from conductor WHERE conductor.ci=".$request['ci']);
        foreach ($verificar as $key => $value) {
          $contador=$value->contador;
        }
        if ($contador==0) {  //SI EL CONTADOR ES IGUAL A  ESQ NO EXISTE ESE CARNET
            $direccion_perfil = "";
            //GUARDAR LA FOTO DE PERFIL DEL CONDUCTOR
            if ($request['perfil'] != "") {
                $gestor = fopen($request['perfil'], "r");
                $contenido = fread($gestor, filesize($request['perfil']));
                $contenido =$contenido;
                fclose($gestor);      
                $direccion_perfil = "Imagen_Conductor/Perfil-".$request['ci'].".png";                
                file_put_contents($direccion_perfil, $contenido);    
                 
            }
                $fecha_inicio_pago=date ( 'Y-m-j');
                $fecha_fin_pago=date('Y-m-j',strtotime( '+1 year' , strtotime ( $fecha_inicio_pago ) )) ;

                $monto="0";
                $frecuencia=DB::select("SELECT anio,frecuencia_dia,frecuencia_semana,frecuencia_mes  FROM ajuste where id_empresa='".Auth::user()->id_empresa."' order by anio desc limit 1 ");
                
                switch ($request['tipo_de_pago']) {
                    case 'DIA':
                    $monto=$frecuencia[0]->frecuencia_dia;
                        break;
                    case 'SEMANA':
                    $monto=$frecuencia[0]->frecuencia_semana;
                        break;
                    case 'MES':
                    $monto=$frecuencia[0]->frecuencia_mes;
                        break;        
                    
                    default:
                        # code...
                        break;
                }

             DB::table('conductor')->insert([ // SE INSERTA AL CONDUCTOR
             'ci' => $request['ci'],
             'fecha_inicio_pago'=>$fecha_inicio_pago,
             'fecha_fin_pago'=>$fecha_fin_pago,
             'expedido' => $request['expedido'], 
             'nombre' => ucfirst(strtolower($request['nombre'])), 
             'paterno' => ucfirst(strtolower($request['paterno'])),
             'materno' => ucfirst(strtolower($request['materno'])), 
             'fecha_nacimiento' => $request['fecha_nacimiento'],
             'sexo' => $request['sexo'],
             'celular' => $request['celular'],
             'imei' => $request['imei'],
             'correo' => $request['correo'],
             'usuario' => $request['usuario'],
             'contrasenia' => $request['contrasenia'],
             'direccion' => $request['direccion'],
             'latitud' => $request['latitud'],'longitud' => $request['longitud'],
             'estado' => $request['estado'],'login' => $request['login'], 
             'credito' => $request['credito'], 'token' => $request['token'], 
             'direccion_imagen' => $direccion_perfil, 
             'categoria_licencia' => $request['categoria_licencia'], 
             'tipo' => $request['tipo'], 'bloqueo' => $request['bloqueo'],
             'aceptar_condiciones' => $request['aceptar_condiciones'],
             'monto_frecuencia'=>$monto,
             'id_empresa' => $request['id_empresa'],
             'tipo_de_pago' => $request['tipo_de_pago'],
             'monto_garantia'=>$request['monto_garantia'],
             'ahorro'=>$request['ahorro'],
             'descripcion'=>$request['descripcion'],
             'localidad'=>$request['localidad'],
             'ci_referencia'=>$request['ci_referencia'],
             'nombre_referencia'=>$request['nombre_referencia'],
             'parentezco_referencia'=>$request['parentezco_referencia'],
             'domicilio_referencia'=>$request['domicilio_referencia'],
               ]);  
               //Verificar si tiene Vehiculo...
               if($request['placa']!=''){
         
              $contador_vehiculo=0;
               $verificar=DB::select("SELECT COUNT(*)as contador from vehiculo WHERE vehiculo.placa='".$request['placa']." ' ");
                foreach ($verificar as $key => $value) {
                  $contador_vehiculo=$value->contador;
                }
                if ($contador_vehiculo==0) {   

                  $propietario=DB::select("SELECT COUNT(*)as contador from duenio WHERE duenio.ci=".$request['ci']);
                   if ($propietario[0]->contador == 0) { //SI NO EXISTE NINGUN PROPIETARIO EN LA TABLA DUENIO SE CREA
                       
                        DB::table('duenio')->insert([
                          'ci'=>$request['ci'], 
                          'expedido'=>$request['expedido'],
                          'nombre'=>$request['nombre'], 
                          'paterno'=>$request['paterno'],
                          'materno'=>$request['materno']]);
                       }             
                
                        //Insertar Imagen del vehiculo
                        $direccion_imagen_adelante="";
                        if ($request['fotoVehiculo'] != "") {
                           
                          $archivo = $request->file('fotoVehiculo');
                          $input  = array('image' => $archivo) ;
                          $reglas = array('image' => 'required|image|mimes:jpeg,jpg,bmp,png,gif|max:15000');
                          $validacion = Validator::make($input,  $reglas);
                          if ($validacion->fails()){
                            echo "Error";
                          }
                          else
                          {
                          $nombre_original=$archivo->getClientOriginalName();
                          $extension=$archivo->getClientOriginalExtension();
                          $nuevo_nombre="FotoVehiculoAdelante-".$request['placa'].".".$extension;
                          $r1=Storage::disk('Imagen_Vehiculo')->put($nuevo_nombre,  \File::get($archivo) );
                          $direccion_imagen_adelante="../storage/Imagen_Vehiculo/".$nuevo_nombre;
                          }
                        }


                //Registrar Vehiculo          
                   
                        DB::table('vehiculo')->insert([ // LA TERCERA TABLA FASE GALPON
                        'placa' => strtoupper($request['placa']), 
                        'marca' => strtoupper($request['marca']), 
                        'modelo' => $request['modelo'], 
                        'cilindrada' => '0',
                        'color' => $request['color'], 
                        'tipo' => $request['tipo'],
                        'clase' => $request['clase'],
                        'nro_poliza' => '0', 
                        'movil' =>'1',  
                        'codigo_empresa' => $request['numero_movil'],
                        'nro_chasis' => $request['nro_chasis'], 
                        'id_propietario' => $request['ci'],   
                        'nro_soat' => $request['nro_soat'], 
                        'nro_inspeccion_tecnica' => $request['nro_inspeccion_tecnica'], 
                        'clasificacion_vehiculo' => $request['clasificacion_vehiculo'],  
                        'direccion_imagen_adelante' => $direccion_imagen_adelante, 
                        'id_empresa' => $request['id_empresa']
                        ]);   
 
                    } else{
                        //Asignacion de vehiculo con el conductor
                        DB::table('asignacion')->insert([ 
                          'descripcion'=>'MOVIL LIBERADO',
                          'id_vehiculo'=>$request['placa'],
                          'numero_movil'=>$request['numero_movil']]);
                        DB::table('historial_baja_alta')->insert([
                          'descripcion' =>'LIBERADO POR EL SISTEMA PARA ASIGNAR CON OTRO CONDUCTOR',
                          'id_vehiculo'=>$request['placa'],
                          'id_login'=>Auth::user()->id, 
                          'fecha' => DB::raw('now()'),
                          'tipo'=>'0',
                          'numero_movil' =>$request['numero_movil']]);
                    }
                    //Registar alta del Movil
                     DB::table('historial_baja_alta')->insert([
                      'descripcion' =>$request['descripcion'],
                      'id_vehiculo'=>$request['placa'],
                      'id_login'=>Auth::user()->id, 
                      'fecha' => DB::raw('now()'),
                      'numero_movil' =>$request['numero_movil'],
                      'tipo'=>'1']);
                    //Asignacion de vehiculo con el conductor
                        DB::table('asignacion')->insert([
                          'id_conductor' =>$request['ci'],
                          'descripcion'=>'ASIGNADO',
                          'id_vehiculo'=>$request['placa'],
                          'numero_movil'=>$request['numero_movil']]);
                        //Actualizacion del Numero de Movil
                         DB::table('numero_movil')
                         ->where('numero_movil', $request['numero_movil'])
                         ->update([
                         'id_vehiculo'=>$request['id_vehiculo'],
                         'id_conductor' =>$request['ci'],
                          'estado'=>'OCUPADO'
                          ]); 

                        //ACTUALIZA CUANDO NO TIENE IMAGEN
                        DB::table('conductor')->where('ci', $request['ci'])->update([
                          'id_vehiculo'=>$request['placa'],
                          'numero_movil'=>$request['numero_movil']
                          ]);  

              }
              DB::commit();          
            Session::flash('message','CREADO CORRECTAMENTE');
            return Redirect::to('/conductor');                                                                 
           }else {
            Session::flash('message-error','YA EXISTE UN CONDUCTOR CON ESE C.I.');
            return Redirect::to('/conductor/create'); 
        }     
      }catch (Exception $e) {
          DB::rollback();
          return redirect('/conductor/create')->with("message-error","ERROR INTENTE NUEVAMENTE");      
      }   
    }



    function crear_archivos($imagen, $ci, $cont, $direccion){
        $gestor = fopen($imagen, "r");
        $contenido = fread($gestor, filesize($imagen));
        $contenido = base64_encode($contenido);
        fclose($gestor);      
        //$direccion_fotocopias_aux = "Imagen_Conductor/".$ci."(".$cont.").txt";                
        file_put_contents($direccion, $contenido);  
    }



    public function edit($ci){
       $conductor = DB::select("SELECT count(*)as contador,conductor.* FROM conductor where conductor.ci=".$ci);

       $perfil = DB::select("SELECT fo.* FROM conductor c,foto fo, fotocopia f where  f.id=fo.id_fotocopia and f.id=c.id_fotocopia_perfil and c.ci=".$ci." order by fo.id desc");

       $cedula = DB::select("SELECT fo.* FROM conductor c,foto fo, fotocopia f where  f.id=fo.id_fotocopia and f.id=c.id_fotocopia_ci and c.ci=".$ci);

       $licencia = DB::select("SELECT fo.* FROM conductor c,foto fo, fotocopia f where  f.id=fo.id_fotocopia and f.id=c.id_fotocopia_licencia and c.ci=".$ci);

       $ham= DB::select("SELECT fo.* FROM conductor c,foto fo, fotocopia f where  f.id=fo.id_fotocopia and f.id=c.id_fotocopia_tarjeta_de_identificacion_de_ham and c.ci=".$ci);

       $transito = DB::select("SELECT fo.* FROM conductor c,foto fo, fotocopia f where  f.id=fo.id_fotocopia and f.id=c.id_fotocopia_tarjeta_de_identificacion_de_transito and c.ci=".$ci);

       $factura = DB::select("SELECT fo.* FROM conductor c,foto fo, fotocopia f where  f.id=fo.id_fotocopia and f.id=c.id_fotocopia_factura_de_agua_luz and c.ci=".$ci);

       $antecedentes = DB::select("SELECT fo.* FROM conductor c,foto fo, fotocopia f where  f.id=fo.id_fotocopia and f.id=c.id_fotocopia_certificado_de_antecedentes_del_transito and c.ci=".$ci);

       $felcc = DB::select("SELECT fo.* FROM conductor c,foto fo, fotocopia f where  f.id=fo.id_fotocopia and f.id=c.id_fotocopia_certificado_de_antecedentes_del_felcc and c.ci=".$ci);
 
       

       $deuda = DB::select("SELECT count(*) as 'numero',sum(f.monto) as 'monto' from frecuencia f,conductor c where c.ci='".$ci."' AND c.id_empresa='".Auth::user()->id_empresa."' and f.tipo=c.tipo_de_pago and f.fecha_fin<now() and f.fecha_inicio>c.fecha_inicio_pago and f.id not in(SELECT df.id_frecuencia from pago_frecuencia pf,detalle_frecuencia df,conductor c where c.ci=pf.id_conductor and pf.id=df.id_pago_frecuencia and pf.id_conductor='".$ci."' and c.id_empresa='".Auth::user()->id_empresa."' and f.fecha_inicio>c.fecha_inicio_pago )");
       $vehiculo = DB::select("SELECT v.* from vehiculo v where v.estado<>6 and v.placa not in(select c.id_vehiculo from conductor c)  ");
        $imei = DB::select("SELECT * from imei_bk where id_conductor='".$ci."' ");
      





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


       return view('conductor.edit',[
        'conductor'=>$conductor,
        'cedula'=>$cedula,
          'deuda'=>$deuda,
          'cedula'=>$cedula,
        'licencia'=>$licencia,
        'ham'=>$ham,
        'transito'=>$transito,
        'factura'=>$factura,
        'antecedentes'=>$antecedentes,
        'felcc'=>$felcc, 
        'empresa'=>$empresa,
        'vehiculo'=>$vehiculo,
        'perfil'=>$perfil,
        'imei'=>$imei]);
    }


      //CODIGO PARA AJAX  REGISTRAR UN NUEVO USUARIO

    function enviar_notificacion_activar(Request $request){
        $mensaje="Activado.";
        $token=$request['token'];
       
                   
 
                         $token_conductor = array();  
                          array_push($token_conductor,$token);

                          // obtener el token del objeto de base de datos
                             $mPushNotification_cond= getPush('Activar servicio','Activar servicio.',null,"usuario","","","0","0","19");
                       
                         // obteniendo el empuje del objeto push
                            $sw_notificacion_cond=send($token_conductor,$mPushNotification_cond);
                            $mensaje="Solicitud asignada con el conductor.";

       return view("mensajes.msj_rechazado")->with("msj",$mensaje);
      }

       function enviar_notificacion_desactivar(Request $request){
       $mensaje="Activado.";
        $token=$request['token'];
       
                   
 
                         $token_conductor = array();  
                          array_push($token_conductor,$token);

                          // obtener el token del objeto de base de datos
                             $mPushNotification_cond= getPush('Desactivar servicio','Desactivar servicio.',null,"usuario","","","0","0","20");
                       
                         // obteniendo el empuje del objeto push
                            $sw_notificacion_cond=send($token_conductor,$mPushNotification_cond);
                            $mensaje="Solicitud asignada con el conductor";

       return view("mensajes.msj_rechazado")->with("msj",$mensaje);
      }


function enviar_notificacion_contacto(Request $request){
       $mensaje="Activado.";
        $token=$request['token'];
       
 $mPushNotification = getPush('Contacto servicio','Contacto servicio.',null,"taxi","","","0","0","40");        
                $tokens = array(); 

                $conductor=DB::select("SELECT token  from conductor WHERE  ci=".$request['id_conductor']);    
                
                foreach ($conductor as $key => $con) {
                     array_push($tokens, $con->token); 
                    }                                   
                $sw_notificacion=send($tokens,$mPushNotification);

                   /*
                         $token_conductor = array();  
                          array_push($token_conductor,$token);

                          // obtener el token del objeto de base de datos
                             $mPushNotification_cond= getPush('Contacto servicio','Contacto servicio.',null,"usuario","","","0","0","40");
                       
                         // obteniendo el empuje del objeto push
                            $sw_notificacion_cond=send($token_conductor,$mPushNotification_cond);
                            */
        $mensaje="Solicitud obtener contactos del conductor".$sw_notificacion;

       return view("mensajes.msj_rechazado")->with("msj",$mensaje);
      }


    public function Actualizar_Conductor(ConductorUpdateRequest $request){
      if ($request['ci'] == $request['ci_aux']) {

            
                //ACTUALIZA CUANDO NO TIENE IMAGEN
                      DB::table('conductor')->where('ci', $request['ci'])->update([
                        'expedido' => $request['expedido'], 
                        'fecha_registro' => $request['fecha_registro'], 
                        'nombre' => ucfirst(strtolower($request['nombre'])), 
                        'paterno' => ucfirst(strtolower($request['paterno'])), 
                        'materno' => ucfirst(strtolower($request['materno'])), 
                        'fecha_nacimiento' => $request['fecha_nacimiento'], 
                        'sexo' => $request['sexo'], 'celular' => $request['celular'], 
                        'imei' => $request['imei'], 
                        'correo' => $request['correo'], 
                        'usuario' => $request['usuario'], 
                        'contrasenia' => $request['contrasenia'], 
                        'direccion' => $request['direccion'], 
                        'latitud' => $request['latitud'], 'longitud' => $request['longitud'], 
                        'estado_asignacion' => $request['estado_asignacion'], 
                        'login' => $request['login'], 'credito' => $request['credito'], 
                        'categoria_licencia' => $request['categoria_licencia'], 
                        'tipo' => $request['tipo'], 
                        'aceptar_condiciones' => $request['aceptar_condiciones'], 
                        'id_empresa' => $request['id_empresa'],
                        'tipo_de_pago' => $request['tipo_de_pago'],
                        'login'=>$request['login'],
                        'ahorro'=>$request['ahorro'],
                        'monto_garantia'=>$request['monto_garantia'],
                        'descripcion'=>$request['descripcion'],
                        'localidad'=>$request['localidad']
                         ]);             
            
          
            Session::flash('message','ACTUALIZADO CORRECTAMENTE');
            return Redirect::to('/conductor');          
        } else {
            $verificar=DB::select("SELECT COUNT(*)as contador from conductor WHERE conductor.ci=".$request['ci']);
              foreach ($verificar as $key => $value) {
                  $contador=$value->contador;
              }
            if($contador == 0){

                
                    DB::table('conductor')->where('ci', $request['ci_aux'])->update(['ci' => $request['ci'], 
                      'fecha_registro' => $request['fecha_registro'], 'expedido' => $request['expedido'], 
                      'nombre' => ucfirst(strtolower($request['nombre'])), 
                      'paterno' => ucfirst(strtolower($request['paterno'])), 
                      'materno' => ucfirst(strtolower($request['materno'])), 
                      'fecha_nacimiento' => $request['fecha_nacimiento'], 
                      'sexo' => $request['sexo'], 'celular' => $request['celular'], 
                      'imei' => $request['imei'], 'correo' => $request['correo'], 
                      'usuario' => $request['usuario'], 
                      'contrasenia' => $request['contrasenia'], 
                      'direccion' => $request['direccion'], 'latitud' => $request['latitud'], 'longitud' => $request['longitud'], 'estado_asignacion' => $request['estado_asignacion'], 'login' => $request['login'], 'credito' => $request['credito'] ,'categoria_licencia' => $request['categoria_licencia'], 'tipo' => $request['tipo'], 'aceptar_condiciones' => $request['aceptar_condiciones'], 'id_empresa' => $request['id_empresa'],'tipo_de_pago' => $request['tipo_de_pago'],
                      'login'=>$request['login'],
                      'ahorro'=>$request['ahorro'],
                      'monto_garantia'=>$request['monto_garantia'],
                      'descripcion'=>$request['descripcion']
                       ]);                     
               
               
                Session::flash('message','ACTUALIZADO CORRECTAMENTE');
                return Redirect::to('/conductor'); 
            }
            else{
                Session::flash('message-error','YA EXISTE ESA CEDULA DE IDENTIDAD "'.$request['ci'].'" VERIQUE POR FAVOR');
                return Redirect::to('/conductors/'.$request['ci_aux']); 
            }          
        }
    }

 

  //CODIGO PARA AJAX. SUBIR IMAGENES DE CI
    public function subir_imagen_ci(Request $request)
    {
        $archivo = $request->file('perfil_imagen_ci');
        $input  = array('image' => $archivo) ;
        $reglas = array('image' => 'required|image|mimes:jpeg,jpg,bmp,png,gif|max:1000');
        $validacion = Validator::make($input,  $reglas);
        if ($validacion->fails())
        {
          return view("mensajes.msj_rechazado")->with("msj","El archivo no es una imagen valida");
        }
        else
        {
            $fotos_rua=DB::select("SELECT max(fo.id) as 'cantidad',fo.id_fotocopia from foto fo,fotocopia f, conductor c WHERE fo.id_fotocopia=f.id and f.id=c.id_fotocopia_ci and c.ci='".$request['ci']."'");
            $cantidad=0;
            $id_fotocopia=0;
            foreach ($fotos_rua as $key => $value) {
              $cantidad=$value->cantidad;
              $id_fotocopia=$value->id_fotocopia;
            }

            $cantidad+=1;

                        $nombre_original=$archivo->getClientOriginalName();
                            $extension=$archivo->getClientOriginalExtension();
                            $nuevo_nombre="Imagen_CI-".$request['ci']."-".$cantidad.".".$extension;
                            $r1=Storage::disk('Imagen_Conductor')->put($nuevo_nombre,  \File::get($archivo) );
                            $rutadelaimagen="Imagen_Conductor/".$nuevo_nombre;


            if($cantidad==1){
                    $id_fotocopia=DB::table('fotocopia')->insertGetId([ 'nombre' => 'CI', 'numero' => $request['numero']]); 
                    }
                    else{
                     DB::table('fotocopia')->where('id',$id_fotocopia)->update(['numero'=>$request['numero']]);    
                    }
                    DB::table('foto')->insert(['id_fotocopia' => $id_fotocopia,'id'=>$cantidad, 'direccion' => $rutadelaimagen]);

                    DB::table('conductor')->where('ci',$request['ci'])->update(['id_fotocopia_ci'=>$id_fotocopia]); //ACTUALIZO LOS FOREIGN KEY DEL VEHICULO

                    
                                return "../../storage/".$rutadelaimagen;
                            
          
        }
    }


  //CODIGO PARA AJAX. SUBIR IMAGENES DE PERFIL
    public function subir_imagen_perfil(Request $request)
    {
        $archivo = $request->file('perfil_imagen_perfil');
        $input  = array('image' => $archivo) ;
        $reglas = array('image' => 'required|image|mimes:jpeg,jpg,bmp,png,gif|max:10000');
        $validacion = Validator::make($input,  $reglas);
        if ($validacion->fails())
        {
          return view("mensajes.msj_rechazado")->with("msj","El archivo no es una imagen valida");
        }
        else
        {
            $fotos_rua=DB::select("SELECT max(fo.id) as 'cantidad',fo.id_fotocopia from foto fo,fotocopia f, conductor c WHERE fo.id_fotocopia=f.id and f.id=c.id_fotocopia_perfil and c.ci='".$request['ci']."'");
            $cantidad=0;
            $id_fotocopia=0;
            foreach ($fotos_rua as $key => $value) {
              $cantidad=$value->cantidad;
              $id_fotocopia=$value->id_fotocopia;
            }

            $cantidad+=1;

                        $nombre_original=$archivo->getClientOriginalName();
                            $extension=$archivo->getClientOriginalExtension();
                            $nuevo_nombre="Imagen_PERFIL-".$request['ci']."-".$cantidad.".".$extension;
                            $r1=Storage::disk('Imagen_Conductor')->put($nuevo_nombre,  \File::get($archivo) );
                            $rutadelaimagen="Imagen_Conductor/".$nuevo_nombre;


//implementado para modificar la direccion de la imagen en el conductor.
                            $gestor = fopen($archivo, "r");
                            $contenido = fread($gestor, filesize($archivo));
                            fclose($gestor);      
                            $direccion_perfil = "Imagen_Conductor/Perfil-".$request['ci'].".png"; 
                            file_put_contents($direccion_perfil, $contenido);   
//fin de la odificacion de la imagen

                    if($cantidad==1){
                      $id_fotocopia=DB::table('fotocopia')->insertGetId([ 'nombre' => 'PERFIL']); 
                     }
                    DB::table('foto')->insert(['id_fotocopia' => $id_fotocopia,'id'=>$cantidad, 'direccion' => $rutadelaimagen,'detalle'=>'Subido por el administrador']);

                    DB::table('conductor')->where('ci',$request['ci'])->update(['id_fotocopia_perfil'=>$id_fotocopia,'direccion_imagen'=>$direccion_perfil]); //ACTUALIZO LOS FOREIGN KEY DEL VEHICULO

                    
                                return "../../storage/".$rutadelaimagen;
                            
          
        }
    }


     //CODIGO PARA AJAX. SUBIR IMAGENES DE LICENCIA
    public function subir_imagen_licencia(Request $request)
    {
        $archivo = $request->file('perfil_imagen_licencia');
        $input  = array('image' => $archivo) ;
        $reglas = array('image' => 'required|image|mimes:jpeg,jpg,bmp,png,gif|max:10000');
        $validacion = Validator::make($input,  $reglas);
        if ($validacion->fails())
        {
          return view("mensajes.msj_rechazado")->with("msj","El archivo no es una imagen valida");
        }
        else
        {
            $fotos_rua=DB::select("SELECT max(fo.id) as 'cantidad',fo.id_fotocopia from foto fo,fotocopia f, conductor c WHERE fo.id_fotocopia=f.id and f.id=c.id_fotocopia_licencia and c.ci='".$request['ci']."'");
            $cantidad=0;
            $id_fotocopia=0;
            foreach ($fotos_rua as $key => $value) {
              $cantidad=$value->cantidad;
              $id_fotocopia=$value->id_fotocopia;
            }

            $cantidad+=1;

                        $nombre_original=$archivo->getClientOriginalName();
                            $extension=$archivo->getClientOriginalExtension();
                            $nuevo_nombre="Imagen_LICENCIA-".$request['ci']."-".$cantidad.".".$extension;
                            $r1=Storage::disk('Imagen_Conductor')->put($nuevo_nombre,  \File::get($archivo) );
                            $rutadelaimagen="Imagen_Conductor/".$nuevo_nombre;


            if($cantidad==1){
                    $id_fotocopia=DB::table('fotocopia')->insertGetId([ 'nombre' => 'LICENCIA DE CONDUCIR', 'numero' => $request['numero']]); 
                    }
                    else{
                     DB::table('fotocopia')->where('id',$id_fotocopia)->update(['numero'=>$request['numero']]);    
                    }
                    DB::table('foto')->insert(['id_fotocopia' => $id_fotocopia,'id'=>$cantidad, 'direccion' => $rutadelaimagen]);

                    DB::table('conductor')->where('ci',$request['ci'])->update(['id_fotocopia_licencia'=>$id_fotocopia]); //ACTUALIZO LOS FOREIGN KEY DEL VEHICULO

                    
                                return "../../storage/".$rutadelaimagen;
                            
          
        }
    }

     //CODIGO PARA AJAX. SUBIR IMAGENES DE HAM
    public function subir_imagen_ham(Request $request)
    {
        $archivo = $request->file('perfil_imagen_ham');
        $input  = array('image' => $archivo) ;
        $reglas = array('image' => 'required|image|mimes:jpeg,jpg,bmp,png,gif|max:10000');
        $validacion = Validator::make($input,  $reglas);
        if ($validacion->fails())
        {
          return view("mensajes.msj_rechazado")->with("msj","El archivo no es una imagen valida");
        }
        else
        {
            $fotos_rua=DB::select("SELECT max(fo.id) as 'cantidad',fo.id_fotocopia from foto fo,fotocopia f, conductor c WHERE fo.id_fotocopia=f.id and f.id=c.id_fotocopia_tarjeta_de_identificacion_de_ham and c.ci='".$request['ci']."'");
            $cantidad=0;
            $id_fotocopia=0;
            foreach ($fotos_rua as $key => $value) {
              $cantidad=$value->cantidad;
              $id_fotocopia=$value->id_fotocopia;
            }

            $cantidad+=1;

                        $nombre_original=$archivo->getClientOriginalName();
                            $extension=$archivo->getClientOriginalExtension();
                            $nuevo_nombre="Imagen_HAM-".$request['ci']."-".$cantidad.".".$extension;
                            $r1=Storage::disk('Imagen_Conductor')->put($nuevo_nombre,  \File::get($archivo) );
                            $rutadelaimagen="Imagen_Conductor/".$nuevo_nombre;


            if($cantidad==1){
                    $id_fotocopia=DB::table('fotocopia')->insertGetId([ 'nombre' => 'TARJETA DE IDENTIFICACION DE HAM', 'numero' => $request['numero']]); 
                    }
                    else{
                     DB::table('fotocopia')->where('id',$id_fotocopia)->update(['numero'=>$request['numero']]);    
                    }
                    DB::table('foto')->insert(['id_fotocopia' => $id_fotocopia,'id'=>$cantidad, 'direccion' => $rutadelaimagen]);

                    DB::table('conductor')->where('ci',$request['ci'])->update(['id_fotocopia_tarjeta_de_identificacion_de_ham'=>$id_fotocopia]); //ACTUALIZO LOS FOREIGN KEY DEL VEHICULO

                    
                                return "../../storage/".$rutadelaimagen;
                            
          
        }
    }

 //CODIGO PARA AJAX. SUBIR IMAGENES DE TRANSITO
    public function subir_imagen_transito(Request $request)
    {
        $archivo = $request->file('perfil_imagen_transito');
        $input  = array('image' => $archivo) ;
        $reglas = array('image' => 'required|image|mimes:jpeg,jpg,bmp,png,gif|max:10000');
        $validacion = Validator::make($input,  $reglas);
        if ($validacion->fails())
        {
          return view("mensajes.msj_rechazado")->with("msj","El archivo no es una imagen valida");
        }
        else
        {
            $fotos_rua=DB::select("SELECT max(fo.id) as 'cantidad',fo.id_fotocopia from foto fo,fotocopia f, conductor c WHERE fo.id_fotocopia=f.id and f.id=c.id_fotocopia_tarjeta_de_identificacion_de_transito and c.ci='".$request['ci']."'");
            $cantidad=0;
            $id_fotocopia=0;
            foreach ($fotos_rua as $key => $value) {
              $cantidad=$value->cantidad;
              $id_fotocopia=$value->id_fotocopia;
            }

            $cantidad+=1;

                        $nombre_original=$archivo->getClientOriginalName();
                            $extension=$archivo->getClientOriginalExtension();
                            $nuevo_nombre="Imagen_TRANSITO-".$request['ci']."-".$cantidad.".".$extension;
                            $r1=Storage::disk('Imagen_Conductor')->put($nuevo_nombre,  \File::get($archivo) );
                            $rutadelaimagen="Imagen_Conductor/".$nuevo_nombre;


            if($cantidad==1){
                    $id_fotocopia=DB::table('fotocopia')->insertGetId([ 'nombre' => 'TARJETA DE IDENTIFICACION DE TRANSITO', 'numero' => $request['numero']]); 
                    }
                    else{
                     DB::table('fotocopia')->where('id',$id_fotocopia)->update(['numero'=>$request['numero']]);    
                    }
                    DB::table('foto')->insert(['id_fotocopia' => $id_fotocopia,'id'=>$cantidad, 'direccion' => $rutadelaimagen]);

                    DB::table('conductor')->where('ci',$request['ci'])->update(['id_fotocopia_tarjeta_de_identificacion_de_transito'=>$id_fotocopia]); //ACTUALIZO LOS FOREIGN KEY DEL VEHICULO

                    
                                return "../../storage/".$rutadelaimagen;
                            
          
        }
    }

 //CODIGO PARA AJAX. SUBIR IMAGENES DE FACTURA DE AGUA O LUZ
    public function subir_imagen_factura(Request $request)
    {
        $archivo = $request->file('perfil_imagen_factura');
        $input  = array('image' => $archivo) ;
        $reglas = array('image' => 'required|image|mimes:jpeg,jpg,bmp,png,gif|max:10000');
        $validacion = Validator::make($input,  $reglas);
        if ($validacion->fails())
        {
          return view("mensajes.msj_rechazado")->with("msj","El archivo no es una imagen valida");
        }
        else
        {
            $fotos_rua=DB::select("SELECT max(fo.id) as 'cantidad',fo.id_fotocopia from foto fo,fotocopia f, conductor c WHERE fo.id_fotocopia=f.id and f.id=c.id_fotocopia_factura_de_agua_luz and c.ci='".$request['ci']."'");
            $cantidad=0;
            $id_fotocopia=0;
            foreach ($fotos_rua as $key => $value) {
              $cantidad=$value->cantidad;
              $id_fotocopia=$value->id_fotocopia;
            }

            $cantidad+=1;

                        $nombre_original=$archivo->getClientOriginalName();
                            $extension=$archivo->getClientOriginalExtension();
                            $nuevo_nombre="Imagen_FACTURA-".$request['ci']."-".$cantidad.".".$extension;
                            $r1=Storage::disk('Imagen_Conductor')->put($nuevo_nombre,  \File::get($archivo) );
                            $rutadelaimagen="Imagen_Conductor/".$nuevo_nombre;
 

            if($cantidad==1){
                    $id_fotocopia=DB::table('fotocopia')->insertGetId([ 'nombre' => 'FACTURA DE AGUA O LUZ', 'numero' => $request['numero']]); 
                    }
                    else{
                     DB::table('fotocopia')->where('id',$id_fotocopia)->update(['numero'=>$request['numero']]);    
                    }
                    DB::table('foto')->insert(['id_fotocopia' => $id_fotocopia,'id'=>$cantidad, 'direccion' => $rutadelaimagen]);

                    DB::table('conductor')->where('ci',$request['ci'])->update(['id_fotocopia_factura_de_agua_luz'=>$id_fotocopia]); //ACTUALIZO LOS FOREIGN KEY DEL VEHICULO

                    
                                return "../../storage/".$rutadelaimagen;
                            
          
        }
    }

     //CODIGO PARA AJAX. SUBIR IMAGENES DE ANTECEDENTES
    public function subir_imagen_antecedentes(Request $request)
    {
        $archivo = $request->file('perfil_imagen_antecedentes');
        $input  = array('image' => $archivo) ;
        $reglas = array('image' => 'required|image|mimes:jpeg,jpg,bmp,png,gif|max:10000');
        $validacion = Validator::make($input,  $reglas);
        if ($validacion->fails())
        {
          return view("mensajes.msj_rechazado")->with("msj","El archivo no es una imagen valida");
        }
        else
        {
            $fotos_rua=DB::select("SELECT max(fo.id) as 'cantidad',fo.id_fotocopia from foto fo,fotocopia f, conductor c WHERE fo.id_fotocopia=f.id and f.id=c.id_fotocopia_certificado_de_antecedentes_del_transito and c.ci='".$request['ci']."'");
            $cantidad=0;
            $id_fotocopia=0;
            foreach ($fotos_rua as $key => $value) {
              $cantidad=$value->cantidad;
              $id_fotocopia=$value->id_fotocopia;
            }

            $cantidad+=1;

                        $nombre_original=$archivo->getClientOriginalName();
                            $extension=$archivo->getClientOriginalExtension();
                            $nuevo_nombre="Imagen_ANTECEDENTES-TRANSITO-".$request['ci']."-".$cantidad.".".$extension;
                            $r1=Storage::disk('Imagen_Conductor')->put($nuevo_nombre,  \File::get($archivo) );
                            $rutadelaimagen="Imagen_Conductor/".$nuevo_nombre;


            if($cantidad==1){
                    $id_fotocopia=DB::table('fotocopia')->insertGetId([ 'nombre' => 'CERTIFICADO DE ANTECEDENTES DEL TRANSITO', 'numero' => $request['numero']]); 
                    }
                    else{
                     DB::table('fotocopia')->where('id',$id_fotocopia)->update(['numero'=>$request['numero']]);    
                    }
                    DB::table('foto')->insert(['id_fotocopia' => $id_fotocopia,'id'=>$cantidad, 'direccion' => $rutadelaimagen]);

                    DB::table('conductor')->where('ci',$request['ci'])->update(['id_fotocopia_certificado_de_antecedentes_del_transito'=>$id_fotocopia]); //ACTUALIZO LOS FOREIGN KEY DEL VEHICULO

                    
                                return "../../storage/".$rutadelaimagen;
                            
          
        }
    }
     //CODIGO PARA AJAX. SUBIR IMAGENES DE CI
    public function subir_imagen_felcc(Request $request)
    {
        $archivo = $request->file('perfil_imagen_felcc');
        $input  = array('image' => $archivo) ;
        $reglas = array('image' => 'required|image|mimes:jpeg,jpg,bmp,png,gif|max:10000');
        $validacion = Validator::make($input,  $reglas);
        if ($validacion->fails())
        {
          return view("mensajes.msj_rechazado")->with("msj","El archivo no es una imagen valida");
        }
        else
        {
            $fotos_rua=DB::select("SELECT max(fo.id) as 'cantidad',fo.id_fotocopia from foto fo,fotocopia f, conductor c WHERE fo.id_fotocopia=f.id and f.id=c.id_fotocopia_certificado_de_antecedentes_del_felcc and c.ci='".$request['ci']."'");
            $cantidad=0;
            $id_fotocopia=0;
            foreach ($fotos_rua as $key => $value) {
              $cantidad=$value->cantidad;
              $id_fotocopia=$value->id_fotocopia;
            }

            $cantidad+=1;

                        $nombre_original=$archivo->getClientOriginalName();
                            $extension=$archivo->getClientOriginalExtension();
                            $nuevo_nombre="Imagen_CERTIFICADO-ANTECEDENTES-FELCC-".$request['ci']."-".$cantidad.".".$extension;
                            $r1=Storage::disk('Imagen_Conductor')->put($nuevo_nombre,  \File::get($archivo) );
                            $rutadelaimagen="Imagen_Conductor/".$nuevo_nombre;


            if($cantidad==1){
                    $id_fotocopia=DB::table('fotocopia')->insertGetId([ 'nombre' => 'CERTIFICADO DE ANTECEDENTE DEL FELCC', 'numero' => $request['numero']]); 
                    }
                    else{
                     DB::table('fotocopia')->where('id',$id_fotocopia)->update(['numero'=>$request['numero']]);    
                    }
                    DB::table('foto')->insert(['id_fotocopia' => $id_fotocopia,'id'=>$cantidad, 'direccion' => $rutadelaimagen]);

                    DB::table('conductor')->where('ci',$request['ci'])->update(['id_fotocopia_certificado_de_antecedentes_del_felcc'=>$id_fotocopia]); //ACTUALIZO LOS FOREIGN KEY DEL VEHICULO

                    
                                return "../../storage/".$rutadelaimagen;
                            
          
        }
    }



    
    public function destroy($id, Request $request){
        $Conductor=Conductor::find($id);
        $Conductor->delete();
        Session::flash('message','Conductor Eliminado Correctamente');
       return Redirect::to('/Conductor');
    }

    //CARGAR PARA VERIFICAR SI EXISTE EL CI DEL CUNDUCTOR
    function verificar_ci_conductor($ci){
        $conductor=DB::select("SELECT count(*)as contador,c.estado_asignacion,c.ci,c.fecha_nacimiento,c.celular,c.estado,c.expedido,c.token,c.nombre,c.paterno,c.materno,e.razon_social,e.direccion,e.whatsapp,c.direccion_imagen,c.tipo_de_pago,c.monto_frecuencia,c.fecha_inicio_pago,c.fecha_fin_pago,c.direccion_imagen,c.credito FROM conductor c,empresa e where c.id_empresa=e.id and c.ci=".$ci);
        return response($conductor);
    }
   


    //CARGAR PARA PODER ACTUALIZAR EN LA PARTE DEL MODAL
    public function cargar_Conductor($ci){
        $Conductor=DB::select("SELECT *from Conductor where ci=".$ci);
        return response($Conductor);
    }

    //PAGO DE LOS MOTISTA
    public function actualizar_pago_motista(Request $request){
        try {
          DB::beginTransaction(); 

            $id_carrera=$request->get('id_carrera');
            $monto=$request->get('monto_pag');
            $cont=0;
             
            while ( $cont < count($id_carrera)) {
                $carrera = DB::table('carrera')->where('id',$id_carrera[$cont])->update(['monto_motista'=>0]);
                $cont=$cont+1;                    
            }
            DB::commit();
            return redirect('/pago_motista')->with("message","SE REALIZO EL PAGO CORRECTAMENTE");              

        } catch (Exception $e) {
          DB::rollback();
          return redirect('/pago_motista')->with("message-error","ERROR INTENTE NUEVAMENTE");      
        }
    }

    //MUESTRA LA LISTA DE LOS MONTO Q DEBE PAGAR AL MOTISTA
    public function cargar_lista_motista($id){      
        $lista=DB::select("SELECT pedido.id,pedido.monto_motista_aux,pedido.fecha from pedido WHERE pedido.monto_motista_aux>0 AND pedido.id_Conductor=".$id);       
        return response($lista);
    }

    //BUSCAR PAGO DE LOS MOTISTA
    public function pago_motista(){
        $buscar_Conductor=DB::select("SELECT id,nombre,apellido,ci,placa,modelo,color,celular FROM Conductor");        
        $pago=DB::select("SELECT id,nombre,apellido,ci,placa,modelo,color,celular FROM Conductor");        
        return view("Conductor.pago_motista",compact('pago','buscar_Conductor'));
    }

    //MUESTRA EL MONTO Q LE DEBE PAGAR AL MOTISTA
    public function cargar_pago_motista($id){      
        $pago_Conductor=DB::select("SELECT SUM(pedido.monto_motista_aux)as monto_motista from pedido WHERE pedido.monto_motista_aux>0 AND pedido.id_Conductor=".$id);
        return response($pago_Conductor);
    }



////////////////////////////////////////////////////////////////////////////////
//////////////////HISTORIAL DE CARRERAS DE LOS MOTISTAS/////////////////////////
////////////////////////////////////////////////////////////////////////////////

    //MUESTRA LA PLANTILLA DE HISTORIAL DE CARRERA
   
     public function show_2(Request $Request )
    {                   
 
        $fecha_inicio=$Request['fecha_inicio'];
        $fecha_fin=$Request['fecha_fin'];
        $id_conductor=$Request['id_conductor'];
        $estado=$Request['estado_opcion'];
        if($estado==1){
            //BUSCAR TODOS LOS PEDIDOS.
        $consulta="SELECT pedido.id, conductor.ci,conductor.expedido,pedido.latitud,pedido.longitud, 
         CONCAT(conductor.nombre,' ',conductor.paterno,' ',conductor.materno)as conductor,vehiculo.codigo_empresa, pedido.tipo_pedido_empresa,
         vehiculo.placa,vehiculo.marca, CONCAT(usuario.nombre,' ',usuario.apellido) as usuario,pedido.id_empresa_cliente,  
         date_format(pedido.fecha_pedido,'%d-%m-%Y %h:%i %p')as fecha_pedido,pedido.direccion,pedido.monto_total,pedido.monto_empresa,pedido.monto_conductor,
         pedido.detalle_cancelo_usuario,pedido.detalle_cancelo_conductor,pedido.direccion,pedido.clase_vehiculo,pedido.estado,pedido.estado_pago_empresa,
          pedido.calificacion_conductor,pedido.calificacion_vehiculo
           from pedido,vehiculo,conductor,usuario 
         WHERE pedido.id_vehiculo=vehiculo.placa AND pedido.id_conductor=conductor.ci AND usuario.id=pedido.id_usuario  AND pedido.id_conductor=".$id_conductor." AND 
         date(pedido.fecha_pedido) >='".$fecha_inicio."' AND date(pedido.fecha_pedido) <='".$fecha_fin."' order by pedido.id desc";
        }else if($estado==2){
            //BUSCAR TODOS LOS PEDIDOS COMPLETADOS 
            $consulta="SELECT pedido.id, conductor.ci,conductor.expedido,pedido.latitud,pedido.longitud, 
         CONCAT(conductor.nombre,' ',conductor.paterno,' ',conductor.materno)as conductor,vehiculo.codigo_empresa, pedido.tipo_pedido_empresa,
         vehiculo.placa,vehiculo.marca, CONCAT(usuario.nombre,' ',usuario.apellido) as usuario,  pedido.id_empresa_cliente,  
         date_format(pedido.fecha_pedido,'%d-%m-%Y %h:%i %p')as fecha_pedido,pedido.direccion,pedido.monto_total,pedido.monto_empresa,pedido.monto_conductor,
         pedido.detalle_cancelo_usuario,pedido.detalle_cancelo_conductor,pedido.direccion,pedido.clase_vehiculo,pedido.estado,pedido.estado_pago_empresa,
         pedido.calificacion_conductor,pedido.calificacion_vehiculo
           from pedido,vehiculo,conductor,usuario 
         WHERE pedido.estado=2 and pedido.id_vehiculo=vehiculo.placa AND pedido.id_conductor=conductor.ci AND usuario.id=pedido.id_usuario  AND pedido.id_conductor='".$id_conductor."' AND 
         date(pedido.fecha_pedido) >='".$fecha_inicio."' AND date(pedido.fecha_pedido) <='".$fecha_fin."' order by pedido.id desc";

        }else if($estado==3){
            //BUSCAR TODOS LOS PEDIDOS CANCELADOS
            $consulta="SELECT pedido.id, conductor.ci,conductor.expedido,pedido.latitud,pedido.longitud, 
         CONCAT(conductor.nombre,' ',conductor.paterno,' ',conductor.materno)as conductor,vehiculo.codigo_empresa, pedido.tipo_pedido_empresa,
         vehiculo.placa,vehiculo.marca, CONCAT(usuario.nombre,' ',usuario.apellido) as usuario, pedido.id_empresa_cliente,   
         date_format(pedido.fecha_pedido,'%d-%m-%Y %h:%i %p')as fecha_pedido,pedido.direccion,pedido.monto_total,pedido.monto_empresa,pedido.monto_conductor,
         pedido.detalle_cancelo_usuario,pedido.detalle_cancelo_conductor,pedido.direccion,pedido.clase_vehiculo,pedido.estado,pedido.estado_pago_empresa,
         pedido.calificacion_conductor,pedido.calificacion_vehiculo
           from pedido,vehiculo,conductor,usuario 
         WHERE pedido.estado>=4 and pedido.id_vehiculo=vehiculo.placa AND pedido.id_conductor=conductor.ci AND usuario.id=pedido.id_usuario  AND pedido.id_conductor=".$id_conductor." AND 
         date(pedido.fecha_pedido) >='".$fecha_inicio."' AND date(pedido.fecha_pedido) <='".$fecha_fin."' order by pedido.id desc";
        }else{
             $pedidos = DB::select("SELECT pedido.id, conductor.ci,conductor.expedido,pedido.latitud,pedido.longitud, 
         CONCAT(conductor.nombre,' ',conductor.paterno,' ',conductor.materno)as conductor,vehiculo.codigo_empresa, pedido.tipo_pedido_empresa,
         vehiculo.placa,vehiculo.marca, CONCAT(usuario.nombre,' ',usuario.apellido) as usuario, pedido.id_empresa_cliente,  
         date_format(pedido.fecha_pedido,'%d-%m-%Y %h:%i %p')as fecha_pedido,pedido.direccion,pedido.monto_total,pedido.monto_empresa,pedido.monto_conductor,
         pedido.detalle_cancelo_usuario,pedido.detalle_cancelo_conductor,pedido.direccion,pedido.clase_vehiculo,pedido.estado,pedido.estado_pago_empresa,
         pedido.calificacion_conductor,pedido.calificacion_vehiculo
           from pedido,vehiculo,conductor,usuario 
         WHERE pedido.id_vehiculo=vehiculo.placa AND pedido.id_conductor=conductor.ci AND usuario.id=pedido.id_usuario  AND pedido.id_conductor=".$id_conductor." AND date(pedido.fecha_pedido) >= date( DATE_SUB(curdate(), INTERVAL + 29 DAY)) AND date(pedido.fecha_pedido) <=date(now())  order by pedido.id desc");
        } 
        
        
    $pedidos = DB::select($consulta);
    
     $fechas = DB::select("SELECT date('".$fecha_inicio."') as fecha_inicio, date('".$fecha_fin."') as fecha_fin");   
      //
      $conductor = DB::select("SELECT *from conductor where conductor.ci=".$id_conductor);

        return view('conductor.historial_carrera',["fechas"=>$fechas,'pedidos'=>$pedidos,'estado'=>$estado,'otra'=>1, 'conductor'=>$conductor]);
    }

    function show($id_conductor)
    {
    $pedidos = DB::select("SELECT pedido.id, conductor.ci,conductor.expedido,pedido.latitud,pedido.longitud, 
         CONCAT(conductor.nombre,' ',conductor.paterno,' ',conductor.materno)as conductor, pedido.tipo_pedido_empresa,
         vehiculo.placa,vehiculo.marca, CONCAT(usuario.nombre,' ',usuario.apellido) as usuario, vehiculo.codigo_empresa,pedido.id_empresa_cliente,  
         date_format(pedido.fecha_pedido,'%d-%m-%Y %h:%i %p')as fecha_pedido,pedido.direccion,pedido.monto_total,pedido.monto_empresa,pedido.monto_conductor,
         pedido.detalle_cancelo_usuario,pedido.detalle_cancelo_conductor,pedido.direccion,pedido.clase_vehiculo,pedido.estado,pedido.estado_pago_empresa,
         pedido.calificacion_conductor,pedido.calificacion_vehiculo
           from pedido,vehiculo,conductor,usuario 
         WHERE pedido.id_vehiculo=vehiculo.placa AND pedido.id_conductor=conductor.ci AND usuario.id=pedido.id_usuario  AND pedido.id_conductor=".$id_conductor." AND date(pedido.fecha_pedido) >= date( DATE_SUB(curdate(), INTERVAL + 29 DAY)) AND date(pedido.fecha_pedido) <=date(now())  order by pedido.id desc");
      $fechas = DB::select("SELECT date(DATE_SUB(curdate(), INTERVAL + 29 DAY)) as fecha_inicio, date(now()) as fecha_fin");   
      $estado=1;
         $conductor = DB::select("SELECT *from conductor where conductor.ci=".$id_conductor);
      
       return view('conductor.historial_carrera',["fechas"=>$fechas,'pedidos'=>$pedidos,'estado'=>$estado,'otra'=>0,'conductor'=>$conductor]);
    }
    //PEDIDOS DE LOS CONDUCTOR DE UNA EMPRESA
    //SELECT * from pedido,vehiculo,conductor WHERE pedido.id_vehiculo=vehiculo.placa AND pedido.id_conductor=conductor.ci AND vehiculo.id_empresa=3

    //MUESTRA LA PLANTILLA DE HISTORIAL DE CARRERA DEL CONDUCTOR
    public function historial_carrera_conductor($ci, $fecha_inicio, $fecha_fin, $estado){
        $conductor = DB::select("SELECT pedido.id, CONCAT(usuario.nombre,' ',usuario.apellido)as usuario,
          date_format(pedido.fecha_pedido,'%d-%m-%Y %h:%i %p')as fecha_pedido,pedido.direccion,pedido.id_empresa_cliente,  
          CONCAT(conductor.nombre,' ',conductor.paterno,' ',conductor.materno)as condctor,
          conductor.ci,pedido.monto_total,pedido.detalle_cancelo_usuario,pedido.detalle_cancelo_conductor,
          pedido.calificacion_conductor,pedido.calificacion_vehiculo 
          FROM conductor,vehiculo v,pedido,usuario WHERE conductor.id_vehiculo=v.placa AND conductor.ci=pedido.id_conductor 
          AND pedido.estado=".$estado." AND usuario.id=pedido.id_usuario AND date(pedido.fecha_pedido) >='".$fecha_inicio."' 
           AND date(pedido.fecha_pedido) <='".$fecha_fin."' AND conductor.ci=".$ci." order by pedido.fecha_pedido  desc");
       return response($conductor);
    }

    public function historial_carrera_detalle($id_pedido){
        $detalle=DB::select("SELECT *,date_format(carrera.fecha_inicio,'%d-%m-%Y %h:%i %p')as fecha_pedido FROM carrera WHERE id_pedido=".$id_pedido);
        return response($detalle);
    }


////////////////////////////////////////////////////////////////////////////////
//////////////////BUSQUEDA DE LAS ConductorS/////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////

    //PARA BUSCAR UN MOTISTA ESPECIFICO
    public function busqueda_Conductor(){
        if (Auth::user()->privilegio == 1) {
            $buscar_Conductor=DB::select("SELECT id,nombre,apellido,ci,placa,modelo,color,celular FROM Conductor");                    
            $buscar_empresa=DB::select("SELECT * FROM empresa WHERE empresa.privilegio=0");                    
            return view("Conductor.busqueda_Conductor",compact('buscar_Conductor','buscar_empresa'));
        } else {
            $buscar_Conductor=DB::select("SELECT id,nombre,apellido,ci,placa,modelo,color,celular FROM Conductor where Conductor.id_empresa=".Auth::user()->id); 
            return view("Conductor.busqueda_Conductor",compact('buscar_Conductor'));                            
        }        
    }

    //MUESTRA LOS MOTISTAS ACTIVOS
    public function buscar_activos_Conductor(){  
        if (Auth::user()->privilegio == 1) {
            $activos=DB::select("SELECT *from Conductor WHERE Conductor.estado=1");                                 
        } else {
            $activos=DB::select("SELECT *from Conductor WHERE Conductor.estado=1 and Conductor.id_empresa=".Auth::user()->id);                    
        }              
        return response($activos);
    }

    //MUESTRA LOS MOTISTAS ACTIVOS
    public function buscar_inactivos_Conductor(){      
        if (Auth::user()->privilegio == 1) {
            $inactivos=DB::select("SELECT *from Conductor WHERE Conductor.estado=0");                                
        } else {
            $inactivos=DB::select("SELECT *from Conductor WHERE Conductor.estado=0 and Conductor.id_empresa=".Auth::user()->id);                    
        }         
        return response($inactivos);
    }

    //MUESTRA LOS MOTISTAS ACTIVOS
    public function buscar_todo_los_Conductor(){   
        if (Auth::user()->privilegio == 1) {
            $todos=DB::select("SELECT * FROM Conductor");                    
        } else {
             $todos=DB::select("SELECT * FROM Conductor where Conductor.id_empresa=".Auth::user()->id);                    
        }                     
        return response($todos);
    }

    //MUESTRA LOS MOTISTAS ACTIVOS
    public function buscar_carrera_Conductor(){      
        $carrera=DB::select("SELECT * FROM Conductor WHERE Conductor.estado=2 and Conductor.id_empresa=".Auth::user()->id);        
        return response($carrera);
    }

    //MUESTRA UN SOLO MOTISTA ESPESIFICO
    public function buscar_un_Conductor($id){      
        $motista=DB::select("SELECT * FROM Conductor WHERE Conductor.id=".$id);        
        return response($motista);
    }

/////BUSCAR ConductorSTAS POR EMPRESA
    //MUESTRA LOS ConductorSTA ACTIVOS DE UNA EMPRESA
    public function buscar_activos_Conductor_adm($id_emp){  
        $activos=DB::select("SELECT *from Conductor WHERE Conductor.estado=1 and Conductor.id_empresa=".$id_emp);                                
        return response($activos);
    }

    //MUESTRA LOS ConductorSTA ACTIVOS
    public function buscar_inactivos_Conductor_adm($id_emp){      
        $inactivos=DB::select("SELECT *from Conductor WHERE Conductor.estado=0 and Conductor.id_empresa=".$id_emp);                       
        return response($inactivos);
    }

    //MUESTRA LOS ConductorSTA ACTIVOS
    public function buscar_todo_los_Conductor_adm($id_emp){   
        $todos=DB::select("SELECT * FROM Conductor where Conductor.id_empresa=".$id_emp);                                      
        return response($todos);
    }

    //MUESTRA LOS MOTISTAS ACTIVOS
    public function buscar_carrera_Conductor_adm($id_emp){      
        $carrera=DB::select("SELECT * FROM Conductor WHERE Conductor.estado=2 and Conductor.id_empresa=".$id_emp);        
        return response($carrera);
    }
    

    
    //ENVIAR NOTIFICACION A VARIOS ConductorSTA EN BUSQUEDA
    function notificacion_busqueda_motista(Request $request){ 
        $mPushNotification = $this->getPush("ASAPP",$request['detalle_msn'],null,"","","","","","20");        
        $id_Conductor=$request->get('id_Conductor_not');
        $token=$request->get('token_not');
        $cont=0;
        $tokens = array(); 
        while ( $cont < count($id_Conductor)) {
          if ( ($token[$cont] != "0") && ($token[$cont] != "") ) {     
            array_push($tokens, $token[$cont]);                            
          }
            $cont=$cont+1;                    
        }     
        send($tokens,$mPushNotification);        

        Session::flash('message','ENVIADO CORRECTAMENTE');
        return Redirect::to('/busqueda_motista');     
    }

    //ENVIAR NOTIFICACION A UN SOLO MOTISTA
    function notificacion_conductor(Request $request){  
        
                   

                $mPushNotification = getPush('Taxi Valle',$request['detalle'],null,"taxi","","","0","0","6");        
                $tokens = array(); 

                $conductor=DB::select("SELECT token  from conductor WHERE  ci=".$request['id_taxi_not']);    
                
                foreach ($conductor as $key => $con) {
                     array_push($tokens, $con->token); 
                    }    
                  $devicetoken = $tokens;                              
                $sw_notificacion=send($tokens,$mPushNotification);


             if($sw_notificacion===FALSE)
             {
                Session::flash('message-error','NO SE ENVIO LA NOTIFICAION  error:'.$sw_notificacion." token: ".$request['token_not']." mensaje =".$request['detalle']);  
             }
             else
             {
              Session::flash('message','ENVIADO CORRECTAMENTE ');
             }
      

                return Redirect::to('/conductor');            
    }

    //ENVIAR NOTIFICACION A UN SOLO MOTISTA
    function notificacion_conductor_2(Request $request){  

                $mPushNotification = getPush('Taxi Valle',$request['detalle'],null,"taxi","","","0","0","6");
                 $tokens = array(); 
                 array_push($tokens,$request['token_not']);        
                $sw_notificacion=send($tokens,$mPushNotification);


             if($sw_notificacion===FALSE)
             {
                Session::flash('message-error','NO SE ENVIO LA NOTIFICAION  error:'.$sw_notificacion." token: ".$request['token_not']." mensaje =".$request['detalle']);  
             }
             else
             {
              Session::flash('message','ENVIADO CORRECTAMENTE ' );
             }
      

                return Redirect::to('/conductor');            
    }
    

    public function conductor_baja(Request $request){ 
            try{
                DB::table('conductor')->where('ci', $request['ci_conductor'])->update(['fecha_fin_pago'=>date('Y-m-j'),'estado_asignacion' => '6','fecha_retiro'=>date('Y-m-j H-m-00'),'id_vehiculo'=>'0']); 
                DB::table('historial_baja_alta')->insert(['descripcion' =>$request['descripcion'],'id_conductor'=>$request['ci_conductor'],'id_login'=>Auth::user()->id, 'fecha' => $request['fecha'],'tipo'=>'0','numero_movil' =>$request['numero_movil']]);
                Session::flash('message','SE DIO DE BAJA');
                }
                catch(Exception $e)
                {
                   Session::flash('message-error','NO SE PUEDO REALIZAR LA BAJA EL CONDUCTOR');
                }
                
             return Redirect::to('/conductor');  
       }



    public function conductor_alta(Request $request){ 
            try{
                DB::table('conductor')->where('ci', $request['ci_conductor'])->update(['estado_asignacion' => '1','fecha_inicio_pago'=>date('Y-m-j'),'fecha_fin_pago'=>date('(Y + 5)-m-j'),'fecha_retiro'=>date('Y-m-j H-m-00')]); 
                DB::table('historial_baja_alta')->insert(['descripcion' =>$request['descripcion'],'id_conductor'=>$request['ci_conductor'],'id_login'=>Auth::user()->id, 'fecha' => $request['fecha'],'tipo'=>'1']);
                Session::flash('message','SE DIO DE ALTA');
                }
                catch(Exception $e)
                {
                   Session::flash('message-error','NO SE PUEDO REALIZAR LA ALTA EL CONDUCTOR');
                }
                
             return Redirect::to('/conductor');  
       }

   public function conductor_activar(Request $request){ 
        
          $sw_registro=false;
            try{
                DB::table('conductor')
                ->where('ci', $request['ci_conductor'])
                ->update([
                  'estado_asignacion' => '1',
                  'pre_registro' => '0',
                  'fecha_inicio_pago'=>date('Y-m-j'),
                  'fecha_fin_pago'=>date('(Y + 5)-m-j'),
                  'fecha_registro'=>date('Y-m-j H-m-00')]); 
                
               

                try{
                DB::table('vehiculo')->where('placa', $request['placa_vehiculo'])->update(['estado' => '1','fecha_registrado'=>date('Y-m-j H-m-00')]); 
                $sw_registro=true;
                }
                catch(Exception $ee)
                { }

                if($sw_registro==true)
                {
                   Session::flash('message','SE REGISTRO EN LA LISTA DE CONDUCTORES Y VEHICULOS ACTIVOS');
                }else
                {
                 Session::flash('message','SE REGISTRO EN LA LISTA DE CONDUCTORES ACTIVOS');
                }

                }
                catch(Exception $e)
                {
                   Session::flash('message-error','NO SE PUEDO REALIZAR EL REGISTRO EN ACTIVOS AL CONDUCTOR');
                }
                
             return Redirect::to('/conductor');  
       }
       

   public function historial_pago_servicio($id_conductor){
         $egreso=DB::select("SELECT e.*,a.nombre as 'usuario',tp.nombre as 'tipo_egreso' from users a,egreso e,tipo_ingreso_egreso tp where e.opcion=2 and a.id=e.id_login and e.id_tipo_ingreso_egreso=tp.id  and e.id_conductor='".$id_conductor."' ");

             
            return view('conductor.historial_pago_servicio', ['egreso'=>$egreso ]);            
        
   }    

   public function historial_otras_deudas($id_conductor){
     $deuda=DB::select("SELECT d.*, concat(c.nombre,' ',c.paterno,' ',c.materno) as 'conductor',tp.nombre as 'tipo_deuda',a.nombre as 'usuario' from users a,deuda d, conductor c, tipo_ingreso_egreso tp where a.id=d.id_login and d.id_conductor=c.ci and d.id_tipo_deuda=tp.id and d.id_conductor='".$id_conductor."'  limit 80 ");

           
            return view('conductor.historial_otras_deudas',['deuda'=>$deuda]);  
   }

   public function historial_baja_alta($id_conductor){
    $historial=DB::select("SELECT h.*,u.nombre as 'usuario' FROM historial_baja_alta h, users u where  u.id=h.id_login and h.id_conductor='".$id_conductor."'");
    return View('conductor.historial_baja_alta',['historial'=>$historial]);
   }

     public function Cambiar_vehiculo_asignacion(Request $request){ 
            try{
              $vehiculo=DB::select("SELECT codigo_empresa FROM vehiculo where placa='".$request['id_vehiculo_asignacion']."'");

                DB::table('conductor')->where('ci', $request['ci_conductor'])->update(['id_vehiculo' => $request['id_vehiculo_asignacion'],'numero_movil'=>$vehiculo[0]->codigo_empresa]); 

                DB::table('asignacion')->insert(['id_conductor' =>$request['ci_conductor'],'descripcion'=>'ASIGNADO','id_vehiculo'=>$request['id_vehiculo_asignacion'],'numero_movil'=>$vehiculo[0]->codigo_empresa]);

                Session::flash('message','VEHICULO ASIGNADO');



                //enviar notificacion
                $mPushNotification = getPush('CENTRAL',"Señor conductor: El administrador de Taxi Valle le asigno con un nuevo Movil con placa: ". $request['id_vehiculo_asignacion'],null,"taxi","","","0","0","6");        
                $tokens = array(); 
                $conductor=DB::select("SELECT token  from conductor WHERE  ci=".$request['ci_conductor']);    
                foreach ($conductor as $key => $con) {
                     array_push($tokens, $con->token); 
                    }    
                  $devicetoken = $tokens;                              
                $sw_notificacion=send($tokens,$mPushNotification);
                //fin de envio de notificacion
                }
                catch(Exception $e)
                {
                   Session::flash('message-error','NO SE PUEDO ASIGNAR EL VEHICULO');
                }
                
             return Redirect::to('/conductor');  
       }

    public function Cambiar_conductor_asignacion(Request $request){ 
            try{
              $vehiculo=DB::select("SELECT codigo_empresa FROM vehiculo where placa='".$request['placa_vehiculo']."'");
                DB::table('conductor')->where('ci', $request['id_conductor_asignacion'])->update(['id_vehiculo' => $request['placa_vehiculo'],'numero_movil'=>$vehiculo[0]->codigo_empresa]); 
                DB::table('asignacion')->insert(['id_conductor' =>$request['id_conductor_asignacion'],'descripcion'=>'ASIGNADO','id_vehiculo'=>$request['placa_vehiculo'],'numero_movil'=>$vehiculo[0]->codigo_empresa]);

                Session::flash('message','CONDUCTOR ASIGNADO');

                 
                //enviar notificacion
                $mPushNotification = getPush('CENTRAL',"Señor conductor: El administrador de Taxi Valle lacaba de asignarle con un nuevo movil con la placa: ".$request['placa_vehiculo'].".",null,"taxi","","","0","0","6");        
                $tokens = array(); 
                $conductor=DB::select("SELECT token  from conductor WHERE  ci=".$request['id_conductor_asignacion']);    
                foreach ($conductor as $key => $con) {
                     array_push($tokens, $con->token); 
                    }    
                  $devicetoken = $tokens;                              
                $sw_notificacion=send($tokens,$mPushNotification);
                //fin de envio de notificacion
                
                }
                catch(Exception $e)
                {
                   Session::flash('message-error','NO SE PUEDO ASIGNAR EL CONDUCTOR');
                }
                
             return Redirect::to('/vehiculo');  
       }

       
    public function Cambiar_codigo_interno(Request $request){ 
            try{
              
                DB::table('conductor')->where('ci', $request['ci_interno'])->update(['numero_movil'=>$request['codigo_interno']]); 

                DB::table('vehiculo')->where('placa', $request['placa_interno'])->update(['codigo_empresa'=>$request['codigo_interno']]); 

                DB::table('asignacion')->insert(['id_conductor' =>$request['ci_interno'],'descripcion'=>'CAMBIADO SU CODIGO INTERNO','id_vehiculo'=>$request['placa_interno'],'numero_movil'=>$request['codigo_interno']]);

                Session::flash('message','CAMBIO DE CODIGO INTERNO');

                 
                //enviar notificacion
                $mPushNotification = getPush('CENTRAL',"Señor conductor: El administrador de Radio Movil Clasico le acaba de asignarle con un Nuevo Numero de Interno: ".$request['codigo_interno'].".",null,"taxi","","","0","0","6");        
                $tokens = array(); 
                $conductor=DB::select("SELECT token  from conductor WHERE  ci=".$request['ci_interno']);    
                foreach ($conductor as $key => $con) {
                     array_push($tokens, $con->token); 
                    }    
                  $devicetoken = $tokens;                              
                $sw_notificacion=send($tokens,$mPushNotification);
                //fin de envio de notificacion
                
                }
                catch(Exception $e)
                {
                   Session::flash('message-error','NO SE PUEDO CAMBIAR EL CODIGO INTERNO');
                }
                
             return Redirect::to('/vehiculo');  
       }


     public function Liberar_movil(Request $request){ 
            try{
                DB::table('conductor')->where('ci', $request['ci_conductor'])->update(['id_vehiculo' => '0']); 
                DB::table('asignacion')->insert(['id_conductor' =>$request['ci_conductor'],'descripcion'=>'MOVIL LIBERADO','id_vehiculo'=>'0']);

                Session::flash('message','VEHICULO LIBERADO');


                 //enviar notificacion
                $mPushNotification = getPush('CENTRAL',"Señor conductor: El administrador de Taxi Valle elimino la asignación de su vehiculo. Porfavor aproximece a la central para que le asignen con otro Movil.",null,"taxi","","","0","0","6");        
                $tokens = array(); 
                $conductor=DB::select("SELECT token  from conductor WHERE  ci=".$request['ci_conductor']);    
                foreach ($conductor as $key => $con) {
                     array_push($tokens, $con->token); 
                    }    
                  $devicetoken = $tokens;                              
                $sw_notificacion=send($tokens,$mPushNotification);
                //fin de envio de notificacion
                }
                catch(Exception $e)
                {
                   Session::flash('message-error','NO SE PUEDO LEBERAR EL VEHICULO');
                }
                
             return Redirect::to('/vehiculo');  
       }   
   public function Liberar_conductor(Request $request){ 
            try{
                DB::table('conductor')->where('ci', $request['ci_conductor'])->update(['id_vehiculo' => '0']); 
                DB::table('asignacion')->insert(['id_conductor' =>$request['ci_conductor'],'descripcion'=>'CONDUCTOR LIBERADO','id_vehiculo'=>'0']);
                Session::flash('message','CONDUCTOR LIBERADO');

                 //enviar notificacion
                $mPushNotification = getPush('CENTRAL',"Señor conductor: El administrador de Taxi Valle elimino la asignación de su vehiculo. Porfavor aproximece a la central para que le asignen con otro Movil.",null,"taxi","","","0","0","6");        
                $tokens = array(); 
                $conductor=DB::select("SELECT token  from conductor WHERE  ci=".$request['ci_conductor']);    
                foreach ($conductor as $key => $con) {
                     array_push($tokens, $con->token); 
                    }    
                  $devicetoken = $tokens;                              
                $sw_notificacion=send($tokens,$mPushNotification);
                //fin de envio de notificacion
                }
                catch(Exception $e)
                {
                   Session::flash('message-error','NO SE PUEDO LIBERAR EL CONDUCTOR');
                }
                
             return Redirect::to('/conductor');  
       }     


    //CARGAR PERFIL DEL CONDUCTOR
    function Cargar_Perfil_Conductor($direccion){
        if ($direccion != "") {
            $perfil = file_get_contents($direccion); 
        }else{
            $perfil="";
        }
        return response($perfil);              
    }

//////////////// P D F
  public function conductors_pdf($ci){ 
   // $direccion_imagen=DB::select("SELECT conductor.direccion_imagen from conductor WHERE conductor.ci=".$ci); 
    $perfil="";
    $direccion="";
   /*
    if ($direccion_imagen[0]->direccion_imagen != "") {
        $perfil = file_get_contents($direccion_imagen[0]->direccion_imagen);
        $direccion=$direccion_imagen[0]->direccion_imagen;          
     } 
     foreach ($direccion_imagen as $key => $value) {
         $perfil=$value->direccion_imagen;
     }
     */
    $conductor=DB::select("SELECT '".$perfil."' as dato,conductor.nombre, conductor.paterno, conductor.materno, conductor.ci, conductor.expedido, empresa.razon_social, empresa.nit,conductor.direccion_imagen from conductor,empresa WHERE conductor.id_empresa=empresa.id AND conductor.ci=".$ci);
    $pdf=\PDF::loadView('conductor.Conductor-PDF',['conductor'=>$conductor]);
   // return   $pdf->stream();
   return view('conductor.qr_conductor',['conductor'=>$conductor]);
  }

   function get_pedidos_estadistica(){
        $pedido=DB::select("SELECT DATE(pp.fecha_pedido)as 'fecha',(select count(*) from pedido p,conductor c where p.estado=2 and p.id_conductor=c.ci and c.id_empresa='".Auth::user()->id_empresa."' and date(p.fecha_pedido)=fecha)as 'cantidad_finalizado' ,(select count(*) from pedido p,conductor c where p.estado>2 and p.id_conductor=c.ci and c.id_empresa='".Auth::user()->id_empresa."' and date(p.fecha_pedido)=fecha)as 'cantidad_cancelado',(select count(*) from pedido p where p.estado=0 and p.id_conductor is null and date(p.fecha_pedido)=fecha)as 'cantidad_sin_aceptar',(select count(*) from pedido p,conductor c where p.estado<2 and p.id_conductor=c.ci and c.id_empresa='".Auth::user()->id_empresa."' and date(p.fecha_pedido)=fecha)as 'cantidad_sin_finalizar' from pedido pp where date(pp.fecha_pedido) BETWEEN date_add(now(),interval -30 DAY) and date(now()) GROUP by fecha");
        return response($pedido);              
    }

    function kardex_pdf($ci){

      $empresa=DB::select("SELECT * from empresa where id='".Auth::user()->id_empresa."'");
      $conductor=DB::select("SELECT * from conductor where ci='".$ci."'");

      $id_imagen="";
      foreach ($empresa as $key => $value) {
        $id_imagen=$value->id_imagen_corporativa;
      }
      
      if($id_imagen!="")
      {
        $corporativa=DB::select("SELECT direccion from foto where id_fotocopia='".$id_imagen."' ");
        foreach ($corporativa as $key => $value) {
        $id_imagen=$value->direccion;
        }
      }
      $asignacion=DB::select("SELECT v.* from vehiculo v, conductor c where v.placa=c.id_vehiculo and  c.ci='".$ci."' ");
      $cant_a=0;
      foreach ($asignacion as $key => $value) {
        $cant_a++;
      }

      //$pdf=\PDF::loadView('conductor.kardex_pdf', ['conductor'=>$conductor,'empresa'=>$empresa,'contenido'=>$id_imagen,'asignacion'=>$asignacion,'cantidad_asignacion'=>$cant_a]);
      // return   $pdf->stream();

       return view('conductor.kardex_pdf', ['conductor'=>$conductor,'empresa'=>$empresa,'contenido'=>$id_imagen,'asignacion'=>$asignacion,'cantidad_asignacion'=>$cant_a]);
    }

        public function pagar_empresa_conductor(Request $request){
        try {
          DB::beginTransaction();
          $monto=$request->get('monto');
          $id_conductor=$request->get('id_conductor_fac');
          $observacion=$request->get('observacion');
          $monto_total_aux=$monto; 

            if ($request['monto'] > $request['monto_aux'] ||  $monto<=0) {
                      DB::rollback();
                      return redirect('/conductor')->with("message-error","ERROR: LA CANTIDAD DE PAGO ESTA MAL, VERIFIQUE NUEVAMENTE");      
            } else {                
                $pedido=DB::select("SELECT id, monto_conductor from pedido where monto_conductor>0 and id_conductor='".$id_conductor."'");
                foreach ($pedido as $key => $value) {
                  $monto_pedido=$value->monto_conductor;
                  if($monto>$monto_pedido)
                  {$monto=$monto-$monto_pedido;
                    $pedido_actualizar = DB::table('pedido')->where('id',$value->id)->where('id_conductor',$id_conductor)->update(['monto_conductor'=>0]);
                  }else if($monto>0 && $monto_pedido>0 )
                  {$monto_aux=$monto_pedido-$monto;
                    $monto=0;
                     $pedido_actualizar = DB::table('pedido')->where('id',$value->id)->where('id_conductor',$id_conductor)->update(['monto_conductor'=>$monto_aux]);
                  }
                }
              DB::commit();

                if($monto_total_aux==0){
                   return redirect('/conductor')->with("message-error","EL MONTO QUE INGRESO ES INVALIDO"); 
                }
                else if($monto>0){
                  $monto_total_aux=$monto_total_aux-$monto;
                   DB::table('egreso')->insert([  
                    'id_conductor' => $id_conductor,
                    'observacion'=>$observacion,
                    'id_login'=>Auth::user()->id,
                    'id_empresa'=>Auth::user()->id_empresa,
                    'opcion'=>2,
                    'id_tipo_ingreso_egreso'=>$request['id_tipo_ingreso_egreso'],
                    'monto'=>$monto_total_aux ]); 
                   return redirect('/conductor')->with("message-error","SOLO PUDIMOS REGISTRAR ( ".$monto_total_aux." Bs) DEL TOTAL"); 
                }else if($monto==0 && $monto_total_aux>0){
                   DB::table('egreso')->insert([  
                    'id_conductor' => $id_conductor,
                    'observacion'=>$observacion,
                    'id_login'=>Auth::user()->id,
                    'id_empresa'=>Auth::user()->id_empresa,
                    'opcion'=>2,
                    'id_tipo_ingreso_egreso'=>$request['id_tipo_ingreso_egreso'],
                    'monto'=>$monto_total_aux ]); 

                return redirect('/conductor')->with("message","SE REALIZO EL PAGO CORRECTAMENTE");  
                } 
                
            }                    

        } catch (Exception $e) {
          DB::rollback();
          return redirect('/conductor')->with("message-error","ERROR INTENTE NUEVAMENTE");      
        }      
    }

        function cargar_historial_imei($id_usuario){
        $admin=DB::select("SELECT * from imei_bk where id_conductor='".$id_usuario."' ORDER BY fecha desc limit 30");
        return response($admin);
    }

    function cargar_historial_caja($id_conductor){
      //opcion
      // 3: ingresos y egresos de caja del conductor.

      $ingresos=DB::select("SELECT i.*,u.usuario from ingreso i,users u where u.id=i.id_login and i.opcion=3 and  i.id_conductor='".$id_conductor."'");
      $egresos=DB::select("SELECT * from egreso where opcion=3 and  id_conductor='".$id_conductor."'");
      return View('conductor.historial_caja',['ingresos'=>$ingresos,'egresos'=>$egresos]);

    }

    function cargar_historial_pro_accidente($id_conductor){
      //opcion
      // 4: ingresos y egresos de pro accidente del conductor.

      $ingresos=DB::select("SELECT i.*,u.usuario from ingreso i,users u where u.id=i.id_login and i.opcion=4 and  i.id_conductor='".$id_conductor."'");
      $egresos=DB::select("SELECT * from egreso where opcion=4 and  id_conductor='".$id_conductor."'");
      return View('conductor.historial_pro_accidente',['ingresos'=>$ingresos,'egresos'=>$egresos]);

    }

     function historial_asignacion($id_conductor){
      //opcion
      $historial=DB::select("SELECT a.*,concat(c.nombre,' ',c.paterno,' ',c.materno) as 'conductor' from asignacion a, conductor c where c.ci=a.id_conductor and a.id_conductor='".$id_conductor."'");
      return View('conductor.historial_asignacion',['historial'=>$historial]);
    }


 function cargar_contactos_conductor($id_conductor){
      //opcion
      // 3: ingresos y egresos de caja del conductor.

      $contactos=DB::select("SELECT * from contacto where id_conductor='".$id_conductor."'");
       
      return View('conductor.contactos_conductor',['contactos'=>$contactos]);

    }

  public function usuarios_completo_conductor($id_conductor){   
        $usuario=DB::select("
          SELECT 
      id,
      IFNULL(nombre,'') AS nombre,
      IFNULL(apellido,'') as apellido,
      IFNULL(celular,'') as celular,
      IFNULL(correo,'') as correo,
      token,
      token_traigo,
      IFNULL(direccion_imagen,'') as direccion_imagen,
      localidad,
      (SELECT COUNT(c.id_usuario) 
          from chat c WHERE  c.id_usuario=usuario.id GROUP BY c.id_usuario) as cantidad 
          from usuario WHERE id in (SELECT chat.id_usuario from chat where chat.id_conductor=".$id_conductor." GROUP BY chat.id_usuario) ORDER BY cantidad DESC ");   
         
        $row = array('usuario'=>$usuario);       
        return response($row);
    }

   function chat_conductor($id_conductor){
    

     $conductor=DB::select("SELECT * from conductor where ci=".$id_conductor);


           
     return view('conductor.chat_conductor',[ 'conductor'=>$conductor]);  
   }

     function chat_mensaje_conductor($id_usuario,$id_conductor){   
        $chat=DB::select("SELECT * from chat c where c.id_usuario=".$id_usuario." 
            AND c.id_conductor=".$id_conductor);   
         
        $row = array('chat'=>$chat);       
        return response($row);
    }

   
   




}
