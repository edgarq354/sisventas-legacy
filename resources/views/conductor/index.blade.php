@extends ('layouts.inicio')
@section ('contenido')
@include('alerts.success')
@include('alerts.request')
@include('alerts.errors')
@include('conductor.modal')
	

        
	<div class="row">	
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="table-responsive" style="overflow-x:inherit">	
		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
			<font size="6">CONDUCTOR</font>
		</div>

		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
		
		</div>

       
		<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
			<button class="btn btn-link"> <a href="{!!URL::to('conductor/create')!!}" data-toggle="tooltip" data-placement="top" title="Registrar un nuevo Conductor"><i class="fa fa-plus" aria-hidden="true"></i><span> Agregar Conductor</span></a> </button>                         
		</div>
       
		

<div class="panel-body">
				<table class="table table-striped table-bordered table-condensed table-hover" style="background: white" id="myTable">
					<thead>
						<th><center>C.i.</center></th>
						<th><center># Movil</center></th>
						<th><center>Conductor</center></th>
						<th><center>Licencia de C.</center></th>
						<th><center>Celular</center></th>
						<th><center>Fecha de nacimiento</center></th>
						<th><center>Credito</center></th>
						<th><center>Localidad</center></th>
						<th><center>Monto a pagar <i class="fa fa-building-o" aria-hidden="true"></i> </center></th>
						<th><center>. . .</center></th>
						
					</thead>

					<tbody align="center" id="body_conductor">					
					@foreach($conductor as $con)
					<tr>
						<td>{{ $con->ci}} {{ $con->expedido}}</td>
						<td>
						@if($con->tipo_asignacion==0)
						<a class='btn btn-success fa fa-link ' data-toggle="modal" data-target="#ModalCambiarVehiculo"> Asignar</a>
						@else
						<b>{{ $con->codigo_empresa}}</b>
						@endif
						</td>
						<td>{{ $con->nombre}} {{ $con->paterno}} {{ $con->materno}}</td>
						<td>{{ $con->categoria_licencia}}</td>
						<td>{{ $con->celular}}</td>
						<td>{{ $con->fecha_nacimiento}}</td>
						<td>{{ $con->credito}}</td>	
						<td>{{ $con->localidad}}</td>	
						<td>
						<?php 
						 try{
							$monto=DB::select("SELECT sum(monto_conductor)as 'monto_total' from pedido where tipo_pedido_empresa=1 and  id_conductor='".$con->ci."'");
							$monto=$monto[0]->monto_total;
							}catch(Exception  $e){
								$monto=0;
							}
				            ?>
            				<label>{{$monto}} Bs</label>
          				 </td>
						<td>
							@if($con->estado_asignacion==1)
							<i class="fa fa-thumbs-up btn btn-link"  aria-hidden="true" aria-hidden="true"  data-toggle="tooltip" data-placement="top" title="Estado activo"></i>
							@else
							<i class="fa fa-thumbs-o-down btn btn-link" aria-hidden="true" aria-hidden="true"  data-toggle="tooltip" data-placement="top" title="Suspendido"></i>
							@endif	
							
							<div class="btn-group">
	                            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
	                              Opción <span class="caret"></span>
	                            </button>
	                            <ul class="dropdown-menu" role="menu">
	                            	<li>
	                            		<a class=' fa fa-eye' href='conductors/{{$con->ci}}' aria-hidden="true"  data-toggle="tooltip" data-placement="top" title="Ver y editar">  Ver y editar</a>
	                            	</li>
	                              <li>
	                              	<a href="" class=" fa fa-money" data-toggle="modal" data-target="#ModalPagarConductor" onclick="Cargar_monto_pagar('{{$con->codigo_empresa}}','{{$con->ci}}','{{$con->nombre}} {{$con->paterno}} {{$con->materno}}','{{$monto}}');"  > Pagar al conductor</a>
	                              </li>
	                              <li> 
	                              	<a href="" class="  fa fa-commenting-o" data-toggle="modal" data-target="#ModalNotificacion" onclick="Cargarconductor('{{$con->ci}}','{{$con->nombre}} {{$con->paterno}} {{$con->materno}}','{{$con->token}}');"  aria-hidden="true"  data-toggle="tooltip" data-placement="top" title="Enviar notificación"> Enviar notificación</a>
	                              </li>
	                              <li> 
	                              		<a  class=' fa fa-commenting' href='chat_conductor/{{$con->ci}}' aria-hidden="true"  data-toggle="tooltip" data-placement="top" title="Chat"> Chat</a>
	                              </li>
	                              <li>
	                              	<a   class=' fa fa-history ' href="{!!URL::to('pago_frecuencia/historial',$con->ci)!!} " target="_blanck" data-toggle="tooltip" data-placement="top" title="Historial de pagos"> Historial de pagos</a>
	                              </li>
	                              <li>
	                              	<a  class=' fa fa-list' href='conductor_pedido/{{$con->ci}}' aria-hidden="true"  data-toggle="tooltip" data-placement="top" title="Ver historial de pedidos"> Ver historial de pedidos</a>
	                              </li>
	                            </ul>
	                          </div>
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


   {!!Html::script('js/conductor.js')!!}
@endsection
