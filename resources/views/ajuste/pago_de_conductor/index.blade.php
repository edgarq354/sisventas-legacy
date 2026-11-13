@extends ('layouts.inicio')
@section ('contenido')
@include('alerts.success')
@include('alerts.request')
@include('alerts.errors')
	
	<div class="row">	
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="table-responsive" style="overflow-x:inherit">	
		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
			<font size="6">Ajuste pago de frecuencia</font>
		</div>

	 

       

				<table class="table table-striped table-bordered table-condensed table-hover" style="background: white" id="myTable">
					<thead>
						<th><center>Perfil</center></th>
						<th><center># Movil</center></th>
						<th><center>CI</center></th>
						<th><center>CONDUCTOR</center></th>
						<th><center>TIPO DE PAGO</center></th>
						<th><center>MONTO DE FRECUENCIA</center></th>
						<th><center>INICIO DE PAGO</center></th>
						<th><center>FIN DE PAGO</center></th>
						<th><center>OPCION</center></th>
						
					</thead>

					<tbody align="center" id="body_conductor">					
					@foreach($conductor as $con)
					
					<tr>
					<td><img src="{{$con->direccion_imagen}}" width="90px" height="90px"  class="img-thumbnail"></td>
						<td>{{ $con->numero_movil}} </td>
						<td>{{ $con->ci}} {{ $con->expedido}}</td>
						<td align="left">{{ $con->nombre}} {{ $con->paterno}} {{ $con->materno}}</td>
						<td>{{ $con->tipo_de_pago}}</td>
						<td>{{ $con->monto_frecuencia}}</td>
						<td>{{ $con->fecha_inicio_pago}}</td>	
						<td>{{ $con->fecha_fin_pago}}</td>	
						<!--td>{{ $con->credito}}</td-->	
						<td>
						<a class='btn btn-primary fa fa-refresh' href='editar_pago/{{$con->ci}}'></a>
					
					
						</td>
					</tr>
					@endforeach
					</tbody>

					<tbody align="center" id="body_conductor_2">
					</tbody>					
				</table>
  		</div>
		</div>
	</div>

   {!!Html::script('js/conductor_pago.js')!!}
@endsection
