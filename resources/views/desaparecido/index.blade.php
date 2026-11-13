@extends ('layouts.inicio')
@section ('contenido')
@include('alerts.success')
@include('alerts.request')
@include('alerts.errors')
	

        
	<div class="row">	
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="table-responsive" style="overflow-x:inherit">	
		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
			<font size="6">DESAPARECIDOS</font>
		</div>

		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
		
		</div>

       
		<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
			<button class="btn btn-link"> <a href="{!!URL::to('desaparecido/create')!!}" data-toggle="tooltip" data-placement="top" title="Registrar un nuevo Desaparecido"><i class="fa fa-plus" aria-hidden="true"></i><span> Agregar Desaparecidos</span></a> </button>                         
		</div>
       
		

<div class="panel-body">
				<table class="table table-striped table-bordered table-condensed table-hover" style="background: white" id="myTable">
					<thead>
						<th><center>Fecha</center></th>
						<th><center>Nombre</center></th>
						<th><center>Dirección</center></th>
						<th><center>Descripción</center></th>
						<th><center>estado</center></th>
						<th><center>Referencia</center></th>
						<th><center>Celular</center></th>
						<th><center>Fecha desaparecido</center></th>
						<th><center>. . .</center></th>
						
					</thead>

					<tbody align="center" id="body_conductor">					
					@foreach($desaparecido as $con)
					<tr>
						<td>{{ $con->fecha}}</td>
						<td>{{ $con->nombre}} </td>
						<td>{{ $con->direccion}} </td>
						<td>{{ $con->descripcion}} </td>
						@if($con->estado==1)
						<td  >
							<button class="btn btn-danger">
								DESAPARECIDO
							</button>
						
						</td>
						@else
						<td > 
						<button class="btn btn-primary">
								ENCONTRADO
							</button>
						</td>
						@endif
					 
						<td>{{ $con->nombre_referencia_1}}</td>
						<td>{{ $con->celular_referencia_1}}</td>
						<td>{{ $con->fecha_desaparecido}}</td>
						 
						<td>
						 
						 
							<div class="btn-group">
	                            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
	                              Opción <span class="caret"></span>
	                            </button>
	                            <ul class="dropdown-menu" role="menu">
	                            	<li>
	                            		<a class=' fa fa-eye' href='desaparecido/{{$con->id}}/edit' aria-hidden="true"  data-toggle="tooltip" data-placement="top" title="Ver y editar">  Ver y editar</a>
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
