@extends ('layouts.inicio')
@section ('contenido')
@include('alerts.success')
@include('alerts.request')
@include('alerts.errors')

	<div class="row">	
		<div clasrs="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="table-responsive" style="overflow-x:inherit">	
		<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
			<font size="6">CONDUCTORES DEUDORES</font>
		</div>

		
<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">


			
		</div>
    

				<table class="table table-striped table-bordered table-condensed table-hover" style="background: white" id="myTable">
					
					<thead>
						<th><center></center></th>
						<th><center>CODIGO MOVIL</center></th>
						<th><center>CI</center></th>
						<th><center>NOMBRE</center></th>
						<th><center>TELEFONO</center></th>

					</thead>
					
						<tbody>
						@foreach($deudores as $conductor)
					<tr>
						<td><img src="../../{{$conductor->direccion_imagen}}" style="width: 50px; height: 50px; border-radius: 5px;" alt="img.png"></td>
						<td><center>{{ $conductor->codigo_empresa}}</center></td>
						<td><center>{{ $conductor->ci}}</center></td>
						<td>{{ $conductor->nombre}} {{$conductor->paterno}} {{$conductor->materno}}</td>
						<td>{{ $conductor->celular}}</td>
						<td>
						{!!Form::open(['route'=>'pago_frecuencia.create', 'method'=>'GET'])!!}	
							<input type="hidden" name="ci" id="ci" value="{{$conductor->ci}}">  
		     				 {!!Form::submit('PAGAR',['class'=>'btn btn-primary','id'=>'btn_buscar','onclick'=>'btn_esconder()'])!!}
		     			</form>
						</td>
					</tr>
					@endforeach
					</tbody>
				
						
				</table>

	
	<div class="pull-right">	<button class="btn btn-default" id="mostrar"><b>VER TODOS</b></button>  </div>
			</div>


		</div>
	</div>


 
@endsection

