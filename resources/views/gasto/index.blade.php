@extends ('layouts.inicio')
@section('contenido')
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
        #tabla_sin_imprimir .btn{ padding:3px 8px; border-radius:8px; }

        .g-actions{ display:flex; flex-wrap:wrap; gap:10px; margin-bottom:18px; }
        .g-actions .g-btn{
            display:inline-flex; align-items:center; justify-content:center; gap:7px;
            min-width:170px; height:42px; padding:0 18px;
            border-radius:10px; font-weight:700; font-size:13px; line-height:1;
            border:0; text-decoration:none; cursor:pointer; color:#fff;
            box-shadow:0 6px 16px -9px rgba(0,0,0,.5);
            transition:transform .1s, box-shadow .12s, filter .12s;
        }
        .g-actions .g-btn:hover{ transform:translateY(-1px); box-shadow:0 9px 20px -9px rgba(0,0,0,.5); filter:brightness(1.06); color:#fff; }
        .g-btn--nuevo{ background:linear-gradient(135deg,#2e7d32,#66bb6a); }
        .g-btn--hist{ background:#c62828; }
        .g-btn--tipo{ background:#5c4033; }
        .g-btn--sueldo{ background:#2e7d32; }
        @media (max-width:600px){ .g-actions .g-btn{ flex:1 1 45%; min-width:0; } }
    </style>

    @php
        $tg_default = collect($tipo_gasto)->first(fn($t) => strtoupper(trim($t->nombre)) === 'GASTOS EN PROCESO DE VENTA');
    @endphp
    <input type="hidden" id="listaCaja" value="{{ json_encode($gasto) }}">
    <input type="hidden" id="empleado_default" value="{{ Auth::user()->id_empleado }}">
    <input type="hidden" id="tipo_gasto_default" value="{{ $tg_default->id ?? '' }}">

    <div class="dash">

        <div class="dash-hero" style="margin-bottom:16px;">
            <div class="dash-hero__icon"><i class="fa fa-money"></i></div>
            <div>
                <h3 class="dash-hero__title">{{ __('gasto.titulo_gastos') }}</h3>
                <p class="dash-hero__sub">{{ __('gasto.registrados', ['count' => count($gasto)]) }}</p>
            </div>
        </div>

        @if(empty($caja_abierta))
            <div style="display:flex;align-items:center;gap:10px;background:#fdecea;border:1px solid #f5c6c2;color:#a12b21;
                        border-radius:10px;padding:10px 14px;margin-bottom:14px;font-size:13px;font-weight:600;">
                <i class="fa fa-exclamation-triangle"></i>
                {{ __('gasto.sin_caja_abierta_aviso') }}
                <a href="{!! URL::to('caja') !!}" class="btn btn-danger btn-xs" style="margin-left:auto;border-radius:8px;font-weight:700;">
                    <i class="fa fa-inbox"></i> {{ __('gasto.ir_a_caja') }}
                </a>
            </div>
        @endif

        <div class="g-actions">
            @if(!empty($caja_abierta))
                <a data-toggle="modal" data-target="#ModalCrearGasto" class="g-btn g-btn--nuevo"><i class="fa fa-plus"></i> {{ __('gasto.nuevo_gasto') }}</a>
            @else
                <span class="g-btn g-btn--nuevo" style="opacity:.5;cursor:not-allowed;" title="{{ __('gasto.abra_caja_primero') }}"><i class="fa fa-plus"></i> {{ __('gasto.nuevo_gasto') }}</span>
            @endif
            <a href="{!! URL::to('gasto_historial/'.date('Y-m-d').'/'.date('Y-m-d').'/0/0') !!}" class="g-btn g-btn--hist"><i class="fa fa-history"></i> {{ __('gasto.historial') }}</a>
            <a href="{!! URL::to('tipo_gasto') !!}" class="g-btn g-btn--tipo"><i class="fa fa-tags"></i> {{ __('gasto.tipo_de_gasto') }}</a>
            <a href="{!! URL::to('gasto_sueldo') !!}" class="g-btn g-btn--sueldo"><i class="fa fa-users"></i> {{ __('gasto.pago_de_sueldo') }}</a>
        </div>

        <div class="dash-card">
            <div class="dash-card__head"><i class="fa fa-list"></i> {{ __('gasto.gastos_registrados') }}</div>
            <div class="dash-card__body dash-card__body--flush">
                <div class="table-responsive" style="overflow-x:auto;">
                    <table class="table table-striped table-hover" id="tabla_sin_imprimir" style="background:white;margin:0;">
                        <thead>
                            <th style="width:55px;"><center>{{ __('gasto.col_id') }}</center></th>
                            <th>{{ __('gasto.col_fecha') }}</th>
                            <th>{{ __('gasto.col_detalle') }}</th>
                            <th>{{ __('gasto.col_empleado') }}</th>
                            <th style="text-align:right;">{{ __('gasto.col_monto') }}</th>
                            <th>{{ __('gasto.col_caja') }}</th>
                            <th>{{ __('gasto.col_usuario') }}</th>
                            <th style="text-align:center;">{{ __('gasto.col_estado') }}</th>
                            <th style="text-align:center;">...</th>
                        </thead>
                        <tbody id="body_conductor">
                            @foreach ($gasto as $pago)
                                <tr>
                                    <td><center>{{ $pago->id }}</center></td>
                                    <td>{{ $pago->fecha }}</td>
                                    <td>
                                        <span class="badge btn-warning">{{ $pago->tipo_gasto }}</span><br>
                                        {{ $pago->detalle }}
                                    </td>
                                    <td>{{ $pago->empleado }}</td>
                                    <td class="num">{{ number_format((float)$pago->precio_gasto, 2) }}</td>
                                    <td>{{ $pago->caja }}</td>
                                    <td>{{ $pago->usuario }}</td>
                                    <td style="text-align:center;">
                                        @if($pago->estado=='Procesado')
                                            <span class="badge btn-success">{{ __('estados.'.$pago->estado) }}</span>
                                        @else
                                            <span class="badge btn-danger">{{ __('estados.'.$pago->estado) }}</span>
                                        @endif
                                    </td>
                                    <td style="text-align:center;white-space:nowrap;">
                                        <a class='btn btn-primary' href='gasto_imprimir/{{ $pago->id }}' title="{{ __('gasto.imprimir') }}"><i class="fa fa-print"></i></a>
                                        @if($pago->estado=='Procesado' && Auth::user()->privilegio==0 && $id_caja==$pago->id_caja || $pago->estado=='Procesado' && Auth::user()->id== $pago->id_usuario && $id_caja==$pago->id_caja)
                                        <a class='btn btn-danger' href='gasto_cancelar/{{ $pago->id }}' title="{{ __('gasto.cancelar_gasto') }}"><i class="fa fa-close"></i></a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <!-- Modal CREAR GASTO -->
    <div id="ModalCrearGasto" class="modal fade" role="dialog">
        <div class="modal-dialog modal-md">
            <div class="modal-content" style="border-radius:14px;overflow:hidden;">

                <div class="modal-header" style="background:linear-gradient(135deg,#c62828,#ef6c00);color:#fff;">
                    <h3 class="modal-title" style="color:#fff;"><i class="fa fa-money"></i> {{ __('gasto.nuevo_gasto') }}</h3>
                </div>

                <div class="modal-body">
                    <form method="POST" action="{{ route('gasto.store') }}" enctype="multipart/form-data" autocomplete="off">
                        @csrf
                        <input type="hidden" name="id_caja" value="{{ $id_caja }}">

                        <div class="row">
                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label for="id_tipo_gasto" style="display:flex;justify-content:space-between;align-items:center;">
                                        {{ __('gasto.tipo_de_gasto') }}
                                        <a href="#" id="toggle_nuevo_tipo" style="font-size:12px;font-weight:700;color:#ef6c00;text-decoration:none;">
                                            <i class="fa fa-plus-circle"></i> {{ __('gasto.nuevo_tipo') }}
                                        </a>
                                    </label>
                                    <select name="id_tipo_gasto" id="id_tipo_gasto" class="form-control selectpicker" data-live-search="true">
                                        <option value="">{{ __('gasto.buscar_tipo_gasto') }}</option>
                                        @foreach ($tipo_gasto as $mov)
                                            <option value="{{ $mov->id }}" {{ (string) old('id_tipo_gasto', $tg_default->id ?? '') === (string) $mov->id ? 'selected' : '' }}>{{ $mov->nombre }}</option>
                                        @endforeach
                                    </select>

                                    <div id="box_nuevo_tipo" style="display:none;margin-top:8px;">
                                        <div class="input-group">
                                            <input type="text" id="nuevo_tipo_nombre" class="form-control" placeholder="{{ __('gasto.placeholder_nuevo_tipo') }}" autocomplete="off" maxlength="60">
                                            <span class="input-group-btn">
                                                <button type="button" id="btn_guardar_tipo" class="btn btn-warning" style="font-weight:700;"><i class="fa fa-check"></i> {{ __('gasto.guardar') }}</button>
                                            </span>
                                        </div>
                                        <small id="nuevo_tipo_msg" style="color:#c62828;"></small>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-7 col-xs-12">
                                <div class="form-group">
                                    <label for="id_empleado">{{ __('gasto.empleado_label') }}</label>
                                    <select name="id_empleado" id="id_empleado" class="form-control selectpicker" data-live-search="true">
                                        <option value="">{{ __('gasto.buscar_empleado') }}</option>
                                        @foreach ($empleado as $mov)
                                            <option value="{{ $mov->id }}" {{ (string) old('id_empleado', Auth::user()->id_empleado) === (string) $mov->id ? 'selected' : '' }}>
                                                {{ $mov->nombre }} {{ $mov->paterno }} {{ $mov->materno }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-5 col-xs-12">
                                <div class="form-group">
                                    <label for="precio_gasto">{{ __('gasto.monto_bs') }}</label>
                                    <input type="number" name="precio_gasto" id="precio_gasto" class="form-control" value="{{ old('precio_gasto', 0) }}" step="0.01" min="0">
                                </div>
                            </div>

                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label for="detalle">{{ __('gasto.detalle_label') }} <span style="color:#c62828">*</span></label>
                                    <textarea name="detalle" id="detalle" class="form-control text-capitalize" placeholder="{{ __('gasto.placeholder_detalle') }}" style="height:60px">{{ old('detalle') }}</textarea>
                                </div>
                                <div class="form-group" hidden>
                                    <textarea name="nota" id="nota" class="form-control">{{ old('nota') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer" style="border-top:1px solid #eee;">
                            <button type="button" data-dismiss="modal" class="btn btn-default" style="border-radius:10px;">{{ __('gasto.cancelar') }}</button>
                            <button type="submit" class="btn btn-warning" id="btn_actualizar" onclick="btn_esconder()" style="border-radius:10px;font-weight:700;">
                                <i class="fa fa-save"></i> {{ __('gasto.registrar_gasto') }}
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <script type="text/javascript">
        function cargarCaja(index) {
            var listaCaja = JSON.parse($("#listaCaja").val()).filter(d => d.id == index);
            for (var i = 0; i < listaCaja.length; i++) {
                $("#idCaja").val(listaCaja[i].id);
                $("#caja").val(listaCaja[i].caja);
                $("#fechaAbrir").val(listaCaja[i].fecha_abrir);
                $("#montoAbrir").val(listaCaja[i].monto_abrir);
                $("#montoCierre").val(listaCaja[i].monto_venta);
                $("#usuario").val(listaCaja[i].usuario);
            }
        }

        // Valores por defecto del modal "Nuevo gasto":
        //  - Empleado  = id_empleado del usuario autenticado
        //  - Tipo gasto = "GASTOS EN PROCESO DE VENTA"
        function aplicarDefaultsGasto() {
            var emp = $('#empleado_default').val();
            var tg  = $('#tipo_gasto_default').val();
            if (emp && !$('#id_empleado').val()) { $('#id_empleado').val(emp); }
            if (tg  && !$('#id_tipo_gasto').val()) { $('#id_tipo_gasto').val(tg); }
            $('#id_empleado').selectpicker('refresh');
            $('#id_tipo_gasto').selectpicker('refresh');
        }
        $(aplicarDefaultsGasto);
        $('#ModalCrearGasto').on('shown.bs.modal', aplicarDefaultsGasto);

        // ── Crear un tipo de gasto sin salir del modal ──────────────────────
        $('#toggle_nuevo_tipo').on('click', function (e) {
            e.preventDefault();
            $('#box_nuevo_tipo').slideToggle(120);
            $('#nuevo_tipo_msg').text('');
            setTimeout(function () { $('#nuevo_tipo_nombre').focus(); }, 130);
        });

        $('#nuevo_tipo_nombre').on('keydown', function (e) {
            if (e.which === 13) { e.preventDefault(); $('#btn_guardar_tipo').click(); }
        });

        $('#btn_guardar_tipo').on('click', function () {
            var nombre = $.trim($('#nuevo_tipo_nombre').val());
            if (!nombre) { $('#nuevo_tipo_msg').text(@json(__('gasto.ingrese_un_nombre'))); return; }
            var $btn = $(this).prop('disabled', true);
            $('#nuevo_tipo_msg').css('color', '#c62828').text(@json(__('gasto.guardando')));

            $.ajax({
                url: '{{ url("tipo_gasto_rapido") }}',
                method: 'POST',
                dataType: 'json',
                data: { _token: '{{ csrf_token() }}', nombre: nombre },
                success: function (res) {
                    if (!res || !res.ok) { $('#nuevo_tipo_msg').text((res && res.mensaje) || @json(__('gasto.no_se_pudo_crear'))); return; }
                    // Si ya existía lo seleccionamos; si es nuevo lo agregamos
                    if ($('#id_tipo_gasto option[value="' + res.id + '"]').length === 0) {
                        $('#id_tipo_gasto').append(new Option(res.nombre, res.id, true, true));
                    }
                    $('#id_tipo_gasto').val(res.id).selectpicker('refresh');
                    $('#nuevo_tipo_nombre').val('');
                    $('#box_nuevo_tipo').slideUp(120);
                    $('#nuevo_tipo_msg').text('');
                    if (typeof alertify !== 'undefined') {
                        alertify.success(res.nuevo ? @json(__('gasto.tipo_gasto_creado')) : @json(__('gasto.tipo_gasto_existia')));
                    }
                },
                error: function () { $('#nuevo_tipo_msg').text(@json(__('gasto.error_conexion'))); },
                complete: function () { $btn.prop('disabled', false); }
            });
        });
    </script>
@endsection
