@extends ('layouts.inicio')
@section ('contenido')
@include('alerts.success')
@include('alerts.request')
@include('alerts.errors')

<script type="text/javascript">
	function cargarNotaVenta(index){
		var listaNotaVenta=JSON.parse($("#listaNotaVenta").val()); 
		listaNotaVenta=listaNotaVenta.filter(dato=>dato.id==index);
		var total=0;
		 
			for (var i = 0; i < listaNotaVenta.length; i++) {  
				$("#idNotaVenta").text(listaNotaVenta[i].id);
				$("#ciNit").val(listaNotaVenta[i].ci_nit);
				$("#razonSocial").val(listaNotaVenta[i].razon_social);
				$("#montoTotal").val(listaNotaVenta[i].monto_total);
				$("#usuario").val(listaNotaVenta[i].usuario);  
				$("#fecha").val(listaNotaVenta[i].fecha); 
				total=listaNotaVenta[i].monto_total;
			} 

		this.obtenerObtenerNotaVenta(index,total);		
	}

	function obtenerObtenerNotaVenta(id,total){

	    $.get("../../get_nota_venta_por_id/"+id, function (res) {
	     var listaDetalle=res.detalle_venta;


	     $('#body_detalle').empty(); 
	var tabladatos=$("#body_detalle"); 
	var monto_total=0;
	for (var i = 0; i < listaDetalle.length; i++) {   
		tabladatos.append('<tr> <td>\n\
			 	'+listaDetalle[i].nombre+'</td><td>'+listaDetalle[i].peso+'</td><td>'+listaDetalle[i].sub_total+'</td> \n\
			</tr>'); 
	}
	tabladatos.append('<tr style="font-weight:bold;"> <td colspan="2">\n\
			 	TOTAL: </td><td>'+total+'</td> \n\
			</tr>'); 

	    
	    });
	}

	function cargarNotaVentaCancelar(index){
		$("#idNotaVentaCancelar").val(index);	
	}
	function cargarNotaVentaActualizarEstado(id_nota_venta){
		$("#idNotaVentaActualizarEstado").val(id_nota_venta);	
	}

	function cancelarNota( )
{
      //  var miurl="asignar_usuario_pedido/"+id_pedido_c+"/"+ci+"/"+placa; 
       var  token = $('input[name="_token"]').val();
        var miurl="../../cancelar_nota_venta"; 
        var divresul="notificacion_resultado";
        //información del formulario
        var formData =  new FormData();     
        formData.append( 'id', $("#idNotaVentaCancelar").val()); 
        formData.append( '_token', token);

        //hacemos la petición ajax   
        $.ajax({
            url: miurl,  
            type: 'POST',
            // Form data
            //datos del formulario
            data: formData,
            //necesario para subir archivos via ajax
            cache: false,
            contentType: false,
            processData: false,
            //mientras enviamos el archivo
            beforeSend: function(){
              $("#"+divresul+"").html($("#cargando_asignacion").html());                
            },
            //una vez finalizado correctamente
            success: function(data){
              alertify.success(":"+data);
              window.location.href = window.location.href;
              $("#"+divresul+"").html(@json(__('nota_venta.asignacion_completado')));   
            },
            //si ha ocurrido un error
            error: function(data){
               alertify.error(@json(__('nota_venta.ha_ocurrido_error'))+data) ;
                
            }
        });

}

function buscarEnlace(){
	var fechaInicio=$("#calendario1").val();
	var fechaFinal=$("#calendario2").val();

	$("#buscar").prop("href", "../../nota_venta_historial/"+fechaInicio+"/"+fechaFinal);
	$("#imprimir").prop("href", "../../nota_venta_historial_imprimir/"+fechaInicio+"/"+fechaFinal);
	$("#imprimir_por_dia").prop("href", "../../nota_venta_historial_por_dia_imprimir/"+fechaInicio+"/"+fechaFinal);
}

</script>





<?php
$message=Session::get('message');
?>


<input type="hidden" id="listaNotaVenta" value="{{json_encode($nota_venta)}}">

@if($message=='store')
<div class="alert alert-success alert-dismissible" role="alert">
<button type="button" class="close" data-dismiss="alert" arial-label="Close"><span aria-hidden="true">$times;</span></button>
	{{ __('nota_venta.pago_registrado') }}
</div>
@endif
@include('partials.dashboard_style')

