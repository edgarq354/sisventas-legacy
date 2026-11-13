@extends ('layouts.inicio')
@section('contenido')
    @include('alerts.success')
    @include('alerts.request')
    @include('alerts.errors')
    @include('partials.dashboard_style')

    @php $user = $usuario[0]; @endphp

    <style type="text/css">
        .u-form .form-group{ margin-bottom:14px; }
        .u-form label{ font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:.4px; color:#8d7b6f; margin-bottom:4px; display:block; }
        .u-form .form-control{ border-radius:9px; border:1px solid #e2d3c6; height:38px; }
        .u-grid{ display:grid; grid-template-columns:1fr 1fr; gap:0 18px; }
        @media (max-width:768px){ .u-grid{ grid-template-columns:1fr; } }

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
        $(function () { seleccionar(); });
    </script>

    <div class="dash u-form">

        <div class="dash-hero" style="margin-bottom:14px;">
            <div class="dash-hero__icon"><i class="fa fa-user"></i></div>
            <div>
                <h3 class="dash-hero__title">Actualizar usuario</h3>
                <p class="dash-hero__sub">{{ $user->nombre }} &middot; {{ $user->usuario }}</p>
            </div>
        </div>

        <form method="POST" action="{{ url('usuario_update_empresa') }}" enctype="multipart/form-data"
              onkeypress="if(event.keyCode == 13) event.returnValue = false;" autocomplete="off">
            @csrf
            <input type="hidden" name="id_usuario" id="id_usuario" value="{{ $user->id }}">
            <input type="hidden" name="id_emp" id="id_emp" value="{{ $user->id_empresa }}">
            <input type="hidden" name="usuario_aux" id="usuario_aux" value="{{ $user->usuario }}">

            <div class="dash-card dash-card--overflow">
                <div class="dash-card__head"><i class="fa fa-id-card-o"></i> Datos del usuario</div>
                <div class="dash-card__body">
                    <div class="u-grid">
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input type="text" name="nombre" id="nombre" class="form-control" maxlength="100" value="{{ old('nombre', $user->nombre) }}">
                        </div>
                        <div class="form-group">
                            <label for="usuario">Usuario</label>
                            <input type="text" name="usuario" id="usuario" class="form-control" maxlength="15" value="{{ old('usuario', $user->usuario) }}" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="privilegio">Tipo de usuario</label>
                            <select name="privilegio" id="privilegio" class="form-control" onchange="seleccionar()">
                                <option value="0" {{ old('privilegio', $user->privilegio) == 0 ? 'selected' : '' }}>ADMINISTRADOR</option>
                                <option value="3" {{ old('privilegio', $user->privilegio) == 3 ? 'selected' : '' }}>NORMAL</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="id_sucursal">Sucursal</label>
                            <select name="id_sucursal" id="id_sucursal" class="form-control selectpicker" data-live-search="true">
                                <option value="">Buscar…</option>
                                @foreach ($sucursal as $mov)
                                    <option value="{{ $mov->id }}" {{ (old('id_sucursal', $user->id_sucursal) == $mov->id) ? 'selected' : '' }}>{{ $mov->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="id_empleado">Empleado <span style="text-transform:none;color:#b8a99b;font-weight:600;">(opcional)</span></label>
                            <select name="id_empleado" id="id_empleado" class="form-control selectpicker text-uppercase" data-live-search="true">
                                <option value="">— Sin cambios —</option>
                                @foreach ($empleado as $mov)
                                    <option value="{{ $mov->id }}" {{ (string) old('id_empleado', $user->id_empleado) === (string) $mov->id ? 'selected' : '' }}>
                                        {{ $mov->nombre }} {{ $mov->paterno }} {{ $mov->materno }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="dash-card" id="div_permiso" @if ($user->privilegio == 0) hidden="" @endif>
                <div class="dash-card__head"><i class="fa fa-key"></i> Permisos por módulo</div>
                <div class="dash-card__body dash-card__body--flush">
                    <table class="table" id="tabla_permisos" style="margin:0;background:#fff;">
                        <thead><tr><th style="text-align:left;">Módulo</th><th style="text-align:center;width:90px;">Acceso</th></tr></thead>
                        <tbody>
                            @foreach ($acceso as $ac)
                                @php
                                    $lectura = false; $escritura = false;
                                    foreach ($permiso as $value) {
                                        if ($ac->id == $value->id_acceso && $value->lectura == 1) $lectura = true;
                                        if ($ac->id == $value->id_acceso && $value->escritura == 2) $escritura = true;
                                    }
                                @endphp
                                <tr>
                                    <td>{{ $ac->modulo }}</td>
                                    <td style="text-align:center;">
                                        <input type="checkbox" class="perm" id="{{ $ac->id }}-" name="{{ $ac->id }}-" value="1" {{ $lectura ? 'checked' : '' }} hidden>
                                        <input type="checkbox" class="perm" id="{{ $ac->id }}+" name="{{ $ac->id }}+" value="2" {{ $escritura ? 'checked' : '' }}>
                                        <label for="{{ $ac->id }}+"><span></span></label>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="u-actions">
                <a href="{!! URL::to('usuarios/empresa') !!}" class="btn btn-danger"><i class="fa fa-times"></i> Cancelar</a>
                <button type="submit" class="btn btn-primary" id="btn_registrar" onclick="btn_esconder()"><i class="fa fa-save"></i> Actualizar</button>
            </div>
        </form>

    </div>
@endsection
