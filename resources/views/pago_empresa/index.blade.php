@extends ('layouts.inicio')
@section ('contenido')
@include('alerts.success')
@include('alerts.request')
@include('alerts.errors')

<?php
$message=Session::get('message');
?>

@if($message=='store')
<div class="alert alert-success alert-dismissible" role="alert">
<button type="button" class="close" data-dismiss="alert" arial-label="Close"><span aria-hidden="true">$times;</span></button>
	Pago registrado con Exito.
</div>
@endif
	<div class="row">	
		<div clasrs="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="table-responsive" style="overflow-x:inherit">	
		<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
			<font size="6">CUOTAS DE LAS EMPRESAS</font>
		</div>

		
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

{!!Form::open(['route'=>'pago_empresa.index', 'method'=>'GET'])!!}	
		<div class="form-group  col-lg-3 col-md-3 col-sm-3 col-xs-12"  >
		<div class='input-group date' id='datetimepicker11' data-toggle="tooltip" data-placement="top" title="Fecha de inicio">
		  {!!Form::text('fecha_inicio',date('Y-m-j'),['id'=>'fecha_inicio','class'=>'form-control','maxlength'=>'10','onkeypress'=>'return bloqueo_de_punto(event)','style'=>'font-size:20px;text-align:left'])!!}		
		  <span class="input-group-addon ">
		     <span class="fa fa-calendar" aria-hidden="true"></span> 
		  </span>
		</div>
		</div>
		<div class=" col-lg-1 col-md-1 col-sm-1 col-xs-12"  >
		 <font ><b>Entre</b></font> 
		</div>
			<div class="form-group  col-lg-3 col-md-3 col-sm-3 col-xs-12" >
        <div class='input-group date' id='datetimepicker10' data-toggle="tooltip" data-placement="top" title="Fecha fin">

		  {!!Form::text('fecha_fin',date('Y-m-j'),['class'=>'form-control','maxlength'=>'10','style'=>'font-size:20px;text-align:left;'])!!}        
          <span class="input-group-addon ">
             <span class="fa fa-calendar" aria-hidden="true"></span>  <!--span class="glyphicon glyphicon-calendar"></span-->
          </span>
        </div>
        </div>

        
		<div class=" form-group col-lg-4 col-md-4 col-sm-4 col-xs-12 " >		
		<button class="btn-sm btn-primary" id="btn_buscar" name='btn_buscar'onclick="btn_esconder()"  data-toggle="tooltip" data-placement="top" title="Buscar"><i class="fa fa-search"  ></i></button> 
		</div>

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<hr>
	<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12" data-toggle="tooltip" data-placement="top" title="Registrar un nuevo cobro">
	<div class="panel rounded shadow btn btn-success">
			<div class="panel-bodys">
				<ul class="inner-all list-unstyled">
					<li class="text-center">
						<a href="{!!URL::to('pago_empresa/create')!!}" >
						 <img src="images/registrar.png"  style="max-width: 100px; max-height: 100px;" >
						 </a>
					</li>
					<li class="text-center"> 
						<h4 class="text-capitalize">Registrar nuevo</h4>
					</li>
				</ul>
			</div>
		</div>
	</div>



	<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12" data-toggle="tooltip" data-placement="top" title="Lista de conductores con deuda">
		<div class="panel rounded shadow btn btn-primary">
			<div class="panel-bodys">
				<ul class="inner-all list-unstyled">
					<li class="text-center">
						<a  href="{!!URL::to('pago_empresa/buscar_pagos_realizados',1)!!}">
						 <img src="images/historial4.png"  style="max-width: 100px; max-height: 100px;" >
						 </a>
					</li>
					<li class="text-center"> 
						<h4 class="text-capitalize">Lista de Cond.<br>sin deuda</h4>
					</li>
				</ul>
			</div>
		</div>
	</div>


	<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12" data-toggle="tooltip" data-placement="top" title="Lista de conductores con deuda">
		<div class="panel rounded shadow btn btn-danger">
			<div class="panel-bodys">
				<ul class="inner-all list-unstyled">
					<li class="text-center">
						<a  href="{!!URL::to('pago_empresa/buscar_deudores',1)!!}">
						 <img src="images/historial4.png"  style="max-width: 100px; max-height: 100px;" >
						 </a>
					</li>
					<li class="text-center"> 
						<h4 class="text-capitalize">Lista de deudores</h4>
					</li>
				</ul>
			</div>
		</div>
	</div>


<div hidden="">
		<a class="btn btn-success fa fa-dollar"  > REGISTRAR</a> 
		<a class='btn btn-success fa fa-list'  href="{!!URL::to('pago_empresa/deudores',1)!!}"> DEUDORES</a>
		<a class='btn btn-success fa fa-print'  target="_blanck">DEUDORES DE LA ULTIMA FRECUENCIA</a>
		<a class='btn btn-success fa fa-money'  href="{!!URL::to('pago_empresa/create_pago_general','DIA')!!}"> PAGOS GENERALES</a>
	</div>
		
</div>		

		

</form>

		

		</div>
    

				<table class="table table-striped table-bordered table-condensed table-hover" style="background: white">
					
					<thead>
						<th><center>Nro Pago</center></th>
						<th><center># Movil</center></th>
						<th><center>Perfil</center></th>
						<th><center>Fecha</center></th>
						<th><center>C/E</center></th>
						<th><center>Conductor</center></th>
						<th><center>M. por Frecuencia</center></th>
						
						<th><center>Total</center></th>
						<th><center>Opciones</center></th>
					</thead>
					
						<tbody>
						@foreach($pago_empresa as $pago)
						<?php if($pago->permiso==0) { ?>
					<tr>
						<td>{{ $pago->nro}}</td>
						<td>{{ $pago->numero}}</td>
						<td><img src="{{$pago->direccion_imagen}}" width="90px" height="90px"  class="img-thumbnail"></td>
						<td>{{ $pago->fecha}}</td>
						<td>{{ $pago->codigo_empresa}}</td>
						<td>{{ $pago->nombre_conductor}}</td>
						<td>{{ $pago->monto_frecuencia}}</td>
						<td>{{ $pago->monto_total}}</td>
						<td>
						<a class="btn btn-success fa fa-eye" href="{{url('pago_empresa/detalle',[$pago->nro,$pago->placa])}}"  data-toggle="tooltip" data-placement="top" title="Ver"></a> 
						
						<a class='btn btn-warning fa fa-print' href="{!!URL::to('pago_empresa/pago_pdf',[$pago->nro,$pago->placa])!!}" data-toggle="tooltip" data-placement="top" title="Imprimir" target="_blanck"></a>
						</td>
					</tr>
					<?php } ?>
					@endforeach
					</tbody>
				
						
				</table>

	
	<div class="pull-right">	<button class="btn btn-default" id="mostrar"><b>VER TODOS</b></button>  </div>
			</div>


		</div>
	</div>


 
@endsection

