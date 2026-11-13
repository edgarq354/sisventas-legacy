<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Admins;
use App\Empresa;
use App\Http\Requests;
use App\Http\Requests\AdminsRequest;
use App\Http\Requests\AdminsUserRequest;
use App\Http\Requests\users_empresa_Request2;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;



class AdminsController extends Controller
{

    public function __construct()
    {
         $this->middleware('auth');
    }

    function opcion_salir()
    {
        return view('admins.opcion_salir');
    }
    function index_empresa()
    {
        //SOLO INGRESA LOS ADMINISTRADORES DE CADA EMPRESA
        /* $usuarios = DB::select("SELECT * from users where id_empresa='".Auth::user()->id_empresa."' ");
         $buscar_usuario=DB::select("SELECT users.id,users.usuario FROM users WHERE users.id_empresa='".Auth::user()->id_empresa."'");
         */
        $usuarios = DB::select("SELECT * from users where id_empresa='" . Auth::user()->id_empresa . "' ");
        $buscar_usuario = DB::select("SELECT users.id,users.usuario,users.nombre FROM users WHERE users.id_empresa='" . Auth::user()->id_empresa . "'");
        return view('admins.usuarios_empresa.index', [
            'usuarios' => $usuarios], ['buscar_usuario'=> $buscar_usuario]);
    }

    function usuario_imprimir()
    {
        //SOLO INGRESA LOS ADMINISTRADORES DE CADA EMPRESA
        /* $usuarios = DB::select("SELECT * from users where id_empresa='".Auth::user()->id_empresa."' ");
         $buscar_usuario=DB::select("SELECT users.id,users.usuario FROM users WHERE users.id_empresa='".Auth::user()->id_empresa."'");
         */
        $usuarios = DB::select("SELECT * from users where id_empresa='" . Auth::user()->id_empresa . "' ");
        $buscar_usuario = DB::select("SELECT users.id,users.usuario,users.nombre FROM users WHERE users.id_empresa='" . Auth::user()->id_empresa . "'");
        $empresa = DB::select("SELECT * from empresa  where id='" . Auth::user()->id_empresa . "'");

        $pdf = \PDF::loadView(
            'admins.usuarios_empresa.usuario_imprimir',
            [
                'usuarios' => $usuarios,
                'buscar_usuario', $buscar_usuario,
                'empresa' => $empresa
            ]
        );
        return $pdf->stream();
    }

    public function create_usuario()
    {
        $acceso = DB::select("SELECT * from acceso where estado=1 ");
        $cliente = DB::select("SELECT * from cliente where tipo_e=1 and id_empresa='" . Auth::user()->id_empresa . "' ");
        $sucursal = DB::select("SELECT * from sucursal where id_empresa='" . Auth::user()->id_empresa . "' ");
        return view('admins.usuarios_empresa.create', [
            'acceso' => $acceso,
            'cliente' => $cliente,
            'sucursal' => $sucursal]);
    }

