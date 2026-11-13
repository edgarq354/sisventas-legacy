@extends ('layouts.inicio')
@section ('contenido')
@include('alerts.success')
@include('alerts.request')
@include('alerts.errors') 
	

        
	<div class="row">	
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="table-responsive" style="overflow-x:inherit">	
		

	 <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 ">
      <div class=" panel panel-success">
      	<div class="panel-heading"><b>RADIO</b> </div>
      	<div class="panel-body">
			<table>
				<tr>
					<td style="padding:5px;">
						  {!!Form::label('','CODIGO:')!!}
						    {{$radio[0]->id}} 
						<br>    
						     {!!Form::label('','Marca:')!!}
						    {{$radio[0]->marca}} 
						<br>    
						     {!!Form::label('','Modelo:')!!}
						    {{$radio[0]->modelo}}     
						<br>   
						    {!!Form::label('','Descripción:')!!}
						    {{$radio[0]->descripcion}} 
						
					</td>
					<td style="padding:5px;">
						   {!!Form::label('','Estado:')!!}
						  @if($radio[0]->estado==0)
							NO DISPONIBLE
							@elseif($radio[0]->estado==1)
							DISPONIBLE
							@elseif($radio[0]->estado==2)
							EN REPARACION
							@endif
							<br>
						   {!!Form::label('','Usuario:')!!}
			   				 {{$radio[0]->nombre}} 
			   				  <br>  
						     {!!Form::label('','Fecha:')!!}
						    {{$radio[0]->fecha}} 
					</td>
				</tr>
			</table>
	      </div>
		</div>
</div>
 
 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
      <div class=" panel panel-primary">
      	<div class="panel-heading"><b>Historial de asignación de Radio</b> </div>
      	<div class="panel-body">
 
				<table class="table table-striped table-bordered table-condensed table-hover" style="background: white" id="myTable">
					<thead>
						<th><center>Id</center></th> 
						<th><center>Fecha</center></th>
						<th><center>Descripcion</center></th>
						<th><center>Placa</center></th>
						<th><center>Usuario</center></th>
						<th><center>Estado</center></th>
						
					</thead>

					<tbody align="center" id="body_conductor">					
					@foreach($historial as $con)
					<tr>
						<td>{{ $con->id}} </td> 
						<td>{{$con->fecha_registro}}</td>
						<td>{{ $con->descripcion}} </td>
						<td>
							  <a href="../vehiculo/{{$con->id_vehiculo}}/edit "  class="btn btn-danger" style="color: white;">  {{$con->id_vehiculo}}</a></div>
						</td>	
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
		</div>
	</div>
 
@endsection
