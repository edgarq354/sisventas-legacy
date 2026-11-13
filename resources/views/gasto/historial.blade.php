@extends ('layouts.inicio')
@section ('contenido')
@include('alerts.success')
@include('alerts.request')
@include('alerts.errors')
@include('partials.dashboard_style')

<style type="text/css">
    #tabla_sin_imprimir{ font-size:12.5px; }
    #tabla_sin_imprimir thead th{ padding:8px 10px !important; font-size:11px; text-transform:uppercase; letter-spacing:.4px;
        background:#fdf0e7; color:#c62828; border-bottom:2px solid #efe4da; text-align:left; }
    #tabla_sin_imprimir tbody td{ padding:6px 10px !important; vertical-align:middle; }
    #tabla_sin_imprimir tbody tr:hover{ background:#fdfaf7; }
    #tabla_sin_imprimir .badge{ font-size:10px; padding:3px 8px; border-radius:999px; }
    #tabla_sin_imprimir td.num{ text-align:right; white-space:nowrap; font-weight:700; }

    .gh-filtros{ display:flex; flex-wrap:wrap; gap:10px 14px; align-items:flex-end; }
    .gh-filtros .fld{ display:flex; flex-direction:column; gap:3px; }
    .gh-filtros label{ font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:.5px; color:#8d7b6f; margin:0; }
    .gh-filtros input[type=text]{ height:36px; border:1px solid #e2d3c6; border-radius:8px; padding:0 10px; font-size:13px; background:#fff; }
    .gh-filtros .bootstrap-select{ min-width:180px; }
    .gh-btn{
        display:inline-flex; align-items:center; justify-content:center; gap:7px;
        height:36px; min-width:120px; padding:0 16px; border-radius:9px;
        font-weight:700; font-size:12.5px; color:#fff; border:0; text-decoration:none;
        box-shadow:0 6px 16px -9px rgba(0,0,0,.5);
    }
    .gh-btn:hover{ filter:brightness(1.07); color:#fff; }
    .gh-btn--buscar{ background:linear-gradient(135deg,#ef6c00,#f9a825); }
    .gh-btn--print{ background:#c62828; }
    .gh-total{ display:inline-flex; align-items:baseline; gap:8px; font-size:13px; }
    .gh-total b{ font-size:20px; color:#c62828; }
</style>

<script type="text/javascript">
function buscarEnlace(){
    var fechaInicio = $("#calendario1").val();
    var fechaFinal  = $("#calendario2").val();
    var id_tipo_gasto = $("#id_tipo_gasto").val() || 0;
    var id_empleado   = $("#id_empleado").val() || 0;
    $("#buscar").prop("href", "../../../../gasto_historial/"+fechaInicio+"/"+fechaFinal+"/"+id_tipo_gasto+"/"+id_empleado);
    $("#imprimir").prop("href", "../../../../gasto_historial_imprimir/"+fechaInicio+"/"+fechaFinal+"/"+id_tipo_gasto+"/"+id_empleado);
}
</script>

@php
    $total_gastos = collect($gasto)->sum(fn($g) => (float) $g->precio_gasto);
@endphp

<div class="dash">

    <div class="dash-hero" style="margin-bottom:16px;">
        <div class="dash-hero__icon"><i class="fa fa-history"></i></div>
        <div>
            <h3 class="dash-hero__title">Historial de gastos</h3>
            <p class="dash-hero__sub">Del {{ $fechaInicio }} al {{ $fechaFinal }} · {{ count($gasto) }} registros</p>
        </div>
    </div>

    <div class="dash-card dash-card--overflow">
        <div class="dash-card__body">
            <div class="gh-filtros">
                <div class="fld">
                    <label>Desde</label>
                    <input type="text" value="{{ $fechaInicio }}" id="calendario1" onmouseover="buscarEnlace();">
                </div>
                <div class="fld">
                    <label>Hasta</label>
                    <input type="text" value="{{ $fechaFinal }}" id="calendario2" onmouseover="buscarEnlace();">
                </div>
                <div class="fld">
                    <label>Tipo de gasto</label>
                    <select id="id_tipo_gasto" class="form-control selectpicker" onchange="buscarEnlace();" data-live-search="true">
                        <option value="0">Todos los tipos</option>
                        @foreach ($tipo_gasto as $mov)
                            <option value="{{ $mov->id }}" @if($id_tipo_gasto == $mov->id) selected @endif>{{ $mov->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="fld">
                    <label>Empleado</label>
                    <select id="id_empleado" class="form-control selectpicker" onchange="buscarEnlace();" data-live-search="true">
                        <option value="0">Todos los empleados</option>
                        @foreach ($empleado as $mov)
                            <option value="{{ $mov->id }}" @if($id_empleado == $mov->id) selected @endif>{{ $mov->nombre }} {{ $mov->paterno }} {{ $mov->materno }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="fld">
                    <label>&nbsp;</label>
                    <div>
                        <a class="gh-btn gh-btn--buscar" href="../../../../gasto_historial/{{ $fechaInicio }}/{{ $fechaFinal }}/0/0" id="buscar" onmouseover="buscarEnlace();"><i class="fa fa-search"></i> Buscar</a>
                        <a class="gh-btn gh-btn--print" href="../../../../gasto_historial_imprimir/{{ $fechaInicio }}/{{ $fechaFinal }}/0/0" id="imprimir" onmouseover="buscarEnlace();"><i class="fa fa-print"></i> Imprimir</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="dash-card">
        <div class="dash-card__head">
            <i class="fa fa-list"></i> Gastos
            <span class="dash-card__extra gh-total">Total: <b>Bs {{ number_format($total_gastos, 2) }}</b></span>
        </div>
        <div class="dash-card__body dash-card__body--flush">
            <div class="table-responsive" style="overflow-x:auto;">
                <table class="table table-striped table-hover" id="tabla_sin_imprimir" style="background:white;margin:0;">
                    <thead>
                        <th style="width:55px;"><center>ID</center></th>
                        <th>Fecha</th>
                        <th>Detalle</th>
                        <th>Empleado</th>
                        <th>Usuario</th>
                        <th style="text-align:right;">Monto</th>
                        <th style="text-align:center;">...</th>
                    </thead>
                    <tbody>
                        @forelse($gasto as $pago)
                            <tr>
                                <td><center>{{ $pago->id }}</center></td>
                                <td>{{ $pago->fecha }}</td>
                                <td>
                                    <span class="badge btn-warning">{{ $pago->tipo_gasto }}</span><br>
                                    {{ $pago->detalle }}
                                </td>
                                <td>{{ $pago->empleado }}</td>
                                <td>{{ $pago->usuario }}</td>
                                <td class="num">{{ number_format((float)$pago->precio_gasto, 2) }}</td>
                                <td style="text-align:center;">
                                    <a class='btn btn-primary btn-xs' href='../../../../gasto_imprimir/{{ $pago->id }}' title="Imprimir"><i class="fa fa-print"></i></a>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="dash-empty">Sin gastos en el período</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
@endsection
