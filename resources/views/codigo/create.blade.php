@extends ('layouts.inicio')
@section ('contenido')
@include('alerts.success')


<div class="row">
	<?php
	$existe=0;

	?>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"  @if($existe==1) hidden="" @endif>
 <div class=" panel panel-success">
      	<div class="panel-heading"><label>Registrar una nueva configuración del año </label><font size="6" ><b><?php $anio=date('Y'); echo "  ".$anio;?></b></font></div>
      	<div class="panel-body">

 <div class="table-responsive" style="overflow-x:inherit">	
	 
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    	    @include('alerts.request')
	
<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
{!!Form::open(['route'=>'codigo.store', 'method'=>'POST'])!!}	
			
<input type="hidden" name="id_empresa" id="id_empresa" value="{{Auth::user()->id_empresa}}">  
	


		<div class="form-group" >
		Monto:
		{!!Form::number('monto','13',['class'=>'form-control','maxlength'=>'5'])!!}
	</div>	
	<div class="form-group"  >
		Fecha inicial:
		{!!Form::text('fecha_inicio',50,['class'=>'form-control','maxlength'=>'10'])!!}
	</div>

	<div class="form-group"  >
		Fecha final:
		{!!Form::text('fecha_fin',50,['class'=>'form-control','maxlength'=>'10'])!!}
	</div>

	<div class="form-group"  >
	{!!Form::submit('REGISTRAR',['class'=>'btn btn-primary','id'=>'btn_registrar','onclick'=>'btn_esconder()'])!!}
		 </div>

	</form>	

	</div>
 




</div>
</div>
</div>
</div>	


</div>
</div>
   
   
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
 
			
	<div class=" panel panel-primary">
      	<div class="panel-heading"><label>Historial de configuraciones </label> </div>
      	<div class="panel-body">
		<div class="table-responsive" style="overflow-x:inherit">	

				<table class="table table-striped table-bordered table-condensed table-hover" style="background: white">
					
					<thead>
						<th><center>AÑO</center></th>
						<th><center>Frecuencia por dia</center></th>
						<th><center>Cantidad de tolerancia</center></th>
						<th><center>Retraso por día</center></th>
						<th><center>Pro accidente</center></th>
						<th><center>Nro recibos(pago frecuencia)</center></th>
						<th><center>. . .</center></th>
					</thead>
					
					<tbody>
						@foreach($ajuste as $mot)
					<tr align="center">
						<td>{{ $mot->anio}}</td>
						<td>{{ $mot->frecuencia_dia}} Bs</td>
						<td>{{ $mot->cantidad_tolerancia_cobro}} días</td>
						<td>{{ $mot->retraso_dia}} Bs</td>
						<td>{{ $mot->pro_accidente}} Bs</td>
						<td>{{ $mot->numero_inicio_recibo}} - {{$mot->numero_fin_recibo}}</td>
						<td>
						<a href="{{$mot->anio}}/edit"><i class="fa fa-pencil-square-o btn btn-link" aria-hidden="true"></i></a>
					
						</td>
					</tr>
					@endforeach
					</tbody>
						
				</table>

	
			</div>
	</div>
	</div>
	</div>
 
 
 
	@endsection