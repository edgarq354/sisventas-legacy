<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use App\Usuario;
use Illuminate\Support\Facades\DB;

use App\Http\Requests\SucursalRequest;


class SucursalController extends Controller
{

  public function __construct()
  {
    $this->middleware('auth');
  }

  function index()
  {

    $sucursal = DB::select("SELECT *
            from sucursal 
            where id_empresa=" . Auth::user()->id_empresa);

    return view('sucursal.index', [
      'sucursal' => $sucursal
    ]);
  }

  function sucursal_imprimir()
  {
    $sucursal = DB::select("SELECT * from sucursal
            where  id_empresa=" . Auth::user()->id_empresa);

    $empresa = DB::select("SELECT * from empresa  where id='" . Auth::user()->id_empresa . "'");

    $pdf = \PDF::loadView('sucursal.sucursal_imprimir', [
      'sucursal' => $sucursal,
      'empresa' => $empresa
    ]);
    return   $pdf->stream();
  }

  function create()
  {

    return view('sucursal.create');
  }

  public function store(SucursalRequest $request)
  {
    DB::beginTransaction();

    try {

      $id_sucursal = DB::table('sucursal')->insertGetId(
        [
          'codigo' => $request['codigo'],
          'nombre' => $request['nombre'],
          'municipio' => $request['municipio'],
          'direccion' => $request['direccion'],
          'telefono' => $request['telefono'],
          'cuis' => $request['cuis'],
          'codigo_punto_venta' => $request['codigo_punto_venta'],
          'id_empresa' => Auth::user()->id_empresa
        ]
      );

      DB::commit();
      return redirect('/sucursal')->with("message", "SE REGISTRO CORRECTAMENTE");
    } catch (Exception $e) {
      DB::rollback();
      return redirect('/sucursal')->with("message-error", "ERROR INTENTE NUEVAMENTE");
    }
  }

  //actualizar producto

  public function actualizar_sucursal(SucursalRequest $request)
  {
    DB::beginTransaction();

    try {

      $pedido = DB::table('sucursal')
        ->where('id', $request['id_sucursal'])
        ->update([
          'codigo' => $request['codigo'],
          'nombre' => $request['nombre'],
          'municipio' => $request['municipio'],
          'direccion' => $request['direccion'],
          'telefono' => $request['telefono'],
          'cuis' => $request['cuis'],
          'codigo_punto_venta' => $request['codigo_punto_venta'],
          'id_empresa' => Auth::user()->id_empresa
        ]);

      DB::commit();
      return redirect('/sucursal')->with("message", "SE REGISTRO CORRECTAMENTE");
    } catch (Exception $e) {
      DB::rollback();
      return redirect('/sucursal')->with("message-error", "ERROR INTENTE NUEVAMENTE");
    }
  }

  //CARGAR PARA PODER ACTUALIZAR EN LA PARTE DEL MODAL
  public function get_sucursal_por_id($id_sucursal)
  {
    $sucursal = DB::select("SELECT * from sucursal where id=" . $id_sucursal);
    return response($sucursal);
  }
}
