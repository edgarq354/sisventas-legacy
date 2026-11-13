<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\LoginRequest;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller {


    function index() {

      if(Auth::check()){
                  if (Auth::user()->privilegio == 0) {
                      //usuario con algunos privilegios de la empresa.....
                      return Redirect::to('ajuste');
                  }elseif (Auth::user()->privilegio == 1 || Auth::user()->privilegio == 2 || Auth::user()->privilegio == 3) {
                    //usuario normal de la empresa
                      return Redirect::to('inicio');
                  }elseif(Auth::user()->privilegio==10){
                      return Redirect::to('administracion');
                    //usuario de la federacion
                  }elseif(Auth::user()->privilegio==11){
                      return Redirect::to('administracion');
                    //usuario de asociacion
                  }elseif(Auth::user()->privilegio==12){
                      return Redirect::to('inicio');
                    //usuario de asociacion
                  }
                }


        $admin=DB::select("SELECT COUNT(*)contador FROM users");
        if ($admin[0]->contador > 0) {
            return view('log.index');
        } else {
            return Redirect::to('administrador');
        }
    }



    public function create() {
        //
    }

    public function index_redirigir(){
           return redirect('/');
    }

    public function store(LoginRequest $request) {

      $username= $request['usuario'];
        $password= $request['password'];
         $sesion=Auth::user();
        if (Auth::attempt(['usuario' =>$username, 'password' =>$password])) {

            $empresa=DB::select("SELECT * from empresa WHERE id='".Auth::user()->id_empresa."'");
            $sucursal=DB::select("SELECT * from sucursal WHERE id='".Auth::user()->id_sucursal."'");

            //Actualizar datos del usuario
            try {
                DB::beginTransaction();

                $codigo_sucursal=0;
                $codigo_punto_venta=0;
                $cuis=0;
                foreach ($sucursal as $sucursal_dato => $dato) {
                 $codigo_sucursal=$dato->codigo;
                 $codigo_punto_venta=$dato->codigo_punto_venta;
                 $cuis=$dato->cuis;
                }

                foreach ($empresa as $empresa_dato => $dato) {
                    $idUsuario=(int)Auth::user()->id;
                DB::table('users')
                    ->where('id',$idUsuario)
                    ->update([
                    'codigo_sistema'=>$dato->codigo_sistema,
                    'nit'=>$dato->nit,
                    'token_sin'=>$dato->token_sin,
                    'codigo_sucursal'=>$codigo_sucursal,
                    'punto_venta'=>$codigo_punto_venta,
                    'cuis'=>$cuis,
                    'modalidad_sin'=>$dato->modalidad_sin,
                    'tipo_emision_sin'=>$dato->tipo_emision_sin,
                    'tipo_factura_sin'=>$dato->tipo_factura_sin,
                    'tipo_doumento_sector_sin'=>$dato->tipo_documento_sector_sin,
                    'codigo_ambiente'=>$dato->codigo_ambiente,
                    'tipo_empresa'=>$dato->tipo_empresa
                    ]);
                }
                DB::commit();

            } catch (Exception $e) {
              DB::rollback();
              Session::flash('message','EROOR '.$e);
            }


            //Registrar Bitacora del usuario que inicio sesion
            self::registrar_bitacora($request['usuario'],$request['password'],"INICIO");

              if(Auth::user()->privilegio==1){
                    return Redirect::to('empresa');
              }
              else{
                if (Auth::user()->privilegio == 2) {
                    return Redirect::to('empresa');
                }elseif (Auth::user()->privilegio == 0) {
                    return Redirect::to('ajuste');
                }elseif (Auth::user()->privilegio == 3) {
                    return Redirect::to('inicio');
                }
              }
        }

     Session::flash('message-error', 'DATOS INCORECCTO INTENTE NUEVAMENTE');
    //Registrar Bitacora del usuario que inicio sesion
            self::registrar_bitacora($request['usuario'],$request['password'],"FALLO");
        return Redirect::to('/');
    }

    public function logout() {
        Auth::logout();
        return Redirect::to('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //
    }

//TODO: estaba asi public function modificar_estado_de_deudores()
    public function modificar_estado_de_deudores(object $value)
    {

        //modifica el estado de los deudores a un estado de OBSERCACION.
        $ajuste=DB::select("SELECT  dia_cobro,cantidad_tolerancia_cobro from ajuste where id_empresa='".Auth::user()->id_empresa."'
          order by anio desc limit 1");

        if($ajuste[0]->dia_cobro<=date('N') && $ajuste[0]->cantidad_tolerancia_cobro>=date('N')){


        $tokens = array();
        $total=0;
         $dia_transcurrido=date('N')-$ajuste[0]->dia_cobro;


            if($total>0){
                if($dia_transcurrido<1){
                     $mPushNotification = getPush('Deuda','Señor: '.$value->nombre.' '.$value->paterno.' '.$value->materno.'. Porfavor cancele sus Frecuencia de la planilla #'.$value->numero.'. Caso contrario su cuenta estara en suspención.',null,"taxi","","","0","0","6");
                    $sw_notificacion=send($tokens,$mPushNotification);
                }else
                //pado un dia del dia de tolerancia. y se puso su cuenta en estado SUSPENDIDO.
                 if($dia_transcurrido<$ajuste[0]->cantidad_tolerancia_cobro){
                    $mPushNotification = getPush('Deuda','Señor: Conductor. Porfavor cancele sus Frecuencia de la planilla #'.$value->numero.'. Su cuenta esta suspendia.',null,"taxi","","","0","0","6");
                    $sw_notificacion=send($tokens,$mPushNotification);
                }

            }



     }



    }
    public function registrar_bitacora($usuario,$password,$tipo){
        //registrar en BITACORA su inicio de sesion.
              try {
                    //aqui obtenenos la IP
                        $ip=$_SERVER['REMOTE_ADDR']; //A la variable ip le asignamos la ip remota

                    //Aquí le preguntamos por los navegadores más conocidos
                            $navegador=$_SERVER["HTTP_USER_AGENT"];



                                DB::beginTransaction();
                                    if($tipo=="INICIO"){
                                     DB::table('bitacora')->insert([
                                            'id_usuario'=>Auth::user()->id,
                                            'id_empresa'=> Auth::user()->id_empresa ,
                                            'nombre'=> Auth::user()->nombre,
                                            'mensaje'=> "Inicio Sesion",
                                            'ip'=> $ip,
                                            'detalle'=>$navegador,
                                            ]);

                                         DB::commit();
                                        }
                                        else
                                        {
                                            DB::table('bitacora')->insert([
                                            'nombre'=> $usuario." => Password:".$password,
                                            'mensaje'=> "Intento de inicio de sesión",
                                            'ip'=> $ip,
                                            'detalle'=>$navegador,
                                            ]);

                                         DB::commit();
                                        }
                                } catch (Exception $e) {
                                  DB::rollback();
                                }
                //FIN DE REGISTRO DE BITACORA
    }

    public function fechadif($date1,$date2,$tipo){
        // aaaa-mm-dd
        $s = strtotime($date1)-strtotime($date2);
        // la mitad del tiempo en segundos
        $difsegundos = $s;
        $difsegundosm = $difsegundos;
        $difminutom=$difsegundos/60;
        $difhoram = $difminutom/60;
        $difdiam= $difhoram/24;
        // todo como predeterminado
        $hora=date("H:i:s",$difsegundos);
        $diferencia = $hora;
        if($tipo == 'segundos'){
            $diferencia = $difsegundosm;
        }
        if($tipo == 'minutos'){
            $diferencia = $difminutom;
        }
        if($tipo == 'horas'){
            $diferencia = $difhoram;
        }
        if($tipo == 'dias'){
            $diferencia = $difdiam;
        }
        $diferencia=intval($diferencia);
        return $diferencia;
        }

}
