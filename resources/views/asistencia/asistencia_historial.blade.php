@extends ('layouts.inicio')
@section ('contenido')
@include('alerts.success')
@include('alerts.request')
@include('alerts.errors')
@include('asistencia.moda_observaciones')

<script type="text/javascript">

	function buscarEnlace(){
		var fechaInicio=$("#calendario1").val();
		var fechaFinal=$("#calendario2").val(); 
		var id_empleado=$("#id_empleado").val();
	
		
	
		$("#buscar").prop("href", "../../../asistencia_historial/"+fechaInicio+"/"+fechaFinal+"/"+id_empleado);
		$("#imprimir").prop("href", "../../../asistencia_historial_imprimir/"+fechaInicio+"/"+fechaFinal+"/"+id_empleado);
	}
	
	</script>
	
	<div class="row">	
		 
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12  " style="padding: 0px;">

 

			<div class=" panel panel-danger  ">

				<div class="panel-heading">
					<h3>{{ __('asistencia.historial_de_asistencia_mayus') }}</h3>
					 {{ __('asistencia.fecha_de_inicio_dp') }}
					<input type="text"  value="{{$fechaInicio}}"  id='calendario1' onmouseover ="buscarEnlace();">
					{{ __('asistencia.fecha_final_dp') }}
					<input type="text"  value="{{$fechaFinal}}"  id='calendario2' onmouseover ="buscarEnlace();">
					 
					<div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
						<select name="id_empleado" id="id_empleado" class="form-control selectpicker" onchange ="buscarEnlace();"
							data-live-search="true">
							<option value="0"> {{ __('asistencia.todos_los_empleados') }} </option>
							@foreach ($usuario as $mov)
								<option value="{{ $mov->id }}" 
									@if ($id_empleado == $mov->id) selected="" @endif>{{ $mov->nombre }}
								</option>
							@endforeach
						</select>
					</div>

				  <a class="btn btn-warning"  href="../../../asistencia_historial/{{$fechaInicio}}/{{$fechaInicio}}/0" id="buscar" onmouseover ="buscarEnlace();">
				  	<i class="fa fa-search"></i> {{ __('asistencia.buscar') }} </a> 
				  	<a class="btn btn-primary"  href="../../../asistencia_historial_imprimir/{{$fechaInicio}}/{{$fechaInicio}}/0" id="imprimir" onmouseover ="buscarEnlace();">
				  	<i class="fa fa-print"></i> {{ __('asistencia.imprimir') }} </a>
			  	</div>
			</div>
  
		
		</div>


		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<hr>
		<div class="table-responsive" style="overflow-x:inherit">	
		
			<div class="panel-body">
				<table class="table table-striped table-bordered table-condensed table-hover" style="background: white" id="tabla_sin_imprimir">
					<thead>
						<th><center>{{ __('asistencia.col_fecha') }}</center></th>
						<th><center>{{ __('asistencia.col_nombre') }}</center></th>
						<th><center>{{ __('asistencia.col_hora_ingreso') }}</center></th>
						<th><center>{{ __('asistencia.col_hora_salida') }}</center></th>
						<th><center>{{ __('asistencia.col_observaciones') }}</center></th>  
					</thead>

					<tbody align="center" id="body_conductor">					
					@foreach($asistencia as $con)
					<tr>
						<td>{{ date('Y-m-d',strtotime($con->fecha))}}</td>
						<td>{{ $con->nombre}}</td>
						<td>{{ $con->fecha_ingreso}} </td>
						<td>{{ $con->fecha_salida}} </td>
						<td>{{ $con->observaciones}}</td>
					</tr>
					@endforeach
					</tbody>

					<tbody align="center" id="body_conductor_2">
					</tbody>					
				</table>
				</div>

			</div>
			</div>
		</div> 

@endsection