<style type="text/css">
    #tabla_sin_imprimir{ font-size:12.5px; }
    #tabla_sin_imprimir thead th{ padding:8px 10px !important; font-size:11px; text-transform:uppercase; letter-spacing:.4px;
        background:#fdf0e7; color:#c62828; border-bottom:2px solid #efe4da; text-align:left; }
    #tabla_sin_imprimir tbody td{ padding:6px 10px !important; vertical-align:middle; }
    #tabla_sin_imprimir tbody tr:hover{ background:#fdfaf7; }
    #tabla_sin_imprimir .badge{ font-size:10px; padding:3px 8px; border-radius:999px; }
    #tabla_sin_imprimir td.num{ text-align:right; font-weight:700; }
    #tabla_sin_imprimir .btn-group .btn{ padding:3px 9px; border-radius:8px; font-size:12px; }
    .vh-filtros{ display:flex; flex-wrap:wrap; gap:10px 14px; align-items:flex-end; }
    .vh-filtros .fld{ display:flex; flex-direction:column; gap:3px; }
    .vh-filtros label{ font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:.5px; color:#8d7b6f; margin:0; }
    .vh-filtros input[type=text]{ height:36px; border:1px solid #e2d3c6; border-radius:8px; padding:0 10px; font-size:13px; background:#fff; }
    .vh-btn{ display:inline-flex; align-items:center; justify-content:center; gap:7px; height:36px; padding:0 14px;
        border-radius:9px; font-weight:700; font-size:12.5px; color:#fff; border:0; text-decoration:none; box-shadow:0 6px 16px -9px rgba(0,0,0,.5); }
    .vh-btn:hover{ filter:brightness(1.07); color:#fff; }
    .vh-btn--buscar{ background:linear-gradient(135deg,#ef6c00,#f9a825); }
    .vh-btn--print{ background:#c62828; }
    .vh-total b{ font-size:20px; color:#2e7d32; }
</style>

@php $total_ventas = collect($nota_venta)->where('estado','!=','Cancelado')->sum(fn($n) => (float) $n->monto_total); @endphp

<div class="dash">

    <div class="dash-hero" style="margin-bottom:14px;">
        <div class="dash-hero__icon"><i class="fa fa-history"></i></div>
        <div>
            <h3 class="dash-hero__title">{{ __('nota_venta.titulo_historial_ventas') }}</h3>
            <p class="dash-hero__sub">{!! __('nota_venta.del_al_registros', ['desde' => $fechaInicio, 'hasta' => $fechaFinal, 'count' => count($nota_venta)]) !!}</p>
        </div>
    </div>

    <div class="dash-card dash-card--overflow">
        <div class="dash-card__body">
            <div class="vh-filtros">
                <div class="fld"><label>{{ __('nota_venta.desde') }}</label><input type="text" value="{{ $fechaInicio }}" id="calendario1" onmouseover="buscarEnlace();" autocomplete="off"></div>
                <div class="fld"><label>{{ __('nota_venta.hasta') }}</label><input type="text" value="{{ $fechaFinal }}" id="calendario2" onmouseover="buscarEnlace();" autocomplete="off"></div>
                <div class="fld"><label>&nbsp;</label>
                    <div>
                        <a class="vh-btn vh-btn--buscar" href="../../nota_venta_historial/{{ $fechaInicio }}/{{ $fechaFinal }}" id="buscar" onmouseover="buscarEnlace();"><i class="fa fa-search"></i> {{ __('nota_venta.buscar') }}</a>
                        <a class="vh-btn vh-btn--print" href="../../nota_venta_historial_imprimir/{{ $fechaInicio }}/{{ $fechaFinal }}" id="imprimir" onmouseover="buscarEnlace();"><i class="fa fa-print"></i> {{ __('nota_venta.imprimir') }}</a>
                        <a class="vh-btn vh-btn--print" href="../../nota_venta_historial_por_dia_imprimir/{{ $fechaInicio }}/{{ $fechaFinal }}" id="imprimir_por_dia" onmouseover="buscarEnlace();"><i class="fa fa-calendar"></i> {{ __('nota_venta.resumen_por_dia') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="dash-card">
        <div class="dash-card__head">
            <i class="fa fa-list"></i> {{ __('nota_venta.ventas_header') }}
            <span class="dash-card__extra vh-total">{{ __('nota_venta.total_colon') }} <b>Bs {{ number_format($total_ventas, 2) }}</b></span>
        </div>
        <div class="dash-card__body dash-card__body--flush">
            <div class="table-responsive" style="overflow-x:auto;">
                <table class="table table-striped table-hover" id="tabla_sin_imprimir" style="background:white;margin:0;">
                    <thead>
                        <th style="width:55px;"><center>{{ __('nota_venta.col_id') }}</center></th>
                        @if(Auth::user()->tipo_empresa=="RESTAURANTE")<th style="text-align:center;">{{ __('nota_venta.col_ticket') }}</th>@endif
                        <th>{{ __('nota_venta.col_fecha') }}</th>
                        <th>{{ __('nota_venta.col_cliente') }}</th>
                        <th style="text-align:right;">{{ __('nota_venta.col_monto') }}</th>
                        <th>{{ __('nota_venta.col_modalidad') }}</th>
                        <th>{{ __('nota_venta.col_usuario') }}</th>
                        <th style="text-align:center;">{{ __('nota_venta.col_estado') }}</th>
                        <th style="text-align:center;">...</th>
                    </thead>
                    <tbody>
                        @forelse($nota_venta as $pago)
                            <tr>
                                <td><center>{{ $pago->id }}</center></td>
                                @if(Auth::user()->tipo_empresa=="RESTAURANTE")<td style="text-align:center;">{{ $pago->numero_ticket }}</td>@endif
                                <td>{{ $pago->fecha }}</td>
                                <td>{{ $pago->razon_social }}</td>
                                <td class="num">{{ number_format((float)$pago->monto_total, 2) }}</td>
                                <td>{{ $pago->tipo }}</td>
                                <td>{{ $pago->usuario }}</td>
                                <td style="text-align:center;">
                                    @if($pago->estado=='Procesado')<span class="badge btn-success">{{ __('estados.'.$pago->estado) }}</span>
                                    @elseif($pago->estado=='Por cobrar')<span class="badge btn-warning">{{ __('estados.'.$pago->estado) }}</span>
                                    @elseif($pago->estado=='Qr')<span class="badge btn-warning">Qr</span>
                                    @elseif($pago->estado=='QrFie')<span class="badge btn-info">{{ __('nota_venta.qr_b_fie') }}</span>
                                    @else<span class="badge btn-danger">{{ __('estados.'.$pago->estado) }}</span>@endif
                                </td>
                                <td style="text-align:center;">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown">{{ __('nota_venta.opcion') }} <span class="caret"></span></button>
                                        <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                            <li><a data-toggle="modal" data-target="#ModalVenta" onclick="cargarNotaVenta({{ $pago->id }});"><i class="fa fa-eye"></i> {{ __('nota_venta.ver_detalle') }}</a></li>
                                            <li><a href='../../nota_venta_imprimir/{{ $pago->id }}' target="_blank"><i class="fa fa-print"></i> {{ __('nota_venta.imprimir') }}</a></li>
                                            <li><a href='../../nota_venta_imprimir_pequenio/{{ $pago->id }}' target="_blank"><i class="fa fa-print"></i> {{ __('nota_venta.boletin') }}</a></li>
                                            @if($pago->estado!='Cancelado')
                                                <li><a href="" data-toggle="modal" data-target="#ModalCancelarVenta" onclick="cargarNotaVentaCancelar({{ $pago->id }})"><i class="fa fa-close"></i> {{ __('nota_venta.cancelar_venta') }}</a></li>
                                            @endif
                                            @if($pago->estado=='Por cobrar')
                                                <li><a href="" data-toggle="modal" data-target="#ModalEstado" onclick="cargarNotaVentaActualizarEstado({{ $pago->id }})"><i class="fa fa-refresh"></i> {{ __('nota_venta.marcar_cobrado') }}</a></li>
                                            @endif
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="9" class="dash-empty">{{ __('nota_venta.sin_ventas_periodo') }}</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>


<!-- Modal NOTA VENTA-->
<div id="ModalVenta" class="modal fade" role="dialog">
	<div class="modal-dialog modal-md">
	  <!-- Modal content-->
	  <div class="modal-content">
  
		<div class="modal-header" style="background: #d4463e; color: white">
		  <h3 class="modal-title">{{ __('nota_venta.modal_venta_titulo') }} <label id="idNotaVenta"></label></h3>
		</div>   
		
  
		<div class="modal-body">
   
   
   			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
  
				<div style="margin: 15px;">
					<label>{{ __('nota_venta.nombre_label') }}</label><br>
					<input type="text"  id="razonSocial"  class="form-control" readonly="" />
	  			</div>
	 

				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 " > 
					<input type="hidden" id='indexCarrito'  /> 
	 
    
					<div class="form-group">
					<label>{{ __('nota_venta.nit_ci_label') }}</label><br>
					<input type="decimal"  class="form-control" id="ciNit"  readonly="" />
					</div>
	
					<div class="form-group">
						<label>{{ __('nota_venta.fecha_label') }}</label><br>
						<input type="decimal"  class="form-control" id="fecha" readonly="" />
					</div>
				</div>
	  
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 " > 	  
					<div class="form-group">
					<label>{{ __('nota_venta.monto_total_label') }}</label><br>
					<input type="decimal"   class="form-control" id="montoTotal" readonly=""  >
					</div>

					<div class="form-group">
					<label>{{ __('nota_venta.usuario_label') }}</label><br>
					<input type="text"   class="form-control" id="usuario" readonly=""  >
					</div>
				</div>
  			 </div>
		</div>

		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
			<table class="table table-striped table-bordered table-condensed table-hover" style="background: white">
				<thead>
					
					<th><center>{{ __('nota_venta.col_producto') }}</center></th>  
					<th><center>{{ __('nota_venta.col_cantidad') }}</center></th> 
					<th><center>{{ __('nota_venta.col_total') }}</center></th> 
				</thead>
				<tbody align="center" id="body_detalle">					
				
				</tbody>
			</table>
		</div>
  
  
		<div class="modal-footer"> 
			<button data-dismiss="modal"  class="btn btn-warning form-control" >
				<i class="fa fa-close" aria-hidden="true"></i> {{ __('nota_venta.cerrar') }}</button>
		</div>
	</div>
</div>
</div>

<!-- Modal CANCELAR NOTA VENTA-->
<div id="ModalCancelarVenta" class="modal fade" role="dialog">
	<div class="modal-dialog modal-md">
	  <!-- Modal content-->
	  <div class="modal-content">
  
		<div class="modal-header" style="background: #d4463e; color: white">
		  <h3 class="modal-title">{{ __('nota_venta.cancelar_venta_titulo') }} </h3>
		</div>   
		
  
		<div class="modal-body">
   
   
   			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
  				<input type="hidden" id="idNotaVentaCancelar">
				 <center><h3>{{ __('nota_venta.cancelar_venta_aviso') }}</h3></center>

  			 </div>
		</div>

		 
  
  
		<div class="modal-footer"> 
			<button data-dismiss="modal"  class="btn btn-warning "  onclick="cancelarNota();">
				<i class="fa fa-save" aria-hidden="true"></i> {{ __('nota_venta.aceptar') }}</button>
			<button data-dismiss="modal"  class="btn btn-danger " >
				<i class="fa fa-save" aria-hidden="true"></i> {{ __('nota_venta.cerrar') }}</button>	
		</div>
	</div>
</div>
</div>





<!-- Modal ACTUALIZAR ESTADO-->
<div id="ModalEstado" class="modal fade" role="dialog">
	<div class="modal-dialog modal-md">
	   
      <div class="modal-content">
        <form action="{{ url('actualizar_estado_nota_venta') }}" 
		method="POST" 
		enctype="multipart/form-data" 
		onkeypress="if(event.keyCode == 13) event.returnValue = false;">
		@csrf   

        <div class="modal-header" style="background: #3984ca; color: white">
          <h3 class="modal-title">{{ __('nota_venta.actualizar_estado_venta_titulo') }} <label id="idNotaVenta"></label></h3>
        </div>    
        <div class="modal-body">
       
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
       
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 " > 
              <input type="hidden" name="id_nota_venta" id='idNotaVentaActualizarEstado'  /> 
              <div class="form-group">
              <label>{{ __('nota_venta.estado_label_mayus') }}</label><br>
              <select name="estado"  class="form-control">
                <option value="Por cobrar"> {{ __('nota_venta.opt_por_cobrar') }}</option>
                <option value="Procesado"> {{ __('nota_venta.opt_procesado') }}</option>
              </select>
              </div>
            </div>
    
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
            <button type="submit" 
					class="btn btn-primary" 
					id="btn_actualizar" 
					onclick="btn_esconder()">
				{{ __('nota_venta.actualizar') }}
			</button>

            
			</form>
            
            </div>
        </div>
 
        <div class="modal-footer"> 
          
        </div>
      </div>
  </div>
</div>

 <input type="hidden" name="_token" id="_token"  value="<?= csrf_token(); ?>">
@endsection

