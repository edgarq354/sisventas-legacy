@extends ('layouts.inicio')
@section ('contenido')
@include('alerts.success')
@include('alerts.request')
@include('alerts.errors')

	

        
	<div class="row">	
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="table-responsive" style="overflow-x:inherit">	
		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
			<font size="6">CONDUCTORES RETIRADOS</font>
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
						<th><center>Celular</center></th>
						<th><center>Fecha de retiro</center></th>
						<th><center>Credito</center></th>
						<th><center>Monto a pagar <i class="fa fa-building-o" aria-hidden="true"></i> </center></th>
						<th><center>. . .</center></th>
						
					</thead>

					<tbody align="center" id="body_conductor">					
					@foreach($conductor as $con)
					<tr>
						<td>{{ $con->ci}} {{ $con->expedido}}</td>
						<td>
						@if($con->tipo_asignacion==0)
						<a class='btn btn-success fa fa-link ' data-toggle="modal" data-target="#ModalCambiarVehiculo"> Asignar : {{ $con->numero_movil}}<b></b></a>
						@else
						<b>{{ $con->numero_movil}}</b>
						@endif
						</td>
						<td>{{ $con->nombre}} {{ $con->paterno}} {{ $con->materno}}</td>
						<td>{{ $con->celular}}</td>
						<td><b>{{ $con->fecha_retiro}}</b></td>
						<td>{{ $con->credito}}</td>	
						<td>
						<?php  
							$monto=DB::select("SELECT sum(monto_conductor)as 'monto_total' from pedido where id_conductor='".$con->ci."'");
							$monto=$monto[0]->monto_total;
				            ?>
            				<label>{{$monto}} Bs</label>
          				 </td>
						<td>
					
						
						<div class="btn-group">
                            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                              Opción <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                            	<li>
                            		<a class=' fa fa-eye' href='conductors/{{$con->ci}}' aria-hidden="true"  data-toggle="tooltip" data-placement="top" title="Ver y editar">  Ver y editar</a>
                            	</li>
                            	<li> 
	                              		<a  class=' fa fa-commenting' href='chat_conductor/{{$con->ci}}' aria-hidden="true"  data-toggle="tooltip" data-placement="top" title="Chat"> Chat</a>
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
