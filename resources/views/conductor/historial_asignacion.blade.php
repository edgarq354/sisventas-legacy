@extends ('layouts.inicio')
@section ('contenido')
@include('alerts.success')
@include('alerts.request')
@include('alerts.errors') 
	

        
	<div class="row">	
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="table-responsive" style="overflow-x:inherit">	
		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
			<font size="6">HISTORIAL DE ASIGNACIÓN</font>
		</div>
 
        
<div class="panel-body">
				<table class="table table-striped table-bordered table-condensed table-hover" style="background: white" id="myTable">
					<thead>
						<th><center>Id</center></th>
						<th><center># Movil</center></th>
						<th><center>Fecha</center></th>
						<th><center>C.I.</center></th>
						<th><center>Conductor</center></th>
						<th><center>Descripción</center></th>
						<th><center>Placa</center></th>
						
					</thead>

					<tbody align="center" id="body_conductor">					
					@foreach($historial as $con)
					<tr>
						<td>{{ $con->id}} </td>
						<td>{{ $con->numero_movil}} </td>
						<td>{{$con->fecha}}</td>
						<td>{{ $con->id_conductor}} </td>
						<td>{{ $con->conductor}}</td>
						<td>{{ $con->descripcion}}</td>
						<td>
							@if($con->id_vehiculo!='0')
							 <label><a href="../vehiculo/{{$con->id_vehiculo}}/edit "   >  {{ $con->id_vehiculo}}</a></label>
							@else
							-
							@endif 
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
