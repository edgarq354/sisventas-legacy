@extends ('layouts.inicio')
@section ('contenido')
@include('alerts.success')
@include('alerts.request')
@include('alerts.errors')
	

        
	<div class="row">	
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="table-responsive" style="overflow-x:inherit">	
		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
			<font size="6">CONDUCTOR CON MAS CANCELACIÓN</font> 
		</div>
 
        
       
	    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      {{Form::open(array('url' => 'conductor_con_mas_cancelacion','onKeypress'=>'if(event.keyCode == 13) event.returnValue = false;'))}} 
     
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
						<th><center>C.i.</center></th>
						<th><center># Movil</center></th>
						<th><center>Conductor</center></th>
						<th><center>Licencia de C.</center></th>
						<th><center>Celular</center></th>
						<th><center>Credito</center></th>
						<th><center>Cantidad de cancelado por el conductor</center></th>
						<th><center>Cantidad de cancelado por el pasajero</center></th>
						
					</thead>

					<tbody align="center" id="body_conductor">					
					@foreach($conductor as $con)
					<tr>
						<td>{{ $con->ci}} {{ $con->expedido}}</td>
						<td>
						 
						<b>{{ $con->numero_movil}}</b>
						 
						</td>
						<td>{{ $con->nombre}} {{ $con->paterno}} {{ $con->materno}}</td>
						<td>{{ $con->categoria_licencia}}</td>
						<td>{{ $con->celular}}</td>
						<td>{{ $con->credito}}</td>	
						<td>{{ $con->cantidad_conductor}}</td>	
						<td>{{ $con->cantidad_pasajero}}</td>	
						 
						 
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
