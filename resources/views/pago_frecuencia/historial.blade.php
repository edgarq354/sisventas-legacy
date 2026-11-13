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

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
  <img src="../../{{$conductor[0]->direccion_imagen}}" style='width: 100px; height: 100px; border-radius: 5px;' alt='img.png'>
</div>
<div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
	<font size='4'> <b>Número de movil:</b> {{$conductor[0]->numero_movil}}</font> <br>  
	<font size='4'> <b> Nombre:</b>{{$conductor[0]->nombre}} {{$conductor[0]->paterno}} {{$conductor[0]->materno}}</font><br>
	<font size='4'> <b>C.I:</b> {{$conductor[0]->ci}}</font> <br>  
	<a class='btn btn-primary fa fa-print ' target="_blank" href="{!!URL::to('pago_frecuencia/historial_conductor_pdf',$conductor[0]->ci)!!} " > Imprimir</a>
	<a class='btn btn-primary fa fa-user'  href="{!!URL::to('conductors',$conductor[0]->ci)!!} " data-toggle="tooltip" data-placement="top" title="Ver el perfil"> </a>
</div>

		<div clasrs="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="table-responsive" style="overflow-x:inherit">	
		<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
			<font size="6">HISTORIAL DE PAGO</font>
		</div>

 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 well">
<?php 
$cant_pagado=0;
$cant_permiso=0;
$cant_deuda=0;
$sum_deuda=0;
$sum_pagado=0;
$sum_permiso=0;
?>
<table class="table table-striped table-bordered table-condensed table-hover" style="background: white" id="myTable">
					
					<thead>
						<tr>
						<th><center>Nro</center></th>
						<th><center># de Movil</center></th>
						<th><center>Nro / Tipo</center></th>
						<th><center>Fecha</center></th>
						<th><center>Monto</center></th>
						<th><center>Tipo</center></th>
						<th><center>Usuario</center></th>
						<th><center>Fecha</center></th>
						</tr>
					</thead>
					
					 <tbody >
						@foreach($pago_frecuencia as $pago)
					
					@if($pago->permiso==0)
						<tr class="bg-green">
						<td><center>{{ $pago->nro_pago}}</center></td>
						<td><center>{{ $conductor[0]->numero_movil}}</center></td>
						<td><center><b>{{ $pago->numero}} - {{$pago->tipo}}</b></center></td>
						<td><center>{{ $pago->fecha_fin}}</center></td>
						<td><center><b>{{ $pago->monto}}</b></center></td>
						<td  ><center>PAGADO</center></td>
						<td  ><center><b>{{ $pago->nombre}}</b></center></td>
						<td><center><b>{{$pago->fecha}}</b></center></td>
						</tr>
						<?php 
						$cant_pagado+=1;
						$sum_pagado+=$pago->monto;
						?>
					@elseif($pago->permiso==1)
						<tr class="bg-yellow">
						<td><center>-</center></td>
						<td><center>{{ $conductor[0]->numero_movil}}</center></td>
						<td><center><b>{{ $pago->numero}} - {{$pago->tipo}}</b></center></td>
						<td><center>{{ $pago->fecha_fin}}</center></td>
						<td><center>{{ $pago->monto}}</center></td>
						<td  ><center>PERMISO</center></td>
						<td  ><center><b>{{ $pago->nombre}}</b></center></td>
						<td><center><b>{{$pago->fecha}}</b></center></td>
						</tr>
						
						<?php 
						$sum_permiso+=$pago->monto;
						$cant_permiso+=1;
						?>
					
					@elseif($pago->permiso==-1)
						<tr class=" bg-red">
						<td><center>-</center></td>
						<td><center>{{ $conductor[0]->numero_movil}}</center></td>
						<td><center><b>{{ $pago->numero}} - {{$pago->tipo}}</b></center></td>
						<td><center>{{ $pago->fecha_fin}}</center></td>
						<td><center>{{ $pago->monto}}</center></td>
						<td ><center>DEUDA</center></td>
						<td ><center>-</center></td>
						<td ><center>-</center></td>
						</tr>
						<?php 
						$cant_deuda+=1;
						$sum_deuda+=$pago->monto;
						?>
					@endif
						
					@endforeach
					</tbody>
				
						
				</table>

