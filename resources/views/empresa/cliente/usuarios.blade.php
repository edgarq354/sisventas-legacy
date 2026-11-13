
@extends ('layouts.inicio')
@section ('contenido')
@include('alerts.success')
@include('alerts.request')
@include('alerts.errors')
@include('admins.usuarios_empresa.modal_usuario')







	<div class="row">	
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="table-responsive" style="overflow-x:inherit">	

		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
			<font size="6">ROL DE USUARIO</font>
		</div>

		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
		   
		</div>

		<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
			 
			</div> 
	 
<div class="panel-body">
				<table class="table table-striped table-bordered table-condensed table-hover" style="background: white" id="tabla_sin_imprimir">
					<thead>
						<th><center>NOMBRE</center></th>
						<th><center>USUARIO</center></th>
						<th><center>TIPO</center></th>
						<th><center>OPCION</center></th>
					</thead>
					<tbody align="center" id="body_usuario">					
					@foreach($usuario as $user)
					<tr>
						<td align="left">{{ $user->nombre}}</td>
						<td align="left">{{ $user->usuario}}</td>
						<td align="left">
						<?php 
						$tipo="";
						if ($user->privilegio == 0) {
							$tipo="ADMINISTRADOR";
						} elseif ($user->privilegio == 3) {
							$tipo="NORMAL";							
						} 
						
													
						echo $tipo; ?></td>
						<td>
						<button class="btn btn-success fa fa-list" data-toggle="modal" data-target="#historial_inicio_sesion" onclick="Cargar_historial_inicio_sesion_empresa({{$user->id}})"></button>

						<button class="btn btn-default"  data-toggle="modal" data-target="#ModalContraseña_usuario" onclick="Cargar_Admin_Usuario({{$user->id}},{{$user->id_empresa}},{{$user->privilegio}},'')">CAMBIAR CONTRASEÑA</button>
					</td>
					</tr>
					@endforeach
					</tbody>

					<tbody align="center" id="body_usuario_2">
					</tbody>					
				</table>
</div>
			</div>
		</div>
	</div>
{!!Html::script('js/admins_usuario.js')!!}	
@endsection