    public function store(users_empresa_Request2 $request)
    {

        $cont_admins = 0;
        $consulta = DB::select("SELECT nombre from users where usuario like '" . $request['usuario'] . "'");
        //$empleado = DB::select("SELECT nombre, paterno,materno from empleado where id_empresa='".Auth::user()->id_empresa."' and ci='".$request['id_empleado']."'");
        foreach ($consulta as $key => $value) {
            $cont_admins++;
        }

        if ($cont_admins == 0) {

            if ($request['privilegio'] == 0) {
                DB::table('users')->insert([
                    'nombre' => $request['nombre'],
                    'usuario' => $request['usuario'],
                    'id_sucursal' => $request['id_sucursal'],
                    'password' => Hash::make($request['password']),
                    'privilegio' => 0,
                    'id_empresa' => Auth::user()->id_empresa/*,'id_empleado'=>$request['id_empleado']*/
                ]);
                Session::flash('message', 'ADMINISTRADOR DE EMPRESA SE HA CREADO CORRECTAMENTE');
                return Redirect::to('/usuarios/empresa');
            } else if ($request['privilegio'] == 3) {


                try {
                    $cantidad = 0;
                    $acceso = DB::select("SELECT * from acceso where estado=1 ");

                    foreach ($acceso as $key => $value) {
                        if (isset($request[$value->id . '-']) || isset($request[$value->id . '+'])) {
                            $cantidad += 1;
                        }
                    }
                } catch (Exception $e) {
                    return redirect('usuarios/crear_usuario')->with("message-error", "ERROR INTENTE NUEVAMENTE");
                }

                if ($cantidad > 0) {


                    try {
                        DB::beginTransaction();

                        $id_login = DB::table('users')->insertGetId([
                            'nombre' => $request['nombre'],
                            'usuario' => $request['usuario'],
                            'id_sucursal' => $request['id_sucursal'],
                            'password' => Hash::make($request['password']),
                            'privilegio' => 3,
                            'id_empleado' => $request['id_empleado'],
                            'id_empresa' => Auth::user()->id_empresa
                        ]);

                        foreach ($acceso as $key => $value) {
                            if (isset($request[$value->id . '-']) || isset($request[$value->id . '+'])) {
                                $lectura = "0";
                                $escritura = "0";
                                if (isset($request[$value->id . '-'])) {
                                    $lectura = 1;
                                }
                                if (isset($request[$value->id . '+'])) {
                                    $escritura = 2;
                                }
                                $suma = $lectura + $escritura;

                                DB::table('permiso')->insert([
                                    'id_login' => $id_login,
                                    'id_acceso' => $value->id,
                                    'numero' => $suma,
                                    'lectura' => $lectura,
                                    'escritura' => $escritura,
                                    'id_empresa' => Auth::user()->id_empresa
                                ]);
                            }
                        }

                        $permisos = DB::select("SELECT sum(a.peso)as 'suma' from acceso a,permiso p where a.id=p.id_acceso and p.id_login='" . $id_login . "'");
                        foreach ($permisos as $key => $value) {
                            DB::table('users')->where('id', $id_login)->update(['permiso' => $value->suma]);
                        }




                        DB::commit();
                        Session::flash('message', 'CREADO CORRECTAMENTE');
                        return Redirect::to('/usuarios/empresa');
                    } catch (Exception $e) {
                        DB::rollback();
                        return redirect('usuarios/crear_usuario')->with("message-error", "ERROR INTENTE NUEVAMENTE");
                    }
                } else {
                    return redirect('usuarios/crear_usuario')->with("message-error", "PORFAVOR REGISTRE PERMISOS");
                }
            } else {
                return redirect('usuarios/crear_usuario')->with("message-error", "ERROR INTENTE NUEVAMENTE");
            }
        } else {
            return redirect('usuarios/crear_usuario')->with("message-error", "LA CUENTA '" . $request['usuario'] . "' YA EXISTE.");
        }
    }



    public function store_2(AdminsUserRequest $request)
    {
        DB::table('users')->insert([
            'usuario' => $request['usuario'],
            'password' => Hash::make($request['password']),
            'privilegio' => $request['privilegio'],
            'id_empresa' => $request['id_empresa'],
            'id_empleado' => '0'
        ]);
        Session::flash('message', 'USUARIO CREADO CORRECTAMENTE');
        return Redirect::to('/usuarios');
    }

