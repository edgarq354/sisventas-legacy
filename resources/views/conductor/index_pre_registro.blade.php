@extends ('layouts.inicio')
@section ('contenido')
@include('alerts.success')
@include('alerts.request')
@include('alerts.errors')

	

        
	<div class="row">	
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="table-responsive" style="overflow-x:inherit">	
		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
			<font size="6">PRE REGISTRO</font>
		</div>

		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
		
		</div>

       
       
		

<div class="panel-body">
				<table class="table table-striped table-bordered table-condensed table-hover" style="background: white" id="myTable">
					<thead>
						<th><center>C.i.</center></th>
						<th><center># Movil</center></th>
						<th><center>Conductor</center></th>
						<th><center>Celular</center></th>
						<th><center>Fecha de Pre-Registro</center></th>
						<th><center>. . .</center></th>
						
					</thead>

					<tbody align="center" id="body_conductor">					
					@foreach($conductor as $con)
					<tr>
						<td>{{ $con->ci}} {{ $con->expedido}}</td>
						<td>
						@if($con->tipo_asignacion==0)
						<a class='btn btn-success fa fa-link ' data-toggle="modal" data-target="#ModalCambiarVehiculo"> Asignar : {{ $con->numero_movil}}<b></b></a>
						@else
						<b>{{ $con->numero_movil}}</b>
						@endif
						</td>
						<td>{{ $con->nombre}} {{ $con->paterno}} {{ $con->materno}}</td>
						<td>{{ $con->celular}}</td>
						<td><b>{{ $con->fecha_pre_registro}}</b></td>
						
						<td>
					
						
						 
                             
                             <a class='btn btn-primary fa fa-eye' aria-expanded="false" href='conductors/{{$con->ci}}' >   </a>
                      
						
						 
						
						</td>
					</tr>
					@endforeach
					</tbody>
				
				</table>
				</div>

			</div>
		</div>
	</div>


   {!!Html::script('js/conductor.js')!!}
@endsection
