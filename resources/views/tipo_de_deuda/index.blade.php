@extends ('layouts.inicio')
@section ('contenido')
@include('alerts.success')
@include('alerts.request')
@include('alerts.errors')
@include('tipo_de_deuda.modal')






	
	<div class="row">	
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="table-responsive" style="overflow-x:inherit">	
		<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
			<font size="6">TIPO DE DEUDA</font>
		</div>

		<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
		  <a class='btn btn-success fa fa-plus' data-toggle="modal" data-target="#ModalCrearNuevo"> Agregar</a>
		</div>

      
<div class="panel-body">
				<table class="table table-striped table-bordered table-condensed table-hover" style="background: white" id="myTable">
					<thead>
						<th><center>ID</center></th>
						<th><center>NOMBRE</center></th>
						<th><center>ESTADO</center></th>
						<th><center>...</center></th>
						
					</thead>

					<tbody align="center" id="body_tipo_de_deuda">					
					@foreach($tipo_de_deuda as $usr)
					<tr>
						<td>{{ $usr->id}}</td>
						<td>{{ $usr->nombre}}</td>
						<td>@if($usr->estado==1)ACTIVO @else INACTIVO @endif </td>
						<td>
						<BUTTON class='btn btn-success fa fa-eye ' data-toggle="modal" onclick="cargar_tipo_de_deuda({{$usr->id}});" data-target="#ModalEditar"> </BUTTON>
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
	</div>

   {!!Html::script('js/tipo_de_deuda_edit.js')!!}
@endsection
