@extends ('layouts.inicio')
@section ('contenido')
@include('alerts.success')
@include('alerts.request')
@include('alerts.errors')

<script type="text/javascript">
  
	function ver_producto(id_producto){
	var fechaInicio=$("#calendario1").val();
	var fechaFinal=$("#calendario2").val();
	    $.get("../../../get_nota_venta_por_id_producto/"+id_producto+"/"+fechaInicio+"/"+fechaFinal, function (res) {
	     var listaDetalle=res.detalle_venta;


	     $('#body_detalle').empty(); 
	var tabladatos=$("#body_detalle");  
	for (var i = 0; i < listaDetalle.length; i++) {   
		tabladatos.append('<tr> <td>\n\
			 	'+listaDetalle[i].id+'</td> \n\
			 	<td>'+listaDetalle[i].fecha+'</td> \n\
			 	<td>'+listaDetalle[i].razon_social+'</td> \n\
			 	<td>'+listaDetalle[i].usuario+'</td> \n\
			 	<td>'+listaDetalle[i].peso+'</td> \n\
			 	<td>'+listaDetalle[i].sub_total+'</td> \n\
			</tr>'); 
	}
	 

	    
	    });
	} 

function buscarEnlace(){
	var fechaInicio=$("#calendario1").val();
	var fechaFinal=$("#calendario2").val();
	var idProducto=$("#idProducto").val();

	$("#buscar").prop("href", "../../../nota_venta_historial_por_producto/"+fechaInicio+"/"+fechaFinal+"/"+idProducto);
	$("#imprimir").prop("href", "../../../nota_venta_historial_por_producto_imprimir/"+fechaInicio+"/"+fechaFinal+"/"+idProducto);
}

</script>




<?php
$message=Session::get('message');
?>


<input type="hidden" id="listaNotaVenta" value="{{json_encode($nota_venta)}}">

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
					<h3>HISTORIAL DE VENTAS POR PRODUCTO</h3>
					 Fecha de Inicio:
					<input type="text"  value="{{$fechaInicio}}"  id='calendario1' onmouseover ="buscarEnlace();">
					Fecha Final:
					<input type="text"  value="{{$fechaFinal}}"  id='calendario2' onmouseover ="buscarEnlace();">
					 
					 <select name="id_producto" id="idProducto" class=" selectpicker"  data-live-search="true" onchange="seleccionarTipo();" >
				         <option value="0"> Todos los Productos                             </option>
				            @foreach($producto as $mov) 
				            <option value="{{$mov->id}}"> {{$mov->nombre}} </option>   
				            @endforeach
				        </select>  
				  <a class="btn btn-warning"  href="../../nota_venta_historial_por_producto/{{$fechaInicio}}/{{$fechaInicio}}/0" id="buscar" onmouseover ="buscarEnlace();">
				  	<i class="fa fa-search"></i> Buscar </a>

				  	<a class="btn btn-primary"  href="../../nota_venta_historial_por_producto_imprimir/{{$fechaInicio}}/{{$fechaInicio}}/0" id="imprimir" onmouseover ="buscarEnlace();">
				  	<i class="fa fa-print"></i> Imprimir </a>
			  	</div>
			</div>
  
		
		</div>

		

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 box box-body box-primary" >

 

        
	 
		

		

    
<div class="panel-body" style="padding: 0px;">
	<div class="table-responsive" style="overflow-x:inherit">	
				<table class="table table-striped table-bordered table-condensed table-hover" style="background: white" id="tabla_sin_imprimir" align="center">
				<thead>
                            <th>
                                <center>ID</center>
                            </th> 
                            <th>
                                <center>TIPO DE PRODUCTO</center>
                            </th>
                            <th>
                                <center>NOMBRE</center>
                            </th> 
                            <th>
                                <center>PRECIO</center>
                            </th>  
                            <th>
                                <center>STOCK</center>
                            </th>
                            <th>
                                <center>STOCK VENTA</center>
                            </th>
                             <th>
                                <center>TOTAL</center>
                            </th>
                            <th>
                                <center>...</center>
                            </th>

                        </thead>

                        <tbody align="center" id="body_video">
                            @foreach ($nota_venta as $usr)
                                <tr>
                                    <td>{{ $usr->id }}</td>
                                     <td>
                                        {{ $usr->nombre_tipo_producto }}
                                    </td>
                                    <td>{{ $usr->nombre }}<br>
                                        <span>{{ $usr->descripcion }}</span></td> 
                                    <td>{{ $usr->precio }}</td> 
                                     
                                    <td>
                                        @if ($usr->peso > $usr->peso_minimo)
                                            {{ $usr->peso }}
                                        @else
                                            <span class="badge  btn-danger">{{ $usr->peso }}</span>
                                        @endif
                                    </td>
                                    <td><b>{{ $usr->peso_venta }}</b></td> 
									<td><b>{{ $usr->sub_total }}</b></td> 
                                    
                                   


                                    <td>


                                        <a class='btn btn-warning' data-toggle="modal" data-target="#ModalVenta"
                                            onclick="ver_producto({{ $usr->id }});"> <i class="fa fa-shopping-cart"></i> </a>

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
		  <h3 class="modal-title">NOTAS DE VENTAS : <label id="idNotaVenta"></label></h3>
		</div>   
		
  
		<div class="modal-body">
   
   <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
			<table class="table table-striped table-bordered table-condensed table-hover" style="background: white">
				<thead> 
					<th><center>ID VENTA</center></th> 
					<th><center>FECHA</center></th>  
					<th><center>CLIENTE</center></th> 
					<th><center>USUARIO</center></th>  
					<th><center>CANTIDAD</center></th> 
					<th><center>TOTAL</center></th> 
				</thead>
				<tbody align="center" id="body_detalle">					
				
				</tbody>
			</table>
		</div>
		</div>

		
  
  
		<div class="modal-footer"> 
			 
		</div>
	</div>
</div>
</div>
 
 <input type="hidden" name="_token" id="_token"  value="<?= csrf_token(); ?>">
@endsection

