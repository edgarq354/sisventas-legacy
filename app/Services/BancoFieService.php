<?php

namespace App\Services;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Cobro con QR de Banco FIE (sip.mc4.com.bo).
 *
 * Flujo (ver database/sql/2026_08_28_add_bancofie_qr_to_empresa.sql):
 *   1) /autenticacion/login        -> token (dura ~24h). Se cachea en
 *                                     empresa.bancofie_token / bancofie_token_expira
 *                                     y se renueva solo.
 *   2) /operaciones/generaQr       -> crea la transaccion. El "imagenQr" que
 *                                     devuelve NO es la imagen real.
 *   3) /transaccion/obtenerMensajeCifrado -> imagen PNG real en base64.
 *   4) /transaccion/verificaTransaccion   -> estadoPago (PAGADO cuando ya pagaron).
 *
 * Las credenciales van por empresa: bancofie_usuario, bancofie_password
 * (encriptada con Crypt), bancofie_id_servicio, bancofie_callback.
 */
class BancoFieService
{
    /** @var object Fila de la tabla `empresa` */
    private object $empresa;

    public function __construct(object $empresa)
    {
        $this->empresa = $empresa;
    }

    /** La empresa tiene el cobro QR Banco FIE habilitado y configurado. */
    public function configurada(): bool
    {
        return (int) ($this->empresa->pago_qr_bancofie ?? 0) === 1
            && !empty($this->empresa->bancofie_usuario)
            && !empty($this->empresa->bancofie_password)
            && !empty($this->empresa->bancofie_id_servicio);
    }

    // ── Genera el QR para una venta ───────────────────────────────────────
    public function generarQr(float $monto, string $alias, string $glosa): array
    {
        $token = $this->token();
        if ($token === null) {
            return ['ok' => false, 'mensaje' => 'No se pudo autenticar con Banco FIE.'];
        }

        $resp = $this->http($token)->post('/operaciones/generaQr', [
            'alias' => $alias !== '' ? $alias : 'Venta',
            'callback' => $this->empresa->bancofie_callback ?: '',
            'detalleGlosa' => $glosa !== '' ? $glosa : 'Venta',
            'tipoSolicitud' => 'PLATAFORMA',
            'fechaVencimiento' => date('d/m/Y'),
            'montoVariable' => false,
            'unicoUso' => true,
            'idServicio' => (int) $this->empresa->bancofie_id_servicio,
            'moneda' => 'BOB',
            'monto' => round($monto, 2),
        ]);

        $data = $resp->json();
        if (!$resp->ok() || ($data['codigo'] ?? '') !== 'OK') {
            return ['ok' => false, 'mensaje' => $data['mensaje'] ?? 'Error al generar el QR con Banco FIE.'];
        }

        $obj = $data['objeto'];
        $idTransaccion = (int) $obj['idTransaccion'];

        // La imagen real siempre se pide por separado.
        $imagenQr = $this->obtenerImagen($token, $idTransaccion);
        if ($imagenQr === null) {
            return ['ok' => false, 'mensaje' => 'El QR se generó pero no se pudo obtener la imagen.', 'idTransaccion' => $idTransaccion];
        }

        return [
            'ok' => true,
            'idTransaccion' => $idTransaccion,
            'idQr' => $obj['idQr'] ?? null,
            'imagenQr' => $imagenQr,
            'monto' => round($monto, 2),
            'moneda' => 'BOB',
            'fechaVencimiento' => $obj['fechaVencimiento'] ?? null,
            'bancoDestino' => $obj['bancoDestino'] ?? null,
            'cuentaDestino' => $obj['cuentaDestino'] ?? null,
        ];
    }

