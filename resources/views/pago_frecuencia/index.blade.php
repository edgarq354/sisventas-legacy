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
			<font size="6">PAGOS POR FRECUENCIAS</font>
		</div>

		
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

{!!Form::open(['route'=>'pago_frecuencia.index', 'method'=>'GET'])!!}	
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
 	<a href="{!!URL::to('pago_frecuencia/create')!!}" >
        <div class="col-lg-2 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
            <img src="images/registrar.png" style="max-width:50px;">
            </div>
            <div class="icon">
               <i class="fa fa-money"></i>
            </div>
          <p class="small-box-footer"> Registrar</p>
          </div>
        </div>
        </a>

      

	<a  href="{!!URL::to('pago_frecuencia/buscar_pagos_realizados',1)!!}">
        <div class="col-lg-2 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-blue">
            <div class="inner">
            <img src="images/17.png" style="max-width:50px;">
            </div>
            <div class="icon">
              <i class=" fa fa-thumbs-o-up" ></i>
            </div>
          <p class="small-box-footer"> Sin deuda</p>
          </div>
        </div>
        </a>

	<a  href="{!!URL::to('pago_frecuencia/buscar_deudores',1)!!}">
        <div class="col-lg-2 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
             <img src="images/36.png" style="max-width:50px;">
            </div>
            <div class="icon">
              <i class="fa fa-meh-o"></i>
            </div>
          <p class="small-box-footer"> Deudores</p>
          </div>
        </div>
        </a>

  </div>




<div hidden="">
		<a class="btn btn-success fa fa-dollar"  > REGISTRAR</a> 
		<a class='btn btn-success fa fa-list'  href="{!!URL::to('pago_frecuencia/deudores',1)!!}"> DEUDORES</a>
		<a class='btn btn-success fa fa-print'  target="_blanck">DEUDORES DE LA ULTIMA FRECUENCIA</a>
		<a class='btn btn-success fa fa-money'  href="{!!URL::to('pago_frecuencia/create_pago_general','DIA')!!}"> PAGOS GENERALES</a>
	</div>
		
	

		

</form>

		

		</div>
    
<div class="panel-body">
				<table class="table table-striped table-bordered table-condensed table-hover" style="background: white" id="myTable" align="center">
					
					<thead>
						<th><center>Nro Pago</center></th>
						<th><center># Movil</center></th>
						<th><center>Fecha</center></th>
						<th><center>Conductor</center></th>
						<th><center>M. por Frecuencia</center></th>
						<th><center>Ahorro</center></th>
						<th><center>Retraso</center></th>
						<th><center>Observaciones</center></th>
						<th><center>Total</center></th>
						<th><center>usuario</center></th>
						<th><center>. . .</center></th>
					</thead>
					
						<tbody>
						@foreach($pago_frecuencia as $pago)
						<?php if($pago->permiso==0) { ?>
					<tr>
						<td>{{ $pago->numero}}</td>
						<td>{{ $pago->numero_movil}}</td>
						<td>{{ $pago->fecha}}</td> 
						<td>{{ $pago->nombre_conductor}}</td>
						<td>{{ $pago->monto_frecuencia}} Bs</td>
						<td>{{ $pago->ahorro}} Bs</td>
						<td>{{ $pago->retraso}} Bs</td>
						<td>{{ $pago->observaciones}}</td>
						<td>{{ $pago->monto_total}} Bs</td>
						<td>{{ $pago->usuario}} </td>
						<td>
						<a class="btn btn-success fa fa-eye" href="{{url('pago_frecuencia/detalle',[$pago->nro,$pago->placa])}}"  data-toggle="tooltip" data-placement="top" title="Ver"></a> 
						
						<a class='btn btn-warning fa fa-print' href="{!!URL::to('pago_frecuencia/pago_pdf',[$pago->nro,$pago->placa])!!}" data-toggle="tooltip" data-placement="top" title="Imprimir" target="_blanck"></a>
						</td>
					</tr>
					<?php } ?>
					@endforeach
					</tbody>
				
						
				</table>
</div>
	
			</div>


		</div>
	</div>


 
@endsection

