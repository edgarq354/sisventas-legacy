@extends ('layouts.inicio')
@section ('contenido')
@include('alerts.success')

<div class="row">


<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="table-responsive" style="overflow-x:inherit">	
		<div class="col-lg-6 col-md-8 col-sm-6 col-xs-12">
			<font size="6">DETALLE PAGO DE FRECUENCIA</font><br>
			
		</div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

    	    @include('alerts.request')
	
<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
@foreach($pago_frecuencia as $pago)
<div class='form-group'>
   <font size="5" ><b>{!!Form::label('Nro:'.$pago->id,null)!!}</b></font><br>
   <font size="4" ><b>{!!Form::label('Nombre:'.$pago->nombre,null)!!}</b></font><br>
   <font size="3" ><b>{!!Form::label('C.I.:'.$pago->ci,null)!!}</b></font>
   </div>
	


			
		<div class="form-group" >
		{!!Form::label('monto_frecuencia_1','Monto Frecuencia:')!!}
		{!!Form::text('monto_frecuencia',$pago->monto_frecuencia,['class'=>'form-control','placeholder'=>'Monto Frecuencia','maxlength'=>'10','id'=>'monto_frecuencia','onkeyup'=>'monto_total_frecuencia()','onchange'=>'monto_total_frecuencia()'])!!}
	</div>	
	<div class="form-group" >
		{!!Form::label('monto_retraso','Monto Retraso:')!!}
		{!!Form::text('monto_retraso',$pago->monto_retraso,['class'=>'form-control','placeholder'=>'Monto Retraso','maxlength'=>'10','onkeyup'=>'monto_total_frecuencia()'])!!}
	</div>	
	<div class="form-group"  hidden="">
		{!!Form::label('pro_navidad','Pro Navidad:')!!}
		{!!Form::text('pro_navidad',$pago->pro_navidad,['class'=>'form-control','placeholder'=>'Pro Navidad','maxlength'=>'10','onkeyup'=>'monto_total_frecuencia()'])!!}
	</div>
	<div class="form-group" hidden="" >
		{!!Form::label('pro_accidente','Pro Accidente:')!!}
		{!!Form::text('pro_accidente',$pago->pro_accidente,['class'=>'form-control','placeholder'=>'Pro Accidente','maxlength'=>'10','onkeyup'=>'monto_total_frecuencia()'])!!}
	</div>	
	<div class="form-group" >
		{!!Form::label('ahorro','Ahorro:')!!}
		{!!Form::text('ahorro',$pago->ahorro,['class'=>'form-control','placeholder'=>'Ahorro','maxlength'=>'10','onkeyup'=>'monto_total_frecuencia()'])!!}
	</div>	
	<div class="form-group" >
		{!!Form::label('monto_total','Monto Total:')!!}
		{!!Form::text('monto_total',$pago->monto_total,['class'=>'form-control','placeholder'=>'Monto Total','maxlength'=>'10'])!!}
	</div>	
	<div class="form-group" >
		{!!Form::label('obsercaciones','Observaciones:')!!}
		{!!Form::textarea('observaciones',$pago->observaciones,['class'=>'form-control','placeholder'=>'Observaciones'])!!}
	</div>
	<div class="form-group">
        {!!Form::select('permiso', array('0' => 'SIN PERMISO', '1' => 'CON PERMISO'),$pago->permiso,array('id'=>'permiso','class'=>'form-control'))!!}	
	</div>
	
@endforeach
</div>	


		<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
			<font size="4">FRECUENCIAS CANCELADAS</font><br>

		
			<table class="table table-striped table-bordered table-condensed table-hover" style="background: white" id="myTable">
					<thead>
						<th><center>FECHA INICIO</center></th>
						<th><center>FECHA FIN</center></th>
						<th><center>NUMERO</center></th>
						<th><center>TIPO</center></th>
						<th><center>MONTO</center></th>
					</thead>
					<tbody align="center" id="body_moto">					
					@foreach($frecuencia as $deuda)
					<tr>
						<td>{{ $deuda->fecha_inicio}}</td>
						<td>{{ $deuda->fecha_fin}}</td>
						<td>{{ $deuda->numero}}</td>
						<td>{{ $deuda->tipo}}</td>
						<td>{{ $deuda->monto}}</td>
						
						
					</tr>
					@endforeach
					</tbody>
			</table>

		</div>
	






	</div>
    


	
   
</div>
 
	@endsection