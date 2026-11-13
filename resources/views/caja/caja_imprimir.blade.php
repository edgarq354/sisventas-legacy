<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<style type="text/css">
    * { box-sizing: border-box; }
    body { font-family: "DejaVu Sans", sans-serif; font-size: 10px; color: #2b2b2b; margin: 0; }
    .wrap { padding: 4px 2px; }

    .head-table { width: 100%; border-collapse: collapse; margin-bottom: 4px; }
    .head-table td { vertical-align: top; padding: 0; border: 0; }
    .brand-name { font-size: 14px; font-weight: bold; color: #c62828; }
    .brand-sub { font-size: 9px; color: #555; line-height: 1.5; }
    .doc-title {
        font-size: 13px; font-weight: bold; letter-spacing: 1px; color: #fff;
        background: #c62828; padding: 5px 12px; display: inline-block; border-radius: 3px;
    }
    .doc-sub { font-size: 9px; color: #555; margin-top: 4px; }
    .rule { border: 0; border-top: 2px solid #ef6c00; margin: 6px 0 10px; }

    table.grid { width: 100%; border-collapse: collapse; }
    table.grid th {
        background: #c62828; color: #fff; font-size: 8.5px; text-transform: uppercase; letter-spacing: .3px;
        padding: 6px 6px; text-align: left; border: 1px solid #c62828;
    }
    table.grid td { padding: 4px 6px; border: 1px solid #e3ddd6; }
    table.grid tbody tr:nth-child(even) td { background: #fbf7f3; }
    .num { text-align: right; white-space: nowrap; }
    .tot td { background: #f1e9e2 !important; font-weight: bold; border-color: #ddd2c7; }
    .pill { display: inline-block; padding: 1px 7px; border-radius: 999px; font-size: 8px; font-weight: bold; }
    .pill--on { background: rgba(46,125,50,.15); color: #2e7d32; }
    .pill--off { background: rgba(198,40,40,.15); color: #c62828; }
    .foot { margin-top: 12px; font-size: 8px; color: #9a9a9a; text-align: right; }
</style>
</head>
<body onload="window.print();">
@php
    $fmt = fn($n) => number_format((float) $n, 2, '.', ',');
    $meses_es = ['','enero','febrero','marzo','abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre','diciembre'];
    $tAbrir = $tEfe = $tQr = $tTotal = 0;
    foreach ($caja as $c) {
        $tAbrir += (float) $c->monto_abrir + (float) ($c->monto_abrir_qr ?? 0);
        if ($c->estado == 'Cerrada') {
            $tEfe   += (float) $c->monto_cierre;
            $tQr    += (float) ($c->monto_cierre_qr ?? 0);
            $tTotal += (float) ($c->monto_cierre_total ?? 0);
        }
    }
@endphp
<div class="wrap">

    <table class="head-table">
        <tr>
            <td style="width: 62%;">
                @if(!empty($empresa[0]->direccion_logo) && file_exists(public_path($empresa[0]->direccion_logo)))
                    <img src="{{ public_path($empresa[0]->direccion_logo) }}" style="height: 40px; margin-bottom: 3px;"><br>
                @endif
                <span class="brand-name">{{ $empresa[0]->razon_social }}</span>
                <div class="brand-sub">
                    @if(!empty($empresa[0]->nit))NIT: {{ $empresa[0]->nit }}<br>@endif
                    @if(!empty($empresa[0]->whatsapp))Tel: {{ $empresa[0]->whatsapp }}<br>@endif
                    @if(!empty($empresa[0]->direccion)){{ $empresa[0]->direccion }}@endif
                </div>
            </td>
            <td style="width: 38%; text-align: right;">
                <span class="doc-title">HISTORIAL DE CAJAS</span>
                <div class="doc-sub">{{ count($caja) }} registros</div>
            </td>
        </tr>
    </table>

    <hr class="rule">

    <table class="grid">
        <thead>
            <tr>
                <th style="width: 34px;">ID</th>
                <th>Usuario</th>
                <th>Caja</th>
                <th class="num">Abrir</th>
                <th class="num">Abrir QR</th>
                <th class="num">Cierre efec.</th>
                <th class="num">Cierre QR</th>
                <th class="num">Cierre total</th>
                <th>Abierto</th>
                <th>Cerrado</th>
                <th style="text-align:center;">Estado</th>
            </tr>
        </thead>
        <tbody>
            @forelse($caja as $usr)
                <tr>
                    <td>{{ $usr->id }}</td>
                    <td>{{ $usr->usuario }}</td>
                    <td>{{ $usr->caja }}</td>
                    <td class="num">{{ $fmt($usr->monto_abrir) }}</td>
                    <td class="num">{{ $fmt($usr->monto_abrir_qr ?? 0) }}</td>
                    <td class="num">{{ $usr->estado == 'Cerrada' ? $fmt($usr->monto_cierre) : '—' }}</td>
                    <td class="num">{{ $usr->estado == 'Cerrada' ? $fmt($usr->monto_cierre_qr ?? 0) : '—' }}</td>
                    <td class="num">{{ $usr->estado == 'Cerrada' ? $fmt($usr->monto_cierre_total ?? 0) : '—' }}</td>
                    <td>{{ $usr->fecha_abrir }}</td>
                    <td>{{ $usr->fecha_cierre ?: '—' }}</td>
                    <td style="text-align:center;">
                        <span class="pill {{ $usr->estado == 'Abierta' ? 'pill--on' : 'pill--off' }}">{{ $usr->estado }}</span>
                    </td>
                </tr>
            @empty
                <tr><td colspan="11" style="text-align:center;color:#999;padding:14px;">Sin registros de caja</td></tr>
            @endforelse

            <tr class="tot">
                <td colspan="3">Totales (cierres)</td>
                <td colspan="2" class="num">Apertura: {{ $fmt($tAbrir) }}</td>
                <td class="num">{{ $fmt($tEfe) }}</td>
                <td class="num">{{ $fmt($tQr) }}</td>
                <td class="num">{{ $fmt($tTotal) }}</td>
                <td colspan="3"></td>
            </tr>
        </tbody>
    </table>

    <div class="foot">
        Generado el {{ date('j') }} de {{ $meses_es[(int) date('n')] }} de {{ date('Y') }}, {{ date('H:i') }}
    </div>

</div>
</body>
</html>
