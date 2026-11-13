@extends ('layouts.inicio')
@section ('contenido')
@include('alerts.success')
@include('alerts.request')
@include('alerts.errors')
@include('lugar.modal')

	<div class="row">	
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="table-responsive" style="overflow-x:inherit">	
		<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
			<font size="6">TIENDAS</font>
		</div>

		<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
		  <a class='btn btn-success' href="{!!URL::to('lugar/create')!!}"> 
			<i class="fa fa-plus"></i>
		  Agregar</a>
		</div>

      
<div class="panel-body">
				<table class="table table-striped table-bordered table-condensed table-hover" style="background: white" id="myTable">
					<thead>
						<th><center>NOMBRE</center></th>
						<th><center>DIRECCION</center></th>
						<th><center>TELEFONO</center></th>
						<th><center>WHATSAPP</center></th>
						<th><center>ESTADO</center></th>
						<th><center>PEDIDO</center></th>
						<th><center>DEUDA</center></th>
						<th><center>CANT.</center></th>
						<th><center><div class="fa fa-whatsapp fa-2x">             
            </div></center></th>
						<th><center>...</center></th>
						
					</thead>

					<tbody align="center" id="body_video">					
					@foreach($lugar as $usr)
					<tr>
						<td>{{ $usr->nombre}}</td>
						<td>{{ $usr->direccion}}</td>
						<td>{{ $usr->telefono}}</td>
						<td>{{ $usr->whatsapp}}</td>
						<td>@if($usr->estado==1)
							<i class="fa fa-circle  fa-red" style="color:green;" aria-hidden="true"></i>
							@else
							<i class="fa fa-circle  " style="color:red;" aria-hidden="true"></i>
							@endif
						</td>
						<td>@if($usr->estado_pedido==1)
							<label style="color: green;">REALIZA</label>
							@else
							<label style="color: red;">NO REALIZA</label>
							@endif
						</td>
						<td>{{ $usr->monto_deuda}}</td>
						<td>{{ $usr->cantidad}}</td>
						<td>{{ $usr->cantidad_whatsapp}}</td>
						<td>
						{!!link_to_route('lugar.edit','', $parameters = $usr->id, $attributes = ['class'=>'btn btn-primary fa fa-eye','data-toggle'=>'tooltip','data-placement'=>'top','title'=>'Ver y editar'])!!}
						
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

   {!!Html::script('js/video_edit.js')!!}
@endsection
