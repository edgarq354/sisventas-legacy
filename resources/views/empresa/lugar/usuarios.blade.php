@extends ('layouts.inicio')
@section ('contenido')
@include('alerts.success')
@include('alerts.request')
@include('alerts.errors')
@include('usuario.modal')

	
	<div class="row">	
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="table-responsive" style="overflow-x:inherit">	
		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
			<font size="6">USUARIOS</font>
		</div>

		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
		  
		</div>

      
<div class="panel-body">
				<table class="table table-striped table-bordered table-condensed table-hover" style="background: white" id="myTable">
					<thead>
						<th><center>PERFIL</center></th>
						<th><center>USUARIO</center></th>
						<th><center>CELULAR</center></th>
						<th><center>CORREO</center></th>
						<th><center>FECHA DE REGISTRO</center></th>
						<th><center>OPCION</center></th>
						
					</thead>

					<tbody align="center" id="body_conductor">					
					@foreach($usuario as $usr)
					<tr>
						<td> <img src="../../../clasico2/{{$usr->direccion_imagen}}" width="90px" height="90px"  class="img-thumbnail"></td>
						<td>{{ $usr->nombre}} {{ $usr->apellido}}</td>
						<td>{{ $usr->celular}}</td>
						<td>{{ $usr->correo}}</td>
						<td>{{ $usr->fecha_registro}}</td>
						<td>
						<button class="btn btn-info fa fa-commenting-o" data-toggle="modal" data-target="#ModalNotificacion" onclick="cargar_usuario('{{$usr->token}}')"></button>
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

   {!!Html::script('js/usuario.js')!!}
@endsection
