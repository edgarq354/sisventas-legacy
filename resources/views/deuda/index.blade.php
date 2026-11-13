@extends ('layouts.inicio')
@section ('contenido')
@include('alerts.success')
@include('alerts.request')
@include('alerts.errors')
@include('deuda.modal')

	

        
	<div class="row">	
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="table-responsive" style="overflow-x:inherit">	
		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
			<font size="6">DEUDAS</font>
		</div>

		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
		
		</div>

       
		<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
			<button class="btn btn-link"> <a href="{!!URL::to('deuda/create')!!}" data-toggle="tooltip" data-placement="top" title="Registrar una nueva deuda"><i class="fa fa-plus" aria-hidden="true"></i><span> Agregar Deuda</span></a> </button>                         
		</div>
       
		

<div class="panel-body">
				<table class="table table-striped table-bordered table-condensed table-hover" style="background: white" id="myTable">
					<thead>
						<th><center>Id</center></th>
						<th><center># Movil</center></th>
						<th><center>Conductor</center></th>
						<th><center>Fecha</center></th>
						<th><center>Descripción</center></th>
						<th><center>Monto a pagar</center></th>
						<th><center>Monto total</center></th>
						<th><center>Usuario</center></th>
						<th><center>Tipo de deuda</center></th>
						<th><center>Estado</center></th>
						<th><center>. . .</center></th>
						
					</thead>

					<tbody align="center" id="body_conductor">					
					@foreach($deuda as $con)
					<tr>
						<td>{{ $con->id}} </td>
						<td>{{ $con->numero_movil}} </td>
						<td> <a href="{!!URL::to('conductors',$con->id_conductor)!!} "  > {{$con->conductor}}</a> </td>
						<td>{{ $con->fecha_registro}}</td>
						<td>{{ $con->descripcion}}</td>
						<td>{{ $con->monto_pagar}} Bs</td>	
						<td>{{ $con->monto}} Bs</td>	
						<td>{{ $con->usuario}} </td>	
						<td>{{ $con->tipo_deuda}}</td>	
						<td>
							 @if($con->estado==1)
								<i class="fa fa-circle  fa-red" style="color:green;" aria-hidden="true"></i>
								@else
								<i class="fa fa-circle  " style="color:red;" aria-hidden="true"></i>
								@endif
          				 </td>
          				 <td>
          				 	<div class="btn-group">
                            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                              Opcion <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                              <li><a  href="{!!URL::to('deuda/edit',$con->id)!!} " class='fa fa-eye'   data-toggle="tooltip" data-placement="top" > Ver y editar</a></li>
                              <li> <a href="" class="  fa fa-money" data-toggle="modal" data-target="#ModalPagarConductor" onclick="Cargar_monto_pagar_deuda( '{{$con->id}}','{{$con->conductor}}','{{$con->monto}}','{{$con->monto_pagar}}','{{$con->id_tipo_deuda}}','{{$con->tipo_deuda}}');"> Pagar</a></li>
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


   {!!Html::script('js/deuda.js')!!}
@endsection
