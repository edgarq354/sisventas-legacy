@extends ('layouts.inicio')
@section ('contenido')
@include('alerts.success')
@include('alerts.request')
@include('alerts.errors')
@include('alerts.gasto_sueldo')
@include('partials.dashboard_style')

@php
    $fechaInicio = date('Y-m-d');
    $fechaFinal  = date('Y-m-d');
    // Defaults por nombre de tipo (funciona para cualquier empresa)
    $tg_anticipo = collect($tipo_gasto)->first(fn($t) => strtoupper(trim($t->nombre)) === 'ANTICIPO');
    $tg_sueldo   = collect($tipo_gasto)->first(fn($t) => strtoupper(trim($t->nombre)) === 'SUELDO');
@endphp

<style type="text/css">
    .gs-grid{ display:grid; grid-template-columns:1.1fr 1fr; gap:18px; align-items:start; }
    @media (max-width:992px){ .gs-grid{ grid-template-columns:1fr; } }
    .gs-field{ margin-bottom:12px; }
    .gs-field label{ font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:.4px; color:#8d7b6f; display:block; margin-bottom:4px; }
    .gs-field .form-control{ border-radius:9px; border:1px solid #e2d3c6; height:38px; }
    .gs-field textarea.form-control{ height:auto; }
    .gs-row2{ display:grid; grid-template-columns:1fr 1fr; gap:12px; }
    #divDatoEmpleado table td{ padding:2px 8px; font-size:13px; }
    #divListaGasto table{ font-size:12.5px; }
    #divListaGasto th{ background:#fdf0e7; color:#c62828; font-size:10px; text-transform:uppercase; padding:7px 9px; }
    #divListaGasto td{ padding:6px 9px; }
    #divListaGasto tr[onclick]{ cursor:pointer; }
    #divListaGasto tr[onclick]:hover td{ background:#fdfaf7; }
    #body_carrito td{ font-size:12.5px; padding:6px 8px; }
    .gs-link-nuevo{ font-size:11px; font-weight:700; color:#ef6c00; text-decoration:none; float:right; }
    .gs-guardar{ height:44px; border-radius:10px; font-weight:800; font-size:14px; }
</style>

<script type="text/javascript">
var listaGastos = [];
var carrito = [];

function con_permiso(){ $("#permiso").val(1); }
function sin_permiso(){ $("#permiso").val(0); }

function get_cliente_por_id() {
    var id_empleado = $('#id_empleado_buscar').val();
    $.get("get_cliente_por_id/" + id_empleado, function (res) {
        var html = "";
        for (var i = 0; i < res.length && i < 15; i++) {
            html += '<div id="divDatoEmpleado"><table>' +
                '<tr><td><b>{{ __('gasto_sueldo.js_nombre_label') }}</b></td><td>' + res[i].nombre + ' ' + res[i].paterno + ' ' + res[i].materno + '</td></tr>' +
                '<tr><td><b>{{ __('gasto_sueldo.js_cargo_label') }}</b></td><td>' + (res[i].cargo || '-') + '</td></tr>' +
                '<tr><td><b>{{ __('gasto_sueldo.js_sueldo_label') }}</b></td><td>Bs ' + res[i].sueldo + '</td></tr>' +
                '</table></div>';
            $("#id_empleado").val(res[i].id);
            $("#precio_gasto").val(res[i].sueldo);
        }
        document.getElementById("divDatoEmpleado").innerHTML = html;
    });
}

function cargarGastoEnCarrito(index){
    this.listaGastos = JSON.parse($("#listaGastos").val());
    var vProducto = this.listaGastos[index];
    if (this.carrito.filter(d => d.id == vProducto.id).length === 0) {
        this.carrito.push(vProducto);
    }
    cargarCarrito();
}

function cargarCarrito(){
    $('#body_carrito').empty();
    var tabladatos = $("#body_carrito");
    var monto_total = 0;
    for (var i = 0; i < this.carrito.length; i++) {
        monto_total = parseFloat(monto_total) + parseFloat(this.carrito[i].precio_gasto);
        tabladatos.append('<tr><td>' +
            '<input name="idCarrito[]" value=' + this.carrito[i].id + ' type="hidden" />' +
            '<input name="precioGasto[]" value=' + this.carrito[i].precio_gasto + ' type="hidden" />' +
            this.carrito[i].tipo_gasto + '<br>' + this.carrito[i].detalle + '</td>' +
            '<td>' + this.carrito[i].precio_gasto + '</td>' +
            '<td><button class="btn btn-danger btn-xs" type="button" onclick="eliminarProducto(' + i + ');"><i class="fa fa-close"></i></button></td></tr>');
    }
    cargarGastoEnTabla();
    $("#monto_total").val(monto_total);
}

function eliminarProducto(index){ this.carrito.splice(index, 1); cargarCarrito(); }

function verProducto(index){
    var vProducto = this.carrito[index];
    $("#precio_compra").val(vProducto.precio_compra);
    $("#precio_venta").val(vProducto.precio_venta);
    $("#precio").val(vProducto.precio);
    $("#cantidad").val(vProducto.cantidad);
    $("#nombre").val(vProducto.nombre);
    $("#indexCarrito").val(index);
}

function getListaAnticiposParaSueldo() {
    var id_empleado = $('#id_empleado_buscar').val();
    var id_tipo_gasto = $('#id_tipo_gasto_buscar').val();
    var fecha_inicio = $('#calendario1').val();
    var fecha_final = $('#calendario2').val();

    $.get("get_lista_gastos_para_sueldo/" + fecha_inicio + "/" + fecha_final + "/" + id_tipo_gasto + "/" + id_empleado, function (res) {
        this.listaGastos = res;
        $("#listaGastos").val(JSON.stringify(res));
        renderListaGasto(res);
    });
}

function renderListaGasto(res){
    var html = "<table class='table table-striped'><tr><th>ID</th><th>Tipo</th><th>Detalle</th><th>Monto</th></tr>";
    for (var i = 0; i < res.length && i < 15; i++) {
        if (carrito.filter(d => d.id == res[i].id).length > 0) continue;
        html += '<tr onclick="cargarGastoEnCarrito(' + i + ');"><td>' + res[i].id + '</td>' +
            '<td>' + res[i].tipo_gasto + '</td><td>' + res[i].detalle + '</td><td>' + res[i].precio_gasto + '</td></tr>';
    }
    document.getElementById("divListaGasto").innerHTML = html + "</table>";
}

function cargarGastoEnTabla(){
    this.listaGastos = JSON.parse($("#listaGastos").val());
    renderListaGasto(this.listaGastos);
}

window.onload = function () {};

// ── Crear un tipo de gasto rápido (se agrega a ambos selects) ──────────
$(function () {
    $('#gs_toggle_nuevo_tipo').on('click', function (e) {
        e.preventDefault();
        $('#gs_box_nuevo_tipo').slideToggle(120);
        $('#gs_msg').text('');
        setTimeout(function () { $('#gs_nuevo_tipo_nombre').focus(); }, 130);
    });
    $('#gs_nuevo_tipo_nombre').on('keydown', function (e) { if (e.which === 13) { e.preventDefault(); $('#gs_btn_guardar_tipo').click(); } });
    $('#gs_btn_guardar_tipo').on('click', function () {
        var nombre = $.trim($('#gs_nuevo_tipo_nombre').val());
        if (!nombre) { $('#gs_msg').text('{{ __('gasto_sueldo.js_ingrese_un_nombre') }}'); return; }
        var $btn = $(this).prop('disabled', true);
        $('#gs_msg').css('color', '#c62828').text('{{ __('gasto_sueldo.js_guardando') }}');
        $.ajax({
            url: '{{ url("tipo_gasto_rapido") }}', method: 'POST', dataType: 'json',
            data: { _token: '{{ csrf_token() }}', nombre: nombre },
            success: function (res) {
                if (!res || !res.ok) { $('#gs_msg').text((res && res.mensaje) || '{{ __('gasto_sueldo.js_no_se_pudo_crear') }}'); return; }
                ['#id_tipo_gasto', '#id_tipo_gasto_buscar'].forEach(function (sel) {
                    if ($(sel + ' option[value="' + res.id + '"]').length === 0) {
                        $(sel).append(new Option(res.nombre, res.id));
                    }
                });
                $('#id_tipo_gasto').val(res.id);
                $('#id_tipo_gasto, #id_tipo_gasto_buscar').selectpicker('refresh');
                $('#gs_nuevo_tipo_nombre').val('');
                $('#gs_box_nuevo_tipo').slideUp(120);
                if (typeof alertify !== 'undefined') alertify.success(res.nuevo ? '{{ __('gasto_sueldo.js_tipo_creado') }}' : '{{ __('gasto_sueldo.js_tipo_ya_existia') }}');
            },
            error: function () { $('#gs_msg').text('{{ __('gasto_sueldo.js_error_de_conexion') }}'); },
            complete: function () { $btn.prop('disabled', false); }
        });
    });
});
</script>

<div class="dash">

    <div class="dash-hero" style="margin-bottom:14px;">
        <div class="dash-hero__icon"><i class="fa fa-users"></i></div>
        <div>
            <h3 class="dash-hero__title">{{ __('gasto_sueldo.pago_de_sueldo') }}</h3>
            <p class="dash-hero__sub">{{ __('gasto_sueldo.descontando_anticipos') }}</p>
        </div>
    </div>

    @if(empty($caja_abierta))
        <div style="display:flex;align-items:center;gap:10px;background:#fdecea;border:1px solid #f5c6c2;color:#a12b21;
                    border-radius:10px;padding:10px 14px;margin-bottom:14px;font-size:13px;font-weight:600;">
            <i class="fa fa-exclamation-triangle"></i>
            {{ __('gasto_sueldo.sin_caja_abierta') }}
            <a href="{!! URL::to('caja') !!}" class="btn btn-danger btn-xs" style="margin-left:auto;border-radius:8px;font-weight:700;"><i class="fa fa-inbox"></i> {{ __('gasto_sueldo.ir_a_caja') }}</a>
        </div>
    @endif

    <input type="hidden" id="listaGastos">

    <div class="gs-grid">

        {{-- ── Izquierda: buscar anticipos ── --}}
        <div class="dash-card dash-card--overflow">
            <div class="dash-card__head"><i class="fa fa-search"></i> {{ __('gasto_sueldo.seleccionar_empleado_anticipos') }}</div>
            <div class="dash-card__body">
                <div class="gs-field">
                    <label for="id_empleado_buscar">{{ __('gasto_sueldo.empleado_label') }}</label>
                    <select class="form-control selectpicker text-uppercase" id="id_empleado_buscar" data-live-search="true">
                        @foreach($empleado as $mov)
                            <option value="{{ $mov->id }}">{{ $mov->nombre }} {{ $mov->paterno }} {{ $mov->materno }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="gs-field">
                    <label for="id_tipo_gasto_buscar">{{ __('gasto_sueldo.tipo_de_gasto_anticipo') }}</label>
                    <select id="id_tipo_gasto_buscar" class="form-control selectpicker text-uppercase" data-live-search="true">
                        <option value="0">{{ __('gasto_sueldo.todos') }}</option>
                        @foreach($tipo_gasto as $mov)
                            <option value="{{ $mov->id }}" {{ ($tg_anticipo && $tg_anticipo->id == $mov->id) ? 'selected' : '' }}>{{ $mov->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="gs-row2">
                    <div class="gs-field">
                        <label for="calendario1">{{ __('gasto_sueldo.desde') }}</label>
                        <input type="text" class="form-control" value="{{ $fechaInicio }}" id="calendario1" autocomplete="off">
                    </div>
                    <div class="gs-field">
                        <label for="calendario2">{{ __('gasto_sueldo.hasta') }}</label>
                        <input type="text" class="form-control" value="{{ $fechaFinal }}" id="calendario2" autocomplete="off">
                    </div>
                </div>

                <button type="button" class="btn btn-warning" style="border-radius:9px;font-weight:700;"
                        onclick="getListaAnticiposParaSueldo();get_cliente_por_id();">
                    <i class="fa fa-search"></i> {{ __('gasto_sueldo.buscar_anticipos') }}
                </button>

                <hr style="margin:14px 0;border-color:#efe4da;">
                <div id="divListaGasto" style="max-height:340px;overflow:auto;"></div>
            </div>
        </div>

        {{-- ── Derecha: registrar el pago ── --}}
        <div class="dash-card dash-card--overflow">
            <div class="dash-card__head"><i class="fa fa-money"></i> {{ __('gasto_sueldo.detalle_del_sueldo') }}</div>
            <div class="dash-card__body">
                <div id="divDatoEmpleado" style="background:#fbf7f3;border:1px solid #efe4da;border-radius:9px;padding:10px 12px;margin-bottom:12px;min-height:34px;color:#8d7b6f;font-size:13px;">
                    {{ __('gasto_sueldo.seleccione_un_empleado') }}
                </div>

                <form method="POST" action="{{ route('gasto_sueldo.store') }}" enctype="multipart/form-data" autocomplete="off"
                      onkeypress="if(event.keyCode == 13) event.returnValue = false;">
                    @csrf
                    <input type="hidden" name="id_caja" value="{{ $id_caja }}">
                    <input type="hidden" name="id_empleado" value="" id="id_empleado">
                    <input type="hidden" name="id_empresa" value="{{ Auth::user()->id_empresa }}">

                    <div class="gs-field">
                        <label for="id_tipo_gasto">
                            {{ __('gasto_sueldo.tipo_de_gasto_sueldo') }}
                            <a href="#" id="gs_toggle_nuevo_tipo" class="gs-link-nuevo"><i class="fa fa-plus-circle"></i> {{ __('gasto_sueldo.nuevo_tipo') }}</a>
                        </label>
                        <select name="id_tipo_gasto" id="id_tipo_gasto" class="form-control selectpicker" data-live-search="true">
                            <option value="">{{ __('gasto_sueldo.buscar_tipo_de_gasto') }}</option>
                            @foreach ($tipo_gasto as $mov)
                                <option value="{{ $mov->id }}" {{ (string) old('id_tipo_gasto', $tg_sueldo->id ?? '') === (string) $mov->id ? 'selected' : '' }}>{{ $mov->nombre }}</option>
                            @endforeach
                        </select>
                        <div id="gs_box_nuevo_tipo" style="display:none;margin-top:8px;">
                            <div class="input-group">
                                <input type="text" id="gs_nuevo_tipo_nombre" class="form-control" placeholder="{{ __('gasto_sueldo.nombre_del_nuevo_tipo') }}" autocomplete="off" maxlength="60">
                                <span class="input-group-btn">
                                    <button type="button" id="gs_btn_guardar_tipo" class="btn btn-warning" style="font-weight:700;"><i class="fa fa-check"></i> {{ __('gasto_sueldo.guardar') }}</button>
                                </span>
                            </div>
                            <small id="gs_msg" style="color:#c62828;"></small>
                        </div>
                    </div>

                    <div class="gs-field">
                        <label for="detalle">{{ __('gasto_sueldo.detalle_label') }}</label>
                        <textarea name="detalle" id="detalle" style="height:50px;" class="form-control">{{ old('detalle') }}</textarea>
                    </div>

                    <div class="gs-row2">
                        <div class="gs-field">
                            <label for="monto_total">{{ __('gasto_sueldo.anticipos_label') }}</label>
                            <input type="text" name="anticipo" id="monto_total" class="form-control" value="{{ old('anticipo', 0) }}" readonly>
                        </div>
                        <div class="gs-field">
                            <label for="precio_gasto">{{ __('gasto_sueldo.monto_a_pagar') }}</label>
                            <input type="text" name="precio_gasto" id="precio_gasto" class="form-control" value="{{ old('precio_gasto', 0) }}" maxlength="10">
                        </div>
                    </div>

                    <label style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.4px;color:#8d7b6f;">{{ __('gasto_sueldo.anticipos_incluidos') }}</label>
                    <div class="table-responsive" style="overflow-x:auto;">
                        <table class="table table-striped" style="background:white;font-size:12.5px;margin-bottom:12px;">
                            <thead><tr><th>{{ __('gasto_sueldo.col_detalle') }}</th><th style="text-align:right;">{{ __('gasto_sueldo.col_monto') }}</th><th></th></tr></thead>
                            <tbody id="body_carrito"></tbody>
                        </table>
                    </div>

                    @if(!empty($caja_abierta))
                        <button type="submit" class="btn btn-success form-control gs-guardar"><i class="fa fa-save"></i> {{ __('gasto_sueldo.guardar_pago') }}</button>
                    @else
                        <button type="button" disabled class="btn btn-success form-control gs-guardar" style="opacity:.5;cursor:not-allowed;"><i class="fa fa-save"></i> {{ __('gasto_sueldo.abra_una_caja_primero') }}</button>
                    @endif
                </form>
            </div>
        </div>

    </div>
</div>

<script src="{{ asset('js/nota_compra.js') }}"></script>
@endsection
