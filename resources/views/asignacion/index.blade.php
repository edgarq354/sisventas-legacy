@extends ('layouts.inicio')
@section ('contenido')
@include('alerts.success')
@include('alerts.request')
@include('alerts.errors')
@include('asignacion.modal')





	<div class="row">	
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="table-responsive" style="overflow-x:inherit">	
		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
			<font size="6">ASIGNACION</font>
		</div>

		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
		
		</div>

       
		<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
		</div>

	<div class="panel-body">
				<table class="table table-striped table-bordered table-condensed table-hover" style="background: white" id="myTable">
					<thead>
						<th><center>G.E.A.</center></th>
						<th><center>CI</center></th>
						<th><center>CONDUCTOR</center></th>
						<th><center>PLACA</center></th>
						<th><center>MARCA</center></th>
						<th><center>CLASE DE VEHICULO</center></th>
						<th><center>OPCION</center></th>
						
					</thead>

					<tbody align="center" id="body_asignacion">					
					@foreach($asignacion as $con)

						<?php
                      $cantidad=DB::select("SELECT count(c.ci)as cantidad from frecuencia f,conductor c 
                      	where c.ci=".$con->ci." AND c.id_empresa=".Auth::user()->id_empresa." and f.tipo=c.tipo_de_pago and  
                      	f.fecha_fin<=now() and f.fecha_inicio>=c.fecha_inicio_pago and f.id not in(SELECT df.id_frecuencia 
                      		from pago_frecuencia pf,detalle_frecuencia df,conductor c where c.ci=pf.id_conductor 
                      		and pf.id=df.id_pago_frecuencia and pf.id_conductor=".$con->ci." 
                      		and c.id_empresa=".Auth::user()->id_empresa." and f.fecha_inicio>=c.fecha_inicio_pago )");
                        ?>
                       @if($con->estado_asignacion==2)
                       <tr class="bg-red">
                       @else
                       <tr>
                       @endif
					
						<td>{{$con->codigo_empresa}}</td>					
						<td>{{$con->ci}} {{$con->expedido}}</td>
						<td align="left" >{{$con->nombre}} {{$con->paterno}} {{$con->materno}}</td>
						<td>{{$con->id_vehiculo}}</td>
						<td>{{$con->marca}}</td>
						<td>{{$con->clase}}</td>
						
						@if($con->estado_asignacion==1)
						<td>
						@else
						<td class="bg-yellow">
						@endif

						@if($cantidad[0]->cantidad>0)
						<i title="Cantidad de deudas del Movil" class="fa fa-money btn btn-link" style="color:red;" aria-hidden="true" data-toggle="tooltip" data-placement="top" > {{$cantidad[0]->cantidad}}</i>
						@endif



						@if($con->estado_asignacion==1)
						<i title="Estado activo" class="fa fa-thumbs-up btn btn-link" aria-hidden="true" data-toggle="tooltip" data-placement="top" ></i>
						@else
						<i class="fa fa-thumbs-o-down btn btn-link" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Estado suspendido"></i>
						@endif	
						<a class='btn btn-link fa fa-eye' alert="Ver" href='asignacions/{{$con->ci}}/{{$con->id_vehiculo}}' aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Ver y editar"></a>
						</td>
					</tr>
					@endforeach
					</tbody>

					<tbody align="center" id="body_asignacion_2">
					</tbody>					
				</table>
				</td>

			</div>


		</div>
	</div>

   {!!Html::script('js/asignacion.js')!!}
@endsection