    public function edit_usuario_empresa($id)
    {
        $usuario = DB::select("SELECT *FROM users where users.id=" . $id);
        $permiso = DB::select("SELECT * from permiso where id_login=" . $id);
        $acceso = DB::select("SELECT *FROM acceso where estado=1");
        $sucursal = DB::select("SELECT *FROM sucursal where id_empresa=".Auth::user()->id_empresa);
        $empleado = DB::select("SELECT id,nombre,paterno,materno from cliente
            where id_empresa=".Auth::user()->id_empresa."
            and (tipo_e=1 or id = (select id_empleado from users where id=".(int)$id."))
            order by nombre asc");
        return view('admins.usuarios_empresa.edit', [
            'usuario' => $usuario,
            'acceso' => $acceso,
            'permiso' => $permiso,
            'sucursal' => $sucursal,
            'empleado' => $empleado
        ]);
    }

    function usuario_update_empresa(Request $request)
    {
        if ($request['usuario'] == $request['usuario_aux']) {
            $datos = [
                'nombre' => $request['nombre'],
                'usuario' => $request['usuario'],
                'privilegio' => $request['privilegio'],
                'id_sucursal' => $request['id_sucursal'],
                'id_empresa' => Auth::user()->id_empresa
            ];
            // El empleado es opcional: solo se actualiza si se seleccionó uno
            if ($request->filled('id_empleado')) {
                $datos['id_empleado'] = $request['id_empleado'];
            }
            DB::table('users')->where('id', $request['id_usuario'])->update($datos);

            //ACTUALIZAR PERMISOS DE ACCESOS A LOS MODULOS
            try {
                DB::beginTransaction();
                $cantidad = 0;
                $acceso = DB::select("SELECT * from acceso where estado=1 ");

                DB::table('permiso')->where('id_login', $request['id_usuario'])->delete();

                foreach ($acceso as $key => $value) {
                    if (isset($request[$value->id . '-']) || isset($request[$value->id . '+'])) {
                        $cantidad += 1;
                    }
                }


                if ($cantidad > 0 && $request['privilegio'] > 0) {
                    $id_login = $request['id_usuario'];

                    foreach ($acceso as $key => $value) {
                        if (isset($request[$value->id . '-']) || isset($request[$value->id . '+'])) {
                            $lectura = "0";
                            $escritura = "0";
                            if (isset($request[$value->id . '-'])) {
                                $lectura = 1;
                            }
                            if (isset($request[$value->id . '+'])) {
                                $escritura = 2;
                            }
                            $suma = $lectura + $escritura;

                            DB::table('permiso')->insert(['id_login' => $request['id_usuario'], 
                            'id_acceso' => $value->id, 
                            'numero' => $suma, 
                            'lectura' => $lectura, 
                            'escritura' => $escritura,
                            'id_empresa' => Auth::user()->id_empresa]);
                        }
                    }
                    //suma el peso de los accesos de cada modulo
                    $permisos = DB::select("SELECT sum(a.peso)as 'suma' from acceso a,permiso p where a.id=p.id_acceso and p.id_login='" . $id_login . "'");
                    foreach ($permisos as $key => $value) {
                        DB::table('users')->where('id', $id_login)->update(['permiso' => $value->suma]);
                    }
                    //fin de la suma de acceso.

                    DB::commit();
                    Session::flash('message', 'ACTUALIZADO CORRECTAMENTE');

                } else if ($request['privilegio'] == 0) {
                    Session::flash('message', 'ACTUALIZADO CORRECTAMENTE');
                }else {
                    DB::rollback();
                    Session::flash('message', "PORFAVOR REGISTRE PERMISOS");
                }
                return Redirect::to('/usuarios/empresa');
            } catch (Exception $e) {
                DB::rollback();
                return redirect('usuarios/empresa')->with("message-error", "ERROR INTENTE NUEVAMENTE");
            }
        } else {

            $verificar = DB::select('SELECT count(*)as contador FROM users where users.usuario="' . $request['usuario'] . '"');
            if ($verificar[0]->contador == 0) {
                DB::table('users')->where('id', $request['id_usuario'])->update(['usuario' => $request['usuario'], 'privilegio' => $request['privilegio'], 'id_empresa' => Auth::user()->id_empresa]);



                //ACTUALIZAR PERMISOS DE ACCESOS A LOS MODULOS
                try {
                    DB::beginTransaction();
                    $cantidad = 0;
                    $acceso = DB::select("SELECT * from acceso where estado=1 ");

                    DB::table('permiso')->where('id_login', $request['id_usuario'])->delete();

                    foreach ($acceso as $key => $value) {
                        if (isset($request[$value->id . '-']) || isset($request[$value->id . '+'])) {
                            $cantidad += 1;
                        }
                    }

                    if ($cantidad > 0) {
                        $id_login = $request['id_usuario'];

                        foreach ($acceso as $key => $value) {
                            if (isset($request[$value->id . '-']) || isset($request[$value->id . '+'])) {
                                $lectura = "0";
                                $escritura = "0";
                                if (isset($request[$value->id . '-'])) {
                                    $lectura = 1;
                                }
                                if (isset($request[$value->id . '+'])) {
                                    $escritura = 2;
                                }
                                $suma = $lectura + $escritura;

                                DB::table('permiso')->insert(['id_login' => $request['id_usuario'], 'id_acceso' => $value->id, 'numero' => $suma, 'lectura' => $lectura, 'escritura' => $escritura]);
                            }
                        }

                        DB::commit();
                        Session::flash('message', 'ACTUALIZADO CORRECTAMENTE');
                        return Redirect::to('/usuarios/empresa');
                    } else {
                        DB::rollback();
                        return redirect('/usuarios/empresa')->with("message-error", "PORFAVOR REGISTRE PERMISOS");
                    }
                } catch (Exception $e) {
                    DB::rollback();
                    return redirect('usuarios/empresa')->with("message-error", "ERROR INTENTE NUEVAMENTE");
                }
                //FIN DEL REGISTRO DE PERMISOS DE ACCESO.




            } else {
                Session::flash('message-error', 'YA EXISTE EL USUARIO "' . $request['usuario'] . '", VERIFIQUE POR FAVOR.');
                return Redirect::to('/usuarios/actualizar_usuarios_empresa/' . $request['id_usuario']);
            }
        }
    }

    function actualizar_administrativo(Request $request)
    {
        if ($request['usuario'] == $request['usuario_aux']) {
            DB::table('users')->where('id', $request['id_user'])->update(['usuario' => $request['usuario'], 'nombre' => $request['nombre']]);
            Session::flash('message', 'ACTUALIZADO CORRECTAMENTE.');
            return Redirect::to('/administrativos');
        } else {
            $verificar = DB::select('SELECT count(*)as contador FROM users where users.usuario="' . $request['usuario'] . '"');
            if ($verificar[0]->contador == 0) {
                DB::table('users')->where('id', $request['id_user'])->update(['usuario' => $request['usuario'], 'nombre' => $request['nombre']]);
                Session::flash('message', 'ACTUALIZADO CORRECTAMENTE.');
                return Redirect::to('/administrativos');
            } else {
                Session::flash('message-error', 'YA EXISTE EL USUARIO "' . $request['usuario'] . '", VERIFIQUE POR FAVOR.');
                return Redirect::to('/administrativos');
            }
        }
    }

    function actualizar_administrador(Request $request)
    {
        if ($request['usuario'] == $request['usuario_aux']) {
            DB::table('users')->where('id', $request['id_user'])->update(['usuario' => $request['usuario'], 'nombre' => $request['nombre']]);
            Session::flash('message', 'ACTUALIZADO CORRECTAMENTE.');
            return Redirect::to('/administrador');
        } else {
            $verificar = DB::select('SELECT count(*)as contador FROM users where users.usuario="' . $request['usuario'] . '"');
            if ($verificar[0]->contador == 0) {
                DB::table('users')->where('id', $request['id_user'])->update(['usuario' => $request['usuario'], 'nombre' => $request['nombre']]);
                Session::flash('message', 'ACTUALIZADO CORRECTAMENTE.');
                return Redirect::to('/administrador');
            } else {
                Session::flash('message-error', 'YA EXISTE EL USUARIO "' . $request['usuario'] . '", VERIFIQUE POR FAVOR.');
                return Redirect::to('/administrador');
            }
        }
    }

    function cargar_admins_usuarios($id)
    {
        $admin = DB::select("SELECT users.id,users.nombre,users.usuario,users.privilegio,users.id_empresa,empresa.razon_social FROM users,empresa WHERE users.id_empresa=empresa.id AND users.id=" . $id);
        return response($admin);
    }

    function cargar_admins($id)
    {
        $admin = DB::select("SELECT users.id,users.nombre,users.usuario,users.privilegio,users.id_empresa,empresa.razon_social FROM users,empresa WHERE users.id_empresa=empresa.id AND users.id=" . $id);
        return response($admin);
    }

    function cargar_historial_inicio_sesion($id_usuario)
    {
        $admin = DB::select("SELECT * from bitacora where id_usuario='" . $id_usuario . "' ORDER BY fecha desc limit 30");
        return response($admin);
    }
}
