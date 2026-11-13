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
			<font size="6">PASAJEROS</font>
		</div>

		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
		  
		</div>

      
<div class="panel-body">
				<table class="table table-striped table-bordered table-condensed table-hover" style="background: white" id="myTable">
					<thead>
						<th><center>Perfil</center></th>
						<th><center>Nombre</center></th>
						<th><center>Celular</center></th>
						<th><center>Cant. Solicitud</center></th>
						<th><center>Fecha de registro</center></th>
						<th><center>Estado</center></th>
						<th><center>Codigo</center></th>
						<th><center>Aplicación</center></th>
						<th><center>. . .</center></th>
						
					</thead>

					<tbody align="center" id="body_conductor">					
					@foreach($usuario as $usr)
					<tr>
						<td>  <a href="../../taxivalle2/{{$usr->direccion_imagen}}" target="_blank"><img src="../../taxivalle2/{{$usr->direccion_imagen}}" width="90px" height="90px" title="PERFIL" class="img-thumbnail"></a></td>
						<td>{{ $usr->nombre}} {{ $usr->apellido}}</td>
						<td>{{ $usr->celular}}</td>
						<td>{{ $usr->cantidad_solicitud}}</td>
						<td>{{ $usr->fecha_registro}}</td>
						<td>
							@if($usr->estado==1)
							ACTIVO
							@else
							BLOQUEADO
							@endif
						</td>
						<td>
							<?php
							echo base_convert("1999".$usr->id, 10,16); 
							 ?>
							 </td>
						<td>{{$usr->aplicacion}}</td>
						<td>
						 	<div class="btn-group">
                            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                              Opción <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                            	<li>
                            		<a class='fa fa-eye' href="pasajero/{{$usr->id}}/edit" aria-hidden="true"  data-toggle="tooltip" data-placement="top" title="Ver y editar"> Editar</a>
                            	</li>
                            	<li>
                            		<a class=' fa fa-print' href='historial_pedidos/{{$usr->id}}' aria-hidden="true"  data-toggle="tooltip" data-placement="top" title="Ver y editar"> Historial de servicios</a>
                            	</li>
                            	<li>
                            		<a class=' fa fa-list' href='historial_bloqueo_pasajero/{{$usr->id}}' aria-hidden="true"  data-toggle="tooltip" data-placement="top" title="Ver y editar"> Historial de bloqueos</a>
                            	</li>
                            	<li>
                            		<a class='fa fa-key' href=''  data-toggle="modal" data-target="#ModalBloqueo" aria-hidden="true"  data-toggle="tooltip" data-placement="top" title="Ver y editar" onclick="cargar_usuario_token_id('{{$usr->token}}','{{$usr->id}}','{{$usr->estado}}');"> Cambiar el estado</a>
                            	</li>
                              <li>
                              	<a href="" class="fa fa-commenting-o" data-toggle="modal" data-target="#ModalNotificacion" onclick="cargar_usuario('{{$usr->token}}');"> Enviar Notificación</a>
                              </li>
                               
                            </ul>
                          </div>
						 
						</td>
					</tr>
					@endforeach
					</tbody>

										
				</table>
				</div>

			</div>


		</div>
	</div>

   {!!Html::script('js/usuario.js')!!}
@endsection
