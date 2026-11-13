<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<style type="text/css">
    * { box-sizing: border-box; }
    body {
        font-family: "DejaVu Sans", sans-serif;
        font-size: 11px;
        color: #2b2b2b;
        margin: 0;
    }
    .wrap { padding: 4px 2px; }

    /* Encabezado */
    .head-table { width: 100%; border-collapse: collapse; margin-bottom: 4px; }
    .head-table td { vertical-align: top; padding: 0; border: 0; }
    .brand-name { font-size: 15px; font-weight: bold; color: #c62828; }
    .brand-sub { font-size: 10px; color: #555; line-height: 1.5; }
    .doc-box {
        text-align: right;
    }
    .doc-title {
        font-size: 14px; font-weight: bold; letter-spacing: 1px;
        color: #fff; background: #c62828; padding: 5px 12px; display: inline-block;
        border-radius: 3px;
    }
    .doc-range { font-size: 10px; color: #555; margin-top: 5px; }

    .rule { border: 0; border-top: 2px solid #ef6c00; margin: 6px 0 12px; }

    /* Tabla principal */
    .fin { width: 100%; border-collapse: collapse; }
    .fin th {
        background: #c62828; color: #fff; font-size: 10px; text-transform: uppercase;
        letter-spacing: .5px; padding: 7px 10px; text-align: left; border: 1px solid #c62828;
    }
    .fin th.num, .fin td.num { text-align: right; white-space: nowrap; }
    .fin td { padding: 5px 10px; border: 1px solid #e3ddd6; }
    .fin tbody tr:nth-child(even) td { background: #fbf7f3; }

    .sec td {
        background: #fdece1 !important; color: #b23b00; font-weight: bold;
        text-transform: uppercase; font-size: 10px; letter-spacing: .5px;
        border-color: #f3c9a8;
    }
    .subtotal td {
        background: #f1e9e2 !important; font-weight: bold; border-color: #ddd2c7;
    }
    .neg { color: #c62828; }
    .neto td {
        background: #c62828 !important; color: #fff !important; font-weight: bold;
        font-size: 12px; padding: 9px 10px; border-color: #c62828;
    }
    .muted { color: #8a8a8a; }

    .foot { margin-top: 14px; font-size: 9px; color: #9a9a9a; text-align: right; }
</style>
</head>
<body>
@php
    $fmt = fn($n) => number_format((float) $n, 2, '.', ',');
    $totalVentas = 0; $totalCompras = 0; $totalGasto = 0;
    $meses_es = ['','enero','febrero','marzo','abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre','diciembre'];
    $estados_venta_ok = ['Procesado','Qr','QrFie'];
@endphp
<div class="wrap">

    <table class="head-table">
        <tr>
            <td style="width: 62%;">
                @if(!empty($empresa[0]->direccion_logo) && file_exists(public_path($empresa[0]->direccion_logo)))
                    <img src="{{ public_path($empresa[0]->direccion_logo) }}" style="height: 42px; margin-bottom: 4px;">
                    <br>
                @endif
                <span class="brand-name">{{ $empresa[0]->razon_social }}</span>
                <div class="brand-sub">
                    @if(!empty($empresa[0]->nit))NIT: {{ $empresa[0]->nit }}<br>@endif
                    @if(!empty($empresa[0]->whatsapp))Tel: {{ $empresa[0]->whatsapp }}<br>@endif
                    @if(!empty($empresa[0]->direccion)){{ $empresa[0]->direccion }}@endif
                </div>
            </td>
            <td style="width: 38%;" class="doc-box">
                <span class="doc-title">ESTADO DE RESULTADO</span>
                <div class="doc-range">
                    Del {{ $fecha_inicio }} al {{ $fecha_final }}
                </div>
            </td>
        </tr>
    </table>

    <hr class="rule">

    <table class="fin">
        <thead>
            <tr>
                <th>Concepto</th>
                <th class="num" style="width: 130px;">Monto (Bs)</th>
            </tr>
        </thead>
        <tbody>

            {{-- ===== INGRESOS ===== --}}
            @php
                $ventas_ok = array_values(array_filter($nota_venta, fn($p) => in_array($p->estado, $estados_venta_ok)));
                $ventas_canceladas = array_sum(array_map(fn($p) => (float) $p->monto_total, array_filter($nota_venta, fn($p) => $p->estado === 'Cancelado')));
            @endphp
            <tr class="sec"><td>Ingresos &mdash; Ventas</td><td class="num"></td></tr>
            @forelse($ventas_ok as $pago)
                <tr>
                    <td>{{ $pago->nombre }}</td>
                    <td class="num">{{ $fmt($pago->monto_total) }}</td>
                </tr>
                @php $totalVentas += (float) $pago->monto_total; @endphp
            @empty
                <tr><td class="muted">Sin ventas en el período</td><td class="num">0.00</td></tr>
            @endforelse
            <tr class="subtotal"><td>Total de ventas</td><td class="num">{{ $fmt($totalVentas) }}</td></tr>
            @if($ventas_canceladas > 0)
                <tr><td class="muted">Ventas canceladas (no computan)</td><td class="num muted">{{ $fmt($ventas_canceladas) }}</td></tr>
            @endif

            {{-- ===== EGRESOS: COMPRAS ===== --}}
            @php $compras_ok = array_values(array_filter($nota_compra, fn($p) => $p->estado === 'Procesado')); @endphp
            <tr class="sec"><td>Egresos &mdash; Compras</td><td class="num"></td></tr>
            @forelse($compras_ok as $pago)
                <tr>
                    <td>{{ $pago->nombre }}</td>
                    <td class="num">{{ $fmt($pago->monto_total) }}</td>
                </tr>
                @php $totalCompras += (float) $pago->monto_total; @endphp
            @empty
                <tr><td class="muted">Sin compras en el período</td><td class="num">0.00</td></tr>
            @endforelse
            <tr class="subtotal"><td>Total en compras</td><td class="num neg">(&minus;) {{ $fmt($totalCompras) }}</td></tr>

            {{-- ===== EGRESOS: GASTOS ===== --}}
            <tr class="sec"><td>Egresos &mdash; Gastos</td><td class="num"></td></tr>
            @forelse($gasto as $pago)
                <tr>
                    <td>{{ $pago->nombre }}</td>
                    <td class="num">{{ $fmt($pago->monto_total) }}</td>
                </tr>
                @php $totalGasto += (float) $pago->monto_total; @endphp
            @empty
                <tr><td class="muted">Sin gastos en el período</td><td class="num">0.00</td></tr>
            @endforelse
            <tr class="subtotal"><td>Total de gastos</td><td class="num neg">(&minus;) {{ $fmt($totalGasto) }}</td></tr>

            {{-- ===== RESULTADO ===== --}}
            @php $neto = $totalVentas - $totalCompras - $totalGasto; @endphp
            <tr class="neto">
                <td>Resultado neto del ejercicio</td>
                <td class="num">{{ $fmt($neto) }} Bs</td>
            </tr>
        </tbody>
    </table>

    <div class="foot">
        Generado el {{ date('j') }} de {{ $meses_es[(int) date('n')] }} de {{ date('Y') }}, {{ date('H:i') }}
    </div>

</div>
</body>
</html>
