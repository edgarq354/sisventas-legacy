@extends ('layouts.inicio')
@section ('contenido')
@include('alerts.success')
@include('alerts.request')
@include('alerts.errors')
@include('partials.dashboard_style')

<style type="text/css">
	/* Tabla de ventas compacta */
	#tabla_sin_imprimir{ font-size:12.5px; }
	#tabla_sin_imprimir thead th{ padding:8px 8px !important; font-size:11px; text-transform:uppercase; letter-spacing:.4px; background:#fdf0e7; color:#c62828; border-bottom:2px solid #efe4da; }
	#tabla_sin_imprimir tbody td{ padding:6px 8px !important; vertical-align:middle; }
	#tabla_sin_imprimir tbody tr:hover{ background:#fdfaf7; }
	#tabla_sin_imprimir .badge{ font-size:10.5px; padding:3px 7px; border-radius:999px; }
	#tabla_sin_imprimir .btn-group .btn{ padding:3px 9px; font-size:12px; border-radius:8px; }
	.nv-monto{ font-weight:700; color:#2e7d32; }

	/* Barra de acciones: botones uniformes */
	.nv-actions{ display:flex; flex-wrap:wrap; gap:10px; }
	.nv-actions .nv-btn{
		display:inline-flex; align-items:center; justify-content:center; gap:7px;
		min-width:155px; height:42px; padding:0 18px;
		border-radius:10px; font-weight:700; font-size:13px; line-height:1;
		border:0; text-decoration:none; cursor:pointer; color:#fff;
		box-shadow:0 6px 16px -9px rgba(0,0,0,.5);
		transition:transform .1s, box-shadow .12s, filter .12s;
	}
	.nv-actions .nv-btn:hover{ transform:translateY(-1px); box-shadow:0 9px 20px -9px rgba(0,0,0,.5); filter:brightness(1.06); color:#fff; }
	.nv-actions .nv-btn .fa{ font-size:14px; }
	.nv-btn--primary{ background:linear-gradient(135deg,#2e7d32,#66bb6a); }
	.nv-btn--pdf{ background:#c62828; }
	.nv-btn--ghost{ background:#5c4033; }
	@media (max-width:600px){ .nv-actions .nv-btn{ flex:1 1 45%; min-width:0; } }
</style>

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

	    $.get("get_nota_venta_por_id/"+id, function (res) {
	     var listaDetalle=res.detalle_venta;


	     $('#body_detalle').empty(); 
	var tabladatos=$("#body_detalle"); 
	var monto_total=0;
	for (var i = 0; i < listaDetalle.length; i++) {   
		tabladatos.append('<tr> <td>\n\
			 	'+listaDetalle[i].descripcion+'</td><td>'+listaDetalle[i].peso+'</td><td>'+listaDetalle[i].sub_total+'</td> \n\
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
        var miurl="cancelar_nota_venta"; 
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

	$("#generarEstadoResultado").prop("href", "est_result_imp/"+fechaInicio+"/"+fechaFinal); 
}
</script>




<?php
$message=Session::get('message');
$fechaInicial=date('Y-m-d');
$fechaFinal=date('Y-m-d');
?>


<input type="hidden" id="listaNotaVenta" value="{{json_encode($nota_venta)}}">

@if($message=='store')
<div class="alert alert-success alert-dismissible" role="alert">
<button type="button" class="close" data-dismiss="alert" arial-label="Close"><span aria-hidden="true">$times;</span></button>
	{{ __('nota_venta.pago_registrado') }}
</div>
@endif
<div class="dash">

	<div class="dash-hero" style="margin-bottom:16px;">
		<div class="dash-hero__icon"><i class="fa fa-file-text-o"></i></div>
		<div>
			<h3 class="dash-hero__title">{{ __('nota_venta.titulo_notas_venta') }}</h3>
			<p class="dash-hero__sub">{{ __('nota_venta.ultimos_movimientos') }}</p>
		</div>
	</div>

	<div class="nv-actions" style="margin-bottom:18px;">
		<a href="{!! URL::to('nota_venta/create') !!}" class="nv-btn nv-btn--primary"><i class="fa fa-plus"></i> {{ __('nota_venta.nueva_venta') }}</a>
		<a href="{!! URL::to('caja') !!}" class="nv-btn nv-btn--ghost"><i class="fa fa-inbox"></i> {{ __('nota_venta.caja') }}</a>
		<a href="{!! URL::to('nota_venta_historial/'.date('Y-m-d').'/'.date('Y-m-d')) !!}" class="nv-btn nv-btn--ghost"><i class="fa fa-history"></i> {{ __('nota_venta.historial') }}</a>
		<a href="{!! URL::to('nota_venta_historial_por_producto/'.date('Y-m-d').'/'.date('Y-m-d').'/0') !!}" class="nv-btn nv-btn--ghost"><i class="fa fa-cube"></i> {{ __('nota_venta.por_producto') }}</a>
		<a data-toggle="modal" data-target="#ModalEstadoResultado" class="nv-btn nv-btn--pdf"><i class="fa fa-file-pdf-o"></i> {{ __('nota_venta.estado_resultado') }}</a>
	</div>

	<div class="dash-card">
		<div class="dash-card__head"><i class="fa fa-list"></i> {{ __('nota_venta.ventas_registradas') }}</div>
		<div class="dash-card__body dash-card__body--flush">
			<div class="table-responsive" style="overflow-x:auto;">
				<table class="table table-striped table-hover" style="background:white;margin:0;" id="tabla_sin_imprimir" align="center">

					<thead>
						<th><center>{{ __('nota_venta.col_id') }}</center></th> 
						@if(Auth::user()->tipo_empresa=="RESTAURANTE")
						<th><center>{{ __('nota_venta.col_ticket') }}</center></th>
						@endif
						<th><center>{{ __('nota_venta.col_fecha') }}</center></th>
						<th><center>{{ __('nota_venta.col_cliente') }}</center></th>
						<th><center>{{ __('nota_venta.col_monto_total') }}</center></th>  
						<th><center>{{ __('nota_venta.col_modalidad') }}</center></th> 
						<th><center>{{ __('nota_venta.col_usuario') }}</center></th> 
						<th><center>{{ __('nota_venta.col_estado') }}</center></th> 
						<th><center>. . .</center></th>
					</thead>
					
						<tbody>
						@foreach($nota_venta as $pago)
					 
					<tr>
						<td>{{ $pago->id}}</td> 
						@if(Auth::user()->tipo_empresa=="RESTAURANTE")
						<td align="center">{{ $pago->numero_ticket}}</td>  
						@endif
						<td>{{ $pago->fecha}}</td>  
						<td>{{ $pago->razon_social}} </td> 
						<td>{{ $pago->monto_total}}  </td>
						<td>{{ $pago->tipo}}</td>
						<td>{{ $pago->usuario}}</td>
						<td>
							@if($pago->estado=='Procesado')
							 <span class="badge  btn-success">{{ __('estados.'.$pago->estado) }}</span>
							 @elseif($pago->estado=='Por cobrar')
							 <span class="badge  btn-warning">{{ __('estados.'.$pago->estado) }}</span>
							 @elseif($pago->estado=='Qr')
							 <span class="badge  btn-warning">Qr</span>
							 @elseif($pago->estado=='QrFie')
							 <span class="badge  btn-info">{{ __('nota_venta.qr_b_fie') }}</span>
							 @else
							 <span class="badge  btn-danger">{{ __('estados.'.$pago->estado) }}</span>
							 @endif
						</td>
						 
						<td>
							<div class="btn-group">
                            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                              {{ __('nota_venta.opcion') }} <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                            	<li>
                            		<a class='fa fa-eye'   data-toggle="modal" data-target="#ModalVenta" onclick="cargarNotaVenta({{$pago->id}});"> {{ __('nota_venta.ver_detalle') }}</a>
                            	</li>
                            	<li>
                            		<a target="_blank" class=' fa fa-print' href='nota_venta_imprimir/{{$pago->id}}' aria-hidden="true"  data-toggle="tooltip" data-placement="top" title="{{ __('nota_venta.imprimir') }}"> {{ __('nota_venta.imprimir') }}</a>
                            	</li>
								<li>
                            		<a target="_blank" class=' fa fa-print' href='nota_venta_imprimir_pequenio/{{$pago->id}}' aria-hidden="true"  data-toggle="tooltip" data-placement="top" title="{{ __('nota_venta.boletin') }}"> {{ __('nota_venta.boletin') }}</a>
                            	</li>
                            	@if($pago->estado!='Cancelado')
                            	<li>
                            		<a class='fa fa-close' href="" data-toggle="modal" data-target="#ModalCancelarVenta"  onclick="cargarNotaVentaCancelar({{$pago->id}})" aria-hidden="true"> {{ __('nota_venta.cancelar_venta') }}</a>
                            	</li>
                            	@endif
								@if($pago->estado=='Por cobrar')
                            	<li>
                            		<a class='' href="" data-toggle="modal" data-target="#ModalEstado"  onclick="cargarNotaVentaActualizarEstado({{$pago->id}})" aria-hidden="true"><i class="fa-spin fa fa-refresh "></i> {{ __('nota_venta.act_cobrado') }}</a>
                            	</li>
                            	@endif
								@if(Auth::user()->tipo_empresa=="RESTAURANTE")
								<li>
                            		<a target="_blank" class=' fa fa-print' href='imprimir_ticket_pdf/{{$pago->id}}' aria-hidden="true"  data-toggle="tooltip" data-placement="top" title="{{ __('nota_venta.ticket') }}"> {{ __('nota_venta.ticket') }}</a>
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




<!-- Modal NOTA VENTA-->
<div id="ModalEstadoResultado" class="modal fade" role="dialog">
	<div class="modal-dialog modal-md">
	  <!-- Modal content-->
	  <div class="modal-content">
  
		<div class="modal-header" style="background: #3984ca; color: white">
		  <h3 class="modal-title">{{ __('nota_venta.generar_estado_resultado') }} <label id="idNotaVenta"></label></h3>
		</div>   
		
  
		<div class="modal-body">
   
   
   			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
   

				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 " > 
					<input type="hidden" id='indexCarrito'  /> 
	 
    
					<div class="form-group">
					<label>{{ __('nota_venta.fecha_inicial_label') }}</label><br>
					<input type="decimal"  class="form-control" id="calendario1"  value="{{$fechaInicial}}"  onmouseover ="buscarEnlace();"/>
					</div>
				</div>

				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 " > 
					<div class="form-group">
						<label>{{ __('nota_venta.fecha_final_label') }}</label><br>
						<input type="decimal"  class="form-control" id="calendario2" value="{{$fechaFinal}}"   onmouseover ="buscarEnlace();" />
					</div>
					
				</div>
				
				<a id="generarEstadoResultado" class="btn btn-primary form-control"  onmouseover ="buscarEnlace();"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> {{ __('nota_venta.generar_pdf') }}</a>
			 
  			 </div>
		</div>

	 
  
  
		<div class="modal-footer"> 
			 
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
				<!-- aquí los campos del formulario -->


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

