@extends ('layouts.inicio')
@section ('contenido')
@include('alerts.success')
@include('alerts.request')
@include('alerts.errors')
@include('partials.dashboard_style')

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>

@php
    $message   = Session::get('message');
    $hoy_texto = now()->locale(app()->getLocale())->translatedFormat('F Y');
@endphp

@if($message=='store')
<div class="alert alert-success alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span></button>
    {{ __('ajuste.ajuste_registrado') }}
</div>
@endif

<div class="dash">

    <div class="dash-hero">
        <div class="dash-hero__icon"><i class="fa fa-cutlery"></i></div>
        <div>
            <h3 class="dash-hero__title">{{ __('ajuste.panel_de', ['nombre' => Auth::user()->nombre]) }}</h3>
            <p class="dash-hero__sub">{{ $hoy_texto }}</p>
        </div>
        <div class="dash-hero__spacer"></div>
        <a href="{{ URL::to('nota_venta/create') }}" class="btn btn-warning" style="font-weight:700;border-radius:10px;">
            <i class="fa fa-plus"></i> {{ __('ajuste.nueva_venta') }}
        </a>
    </div>

    <div class="dash-stats">
        <div class="dash-stat dash-stat--sales">
            <div class="dash-stat__row">
                <div>
                    <div class="dash-stat__value">Bs {{ number_format((float)$monto_total, 2) }}</div>
                    <div class="dash-stat__label">{{ __('ajuste.total_ganado') }}</div>
                </div>
                <div class="dash-stat__icon"><i class="fa fa-line-chart"></i></div>
            </div>
            <a href="{{ URL::to('nota_venta_rendimiento') }}" class="dash-stat__foot">{{ __('ajuste.ver_rendimiento') }} <i class="fa fa-arrow-right"></i></a>
        </div>

        <div class="dash-stat dash-stat--month">
            <div class="dash-stat__row">
                <div>
                    <div class="dash-stat__value">Bs {{ number_format((float)$monto_total_mes, 2) }}</div>
                    <div class="dash-stat__label">{{ __('ajuste.total_mes', ['mes' => $mes]) }}</div>
                </div>
                <div class="dash-stat__icon"><i class="fa fa-calendar"></i></div>
            </div>
            <a href="{{ URL::to('nota_venta_rendimiento') }}" class="dash-stat__foot">{{ __('ajuste.ver_rendimiento') }} <i class="fa fa-arrow-right"></i></a>
        </div>

        <div class="dash-stat dash-stat--caja">
            <div class="dash-stat__row">
                <div>
                    <div class="dash-stat__value">Bs {{ number_format((float)$monto_caja, 2) }}</div>
                    <div class="dash-stat__label">{{ __('ajuste.monto_en_caja') }}</div>
                </div>
                <div class="dash-stat__icon"><i class="fa fa-inbox"></i></div>
            </div>
            <a href="{{ URL::to('caja') }}" class="dash-stat__foot">{{ __('ajuste.ir_a_caja') }} <i class="fa fa-arrow-right"></i></a>
        </div>

        <div class="dash-stat dash-stat--info">
            <div class="dash-stat__row">
                <div>
                    <div class="dash-stat__value">{{ count($producto) }}</div>
                    <div class="dash-stat__label">{{ __('ajuste.productos_stock_bajo') }}</div>
                </div>
                <div class="dash-stat__icon"><i class="fa fa-cubes"></i></div>
            </div>
            <a href="{{ URL::to('producto') }}" class="dash-stat__foot">{{ __('ajuste.ver_productos') }} <i class="fa fa-arrow-right"></i></a>
        </div>
    </div>

    <div class="dash-card">
        <div class="dash-card__head">
            <i class="fa fa-bar-chart"></i> {{ __('ajuste.ganancias_mensuales') }}
            <span class="dash-card__extra">
                {{ __('ajuste.anio') }}
                <select id="anio" onchange="buscar_por_anio();" style="border:1px solid #e2d3c6;border-radius:8px;padding:2px 8px;">
                    @for($y = (int)date('Y'); $y >= (int)date('Y') - 6; $y--)
                        <option value="{{ $y }}" {{ $y == (int)date('Y') ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
            </span>
        </div>
        <div class="dash-card__body">
            <div id="estadistica_pedido_anio" class="dash-chart"></div>
            <div class="table-responsive" style="overflow-x:auto;margin-top:6px;">
                <table class="dash-table" id="tabla_meses" style="font-size:12.5px;">
                    <thead><tr><th>{{ __('ajuste.col_mes') }}</th><th style="text-align:right;">{{ __('ajuste.col_ventas_bs') }}</th><th style="text-align:center;">{{ __('ajuste.col_n_ventas') }}</th><th style="text-align:right;">{{ __('ajuste.col_canceladas_bs') }}</th></tr></thead>
                    <tbody></tbody>
                    <tfoot></tfoot>
                </table>
            </div>
        </div>
    </div>

    <div class="dash-grid-2">
        <div class="dash-card">
            <div class="dash-card__head"><i class="fa fa-exclamation-triangle"></i> {{ __('ajuste.alerta_de_stock') }}</div>
            <div class="dash-card__body dash-card__body--flush">
                <table class="dash-table" id="tabla_sin_imprimir_medio">
                    <thead><tr><th>{{ __('ajuste.col_producto') }}</th><th style="text-align:right;">{{ __('ajuste.col_stock') }}</th></tr></thead>
                    <tbody>
                    @forelse($producto as $usr)
                        <tr>
                            <td>
                                @if($usr->imagen1!="")<img src="../{{ $usr->imagen1 }}" class="dash-thumb" alt="">@endif
                                {{ $usr->nombre }}
                            </td>
                            <td style="text-align:right;"><span class="dash-pill dash-pill--red">{{ $usr->peso }}</span></td>
                        </tr>
                    @empty
                        <tr><td colspan="2" class="dash-empty">{{ __('ajuste.sin_productos_alerta') }}</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="dash-card">
            <div class="dash-card__head"><i class="fa fa-shopping-basket"></i> {{ __('ajuste.compras_por_dia_mes') }}</div>
            <div class="dash-card__body dash-card__body--flush">
                <table class="dash-table" id="tabla_sin_imprimir_medio_2">
                    <thead><tr><th>{{ __('ajuste.col_producto') }}</th><th style="text-align:center;">{{ __('ajuste.col_stock') }}</th><th style="text-align:center;">{{ __('ajuste.col_dia') }}</th><th style="text-align:center;">{{ __('ajuste.col_mes') }}</th></tr></thead>
                    <tbody>
                    @forelse($producto_compra as $usr)
                        <tr>
                            <td>
                                @if($usr->imagen1!="")<img src="../{{ $usr->imagen1 }}" class="dash-thumb" alt="">@endif
                                {{ $usr->nombre }}
                            </td>
                            <td style="text-align:center;"><b>{{ $usr->peso }}</b></td>
                            <td style="text-align:center;"><span class="dash-pill dash-pill--green">{{ $usr->peso_dia }}</span></td>
                            <td style="text-align:center;"><span class="dash-pill dash-pill--amber">{{ $usr->peso_mes }}</span></td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="dash-empty">{{ __('ajuste.sin_compras_mes') }}</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="dash-card">
        <div class="dash-card__head"><i class="fa fa-th-large"></i> {{ __('ajuste.accesos_rapidos') }}</div>
        <div class="dash-card__body">
            <div class="dash-quick">
                <a href="{{ URL::to('nota_venta') }}"><i class="fa fa-file-text-o"></i><span>{{ __('ajuste.notas_de_venta') }}</span></a>
                <a href="{{ URL::to('nota_compra') }}"><i class="fa fa-truck"></i><span>{{ __('ajuste.notas_de_compra') }}</span></a>
                <a href="{{ URL::to('producto') }}"><i class="fa fa-cubes"></i><span>{{ __('ajuste.productos') }}</span></a>
                <a href="{{ URL::to('tipo_producto') }}"><i class="fa fa-tags"></i><span>{{ __('ajuste.categorias') }}</span></a>
                <a href="{{ URL::to('caja') }}"><i class="fa fa-inbox"></i><span>{{ __('ajuste.caja') }}</span></a>
                <a href="{{ URL::to('cliente') }}"><i class="fa fa-users"></i><span>{{ __('ajuste.clientes') }}</span></a>
            </div>
        </div>
    </div>

</div>

<input type="hidden" id="cantidad_ventas" value="0">
<input type="hidden" id="cantidad_cancelaciones" value="0">

<script type="text/javascript">
Highcharts.setOptions({ colors: ['#2e7d32', '#c62828', '#ef6c00', '#f9a825'] });

window.onload = function () { buscar_por_anio(); };

function buscar_por_anio() {
    var anio = $("#anio").val();
    $.get('get_venta_estadistica_anio/' + anio, function (response) {
        var meses = @json(explode(',', __('rendimiento.meses_completos')));
        var fecha = [], monto_venta = [], monto_cancelado = [];
        var cantidad_venta = 0, cantidad_cancelaciones = 0;

        var fmt = function (n) { return parseFloat(n || 0).toLocaleString('es-BO', { minimumFractionDigits: 2, maximumFractionDigits: 2 }); };
        var filas = '', totV = 0, totC = 0;
        for (var i = 0; i < response.length; i++) {
            cantidad_venta += parseInt(response[i].cantidad_venta);
            cantidad_cancelaciones += parseInt(response[i].cantidad_cancelado);
            var mNom = meses[parseInt(response[i].mes)] || response[i].mes;
            fecha.push(mNom);
            monto_venta.push(parseFloat(response[i].monto_venta));
            monto_cancelado.push(parseFloat(response[i].monto_cancelado));
            totV += parseFloat(response[i].monto_venta || 0);
            totC += parseFloat(response[i].monto_cancelado || 0);
            filas += '<tr><td><b>' + mNom + '</b></td><td style="text-align:right;font-weight:700;color:#2e7d32;">' + fmt(response[i].monto_venta) +
                '</td><td style="text-align:center;">' + parseInt(response[i].cantidad_venta) +
                '</td><td style="text-align:right;color:#c62828;">' + fmt(response[i].monto_cancelado) + '</td></tr>';
        }
        $('#tabla_meses tbody').html(filas || '<tr><td colspan="4" class="dash-empty">' + @json(__('ajuste.sin_datos_anio')) + '</td></tr>');
        $('#tabla_meses tfoot').html('<tr style="font-weight:800;background:#fbf7f3;"><td>' + @json(__('ajuste.total_mayus')) + '</td><td style="text-align:right;color:#2e7d32;">Bs ' + fmt(totV) +
            '</td><td style="text-align:center;">' + cantidad_venta + '</td><td style="text-align:right;color:#c62828;">Bs ' + fmt(totC) + '</td></tr>');

        Highcharts.chart('estadistica_pedido_anio', {
            chart: { type: 'areaspline', backgroundColor: 'transparent' },
            title: { text: null },
            credits: { enabled: false },
            xAxis: { categories: fecha, lineColor: '#efe4da', tickColor: '#efe4da' },
            yAxis: { title: { text: 'Bs' }, gridLineColor: '#f2e9e1' },
            tooltip: { shared: true, valuePrefix: 'Bs ' },
            legend: { align: 'right', verticalAlign: 'top' },
            plotOptions: { areaspline: { fillOpacity: 0.15, marker: { enabled: false } } },
            series: [
                { name: @json(__('rendimiento.serie_ventas')), data: monto_venta },
                { name: @json(__('rendimiento.serie_canceladas')), data: monto_cancelado }
            ]
        });

        $("#cantidad_ventas").val(cantidad_venta);
        $("#cantidad_cancelaciones").val(cantidad_cancelaciones);
    });
}
</script>

@endsection
