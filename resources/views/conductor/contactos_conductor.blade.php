@extends ('layouts.inicio')
@section ('contenido')
@include('alerts.success')
@include('alerts.request')
@include('alerts.errors') 
	

        
	<div class="row">	
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="table-responsive" style="overflow-x:inherit">	
		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
			<font size="6">CONTACTOS</font>
		</div>
 
        
<div class="panel-body">
				<table class="table table-striped table-bordered table-condensed table-hover" style="background: white" id="myTable">
					<thead>
						<th><center>Id</center></th>
						<th><center>Nombre</center></th>
						<th><center>Telefono</center></th>
						
					</thead>

					<tbody align="center" >					
					@foreach($contactos as $con)
					<tr>
						<td>{{ $con->id}} </td>
						<td>{{$con->nombre}}</td>
						<td>{{ $con->numero}} </td>
					</tr>
					@endforeach
					</tbody>
 				
				</table>
				</div>

			</div>
		</div>
	</div>
 
@endsection
