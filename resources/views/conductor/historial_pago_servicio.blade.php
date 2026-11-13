@extends ('layouts.inicio')
@section ('contenido')
@include('alerts.success')
@include('alerts.request')
@include('alerts.errors')
@include('usuario.modal')
	
	
	<div class="row">	
		
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
				<font size="6">HISTORIAL DE PAGOS DE SERVICIO CORPORATIVOS</font><BR>
			</div>
			<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
			<div class="pull-right">
				<a class="btn btn-link fa fa-plus" href="{!!URL::to('egreso/create')!!}"> Agregar Egreso</a> 
			</div>
		</div>
		</div>
 
		

<?php
$monto_total=0; 
?>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="table-responsive" style="overflow-x:inherit">	
		
		
      

				<table class="table table-striped table-bordered table-condensed table-hover" style="background: white" id="myTable">
					<thead>
						<th><center>ID</center></th>
						<th><center>FECHA</center></th>
						<th><center>USUARIO</center></th>
						<th><center>OBSERVACIONES</center></th>
						<th><center>MONTO</center></th>
						<th><center>DEBE</center></th>
						<th><center>TIPO EGRESO</center></th>
						<th><center>OPCION</center></th>
						<th><center>. . .</center></th>
						
					</thead>

					<tbody align="center" id="body_egreso">					
					@foreach($egreso as $usr)
					<tr>
							<td>{{ $usr->id}}</td>
						<td>{{$usr->fecha}}</td>
						<td>{{$usr->usuario}}</td>
						<td>{{$usr->observacion}}</td>
						<td><b>{{$usr->monto}}</b></td>
						<td>{{$usr->debe}}</td>
						<td>{{$usr->tipo_egreso}}</td>
						<td>@if($usr->opcion==1)
							CONDUCTOR
							@elseif($usr->opcion==2)
							CORPORATIVO
							@elseif($usr->opcion==0)
							NORMAL
							@endif
						</td>
						 
						<td>
						<a class='btn btn-warning fa fa-print' href="{!!URL::to('egreso/comprobante_egreso_pdf',[$usr->id])!!}" data-toggle="tooltip" data-placement="top" title="Imprimir" target="_blanck"></a>
						</td>
					</tr>
					<?php 
					$monto_total+=$usr->monto;
					?>
					@endforeach
					</tbody>

					<tbody align="center" id="body_conductor_2">
					</tbody>					
				</table>

	<div class="pull-left btn btn-success">Monto total de egreso es<b> {{$monto_total}} bs</b> </div>
			</div>


		</div>
	</div>

   {!!Html::script('js/usuario.js')!!}
@endsection
