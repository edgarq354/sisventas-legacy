@extends ('layouts.inicio')
@section ('contenido')
@include('alerts.success')
@include('alerts.request')
@include('alerts.errors')
	

        
	<div class="row">	
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="table-responsive" style="overflow-x:inherit">	
		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
			<font size="6">PASAJEROS CON MAS CANCELACIÓN</font> 
		</div>
 
        
       
	    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      {{Form::open(array('url' => 'pasajero_con_mas_cancelacion','onKeypress'=>'if(event.keyCode == 13) event.returnValue = false;'))}} 
     
        @foreach($fechas as $fecha)
            <b>Fecha Inicio:</b> <input type="date" name="fecha_inicio" id="fecha_inicio" value="{{$fecha->fecha_inicio}}">
            <b>Fecha Fin:</b> <input type="date" name="fecha_fin"  id="fecha_fin" value="{{$fecha->fecha_fin}}"> 
        @endforeach
       
            <button class=" form-group btn-sm btn-primary" ><i class="fa fa-search"></i></button>         
             
          </form>     
            
         
          </div>	

<div class="panel-body">
				<table class="table table-striped table-bordered table-condensed table-hover" style="background: white" id="myTable">
					<thead>
						<th><center>Perfil</center></th>
						<th><center>Nombre</center></th>
						<th><center>Celular</center></th>
						<th><center>Correo</center></th>
						<th><center>Fecha de registro</center></th>
						<th><center>Cantidad de cancelado por el conductor</center></th>
						<th><center>Cantidad de cancelado por el pasajero</center></th>
						
					</thead>

					<tbody align="center" >					
					@foreach($pasajero as $usr)
					<tr>
						<td> <img src="../../taxivalle2/{{$usr->direccion_imagen}}" width="90px" height="90px" title="PERFIL" class="img-thumbnail"></td>
						<td>{{ $usr->nombre}} {{ $usr->apellido}}</td>
						<td>{{ $usr->celular}}</td>
						<td>{{ $usr->correo}}</td>
						<td>{{ $usr->fecha_registro}}</td>
						<td>{{ $usr->cantidad_conductor}}</td>	
						<td>{{ $usr->cantidad_pasajero}}</td>	
					</tr>
					@endforeach
					</tbody>

										
				</table>
				</div>

			</div>
		</div>
	</div>

 
@endsection
