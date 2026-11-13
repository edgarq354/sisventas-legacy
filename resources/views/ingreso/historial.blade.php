@extends ('layouts.inicio')
@section ('contenido')
@include('alerts.success')
@include('alerts.request')
@include('alerts.errors')

<script type="text/javascript">
	function cargarTraspaso(index){
		var listaTraspaso=JSON.parse($("#listaTraspaso").val());
		listaTraspaso=listaTraspaso.filter(dato=>dato.id==index);
		var total=0;

			for (var i = 0; i < listaTraspaso.length; i++) {
				$("#idTraspaso").text(listaTraspaso[i].id);
				$("#sucursalOrigen").val(listaTraspaso[i].sucursal_origen);
				$("#sucursalDestino").val(listaTraspaso[i].sucursal_destino);
				$("#usuario").val(listaTraspaso[i].usuario);
				$("#caja_origen").val(listaTraspaso[i].caja_origen);
				$("#caja_destino").val(listaTraspaso[i].caja_destino);
				$("#monto_traspaso").val(listaTraspaso[i].monto);
				$("#nota_traspaso").val(listaTraspaso[i].nota_traspaso);
				$("#nota_recibido").val(listaTraspaso[i].nota_recibido);
				$("#fecha").val(listaTraspaso[i].fecha);
				//$("#estado").val(listaTraspaso[i].estado);
				var estado =listaTraspaso[i].estado;
				$("#id_traspaso").val(listaTraspaso[i].id);
				$("#id_caja_origen").val(listaTraspaso[i].id_caja_origen);
				$("#id_caja_destino").val(listaTraspaso[i].id_caja_destino);
				$("#id_usuario_registro").val(listaTraspaso[i].id_usuario_registro);
				$("#estado_select option[value='"+estado+"']").prop("selected", true);


				if(estado=="PROCESADO"||estado=="CANCELADO"){
					$("#nota_recibido").prop("readonly", true);
					$("#btn_actualizar").hide();
				}else{
					$("#nota_recibido").prop("readonly", false);
					$("#btn_actualizar").show();
				}

			}

	}



	function obtenerObtenerNotaVenta(id,total){

	    $.get("../../get_traspaso_por_id/"+id, function (res) {
	     var listaDetalle=res.traspaso_detalle;


	     $('#body_detalle').empty();
	var tabladatos=$("#body_detalle");
	for (var i = 0; i < listaDetalle.length; i++) {
		tabladatos.append('<tr> <td>'+listaDetalle[i].codigo_producto+'</td><td>'+listaDetalle[i].nombre+'</td><td>'+listaDetalle[i].cantidad+'</td>\n\
			</tr>');
	}



	    });
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
              $("#"+divresul+"").html("Asignacion de Taxi completado");
            },
            //si ha ocurrido un error
            error: function(data){
               alertify.error("ha ocurrido un error:"+data) ;

            }
        });

}

function buscarEnlace(){
	var fechaInicio=$("#calendario1").val();
	var fechaFinal=$("#calendario2").val();

	$("#buscar").prop("href", "../../ingreso_historial/"+fechaInicio+"/"+fechaFinal);
	$("#imprimir").prop("href", "../../ingreso_historial_imprimir/"+fechaInicio+"/"+fechaFinal);
}

</script>





<?php
$message=Session::get('message');
?>


<input type="hidden" id="listaTraspaso" value="{{json_encode($ingreso)}}">

@if($message=='store')
<div class="alert alert-success alert-dismissible" role="alert">
<button type="button" class="close" data-dismiss="alert" arial-label="Close"><span aria-hidden="true">$times;</span></button>
	Pago registrado con Exito.
</div>
@endif
	<div class="row">
		<div clasrs="col-lg-12 col-md-12 col-sm-12 col-xs-12">



    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12  " style="padding: 0px;">



			<div class=" panel panel-danger  ">

				<div class="panel-heading">
					<h3>HISTORIAL DE INGRESOS</h3>
					 Fecha de Inicio:
					<input type="text"  value="{{$fechaInicio}}"  id='calendario1' onmouseover ="buscarEnlace();">
					Fecha Final:
					<input type="text"  value="{{$fechaFinal}}"  id='calendario2' onmouseover ="buscarEnlace();">

					<a class="btn btn-warning"  href="../../ingreso_historial/{{$fechaInicio}}/{{$fechaInicio}}" id="buscar" onmouseover ="buscarEnlace();">
				  	<i class="fa fa-search"></i> Buscar </a>

				  	 <a class="btn btn-primary"  target="_blank"  href="../../ingreso_historial_imprimir/{{$fechaInicio}}/{{$fechaInicio}}" id="imprimir" onmouseover ="buscarEnlace();">
				  	<i class="fa fa-print"></i> Imprimir </a>
			  	</div>
			</div>


		</div>






<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 box box-body box-primary" >

<div class="panel-body" style="padding: 0px;">
	<div class="table-responsive" style="overflow-x:inherit">
				<table class="table table-striped table-bordered table-condensed table-hover" style="background: white" id="tabla_sin_imprimir" align="center">

					<thead>
						<th><center>Id</center></th>
						<th><center>Fecha</center></th>
						<th><center>Concepto</center></th>
						<th><center>Descripción</center></th>
						<th><center>Tipo</center></th>
						<th><center>Cliente</center></th>
						<th><center>Monto</center></th>
						<th><center>Sucursal</center></th>
						<th><center>Caja</center></th>
						<th><center>Usuario</center></th>
						<th><center>Estado</center></th>
						<th><center>. . .</center></th>
					</thead>

						<tbody>
							@foreach($ingreso as $item)

							<tr>
								<td>{{ $item->id}}</td>
								<td>{{ $item->fecha}}</td>
								<td>{{ $item->concepto}}  </td>
								<td>{{ $item->descripcion}}  </td>
								<td>{{ $item->tipo_gasto}}  </td>
								<td>{{ $item->nombre_cliente}}  </td>
								<td>{{ $item->monto}}  </td>
								<td>{{ $item->sucursal}}  </td>
								<td>{{ $item->caja}}  </td>
								<td>{{ $item->usuario}}</td>
								<TD>@if($item->estado=='Procesado')
									<span class="badge  btn-success">{{$item->estado}}</span>
									@elseif($item->estado=='Por cobrar')
									<span class="badge  btn-warning">{{$item->estado}}</span>
									@else
									<span class="badge  btn-danger">{{$item->estado}}</span>
									@endif
								</TD>
								<td>
									<div class="btn-group">
									<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
									  Opción <span class="caret"></span>
									</button>
									<ul class="dropdown-menu" role="menu">
										<li>
											<a target="_blank" class=' fa fa-print' href='../../ingreso_imprimir/{{$item->id}}' aria-hidden="true"  data-toggle="tooltip" data-placement="top" title="Imprimir"> Imprimir</a>
										</li>

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







 <input type="hidden" name="_token" id="_token"  value="<?= csrf_token(); ?>">
@endsection

