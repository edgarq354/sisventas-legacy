@extends ('layouts.inicio')
@section ('contenido')
@include('alerts.success')
@include('alerts.request')
@include('alerts.errors')
@include('radio.modal')






	
	<div class="row">	
		 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
      <div class=" panel panel-default">
      	<div class="panel-heading"><b>Equipo de Radio</b>  
      		<div align="right"><a class='btn btn-success fa fa-plus'  data-toggle="modal" data-target="#ModalCrearNuevo"> Agregar</a></div>

      	</div>
      	<div class="panel-body">

		 

      
<div class="panel-body">
				<table class="table table-striped table-bordered table-condensed table-hover" style="background: white" id="myTable">
					<thead>
						<th><center>Codigo</center></th>
						<th><center>Marca</center></th>
						<th><center>Modelo</center></th>
						<th><center>Descripción</center></th>
						<th><center>Estado</center></th>
						<th><center>Usuario</center></th>
						<th><center>Fecha</center></th>
						<th><center>...</center></th>
						
					</thead>

					<tbody align="center" id="body_video">					
					@foreach($radio as $usr)
					<tr>
						<td>{{ $usr->id}}</td>
						<td>{{ $usr->marca}}</td>
						<td>{{ $usr->modelo}}</td>
						<td>{{ $usr->descripcion}}</td>
						<td>
							@if($usr->estado==0)
							NO DISPONIBLE
							@elseif($usr->estado==1)
							DISPONIBLE
							@elseif($usr->estado==2)
							EN REPARACION
							@endif

						</td>
						<td>{{ $usr->nombre}}</td>
						<td>{{ $usr->fecha}}</td>
						<td>
						<a class='btn btn-success fa fa-eye ' data-toggle="modal" onclick="cargar_video({{$usr->id}});" data-target="#ModalEditar"> </a>
						  <a href="{!!URL::to('historial_radio',$usr->id)!!} " class="fa fa-list btn btn-primary"   > </a> 

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

   {!!Html::script('js/radio_edit.js')!!}
@endsection
