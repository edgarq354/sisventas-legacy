<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CajaController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }

  public function index(Request $request)
  {
    // Filtros (solo para el administrador, privilegio 0)
    $f_desde = $request->input('desde') ?: date('Y-m-01');
    $f_hasta = $request->input('hasta') ?: date('Y-m-d');
    $f_usuarios = array_values(array_filter((array) $request->input('id_usuario', []), fn($v) => is_numeric($v)));
    $usuarios_empresa = [];
    $filtro_caja = "";
    if (Auth::user()->privilegio == 0) {
        $usuarios_empresa = DB::select("SELECT id, usuario, nombre FROM users WHERE id_empresa = ".Auth::user()->id_empresa." ORDER BY nombre ASC");
        $filtro_caja = " and date(c.fecha_abrir) between '".$f_desde."' and '".$f_hasta."'";
        if (!empty($f_usuarios)) {
            $filtro_caja .= " and c.id_usuario in (".implode(',', array_map('intval', $f_usuarios)).")";
        }
    }

if(Auth::user()->privilegio==0 ){
      $caja = DB::select("SELECT c.*,a.usuario,c.monto_abrir+
      (select IFNULL(sum(nv.monto_total),0) from nota_venta nv  where nv.estado='Procesado' and nv.id_caja=c.id)
      + (select IFNULL(sum(dc.monto),0) from detalle_cobranza dc  where dc.forma_pago='Procesado' and dc.estado_cobranza='Por cobrar' and dc.id_caja=c.id)
      + (select IFNULL(sum(dc.monto),0) from ingreso dc  where  dc.id_caja=c.id and dc.estado in('Procesado'))
      - (select IFNULL(sum(dc.monto),0) from detalle_cobranza dc  where dc.forma_pago in ('Procesado')  and dc.estado_cobranza='Por pagar' and dc.id_caja=c.id)
       - (select IFNULL(sum(nc.monto_total),0) from nota_compra nc  where nc.estado='Procesado' and nc.id_caja=c.id)
       -(select IFNULL(sum(g.precio_gasto),0) from gasto g where g.id_caja=c.id and g.estado in ('Procesado') ) as 'monto_venta' ,
       c.monto_abrir+c.monto_abrir_qr+
      (select IFNULL(sum(nv.monto_total),0) from nota_venta nv  where nv.estado in ('Procesado','Qr','QrFie' ) and nv.id_caja=c.id)
      + (select IFNULL(sum(dc.monto),0) from detalle_cobranza dc  where dc.forma_pago in ('Procesado','Qr' )  and dc.estado_cobranza='Por cobrar' and dc.id_caja=c.id)
      + (select IFNULL(sum(dc.monto),0) from ingreso dc  where  dc.id_caja=c.id  and dc.estado in('Procesado'))
      - (select IFNULL(sum(dc.monto),0) from detalle_cobranza dc  where dc.forma_pago in ('Procesado','Qr' )  and dc.estado_cobranza='Por pagar' and dc.id_caja=c.id)
       - (select IFNULL(sum(nc.monto_total),0) from nota_compra nc  where nc.estado='Procesado' and nc.id_caja=c.id)
       -(select IFNULL(sum(g.precio_gasto),0) from gasto g where g.id_caja=c.id and g.estado in ('Procesado')) as 'monto_venta_total' ,
       c.monto_abrir_qr+(select IFNULL(sum(nv.monto_total),0) from nota_venta nv  where nv.estado in ('Qr','QrFie') and nv.id_caja=c.id)
       + (select IFNULL(sum(dc.monto),0) from detalle_cobranza dc  where dc.forma_pago in ('Qr' )  and dc.estado_cobranza='Por cobrar' and dc.id_caja=c.id)
       - (select IFNULL(sum(dc.monto),0) from detalle_cobranza dc  where dc.forma_pago in ('Qr')  and dc.estado_cobranza='Por pagar' and dc.id_caja=c.id) as monto_venta_qr,
       (select IFNULL(sum(nv.monto_total),0) from nota_venta nv  where nv.estado='Por cobrar' and nv.id_caja=c.id) as monto_venta_por_cobrar,
       (select IFNULL(sum(nv.monto_total),0) from nota_venta nv  where nv.estado='POS/Tarjeta' and nv.id_caja=c.id) as monto_venta_pos_tarjeta
            FROM caja c,users a
            where   c.id_usuario=a.id and c.id_empresa=" . Auth::user()->id_empresa . $filtro_caja . "   order by c.id desc limit 300");
    }else{
    $caja = DB::select("SELECT c.*,a.usuario,c.monto_abrir+
    (select IFNULL(sum(nv.monto_total),0) from nota_venta nv where nv.estado='Procesado' and nv.id_caja=c.id)
    + (select IFNULL(sum(dc.monto),0) from detalle_cobranza dc  where dc.forma_pago='Procesado' and dc.estado_cobranza='Por cobrar' and dc.id_caja=c.id)
    + (select IFNULL(sum(dc.monto),0) from ingreso dc  where  dc.id_caja=c.id  and dc.estado in('Procesado'))
    - (select IFNULL(sum(dc.monto),0) from detalle_cobranza dc  where dc.forma_pago in ('Procesado')  and dc.estado_cobranza='Por pagar' and dc.id_caja=c.id)
    - (select IFNULL(sum(nc.monto_total),0) from nota_compra nc  where nc.estado='Procesado' and nc.id_caja=c.id)
    -(select IFNULL(sum(g.precio_gasto),0) from gasto g where g.id_caja=c.id and g.estado in ('Procesado')) as 'monto_venta',
    c.monto_abrir+c.monto_abrir_qr+
    (select IFNULL(sum(nv.monto_total),0) from nota_venta nv  where nv.estado in ('Procesado','Qr','QrFie' ) and nv.id_caja=c.id)
      + (select IFNULL(sum(dc.monto),0) from detalle_cobranza dc  where dc.forma_pago in ('Procesado','Qr' )  and dc.estado_cobranza='Por cobrar' and dc.id_caja=c.id)
      + (select IFNULL(sum(dc.monto),0) from ingreso dc  where  dc.id_caja=c.id  and dc.estado in('Procesado'))
      - (select IFNULL(sum(dc.monto),0) from detalle_cobranza dc  where dc.forma_pago in ('Procesado','Qr' )  and dc.estado_cobranza='Por pagar' and dc.id_caja=c.id)
       - (select IFNULL(sum(nc.monto_total),0) from nota_compra nc  where nc.estado='Procesado' and nc.id_caja=c.id)
       -(select IFNULL(sum(g.precio_gasto),0) from gasto g where g.id_caja=c.id and g.estado in ('Procesado')) as 'monto_venta_total' ,
       c.monto_abrir_qr+(select IFNULL(sum(nv.monto_total),0) from nota_venta nv  where nv.estado in ('Qr','QrFie') and nv.id_caja=c.id)
       + (select IFNULL(sum(dc.monto),0) from detalle_cobranza dc  where dc.forma_pago in ('Qr' )  and dc.estado_cobranza='Por cobrar' and dc.id_caja=c.id)
       - (select IFNULL(sum(dc.monto),0) from detalle_cobranza dc  where dc.forma_pago in ('Qr')  and dc.estado_cobranza='Por pagar' and dc.id_caja=c.id) as monto_venta_qr,
       (select IFNULL(sum(nv.monto_total),0) from nota_venta nv  where nv.estado='Por cobrar' and nv.id_caja=c.id) as monto_venta_por_cobrar,
       (select IFNULL(sum(nv.monto_total),0) from nota_venta nv  where nv.estado='POS/Tarjeta' and nv.id_caja=c.id) as monto_venta_pos_tarjeta
            FROM caja c,users a
            where   c.id_usuario=a.id and c.id_empresa=" . Auth::user()->id_empresa . " and c.id_usuario=".Auth::user()->id."  order by c.id desc limit 100");
    }

    $caja_monto=DB::select("SELECT  cc.* FROM cajas c
    LEFT JOIN caja cc ON cc.id = (    SELECT cc2.id FROM caja cc2
    WHERE cc2.caja = c.descripcion  AND cc2.estado = 'Cerrada' AND cc2.id_empresa = ".Auth::user()->id_empresa."
    ORDER BY cc2.fecha_cierre DESC    LIMIT 1 ) ");

    $cajas_disponibles=DB::select("SELECT *
    from cajas c
    where  c.descripcion not in(select cc.caja from caja cc where cc.estado='Abierta' and cc.id_empresa=".Auth::user()->id_empresa.") ");

    $caja_abierta = DB::select("SELECT c.*,a.usuario FROM caja c,users a where c.estado='Abierta' and c.id_usuario=a.id and a.id=" . Auth::user()->id . " and c.id_empresa=" . Auth::user()->id_empresa);
    $id_caja = null;

    foreach ($caja_abierta as $key => $value) {
        $id_caja = $value->id;
      }
    return view('caja.index', [
      'caja' => $caja,
      'caja_monto' => $caja_monto,
      'cajas_disponibles' => $cajas_disponibles,
      'id_caja' => $id_caja,
      'usuarios_empresa' => $usuarios_empresa,
      'f_desde' => $f_desde,
      'f_hasta' => $f_hasta,
      'f_usuarios' => $f_usuarios,
    ]);

  }

  public function edit($id)
  {
    //LISTA DE VENTAS
    $nota_venta = DB::select("SELECT nc.*, a.usuario
          from nota_venta nc,  users a
          where
          nc.id_usuario = a.id and nc.id_caja=" . $id . " and nc.id_empresa=" . Auth::user()->id_empresa);

    $nota_compra = DB::select("SELECT nc.*, a.usuario,
          p.ci_nit,
          (concat(p.nombre,' ',p.paterno,' ',p.materno)) as proveedor,
          (concat(c.nombre,' ', c.paterno,' ',c.materno)) as comprador, c.nombre
          from nota_compra nc, users a, cliente p, cliente c
          where nc.id_proveedor = p.id and nc.id_comprador = c.id and nc.id_usuario = a.id and nc.id_caja=" . $id . " and nc.id_empresa=" . Auth::user()->id_empresa);

    $gasto = DB::select("SELECT  g.*,c.caja,a.usuario
          from gasto g, caja c, users a
          where g.id_caja=c.id and g.id_usuario=a.id and g.id_caja=" . $id . "  and g.id_empresa=" . Auth::user()->id_empresa . " order by g.id asc");

    $detalle_cobranza = DB::select("SELECT dc.*, a.usuario, c.caja as caja
    from detalle_cobranza dc,  users a, caja c
    where
    dc.id_caja=c.id and
    dc.id_usuario_registro = a.id and dc.id_caja=" . $id . " and dc.id_empresa=" . Auth::user()->id_empresa);

    $ingreso = DB::select("SELECT i.*,a.nombre as 'usuario',tp.nombre as tipo_gasto , c.caja, s.nombre as sucursal
             from ingreso i,tipo_gasto tp,users a,caja c, sucursal s
             where i.id_tipo_gasto=tp.id
             and a.id=i.id_usuario
             and s.id=i.id_sucursal
             and c.id=i.id_caja
             and i.estado in('Procesado')
             AND i.id_caja=".$id);

    $caja = DB::select("SELECT c.*,
      a.usuario,c.monto_abrir
      +(select IFNULL(sum(nv.monto_total),0) from nota_venta nv  where nv.estado='Procesado' and nv.id_caja=c.id)
      + (select IFNULL(sum(dc.monto),0) from detalle_cobranza dc  where dc.forma_pago='Procesado'  and dc.estado_cobranza='Por cobrar' and dc.id_caja=c.id)
      + (select IFNULL(sum(dc.monto),0) from ingreso dc  where  dc.id_caja=c.id and dc.estado in('Procesado'))
      - (select IFNULL(sum(dc.monto),0) from detalle_cobranza dc  where dc.forma_pago in ('Procesado')  and dc.estado_cobranza='Por pagar' and dc.id_caja=c.id)
       - (select IFNULL(sum(nc.monto_total),0) from nota_compra nc  where  nc.estado='Procesado' and nc.id_caja=c.id)
       -(select IFNULL(sum(g.precio_gasto),0) from gasto g where g.id_caja=c.id and g.estado in ('Procesado')) as 'monto_venta' ,
       c.monto_abrir+c.monto_abrir_qr+
      (select IFNULL(sum(nv.monto_total),0) from nota_venta nv  where nv.estado in ('Procesado','Qr','QrFie' ) and nv.id_caja=c.id)
      + (select IFNULL(sum(dc.monto),0) from detalle_cobranza dc  where dc.forma_pago in ('Procesado','Qr' )  and dc.estado_cobranza='Por cobrar' and dc.id_caja=c.id)
      + (select IFNULL(sum(dc.monto),0) from ingreso dc  where  dc.id_caja=c.id  and dc.estado in('Procesado'))
      - (select IFNULL(sum(dc.monto),0) from detalle_cobranza dc  where dc.forma_pago in ('Procesado','Qr' )  and dc.estado_cobranza='Por pagar' and dc.id_caja=c.id)
       - (select IFNULL(sum(nc.monto_total),0) from nota_compra nc  where nc.estado='Procesado' and nc.id_caja=c.id)
       -(select IFNULL(sum(g.precio_gasto),0) from gasto g where g.id_caja=c.id and g.estado in ('Procesado')) as 'monto_venta_total' ,
       c.monto_abrir_qr+(select IFNULL(sum(nv.monto_total),0) from nota_venta nv  where nv.estado in ('Qr','QrFie') and nv.id_caja=c.id)
       + (select IFNULL(sum(dc.monto),0) from detalle_cobranza dc  where dc.forma_pago in ('Qr' )  and dc.estado_cobranza='Por cobrar' and dc.id_caja=c.id)
       - (select IFNULL(sum(dc.monto),0) from detalle_cobranza dc  where dc.forma_pago in ('Qr')  and dc.estado_cobranza='Por pagar' and dc.id_caja=c.id) as monto_venta_qr,
       (select IFNULL(sum(nv.monto_total),0) from nota_venta nv  where nv.estado='Por cobrar' and nv.id_caja=c.id) as monto_venta_por_cobrar,
       (select IFNULL(sum(nv.monto_total),0) from nota_venta nv  where nv.estado='POS/Tarjeta' and nv.id_caja=c.id) as monto_venta_pos_tarjeta
            FROM caja c,users a
            where c.id_usuario=a.id and c.id=" . $id . "
             and c.id_empresa=" . Auth::user()->id_empresa . "
             order by c.id desc limit 1");

    return view('caja.edit', [
      'nota_venta' => $nota_venta,
      'nota_compra' => $nota_compra,
      'gasto' => $gasto,
      'caja' => $caja,
      'ingreso'=>$ingreso,
      'detalle_cobranza'=>$detalle_cobranza
    ]);
  }


  public function store(Request $request)
  {
    DB::beginTransaction();
    try {
      $caja = DB::select("SELECT c.*,a.usuario FROM caja c,users a where c.estado='Abierta' and c.id_usuario=a.id and a.id=" . Auth::user()->id . " and c.id_empresa=" . Auth::user()->id_empresa);
      $id_caja = null;

      foreach ($caja as $key => $value) {
        $id_caja = $value->id;
      }
      if ($id_caja != null) {

        return redirect('/caja')->with("message-error", "YA EXISTE UNA CAJA ABIERTA");
      }

      DB::table('caja')->insert(
        [
          'caja' => $request['caja'],
          'monto_abrir' => $request['monto_abrir'] ?? 0,
          'monto_abrir_qr' => $request['monto_abrir_qr'] ?? 0,
          'monto_abrir_bk' => $request['monto_abrir_bk'] ?? 0,
          'monto_abrir_qr_bk' => $request['monto_abrir_qr_bk'] ?? 0,
          'estado' => 'Abierta',
          'nota_abrir' => $request['nota_abrir'],
          'id_usuario' => Auth::user()->id,
          'fecha_abrir' => now(),
          'id_empresa' => Auth::user()->id_empresa
        ]
      );
      DB::commit();
      return redirect('/caja')->with("message", "SE REGISTRO CORRECTAMENTE");

    } catch (Exception $e) {
      DB::rollback();
      $this->registrar_bitacora('store de abrir caja',$e);
      return redirect('/caja')->with("message-error", "ERROR INTENTE NUEVAMENTE.".$e);
    }
  }

  public function update(Request $request)
  {
    DB::beginTransaction();
    try {


      $pedido = DB::table('caja')
        ->where('id', $request['id'])
        ->update([
          'monto_cierre' => $request['monto_cierre']?? 0,
          'monto_cierre_total' => $request['monto_cierre_total']?? 0,
          'monto_cierre_qr' => $request['monto_cierre_qr']?? 0,
          'monto_cierre_por_cobrar' => $request['monto_cierre_por_cobrar'] ?? 0,
          'monto_cierre_pos_tarjeta' => $request['monto_cierre_pos_tarjeta'] ?? 0,
          'nota_cierre' => $request['nota_cierre'],
          'estado' => 'Cerrada',
          'fecha_cierre' => now()
        ]);
      DB::commit();
      return redirect('/caja')->with("message", "SE ACTUALIZO CORRECTAMENTE");

    } catch (Exception $e) {
      DB::rollback();
      $this->registrar_bitacora('store de cerrar caja',$e);
      return redirect('/caja')->with("message-error", "ERROR INTENTE NUEVAMENTE".$e);
    }

  }

  public function show($id)
  {
    return "En proceso";
  }

  public function caja_imprimir()
  {
    // El PDF usa los montos ya guardados en `caja` (monto_abrir/monto_cierre/…),
    // no hace falta recalcular con subconsultas por cada fila.
    $caja = DB::select("SELECT c.*, a.usuario
            FROM caja c
            JOIN users a ON a.id = c.id_usuario
            WHERE c.id_empresa = " . Auth::user()->id_empresa . "
            ORDER BY c.id DESC
            LIMIT 80");
    $empresa = DB::select("SELECT * from empresa  where id='" . Auth::user()->id_empresa . "'");

    $pdf = \PDF::loadView('caja.caja_imprimir', [
      'caja' => $caja,
      'empresa' => $empresa
    ])->setPaper('letter', 'landscape');
    return $pdf->stream('historial-cajas.pdf');
  }

  public function caja_usuario_imprimir($id_caja)
  {

    // LISTA DE VENTAS
    $nota_venta = DB::select("SELECT nc.*, a.usuario
          from nota_venta nc,  users a
          where
          nc.id_usuario = a.id and nc.id_caja=" . $id_caja . " and nc.id_empresa=" . Auth::user()->id_empresa);
    // LISTA DE COMPRAS
      $nota_compra = DB::select("SELECT nc.*, a.usuario,
      p.ci_nit,
      (concat(p.nombre,' ',p.paterno,' ',p.materno)) as proveedor,
      (concat(c.nombre,' ', c.paterno,' ',c.materno)) as comprador, c.nombre
      from nota_compra nc, users a, cliente p, cliente c
      where nc.id_proveedor = p.id and nc.id_comprador = c.id and nc.id_usuario = a.id and nc.id_caja=" . $id_caja . " and nc.id_empresa=" . Auth::user()->id_empresa);
    // LISTA DE GASTOS
      $gasto = DB::select("SELECT  g.*,c.caja,a.usuario, tg.nombre as tipo_gasto
      from gasto g, caja c, users a, tipo_gasto tg
      where g.id_caja=c.id and g.id_usuario=a.id and tg.id=g.id_tipo_gasto and g.estado in ('Procesado') and g.id_caja=" . $id_caja . "  and g.id_empresa=" . Auth::user()->id_empresa . " order by g.id asc");

    //INGRESOS
    $ingreso = DB::select("SELECT i.*,a.nombre as 'usuario',tp.nombre as tipo_gasto , c.caja, s.nombre as sucursal
    from ingreso i,tipo_gasto tp,users a,caja c, sucursal s
    where i.id_tipo_gasto=tp.id
    and a.id=i.id_usuario
    and s.id=i.id_sucursal
    and c.id=i.id_caja
    and i.estado in('Procesado')
    AND i.id_caja=".$id_caja);

    // DETALLE DE LA CAJA
      $caja = DB::select("SELECT c.*,a.usuario,c.monto_abrir+(select IFNULL(sum(nv.monto_total),0) from nota_venta nv  where nv.id_caja=c.id and nv.id_empresa=" . Auth::user()->id_empresa . ") as 'monto_venta'
              FROM caja c,users a
              where c.id_usuario=a.id and c.id=" . $id_caja . " and c.id_empresa=" . Auth::user()->id_empresa . " order by c.id desc limit 1");
    // DATOS DE LA EMPRESA
      $empresa = DB::select("SELECT * from empresa  where id='" . Auth::user()->id_empresa . "'");

      $pdf = \PDF::loadView('caja.caja_usuario_imprimir', [
        'nota_venta' => $nota_venta,
        'nota_compra' => $nota_compra,
        'gasto' => $gasto,
        'ingreso' => $ingreso,
        'caja' => $caja,
        'empresa' => $empresa
      ]);
    return $pdf->stream();
  }

  public function caja_usuario_utilidad_imprimir($id_caja)
  {

    // LISTA DE VENTAS
    $nota_venta = DB::select("SELECT nc.*, a.usuario
          from nota_venta nc,  users a
          where
          nc.id_usuario = a.id and nc.id_caja=" . $id_caja . " and nc.id_empresa=" . Auth::user()->id_empresa);
        // LISTA VENTAS POR PRODUCTO
    $detalle_venta = DB::select("SELECT tabla.*,ROUND(tabla.sub_total-(tabla.precio_compra * tabla.cantidad ),2)  as utilidad FROM
        (SELECT nv.estado,date(nv.fecha) as fecha,
        dv.id_producto_sucursal,
        dv.id_producto as id,
        tp.nombre as tipo_producto,
        p.marca,
        IFNULL(p.codigo_producto, 'S/C') as codigo_producto,
        concat(p.nombre,', ',IFNULL(p.descripcion, 'S/D'),', ', IFNULL(p.modelo, 'S/M')) as descripcion,
        dv.cantidad  as cantidad,
        dv.precio_unidad,
        dv.sub_total as sub_total,ps.precio_compra as precio_compra
        from caja c, detalle_venta dv, nota_venta nv , producto p, producto_sucursal ps, tipo_producto tp
        where
        nv.estado<>'Cancelado' and
        tp.id=p.id_tipo_producto and
        p.id=dv.id_producto and
        c.id=nv.id_caja and dv.id_nota_venta=nv.id and
        ps.id=dv.id_producto_sucursal and
        nv.id_caja=" . $id_caja . " and nv.id_empresa=" . Auth::user()->id_empresa."
        ORDER BY  nv.estado,dv.id_producto_sucursal, dv.precio_unidad ASC )tabla");
//AGRUPADO DE TIPO DE VENTA
        $detalle_venta_grupo = DB::select("SELECT distinct nv.estado
        from caja c,  nota_venta nv
        where
        nv.estado<>'Cancelado' and
        c.id=nv.id_caja and
        nv.id_caja=" . $id_caja . " and nv.id_empresa=" . Auth::user()->id_empresa );

    // LISTA DE COMPRAS
      $nota_compra = DB::select("SELECT nc.*, a.usuario,
      p.ci_nit,
      (concat(p.nombre,' ',p.paterno,' ',p.materno)) as proveedor,
      (concat(c.nombre,' ', c.paterno,' ',c.materno)) as comprador, c.nombre
      from nota_compra nc, users a, cliente p, cliente c
      where nc.id_proveedor = p.id and nc.id_comprador = c.id and nc.id_usuario = a.id and nc.id_caja=" . $id_caja . " and nc.id_empresa=" . Auth::user()->id_empresa);


   // LISTA VENTAS POR PRODUCTO
   $detalle_compra = DB::select("SELECT tabla.*FROM
   (SELECT nv.estado,date(nv.fecha) as fecha,
   dv.id_producto_sucursal,
   dv.id_producto as id,
   tp.nombre as tipo_producto,
   p.marca,
   IFNULL(p.codigo_producto, 'S/C') as codigo_producto,
   concat(p.nombre,', ',IFNULL(p.descripcion, 'S/D'),', ', IFNULL(p.modelo, 'S/M')) as descripcion,
   dv.cantidad  as cantidad,
   dv.precio_unidad,
   dv.sub_total as sub_total,ps.precio_compra as precio_compra
   from caja c, detalle_compra dv, nota_compra nv , producto p, producto_sucursal ps, tipo_producto tp
   where
   nv.estado<>'Cancelado' and
   tp.id=p.id_tipo_producto and
   p.id=dv.id_producto and
   c.id=nv.id_caja and dv.id_nota_compra=nv.id and
   ps.id=dv.id_producto_sucursal and
   nv.id_caja=" . $id_caja . " and nv.id_empresa=" . Auth::user()->id_empresa."
   ORDER BY  nv.estado,dv.id_producto_sucursal, dv.precio_unidad ASC )tabla");
//AGRUPADO DE TIPO DE VENTA
   $detalle_compra_grupo = DB::select("SELECT distinct nv.estado
   from caja c,  nota_compra nv
   where
   nv.estado<>'Cancelado' and
   c.id=nv.id_caja and
   nv.id_caja=" . $id_caja . " and nv.id_empresa=" . Auth::user()->id_empresa );

    // LISTA DE GASTOS
      $gasto = DB::select("SELECT  g.*,c.caja,a.usuario, tg.nombre as tipo_gasto
      from gasto g, caja c, users a, tipo_gasto tg
      where g.id_caja=c.id and g.id_usuario=a.id and tg.id=g.id_tipo_gasto and g.estado in ('Procesado') and g.id_caja=" . $id_caja . "  and g.id_empresa=" . Auth::user()->id_empresa . " order by g.id asc");


    //INGRESOS
    $ingreso = DB::select("SELECT i.*,a.nombre as 'usuario',tp.nombre as tipo_gasto , c.caja, s.nombre as sucursal
    from ingreso i,tipo_gasto tp,users a,caja c, sucursal s
    where i.id_tipo_gasto=tp.id
    and a.id=i.id_usuario
    and s.id=i.id_sucursal
    and c.id=i.id_caja
    and i.estado in('Procesado')
    AND i.id_caja=".$id_caja);

    // DETALLE DE LA CAJA
      $caja = DB::select("SELECT c.*,a.usuario,c.monto_abrir+(select IFNULL(sum(nv.monto_total),0) from nota_venta nv  where nv.id_caja=c.id and nv.id_empresa=" . Auth::user()->id_empresa . ") as 'monto_venta'
              FROM caja c,users a
              where c.id_usuario=a.id and c.id=" . $id_caja . " and c.id_empresa=" . Auth::user()->id_empresa . " order by c.id desc limit 1");
    // DATOS DE LA EMPRESA
      $empresa = DB::select("SELECT * from empresa  where id='" . Auth::user()->id_empresa . "'");

      $pdf = \PDF::loadView('caja.caja_usuario_utilidad_imprimir', [
        'nota_venta' => $nota_venta,
        'detalle_venta'=>$detalle_venta,
        'detalle_compra'=>$detalle_compra,
        'nota_compra' => $nota_compra,
        'gasto' => $gasto,
        'ingreso' => $ingreso,
        'caja' => $caja,
        'empresa' => $empresa,
        'detalle_venta_grupo'=>$detalle_venta_grupo,
        'detalle_compra_grupo'=>$detalle_compra_grupo
      ]);
    return $pdf->stream();
  }

  public function caja_usuario_imprimir_boletin($id_caja)
  {

    // LISTA DE VENTAS
    $nota_venta = DB::select("SELECT nc.estado,SUM(nc.monto_total) AS monto_total
          from nota_venta nc
          where
          nc.id_caja=" . $id_caja . " and nc.id_empresa=" . Auth::user()->id_empresa." GROUP BY nc.estado");
    // LISTA DE COMPRAS
      $nota_compra = DB::select("SELECT nc.estado,SUM(nc.monto_total) AS monto_total
      from nota_compra nc, users a, cliente p, cliente c
      where nc.id_proveedor = p.id and nc.id_comprador = c.id and nc.id_usuario = a.id and nc.id_caja=" . $id_caja . " and nc.id_empresa=" . Auth::user()->id_empresa." GROUP BY nc.estado");
    // LISTA DE GASTOS (detallado: cada gasto con su descripción)
      $gasto = DB::select("SELECT g.detalle, g.precio_gasto AS monto_total, tg.nombre AS tipo_gasto
      from gasto g
      join tipo_gasto tg on tg.id = g.id_tipo_gasto
      where g.id_caja=" . $id_caja . "  and g.id_empresa=" . Auth::user()->id_empresa . " and g.estado in ('Procesado')
      order by g.id asc");

    // DETALLE DE LA CAJA
      $caja = DB::select("SELECT c.*,a.usuario,c.monto_abrir+(select IFNULL(sum(nv.monto_total),0) from nota_venta nv  where nv.id_caja=c.id and nv.id_empresa=" . Auth::user()->id_empresa . ") as 'monto_venta'
              FROM caja c,users a
              where c.id_usuario=a.id and c.id=" . $id_caja . " and c.id_empresa=" . Auth::user()->id_empresa . " order by c.id desc limit 1");

    //INGRESOS
    $ingreso = DB::select("SELECT i.*,a.nombre as 'usuario',tp.nombre as tipo_gasto , c.caja, s.nombre as sucursal
    from ingreso i,tipo_gasto tp,users a,caja c, sucursal s
    where i.id_tipo_gasto=tp.id
    and a.id=i.id_usuario
    and s.id=i.id_sucursal
    and c.id=i.id_caja
    and i.estado in('Procesado')
    AND i.id_caja=".$id_caja);

    // DATOS DE LA EMPRESA
      $empresa = DB::select("SELECT * from empresa  where id='" . Auth::user()->id_empresa . "'");

      $customPaper = array(0,0,1567.00,226.77);
      $pdf = \PDF::loadView('caja.caja_usuario_imprimir_boletin', [
        'nota_venta' => $nota_venta,
        'nota_compra' => $nota_compra,
        'gasto' => $gasto,
        'ingreso' => $ingreso,
        'caja' => $caja,
        'empresa' => $empresa
      ])->setPaper($customPaper, 'landscape');

    return $pdf->stream();
  }


  public function caja_usuario_imprimir_por_producto_boletin($id_caja)
  {

    // LISTA VENTAS POR PRODUCTO
    $detalle_venta = DB::select("SELECT p.id as id, date(nv.fecha) as fecha,p.nombre as descripcion,sum(dv.cantidad)  as cantidad
    from caja c, detalle_venta dv, nota_venta nv , producto p
    where
    p.id=dv.id_producto and
    c.id=nv.id_caja and dv.id_nota_venta=nv.id and
    nv.id_caja=" . $id_caja . " and nv.id_empresa=" . Auth::user()->id_empresa."
    GROUP BY p.id,fecha
    ORDER BY p.id");

    // DETALLE DE LA CAJA
      $caja = DB::select("SELECT c.*,a.usuario,c.monto_abrir+(select IFNULL(sum(nv.monto_total),0) from nota_venta nv  where nv.id_caja=c.id and nv.id_empresa=" . Auth::user()->id_empresa . ") as 'monto_venta'
              FROM caja c,users a
              where c.id_usuario=a.id and c.id=" . $id_caja . " and c.id_empresa=" . Auth::user()->id_empresa . " order by c.id desc limit 1");
    // DATOS DE LA EMPRESA
      $empresa = DB::select("SELECT * from empresa  where id='" . Auth::user()->id_empresa . "'");

      $customPaper = array(0,0,1567.00,226.77);
      $pdf = \PDF::loadView('caja.caja_usuario_imprimir_por_producto_boletin', [
        'detalle_venta' => $detalle_venta,
        'caja' => $caja,
        'empresa' => $empresa
      ])->setPaper($customPaper, 'landscape');

    return $pdf->stream();
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
