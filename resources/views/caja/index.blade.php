@extends ('layouts.inicio')
@section('contenido')
    @include('alerts.success')
    @include('alerts.request')
    @include('alerts.errors')
    @include('caja.modal')
    @include('partials.dashboard_style')

    <style type="text/css">
        #tabla_sin_imprimir{ font-size:12px; }
        #tabla_sin_imprimir thead th{ padding:8px 9px !important; font-size:10px; text-transform:uppercase; letter-spacing:.3px;
            background:#fdf0e7; color:#c62828; border-bottom:2px solid #efe4da; text-align:left; white-space:nowrap; }
        #tabla_sin_imprimir tbody td{ padding:6px 9px !important; vertical-align:middle; white-space:nowrap; }
        #tabla_sin_imprimir tbody tr:hover{ background:#fdfaf7; }
        #tabla_sin_imprimir .badge{ font-size:10px; padding:3px 8px; border-radius:999px; }
        #tabla_sin_imprimir td.num{ text-align:right; font-weight:700; }
        #tabla_sin_imprimir .btn{ padding:3px 9px; border-radius:8px; font-size:12px; }

        /* Barra compacta de resumen */
        .c-bar{
            display:flex; flex-wrap:wrap; align-items:center; gap:10px 22px;
            background:#fff; border:1px solid var(--d-border, #ecdfd6); border-radius:12px;
            padding:10px 16px; margin-bottom:14px; box-shadow:0 6px 18px -12px rgba(58,44,36,.3);
        }
        .c-bar__title{ font-weight:800; font-size:14px; color:#3a2c24; display:flex; align-items:center; gap:8px; }
        .c-bar__title .dot{ width:9px; height:9px; border-radius:50%; }
        .c-bar__title .dot--on{ background:#2e7d32; } .c-bar__title .dot--off{ background:#c62828; }
        .c-bar__stats{ display:flex; flex-wrap:wrap; gap:6px 20px; margin-left:auto; }
        .c-fig{ line-height:1.1; }
        .c-fig b{ display:block; font-size:15px; font-weight:800; }
        .c-fig span{ font-size:10px; text-transform:uppercase; letter-spacing:.4px; color:#927c6e; font-weight:700; }
        .c-fig--total b{ color:#c62828; } .c-fig--efe b{ color:#2e7d32; }
        .c-fig--qr b{ color:#ef6c00; } .c-fig--pc b{ color:#8a6d00; }
        .c-actions{ display:flex; flex-wrap:wrap; gap:8px; }
        .c-actions .c-btn{
            display:inline-flex; align-items:center; justify-content:center; gap:6px;
            height:34px; padding:0 14px; border-radius:9px;
            font-weight:700; font-size:12.5px; color:#fff; border:0; text-decoration:none; cursor:pointer;
            box-shadow:0 6px 14px -9px rgba(0,0,0,.5);
        }
        .c-actions .c-btn:hover{ filter:brightness(1.07); color:#fff; }
        .c-btn--abrir{ background:linear-gradient(135deg,#2e7d32,#66bb6a); }
        .c-btn--print{ background:#c62828; }

        .c-filtros{ display:flex; flex-wrap:wrap; gap:10px 14px; align-items:flex-end; margin:0; }
        .c-filtros .fld{ display:flex; flex-direction:column; gap:3px; }
        .c-filtros label{ font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:.5px; color:#8d7b6f; margin:0; }
        .c-filtros input[type=date]{ height:36px; border:1px solid #e2d3c6; border-radius:8px; padding:0 10px; font-size:13px; background:#fff; }
        .c-fbtn{ display:inline-flex; align-items:center; gap:6px; height:36px; padding:0 15px; border-radius:9px; font-weight:700; font-size:12.5px;
            color:#fff; border:0; text-decoration:none; cursor:pointer; }
        .c-fbtn--buscar{ background:linear-gradient(135deg,#ef6c00,#f9a825); }
        .c-fbtn--limpiar{ background:#8d7b6f; }
        .c-fbtn:hover{ filter:brightness(1.07); color:#fff; }

        /* Selector de usuarios con checkboxes */
        .c-usel{ position:relative; }
        .c-usel__btn{ display:flex; align-items:center; justify-content:space-between; gap:10px; width:240px; height:36px;
            padding:0 12px; border:1px solid #e2d3c6; border-radius:8px; background:#fff; font-size:13px; color:#3a2c24; cursor:pointer; }
        .c-usel__btn:hover{ border-color:#ef6c00; }
        .c-usel__btn .fa{ color:#9a8b7d; }
        .c-usel__menu{ display:none; position:absolute; z-index:1060; top:calc(100% + 4px); left:0; width:260px;
            background:#fff; border:1px solid #e6d8cc; border-radius:10px; box-shadow:0 16px 34px -10px rgba(58,44,36,.4); padding:4px; }
        .c-usel.open .c-usel__menu{ display:block; }
        .c-usel__list{ max-height:230px; overflow:auto; margin-top:2px; }
        .c-usel__opt{ display:flex; align-items:center; gap:8px; padding:7px 10px; border-radius:7px; font-size:13px; font-weight:500;
            color:#3a2c24; cursor:pointer; margin:0; }
        .c-usel__opt:hover{ background:#fdfaf7; }
        .c-usel__opt input{ width:16px; height:16px; accent-color:#c62828; margin:0; }
        .c-usel__all{ border-bottom:1px solid #f0e6dc; margin-bottom:2px; padding-bottom:8px; }
    </style>

    <input type="hidden" id="listaCaja" value="{{ json_encode($caja) }}">
    <input type="hidden" id="listaCajaMonto" value="{{ json_encode($caja_monto) }}">

    @php
        $abierta = collect($caja)->firstWhere('estado', 'Abierta');
    @endphp

    <div class="dash">

        <div class="c-bar">
            <div class="c-bar__title">
                <span class="dot {{ $abierta ? 'dot--on' : 'dot--off' }}"></span>
                <i class="fa fa-inbox"></i>
                @if($abierta) Caja "{{ $abierta->caja }}" abierta @else Sin caja abierta @endif
            </div>

            @if($abierta)
            <div class="c-bar__stats">
                <div class="c-fig c-fig--total"><b>Bs {{ number_format((float)$abierta->monto_venta_total, 2) }}</b><span>Total</span></div>
                <div class="c-fig c-fig--efe"><b>Bs {{ number_format((float)$abierta->monto_venta, 2) }}</b><span>Efectivo</span></div>
                <div class="c-fig c-fig--qr"><b>Bs {{ number_format((float)$abierta->monto_venta_qr, 2) }}</b><span>QR</span></div>
                <div class="c-fig c-fig--pc"><b>Bs {{ number_format((float)$abierta->monto_venta_por_cobrar, 2) }}</b><span>Por cobrar</span></div>
            </div>
            @endif

            <div class="c-actions" style="{{ $abierta ? '' : 'margin-left:auto;' }}">
                @if(!($id_caja>0))
                    <a class="c-btn c-btn--abrir" data-toggle="modal" data-target="#ModalAbrirCaja" onclick="cargarCajaMonto();"><i class="fa fa-plus"></i> Abrir caja</a>
                @endif
                <a class="c-btn c-btn--print" href="caja_imprimir" target="_blank"><i class="fa fa-print"></i> Imprimir</a>
            </div>
        </div>

        @if(Auth::user()->privilegio == 0)
        <div class="dash-card dash-card--overflow">
            <div class="dash-card__body">
                <form method="GET" action="{{ url('caja') }}" class="c-filtros">
                    <div class="fld"><label>Desde</label><input type="date" name="desde" value="{{ $f_desde }}"></div>
                    <div class="fld"><label>Hasta</label><input type="date" name="hasta" value="{{ $f_hasta }}"></div>
                    <div class="fld">
                        <label>Usuario(s)</label>
                        <div class="c-usel" id="c-usel">
                            <button type="button" class="c-usel__btn" onclick="cUselToggle()">
                                <span id="c-usel-label">{{ count($f_usuarios) ? count($f_usuarios).' seleccionado(s)' : 'Todos los usuarios' }}</span>
                                <i class="fa fa-caret-down"></i>
                            </button>
                            <div class="c-usel__menu" id="c-usel-menu">
                                <label class="c-usel__opt c-usel__all">
                                    <input type="checkbox" id="c-usel-todos" {{ count($f_usuarios) ? '' : 'checked' }}> <b>Todos</b>
                                </label>
                                <div class="c-usel__list">
                                    @foreach($usuarios_empresa as $u)
                                        <label class="c-usel__opt">
                                            <input type="checkbox" name="id_usuario[]" value="{{ $u->id }}" class="c-usel-chk" {{ in_array($u->id, $f_usuarios) ? 'checked' : '' }}>
                                            {{ $u->nombre ?: $u->usuario }} <span style="color:#9a8b7d;">({{ $u->usuario }})</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="fld"><label>&nbsp;</label>
                        <div>
                            <button type="submit" class="c-fbtn c-fbtn--buscar"><i class="fa fa-search"></i> Filtrar</button>
                            <a href="{{ url('caja') }}" class="c-fbtn c-fbtn--limpiar"><i class="fa fa-eraser"></i> Limpiar</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        @endif

        <div class="dash-card">
            <div class="dash-card__head">
                <i class="fa fa-history"></i> Movimientos de caja
                @if(Auth::user()->privilegio == 0)
                    <span class="dash-card__extra">{{ count($caja) }} cajas · {{ $f_desde }} al {{ $f_hasta }}</span>
                @endif
            </div>
            <div class="dash-card__body dash-card__body--flush">
                <div class="table-responsive" style="overflow-x:auto;">
                    <table class="table table-striped table-hover" id="tabla_sin_imprimir" style="background:white;margin:0;">
                        <thead>
                            <th><center>ID</center></th>
                            <th>Usuario</th>
                            <th>Caja</th>
                            <th style="text-align:right;">Abrir</th>
                            <th style="text-align:right;">Abrir QR</th>
                            <th style="text-align:right;">Cerrado total</th>
                            <th style="text-align:right;">Cerrado efectivo</th>
                            <th style="text-align:right;">Cerrado QR</th>
                            <th>Abierto</th>
                            <th>Cerrado</th>
                            <th style="text-align:center;">Estado</th>
                            <th style="text-align:center;">Opción</th>
                        </thead>
                        <tbody id="body_conductor">
                            @foreach ($caja as $usr)
                                <tr>
                                    <td><center>{{ $usr->id }}</center></td>
                                    <td>{{ $usr->usuario }}</td>
                                    <td>{{ $usr->caja }}</td>
                                    <td class="num">{{ number_format((float)$usr->monto_abrir, 2) }}</td>
                                    <td class="num">{{ number_format((float)$usr->monto_abrir_qr, 2) }}</td>
                                    <td class="num">{{ number_format((float)$usr->monto_cierre_total, 2) }}</td>
                                    <td class="num">{{ number_format((float)$usr->monto_cierre, 2) }}</td>
                                    <td class="num">{{ number_format((float)$usr->monto_cierre_qr, 2) }}</td>
                                    <td>{{ $usr->fecha_abrir }}</td>
                                    <td>{{ $usr->fecha_cierre }}</td>
                                    <td style="text-align:center;">
                                        @if ($usr->estado == 'Abierta')
                                            <span class="badge btn-success">{{ $usr->estado }}</span>
                                        @else
                                            <span class="badge btn-danger">{{ $usr->estado }}</span>
                                        @endif
                                    </td>
                                    <td style="text-align:center;">
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                Opción <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                                <li><a href='caja/{{ $usr->id }}/edit' title="Ver"><i class='fa fa-eye'></i> Ver</a></li>
                                                @if ($usr->estado == 'Abierta' && $usr->id_usuario == Auth::user()->id)
                                                    <li><a href="" data-toggle="modal" data-target="#ModalCierreCaja2" onclick="cargarCaja({{ $usr->id }})"><i class='fa fa-close'></i> Cerrar caja</a></li>
                                                @else
                                                    <li><a target="_blank" href='caja_usuario_imprimir/{{ $usr->id }}'><i class='fa fa-print'></i> Imprimir</a></li>
                                                    <li><a target="_blank" href='caja_usuario_imprimir_boletin/{{ $usr->id }}'><i class='fa fa-print'></i> Imp. boletín</a></li>
                                                    <li><a target="_blank" href='caja_usuario_imprimir_por_producto_boletin/{{ $usr->id }}'><i class='fa fa-print'></i> Rep. por producto</a></li>
                                                @endif
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <script type="text/javascript">
        function cargarCaja(index) {
            var listaCaja = JSON.parse($("#listaCaja").val()).filter(d => d.id == index);
            for (var i = 0; i < listaCaja.length; i++) {
                $("#idCaja").val(listaCaja[i].id);
                $("#cajaCierre").val(listaCaja[i].caja);
                $("#fechaAbrir").val(listaCaja[i].fecha_abrir);
                $("#montoAbrir").val(listaCaja[i].monto_abrir);
                $("#montoAbrirQr").val(listaCaja[i].monto_abrir_qr);
                $("#montoCierre").val(listaCaja[i].monto_venta);
                $("#montoCierreTotal").val(listaCaja[i].monto_venta_total);
                $("#montoCierreQr").val(listaCaja[i].monto_venta_qr);
                $("#montoCierrePorCobrar").val(listaCaja[i].monto_venta_por_cobrar);
                $("#usuario").val(listaCaja[i].usuario);
                $("#notaAbrir").val(listaCaja[i].nota_abrir);
            }
            calcularMontoCierre();
        }

        function cargarCajaMonto() {
            var listaCajaMonto = JSON.parse($("#listaCajaMonto").val());
            var caja = listaCajaMonto.filter(dato => dato.caja == $("#caja").val());
            $("#estado_caja_abrir").val("Cerrada");

            if (caja.length == 0) {
                $("#monto_abrir, #monto_abrir_qr, #monto_abrir_bk, #monto_abrir_qr_bk, #id_caja_padre").val(0);
            }
            for (var i = 0; i < caja.length; i++) {
                var estado = caja[i].estado;
                $("#estado_caja_abrir").val(estado);
                if (estado == "Cerrada") {
                    $("#monto_abrir").val(caja[i].monto_cierre);
                    $("#monto_abrir_bk").val(caja[i].monto_cierre);
                    $("#monto_abrir_qr").val(caja[i].monto_cierre_qr);
                    $("#monto_abrir_qr_bk").val(caja[i].monto_cierre_qr);
                    $("#id_caja_padre").val(caja[i].id);
                } else {
                    $("#monto_abrir, #monto_abrir_qr, #monto_abrir_bk, #monto_abrir_qr_bk, #id_caja_padre").val(0);
                }
            }
        }

        function calcularMontoCierre() {
            var montoCierre = parseFloat($("#montoCierre").val()) || 0;
            var montoCierreQr = parseFloat($("#montoCierreQr").val()) || 0;
            $("#montoCierreTotal").val((montoCierre + montoCierreQr).toFixed(2));
        }

        // ── Selector de usuarios (checkboxes) ──────────────────────────
        function cUselToggle() { $('#c-usel').toggleClass('open'); }
        (function () {
            var $todos = $('#c-usel-todos'), $chk = $('.c-usel-chk');
            function actualizarLabel() {
                var n = $chk.filter(':checked').length;
                $('#c-usel-label').text(n === 0 ? 'Todos los usuarios' : n + ' seleccionado(s)');
                $todos.prop('checked', n === 0);
            }
            $todos.on('change', function () { if (this.checked) { $chk.prop('checked', false); } actualizarLabel(); });
            $chk.on('change', actualizarLabel);
            $(document).on('mousedown', function (e) {
                if (!$(e.target).closest('#c-usel').length) { $('#c-usel').removeClass('open'); }
            });
            actualizarLabel();
        })();
    </script>

@endsection
