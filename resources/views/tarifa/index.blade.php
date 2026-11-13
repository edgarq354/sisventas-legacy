@extends ('layouts.inicio')
@section ('contenido')
@include('alerts.success')
@include('alerts.request')
@include('alerts.errors')



 
	
	<div class="row">	
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="table-responsive" style="overflow-x:inherit">	
		<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
			<font size="6">TARIFARIO</font>
		</div>

		<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
		  <a class='btn btn-success fa fa-plus' data-toggle="modal" data-target="#ModalCrearNuevo"> Agregar</a>
		</div>

      
<div class="panel-body">
				<table class="table table-striped table-bordered table-condensed table-hover" style="background: white" id="myTable">
					<thead>
						<th><center>ID</center></th>
						<th><center>LOCALIDAD</center></th>
						<th><center>...</center></th>
						
					</thead>

					<tbody align="center" >					
					@foreach($tarifa as $usr)
					<tr>
						 
						<td>{{ $usr->id}}</td>
						<td>{{ $usr->nombre_localidad}}</td>
						 
						<td>
						{!!link_to_route('tarifa.edit','', $parameters = $usr->id, $attributes = ['class'=>'btn btn-primary fa fa-eye','data-toggle'=>'tooltip','data-placement'=>'top','title'=>'Ver y editar'])!!}
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

   {!!Html::script('js/categoria_edit.js')!!}
@endsection
