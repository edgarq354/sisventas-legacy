@extends ('layouts.inicio')
@section ('contenido')
@include('alerts.success')
@include('alerts.request')
@include('alerts.errors')
@include('partials.dashboard_style')

<script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@latest/dist/Chart.min.js"></script>

<input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">

<div class="dash">

    <div class="dash-hero">
        <div class="dash-hero__icon"><i class="fa fa-line-chart"></i></div>
        <div>
            <h3 class="dash-hero__title">{{ __('rendimiento.titulo') }}</h3>
            <p class="dash-hero__sub">{{ __('rendimiento.subtitulo') }}</p>
        </div>
        <div class="dash-hero__spacer"></div>
        <span class="dash-card__extra" style="color:#fff;">
            {{ __('rendimiento.anio') }}
            <select class="selectpicker" id="anio" onchange="buscar_por_anio();" style="border:none;border-radius:8px;padding:3px 10px;color:#3a2c24;">
                @for($y = (int)date('Y'); $y >= (int)date('Y') - 6; $y--)
                    <option value="{{ $y }}" {{ $y == (int)date('Y') ? 'selected' : '' }}>{{ $y }}</option>
                @endfor
            </select>
        </span>
    </div>

    <div class="dash-stats">
        <div class="dash-stat dash-stat--sales">
            <div class="dash-stat__row">
                <div>
                    <div class="dash-stat__value" id="stat_ganancia">Bs 0.00</div>
                    <div class="dash-stat__label">{{ __('rendimiento.ganancia_del_anio') }}</div>
                </div>
                <div class="dash-stat__icon"><i class="fa fa-money"></i></div>
            </div>
            <span class="dash-stat__foot">{{ __('rendimiento.ventas_procesadas_qr') }}</span>
        </div>
        <div class="dash-stat dash-stat--month">
            <div class="dash-stat__row">
                <div>
                    <div class="dash-stat__value" id="stat_ventas">0</div>
                    <div class="dash-stat__label">{{ __('rendimiento.ventas_realizadas') }}</div>
                </div>
                <div class="dash-stat__icon"><i class="fa fa-check"></i></div>
            </div>
            <span class="dash-stat__foot">{{ __('rendimiento.en_anio_seleccionado') }}</span>
        </div>
        <div class="dash-stat dash-stat--caja">
            <div class="dash-stat__row">
                <div>
                    <div class="dash-stat__value" id="stat_canceladas">0</div>
                    <div class="dash-stat__label">{{ __('rendimiento.ventas_canceladas') }}</div>
                </div>
                <div class="dash-stat__icon"><i class="fa fa-times"></i></div>
            </div>
            <span class="dash-stat__foot">{{ __('rendimiento.en_anio_seleccionado') }}</span>
        </div>
    </div>

    <div class="dash-card">
        <div class="dash-card__head"><i class="fa fa-area-chart"></i> {{ __('rendimiento.ganancias_mensuales') }}</div>
        <div class="dash-card__body">
            <div id="estadistica_pedido_anio" class="dash-chart"></div>
            <div class="table-responsive" style="overflow-x:auto;margin-top:6px;">
                <table class="dash-table" id="tabla_meses" style="font-size:12.5px;">
                    <thead><tr><th>{{ __('rendimiento.col_mes') }}</th><th style="text-align:right;">{{ __('rendimiento.col_ventas_bs') }}</th><th style="text-align:center;">{{ __('rendimiento.col_n_ventas') }}</th><th style="text-align:right;">{{ __('rendimiento.col_canceladas_bs') }}</th></tr></thead>
                    <tbody></tbody>
                    <tfoot></tfoot>
                </table>
            </div>
        </div>
    </div>

    <div class="dash-card" style="max-width:460px;">
        <div class="dash-card__head"><i class="fa fa-pie-chart"></i> {{ __('rendimiento.ventas_vs_canceladas') }}</div>
        <div class="dash-card__body" style="text-align:center;">
            <canvas id="myChart" style="max-height:280px;"></canvas>
        </div>
    </div>

</div>

<input type="hidden" id="cantidad_ventas" value="0">
<input type="hidden" id="cantidad_cancelaciones" value="0">

<script type="text/javascript">
Highcharts.setOptions({ colors: ['#2e7d32', '#c62828', '#ef6c00', '#f9a825'] });
var pieChart = null;

window.onload = function () { buscar_por_anio(); };

function buscar_por_anio() {
    var anio = $("#anio").val();
    $.get('get_venta_estadistica_anio/' + anio, function (response) {
        var meses = @json(explode(',', __('rendimiento.meses_completos')));
        var fecha = [], monto_venta = [], monto_cancelado = [];
        var monto_total = 0, cantidad_venta = 0, cantidad_cancelaciones = 0;

        var fmt = function (n) { return parseFloat(n || 0).toLocaleString('es-BO', { minimumFractionDigits: 2, maximumFractionDigits: 2 }); };
        var filas = '', totC_monto = 0;
        for (var i = 0; i < response.length; i++) {
            monto_total += parseFloat(response[i].monto_venta);
            cantidad_venta += parseInt(response[i].cantidad_venta);
            cantidad_cancelaciones += parseInt(response[i].cantidad_cancelado);
            var mNom = meses[parseInt(response[i].mes)] || response[i].mes;
            fecha.push(mNom);
            monto_venta.push(parseFloat(response[i].monto_venta));
            monto_cancelado.push(parseFloat(response[i].monto_cancelado));
            totC_monto += parseFloat(response[i].monto_cancelado || 0);
            filas += '<tr><td><b>' + mNom + '</b></td><td style="text-align:right;font-weight:700;color:#2e7d32;">' + fmt(response[i].monto_venta) +
                '</td><td style="text-align:center;">' + parseInt(response[i].cantidad_venta) +
                '</td><td style="text-align:right;color:#c62828;">' + fmt(response[i].monto_cancelado) + '</td></tr>';
        }
        $('#tabla_meses tbody').html(filas || '<tr><td colspan="4" class="dash-empty">' + @json(__('rendimiento.sin_datos_anio')) + '</td></tr>');
        $('#tabla_meses tfoot').html('<tr style="font-weight:800;background:#fbf7f3;"><td>' + @json(__('rendimiento.total_mayus')) + '</td><td style="text-align:right;color:#2e7d32;">Bs ' + fmt(monto_total) +
            '</td><td style="text-align:center;">' + cantidad_venta + '</td><td style="text-align:right;color:#c62828;">Bs ' + fmt(totC_monto) + '</td></tr>');

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

        $("#stat_ganancia").text('Bs ' + monto_total.toLocaleString('es-BO', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
        $("#stat_ventas").text(cantidad_venta.toLocaleString('es-BO'));
        $("#stat_canceladas").text(cantidad_cancelaciones.toLocaleString('es-BO'));
        $("#cantidad_ventas").val(cantidad_venta);
        $("#cantidad_cancelaciones").val(cantidad_cancelaciones);

        var ctx = document.getElementById('myChart').getContext('2d');
        if (pieChart) { pieChart.destroy(); }
        pieChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: [cantidad_venta, cantidad_cancelaciones],
                    backgroundColor: ['#2e7d32', '#c62828']
                }],
                labels: [@json(__('rendimiento.serie_ventas')), @json(__('rendimiento.serie_canceladas'))]
            },
            options: { responsive: true, legend: { position: 'bottom' } }
        });
    });
}
</script>

@endsection
