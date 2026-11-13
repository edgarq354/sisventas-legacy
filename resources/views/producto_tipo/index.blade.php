@extends ('layouts.inicio')
@section ('contenido')
@include('alerts.success')
@include('alerts.request')
@include('alerts.errors')
@include('producto_tipo.modal')

<script type="text/javascript">
	function detalle_producto(id_producto,cantidad)
	{
		$("#id_producto").val(id_producto);
		$("#cantidad_actual").val(cantidad);
		$("#cantidad_actual_2").text("cantidad actual :"+cantidad);
	}
function detalle_producto_2(id_producto,cantidad)
	{
		$("#id_producto_2").val(id_producto);
		$("#cantidad_actual_2_menos").val(cantidad);
		$("#cantidad_actual_2_2").text("cantidad actual :"+cantidad);
	}

</script>


<?php
$message=Session::get('message');
?>

@if($message=='store')
<div class="alert alert-success alert-dismissible" role="alert">
<button type="button" class="close" data-dismiss="alert" arial-label="Close"><span aria-hidden="true">$times;</span></button>
	Pago registrado con Exito.
</div>
@endif
	<div class="row">	
		<div clasrs="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="table-responsive" style="overflow-x:inherit">	
		<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
			<font size="6">LISTA DE PRODUCTOS</font>
		</div>

		
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

{!!Form::open(['route'=>'producto_tipo.index', 'method'=>'GET'])!!}	
		<div class="col-lg-5 col-md-5 col-sm-5 col-xs-12"  >
		    <select name="id_tipo_producto" class="form-control selectpicker" id="id_tipo_producto" data-live-search="true" >
		     <option value="">  Buscar por tipo de producto</option>
		        @foreach($tipo as $mov)
		        <option value="{{$mov->id}}">{{$mov->nombre}}  </option>
		        @endforeach
		    </select>
		</div>
		 <div class=" form-group col-lg-4 col-md-4 col-sm-4 col-xs-12 " >		
		<button class="btn-sm btn-primary" id="btn_buscar" name='btn_buscar'onclick="btn_esconder()"  data-toggle="tooltip" data-placement="top" title="Buscar"><i class="fa fa-search"  ></i></button> 

		
	</form>		 

        
		<a href="{!!URL::to('producto_tipo/create')!!}" >
			<i class="fa fa-plus btn btn-primary"> Agregar nuevo</i>
		</a>
		</div>



 
 	
         
      
 
	 
 


 
		
	

		



		

		</div>
    
<div class="panel-body">
				<table class="table table-striped table-bordered table-condensed table-hover" style="background: white" id="myTable" align="center">
					
					<thead>
						<th><center>ID</center></th>
						<th><center>Imagen</center></th>
						<th><center>Nombre</center></th>
						<th><center>Descripción</center></th>
						<th><center>Precio</center></th>
						<th><center>Centidad</center></th>
						<th><center>Nombre del Tipo</center></th>
						<th><center>. . .</center></th>
					</thead>
					
						<tbody>
						@foreach($producto_tipo as $pago)
					<tr>
						<td>{{ $pago->id}}</td>
						<td> 
							<a href="../../taxivalle/storage/{{$pago->imagen1}}" target="_blank"><img src="../../taxivalle/storage/{{$pago->imagen1}}" width="90px" height="90px" title="LOGO" class="img-thumbnail"></a>
						</td>
						<td>{{ $pago->nombre}}</td>
						<td>{{ $pago->descripcion}}</td> 
						<td>{{ $pago->precio}} Bs</td>
						<td>{{ $pago->cantidad}} </td>
						<td>{{ $pago->nombre_tipo}} </td>
						<td>
						 
						{!!link_to_route('producto_tipo.edit','', $parameters = $pago->id, $attributes = ['class'=>'btn btn-primary fa fa-eye','data-toggle'=>'tooltip','data-placement'=>'top','title'=>'Ver y editar'])!!}
						
					 <button class="btn btn-success fa fa-plus" data-toggle="modal" data-target="#Modal_agregar_producto" onclick="detalle_producto('{{$pago->id}}','{{$pago->cantidad}}');"></button>
					 <button class="btn btn-success fa fa-angle-down" data-toggle="modal" data-target="#Modal_agregar_producto_restar" onclick="detalle_producto_2('{{$pago->id}}','{{$pago->cantidad}}');"></button>
						</td>
					</tr>
					@endforeach
					</tbody>
				
						
				</table>
</div>
	
			</div>


		</div>
	</div>


 
@endsection

