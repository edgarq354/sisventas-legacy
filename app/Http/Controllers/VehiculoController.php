<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\VehiculoRequest;
use App\Http\Requests\VehiculoUpdateRequest;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use App\Vehiculo;
use App\Notificacion;
use Illuminate\Support\Facades\DB;

use App\Http\Requests;
use Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class VehiculoController extends Controller
{
    public function __construct() {
         $this->middleware('auth');
    }

	function index(){
   if(Auth::user()->privilegio==1){
          //ADMINISTRADOR DE TOD
          $vehiculo=DB::table('vehiculo')->where('estado','<>','6')->orderby('id_empresa')->get();
        
       return view('vehiculo.administrador.index',["vehiculo"=>$vehiculo]);        

        } else {
            $vehiculo=DB::table('vehiculo')->select('*')->where('vehiculo.id_empresa', Auth::user()->id_empresa)->where('estado','<>','6')->orderby('placa')->get();
       return view('vehiculo.index',["vehiculo"=>$vehiculo]);        
        }
	}

 public function vehiculo_retirado(){
    
    
          //ADMINISTRADOR DE TOD
           $vehiculo=DB::table('vehiculo')->select('*')->where('vehiculo.id_empresa', Auth::user()->id_empresa)->where('estado','=','6')->orderby('placa')->get();
           return view('vehiculo.index_retirado',["vehiculo"=>$vehiculo]);        
        
  }

 public function vehiculo_pre_registro(){
    
    
          //ADMINISTRADOR DE TOD
           $vehiculo=DB::table('vehiculo')->select('*')->where('vehiculo.id_empresa', Auth::user()->id_empresa)->where('estado','=','7')->orderby('placa')->get();
           return view('vehiculo.index_pre_registro',["vehiculo"=>$vehiculo]);        
        
  }
  
  
  
  
	public function create(){
    
       if(Auth::user()->privilegio==1){
          //ADMINISTRADOR DE TOD
          $empresa=DB::table('empresa')
                ->select('empresa.*')
                ->get();
        }else {
       $empresa=DB::table('empresa')
                ->select('empresa.*')
                ->paginate(15);
         }            
          $radio = DB::select("SELECT r.* from radio r where r.estado=1 and r.id not in(select v.nro_radio from vehiculo v)  ");
        return view('vehiculo.create',['empresa'=>$empresa,'radio'=>$radio]);	
    }
 
     function historial_asignacion($id_vehiculo){
      //opcion
      $historial=DB::select("SELECT a.*,concat(c.nombre,' ',c.paterno,' ',c.materno) as 'conductor' from asignacion a, conductor c where c.ci=a.id_conductor and a.id_vehiculo='".$id_vehiculo."'");
      return View('conductor.historial_asignacion',['historial'=>$historial]);
    }
 public function historial_baja_alta($placa){
    $historial=DB::select("SELECT h.*,u.nombre as 'usuario' FROM historial_baja_alta h, users u where  u.id=h.id_login and h.id_vehiculo='".$placa."'");
    return View('conductor.historial_baja_alta',['historial'=>$historial]);
   }

    public function store(VehiculoRequest $request){
      try {
        $movil=0;
        $moto=0;
        $lujo=0;
        $aire=0;
        $parrilla=0;
        $camioneta=0;
        $maletero_libre=0;
         
        if($request['lujo']){
          $lujo=1;
        }
        if($request['aire']){
          $aire=1;
        }
        if($request['maletero_libre']){
          $maletero_libre=1;
        }
         if($request['parrilla']){
          $parrilla=1;
        }
         if($request['camioneta']){
          $camioneta=1;
        }

        if($request['moto']){
          $moto=1;
        }else{
          $movil=1;
        }

      DB::beginTransaction();
       $verificar=DB::select("SELECT COUNT(*)as contador from vehiculo WHERE vehiculo.placa='".$request['placa']." ' ");
        foreach ($verificar as $key => $value) {
          $contador=$value->contador;
        }
        if ($contador==0) {  
          

           $direccion_perfil="";          
           if ($request['ci_apoderado'] == "") { //SI ES IGUAL A VACIO SIGNIFICA Q NO TIENE APODERADO  //|| $request['expedido_apoderado'] == "" || $request['nombre_apoderado'] == "" || $request['paterno_apoderado'] == "" || $request['materno_apoderado'] == "" || $request['fecha_nacimiento_apoderado'] == ""
             $verificar=DB::select("SELECT COUNT(*)as contador from duenio WHERE duenio.ci=".$request['ci_propietario']);

             if ($verificar[0]->contador == 0) { //SI NO EXISTE NINGUN PROPIETARIO EN LA TABLA DUENIO SE CREA
              if ($request['imagen_pro'] != "") {
                $gestor = fopen($request['imagen_pro'], "r");
                $contenido = fread($gestor, filesize($request['imagen_pro']));
                $contenido = base64_encode($contenido);
                fclose($gestor);      
                $direccion_perfil = "Imagen_Duenio/Perfil-".$request['ci_propietario'].".txt";                
                file_put_contents($direccion_perfil, $contenido);  
              }
                DB::table('duenio')->insert(['ci'=>$request['ci_propietario'], 'expedido'=>$request['expedido_propietario'],'nombre'=>$request['nombre_propietario'], 'paterno'=>$request['paterno_propietario'],'materno'=>$request['materno_propietario'],'titulo'=>$request['titulo_propietario'],'correo'=>$request['correo_propietario'],'fecha_nacimiento'=>$request['fecha_nacimiento_propietario'], 'direccion_imagen'=>$direccion_perfil ]);                  
             } 
                DB::table('vehiculo')->insert([ // LA TERCERA TABLA FASE GALPON
                'placa' => strtoupper($request['placa']), 
                'marca' => strtoupper($request['marca']), 
                'modelo' => $request['modelo'], 
                'cilindrada' => $request['cilindrada'],
                'color' => $request['color'], 
                'tipo' => $request['tipo'],
                'clase' => $request['clase'],
                'nro_poliza' => $request['nro_poliza'],
                'traccion' => $request['traccion'],
                'movil' =>$movil,
                'moto' =>$moto,
                'lujo' => $lujo,
                'aire' => $aire,
                'parrilla' => $parrilla,
                'camioneta' => $camioneta,
                'maletero_libre' => $maletero_libre,
                'codigo_empresa' => $request['codigo_empresa'],
                'nro_chasis' => $request['nro_chasis'],
                'nro_rua' => $request['nro_rua'],
                'id_propietario' => $request['ci_propietario'], 
                'nro_documento_propiedad' => $request['nro_documento_propiedad'], 
                'nro_soat' => $request['nro_soat'], 
                'nro_inspeccion_tecnica' => $request['nro_inspeccion_tecnica'], 
                'nro_puertas' => $request['nro_puertas'], 
             'nro_radio' => $request['nro_radio'], 
                'nro_asientos' => $request['nro_asientos'], 
                'clasificacion_vehiculo' => $request['clasificacion_vehiculo'], 
                'servicio' => $request['servicio'], 
                'radicatoria' => $request['radicatoria'],
                'id_empresa' => $request['id_empresa']
                ]);                                       
           }
           else{//EN CASO Q TENGA UN APODERADO O POSEEDOR
             $propietario=DB::select("SELECT COUNT(*)as contador from duenio WHERE duenio.ci=".$request['ci_propietario']);
             if ($propietario[0]->contador == 0) { //SI NO EXISTE NINGUN PROPIETARIO EN LA TABLA DUENIO SE CREA
              if ($request['imagen_pro'] != "") {
                $gestor = fopen($request['imagen_pro'], "r");
                $contenido = fread($gestor, filesize($request['imagen_pro']));
                $contenido = base64_encode($contenido);
                fclose($gestor);      
                $direccion_perfil = "Imagen_Duenio/Perfil-".$request['ci_propietario'].".txt";                
                file_put_contents($direccion_perfil, $contenido);                  
              }
              DB::table('duenio')->insert([
                'ci'=>$request['ci_propietario'], 
                'expedido'=>$request['expedido_propietario'],
                'nombre'=>$request['nombre_propietario'], 
                'paterno'=>$request['paterno_propietario'],
                'materno'=>$request['materno_propietario'],
                'titulo'=>$request['titulo_propietario'],
                'correo'=>$request['correo_propietario'],
                'fecha_nacimiento'=>$request['fecha_nacimiento_propietario'], 
                'direccion_imagen'=> $direccion_perfil ]);
             }             
                
             $apoderado=DB::select("SELECT COUNT(*)as contador from duenio WHERE duenio.ci=".$request['ci_apoderado']);                 
             if ($apoderado[0]->contador == 0) {
              $direccion_perfil_apoderado="";              
              if ($request['imagen_apo'] != "") {
                $gestor = fopen($request['imagen_apo'], "r");
                $contenido = fread($gestor, filesize($request['imagen_apo']));
                $contenido = base64_encode($contenido);
                fclose($gestor);      
                $direccion_perfil_apoderado = "Imagen_Duenio/Perfil-".$request['ci_apoderado'].".txt";   
                file_put_contents($direccion_perfil_apoderado, $contenido);  
              }
 
                DB::table('duenio')->insert([
                  'ci'=>$request['ci_apoderado'], 
                  'expedido'=>$request['expedido_apoderado'],
                  'nombre'=>$request['nombre_apoderado'], 
                  'paterno'=>$request['paterno_apoderado'],
                  'materno'=>$request['materno_apoderado'],
                  'titulo'=>$request['titulo_apoderado'],
                  'correo'=>$request['correo_apoderado'],
                  'fecha_nacimiento'=>$request['fecha_nacimiento_apoderado'], 
                  'direccion_imagen'=> $direccion_perfil_apoderado]);                                      
             }
              
             DB::table('vehiculo')->insert([ // LA TERCERA TABLA FASE GALPON
             'placa' => strtoupper($request['placa']), 
             'marca' => strtoupper($request['marca']), 
             'modelo' => $request['modelo'], 
             'cilindrada' => $request['cilindrada'],
             'color' => $request['color'], 
             'tipo' => $request['tipo'],
             'clase' => $request['clase'],
              'movil' =>$movil,
              'moto' =>$moto,
                'lujo' => $lujo,
                'aire' => $aire,
               'parrilla' => $parrilla,
                'camioneta' => $camioneta,
                'maletero_libre' => $maletero_libre,
                'codigo_empresa' => $request['codigo_empresa'],
             'nro_poliza' => $request['nro_poliza'],
             'traccion' => $request['traccion'],
             'nro_chasis' => $request['nro_chasis'],
             'nro_rua' => $request['nro_rua'],
             'id_propietario' => $request['ci_propietario'],
             'id_apoderado' => $request['ci_apoderado'], 
             'nro_documento_propiedad' => $request['nro_documento_propiedad'], 
             'nro_soat' => $request['nro_soat'], 
             'nro_inspeccion_tecnica' => $request['nro_inspeccion_tecnica'], 
             'nro_puertas' => $request['nro_puertas'], 
             'nro_radio' => $request['nro_radio'], 
             'nro_asientos' => $request['nro_asientos'], 
             'clasificacion_vehiculo' => $request['clasificacion_vehiculo'], 
             'servicio' => $request['servicio'], 
             'radicatoria' => $request['radicatoria'],
             'id_empresa' => $request['id_empresa']
                   
             ]);                                                    
           }




            if($request['nro_radio']!="")
                  {
                    DB::table('historial_radio')->insert(['descripcion' =>"Asignado al registrar el vehiculo",'id_vehiculo'=>$request['placa'],'id_radio'=>$request['nro_radio'],'id_empresa'=>Auth::user()->id_empresa,'id_login'=>Auth::user()->id, 'fecha'=>date('Y-m-j'),'tipo'=>'1']);
                  }

                       
              DB::commit();          
            Session::flash('message','CREADO CORRECTAMENTE');
            return Redirect::to('/vehiculo');          
        } else {  ///EN CASO Q EXISTA YA UN VEHICULO CON ESA PLACA NO SE CREA
            Session::flash('message-error','YA EXISTE UN VEHICULO CON ESA PLACA');
            return Redirect::to('/vehiculo/create'); 
        }     
      }catch (Exception $e) {
          DB::rollback();
          return redirect('/vehiculo/create')->with("message-error","ERROR INTENTE NUEVAMENTE");      
      }   
    }

    function crear_archivos($imagen, $direccion){
        $gestor = fopen($imagen, "r");
        $contenido = fread($gestor, filesize($imagen));
        $contenido = base64_encode($contenido);
        fclose($gestor);      
        file_put_contents($direccion, $contenido);  
    }


    public function edit($placa){
       $vehiculo = DB::select("SELECT vehiculo.*,duenio.*,vehiculo.id_empresa as 'id_empresa_v' FROM vehiculo,duenio WHERE vehiculo.id_propietario=duenio.ci AND vehiculo.placa='".$placa."' ");
       $duenio = DB::select("SELECT d.*,v.id_apoderado FROM duenio d,vehiculo v WHERE d.ci=v.id_propietario and v.placa='".$placa."'  ");
       $apoderado = DB::select("SELECT d.* FROM duenio d,vehiculo v WHERE d.ci=v.id_apoderado and v.placa='".$placa."'  ");
       
       $rua=DB::select("SELECT fo.* FROM vehiculo v,fotocopia f, foto fo WHERE f.id=fo.id_fotocopia and f.id=v.id_fotocopia_rua and v.placa='".$placa."'  ");

       $ci_rua=DB::select("SELECT fo.* FROM vehiculo v,fotocopia f, foto fo WHERE f.id=fo.id_fotocopia and f.id=v.id_fotocopia_ci_titular_del_rua and v.placa='".$placa."'  ");

      $propiedad=DB::select("SELECT fo.* FROM vehiculo v,fotocopia f, foto fo WHERE f.id=fo.id_fotocopia and f.id=v.id_fotocopia_documento_de_propiedad and v.placa='".$placa."'  ");

      $soat=DB::select("SELECT fo.* FROM vehiculo v,fotocopia f, foto fo WHERE f.id=fo.id_fotocopia and f.id=v.id_fotocopia_soat and v.placa='".$placa."'  ");

      $inspeccion=DB::select("SELECT fo.* FROM vehiculo v,fotocopia f, foto fo WHERE f.id=fo.id_fotocopia and f.id=v.id_foto_inspeccion_tecnica and v.placa='".$placa."'  ");
       
        $asignacion=DB::select("SELECT * from conductor where  id_vehiculo like '".$placa."' and id_empresa='".Auth::user()->id_empresa."'");
      $cant_a=0;

       $conductor_libre = DB::select("SELECT c.* from conductor c where c.id_vehiculo='0' and estado<>6");
       $radio = DB::select("SELECT r.* from radio r where r.estado=1 and r.id not in(select v.nro_radio from vehiculo v)  ");


      foreach ($asignacion as $key => $value) {
        $cant_a++;
      }



 

    //buscar empresa               

       return view('vehiculo.edit',[
        'vehiculo'=>$vehiculo,
        'duenio'=>$duenio,
        'apoderado'=>$apoderado,
        'rua'=>$rua,
        'ci_rua'=>$ci_rua,
        'propiedad'=>$propiedad,
        'soat'=>$soat,
        'inspeccion'=>$inspeccion,
        'asignacion'=>$asignacion,
        'cantidad_asignacion'=>$cant_a,
        'conductor_libre'=>$conductor_libre,
        'radio'=>$radio]);
    }

    public function update(VehiculoUpdateRequest $request){

       $movil=0;
        $lujo=0;
        $aire=0;
        $maletero_libre=0;
        $moto=0;
        $parrilla=0;
        $camioneta=0;
         
        if($request['lujo']){
          $lujo=1;
        }
        if($request['aire']){
          $aire=1;
        }
        if($request['maletero_libre']){
          $maletero_libre=1;
        }
        if($request['moto']){
          $moto=1;
        }else{
         $movil=1; 
        }

 if($request['camioneta']){
          $camioneta=1;
        }

         if($request['parrilla']){
          $parrilla=1;
        }



      if ($request['placa'] == $request['placa_aux']) {

            $placa=$request['placa'];
            DB::table('vehiculo')->where('placa', $placa)->update([
              'placa' => $request['placa'], 
              'marca' => $request['marca'], 
              'modelo' => $request['modelo'], 
              'cilindrada' => $request['cilindrada'], 
              'color' => $request['color'], 
              'tipo' => $request['tipo'], 
              'clase' => $request['clase'], 
              'movil' =>$movil,
                'lujo' => $lujo,
                'aire' => $aire,
                'moto' => $moto,
                'parrilla' => $parrilla,
                'camioneta' => $camioneta,
                'maletero_libre' => $maletero_libre,
                'codigo_empresa' => $request['codigo_empresa'],
              'nro_poliza' => $request['nro_poliza'], 
              'traccion' => $request['traccion'], 
              'nro_chasis' => $request['nro_chasis'], 
              'nro_rua' => $request['nro_rua'], 
              'nro_documento_propiedad' => $request['nro_documento_propiedad'], 
              'nro_soat' => $request['nro_soat'], 
              'nro_inspeccion_tecnica' => $request['nro_inspeccion_tecnica'], 
              'nro_puertas' => $request['nro_puertas'], 
              'nro_asientos' => $request['nro_asientos'], 
              'clasificacion_vehiculo' => $request['clasificacion_vehiculo'], 
              'servicio' => $request['servicio'],
              'radicatoria' => $request['radicatoria'],
             ]);
            Session::flash('message','ACTUALIZADO CORRECTAMENTE');
            return Redirect::to('/vehiculo');          
        } else {
            $verificar=DB::select("SELECT COUNT(*)as contador from vehiculo WHERE vehiculo.placa='".$request['placa']."'");
              foreach ($verificar as $key => $value) {
                  $contador=$value->contador;
              }
            if($contador == 0){
                $placa=$request['placa_aux'];
                DB::table('vehiculo')->where('placa', $placa)->update([
                  'placa' => $request['placa'], 
                  'marca' => $request['marca'], 
                  'modelo' => $request['modelo'], 
                  'cilindrada' => $request['cilindrada'], 
                  'color' => $request['color'], 
                  'tipo' => $request['tipo'], 
                  'clase' => $request['clase'], 
                  'movil' =>$movil,
                  'lujo' => $lujo,
                  'aire' => $aire,
                  'parrilla' => $parrilla,
                'camioneta' => $camioneta,
                  'maletero_libre' => $maletero_libre,
                  'codigo_empresa' => $request['codigo_empresa'],
                  'nro_poliza' => $request['nro_poliza'], 
                  'traccion' => $request['traccion'], 
                  'nro_chasis' => $request['nro_chasis'], 
                  'nro_rua' => $request['nro_rua'], 
                  'nro_documento_propiedad' => $request['nro_documento_propiedad'], 
                  'nro_soat' => $request['nro_soat'], 
                  'nro_inspeccion_tecnica' => $request['nro_inspeccion_tecnica'], 
                  'nro_puertas' => $request['nro_puertas'], 
                  'nro_asientos' => $request['nro_asientos'], 
                  'clasificacion_vehiculo' => $request['clasificacion_vehiculo'], 
                  'servicio' => $request['servicio'],
                  'radicatoria' => $request['radicatoria'],
                 ]); 
                Session::flash('message','ACTUALIZADO CORRECTAMENTE');
                return Redirect::to('/vehiculo'); 
            }
            else{
                Session::flash('message-error','YA EXISTE UN VEHICULO CON ESE NUMERO DE PLACA "'.$request['placa'].'" VERIFIQUE POR FAVOR');
                return Redirect::to("/vehiculo/".$request['placa_aux']."/edit"); 
            }          
        }
    }
    
    public function destroy($id, Request $request){
        $vehiculo=Vehiculo::find($id);
        $vehiculo->delete();
        Session::flash('message','vehiculo Eliminado Correctamente');
       return Redirect::to('/vehiculo');
    }

    //CARGAR PARA VERIFICAR SI EXISTE EL CI DEL PROPIETARIO
    function verificar_ci_propietario($ci){
      $direccion="";
        $direccion_im=DB::select("SELECT count(*)as cont, duenio.* FROM duenio where duenio.ci=".$ci);
        if ($direccion_im[0]->cont != 0) {
          if ($direccion_im[0]->direccion_imagen != "") {
            $direccion = file_get_contents($direccion_im[0]->direccion_imagen);                       
          }
        }
        $duenio=DB::select("SELECT count(*)as contador,'".$direccion."' as imagen,duenio.* FROM duenio where duenio.ci=".$ci);        
        return response($duenio);
    }


    //CARGAR PARA VERIFICAR SI EXISTE LA PLACA DEL VEHICULO
    function verificar_placa($placa){
      /*$direccion_imagen_adelante="";
      $direccion_imagen_atras="";
      $direccion_imagen_interior_adelante="";
      $direccion_imagen_interior_atras="";
      $direccion_im=DB::select("SELECT COUNT(*)as contador,vehiculo.* from vehiculo WHERE vehiculo.placa='".$placa."'");
      if ($direccion_im[0]->contador != 0) {
        echo $direccion_im[0]->direccion_imagen_adelante;
        if ($direccion_im[0]->direccion_imagen_adelante != NULL ) {
          $direccion_imagen_adelante = file_get_contents($direccion_im[0]->direccion_imagen_adelante);                       
        }
        if ($direccion_im[0]->direccion_imagen_atras != NULL) {
          $direccion_imagen_atras = file_get_contents($direccion_im[0]->direccion_imagen_atras);                       
        }
        if ($direccion_im[0]->direccion_imagen_interior_adelante != NULL) {
          $direccion_imagen_interior_adelante = file_get_contents($direccion_im[0]->direccion_imagen_interior_adelante);                       
        }
        if ($direccion_im[0]->direccion_imagen_interior_atras != NULL) {
          $direccion_imagen_interior_atras = file_get_contents($direccion_im[0]->direccion_imagen_interior_atras);                       
        }                        
      }   */   
      /*$vehiculo=DB::select("SELECT COUNT(*)as contador,'".$direccion_imagen_adelante."' as direccion_imagen_adelante, '".$direccion_imagen_atras."' as direccion_imagen_atras, '".$direccion_imagen_interior_adelante."' as direccion_imagen_interior_adelante, '".$direccion_imagen_interior_atras."' as direccion_imagen_interior_atras , vehiculo.* from vehiculo WHERE vehiculo.placa='".$placa."'");*/
      $vehiculo=DB::select("SELECT COUNT(*)as contador, v.*,e.razon_social,e.direccion,e.whatsapp from vehiculo v,empresa e WHERE e.id=v.id_empresa and v.placa='".$placa."' limit 1");
      return response($vehiculo);
    }   



    //CARGAR PARA VERIFICAR SI EXISTE EL CI DEL APODERADO
    function Cargar_Apoderado($ci){
        $apoderado=DB::select("SELECT *FROM duenio WHERE duenio.ci=".$ci);
        return response($apoderado);
    }         


    //CARGAR PARA PODER ACTUALIZAR EN LA PARTE DEL MODAL
    public function cargar_vehiculo($placa){
        $vehiculo=DB::select("SELECT *from vehiculo where vehiculo.placa='".$placa."'");
        return response($vehiculo);
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
        $lista=DB::select("SELECT pedido.id,pedido.monto_motista_aux,pedido.fecha from pedido WHERE pedido.monto_motista_aux>0 AND pedido.id_vehiculo like '".$id."'");       
        return response($lista);
    }

    //BUSCAR PAGO DE LOS MOTISTA
    public function pago_motista(){
        $buscar_vehiculo=DB::select("SELECT id,nombre,apellido,ci,placa,modelo,color,celular FROM vehiculo");        
        $pago=DB::select("SELECT id,nombre,apellido,ci,placa,modelo,color,celular FROM vehiculo");        
        return view("vehiculo.pago_motista",compact('pago','buscar_vehiculo'));
    }

    //MUESTRA EL MONTO Q LE DEBE PAGAR AL MOTISTA
    public function cargar_pago_motista($id){      
        $pago_vehiculo=DB::select("SELECT SUM(pedido.monto_motista_aux)as monto_motista from pedido WHERE pedido.monto_motista_aux>0 AND pedido.id_vehiculo like '".$id."'");
        return response($pago_vehiculo);
    }



////////////////////////////////////////////////////////////////////////////////
//////////////////HISTORIAL DE CARRERAS DE LOS MOTISTAS/////////////////////////
////////////////////////////////////////////////////////////////////////////////

    //MUESTRA LA PLANTILLA DE HISTORIAL DE CARRERA
    public function show($id){
        if (Auth::user()->privilegio == 1) {
           $vehiculo = vehiculo::find($id);
           $fechas = DB::select("SELECT DATE_SUB(curdate(), INTERVAL + 29 DAY) as fecha_inicio, curdate() as fecha_fin");
           return view('vehiculo.historial_carrera',['vehiculo'=>$vehiculo], compact('fechas'));             
        } else {
            $verificar=DB::select("SELECT *from vehiculo WHERE vehiculo.id=".$id);
            if ($verificar[0]->id_empresa == Auth::user()->id) {
               $vehiculo = vehiculo::find($id);
               $fechas = DB::select("SELECT DATE_SUB(curdate(), INTERVAL + 29 DAY) as fecha_inicio, curdate() as fecha_fin");
               return view('vehiculo.historial_carrera',['vehiculo'=>$vehiculo], compact('fechas'));            
            } else {            
               return view('errors.404');            
            }            
        }
    }
    //MUESTRA LA PLANTILLA DE HISTORIAL DE CARRERA
   /* public function historial_carrera($id, $fecha_inicio, $fecha_fin){
        $vehiculo = DB::select("SELECT CONCAT(usuario.nombre,' ',usuario.apellido) as usuario,pedido.fecha_pedido,pedido.direccion from pedido,vehiculo,empresa,usuario WHERE pedido.id_vehiculo=vehiculo.id and vehiculo.id_empresa=empresa.id AND pedido.id_usuario=usuario.id and vehiculo.id=".$id."  AND pedido.fecha_pedido BETWEEN '".$fecha_inicio."' AND DATE_SUB('".$fecha_fin."',INTERVAL -1 DAY) order by pedido.fecha_pedido DESC");
       return response($vehiculo);
    }

    public function historial_carrera_detalle($id_pedido){
        $detalle=DB::select("SELECT *,date_format(carrera.fecha_inicio,'%d-%m-%Y %h:%i %p')as fecha_pedido FROM carrera WHERE id_pedido=".$id_pedido);
        return response($detalle);
    }*/


////////////////////////////////////////////////////////////////////////////////
//////////////////BUSQUEDA DE LAS vehiculoS/////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////

    //PARA BUSCAR UN MOTISTA ESPECIFICO
    public function busqueda_vehiculo(){
        if (Auth::user()->privilegio == 1) {
            $buscar_vehiculo=DB::select("SELECT id,nombre,apellido,ci,placa,modelo,color,celular FROM vehiculo");                    
            $buscar_empresa=DB::select("SELECT * FROM empresa WHERE empresa.privilegio=0");                    
            return view("vehiculo.busqueda_vehiculo",compact('buscar_vehiculo','buscar_empresa'));
        } else {
            $buscar_vehiculo=DB::select("SELECT id,nombre,apellido,ci,placa,modelo,color,celular FROM vehiculo where vehiculo.id_empresa=".Auth::user()->id); 
            return view("vehiculo.busqueda_vehiculo",compact('buscar_vehiculo'));                            
        }        
    }

    //MUESTRA LOS MOTISTAS ACTIVOS
    public function buscar_activos_vehiculo(){  
        if (Auth::user()->privilegio == 1) {
            $activos=DB::select("SELECT *from vehiculo WHERE vehiculo.estado=1");                                 
        } else {
            $activos=DB::select("SELECT *from vehiculo WHERE vehiculo.estado=1 and vehiculo.id_empresa=".Auth::user()->id);                    
        }              
        return response($activos);
    }

    //MUESTRA LOS MOTISTAS ACTIVOS
    public function buscar_inactivos_vehiculo(){      
        if (Auth::user()->privilegio == 1) {
            $inactivos=DB::select("SELECT *from vehiculo WHERE vehiculo.estado=0");                                
        } else {
            $inactivos=DB::select("SELECT *from vehiculo WHERE vehiculo.estado=0 and vehiculo.id_empresa=".Auth::user()->id);                    
        }         
        return response($inactivos);
    }

    //MUESTRA LOS MOTISTAS ACTIVOS
    public function buscar_todo_los_vehiculo(){   
        if (Auth::user()->privilegio == 1) {
            $todos=DB::select("SELECT * FROM vehiculo");                    
        } else {
             $todos=DB::select("SELECT * FROM vehiculo where vehiculo.id_empresa=".Auth::user()->id);                    
        }                     
        return response($todos);
    }

    //MUESTRA LOS MOTISTAS ACTIVOS
    public function buscar_carrera_vehiculo(){      
        $carrera=DB::select("SELECT * FROM vehiculo WHERE vehiculo.estado=2 and vehiculo.id_empresa=".Auth::user()->id);        
        return response($carrera);
    }

    //MUESTRA UN SOLO MOTISTA ESPESIFICO
    public function buscar_un_vehiculo($id){      
        $motista=DB::select("SELECT * FROM vehiculo WHERE vehiculo.id=".$id);        
        return response($motista);
    }

/////BUSCAR vehiculoSTAS POR EMPRESA
    //MUESTRA LOS vehiculoSTA ACTIVOS DE UNA EMPRESA
    public function buscar_activos_vehiculo_adm($id_emp){  
        $activos=DB::select("SELECT *from vehiculo WHERE vehiculo.estado=1 and vehiculo.id_empresa=".$id_emp);                                
        return response($activos);
    }

    //MUESTRA LOS vehiculoSTA ACTIVOS
    public function buscar_inactivos_vehiculo_adm($id_emp){      
        $inactivos=DB::select("SELECT *from vehiculo WHERE vehiculo.estado=0 and vehiculo.id_empresa=".$id_emp);                       
        return response($inactivos);
    }

    //MUESTRA LOS vehiculoSTA ACTIVOS
    public function buscar_todo_los_vehiculo_adm($id_emp){   
        $todos=DB::select("SELECT * FROM vehiculo where vehiculo.id_empresa=".$id_emp);                                      
        return response($todos);
    }

    //MUESTRA LOS MOTISTAS ACTIVOS
    public function buscar_carrera_vehiculo_adm($id_emp){      
        $carrera=DB::select("SELECT * FROM vehiculo WHERE vehiculo.estado=2 and vehiculo.id_empresa=".$id_emp);        
        return response($carrera);
    }
    
    //ENVIAR NOTIFICACION A VARIOS vehiculoSTA EN BUSQUEDA
    function notificacion_busqueda_motista(Request $request){ 
        $mPushNotification = getPush("ASAPP",$request['detalle_msn'],null,"","","","","","20");        
        $id_vehiculo=$request->get('id_vehiculo_not');
        $token=$request->get('token_not');
        $cont=0;
        $tokens = array(); 
        while ( $cont < count($id_vehiculo)) {
          if ( ($token[$cont] != "0") && ($token[$cont] != "") ) {     
            array_push($tokens, $token[$cont]);                            
          }
            $cont=$cont+1;                    
        }     
        send($tokens,$mPushNotification);        

        Notificacion::create([
            'titulo' => "ASAPP",
            'mensaje' => $request['detalle_msn'],
            'tipo' => 1,
            'id_administrador' => $request->user()->id,
        ]);

        Session::flash('message','ENVIADO CORRECTAMENTE');
        return Redirect::to('/busqueda_motista');     
    }

    //ENVIAR NOTIFICACION A UN SOLO MOTISTA
    function notificacion_motista(Request $request){  
        $mPushNotification = getPush("ASAPP",$request['detalle'],null,"","","","","","20");        
        $tokens = array(); 
        if ( ($request['token_not'] != "0") && ($request['token_not'] != "") ) {     
            array_push($tokens, $request['token_not']);                            
        }            
        send($tokens,$mPushNotification);   

        Notificacion::create([
            'titulo' => "ASAPP",
            'mensaje' => $request['detalle'],
            'tipo' => 1,
            'id_administrador' => $request->user()->id,
        ]);

        Session::flash('message','ENVIADO CORRECTAMENTE');
        return Redirect::to('/vehiculo');            
    }

    //PDF DE VEHICULO
    
  public function vehiculo_pdf($placa){ 
    $vehiculo=DB::select("SELECT *from vehiculo,empresa WHERE vehiculo.id_empresa=empresa.id AND vehiculo.placa='".$placa."'");
    $pdf=\PDF::loadView('vehiculo.Vehiculo-PDF',compact('vehiculo'));
    //return   $pdf->stream();

    return view('vehiculo.qr_vehiculo',compact('vehiculo'));
  }  
  public function vehiculo_baja(Request $request){ 
                try{
                DB::table('vehiculo')->where('placa', $request['placa'])->update(['estado' => '6','fecha_retiro'=>date('Y-m-j H-m-00')]); 
                DB::table('conductor')->where('id_vehiculo', $request['placa'])->update(['id_vehiculo' => '0']); 
                DB::table('historial_baja_alta')->insert(['descripcion' =>$request['descripcion'],'id_vehiculo'=>$request['placa'],'id_login'=>Auth::user()->id, 'fecha' => $request['fecha'],'tipo'=>'0','numero_movil' =>$request['numero_movil']]);
                Session::flash('message','SE DIO DE BAJA');
                }
                catch(Exception $e)
                {
                   Session::flash('message-error','NO SE PUEDO REALIZAR LA BAJA EL VEHICULO');
                }
                return Redirect::to('/vehiculo');  
   }

     public function vehiculo_alta(Request $request){ 
            try{
                DB::table('vehiculo')->where('placa', $request['placa'])->update(['estado' => '1','fecha_retiro'=>date('Y-m-j H-m-00')]); 
               DB::table('historial_baja_alta')->insert(['descripcion' =>$request['descripcion'],'id_vehiculo'=>$request['placa'],'id_login'=>Auth::user()->id, 'fecha' => $request['fecha'],'tipo'=>'1']);
                Session::flash('message','SE DIO DE ALTA');
                }
                catch(Exception $e)
                {
                   Session::flash('message-error','NO SE PUEDO REALIZAR LA ALTA EL VEHICULO');
                }
                
             return Redirect::to('/vehiculo');  
       }

     public function cambiar_radio(Request $request){ 
            try{
              if($request['nro_radio_actual']!=$request['nro_radio_edit']){
                 DB::table('vehiculo')->where('placa', $request['placa'])->update(['nro_radio' => $request['nro_radio_edit']]); 
                 if($request['nro_radio_actual']!="")
                 {
                    DB::table('historial_radio')->insert(['descripcion' =>$request['descripcion_edit'],'id_vehiculo'=>$request['placa'],'id_radio'=>$request['nro_radio_actual'],'id_empresa'=>Auth::user()->id_empresa,'id_login'=>Auth::user()->id, 'fecha'=>date('Y-m-j'),'tipo'=>'0']);
                 }

                 if($request['nro_radio_edit']!="")
                  {
                    DB::table('historial_radio')->insert(['descripcion' =>$request['descripcion_edit'],'id_vehiculo'=>$request['placa'],'id_radio'=>$request['nro_radio_edit'],'id_empresa'=>Auth::user()->id_empresa,'id_login'=>Auth::user()->id, 'fecha'=>date('Y-m-j'),'tipo'=>'1']);
                  }
                  
                Session::flash('message','SE ACTUALIZO CORRECTAMENTE');
              }else{
                   Session::flash('message-error','TIENE LA MISMA RADIO O EL DATO ESTA VACIO.');
              }
                
                }
                catch(Exception $e)
                {
                   Session::flash('message-error','NO SE PUEDO ACTUALIZAR');
                }
                
             return Redirect::to('/vehiculo');  
       }


  public function subir_imagen_adelante(Request $request)
    {
        $archivo = $request->file('perfil_vehiculo_adelante');
        $input  = array('image' => $archivo) ;
        $reglas = array('image' => 'required|image|mimes:jpeg,jpg,bmp,png,gif|max:15000');
        $validacion = Validator::make($input,  $reglas);
        if ($validacion->fails()) 
        {
          return view("mensajes.msj_rechazado")->with("msj","El archivo no es una imagen valida");
        }
        else
        {

                        $nombre_original=$archivo->getClientOriginalName();
                            $extension=$archivo->getClientOriginalExtension();
                            $nuevo_nombre="FotoVehiculoAdelante-".$request['placa'].".".$extension;
                            $r1=Storage::disk('Imagen_Vehiculo')->put($nuevo_nombre,  \File::get($archivo) );
                            $rutadelaimagen="../storage/Imagen_Vehiculo/".$nuevo_nombre;

                        DB::table('vehiculo')->where('placa',$request['placa'])->update(['direccion_imagen_adelante'=>$rutadelaimagen]);
                    
                                return view("mensajes.msj_correcto")->with("msj","Imagen agregada correctamente");
                            
          
        }
    }

     public function subir_imagen_atras(Request $request)
    {
        $archivo = $request->file('perfil_vehiculo_atras');
        $input  = array('image' => $archivo) ;
        $reglas = array('image' => 'required|image|mimes:jpeg,jpg,bmp,png,gif|max:15000');
        $validacion = Validator::make($input,  $reglas);
        if ($validacion->fails())
        {
          return view("mensajes.msj_rechazado")->with("msj","El archivo no es una imagen valida");
        }
        else
        {

                            $nombre_original=$archivo->getClientOriginalName();
                            $extension=$archivo->getClientOriginalExtension();
                            $nuevo_nombre="FotoVehiculoAtras-".$request['placa'].".".$extension;
                            $r1=Storage::disk('Imagen_Vehiculo')->put($nuevo_nombre,  \File::get($archivo) );
                            $rutadelaimagen="../storage/Imagen_Vehiculo/".$nuevo_nombre;

                            DB::table('vehiculo')->where('placa',$request['placa'])->update(['direccion_imagen_atras'=>$rutadelaimagen]);
                    
                            return view("mensajes.msj_correcto")->with("msj","Imagen agregada correctamente");
                            
          
        }
    }

    public function subir_imagen_interior_adelante(Request $request)
    {
        $archivo = $request->file('perfil_vehiculo_interior_adelante');
        $input  = array('image' => $archivo) ;
        $reglas = array('image' => 'required|image|mimes:jpeg,jpg,bmp,png,gif|max:15000');
        $validacion = Validator::make($input,  $reglas);
        if ($validacion->fails())
        {
          return view("mensajes.msj_rechazado")->with("msj","El archivo no es una imagen valida");
        }
        else
        {

                        $nombre_original=$archivo->getClientOriginalName();
                            $extension=$archivo->getClientOriginalExtension();
                            $nuevo_nombre="FotoVehiculoInteriorAdelante-".$request['placa'].".".$extension;
                            $r1=Storage::disk('Imagen_Vehiculo')->put($nuevo_nombre,  \File::get($archivo) );
                            $rutadelaimagen="../storage/Imagen_Vehiculo/".$nuevo_nombre;

                        DB::table('vehiculo')->where('placa',$request['placa'])->update(['direccion_imagen_interior_adelante'=>$rutadelaimagen]);
                    
                                return view("mensajes.msj_correcto")->with("msj","Imagen agregada correctamente");
                            
          
        }
    }
    public function subir_imagen_interior_atras(Request $request)
    {
        $archivo = $request->file('perfil_vehiculo_interior_atras');
        $input  = array('image' => $archivo) ;
        $reglas = array('image' => 'required|image|mimes:jpeg,jpg,bmp,png,gif|max:15000');
        $validacion = Validator::make($input,  $reglas);
        if ($validacion->fails())
        {
          return view("mensajes.msj_rechazado")->with("msj","El archivo no es una imagen valida");
        }
        else
        {

                        $nombre_original=$archivo->getClientOriginalName();
                            $extension=$archivo->getClientOriginalExtension();
                            $nuevo_nombre="FotoVehiculoInteriorAtras-".$request['placa'].".".$extension;
                            $r1=Storage::disk('Imagen_Vehiculo')->put($nuevo_nombre,  \File::get($archivo) );
                            $rutadelaimagen="../storage/Imagen_Vehiculo/".$nuevo_nombre;

                        DB::table('vehiculo')->where('placa',$request['placa'])->update(['direccion_imagen_interior_atras'=>$rutadelaimagen]);
                    
                                return $rutadelaimagen;
                            
          
        }
    }
    //CODIGO PARA AJAX. SUBIR IMAGENES DE RUA
    public function subir_imagen_rua(Request $request)
    {
        $archivo = $request->file('perfil_imagen_rua');
        $input  = array('image' => $archivo) ;
        $reglas = array('image' => 'required|image|mimes:jpeg,jpg,bmp,png,gif|max:15000');
        $validacion = Validator::make($input,  $reglas);
        if ($validacion->fails())
        {
          return view("mensajes.msj_rechazado")->with("msj","El archivo no es una imagen valida");
        }
        else
        {
            $fotos_rua=DB::select("SELECT max(fo.id) as 'cantidad',fo.id_fotocopia from foto fo,fotocopia f, vehiculo v WHERE fo.id_fotocopia=f.id and f.id=v.id_fotocopia_rua and v.placa='".$request['placa']."'");
            $cantidad=0;
            $id_fotocopia=0;
            foreach ($fotos_rua as $key => $value) {
              $cantidad=$value->cantidad;
              $id_fotocopia=$value->id_fotocopia;
            }

            $cantidad+=1;

                        $nombre_original=$archivo->getClientOriginalName();
                            $extension=$archivo->getClientOriginalExtension();
                            $nuevo_nombre="Imagen_RUA-".$request['placa']."-".$cantidad.".".$extension;
                            $r1=Storage::disk('Imagen_Vehiculo')->put($nuevo_nombre,  \File::get($archivo) );
                            $rutadelaimagen="/Imagen_Vehiculo/".$nuevo_nombre;


            if($cantidad==1){
                    $id_fotocopia=DB::table('fotocopia')->insertGetId([ 'nombre' => 'RUA', 'numero' => $request['placa']]); 
                    }
                    DB::table('foto')->insert(['id_fotocopia' => $id_fotocopia,'id'=>$cantidad, 'direccion' => $rutadelaimagen]);

                    DB::table('vehiculo')->where('placa',$request['placa'])->update(['id_fotocopia_rua'=>$id_fotocopia]); //ACTUALIZO LOS FOREIGN KEY DEL VEHICULO

                    
                                return "../../../storage".$rutadelaimagen;
                            
          
        }
    }

//CODIGO DE AJAX PARA SUBIR IMAGENES DEL TITULAR DE REGISTRO EN RUA
    public function subir_imagen_ci_rua(Request $request)
    {
        $archivo = $request->file('perfil_imagen_ci_rua');
        $input  = array('image' => $archivo) ;
        $reglas = array('image' => 'required|image|mimes:jpeg,jpg,bmp,png,gif|max:15000');
        $validacion = Validator::make($input,  $reglas);
        if ($validacion->fails())
        {
          return view("mensajes.msj_rechazado")->with("msj","El archivo no es una imagen valida");
        }
        else
        {
            $fotos_rua=DB::select("SELECT max(fo.id) as 'cantidad',fo.id_fotocopia from foto fo,fotocopia f, vehiculo v WHERE fo.id_fotocopia=f.id and f.id=v.id_fotocopia_ci_titular_del_rua and v.placa='".$request['placa']."'");
            $cantidad=0;
            $id_fotocopia=0;
            foreach ($fotos_rua as $key => $value) {
              $cantidad=$value->cantidad;
              $id_fotocopia=$value->id_fotocopia;
            }

            $cantidad+=1;

                        $nombre_original=$archivo->getClientOriginalName();
                            $extension=$archivo->getClientOriginalExtension();
                            $nuevo_nombre="Imagen_CI-RUA-".$request['placa']."-".$cantidad.".".$extension;
                            $r1=Storage::disk('Imagen_Vehiculo')->put($nuevo_nombre,  \File::get($archivo) );
                            $rutadelaimagen="/Imagen_Vehiculo/".$nuevo_nombre;


            if($cantidad==1){
                    $id_fotocopia=DB::table('fotocopia')->insertGetId([ 'nombre' => 'CI TITULAR DEL RUA', 'numero' => $request['placa']]); 
                    }
                    DB::table('foto')->insert(['id_fotocopia' => $id_fotocopia,'id'=>$cantidad, 'direccion' => $rutadelaimagen]);

                    DB::table('vehiculo')->where('placa',$request['placa'])->update(['id_fotocopia_ci_titular_del_rua'=>$id_fotocopia]); //ACTUALIZO LOS FOREIGN KEY DEL VEHICULO

                    
                                return "../../../storage".$rutadelaimagen;
                            
          
        }
    }
    //CODIGO AJAX PARA SUBIR LAS FOTOS DEL DOCUMENTO DE PROPIEDAD
    public function subir_imagen_propiedad(Request $request)
    {
        $archivo = $request->file('perfil_imagen_propiedad');
        $input  = array('image' => $archivo) ;
        $reglas = array('image' => 'required|image|mimes:jpeg,jpg,bmp,png,gif|max:15000');
        $validacion = Validator::make($input,  $reglas);
        if ($validacion->fails())
        {
          return view("mensajes.msj_rechazado")->with("msj","El archivo no es una imagen valida");
        }
        else
        {
            $fotos_rua=DB::select("SELECT max(fo.id) as 'cantidad',fo.id_fotocopia from foto fo,fotocopia f, vehiculo v WHERE fo.id_fotocopia=f.id and f.id=v.id_fotocopia_documento_de_propiedad and v.placa='".$request['placa']."'");
            $cantidad=0;
            $id_fotocopia=0;
            foreach ($fotos_rua as $key => $value) {
              $cantidad=$value->cantidad;
              $id_fotocopia=$value->id_fotocopia;
            }

            $cantidad+=1;

                        $nombre_original=$archivo->getClientOriginalName();
                            $extension=$archivo->getClientOriginalExtension();
                            $nuevo_nombre="Imagen_DOCUMENTO-PROPIEDAD-".$request['placa']."-".$cantidad.".".$extension;
                            $r1=Storage::disk('Imagen_Vehiculo')->put($nuevo_nombre,  \File::get($archivo) );
                            $rutadelaimagen="/Imagen_Vehiculo/".$nuevo_nombre;


            if($cantidad==1){
                    $id_fotocopia=DB::table('fotocopia')->insertGetId([ 'nombre' => 'DOCUMENTO DE PROPIEDAD', 'numero' => $request['placa']]); 
                    }
                    DB::table('foto')->insert(['id_fotocopia' => $id_fotocopia,'id'=>$cantidad, 'direccion' => $rutadelaimagen]);

                    DB::table('vehiculo')->where('placa',$request['placa'])->update(['id_fotocopia_documento_de_propiedad'=>$id_fotocopia]); //ACTUALIZO LOS FOREIGN KEY DEL VEHICULO

                    
                                return "../../../storage".$rutadelaimagen;
        }
    }

    //CODIGO DE AJAX PARA SUBBIR LA IMAGEN DE SOAT
    public function subir_imagen_soat(Request $request)
    {
        $archivo = $request->file('perfil_imagen_soat');
        $input  = array('image' => $archivo) ;
        $reglas = array('image' => 'required|image|mimes:jpeg,jpg,bmp,png,gif|max:15000');
        $validacion = Validator::make($input,  $reglas);
        if ($validacion->fails())
        {
          return view("mensajes.msj_rechazado")->with("msj","El archivo no es una imagen valida");
        }
        else
        {
            $fotos_rua=DB::select("SELECT max(fo.id) as 'cantidad',fo.id_fotocopia from foto fo,fotocopia f, vehiculo v WHERE fo.id_fotocopia=f.id and f.id=v.id_fotocopia_soat and v.placa='".$request['placa']."'");
            $cantidad=0;
            $id_fotocopia=0;
            foreach ($fotos_rua as $key => $value) {
              $cantidad=$value->cantidad;
              $id_fotocopia=$value->id_fotocopia;
            }

            $cantidad+=1;

                        $nombre_original=$archivo->getClientOriginalName();
                            $extension=$archivo->getClientOriginalExtension();
                            $nuevo_nombre="Imagen_SOAT-".$request['placa']."-".$cantidad.".".$extension;
                            $r1=Storage::disk('Imagen_Vehiculo')->put($nuevo_nombre,  \File::get($archivo) );
                            $rutadelaimagen="/Imagen_Vehiculo/".$nuevo_nombre;


            if($cantidad==1){
                    $id_fotocopia=DB::table('fotocopia')->insertGetId([ 'nombre' => 'SOAT', 'numero' => $request['placa']]); 
                    }
                    DB::table('foto')->insert(['id_fotocopia' => $id_fotocopia,'id'=>$cantidad, 'direccion' => $rutadelaimagen]);

                    DB::table('vehiculo')->where('placa',$request['placa'])->update(['id_fotocopia_soat'=>$id_fotocopia]); //ACTUALIZO LOS FOREIGN KEY DEL VEHICULO

                    
                                return "../../../storage".$rutadelaimagen;
        }
    }
    //CODIGO DE AJAX PARA SUBIR LAS INSPECCIONES TECNICAS
    public function subir_imagen_inspeccion(Request $request)
    {
        $archivo = $request->file('perfil_imagen_inspeccion');
        $input  = array('image' => $archivo) ;
        $reglas = array('image' => 'required|image|mimes:jpeg,jpg,bmp,png,gif|max:15000');
        $validacion = Validator::make($input,  $reglas);
        if ($validacion->fails())
        {
          return view("mensajes.msj_rechazado")->with("msj","El archivo no es una imagen valida");
        }
        else
        {
            $fotos_rua=DB::select("SELECT max(fo.id) as 'cantidad',fo.id_fotocopia from foto fo,fotocopia f, vehiculo v WHERE fo.id_fotocopia=f.id and f.id=v.id_foto_inspeccion_tecnica and v.placa='".$request['placa']."'");
            $cantidad=0;
            $id_fotocopia=0;
            foreach ($fotos_rua as $key => $value) {
              $cantidad=$value->cantidad;
              $id_fotocopia=$value->id_fotocopia;
            }

            $cantidad+=1;

                        $nombre_original=$archivo->getClientOriginalName();
                            $extension=$archivo->getClientOriginalExtension();
                            $nuevo_nombre="Imagen_INSPECCION-TECNICA-".$request['placa']."-".$cantidad.".".$extension;
                            $r1=Storage::disk('Imagen_Vehiculo')->put($nuevo_nombre,  \File::get($archivo) );
                            $rutadelaimagen="/Imagen_Vehiculo/".$nuevo_nombre;


            if($cantidad==1){
                    $id_fotocopia=DB::table('fotocopia')->insertGetId([ 'nombre' => 'INSPECCION TECNICA', 'numero' => $request['placa']]); 
                    }
                    DB::table('foto')->insert(['id_fotocopia' => $id_fotocopia,'id'=>$cantidad, 'direccion' => $rutadelaimagen]);

                    DB::table('vehiculo')->where('placa',$request['placa'])->update(['id_foto_inspeccion_tecnica'=>$id_fotocopia]); //ACTUALIZO LOS FOREIGN KEY DEL VEHICULO

                    
                                return "../../../storage".$rutadelaimagen;
        }
    }
                            
                
  function kardex_pdf($placa){

      $empresa=DB::select("SELECT * from empresa where id='".Auth::user()->id_empresa."'");
      $vehiculo=DB::select("SELECT * from vehiculo where placa='".$placa."'");
      $propietario=DB::select("SELECT d.* from duenio d,vehiculo v where v.id_propietario=d.ci and v.placa='".$placa."'");

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
       $asignacion=DB::select("SELECT v.* from vehiculo v, conductor c where c.id_vehiculo=v.placa and c.id_vehiculo='".$placa."' ");
      $cant_a=0;
      foreach ($asignacion as $key => $value) {
        $cant_a++;
      }

      $pdf=\PDF::loadView('vehiculo.kardex_pdf', ['vehiculo'=>$vehiculo,'empresa'=>$empresa,'contenido'=>$id_imagen,'asignacion'=>$asignacion,'propietario'=>$propietario,'cantidad_asignacion'=>$cant_a]);
    return   $pdf->stream();
   // return view('vehiculo.kardex_pdf', ['vehiculo'=>$vehiculo,'empresa'=>$empresa,'contenido'=>$id_imagen,'asignacion'=>$asignacion,'propietario'=>$propietario,'cantidad_asignacion'=>$cant_a]);
    }   

     public function historial_radio_vehiculo($placa){
    $historial=DB::select("SELECT h.*,u.nombre as 'usuario' FROM historial_radio h, users u where  u.id=h.id_login and h.id_vehiculo='".$placa."'");
  
    return View('vehiculo.historial_radio',['historial'=>$historial ]);
   }   






}
