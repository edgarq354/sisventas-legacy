
@extends ('layouts.inicio')
@section ('contenido')
@include('alerts.success')
@include('alerts.request')
@include('alerts.errors')
@include('empresa.modal')
	<div class="row">	
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="table-responsive" style="overflow-x:inherit">	

		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
			<font size="6">ASOCIACIÓN</font>
		</div>

	

       
		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
			<div class="pull-right">
				<?php //{!!link_to_route('empresa.show', $title = 'REGISTRAR',  $attributes = ['class'=>'btn btn-success'])!!}									 ?>	
				<?php if (Auth::user()->privilegio != 2): ?>
					<a class="btn btn-success" href="{!!URL::to('empresa/create')!!}">REGISTRAR</a> 					
				<?php endif ?>
			</div>
		</div>
				<table class="table table-striped table-bordered table-condensed table-hover" style="background: white">
					<thead>
						<th><center>ASOCIACION</center></th>
						<th><center>CORREO</center></th>
						<th><center>DIRECCION</center></th>
						<th><center>DEPARTAMENTO</center></th>
						<th><center>OPCION</center></th>
					</thead>
					<tbody align="center" id="body_empresa">					
					@foreach($empresa as $user)
					<tr>
						<td>{{ $user->razon_social}}</td>					
						<td>{{ $user->correo}}</td>
						<td>{{ $user->direccion}}</td>
						<td>{{ $user->departamento}}</td>
						<td>
						{!!link_to_route('empresa.edit', $title = '', $parameters = $user->id, $attributes = ['class'=>'btn btn-primary fa fa-eye'])!!}	
						<a class='btn btn-warning fa fa-building' href='empresa_asociacion/{{$user->id}}'>Empresas</a>
						</td>
					</tr>
					@endforeach
					</tbody>

					<tbody align="center" id="body_empresa_2">
					</tbody>					
				</table>
	<div class="pull-left">	{!!$empresa->render()!!}  </div>
	<div class="pull-right">	<button class="btn btn-default" id="mostrar" onclick="ver_todos()"><b>VER TODOS</b></button>  </div>	

			</div>
		</div>
	</div>
   {!!Html::script('js/empresas.js')!!}

@endsection





