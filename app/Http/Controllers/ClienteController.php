<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ClienteRequest;
use App\Http\Requests;
use Exception;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class ClienteController extends Controller
{
      public function __construct() {
         $this->middleware('auth');
    }

    function index() {

            $cliente = DB::table('cliente')->select('*')->where('id_empresa',Auth::user()->id_empresa)->get();
            return view('cliente.index',['cliente'=> $cliente]);

    }
    function edit($id) {

            $cliente=DB::select("SELECT * FROM cliente WHERE id_empresa='".Auth::user()->id_empresa."' and id='".$id."'");
            return view('cliente.edit', ['cliente'=> $cliente]);
    }
    public function create() {
        return view('cliente.create');
    }

    public function store(ClienteRequest $request){

        try {
      DB::beginTransaction();
        $tipo_c=0;
        $tipo_p=0;
        $tipo_e=0;
        if($request['tipo_c'])
        {
            $tipo_c=1;
        }
        if($request['tipo_p']){
            $tipo_p=1;
        }
        if($request['tipo_e']){
            $tipo_e=1;
        }
            $id_cliente=DB::table('cliente')->insertGetId([
                'nombre' => $request['nombre'],
                'paterno' => $request['paterno'],
                'materno' => $request['materno'],
                'telefono' =>$request['telefono'],
                'ci_nit'=>$request['ci_nit'],
                'correo'=>$request['correo'],
                'direccion'=>$request['direccion'],
                'descripcion'=>$request['descripcion'],
                'latitud'=>$request['latitud'],
                'longitud'=>$request['longitud'],
                'tipo_c'=>$tipo_c,
                'tipo_p'=>$tipo_p,
                'tipo_e'=>$tipo_e,
                'sueldo'=>$request['sueldo'],
                'cargo'=>$request['cargo'],
                'id_empresa'=>Auth::user()->id_empresa]);

        if($request['tipo_e'])
        {
           DB::table('cliente')
           ->where('id', $id_cliente)
           ->update([
            'fecha_ingreso'=>$request['fecha_ingreso']
             ]);
        }

              DB::commit();
            Session::flash('message', __('cliente.registrado_correctamente'));
            return Redirect::to('/cliente');

      }catch (Exception $e) {
          DB::rollback();
          self::registrar_bitacora('Registrar Cliente',$e);
          return redirect('/cliente/create')->with("message-error", __('cliente.error_intente_nuevamente'));
      }
    }
    public function show()
    { if (Auth::user()->privilegio == 1 || Auth::user()->privilegio == 2 || Auth::user()->privilegio == 0) {
            $cliente = DB::select("SELECT * FROM cliente where id_empresa=".Auth::user()->id_empresa." order by nombre asc ");
            $buscar_cliente=DB::select("SELECT * FROM cliente where id_empresa=".Auth::user()->id_empresa." order by nombre asc ");
            return view('cliente.index', compact('cliente', $cliente,'buscar_cliente',$buscar_cliente));
        } else {
            return view('errors.404');
        }
    }

    public function update(Request $request){
       $tipo_c=0;
        $tipo_p=0;
        $tipo_e=0;
        if($request['tipo_c'])
        {
            $tipo_c=1;
        }
        if($request['tipo_p']){
            $tipo_p=1;
        }
        if($request['tipo_e']){
            $tipo_e=1;
        }

        DB::table('cliente')->where('id', $request['id'])->update([
             'ci_nit' => $request['ci_nit'],
            'expedido' => $request['expedido'],
            'nombre' => $request['nombre'],
            'paterno' => $request['paterno'],
            'materno' => $request['materno'],
            'telefono' => $request['telefono'],
            'correo'=>$request['correo'],
            'direccion'=>$request['direccion'],
            'descripcion'=>$request['descripcion'],
            'latitud'=>$request['latitud'],
            'longitud'=>$request['longitud'],
            'tipo_c'=>$tipo_c,
            'tipo_p'=>$tipo_p,
            'tipo_e'=>$tipo_e,
            'sueldo'=>$request['sueldo'],
            'cargo'=>$request['cargo']
            ]);

        if($request['tipo_e'])
        {
           DB::table('cliente')
           ->where('id', $request['id'])
           ->update([
            'fecha_ingreso'=>$request['fecha_ingreso']
             ]);
        }

        Session::flash('message', __('cliente.actualizado_correctamente'));
            return Redirect::to('/cliente');
    }

    //CARGAR PARA VERIFICAR SI EXISTE EL CI DEL CUNDUCTOR
    function verificar_id_cliente($id){
        $cliente=DB::select("SELECT count(*)as contador,c.* FROM cliente c where c.id=".$id. " and c.id_empresa=".Auth::user()->id_empresa);
        return response($cliente);
    }

      public function personal_baja(Request $request){
                try{
                DB::table('cliente')->where('id', $request['id_personal'])->update(['estado' => '6','fecha_retiro'=>date('Y-m-j H-m-00')]);
                DB::table('historial_baja_alta')->insert(['descripcion' =>$request['descripcion'],'id_personal'=>$request['id_personal'],'id_login'=>Auth::user()->id, 'fecha' => $request['fecha'],'tipo'=>'0']);
                Session::flash('message', __('cliente.se_dio_de_baja'));
                }
                catch(Exception $e)
                {
                   Session::flash('message-error', __('cliente.no_se_pudo_dar_baja'));
                }
                return Redirect::to('/cliente');
   }

     public function personal_alta(Request $request){
            try{
                DB::table('cliente')->where('id', $request['id_personal'])->update(['estado' => '1','fecha_retiro'=>date('Y-m-j H-m-00')]);
               DB::table('historial_baja_alta')->insert(['descripcion' =>$request['descripcion'],'id_personal'=>$request['id_personal'],'id_login'=>Auth::user()->id, 'fecha' => $request['fecha'],'tipo'=>'1']);
                Session::flash('message', __('cliente.se_dio_de_alta'));
                }
                catch(Exception $e)
                {
                   Session::flash('message-error', __('cliente.no_se_pudo_dar_alta'));
                }

             return Redirect::to('/cliente');
       }

    public function historial_baja_alta($id_personal){
    $historial=DB::select("SELECT h.*,u.nombre as 'usuario' FROM historial_baja_alta h, users u where  u.id=h.id_login and h.id_personal='".$id_personal."' and h.id_empresa=".Auth::user()->id_empresa);
    return View('cliente.historial_baja_alta',['historial'=>$historial]);
   }

   function cliente_imprimir() {

            $cliente = DB::table('cliente')->select('*')->where('id_empresa',Auth::user()->id_empresa)->get();
            $empresa=DB::select("SELECT * from empresa  where id='".Auth::user()->id_empresa."'");

     $pdf=\PDF::loadView('cliente.cliente_imprimir',[
        'cliente'=>$cliente,
        'empresa'=>$empresa
      ]);

      return $pdf->stream();
    }


   //CARGAR PARA PODER ACTUALIZAR EN LA PARTE DEL MODAL
   public function get_cliente_por_id($id)
   {

     $sql="SELECT * from cliente where id=".$id."
     and id_empresa=".Auth::user()->id_empresa;

      $gasto=DB::select($sql);

     return response($gasto);
   }

   //Buscar persona por Nombre
      public function get_clientes_por_nombre($nombre)
   {
        $nombre=strtolower($nombre);
     $sql="SELECT id, ci_nit,nombre,paterno,materno from cliente where  lower(concat(nombre,' ',paterno,' ',materno)) like '%".$nombre."%'
     and id_empresa=".Auth::user()->id_empresa. " order by nombre asc limit 10";

      $gasto=DB::select($sql);

     return response($gasto);
   }


  public function registrar_bitacora($funcion,$mensaje){
    //registrar en BITACORA su inicio de sesion.
          try {
                            DB::beginTransaction();

                                        DB::table('bitacora')->insert([
                                        'nombre'=> $funcion,
                                        'mensaje'=> $funcion,
                                        'detalle'=>$mensaje,
                                        ]);

                                     DB::commit();
                            } catch (Exception $e) {

                            }
            //FIN DE REGISTRO DE BITACORA
    }
}
