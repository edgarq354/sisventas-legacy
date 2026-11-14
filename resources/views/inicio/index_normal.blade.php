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
    $meses_es  = ['','enero','febrero','marzo','abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre','diciembre'];
    $hoy_texto = $meses_es[(int)date('n')].' '.date('Y');
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
            <h3 class="dash-hero__title">{{ __('ajuste.hola', ['nombre' => Auth::user()->nombre]) }}</h3>
            <p class="dash-hero__sub">{{ $hoy_texto }}</p>
        </div>
        <div class="dash-hero__spacer"></div>
        <a href="{{ URL::to('nota_venta/create') }}" class="btn btn-warning" style="font-weight:700;border-radius:10px;">
            <i class="fa fa-plus"></i> {{ __('ajuste.nueva_venta') }}
        </a>
    </div>

    <div class="dash-stats">
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

        <div class="dash-stat dash-stat--month">
            <div class="dash-stat__row">
                <div>
                    <div class="dash-stat__value">Bs {{ number_format((float)$monto_total_mes, 2) }}</div>
                    <div class="dash-stat__label">{{ __('ajuste.ventas_mes', ['mes' => $mes]) }}</div>
                </div>
                <div class="dash-stat__icon"><i class="fa fa-calendar"></i></div>
            </div>
            <a href="{{ URL::to('nota_venta') }}" class="dash-stat__foot">{{ __('ajuste.ver_ventas') }} <i class="fa fa-arrow-right"></i></a>
        </div>

        <div class="dash-stat dash-stat--info">
            <div class="dash-stat__row">
                <div>
                    <div class="dash-stat__value">{{ count($producto) }}</div>
                    <div class="dash-stat__label">{{ __('ajuste.productos_stock_bajo') }}</div>
                </div>
                <div class="dash-stat__icon"><i class="fa fa-cubes"></i></div>
            </div>
            <a href="{{ URL::to('cliente') }}" class="dash-stat__foot">{{ __('ajuste.ver_clientes') }} <i class="fa fa-arrow-right"></i></a>
        </div>
    </div>

    <div class="dash-grid-2">
        <div class="dash-card">
            <div class="dash-card__head"><i class="fa fa-exclamation-triangle"></i> {{ __('ajuste.alerta_de_stock') }}</div>
            <div class="dash-card__body dash-card__body--flush">
                <table class="dash-table">
                    <thead><tr><th>{{ __('ajuste.col_producto') }}</th><th style="text-align:right;">{{ __('nota_venta.col_cantidad') }}</th></tr></thead>
                    <tbody>
                    @forelse($producto as $usr)
                        <tr>
                            <td>
                                @if($usr->imagen1!="")<img src="../storage/{{ $usr->imagen1 }}" class="dash-thumb" alt="">@endif
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
            <div class="dash-card__head">
                <i class="fa fa-bar-chart"></i> {{ __('ajuste.ganancias_mensuales') }}
                <span class="dash-card__extra">{{ date('Y') }}</span>
            </div>
            <div class="dash-card__body">
                <div id="estadistica_pedido_anio" class="dash-chart" style="min-height:300px;"></div>
            </div>
        </div>
    </div>

    <div class="dash-card">
        <div class="dash-card__head"><i class="fa fa-th-large"></i> {{ __('ajuste.accesos_rapidos') }}</div>
        <div class="dash-card__body">
            <div class="dash-quick">
                <a href="{{ URL::to('nota_venta/create') }}"><i class="fa fa-plus-circle"></i><span>{{ __('ajuste.nueva_venta') }}</span></a>
                <a href="{{ URL::to('nota_venta') }}"><i class="fa fa-file-text-o"></i><span>{{ __('ajuste.notas_de_venta') }}</span></a>
                <a href="{{ URL::to('caja') }}"><i class="fa fa-inbox"></i><span>{{ __('ajuste.caja') }}</span></a>
                <a href="{{ URL::to('cliente') }}"><i class="fa fa-users"></i><span>{{ __('ajuste.clientes') }}</span></a>
            </div>
        </div>
    </div>

</div>

<input type="hidden" id="anio" value="{{ date('Y') }}">
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

        for (var i = 0; i < response.length; i++) {
            cantidad_venta += parseInt(response[i].cantidad_venta);
            cantidad_cancelaciones += parseInt(response[i].cantidad_cancelado);
            fecha.push(meses[parseInt(response[i].mes)] || response[i].mes);
            monto_venta.push(parseFloat(response[i].monto_venta));
            monto_cancelado.push(parseFloat(response[i].monto_cancelado));
        }

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
