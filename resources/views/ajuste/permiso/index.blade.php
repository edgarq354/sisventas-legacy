@extends ('layouts.inicio')
@section ('contenido')
@include('alerts.success')
@include('alerts.request')
@include('alerts.errors')

<?php
$message=Session::get('message');
?>
	<div class="row">	
		<div class="table-responsive" style="overflow-x:inherit">	
@if($message=='store')
<div class="alert alert-success alert-dismissible" role="alert">
<button type="button" class="close" data-dismiss="alert" arial-label="Close"><span aria-hidden="true">$times;</span></button>
	Pago registrado con Exito.
</div>
@endif

		 
			
		<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
			<font size="6">REGISTRO DE PERMISOS</font>
		</div>

		


        
		<div class=" form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">		
		 
		


		

		</div>
    

 


		</div>
</div>


 
	<div class="row">	
		<div clasrs="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="table-responsive" style="overflow-x:inherit">	
		 

		
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

{!!Form::open(['route'=>'gestionar_permiso.index', 'method'=>'GET'])!!}	
		<div class="form-group  col-lg-3 col-md-3 col-sm-3 col-xs-12" >
		<div class='input-group date' id='datetimepicker11'>
		  {!!Form::text('fecha_inicio',date('Y-m-j'),['id'=>'fecha_inicio','class'=>'form-control','maxlength'=>'10','onkeypress'=>'return bloqueo_de_punto(event)','style'=>'font-size:20px;text-align:left'])!!}		
		  <span class="input-group-addon ">
		     <span class="fa fa-calendar" aria-hidden="true"></span> 
		  </span>
		</div>
		</div>
		<div class=" col-lg-1 col-md-1 col-sm-1 col-xs-12" >
		 <font ><b>Entre</b></font> 
		</div>
			<div class="form-group  col-lg-3 col-md-3 col-sm-3 col-xs-12" >
        <div class='input-group date' id='datetimepicker10'>

		  {!!Form::text('fecha_fin',date('Y-m-j'),['class'=>'form-control','maxlength'=>'10','style'=>'font-size:20px;text-align:left;'])!!}        
          <span class="input-group-addon ">
             <span class="fa fa-calendar" aria-hidden="true"></span>  <!--span class="glyphicon glyphicon-calendar"></span-->
          </span>
        </div>
        </div>

        
		<div class=" form-group col-lg-4 col-md-4 col-sm-4 col-xs-12 " >		
		<button class="btn-sm btn-primary" id="btn_buscar" name='btn_buscar'onclick="btn_esconder()"  data-toggle="tooltip" data-placement="top" title="Buscar"><i class="fa fa-search"  ></i></button> 
		</div>


 



<div  >
		<a class="btn btn-success fa fa-dollar" href="{!!URL::to('gestionar_permiso/create')!!}"> Nuevo</a>
		
	</div>
		
	

		

</form>

		

		</div>
    
<div class="panel-body">
				<table class="table table-striped table-bordered table-condensed table-hover" style="background: white" id="myTable">
					
					<thead>
						<th><center>Nro Pago</center></th>
						<th><center>Fecha</center></th>
						<th><center>Codigo Interno</center></th>
						<th><center>Conductor</center></th>
						<th><center>Observación</center></th>
						<th><center>Monto total</center></th>
						<th><center>. . .</center></th>
					</thead>
					
						<tbody align="center">
						@foreach($pago_frecuencia as $pago)
					<tr>
						<td>{{ $pago->nro}}</td>
						<td>{{ $pago->fecha}}</td>
						<td>{{ $pago->codigo_empresa}}</td>
						<td>{{ $pago->nombre_conductor}}</td>
						<td>{{ $pago->observaciones}}</td>
						<td>{{ $pago->monto_total}}</td>
						<td class="btn btn-warning">CON PERMISO</td>
					</tr>
					@endforeach
					</tbody>
				
						
				</table>
</div>
	
			</div>


		</div>
	</div>


  

 
@endsection

