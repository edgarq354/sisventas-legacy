@extends ('layouts.inicio')
@section ('contenido')
@include('alerts.success')
@include('alerts.request')
@include('alerts.errors')
@include('tipo_gasto.modal')
<script>

function cargar_categoria(id){
    $.get('cargar_categoria/'+id , function (response) {
        $("#id_empresa_edit").val(response[0].id_empresa);
        $("#id_categoria_edit").val(response[0].id);
        $("#id_categoria").val(response[0].id);
        $("#nombre_edit").val(response[0].nombre);
        if (response[0].estado==1) {
 		$("#estado_edit").prop( "checked", true);
        }else{
 		$("#estado_edit").prop( "checked", false);
        }

        if (response[0].estado_pedido==1) {
        $("#estado_pedido_edit").prop( "checked", true);
        }else{
        $("#estado_pedido_edit").prop( "checked", false);
        }

    });
}



function cargar_tipo_gasto(id){
    $.get('cargar_tipo_gasto/'+id , function (response) {
        $("#id_empresa_edit").val(response[0].id_empresa);
        $("#id_tipo_gasto_edit").val(response[0].id);
        $("#id_tipo_gasto_edit_2").val(response[0].id);
        $("#nombre_edit").val(response[0].nombre);
         if (response[0].estado==1) {
        $("#estado_edit").prop( "checked", true);
        }else{
        $("#estado_edit").prop( "checked", false);
        }


    });
}
</script>


<div style="display: none;" id="cargador_empresa" align="center">
            <br>


         <label style="color:#FFF; background-color:#ABB6BA; text-align:center">&nbsp;&nbsp;&nbsp;{{ __('tipo_gasto.espere') }} &nbsp;&nbsp;&nbsp;</label>

         <img src="images/cargando.gif" align="middle" alt="cargador"> &nbsp;<label style="color:#ABB6BA">{{ __('tipo_gasto.realizando_tarea') }}</label>

          <br>
         <hr style="color:#003" width="50%">
         <br>
       </div>



@include('partials.dashboard_style')

<style type="text/css">
    #tabla_sin_imprimir{ font-size:12.5px; }
    #tabla_sin_imprimir thead th{ padding:8px 10px !important; font-size:11px; text-transform:uppercase; letter-spacing:.4px;
        background:#fdf0e7; color:#c62828; border-bottom:2px solid #efe4da; text-align:left; }
    #tabla_sin_imprimir tbody td{ padding:7px 10px !important; vertical-align:middle; }
    #tabla_sin_imprimir tbody tr:hover{ background:#fdfaf7; }
    .tg-actions{ display:flex; flex-wrap:wrap; gap:10px; margin-bottom:16px; }
    .tg-actions .tg-btn{ display:inline-flex; align-items:center; justify-content:center; gap:7px; min-width:150px; height:42px;
        padding:0 18px; border-radius:10px; font-weight:700; font-size:13px; color:#fff; border:0; text-decoration:none; cursor:pointer;
        box-shadow:0 6px 16px -9px rgba(0,0,0,.5); }
    .tg-actions .tg-btn:hover{ filter:brightness(1.07); color:#fff; }
    .tg-btn--add{ background:linear-gradient(135deg,#2e7d32,#66bb6a); }
    .tg-btn--print{ background:#c62828; }
    .tg-estado{ display:inline-flex; align-items:center; gap:6px; font-size:11px; font-weight:700; padding:3px 10px; border-radius:999px; }
    .tg-estado--on{ background:rgba(46,125,50,.12); color:#2e7d32; }
    .tg-estado--off{ background:rgba(198,40,40,.12); color:#c62828; }
</style>

<div class="dash">

    <div class="dash-hero" style="margin-bottom:14px;">
        <div class="dash-hero__icon"><i class="fa fa-tags"></i></div>
        <div>
            <h3 class="dash-hero__title">{{ __('tipo_gasto.tipos_de_gasto') }}</h3>
            <p class="dash-hero__sub">{{ __('tipo_gasto.registrados', ['count' => count($tipo_gasto)]) }}</p>
        </div>
    </div>

    <div class="tg-actions">
        <a class="tg-btn tg-btn--add" data-toggle="modal" data-target="#ModalCrearNuevo"><i class="fa fa-plus"></i> {{ __('tipo_gasto.agregar_tipo') }}</a>
        <a class="tg-btn tg-btn--print" href="tipo_gasto_imprimir" target="_blank"><i class="fa fa-print"></i> {{ __('tipo_gasto.imprimir') }}</a>
    </div>

    <div class="dash-card">
        <div class="dash-card__head"><i class="fa fa-list"></i> {{ __('tipo_gasto.lista') }}</div>
        <div class="dash-card__body dash-card__body--flush">
            <div class="table-responsive" style="overflow-x:auto;">
                <table class="table table-striped table-hover" id="tabla_sin_imprimir" style="background:white;margin:0;">
                    <thead>
                        <th style="width:55px;"><center>{{ __('tipo_gasto.col_id') }}</center></th>
                        <th>{{ __('tipo_gasto.col_nombre') }}</th>
                        <th style="text-align:center;">{{ __('tipo_gasto.col_estado') }}</th>
                        <th style="text-align:right;">{{ __('tipo_gasto.col_opciones') }}</th>
                    </thead>
                    <tbody id="body_tipo_producto">
                        @foreach($tipo_gasto as $usr)
                            <tr>
                                <td><center>{{ $usr->id }}</center></td>
                                <td><b>{{ $usr->nombre }}</b></td>
                                <td style="text-align:center;">
                                    @if($usr->estado==1)
                                        <span class="tg-estado tg-estado--on"><i class="fa fa-circle" style="font-size:8px;"></i> {{ __('tipo_gasto.activo') }}</span>
                                    @else
                                        <span class="tg-estado tg-estado--off"><i class="fa fa-circle" style="font-size:8px;"></i> {{ __('tipo_gasto.inactivo') }}</span>
                                    @endif
                                </td>
                                <td style="text-align:right;">
                                    <button class='btn btn-primary btn-sm' data-toggle="modal" onclick="cargar_tipo_gasto({{ $usr->id }});" data-target="#ModalEditar"><i class="fa fa-pencil"></i> {{ __('tipo_gasto.editar') }}</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tbody id="body_conductor_2"></tbody>
                </table>
            </div>
        </div>
    </div>

</div>


<script src="{{ asset('js/categoria_edit.js') }}"></script>

@endsection
