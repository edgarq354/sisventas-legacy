@extends ('layouts.inicio')
@section ('contenido')
@include('alerts.success')
@include('alerts.request')
@include('alerts.errors')
	
		
	<div class="row">	
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="table-responsive" style="overflow-x:inherit">	
		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
			<font size="6">{{ __('tipo_ingreso_egreso.titulo') }}</font>
		</div>


		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">

		</div>

		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
			<div class="pull-right">
				<a class="btn btn-link fa fa-plus" href="{!!URL::to('tipo_ingreso_egreso/create')!!}"> {{ __('tipo_ingreso_egreso.agregar_tipo') }}</a>
			</div>
		</div>


				<table class="table table-striped table-bordered table-condensed table-hover" style="background: white" id="myTable">
					<thead>
						<th><center>{{ __('tipo_ingreso_egreso.col_id') }}</center></th>
						<th><center>{{ __('tipo_ingreso_egreso.col_nombre') }}</center></th>
						<th><center>{{ __('tipo_ingreso_egreso.col_detalle') }}</center></th>
						<th><center>{{ __('tipo_ingreso_egreso.col_opcion') }}</center></th>
						
					</thead>

					<tbody align="center" id="body_conductor">					
					@foreach($tipo as $usr)
					<tr>
						<td>{{$usr->id}}</td>
						<td>{{$usr->nombre}}</td>
						<td>{{$usr->detalle}}</td>
						<td>
						<button class="btn btn-primary fa fa-refresh" data-toggle="modal" data-target="#ModalUsuario" onclick="CargarTipo({{$usr->id}})"></button>
						
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

   {!!Html::script('js/usuario.js')!!}
@endsection
