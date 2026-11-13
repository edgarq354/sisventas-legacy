@extends ('layouts.inicio')
@section ('contenido')
@include('alerts.success')
@include('alerts.request')
@include('alerts.errors')
@include('pedido.modal')
	
	<div class="row">	

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

{!!Form::open(['route'=>'pedido.index', 'method'=>'GET'])!!}	
		<div class="form-group  col-lg-2 col-md-2 col-sm-2 col-xs-12"  >
		<div class='input-group date' id='datetimepicker11' data-toggle="tooltip" data-placement="top" title="Fecha de inicio">
		  {!!Form::text('fecha_inicio',date('Y-m-j'),['id'=>'fecha_inicio','class'=>'form-control','maxlength'=>'10','onkeypress'=>'return bloqueo_de_punto(event)','style'=>'font-size:20px;text-align:left'])!!}		
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

		  	{!!Form::text('fecha_fin',date('Y-m-j'),['class'=>'form-control','maxlength'=>'10','style'=>'font-size:20px;text-align:left;'])!!}        
          		<span class="input-group-addon ">
            	 <span class="fa fa-calendar" aria-hidden="true"></span>  <!--span class="glyphicon glyphicon-calendar"></span-->
          	</span>
        	</div>
        </div>
        <div class="form-group  col-lg-2 col-md-2 col-sm-2 col-xs-12" >
		{!!Form::select('filtro', array( 
		'0' => 'TODOS',
		'1' => 'COMPLETADOS', 
		'2' => 'CANCELADOS',
		'3'=>'UN MOVIL',
		'4'=>'DE LUJO',
		'5'=>'CON AIRE',
		'6'=>'CON MALETERO',
		'7'=>'RESERVAS',
		'8'=>'MOTO',
		'9'=>'PEDIDOS EN MOVIL',
		'10'=>'PEDIDOS EN MOTO'
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
		      <div class=" panel panel-primary">
      	<div class="panel-heading">Historial de servicios por aplicación</div>
      	<div class="panel-body">
      

<div class="panel-body">
				<table class="table table-striped table-bordered table-condensed table-hover" style="background: white" id="myTable">		

					<thead>
						<th><center>Id</center></th>
						<th><center># Movil</center></th>
						<th><center>Conductor</center></th>
						<th><center>Pasajero</center></th>
						<th><center>Fecha de registro</center></th> 
						<th><center><i class="fa fa-money"></i> Monto</center></th>
						<th><center>Tipo de vehiculo</center></th> 
						<th><center>Estado</center></th>
						<th><center>. . .</center></th>
						
					</thead>

					<tbody align="center" id="body_conductor">					
					@foreach($pedido as $usr)

						@if($usr->estado==0)
						<tr class=" bg-navy"  style="opacity: 0.5; ">
						
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
						<td><b>{{ $usr->codigo_empresa}}</b></td>

						


						<td align="left">
						  <a href="{!!URL::to('conductors',$usr->id_conductor)!!} "  > {{ $usr->nombre}} {{ $usr->paterno}} {{$usr->materno}} </a> 
						
						<button class="fa fa-phone btn btn-link" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Ver el número de celular" onclick="mensaje('Número de celular del conductor','{{$usr->celular_conductor}}');"></button>
						</td>
						
						<td align="left">{{ $usr->pasajero}} <button class="fa fa-phone btn btn-link" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Ver el número de celular" onclick="mensaje('Número de celular del pasajero','{{$usr->celular_pasajero}}');"></button></td>
						<td>{{ $usr->fecha_pedido}}</td>
						 
						<td>
							@if($usr->estado==2)
							{{ $usr->monto_total}} Bs
							@else
							-
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
							<hidden><label style="visibility: collapse;">{{$usr->estado}}</label></hidden>
							@if($usr->estado==0)
						 
						<a class="fa fa-street-view btn btn-primary" target="_BLANK" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="En camino a la ubicación del pasajero"  href="{!!URL::to('ver_detalle_pedido_por_id',$usr->id)!!}"></a>
						@elseif($usr->estado==1)
						<a class="fa fa-location-arrow btn btn-link" target="_BLANK"  aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Con pasajero abordo" href="{!!URL::to('ver_detalle_pedido_por_id',$usr->id)!!}"></a>
						@elseif($usr->estado==2)
						 <a href="{!!URL::to('ver_detalle_pedido_por_id',$usr->id)!!}" target="_BLANK" class="fa fa-check btn btn-link" aria-hidden="true"  title="Pedido finalizado" />
						 
						@elseif($usr->estado==4)
						 

						<a href="{!!URL::to('ver_detalle_pedido_por_id',$usr->id)!!}" target="_BLANK" class="fa fa-user-times btn btn-link" aria-hidden="true"  title="Pedido cancelado por el pasajero"   style="color:red;"/>
						@elseif($usr->estado==5)
					 

						<a href="{!!URL::to('ver_detalle_pedido_por_id',$usr->id)!!}" target="_BLANK" class="fa fa-id-card-o btn btn-link" aria-hidden="true"  title="Pedido cancelado por el conductor"  style="color:red;" />
						@endif
						</td>
						
						<td align="left">
							 
							 <a href="{!!URL::to('ver_detalle_pedido_por_id',$usr->id)!!}" target="_BLANK"  class="fa fa-eye btn btn-link" aria-hidden="true"  title="Pedido finalizado" />
						 

						</td>
					</tr>
					@endforeach
					</tbody>

				</table>
</div>
</div>
</div>
			</div>


		</div>
	</div>
   {!!Html::script('js/pedido.js')!!}

@endsection
