@extends ('layouts.inicio')
@section('contenido')
    @include('alerts.success')
    @include('alerts.request')
    @include('alerts.errors')
    @include('partials.dashboard_style')

    <style type="text/css">
        .u-form .form-group{ margin-bottom:14px; }
        .u-form label{ font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:.4px; color:#8d7b6f; margin-bottom:4px; display:block; }
        .u-form .form-control{ border-radius:9px; border:1px solid #e2d3c6; height:38px; }
        .u-grid{ display:grid; grid-template-columns:1fr 1fr; gap:0 18px; }
        @media (max-width:768px){ .u-grid{ grid-template-columns:1fr; } }

        /* toggle de permiso (reemplaza el sprite) */
        input[type="checkbox"].perm{ position:absolute; opacity:0; width:0; height:0; }
        input[type="checkbox"].perm + label{ cursor:pointer; margin:0; }
        input[type="checkbox"].perm + label span{
            display:inline-block; width:40px; height:22px; border-radius:999px; background:#d7cbc2; position:relative; vertical-align:middle; transition:background .15s;
        }
        input[type="checkbox"].perm + label span::after{
            content:''; position:absolute; top:2px; left:2px; width:18px; height:18px; border-radius:50%;
            background:#fff; box-shadow:0 1px 3px rgba(0,0,0,.3); transition:transform .15s;
        }
        input[type="checkbox"].perm:checked + label span{ background:#2e7d32; }
        input[type="checkbox"].perm:checked + label span::after{ transform:translateX(18px); }

        #tabla_permisos{ font-size:12.5px; }
        #tabla_permisos thead th{ background:#fdf0e7; color:#c62828; font-size:11px; text-transform:uppercase; padding:8px 10px; border-bottom:2px solid #efe4da; }
        #tabla_permisos td{ padding:6px 10px; vertical-align:middle; }
        #tabla_permisos tr:hover td{ background:#fdfaf7; }

        .u-actions{ position:sticky; bottom:0; display:flex; gap:10px; justify-content:flex-end; padding:14px 16px;
            background:rgba(255,255,255,.94); border:1px solid #ecdfd6; border-radius:12px; margin-top:16px; box-shadow:0 -6px 20px -14px rgba(0,0,0,.4); }
        .u-actions .btn{ min-width:130px; height:40px; border-radius:10px; font-weight:700; display:inline-flex; align-items:center; justify-content:center; gap:7px; }
    </style>

    <script type="text/javascript">
        function seleccionar() {
            if ($("#privilegio").val() == "0") { $("#div_permiso").hide(); }
            else { $("#div_permiso").show(); }
        }
        function buscarNombre() {
            var nombre = $("#idEmpleado option:selected").text();
            $("#nombre").val($.trim(nombre));
        }
        $(function () { seleccionar(); });
    </script>

    <div class="dash u-form">

        <div class="dash-hero" style="margin-bottom:14px;">
            <div class="dash-hero__icon"><i class="fa fa-user-plus"></i></div>
            <div>
                <h3 class="dash-hero__title">{{ __('admins.registrar_usuario_h3') }}</h3>
                <p class="dash-hero__sub">{{ __('admins.datos_acceso_permisos') }}</p>
            </div>
        </div>

        <form method="POST" action="{{ route('administrador.store') }}" onkeypress="if(event.keyCode == 13) event.returnValue = false;" autocomplete="off">
            @csrf

            <div class="dash-card dash-card--overflow">
                <div class="dash-card__head"><i class="fa fa-id-card-o"></i> {{ __('admins.datos_del_usuario') }}</div>
                <div class="dash-card__body">
                    <div class="form-group">
                        <label>{{ __('admins.empleado_label') }}</label>
                        <div class="input-group">
                            <select name="id_empleado" id="idEmpleado" onchange="buscarNombre();" class="form-control selectpicker" data-live-search="true">
                                <option value="">{{ __('admins.buscar_el_empleado') }}</option>
                                @foreach ($cliente as $mov)
                                    <option value="{{ $mov->id }}">{{ $mov->nombre }} {{ $mov->paterno }} {{ $mov->materno }}</option>
                                @endforeach
                            </select>
                            <span class="input-group-btn">
                                <a href="{{ url('cliente') }}"><button class="btn btn-success" type="button" style="height:38px;"><i class="fa fa-plus"></i> {{ __('admins.nuevo') }}</button></a>
                            </span>
                        </div>
                    </div>

                    <div class="u-grid">
                        <div class="form-group">
                            <label for="nombre">{{ __('admins.nombre_corto') }}</label>
                            <input type="text" name="nombre" id="nombre" class="form-control" placeholder="{{ __('admins.placeholder_nombre_corto') }}" maxlength="100" value="{{ old('nombre') }}">
                        </div>
                        <div class="form-group">
                            <label for="usuario">{{ __('admins.usuario_corto') }}</label>
                            <input type="text" name="usuario" id="usuario" class="form-control" placeholder="{{ __('admins.placeholder_usuario_acceso') }}" maxlength="15" value="{{ old('usuario') }}" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="password">{{ __('admins.contrasena_corto') }}</label>
                            <input type="text" name="password" id="password" class="form-control" placeholder="{{ __('admins.placeholder_contrasena_corto') }}" maxlength="15" value="{{ old('password') }}" autocomplete="new-password">
                        </div>
                        <div class="form-group">
                            <label for="privilegio">{{ __('admins.tipo_de_usuario') }}</label>
                            <select name="privilegio" id="privilegio" class="form-control" onchange="seleccionar()">
                                <option value="0" {{ old('privilegio') == '0' ? 'selected' : '' }}>{{ __('admins.administrador') }}</option>
                                <option value="3" {{ old('privilegio') == '3' ? 'selected' : '' }}>{{ __('admins.normal') }}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>{{ __('admins.sucursal_label') }}</label>
                            <select name="id_sucursal" class="form-control selectpicker" data-live-search="true">
                                <option value="">{{ __('admins.buscar_puntos') }}</option>
                                @foreach ($sucursal as $mov)
                                    <option value="{{ $mov->id }}">{{ $mov->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="dash-card" id="div_permiso" hidden="">
                <div class="dash-card__head"><i class="fa fa-key"></i> {{ __('admins.accesos_modulos') }}</div>
                <div class="dash-card__body dash-card__body--flush">
                    <table class="table" id="tabla_permisos" style="margin:0;background:#fff;">
                        <thead><tr><th style="text-align:left;">{{ __('admins.col_modulo') }}</th><th style="text-align:center;width:90px;">{{ __('admins.col_acceso') }}</th></tr></thead>
                        <tbody>
                            @foreach ($acceso as $ac)
                                <tr>
                                    <td>{{ $ac->modulo }}</td>
                                    <td style="text-align:center;">
                                        <input type="checkbox" class="perm" id="{{ $ac->id }}-" name="{{ $ac->id }}-" hidden>
                                        <input type="checkbox" class="perm" id="{{ $ac->id }}+" name="{{ $ac->id }}+">
                                        <label for="{{ $ac->id }}+"><span></span></label>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="u-actions">
                <a href="{!! URL::to('usuarios/empresa') !!}" class="btn btn-danger"><i class="fa fa-times"></i> {{ __('admins.cancelar') }}</a>
                <button type="submit" class="btn btn-success" id="btn_registrar" onclick="btn_esconder()"><i class="fa fa-save"></i> {{ __('admins.registrar_usuario') }}</button>
            </div>
        </form>

    </div>
@endsection