    // ── Consulta el estado de pago de una transaccion ────────────────────
    public function verificar(int $idTransaccion): array
    {
        $token = $this->token();
        if ($token === null) {
            return ['ok' => false, 'mensaje' => 'No se pudo autenticar con Banco FIE.'];
        }

        $resp = $this->http($token)->post('/transaccion/verificaTransaccion?=null', [
            'idTransaccion' => $idTransaccion,
        ]);

        $data = $resp->json();
        if (!$resp->ok() || ($data['codigo'] ?? '') !== 'OK') {
            return ['ok' => false, 'mensaje' => $data['mensaje'] ?? 'Error al verificar la transacción.'];
        }

        $obj = $data['objeto'];

        return [
            'ok' => true,
            'idTransaccion' => (int) $obj['id'],
            'estadoPago' => $obj['estadoPago'] ?? null,
            'pagado' => ($obj['estadoPago'] ?? '') === 'PAGADO',
            'monto' => $obj['monto'] ?? null,
            'clienteRef' => $obj['clienteRef'] ?? null,
            'fechaPago' => $obj['fechaPago'] ?? null,
        ];
    }

    // ── Imagen QR real (base64 PNG) ──────────────────────────────────────
    private function obtenerImagen(string $token, int $idTransaccion): ?string
    {
        $resp = $this->http($token)->get('/transaccion/obtenerMensajeCifrado', [
            'idTransaccion' => $idTransaccion,
        ]);
        $data = $resp->json();
        if (!$resp->ok() || ($data['codigo'] ?? '') !== 'OK') {
            return null;
        }
        return is_string($data['objeto'] ?? null) ? $data['objeto'] : null;
    }

    // ── Token valido: reusa el cache de la empresa mientras no expire ────
    private function token(): ?string
    {
        $tokenCache = $this->empresa->bancofie_token ?? null;
        $expira = $this->empresa->bancofie_token_expira ?? null;

        if (!empty($tokenCache) && !empty($expira)) {
            try {
                // margen de 5 min antes de que expire
                if (new \DateTime($expira) > (new \DateTime())->modify('+5 minutes')) {
                    return $tokenCache;
                }
            } catch (\Throwable $e) {
                // fecha corrupta -> se renueva
            }
        }

        return $this->login();
    }

    // ── Login y cacheo del token en la fila de la empresa ───────────────
    private function login(): ?string
    {
        try {
            $password = Crypt::decryptString($this->empresa->bancofie_password);
        } catch (\Throwable $e) {
            Log::warning('BancoFie: no se pudo desencriptar bancofie_password de empresa ' . $this->empresa->id);
            return null;
        }

        $resp = $this->http(null)->post('/autenticacion/login', [
            'username' => $this->empresa->bancofie_usuario,
            'password' => $password,
            'remember' => true,
        ]);

        $data = $resp->json();
        if (!$resp->ok() || ($data['codigo'] ?? '') !== 'OK') {
            Log::warning('BancoFie login falló para empresa ' . $this->empresa->id . ': ' . ($data['mensaje'] ?? $resp->status()));
            return null;
        }

        $token = $data['objeto']['token'];
        $fechaExpiracion = $data['objeto']['fechaExpiracion'] ?? null; // "d/m/Y H:i:s"

        $expiraMysql = null;
        if ($fechaExpiracion) {
            $f = \DateTime::createFromFormat('d/m/Y H:i:s', $fechaExpiracion);
            $expiraMysql = $f ? $f->format('Y-m-d H:i:s') : null;
        }

        DB::table('empresa')->where('id', $this->empresa->id)->update([
            'bancofie_token' => $token,
            'bancofie_token_expira' => $expiraMysql,
        ]);
        $this->empresa->bancofie_token = $token;
        $this->empresa->bancofie_token_expira = $expiraMysql;

        return $token;
    }

    // ── Cliente HTTP base ───────────────────────────────────────────────
    private function http(?string $token)
    {
        $req = Http::baseUrl(config('services.bancofie.base_url'))
            ->timeout((int) config('services.bancofie.timeout', 20))
            ->acceptJson()
            ->withHeaders(['Content-Type' => 'application/json']);

        if (!config('services.bancofie.verify_ssl', true)) {
            $req = $req->withoutVerifying();
        }
        if ($token !== null) {
            $req = $req->withToken($token);
        }

        return $req;
    }
}
