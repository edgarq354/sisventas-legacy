@extends ('layouts.inicio')
@section ('contenido')
@include('alerts.success')
@include('alerts.request')
@include('alerts.errors')
@include('cliente.modal')
@include('partials.dashboard_style')

<style type="text/css">
    #tabla_sin_imprimir{ font-size:12.5px; }
    #tabla_sin_imprimir thead th{ padding:8px 10px !important; font-size:11px; text-transform:uppercase; letter-spacing:.4px;
        background:#fdf0e7; color:#c62828; border-bottom:2px solid #efe4da; text-align:left; }
    #tabla_sin_imprimir tbody td{ padding:7px 10px !important; vertical-align:middle; }
    #tabla_sin_imprimir tbody tr:hover{ background:#fdfaf7; }
    .cl-actions{ display:flex; flex-wrap:wrap; gap:10px; margin-bottom:16px; }
    .cl-actions .cl-btn{ display:inline-flex; align-items:center; justify-content:center; gap:7px; min-width:150px; height:42px;
        padding:0 18px; border-radius:10px; font-weight:700; font-size:13px; color:#fff; border:0; text-decoration:none; cursor:pointer;
        box-shadow:0 6px 16px -9px rgba(0,0,0,.5); }
    .cl-actions .cl-btn:hover{ filter:brightness(1.07); color:#fff; }
    .cl-btn--add{ background:linear-gradient(135deg,#2e7d32,#66bb6a); }
    .cl-btn--print{ background:#c62828; }
    .cl-tag{ display:inline-flex; align-items:center; gap:5px; font-size:10.5px; font-weight:700; padding:2px 9px; border-radius:999px; }
    .cl-tag--c{ background:rgba(43,108,176,.12); color:#2b6cb0; }
    .cl-tag--p{ background:rgba(239,108,0,.14); color:#b45309; }
    .cl-tag--e{ background:rgba(46,125,50,.12); color:#2e7d32; }
    .cl-tel{ display:inline-flex; align-items:center; gap:6px; font-size:12px; font-weight:600; color:#2b6cb0; }
</style>

<div class="dash">

    <div class="dash-hero" style="margin-bottom:14px;">
        <div class="dash-hero__icon"><i class="fa fa-users"></i></div>
        <div>
            <h3 class="dash-hero__title">{{ __('cliente.titulo_clientes') }}</h3>
            <p class="dash-hero__sub">{{ __('cliente.registrados', ['count' => count($cliente)]) }}</p>
        </div>
    </div>

    <div class="cl-actions">
        <a class="cl-btn cl-btn--add" href="{!! URL::to('cliente/create') !!}"><i class="fa fa-plus"></i> {{ __('cliente.agregar_cliente') }}</a>
        <a class="cl-btn cl-btn--print" href="cliente_imprimir" target="_blank"><i class="fa fa-print"></i> {{ __('cliente.imprimir') }}</a>
    </div>

    <div class="dash-card">
        <div class="dash-card__head"><i class="fa fa-list"></i> {{ __('cliente.lista_clientes') }}</div>
        <div class="dash-card__body dash-card__body--flush">
            <div class="table-responsive" style="overflow-x:auto;">
                <table class="table table-striped table-hover" id="tabla_sin_imprimir" style="background:white;margin:0;">
                    <thead>
                        <th>{{ __('cliente.col_ci_nit') }}</th>
                        <th>{{ __('cliente.col_nombre') }}</th>
                        <th>{{ __('cliente.col_telefono') }}</th>
                        <th>{{ __('cliente.col_tipo') }}</th>
                        <th style="text-align:right;">...</th>
                    </thead>
                    <tbody id="body_cliente">
                        @foreach($cliente as $usr)
                            <tr>
                                <td>{{ $usr->ci_nit }}</td>
                                <td><b>{{ $usr->nombre }} {{ $usr->paterno }} {{ $usr->materno }}</b></td>
                                <td>
                                    @if(strlen($usr->telefono) > 0)
                                        <span class="cl-tel"><i class="fa fa-phone"></i> {{ $usr->telefono }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if($usr->tipo_c==1)<span class="cl-tag cl-tag--c">{{ __('cliente.tag_cliente') }}</span> @endif
                                    @if($usr->tipo_p==1)<span class="cl-tag cl-tag--p">{{ __('cliente.tag_proveedor') }}</span> @endif
                                    @if($usr->tipo_e==1)<span class="cl-tag cl-tag--e">{{ __('cliente.tag_empleado') }}</span>@endif
                                    @if($usr->tipo_e==1 && $usr->fecha_ingreso)<br><span style="font-size:10px;color:#8d7b6f;">{{ __('cliente.ing_fecha', ['fecha' => $usr->fecha_ingreso]) }}</span>@endif
                                </td>
                                <td style="text-align:right;">
                                    <a class="btn btn-primary btn-sm" href='cliente/{{ $usr->id }}/edit' title="{{ __('cliente.ver_y_editar') }}"><i class="fa fa-pencil"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<script src="{{ asset('js/cliente.js') }}"></script>
@endsection
