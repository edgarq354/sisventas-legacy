@extends ('layouts.inicio')
@section ('contenido')
@include('alerts.success')
@include('alerts.request')
@include('alerts.errors')
@include('pedido.modal')
	
	<div class="row">	

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

 
  {{Form::open(array('url' => 'solicitudes_sin_aceptar', 'method'=>'GET','onKeypress'=>'if(event.keyCode == 13) event.returnValue = false;'))}} 
		<div class="form-group  col-lg-2 col-md-2 col-sm-2 col-xs-12"  >
		<div class='input-group date' id='datetimepicker11' data-toggle="tooltip" data-placement="top" title="Fecha de inicio">
		  {!!Form::text('fecha_inicio',$fecha_inicio,['id'=>'fecha_inicio','class'=>'form-control','maxlength'=>'10','onkeypress'=>'return bloqueo_de_punto(event)','style'=>'font-size:20px;text-align:left'])!!}		
		  <span class="input-group-addon ">
		     <span class="fa fa-calendar" aria-hidden="true"></span> 
		  </span>
		</div>
		</div>
		<div class=" col-lg-1 col-md-1 col-sm-1 col-xs-12"  >
			<font ><b>Entre</b></font> 
		</div>
		
		<div class="form-group  col-lg-2 col-md-2 col-sm-2 col-xs-12" >
        	<div class='input-group date' id='datetimepicker10' data-toggle="tooltip" data-placement="top" title="Fecha fin">

		  	{!!Form::text('fecha_fin',$fecha_fin,['class'=>'form-control','maxlength'=>'10','style'=>'font-size:20px;text-align:left;'])!!}        
          		<span class="input-group-addon ">
            	 <span class="fa fa-calendar" aria-hidden="true"></span>  <!--span class="glyphicon glyphicon-calendar"></span-->
          	</span>
        	</div>
        </div>
        <div class="form-group  col-lg-2 col-md-2 col-sm-2 col-xs-12" >
		{!!Form::select('filtro', array( 
		'0' => 'TODOS',
		'1' => 'PEDIDOS', 
		'2' => 'RESERVAS',
		 ),null,array('id'=>'expedido','class'=>'custom-select form-control dropdown-toggle','data-toggle' => 'dropdown'))!!}
		</div>	

        
		<div class=" form-group col-lg-2 col-md-2 col-sm-2 col-xs-12 " >		
		<button class="btn-sm btn-primary" id="btn_buscar" name='btn_buscar'onclick="btn_esconder()"  data-toggle="tooltip" data-placement="top" title="Buscar"><i class="fa fa-search"  ></i></button> 
		</div>
</form>
</div>
		

		</div>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="table-responsive" style="overflow-x:inherit">	
		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
			<font size="6">Pedidos y reservas sin aceptar</font>
		</div>
      

<div class="panel-body">
				<table class="table table-striped table-bordered table-condensed table-hover" style="background: white" id="myTable">		

					<thead>
						<th><center>Id</center></th>
						<th><center>Pasajero</center></th>
						<th><center>Fecha de registro</center></th>
						<th><center>Fecha de reserva</center></th> 
						<th><center>Tipo de vehiculo</center></th>
						<th><center>Tipo</center></th>
						<th><center>Empresa</center></th>
						<th><center>. . .</center></th>
						
					</thead>

					<tbody align="center" id="body_conductor">					
					@foreach($pedido as $usr)

						@if($usr->estado==0)
						<tr class=" bg-navy"  style="opacity: 0.5; " >
						
						@elseif($usr->estado==1)
						<tr style="background:rgba(48,148,70,0.1); ">
						@elseif($usr->estado==2)
						<tr style="background:rgba(0,255,200,0.8); ">
						@elseif($usr->estado==4)
						<tr    style="background:rgba(255,0,0,0.1); ">
						@elseif($usr->estado==5)
						<tr style="background:rgba(255,255,0,0.1); ">
						@else 
							<tr >
						@endif
						

						<td>{{ $usr->id}}</td>

						 
						
						<td align="left">{{ $usr->pasajero}} <button class="fa fa-phone btn btn-link" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Ver el número de celular" onclick="mensaje('Número de celular del pasajero','{{$usr->celular_pasajero}}');"></button></td>
						<td>{{ $usr->fecha_pedido}}</td>
						<td>
							@if($usr->tipo_reserva_auxiliar==1)
							 {{ $usr->fecha_reserva}}
							@else
							--
							@endif
						</td>
						 
						<td>
							@if($usr->clase_vehiculo==1)
							MOVIL NORMAL
							@elseif($usr->clase_vehiculo==2)
							DE LUJO
							@elseif($usr->clase_vehiculo==3)
								CON AIRE
							@elseif($usr->clase_vehiculo==4)
							 CON MALETERO
							@elseif($usr->clase_vehiculo==5)
							PEDIDO
							@elseif($usr->clase_vehiculo==6)
							RESERVA
							@elseif($usr->clase_vehiculo==7)
							MOTO
							@elseif($usr->clase_vehiculo==7)
							MOTO PEDIDO
							@endif
						</td>
						<td>
							<b>
							@if($usr->tipo_reserva_auxiliar==1)
								@if($usr->estado_reserva==4)
									RESERVA CANCELADO
								@else
									RESERVA
								@endif
							@elseif($usr->estado==4)
								PEDIDO CANCELADO							 
							@else
							--
							@endif
						</b>
						</td>
						<td>
							@if($usr->tipo_pedido_empresa==1)
							<?php
							try{
							$empresa=DB::select("SELECT razon_social from empresa where id='".$usr->id_empresa_cliente."'");
							echo $empresa[0]->razon_social;
							}catch(Exception $e){

							}
							?>
							@endif
						</td>
						 
						
						<td align="left">
						<button class="btn btn-link fa fa-eye" data-toggle="modal" data-target="#Modal_pedido_sin_aceptar" onclick="detalle_pedido_reserva_sin_aceptar('{{$usr->id}}');"></button>
						</td>
					</tr>
					@endforeach
					</tbody>

				</table>
</div>
			</div>


		</div>
	</div>
   {!!Html::script('js/pedido.js')!!}

@endsection
