<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\NotaVentaRequest;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use App\Usuario;
use App\Notificacion;
use Illuminate\Support\Facades\DB;
use Luecano\NumeroALetras\NumeroALetras;


 use App\Services\QrService;

class NotaVentaController extends Controller
{
   protected $qrService;

         public function __construct() {
         $this->middleware('auth'); 
    }

    function index(Request $Request)
    {

      if(Auth::user()->privilegio==0){
        $nota_venta=DB::select("SELECT nc.*, a.usuario
          from nota_venta nc,  users a
          where
          nc.id_usuario = a.id and nc.id_empresa= ".Auth::user()->id_empresa." order by nc.id desc limit 50");

       return view('nota_venta.index',[
        'nota_venta'=>$nota_venta ]);
      }else{
        $nota_venta=DB::select("SELECT nc.*, a.usuario
          from nota_venta nc,  users a, caja c
          where
          c.id_usuario=a.id and nc.id_caja=c.id and
          nc.id_usuario = a.id and a.id=".Auth::user()->id." AND nc.id_empresa= ".Auth::user()->id_empresa." order by nc.id desc limit 50");

       return view('nota_venta.index',[
        'nota_venta'=>$nota_venta ]);
      }

    }

    public function create(Request $request)
    {



      $documento=DB::select("SELECT clasificador.codigoClasificador as id, clasificador.descripcion as nombre
      FROM clasificador WHERE clasificador.tipoClasificador='tipo_documento' and estado=1 and  id_empresa= ".Auth::user()->id_empresa);
      $cliente=DB::select("SELECT  c.id, c.ci_nit,upper(c.nombre) as nombre,upper(c.paterno)as paterno,upper(c.materno) as materno from cliente c where c.id_empresa= ".Auth::user()->id_empresa
      ." UNION SELECT 0 as id, 0 as ci_nit, upper(trim(t.razon_social)) as nombre,'','' FROM (SELECT DISTINCT n.razon_social FROM nota_venta n WHERE n.id_empresa=".Auth::user()->id_empresa.")t ");
      $tipo=DB::select("SELECT  * from tipo_producto tp where tp.id_empresa= ".Auth::user()->id_empresa." and tp.id in(select id_tipo_producto from producto )");
      $caja=DB::select("SELECT id from caja where  estado ='Abierta' and id_usuario=".Auth::user()->id." and  id_empresa= ".Auth::user()->id_empresa." order by id desc limit 1 ");
      $id_caja="";

       foreach ($caja as $key => $value) {
            $id_caja= $value->id;
        }

      // Cobro con QR de Banco FIE habilitado para esta empresa
      $emp = DB::selectOne("SELECT pago_qr_bancofie, bancofie_usuario, bancofie_password, bancofie_id_servicio FROM empresa WHERE id = ".Auth::user()->id_empresa);
      $bancofie_habilitado = $emp
          && (int)($emp->pago_qr_bancofie ?? 0) === 1
          && !empty($emp->bancofie_usuario)
          && !empty($emp->bancofie_password)
          && !empty($emp->bancofie_id_servicio);


        $userAgent = $request->header('User-Agent');
      if (preg_match('/(android|iphone|ipad|ipod|windows phone|blackberry|mobile)/i', $userAgent)) {
          // El usuario está usando un dispositivo móvil
          return view('nota_venta.create_mobile',['tipo_producto'=>$tipo,
          'cliente'=>$cliente,
          'id_caja'=>$id_caja,
          'bancofie_habilitado'=>$bancofie_habilitado,
          'tipo_documento'=>$documento]);
      } else {
          return view('nota_venta.create',['tipo_producto'=>$tipo,
          'cliente'=>$cliente,
          'id_caja'=>$id_caja,
          'bancofie_habilitado'=>$bancofie_habilitado,
          'tipo_documento'=>$documento]);
      }
    }

    public function store(NotaVentaRequest $request){
      $resultado="";

      // ── Cobro con QR de Banco FIE: la venta solo se registra si Banco FIE
      //    confirma que la transaccion quedo PAGADA (se re-verifica aqui,
      //    no se confia en el navegador). Ver BancoFieQrController.
      $id_transaccion_qr = null;
      if ($request['estado'] === 'QrFie') {
          $id_transaccion_qr = (int) $request->input('id_transaccion_qr', 0);
          if ($id_transaccion_qr <= 0) {
              return redirect('/nota_venta/create')->with('message-error', 'Falta generar y pagar el QR de Banco FIE.');
          }
          $empresaRow = DB::select('SELECT * FROM empresa WHERE id = ? LIMIT 1', [Auth::user()->id_empresa]);
          $txRow = DB::table('transaccion_qr_bancofie')
              ->where('id_transaccion', $id_transaccion_qr)
              ->where('id_empresa', Auth::user()->id_empresa)
              ->first();
          if (empty($empresaRow) || $txRow === null) {
              return redirect('/nota_venta/create')->with('message-error', 'Transacción QR no encontrada.');
          }
          if (!empty($txRow->id_nota_venta)) {
              return redirect('/nota_venta/create')->with('message-error', 'Ese QR ya fue usado en otra venta.');
          }
          $verif = (new \App\Services\BancoFieService($empresaRow[0]))->verificar($id_transaccion_qr);
          if (empty($verif['ok']) || empty($verif['pagado'])) {
              return redirect('/nota_venta/create')->with('message-error', 'El QR de Banco FIE aún no está pagado.');
          }
          DB::table('transaccion_qr_bancofie')->where('id_transaccion', $id_transaccion_qr)->update([
              'estado_pago' => 'PAGADO',
              'fecha_verificacion' => now(),
          ]);
      }

        	DB::beginTransaction();
        try {
               $id_cliente=null;

               // Obtener DATOS DEL CLIENTE
                  if(isset($request['numero_documento'])==true &&  $request['numero_documento']!=''){
                    $cliente=DB::select("SELECT id from cliente where ci_nit='".$request['numero_documento']."' and  id_empresa= ".Auth::user()->id_empresa);

                    foreach ($cliente as $key => $value) {
                     $id_cliente= $value->id;
                    }
                    if($id_cliente==null){
                     //Registro de cliente con razon social igualesS
                     try{
                       $id_cliente=DB::table('cliente')->insertGetId([
                        'ci_nit'=>$request['numero_documento'],
                        'nombre'=>$request['razon_social'],
                        'id_empresa'=>Auth::user()->id_empresa
                        ]);
                     } catch (Exception $e) {
                      //echo $e;
                      $resultado.=",try:".$e;
                     }
                   }
                  }

                // Obtener Datos EMPRESA
                $empresa=DB::select("SELECT * from empresa where id=".Auth::user()->id_empresa);

                // Obtener Datos SUCURSAL
                $sucursal=DB::select("SELECT * from sucursal where id=".Auth::user()->id_sucursal);


                  // Registrar CLIENTE NUEVO
                    if($id_cliente==null){
                      try{
                       $id_cliente=DB::table('cliente')->insertGetId([
                        'ci_nit'=>$request['numero_documento'],
                        'nombre'=>$request['razon_social'],
                        'id_empresa'=>Auth::user()->id_empresa
                        ]);
                     } catch (Exception $e) {
                      //echo $e;
                      $resultado.=",try:".$e;
                     }
                    }
                    $resultado.= ",cliente..".$id_cliente;
                    //Obtener Numero de TIcket
                    $ticket=DB::select("SELECT COALESCE(MAX(nv.numero_ticket) + 1, 1) as numero_ticket
                    from nota_venta nv, caja c
                    where nv.id_caja=c.id and c.id_usuario=".Auth::user()->id." and nv.id_empresa=".Auth::user()->id_empresa." and c.estado ='Abierta'");
                    // Registrar NOTA DE VENTA
                      $id_nota_venta=DB::table('nota_venta')->insertGetId([
                        'monto_total'=>$request['monto_total'],
                        'efectivo_pago'=>$request['efectivo_pago'],
                        'ci_nit'=>$request['numero_documento'],
                        'razon_social'=>$request['razon_social'],
                        'id_caja'=>$request['id_caja'],
                        'tipo'=>$request['tipo'],
                        'id_cliente'=>$id_cliente,
                        'id_usuario'=>Auth::user()->id,
                        'estado'=>$request['estado'],
                        'numero_ticket'=>$ticket[0]->numero_ticket,
                        'id_transaccion_qr'=>$id_transaccion_qr,
                        'fecha'=>now(),
                        'id_empresa'=>Auth::user()->id_empresa
                        ] );

                      // Vincular la transaccion QR de Banco FIE con esta venta
                      if($id_transaccion_qr!=null){
                        DB::table('transaccion_qr_bancofie')
                          ->where('id_transaccion',$id_transaccion_qr)
                          ->update(['id_nota_venta'=>$id_nota_venta]);
                      }

                      if($request['estado']=="Por cobrar"){
                        // Registrar PLAN DE PAGOS COBRANZA
                        $id_cobranza=DB::table('cobranzas')->insertGetId([
                          'monto_total'=>$request['monto_total'],
                          'id_nota_venta'=>$id_nota_venta,
                          'ci_nit'=>$request['numero_documento'],
                          'razon_social'=>$request['razon_social'],
                          'id_cliente'=>$id_cliente,
                          'nota'=>"Ticket: ".$ticket[0]->numero_ticket,
                          'tipo'=>"NOTA_VENTA",
                          'id_usuario_registro'=>Auth::user()->id,
                          'id_caja'=>$request['id_caja'],
                          'estado'=>$request['estado'],
                          'id_sucursal'=>Auth::user()->id_sucursal,
                          'fecha_registro'=>now(),
                          'id_empresa'=>Auth::user()->id_empresa
                          ] );
                      }

                  // Registrar DETALLE DE VENTA
                  $cant=0;
                  foreach ($request['idCarrito'] as $val) {
                    $id_producto=$request['idCarrito'][$cant];
                    $cantidad=$request['cantidad'][$cant];
                    $precio=$request['precio'][$cant];
                    $precioCompra=$request['precioCompra'][$cant];
                    $precioVenta=$request['precioVenta'][$cant];
                    $actividadEconomica=$request['actividadEconomica'][$cant];
                    $descripcion=$request['descripcion'][$cant];
                    $unidadMedida = (is_numeric($request->input("unidadMedida.$cant")) && $request->input("unidadMedida.$cant") !== 'undefined') ? (int)$request->input("unidadMedida.$cant") : 0;
                    $montoDescuento=$request['montoDescuento'][$cant];
                    $subTotal=$request['subTotal'][$cant];
                    $peso=$request['peso'][$cant];
                    $cant++;
                    DB::table('detalle_venta')->insert([
                      'id_nota_venta'=>$id_nota_venta,
                      'id_producto'=>$id_producto,
                      'precio_unidad'=>$precio,
                      'cantidad'=>$cantidad,
                      'peso'=>$peso,
                      'actividad_economica'=>$actividadEconomica,
                      'descripcion'=>$descripcion,
                      'unidad_medida'=>$unidadMedida,
                      'monto_descuento'=>$montoDescuento,
                      'sub_total'=>$subTotal,
                      'fecha_registro'=>now(),
                      'id_empresa'=>Auth::user()->id_empresa
                    ]);
                    DB::table('producto')
                    ->where('id',$id_producto)
                    ->update([
                      'cantidad'=>DB::raw('cantidad - '.$cantidad),
                      'peso'=>DB::raw('peso - '.$peso)
                    ]);
                }
                 DB::commit();


                //Generar Ticket en BASE 64
                $ticketBase64=self::nota_venta_imprimir_pequenio_ticket_base_64($id_nota_venta);
                //Generar Ticket en BASE 64
                $ticketCocinaBase64=self::nota_venta_imprimir_pequenio_ticket_cocina_base_64($id_nota_venta);
                //Generar Nota de Venta en BASE 64
                $notaVentaBase64= self::nota_venta_imprimir_pequenio_base_64($id_nota_venta);
                //Agregar las impresoras
                $servidor1="";
                $servidor2="";
                $impresora1="";
                $impresora2="";
                $impresora_nota_venta="";
                $impresora_factura="";
                    foreach ($empresa as $key => $value) {
                      $servidor1=$value->servidor_impresora1;
                      $servidor2=$value->servidor_impresora2;
                      $impresora1=$value->impresora1;
                      $impresora2=$value->impresora2;
                      $impresora_nota_venta=$value->impresora_nota_venta;
                      $impresora_factura=$value->impresora_factura;
                    }
                return redirect('/nota_venta/create')
                ->with('servidor1',$servidor1)
                ->with('servidor2',$servidor2)
                ->with('impresora1',$impresora1)
                ->with('impresora2',$impresora2)
                ->with('impresora_nota_venta',$impresora_nota_venta)
                ->with('impresora_factura',$impresora_factura)
                ->with('nota_venta_id',$id_nota_venta)
                ->with('nota_venta_base64',$notaVentaBase64)
                ->with('ticket_cocina_base64',$ticketCocinaBase64)
                ->with('ticket_base64',$ticketBase64);

        } catch (Exception $e) {
          DB::rollback();
          return redirect('/nota_venta')->with("message-error","ERROR INTENTE NUEVAMENTE");
        }
    	}

    	public function update(Request $request){
    	DB::beginTransaction();
        try {
          $estado=0;
          if($request['estado_edit']){
            $estado=1;
          }

	         $pedido = DB::table('categoria')
	         ->where('id',$request['id_categoria_edit'])
           ->update(['nombre'=>$request['nombre_edit'],'estado'=>$estado  ]);
                DB::commit();
                return redirect('/categoria')->with("message","SE ACTUALIZO CORRECTAMENTE");

        } catch (Exception $e) {
          DB::rollback();
          return redirect('/categoria')->with("message-error","ERROR INTENTE NUEVAMENTE");
        }

    	}

    function cargar_categoria($id_video){
        $apoderado=DB::select("SELECT * FROM categoria WHERE id=".$id_video);
        return response($apoderado);
    }


    public function nota_venta_imprimir($id){

      $empresa=DB::select("SELECT * from empresa e where e.id=".Auth::user()->id_empresa);

          $nota_venta=DB::select("SELECT nc.*, a.usuario
          from nota_venta nc,  users a
          where nc.id_usuario = a.id  and nc.id=".$id." and  nc.id_empresa= ".Auth::user()->id_empresa);

          $sucursal=DB::select("SELECT * from sucursal e where  e.id_empresa=".Auth::user()->id_empresa);
          //$factura=DB::select("SELECT * from factura e where e.id_nota_venta=".$nota_venta[0]->id." and e.id_empresa=".Auth::user()->id_empresa);

          $detalle_venta=DB::select("
                      SELECT dv.*, p.nombre
                      from detalle_venta dv, producto p
                      where p.id=dv.id_producto and  dv.id_nota_venta=".$id ." and dv.id_empresa= ".Auth::user()->id_empresa);

          $formatter = new NumeroALetras();
          $numeroLetra=ucfirst(strtolower($formatter->toInvoice($nota_venta[0]->monto_total, 2,'Bolivianos')));


          $qrGenerar = "nit=".$empresa[0]->nit."&numero=".$nota_venta[0]->id."&t=1";

 	$this->qrService = new QrService();
        $qrGenerar = str_replace(["\r", "\n"], '', $this->qrService->generarBase64($qrGenerar));
         

        $pdf=\PDF::loadView('nota_venta.imprimir_recibo',  [
          'nota_venta'=>$nota_venta,
          'detalle_venta'=>$detalle_venta,
          'empresa'=>$empresa,
          'sucursal'=>$sucursal,
          //'factura'=>$factura,
          'qrBase64' => $qrGenerar,
          'numeroLetra'=>$numeroLetra
        ]);
        return   $pdf->stream();

    }


    public function nota_venta_imprimir_pequenio_ticket_pdf($id){

      $empresa=DB::select("SELECT * from empresa e where e.id=".Auth::user()->id_empresa);

          $nota_venta=DB::select("SELECT nc.*, a.usuario
          from nota_venta nc,  users a
          where nc.id_usuario = a.id  and nc.id=".$id." and  nc.id_empresa= ".Auth::user()->id_empresa);

          $sucursal=DB::select("SELECT * from sucursal e where  e.id_empresa=".Auth::user()->id_empresa);
          $factura=DB::select("SELECT * from factura e where e.id_nota_venta=".$nota_venta[0]->id." and e.id_empresa=".Auth::user()->id_empresa);

          $detalle_venta=DB::select("
                      SELECT dv.*, p.nombre
                      from detalle_venta dv, producto p
                      where p.id=dv.id_producto and  dv.id_nota_venta=".$id ." and dv.id_empresa= ".Auth::user()->id_empresa);

          $formatter = new NumeroALetras();
          $numeroLetra=ucfirst(strtolower($formatter->toInvoice($nota_venta[0]->monto_total, 2,'Bolivianos')));

$customPaper = array(0,0,567.00,226.77);
//$customPaper = array(0,0,0,0);
        $pdf=\PDF::loadView('nota_venta.imprimir_ticket',  [
          'nota_venta'=>$nota_venta,
          'detalle_venta'=>$detalle_venta,
          'empresa'=>$empresa,
          'sucursal'=>$sucursal,
          'factura'=>$factura,
          'numeroLetra'=>$numeroLetra
        ])->setPaper($customPaper, 'landscape');

        return   $pdf->stream();
    }

    public function nota_venta_imprimir_pequenio($id){

      $empresa=DB::select("SELECT * from empresa e where e.id=".Auth::user()->id_empresa);

          $nota_venta=DB::select("SELECT nc.*, a.usuario
          from nota_venta nc,  users a
          where nc.id_usuario = a.id  and nc.id=".$id." and  nc.id_empresa= ".Auth::user()->id_empresa);

          $sucursal=DB::select("SELECT * from sucursal e where  e.id_empresa=".Auth::user()->id_empresa);
          $factura=DB::select("SELECT * from factura e where e.id_nota_venta=".$nota_venta[0]->id." and e.id_empresa=".Auth::user()->id_empresa);

          $detalle_venta=DB::select("
                      SELECT dv.*, p.nombre
                      from detalle_venta dv, producto p
                      where p.id=dv.id_producto and  dv.id_nota_venta=".$id ." and dv.id_empresa= ".Auth::user()->id_empresa);

          $formatter = new NumeroALetras();
          $numeroLetra=ucfirst(strtolower($formatter->toInvoice($nota_venta[0]->monto_total, 2,'Bolivianos')));

        $customPaper = array(0,0,567.00,226.77);
        $pdf=\PDF::loadView('nota_venta.imprimir_recibo_pequenio',  [
          'nota_venta'=>$nota_venta,
          'detalle_venta'=>$detalle_venta,
          'empresa'=>$empresa,
          'sucursal'=>$sucursal,
          'factura'=>$factura,
          'numeroLetra'=>$numeroLetra
        ])->setPaper($customPaper, 'landscape');
    //    return   $pdf->stream();
    return $pdf->download('nota_venta_'.$id.'.pdf');
    }

    public function nota_venta_imprimir_pequenio_base_64($id){

      $empresa=DB::select("SELECT * from empresa e where e.id=".Auth::user()->id_empresa);

          $nota_venta=DB::select("SELECT nc.*, a.usuario
          from nota_venta nc,  users a
          where nc.id_usuario = a.id  and nc.id=".$id." and  nc.id_empresa= ".Auth::user()->id_empresa);

          $sucursal=DB::select("SELECT * from sucursal e where  e.id_empresa=".Auth::user()->id_empresa);
          $factura=DB::select("SELECT * from factura e where e.id_nota_venta=".$nota_venta[0]->id." and e.id_empresa=".Auth::user()->id_empresa);

          $detalle_venta=DB::select("
                      SELECT dv.*, p.nombre
                      from detalle_venta dv, producto p
                      where p.id=dv.id_producto and  dv.id_nota_venta=".$id ." and dv.id_empresa= ".Auth::user()->id_empresa);

          $formatter = new NumeroALetras();
          $numeroLetra=ucfirst(strtolower($formatter->toInvoice($nota_venta[0]->monto_total, 2,'Bolivianos')));

        $customPaper = array(0,0,567.00,226.77);
        $pdf=\PDF::loadView('nota_venta.imprimir_recibo_pequenio',  [
          'nota_venta'=>$nota_venta,
          'detalle_venta'=>$detalle_venta,
          'empresa'=>$empresa,
          'sucursal'=>$sucursal,
          'factura'=>$factura,
          'numeroLetra'=>$numeroLetra
        ])->setPaper($customPaper, 'landscape');

        $pdfContent = $pdf->output(); // Obtener el contenido del PDF como una cadena binaria

        // Convertir la cadena binaria a Base64
        $base64 = base64_encode($pdfContent);

        return $base64;
    }

    public function nota_venta_imprimir_pequenio_ticket_base_64($id){

      $empresa=DB::select("SELECT * from empresa e where e.id=".Auth::user()->id_empresa);

          $nota_venta=DB::select("SELECT nc.*, a.usuario
          from nota_venta nc,  users a
          where nc.id_usuario = a.id  and nc.id=".$id." and  nc.id_empresa= ".Auth::user()->id_empresa);

          $sucursal=DB::select("SELECT * from sucursal e where  e.id_empresa=".Auth::user()->id_empresa);
          $factura=DB::select("SELECT * from factura e where e.id_nota_venta=".$nota_venta[0]->id." and e.id_empresa=".Auth::user()->id_empresa);

          $detalle_venta=DB::select("
                      SELECT dv.*, p.nombre
                      from detalle_venta dv, producto p
                      where p.id=dv.id_producto and  dv.id_nota_venta=".$id ." and dv.id_empresa= ".Auth::user()->id_empresa);

          $formatter = new NumeroALetras();
          $numeroLetra=ucfirst(strtolower($formatter->toInvoice($nota_venta[0]->monto_total, 2,'Bolivianos')));

$customPaper = array(0,0,567.00,226.77);
//$customPaper = array(0,0,0,0);
        $pdf=\PDF::loadView('nota_venta.imprimir_ticket',  [
          'nota_venta'=>$nota_venta,
          'detalle_venta'=>$detalle_venta,
          'empresa'=>$empresa,
          'sucursal'=>$sucursal,
          'factura'=>$factura,
          'numeroLetra'=>$numeroLetra
        ])->setPaper($customPaper, 'landscape');

        $pdfContent = $pdf->output(); // Obtener el contenido del PDF como una cadena binaria

        // Convertir la cadena binaria a Base64
        $base64 = base64_encode($pdfContent);

        return $base64;
    }

    public function nota_venta_imprimir_pequenio_ticket_cocina_base_64($id){

      $empresa=DB::select("SELECT * from empresa e where e.id=".Auth::user()->id_empresa);

          $nota_venta=DB::select("SELECT nc.*, a.usuario
          from nota_venta nc,  users a
          where nc.id_usuario = a.id  and nc.id=".$id." and  nc.id_empresa= ".Auth::user()->id_empresa);

          $sucursal=DB::select("SELECT * from sucursal e where  e.id_empresa=".Auth::user()->id_empresa);
          $factura=DB::select("SELECT * from factura e where e.id_nota_venta=".$nota_venta[0]->id." and e.id_empresa=".Auth::user()->id_empresa);

          $detalle_venta=DB::select("
                      SELECT dv.*, p.nombre
                      from detalle_venta dv, producto p
                      where p.id=dv.id_producto and  dv.id_nota_venta=".$id ." and dv.id_empresa= ".Auth::user()->id_empresa);

          $formatter = new NumeroALetras();
          $numeroLetra=ucfirst(strtolower($formatter->toInvoice($nota_venta[0]->monto_total, 2,'Bolivianos')));

$customPaper = array(0,0,567.00,226.77);
//$customPaper = array(0,0,0,0);
        $pdf=\PDF::loadView('nota_venta.imprimir_ticket_cocina',  [
          'nota_venta'=>$nota_venta,
          'detalle_venta'=>$detalle_venta,
          'empresa'=>$empresa,
          'sucursal'=>$sucursal,
          'factura'=>$factura,
          'numeroLetra'=>$numeroLetra
        ])->setPaper($customPaper, 'landscape');

        $pdfContent = $pdf->output(); // Obtener el contenido del PDF como una cadena binaria

        // Convertir la cadena binaria a Base64
        $base64 = base64_encode($pdfContent);

        return $base64;
    }

    public function get_nota_venta_por_id($id){
        $nota_venta=DB::select("SELECT nc.*, a.usuario
          from nota_venta nc,  users a
          where nc.id_usuario = a.id  and nc.id=".$id. " and nc.id_empresa= ".Auth::user()->id_empresa);
          $detalle_venta=DB::select("
                      SELECT dv.*, p.nombre
                      from detalle_venta dv, producto p
                      where p.id=dv.id_producto and  dv.id_nota_venta=".$id);
        return response([
          'nota_venta'=>$nota_venta,
          'detalle_venta'=>$detalle_venta
        ]);
    }

      //CODIGO PARA AJAX  REGISTRAR UN NUEVO USUARIO

    function cancelar_nota_venta(Request $request){
        $mensaje="No se realizo la cancelaci��n";
        $id=$request['id'];

            try{
            DB::beginTransaction();

             DB::table("nota_venta")
             ->whereRaw('id='.$id)
             ->update(['estado'=>'Cancelado']);

$detalle_venta=DB::select("SELECT * from detalle_venta where id_nota_venta=".$id);

       foreach ($detalle_venta as $key => $value) {
            DB::table('producto')
                    ->where('id',$value->id_producto)
                    ->update([
                      'peso'=>DB::raw('peso + '.$value->peso)
                    ]);
        }
        $mensaje="Se realizo la cancelaci��n";

             DB::commit();
          } catch (Exception $e) {
            DB::rollback();

              }

       return view("mensajes.msj_rechazado")->with("msj",$mensaje);
      }


  public function rendimiento()
    {

       return view('nota_venta.rendimiento' );
    }



   public function get_venta_estadistica_anio($anio){
        $anio = (int) $anio;
        // Rango [anio-01-01, anio+1-01-01) para poder usar el índice (id_empresa, fecha)
        $nota_venta=DB::select("SELECT
            MONTH(fecha) AS 'mes',
            SUM(CASE WHEN estado IN ('Procesado','Qr','QrFie') THEN monto_total ELSE 0 END) AS 'monto_venta',
            SUM(CASE WHEN estado = 'Cancelado' THEN monto_total ELSE 0 END) AS 'monto_cancelado',
            COUNT(CASE WHEN estado IN ('Procesado','Qr','QrFie') THEN 1 ELSE NULL END) AS 'cantidad_venta',
            COUNT(CASE WHEN estado = 'Cancelado' THEN 1 ELSE NULL END) AS 'cantidad_cancelado'
        FROM
            nota_venta
        WHERE
            id_empresa = ".Auth::user()->id_empresa."
            AND fecha >= '".$anio."-01-01' AND fecha < '".($anio + 1)."-01-01'
        GROUP BY
            MONTH(fecha)
        ORDER BY
            mes ASC");
        return response($nota_venta);
    }


    public  function nota_venta_historial($fechaInicio,$fechaFinal)
    {
          $nota_venta=DB::select("SELECT nc.*, a.usuario
          from nota_venta nc,  users a
          where
          nc.id_usuario = a.id  and  date(nc.fecha) between date('".$fechaInicio."') and date('".$fechaFinal."') and nc.id_empresa=".Auth::user()->id_empresa);

       return view('nota_venta.historial',[
        'nota_venta'=>$nota_venta,
        'fechaInicio'=>$fechaInicio,
        'fechaFinal'=>$fechaFinal
         ]);
    }


    public  function nota_venta_historial_imprimir($fechaInicio,$fechaFinal)
    {
          $nota_venta=DB::select("SELECT nc.*, a.usuario
          from nota_venta nc,  users a
          where
          nc.id_usuario = a.id  and  date(nc.fecha) between date('".$fechaInicio."') and date('".$fechaFinal."')
          and nc.estado='Procesado'  and nc.id_empresa=".Auth::user()->id_empresa);

          $empresa=DB::select("SELECT * from empresa  where id='".Auth::user()->id_empresa."'");

         $pdf=\PDF::loadView('nota_venta.historial_imprimir',[
          'nota_venta'=>$nota_venta,
          'fechaInicio'=>$fechaInicio,
          'fechaFinal'=>$fechaFinal,
          'empresa'=>$empresa
           ]);
        return   $pdf->stream();


    }

    public  function nota_venta_historial_por_dia_imprimir($fechaInicio,$fechaFinal)
    {
          $nota_venta=DB::select("SELECT
          DATE(nc.fecha) AS fecha,
          SUM(nc.monto_total) AS monto_total,
          nc.estado
          from nota_venta nc,  users a
          where
          nc.id_usuario = a.id  and  date(nc.fecha) between date('".$fechaInicio."') and date('".$fechaFinal."')
          and nc.estado in ('Procesado','Qr','QrFie')   and nc.id_empresa=".Auth::user()->id_empresa." GROUP BY
          DATE(nc.fecha),
          nc.estado
      ORDER BY
          DATE(nc.fecha)");

          $empresa=DB::select("SELECT * from empresa  where id='".Auth::user()->id_empresa."'");

         $pdf=\PDF::loadView('nota_venta.historial_por_dia_imprimir',[
          'nota_venta'=>$nota_venta,
          'fechaInicio'=>$fechaInicio,
          'fechaFinal'=>$fechaFinal,
          'empresa'=>$empresa
           ]);
        return   $pdf->stream();
  /*return view('nota_venta.historial_por_dia_imprimir',[
          'nota_venta'=>$nota_venta,
          'fechaInicio'=>$fechaInicio,
          'fechaFinal'=>$fechaFinal,
          'empresa'=>$empresa
           ]);*/

    }

  public function est_result_imp($fechaInicio,$fechaFinal){

      $id_empresa = Auth::user()->id_empresa;
      $fin = date('Y-m-d', strtotime($fechaFinal.' +1 day')); // rango [inicio, fin) para usar el indice de fecha

      // NOTA DE VENTA: total por producto y estado en el rango
      $nota_venta = DB::select("
          SELECT nc.estado, p.nombre,
                 SUM(dc.peso) AS peso_venta,
                 SUM(dc.sub_total) AS monto_total
          FROM nota_venta nc
          JOIN detalle_venta dc ON dc.id_nota_venta = nc.id
          JOIN producto p ON p.id = dc.id_producto
          WHERE nc.id_empresa = ".$id_empresa."
            AND nc.fecha >= '".$fechaInicio."' AND nc.fecha < '".$fin."'
          GROUP BY nc.estado, p.id, p.nombre
          ORDER BY nc.estado, p.nombre");

      // NOTA DE COMPRA
      $nota_compra = DB::select("
          SELECT nc.estado, p.nombre,
                 SUM(dc.peso) AS peso_venta,
                 SUM(dc.sub_total) AS monto_total
          FROM nota_compra nc
          JOIN detalle_compra dc ON dc.id_nota_compra = nc.id
          JOIN producto p ON p.id = dc.id_producto
          WHERE nc.id_empresa = ".$id_empresa."
            AND nc.fecha >= '".$fechaInicio."' AND nc.fecha < '".$fin."'
          GROUP BY nc.estado, p.id, p.nombre
          ORDER BY nc.estado, p.nombre");
   
  // GASTOS
  $gasto = DB::select("SELECT  t.nombre , sum(g.precio_gasto) as monto_total  from gasto g, tipo_gasto t
  where g.id_tipo_gasto =t.id  
  and date(g.fecha) between date('".$fechaInicio."') and date('".$fechaFinal."') 
  and g.id_empresa=" . Auth::user()->id_empresa . " group by t.nombre ");
  
   
      $empresa = DB::select("SELECT * from empresa  where id='" . Auth::user()->id_empresa . "'");
  
      $pdf = \PDF::loadView('nota_venta.estado_resultado_imprimir', [
        'nota_venta' => $nota_venta,
        'nota_compra' => $nota_compra,
        'gasto' => $gasto,
        'empresa' => $empresa,
        'fecha_inicio'=>$fechaInicio,
        'fecha_final'=>$fechaFinal
      ])->setPaper('letter', 'portrait');

      return $pdf->stream('estado-resultado_'.$fechaInicio.'_'.$fechaFinal.'.pdf');
    }

    public  function imprimir_factura($id)
    {

      $empresa=DB::select("SELECT * from empresa e where e.id=".Auth::user()->id_empresa);

          $nota_venta=DB::select("SELECT nc.*, a.usuario
          from nota_venta nc,  users a
          where nc.id_usuario = a.id  and nc.id=".$id . " and  and nc.id_empresa=".Auth::user()->id_empresa);
          $detalle_venta=DB::select("
                      SELECT dv.*, p.nombre
                      from detalle_venta dv, producto p
                      where p.id=dv.id_producto and  dv.id_nota_venta=".$id."  and dv.id_empresa=".Auth::user()->id_empresa);

          $formatter = new NumeroALetras();
          $numeroLetra=ucfirst(strtolower($formatter->toInvoice($nota_venta[0]->monto_total, 2)).'Bolivianos');


      $empresa=DB::select("SELECT * from empresa  where id='".Auth::user()->id_empresa."'");

      $data ='casa';

      $pdf=\PDF::loadView('nota_venta.imprimir_factura',[
        'nota_venta'=>$nota_venta,
        'detalle_venta'=>$detalle_venta,
        'empresa'=>$empresa,
        'numeroLetra'=>$numeroLetra
      ]);
      return   $pdf->stream();
    }


    public  function actualizar_estado_nota_venta(Request $request){
      DB::beginTransaction();

        try {

           $pedido = DB::table('nota_venta')
           ->where('id',$request['id_nota_venta'])
           ->update([
                  'estado'=>$request['estado'],
            ]);
                DB::commit();
               return redirect('/nota_venta')->with("message","SE ACTUALIZO CORRECTAMENTE");

        } catch (Exception $e) {
          DB::rollback();
          return redirect('/nota_venta')->with("message-error","ERROR INTENTE NUEVAMENTE");
        }

      }

      public function get_nota_venta_por_id_producto($id,$fechaInicio,$fechaFinal){
        $detalle_venta=DB::select("SELECT nc.id,
            nc.fecha,
            a.usuario,
            nc.ci_nit,
            nc.razon_social,
            dc.peso,
            dc.precio_unidad,
            dc.sub_total
            from nota_venta nc, users a, detalle_venta dc
            where nc.id=dc.id_nota_venta
            and nc.id_usuario = a.id
            and  date(nc.fecha) between date('".$fechaInicio."') and date('".$fechaFinal."')
            and dc.id_producto=".$id);
        return response([
          'detalle_venta'=>$detalle_venta
        ]);
    }


    public  function nota_venta_historial_por_producto($fechaInicio,$fechaFinal,$id_producto)
    {
      $sql="";

      $nota_venta="";
          if($id_producto==0){

            $sql="SELECT p.*,tp.nombre as nombre_tipo_producto,(select sum(dcc.peso) from detalle_venta dcc, nota_venta ncc
            where dcc.id_producto=p.id
            and dcc.id_nota_venta=ncc.id
            and ncc.id_empresa=".Auth::user()->id_empresa."
            and date(ncc.fecha)  between date('".$fechaInicio."') and date('".$fechaFinal."') ) as peso_venta,
            (select sum(dcc.sub_total) from detalle_venta dcc, nota_venta ncc
            where dcc.id_producto=p.id
            and dcc.id_nota_venta=ncc.id
            and ncc.id_empresa=".Auth::user()->id_empresa."
            and date(ncc.fecha)  between date('".$fechaInicio."') and date('".$fechaFinal."') ) as sub_total
             from producto p, detalle_venta dc, nota_venta nc, tipo_producto tp
            where p.id_tipo_producto=tp.id
            and dc.id_producto=p.id
            and nc.id=dc.id_nota_venta
            and date(nc.fecha) between date('".$fechaInicio."') and date('".$fechaFinal."')
            and nc.id_empresa=".Auth::user()->id_empresa. " group by p.id";

          }else{
            $sql="SELECT p.*,tp.nombre as nombre_tipo_producto,(select sum(dcc.peso) from detalle_venta dcc, nota_venta ncc
            where dcc.id_producto=p.id
            and dcc.id_nota_venta=ncc.id
            and ncc.id_empresa=".Auth::user()->id_empresa."
            and date(ncc.fecha)  between date('".$fechaInicio."') and date('".$fechaFinal."') ) as peso_venta,
            (select sum(dcc.sub_total) from detalle_venta dcc, nota_venta ncc
            where dcc.id_producto=p.id
            and dcc.id_nota_venta=ncc.id
            and ncc.id_empresa=".Auth::user()->id_empresa."
            and date(ncc.fecha)  between date('".$fechaInicio."') and date('".$fechaFinal."') ) as sub_total
             from producto p, detalle_venta dc, nota_venta nc, tipo_producto tp
            where p.id_tipo_producto=tp.id
            and dc.id_producto=p.id
            and nc.id=dc.id_nota_venta
            and p.id=".$id_producto."
            and date(nc.fecha) between date('".$fechaInicio."') and date('".$fechaFinal."')
            and nc.id_empresa=".Auth::user()->id_empresa. " group by p.id";
          }
        $nota_venta=DB::select($sql);
        $producto=DB::select("SELECT p.* from producto p where p.id_empresa=".Auth::user()->id_empresa);

        // echo $sql;
       return view('nota_venta.historial_por_producto',[
          'nota_venta'=>$nota_venta,
          'fechaInicio'=>$fechaInicio,
          'fechaFinal'=>$fechaFinal,
          'id_producto'=>$id_producto,
          'producto'=>$producto,
          'sql'=> $sql,
           ]);

    }

    public  function nota_venta_historial_por_producto_imprimir($fechaInicio,$fechaFinal,$id_producto)
    {
     $sql="";

      $nota_venta="";
          if($id_producto==0){

            $sql="SELECT p.*,tp.nombre as nombre_tipo_producto,(select sum(dcc.peso) from detalle_venta dcc, nota_venta ncc
            where dcc.id_producto=p.id
            and dcc.id_nota_venta=ncc.id
            and ncc.id_empresa=".Auth::user()->id_empresa."
            and date(ncc.fecha)  between date('".$fechaInicio."') and date('".$fechaFinal."') ) as peso_venta,
            (select sum(dcc.sub_total) from detalle_venta dcc, nota_venta ncc
            where dcc.id_producto=p.id
            and dcc.id_nota_venta=ncc.id
            and ncc.id_empresa=".Auth::user()->id_empresa."
            and date(ncc.fecha)  between date('".$fechaInicio."') and date('".$fechaFinal."') ) as sub_total
             from producto p, detalle_venta dc, nota_venta nc, tipo_producto tp
            where p.id_tipo_producto=tp.id
            and dc.id_producto=p.id
            and nc.id=dc.id_nota_venta
            and date(nc.fecha) between date('".$fechaInicio."') and date('".$fechaFinal."')
            and nc.id_empresa=".Auth::user()->id_empresa. " group by p.id";

          }else{
            $sql="SELECT p.*,tp.nombre as nombre_tipo_producto,(select sum(dcc.peso) from detalle_venta dcc, nota_venta ncc
            where dcc.id_producto=p.id
            and dcc.id_nota_venta=ncc.id
            and ncc.id_empresa=".Auth::user()->id_empresa."
            and date(ncc.fecha)  between date('".$fechaInicio."') and date('".$fechaFinal."') ) as peso_venta,
            (select sum(dcc.sub_total) from detalle_venta dcc, nota_venta ncc
            where dcc.id_producto=p.id
            and dcc.id_nota_venta=ncc.id
            and ncc.id_empresa=".Auth::user()->id_empresa."
            and date(ncc.fecha)  between date('".$fechaInicio."') and date('".$fechaFinal."') ) as sub_total
             from producto p, detalle_venta dc, nota_venta nc, tipo_producto tp
            where p.id_tipo_producto=tp.id
            and dc.id_producto=p.id
            and nc.id=dc.id_nota_venta
            and p.id=".$id_producto."
            and date(nc.fecha) between date('".$fechaInicio."') and date('".$fechaFinal."')
            and nc.id_empresa=".Auth::user()->id_empresa. " group by p.id";
          }
        $nota_venta=DB::select($sql);

         $empresa=DB::select("SELECT * from empresa  where id='".Auth::user()->id_empresa."'");

         $pdf=\PDF::loadView('nota_venta.historial_por_producto_imprimir',[
          'nota_venta'=>$nota_venta,
          'fechaInicio'=>$fechaInicio,
          'fechaFinal'=>$fechaFinal,
          'id_producto'=>$id_producto,
          'empresa'=>$empresa
           ]);
        return   $pdf->stream();
    }





}