<table class="table table-striped table-bordered table-condensed table-hover " style="width:250px;">
	<thead style="background-color: #F8B712;">
		<th>Detalle</th>
		<th>Cantidad</th>
		<th>Monto</th>
	</thead>
	<tbody>
		<tr >
			<td>Pagado</td>
			<td>{{$cant_pagado}}</td>
			<td>{{$sum_pagado}} Bs</td>
		</tr>
		<tr>
			<td>Permiso</td>
			<td>{{$cant_permiso}}</td>
			<td>{{$sum_permiso}} Bs.</td>
		</tr>
		<tr>
			<td>Deuda</td>
			<td>{{$cant_deuda}}</td>
			<td>{{$sum_deuda}} Bs.</td>
		</tr>
		
	</tbody>
</table >

</div>		

<!--
 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 well">

    	   



					@foreach($pago_frecuencia as $pago)
					@if($pago->permiso==0)
					<div class="searchable-container col-lg-2 col-md-2 col-sm-2 col-xs-12 btn btn-success"  style=" margin:0px 0px 0px 0px;  padding: 0px 0px 0px 0px; width: 170px; height: 200px;" data-toggle="buttons">
					  					<h2><b>{{$pago->numero}}</b></h2>
	                                    <h3><b>{{ $pago->id_pago}}</b> - {{ $pago->monto}}Bs</h3>
	                                    <h4>{{ $pago->fecha}}</h4>
	                                    <p>Inicio:{{ $pago->fecha_inicio}}<br>Fin:{{ $pago->fecha_fin}}</p>
					
					@elseif($pago->permiso==1)
					<div class="searchable-container col-lg-2 col-md-2 col-sm-2 col-xs-12 btn btn-warning"  style=" margin:0px 0px 0px 0px;  padding: 0px 0px 0px 0px; width: 170px; height: 200px;" data-toggle="buttons">

					<h2><b>{{$pago->numero}}</b></h2><br>
					<h4 style=" transform:rotate(-45deg); align-content: center;">
					<br>
					{{ $pago->fecha_inicio}}-{{ $pago->fecha_fin}}
					<br><b>PERMISO</b></h4>

					
					@elseif($pago->permiso==-1)
					<div class="searchable-container col-lg-2 col-md-2 col-sm-2 col-xs-12 btn btn-danger"  style=" margin:0px 0px 0px 0px;  padding: 0px 0px 0px 0px; width: 170px; height: 200px;" data-toggle="buttons">

					<h2><b>{{$pago->numero}}</b></h2><br>
					<h4 style=" transform:rotate(-45deg); align-content: center;">
					{{ $pago->fecha_inicio}}-{{ $pago->monto}}Bs
					<br><b>DEUDA</b></h4>
					
					@endif
	                       
	                                  
	                            
	                </div>

					@endforeach

	</div>
-->
<!--		
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">


			
		</div>
    

				<table class="table table-striped table-bordered table-condensed table-hover" style="background: white">
					
					<thead>
						<th><center>Nro Pago</center></th>
						<th><center>Nro</center></th>
						<th><center>FECHA INICIO</center></th>
						<th><center>FECHA FIN</center></th>
						<th><center>MONTO</center></th>
						<th><center>TIPO</center></th>
					</thead>
					
						<tbody>
						@foreach($pago_frecuencia as $pago)
					<tr>
						<td><center>{{ $pago->id_pago}}</center></td>
						<td><center>{{ $pago->numero}}</center></td>
						<td><center>{{ $pago->fecha_inicio}}</center></td>
						<td><center>{{ $pago->fecha_fin}}</center></td>
						<td><center>{{ $pago->monto}}</center></td>
						<?php 
						if($pago->permiso==1)
						{
							echo "<td style='width:100%;' class='btn btn-warning'>CON PERMISO</td>";
						}else
						{
							echo "<td style='width:100%;' class='btn btn-success'>PAGADO</td>";
						}
						?>
						
					</tr>
					@endforeach
					</tbody>
				
						
				</table>
-->
	
	<div class="pull-right">	<button class="btn btn-default" id="mostrar"><b>VER TODOS</b></button>  </div>
			</div>


		</div>
	</div>


 
@endsection

