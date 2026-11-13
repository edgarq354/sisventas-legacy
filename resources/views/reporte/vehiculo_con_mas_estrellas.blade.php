@extends ('layouts.inicio')
@section ('contenido')
@include('alerts.success')
@include('alerts.request')
@include('alerts.errors')
	

        
	<div class="row">	
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="table-responsive" style="overflow-x:inherit">	
		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
			<font size="6">VEHICULO CON MAS ESTRELLAS</font> 
		</div>
  
<div class="panel-body">
				<table class="table table-striped table-bordered table-condensed table-hover" style="background: white" id="myTable">
					<thead>
						<th><center># MOVIL</center></th>
						<th><center>PLACA</center></th>
						<th><center>MARCA</center></th>
						<th><center>MODELO</center></th>
						<th><center>CLASE</center></th>
						<th><center>COLOR</center></th>
						<th><center>SERVICIO</center></th>
						<th><center>MOTO</center></th>
						<th><center>. . .</center></th>
						
					</thead>

					<tbody align="center" id="body_vehiculo">					
					@foreach($vehiculo as $mot)
					<tr>
						<td><b>{{ $mot->codigo_empresa}}</b></td>
						<td>{{ $mot->placa}}</td>
						<td>{{ $mot->marca}}</td>
						<td>{{ $mot->modelo}}</td>
						<td>{{ $mot->clase}}</td>
						<td>{{ $mot->color}}</td>
						<td>{{ $mot->servicio}}</td>
						<td>
							@if($mot->moto==1)
							<i class="fa fa-motorcycle" aria-hidden="true"></i>
							@else
							<i class="fa fa-car" aria-hidden="true"></i>
							@endif
						</td>	
						<td><i class="fa fa-star" aria-hidden="true" style="color: black;background: yellow;"></i> {{ $mot->calificacion}}</td>	
					</tr>
					@endforeach
					</tbody>

					 					
				</table>
				</div>

			</div>
		</div>
	</div>

 
@endsection
