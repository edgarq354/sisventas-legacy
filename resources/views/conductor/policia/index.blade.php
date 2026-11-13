@extends ('layouts.inicio')
@section ('contenido')
@include('alerts.success')
@include('alerts.request')
@include('alerts.errors')
@include('conductor.modal')
	
<script type="text/javascript">
function getConfirm(l)
{
  if(arguments[0] != null)
  {
  	alertify.confirm("Taxi-Corp","Desea dar de baja EL Conductor?.",
      function(){
        alertify.success('SE REGISTRO LA BAJA DEL CONDUCTOR');
        document.location.href = 'dar_de_baja_conductor/'+l;
      },
      function(){
        alertify.error('SE CANCELO');
      });
   
  }
  else
  {
   alertify.error('ERROR AL DAR DE BAJA');
  }
  return;
}
</script>





	<div class="row">	
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="table-responsive" style="overflow-x:inherit">	
		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
			<font size="6">CONDUCTOR</font>
		</div>

		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
		    
		</div>

       
		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
			<div class="pull-right">
				
				<table>
					<tr>
						<td class="btn btn-link"><a href="{!!URL::to('conductor/create')!!}" data-toggle="tooltip" data-placement="top" title="Registrar un nuevo Conductor"><i class="fa fa-plus" aria-hidden="true"></i><span> Agregar Conductor</span></a> 
						</td>
						<td class="btn btn-link">
							<a href="{!!URL::to('conductores_pdf')!!}">
                			<i class="fa fa-print" aria-hidden="true"></i><span> Imprimir</span>
                 			</a>
						</td>
					</tr>
				</table>
				
			</div>
			
                                     
		</div>

<div class="panel-body">
				<table class="table table-striped table-bordered table-condensed table-hover" style="background: white" id="myTable">
					<thead>
						<th><center>C.i.</center></th>
						<th><center>Conductor</center></th>
						<th><center>Celular</center></th>
						<th><center>Fecha de nacimiento</center></th>
						<!--th><center>CREDITO</center></th-->
						<th><center>Opción</center></th>
						
					</thead>

					<tbody align="center" id="body_conductor">					
					@foreach($conductor as $con)
					<tr>
						<td>{{ $con->ci}} {{ $con->expedido}}</td>
						<td>{{ $con->nombre}} {{ $con->paterno}} {{ $con->materno}}</td>
						<td>{{ $con->celular}}</td>
						<td>{{ $con->fecha_nacimiento}}</td>
						<!--td>{{ $con->credito}}</td-->	
						<td>
						@if($con->panico==1)
						<i class="fa fa-bullhorn btn btn-link"  aria-hidden="true" aria-hidden="true"  data-toggle="tooltip" data-placement="top" title="Con panico"></i> 
						@endif
						@if($con->estado==1)
						<i class="fa fa-thumbs-up btn btn-link"  aria-hidden="true" aria-hidden="true"  data-toggle="tooltip" data-placement="top" title="Estado activo"></i>
						@else
						<i class="fa fa-thumbs-o-down btn btn-link" aria-hidden="true" aria-hidden="true"  data-toggle="tooltip" data-placement="top" title="Estado inactivo"></i>
						@endif	
						<a class='btn btn-primary fa fa-eye' href='conductors/{{$con->ci}}' aria-hidden="true"  data-toggle="tooltip" data-placement="top" title="Ver y editar"></a>
						
						<a class='btn btn-success fa fa-qrcode' href='conductors_pdf/{{$con->ci}}' aria-hidden="true"  data-toggle="tooltip" data-placement="top" title="Codigo QR" target="_blanck"></a>
						
						<button class="btn btn-info fa fa-commenting-o" data-toggle="modal" data-target="#ModalNotificacion" onclick="Cargarconductor('{{$con->ci}}','{{$con->nombre}} {{$con->paterno}} {{$con->materno}}','{{$con->token}}');"  aria-hidden="true"  data-toggle="tooltip" data-placement="top" title="Enviar notificación"></button>
						
						<!--button class="btn btn-info" style="background: #0080FF" data-toggle="modal" data-target="#ModalCargarCredito" onclick="Cargarconductor({{$con->ci}})">CREDITO</button-->
						
						<a class='btn btn-success fa fa-history ' href="{!!URL::to('pago_frecuencia/historial',$con->ci)!!} " target="_blanck" data-toggle="tooltip" data-placement="top" title="Historial de pagos"></a>
						<a class='btn btn-warning fa fa-list' href='conductor_pedido/{{$con->ci}}' aria-hidden="true"  data-toggle="tooltip" data-placement="top" title="Ver historial de pedidos"></a>
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
