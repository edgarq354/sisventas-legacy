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
	#tabla_sin_imprimir td.num{ text-align:right; font-weight:700; }
	#tabla_sin_imprimir .btn-group .btn{ padding:3px 9px; border-radius:8px; font-size:12px; }
	.nc-actions{ display:flex; flex-wrap:wrap; gap:10px; margin-bottom:18px; }
	.nc-actions .nc-btn{
		display:inline-flex; align-items:center; justify-content:center; gap:7px;
		min-width:165px; height:42px; padding:0 18px; border-radius:10px;
		font-weight:700; font-size:13px; color:#fff; border:0; text-decoration:none; cursor:pointer;
		box-shadow:0 6px 16px -9px rgba(0,0,0,.5); transition:transform .1s, filter .12s;
	}
	.nc-actions .nc-btn:hover{ transform:translateY(-1px); filter:brightness(1.07); color:#fff; }
	.nc-btn--nueva{ background:linear-gradient(135deg,#2e7d32,#66bb6a); }
	.nc-btn--hist{ background:#c62828; }
	.nc-btn--prod{ background:#5c4033; }
	@media (max-width:600px){ .nc-actions .nc-btn{ flex:1 1 45%; min-width:0; } }
</style>

<script type="text/javascript">
	function cargarNotaVenta(index) {
		var listaNotaVenta = JSON.parse($("#listaNotaVenta").val());
		listaNotaVenta = listaNotaVenta.filter(dato => dato.id == index);
		var total = 0;

		for (var i = 0; i < listaNotaVenta.length; i++) {
			$("#idNotaVenta").text(listaNotaVenta[i].id);
			$("#ciNit").val(listaNotaVenta[i].ci_nit);
			$("#proveedor").val(listaNotaVenta[i].proveedor);
			$("#comprador").val(listaNotaVenta[i].comprador);
			$("#montoTotal").val(listaNotaVenta[i].monto_total);
			$("#usuario").val(listaNotaVenta[i].usuario);
			$("#fecha").val(listaNotaVenta[i].fecha);
			total = listaNotaVenta[i].monto_total;
		}

		this.obtenerObtenerNotaVenta(index, total);
	}

	function obtenerObtenerNotaVenta(id, total) {

		$.get("get_nota_compra_por_id/" + id, function(res) {
			var listaDetalle = res.detalle_compra;


			$('#body_detalle').empty();
			var tabladatos = $("#body_detalle");
			var monto_total = 0;
			for (var i = 0; i < listaDetalle.length; i++) {
				tabladatos.append('<tr> <td>\n\
			 	' + listaDetalle[i].nombre + '</td> <td>' + listaDetalle[i].peso + '</td><td>' + listaDetalle[i].sub_total + '</td> \n\
			</tr>');
			}
			tabladatos.append('<tr style="font-weight:bold;"> <td colspan="2">\n\
			 	TOTAL: </td><td>' + total + '</td> \n\
			</tr>');


		});
	}

	function cargarNotaVentaCancelar(index) {
		$("#idNotaVentaCancelar").val(index);
	}

	function cargarNotaActualizarEstado(id_nota_venta){
		$("#idNotaActualizarEstado").val(id_nota_venta);	
	}


	function cancelarNota() {
		//  var miurl="asignar_usuario_pedido/"+id_pedido_c+"/"+ci+"/"+placa; 
		var token = $('input[name="_token"]').val();
		var miurl = "cancelar_nota_compra";
		var divresul = "notificacion_resultado";
		//información del formulario
		var formData = new FormData();
		formData.append('id', $("#idNotaVentaCancelar").val());
		formData.append('_token', token);

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
			beforeSend: function() {
				$("#" + divresul + "").html($("#cargando_asignacion").html());
			},
			//una vez finalizado correctamente
			success: function(data) {
				alertify.success(":" + data);
				window.location.href = window.location.href;
				$("#" + divresul + "").html(@json(__('nota_compra.asignacion_completado')));
			},
			//si ha ocurrido un error
			error: function(data) {
				alertify.error(@json(__('nota_compra.ha_ocurrido_error')) + data);

			}
		});

	}
</script>




<?php
$message = Session::get('message');
?>


<input type="hidden" id="listaNotaVenta" value="{{json_encode($nota_compra)}}">

@if($message=='store')
<div class="alert alert-success alert-dismissible" role="alert">
	<button type="button" class="close" data-dismiss="alert" arial-label="Close"><span aria-hidden="true">$times;</span></button>
	{{ __('nota_compra.pago_registrado') }}
</div>
@endif
<div class="dash">

	<div class="dash-hero" style="margin-bottom:14px;">
		<div class="dash-hero__icon"><i class="fa fa-truck"></i></div>
		<div>
			<h3 class="dash-hero__title">{{ __('nota_compra.titulo_notas_compra') }}</h3>
			<p class="dash-hero__sub">{{ __('nota_compra.ultimos_movimientos') }}</p>
		</div>
	</div>

	<div class="nc-actions">
		@if(!empty($caja_abierta))
			<a href="{!! URL::to('nota_compra/create') !!}" class="nc-btn nc-btn--nueva"><i class="fa fa-plus"></i> {{ __('nota_compra.nueva_compra') }}</a>
		@else
			<span class="nc-btn nc-btn--nueva" style="opacity:.5;cursor:not-allowed;" title="{{ __('nota_compra.abra_caja_primero') }}"><i class="fa fa-plus"></i> {{ __('nota_compra.nueva_compra') }}</span>
		@endif
		<a href="{!! URL::to('nota_compra_historial/'.date('Y-m-d').'/'.date('Y-m-d')) !!}" class="nc-btn nc-btn--hist"><i class="fa fa-history"></i> {{ __('nota_compra.historial') }}</a>
		<a href="{!! URL::to('nota_compra_historial_por_producto/'.date('Y-m-d').'/'.date('Y-m-d').'/0') !!}" class="nc-btn nc-btn--prod"><i class="fa fa-cube"></i> {{ __('nota_compra.por_producto') }}</a>
	</div>

	@if(empty($caja_abierta))
		<div style="display:flex;align-items:center;gap:10px;background:#fdecea;border:1px solid #f5c6c2;color:#a12b21;border-radius:10px;padding:10px 14px;margin-bottom:14px;font-size:13px;font-weight:600;">
			<i class="fa fa-exclamation-triangle"></i>
			{{ __('nota_compra.sin_caja_abierta_aviso') }}
			<a href="{!! URL::to('caja') !!}" class="btn btn-danger btn-xs" style="margin-left:auto;border-radius:8px;font-weight:700;"><i class="fa fa-inbox"></i> {{ __('nota_compra.ir_a_caja') }}</a>
		</div>
	@endif

	<div class="dash-card">
		<div class="dash-card__head"><i class="fa fa-list"></i> {{ __('nota_compra.compras_registradas') }}</div>
		<div class="dash-card__body dash-card__body--flush">
			<div class="table-responsive" style="overflow-x:auto;">
				<table class="table table-striped table-hover" style="background:white;margin:0;" id="tabla_sin_imprimir">

					<thead>
							<th>
								<center>{{ __('nota_compra.col_id') }}</center>
							</th> 
							<th>
								<center>{{ __('nota_compra.col_fecha') }}</center>
							</th>
							<th>
								<center>{{ __('nota_compra.col_proveedor') }}</center>
							</th>
							<th>
								<center>{{ __('nota_compra.col_comprador') }}</center>
							</th>
							<th>
								<center>{{ __('nota_compra.col_monto_total') }}</center>
							</th>
							<th>
								<center>{{ __('nota_compra.col_usuario') }}</center>
							</th>
							<th>
								<center>{{ __('nota_compra.col_estado') }}</center>
							</th>
							<th>
								<center>. . .</center>
							</th>
						</thead>

						<tbody>
							@foreach($nota_compra as $pago)

							<tr>
								<td>{{ $pago->id}}</td> 
								<td>{{ $pago->fecha}}</td>
								<td>{{ $pago->proveedor}} </td>
								<td>{{ $pago->comprador}} </td>
								<td>{{ $pago->monto_total}} </td>
								<td>{{ $pago->usuario}}</td>
								<td>
									@if($pago->estado=='Procesado')
									 <span class="badge  btn-success">{{ __('estados.'.$pago->estado) }}</span>
									 @elseif($pago->estado=='Por pagar')
									 <span class="badge  btn-warning">{{ __('estados.'.$pago->estado) }}</span> 
									 @else
									 <span class="badge  btn-danger">{{ __('estados.'.$pago->estado) }}</span>
									 @endif
								</td>

								<td>
									<div class="btn-group">
										<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
											{{ __('nota_compra.opcion') }} <span class="caret"></span>
										</button>
										<ul class="dropdown-menu" role="menu">
											<li>
												<a class='fa fa-eye' data-toggle="modal" data-target="#ModalVenta" onclick="cargarNotaVenta({{$pago->id}});"> {{ __('nota_compra.ver_detalle') }}</a>
											</li>
											<li>
												<a class=' fa fa-print' href='nota_compra_imprimir/{{$pago->id}}' aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ __('nota_compra.imprimir') }}"> {{ __('nota_compra.imprimir') }}</a>
											</li> 
											@if($pago->estado=='Por pagar')
											<li>
												<a class='' href="" data-toggle="modal" data-target="#ModalEstado"  onclick="cargarNotaActualizarEstado({{$pago->id}})" aria-hidden="true"><i class="fa-spin fa fa-refresh "></i> {{ __('nota_compra.act_pagado') }}</a>
											</li>
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
</div>




<!-- Modal NOTA VENTA-->
<div id="ModalVenta" class="modal fade" role="dialog">
	<div class="modal-dialog modal-md">
		<!-- Modal content-->
		<div class="modal-content">

			<div class="modal-header" style="background: #d4463e; color: white">
				<h3 class="modal-title">{{ __('nota_compra.modal_compra_titulo') }} <label id="idNotaVenta"></label></h3>
			</div>


			<div class="modal-body">


				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

					<div style="margin: 15px;">
						<label>{{ __('nota_compra.proveedor_label') }}</label><br>
						<input type="text" id="proveedor" class="form-control" readonly="" />
					</div>

					<div style="margin: 15px;">
						<label>{{ __('nota_compra.comprador_label') }}</label><br>
						<input type="text" id="comprador" class="form-control" readonly="" />
					</div>


					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 ">
						<input type="hidden" id='indexCarrito' />


						<div class="form-group">
							<label>{{ __('nota_compra.nit_ci_label') }}</label><br>
							<input type="decimal" class="form-control" id="ciNit" readonly="" />
						</div>

						<div class="form-group">
							<label>{{ __('nota_compra.fecha_label') }}</label><br>
							<input type="decimal" class="form-control" id="fecha" readonly="" />
						</div>
					</div>

					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 ">
						<div class="form-group">
							<label>{{ __('nota_compra.monto_total_label') }}</label><br>
							<input type="decimal" class="form-control" id="montoTotal" readonly="">
						</div>

						<div class="form-group">
							<label>{{ __('nota_compra.usuario_label') }}</label><br>
							<input type="text" class="form-control" id="usuario" readonly="">
						</div>
					</div>
				</div>
			</div>

			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<table class="table table-striped table-bordered table-condensed table-hover" style="background: white">
					<thead>

						<th>
							<center>{{ __('nota_compra.col_producto') }}</center>
						</th>
						<th>
							<center>{{ __('nota_compra.col_cantidad') }}</center>
						</th> 
						<th>
							<center>{{ __('nota_compra.col_total') }}</center>
						</th>
					</thead>
					<tbody align="center" id="body_detalle">

					</tbody>
				</table>
			</div>


			<div class="modal-footer">
				<button data-dismiss="modal" class="btn btn-warning form-control">
					<i class="fa fa-close" aria-hidden="true"></i> {{ __('nota_compra.cerrar') }}</button>
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
				<h3 class="modal-title">{{ __('nota_compra.cancelar_venta_titulo') }} </h3>
			</div>


			<div class="modal-body">


				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<input type="hidden" id="idNotaVentaCancelar">
					<center>
						<h3>{{ __('nota_compra.cancelar_venta_aviso') }}</h3>
					</center>

				</div>
			</div>




			<div class="modal-footer">
				<button data-dismiss="modal" class="btn btn-warning " onclick="cancelarNota();">
					<i class="fa fa-save" aria-hidden="true"></i> {{ __('nota_compra.aceptar') }}</button>
				<button data-dismiss="modal" class="btn btn-danger ">
					<i class="fa fa-save" aria-hidden="true"></i> {{ __('nota_compra.cerrar') }}</button>
			</div>
		</div>
	</div>
</div>



<!-- Modal ACTUALIZAR ESTADO-->
<div id="ModalEstado" class="modal fade" role="dialog">
	<div class="modal-dialog modal-md">
	   
      <div class="modal-content">
        <form action="{{ url('actualizar_estado_nota_compra') }}" method="POST" enctype="multipart/form-data" onkeypress="if(event.keyCode == 13) event.returnValue = false;">
    	@csrf
        <div class="modal-header" style="background: #3984ca; color: white">
          <h3 class="modal-title">{{ __('nota_compra.actualizar_estado_compra_titulo') }}</h3>
        </div>    
        <div class="modal-body">
       
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
       
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 " > 
              <input type="hidden" name="id_nota_compra" id='idNotaActualizarEstado'  /> 
              <div class="form-group">
              <label>{{ __('nota_compra.estado_label_mayus') }}</label><br>
              <select name="estado"  class="form-control">
                <option value="Por cobrar"> {{ __('nota_compra.opt_por_cobrar') }}</option>
                <option value="Procesado"> {{ __('nota_compra.opt_procesado') }}</option>
              </select>
              </div>
            </div>
    
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
            <button
				type="submit"
				class="btn btn-primary"
				id="btn_actualizar"
				onclick="btn_esconder()"
				>
				{{ __('nota_compra.actualizar') }}
				</button>
            </form>
            
            </div>
        </div>
 
        <div class="modal-footer"> 
          
        </div>
      </div>
  </div>
</div>


<input type="hidden" name="_token" id="_token" value="<?= csrf_token(); ?>">
@endsection