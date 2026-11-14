@extends ('layouts.inicio')
@section ('contenido')
@include('alerts.success')
@include('alerts.request')
@include('alerts.errors')
@include('asistencia.moda_observaciones')
	
	<div class="row">	
		<div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
			<font size="6">{{ __('asistencia.titulo_asistencia') }}</font>
		</div>
		<div class="col-lg-3 col-xs-6" @if(Auth::user()->privilegio!=0) hidden="" @endif>
			<!-- small box -->
			<div class="small-box bg-blue">
			  <div class="inner">
			   <font style="font-size: 30px; font-weight: bold;">{{ __('asistencia.historial') }}</font>
			  </div>
			  <div class="icon">
				<i class="fa fa-book fa-3"></i>
			  </div>
			  <a href="{!!URL::to('asistencia_historial/'.date('Y-m-d').'/'.date('Y-m-d').'/0')!!}" class="small-box-footer">{{ __('asistencia.ver') }} <i class="fa fa-arrow-circle-right"></i></a>
			</div>
		</div>
		<div class="col-lg-3 col-xs-6"> 
			<!-- small box -->
			<div class="small-box bg-green"> 
			  <div class="inner">
			   <font style="font-size: 30px; font-weight: bold;">{{ __('asistencia.reg_ingreso') }}</font>
			  </div>
			  <div class="icon">
				<i class="fa fa-sign-in fa-2"></i>
			  </div>
			  <a  href="{!!URL::to('asistencia/registro/0')!!}"  class="small-box-footer">{{ __('asistencia.registrar') }} <i class="fa fa-arrow-circle-right"></i></a>
			</div>
			
		</div>
		<div class="col-lg-3 col-xs-6">
			<!-- small box -->
			<div class="small-box bg-red">
			  <div class="inner">
			   <font style="font-size: 30px; font-weight: bold;">{{ __('asistencia.reg_salida') }}</font>
			  </div>
			  <div class="icon">
				<i class="fa fa-sign-out fa-3"></i>
			  </div>
			  <a data-toggle="modal" data-target="#modal_finalizar"class="small-box-footer">{{ __('asistencia.registrar') }} <i class="fa fa-arrow-circle-right"></i></a>
			</div>
		</div>
 
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<hr>
		<div class="table-responsive" style="overflow-x:inherit">	
		
			<div class="panel-body">
				<table class="table table-striped table-bordered table-condensed table-hover" style="background: white" id="myTable">
					<thead>
						<th><center>{{ __('asistencia.col_fecha') }}</center></th>
						<th><center>{{ __('asistencia.col_nombre') }}</center></th>
						<th><center>{{ __('asistencia.col_hora_ingreso') }}</center></th>
						<th><center>{{ __('asistencia.col_hora_salida') }}</center></th>
						<th><center>{{ __('asistencia.col_observaciones') }}</center></th>
						<th><center>{{ __('asistencia.col_opcion') }}</center></th>
						
					</thead>

					<tbody align="center" id="body_conductor">					
					@foreach($asistencia as $con)
					<tr>
						<td>{{ $con->fecha}}</td>
						<td>{{ $con->nombre}}</td>
						<td>{{ $con->fecha_ingreso}} </td>
						<td>{{ $con->fecha_salida}} </td>
						<td>{{ $con->observaciones}}</td>
						<td><a class='btn btn-warning fa fa-print' href='reporte_asistencia_pdf/{{$con->id}}' target="_blanck"></a></td>
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
