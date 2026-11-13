@extends ('layouts.inicio')
@section ('contenido')
@include('alerts.success')
@include('alerts.request')
@include('alerts.errors') 
	

        
	<div class="row">	
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="table-responsive" style="overflow-x:inherit">	
		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
			<font size="6">HISTORIAL DE BAJAS Y ALTAS</font>
		</div>
 
        
<div class="panel-body">
				<table class="table table-striped table-bordered table-condensed table-hover" style="background: white" id="myTable">
					<thead>
						<th><center>Id</center></th>
						<th><center># Movil</center></th>
						<th><center>Fecha</center></th>
						<th><center>Descripcion</center></th>
						<th><center>Usuario</center></th>
						<th><center>Estado</center></th>
						
					</thead>

					<tbody align="center" id="body_conductor">					
					@foreach($historial as $con)
					<tr>
						<td>{{ $con->id}} </td>
						<td><label>{{ $con->numero_movil}} </label></td>
						<td>{{$con->fecha_registrado}}</td>
						<td>{{ $con->descripcion}} </td>
						<td>{{ $con->usuario}}</td>
						<td>
							@if($con->tipo==1)
							ALTA
							@else
							BAJA
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
