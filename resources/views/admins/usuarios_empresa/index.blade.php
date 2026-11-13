@extends ('layouts.inicio')
@section ('contenido')
@include('alerts.success')
@include('alerts.request')
@include('alerts.errors')
@include('admins.usuarios_empresa.modal_usuario')
@include('partials.dashboard_style')

<style type="text/css">
    #tabla_sin_imprimir{ font-size:12.5px; }
    #tabla_sin_imprimir thead th{ padding:8px 10px !important; font-size:11px; text-transform:uppercase; letter-spacing:.4px;
        background:#fdf0e7; color:#c62828; border-bottom:2px solid #efe4da; text-align:left; }
    #tabla_sin_imprimir tbody td{ padding:7px 10px !important; vertical-align:middle; }
    #tabla_sin_imprimir tbody tr:hover{ background:#fdfaf7; }
    #tabla_sin_imprimir .btn{ padding:4px 9px; border-radius:8px; font-size:12px; }
    .ue-rol{ display:inline-block; padding:3px 10px; border-radius:999px; font-size:11px; font-weight:700; }
    .ue-rol--admin{ background:rgba(198,40,40,.12); color:#c62828; }
    .ue-rol--normal{ background:rgba(46,125,50,.12); color:#2e7d32; }
    .ue-actions{ display:flex; flex-wrap:wrap; gap:10px; margin-bottom:18px; }
    .ue-actions .ue-btn{
        display:inline-flex; align-items:center; justify-content:center; gap:7px;
        min-width:150px; height:42px; padding:0 18px; border-radius:10px;
        font-weight:700; font-size:13px; color:#fff; border:0; text-decoration:none; cursor:pointer;
        box-shadow:0 6px 16px -9px rgba(0,0,0,.5); transition:transform .1s, filter .12s;
    }
    .ue-actions .ue-btn:hover{ transform:translateY(-1px); filter:brightness(1.07); color:#fff; }
    .ue-btn--add{ background:linear-gradient(135deg,#2e7d32,#66bb6a); }
    .ue-btn--print{ background:#c62828; }
    @media (max-width:600px){ .ue-actions .ue-btn{ flex:1 1 45%; min-width:0; } }
</style>

<div class="dash">

    <div class="dash-hero" style="margin-bottom:14px;">
        <div class="dash-hero__icon"><i class="fa fa-users"></i></div>
        <div>
            <h3 class="dash-hero__title">Usuarios de la empresa</h3>
            <p class="dash-hero__sub">{{ count($usuarios) }} usuarios registrados</p>
        </div>
    </div>

    <div class="ue-actions">
        <a class="ue-btn ue-btn--add" href="{!! URL::to('usuarios/crear_usuario') !!}"><i class="fa fa-plus"></i> Agregar usuario</a>
        <a class="ue-btn ue-btn--print" href="usuario_imprimir" target="_blank"><i class="fa fa-print"></i> Imprimir</a>
    </div>

    <div class="dash-card">
        <div class="dash-card__head"><i class="fa fa-list"></i> Roles de usuario</div>
        <div class="dash-card__body dash-card__body--flush">
            <div class="table-responsive" style="overflow-x:auto;">
                <table class="table table-striped table-hover" id="tabla_sin_imprimir" style="background:white;margin:0;">
                    <thead>
                        <th>Nombre</th>
                        <th>Usuario</th>
                        <th>Rol</th>
                        <th style="text-align:right;">Opciones</th>
                    </thead>
                    <tbody id="body_usuario">
                        @foreach($usuarios as $user)
                            @php
                                $tipo = $user->privilegio == 0 ? 'ADMINISTRADOR' : ($user->privilegio == 3 ? 'NORMAL' : '—');
                            @endphp
                            <tr>
                                <td><b>{{ $user->nombre }}</b></td>
                                <td>{{ $user->usuario }}</td>
                                <td>
                                    <span class="ue-rol {{ $user->privilegio == 0 ? 'ue-rol--admin' : 'ue-rol--normal' }}">{{ $tipo }}</span>
                                </td>
                                <td style="text-align:right;white-space:nowrap;">
                                    <a class='btn btn-primary' href='actualizar_usuarios_empresa/{{ $user->id }}' title="Editar"><i class="fa fa-pencil"></i></a>
                                    <button class="btn btn-warning" data-toggle="modal" data-target="#historial_inicio_sesion" onclick="Cargar_historial_inicio_sesion_empresa({{ $user->id }})" title="Historial de sesiones"><i class="fa fa-history"></i></button>
                                    <button class="btn btn-default" data-toggle="modal" data-target="#ModalContraseña_usuario" onclick="Cargar_Admin_Usuario({{ $user->id }},{{ $user->id_empresa }},{{ $user->privilegio }},'')"><i class="fa fa-key"></i> Contraseña</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tbody align="center" id="body_usuario_2"></tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<script src="{{ asset('js/admins_usuario.js') }}"></script>
@endsection
