<?php

namespace App\Http\Controllers;

use App\Services\BancoFieService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * Endpoints AJAX para el cobro con QR de Banco FIE desde nota_venta/create.
 *
 *   POST nota_venta/bancofie/generar  -> genera el QR de una venta
 *   POST nota_venta/bancofie/estado   -> consulta si ya se pagó
 *
 * El registro definitivo de la venta lo sigue haciendo NotaVentaController@store
 * (que además re-verifica el pago server-side antes de guardar).
 */
class BancoFieQrController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    private function empresaActual(): ?object
    {
        $rows = DB::select('SELECT * FROM empresa WHERE id = ? LIMIT 1', [Auth::user()->id_empresa]);
        return $rows[0] ?? null;
    }

    public function generar(Request $request)
    {
        $monto = (float) $request->input('monto', 0);
        $nombre = trim((string) $request->input('alias', ''));
        $glosa = trim((string) $request->input('glosa', 'Venta'));

        if ($monto <= 0) {
            return response()->json(['suceso' => '2', 'mensaje' => 'El monto total debe ser mayor a 0.']);
        }

        // Banco FIE exige que el alias sea único ("El Alias ingresado ya existe"),
        // así que le agregamos un sufijo de fecha/hora + aleatorio.
        $base = $nombre !== '' ? mb_substr($nombre, 0, 90) : 'Venta';
        $alias = $base . ' ' . now()->format('ymdHis') . mt_rand(10, 99);

        $empresa = $this->empresaActual();
        if ($empresa === null) {
            return response()->json(['suceso' => '2', 'mensaje' => 'No se encontró la empresa.']);
        }

        $service = new BancoFieService($empresa);
        if (!$service->configurada()) {
            return response()->json(['suceso' => '2', 'mensaje' => 'La empresa no tiene configurado el cobro con QR de Banco FIE. Actívelo en Empresa → editar.']);
        }

        $r = $service->generarQr($monto, $alias, $glosa);
        if (empty($r['ok'])) {
            return response()->json(['suceso' => '2', 'mensaje' => $r['mensaje'] ?? 'No se pudo generar el QR.']);
        }

        // Nota: la imagen del QR (base64) NO se guarda en BD; solo se devuelve
        // en esta respuesta para mostrarla en el navegador.
        DB::table('transaccion_qr_bancofie')->updateOrInsert(
            ['id_transaccion' => $r['idTransaccion']],
            [
                'id_qr' => $r['idQr'],
                'id_empresa' => Auth::user()->id_empresa,
                'id_usuario_registro' => Auth::user()->id,
                'origen' => 'NOTA_VENTA',
                'alias' => $alias !== '' ? $alias : 'Venta',
                'detalle_glosa' => $glosa,
                'moneda' => 'BOB',
                'monto' => $r['monto'],
                'id_servicio' => (int) $empresa->bancofie_id_servicio,
                'banco_destino' => $r['bancoDestino'],
                'cuenta_destino' => $r['cuentaDestino'],
                'fecha_vencimiento' => $this->fechaDmyAMysql($r['fechaVencimiento']),
                'estado_pago' => 'PENDIENTE',
            ]
        );

        return response()->json([
            'suceso' => '1',
            'mensaje' => 'QR generado.',
            'idTransaccion' => $r['idTransaccion'],
            'idQr' => $r['idQr'],
            'alias' => $alias,
            'imagenQr' => $r['imagenQr'],
            'monto' => $r['monto'],
            'moneda' => 'BOB',
            'bancoDestino' => $r['bancoDestino'],
            'cuentaDestino' => $r['cuentaDestino'],
            'fechaVencimiento' => $r['fechaVencimiento'],
        ]);
    }

    public function estado(Request $request)
    {
        $idTransaccion = (int) $request->input('idTransaccion', 0);
        if ($idTransaccion <= 0) {
            return response()->json(['suceso' => '2', 'mensaje' => 'Falta el idTransaccion.']);
        }

        // La transacción debe pertenecer a la empresa del cajero.
        $fila = DB::table('transaccion_qr_bancofie')
            ->where('id_transaccion', $idTransaccion)
            ->where('id_empresa', Auth::user()->id_empresa)
            ->first();
        if ($fila === null) {
            return response()->json(['suceso' => '2', 'mensaje' => 'Transacción no encontrada.']);
        }

        $empresa = $this->empresaActual();
        $r = (new BancoFieService($empresa))->verificar($idTransaccion);
        if (empty($r['ok'])) {
            return response()->json(['suceso' => '2', 'mensaje' => $r['mensaje'] ?? 'No se pudo verificar el pago.']);
        }

        DB::table('transaccion_qr_bancofie')->where('id_transaccion', $idTransaccion)->update([
            'estado_pago' => $r['estadoPago'] ?? 'PENDIENTE',
            'cliente_ref' => $r['clienteRef'],
            'fecha_pago' => $this->fechaIsoAMysql($r['fechaPago']),
            'fecha_verificacion' => now(),
        ]);

        return response()->json([
            'suceso' => '1',
            'idTransaccion' => $idTransaccion,
            'estadoPago' => $r['estadoPago'],
            'pagado' => (bool) $r['pagado'],
        ]);
    }

    private function fechaDmyAMysql(?string $dmy): ?string
    {
        if (empty($dmy)) {
            return null;
        }
        $f = \DateTime::createFromFormat('d/m/Y', $dmy);
        return $f ? $f->format('Y-m-d') : null;
    }

    private function fechaIsoAMysql(?string $iso): ?string
    {
        if (empty($iso)) {
            return null;
        }
        try {
            return (new \DateTime($iso))->format('Y-m-d H:i:s');
        } catch (\Throwable $e) {
            return null;
        }
    }
}
