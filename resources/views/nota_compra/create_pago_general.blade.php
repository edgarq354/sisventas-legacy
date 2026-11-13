@extends ('layouts.inicio')
@section ('contenido')
@include('alerts.success')

<div class="row">
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

			<div class="table-responsive" style="overflow-x:inherit">	
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<font size="6">REGISTRAR PAGO DE FRECUENCIA GENERAL</font><br>
			<font size="2">Los Frecuencias seleccionadas para registrar  los pagos seran registrador para todos los conductores de la empresa</font>
		</div>

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
<hr>
	<a class='btn btn-success' href="{!!URL::to('pago_frecuencia/create_pago_general','DIA')!!}">FRECUENCIAS POR DIA</a>
	<a class='btn btn-success' href="{!!URL::to('pago_frecuencia/create_pago_general','SEMANA')!!}">FRECUENCIAS POR SEMANA</a>
	<a class='btn btn-success' href="{!!URL::to('pago_frecuencia/create_pago_general','MES')!!}">FRECUENCIAS POR MES</a>
	<hr>
	</div>

<input type="hidden" name="id_empresa" id="id_empresa" value="{{Auth::user()->id_empresa}}">  

    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

    	    @include('alerts.request')


<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">

{!!Form::open(['action' => 'Pago_frecuenciaController@store_pago_general'])!!}	

<input type="hidden" name="tipo" id="tipo" value="{{$tipo}}">  

		 @foreach($sumatoria as $sum)	
		<div class="form-group" >
		{!!Form::label('monto_frecuencia_1','Monto Frecuencia:')!!}
		{!!Form::text('monto_frecuencia',$sum->monto,['class'=>'form-control','placeholder'=>'Monto Frecuencia','maxlength'=>'10','id'=>'monto_frecuencia','onkeyup'=>'monto_total_frecuencia()','onBlur'=>'monto_total_frecuencia()','monto_total_frecuencia()'])!!}
		</div>	
		@endforeach

	@foreach($ajuste as $ajuste)
	<div class="form-group" >
		{!!Form::label('monto_retraso','Monto Retraso:')!!}
		{!!Form::text('monto_retraso',$ajuste->retraso_dia,['class'=>'form-control','placeholder'=>'Monto Retraso','maxlength'=>'10','onkeyup'=>'monto_total_frecuencia()','onBlur'=>'monto_total_frecuencia()'])!!}
	</div>	
	<div class="form-group" >
		{!!Form::label('pro_navidad','Pro Navidad:')!!}
		{!!Form::text('pro_navidad',$ajuste->pro_navidad,['class'=>'form-control','placeholder'=>'Pro Navidad','maxlength'=>'10','onkeyup'=>'monto_total_frecuencia()','onBlur'=>'monto_total_frecuencia()'])!!}
	</div>
	<div class="form-group" >
		{!!Form::label('pro_accidente','Pro Accidente:')!!}
		{!!Form::text('pro_accidente',$ajuste->pro_accidente,['class'=>'form-control','placeholder'=>'Pro Accidente','maxlength'=>'10','onkeyup'=>'monto_total_frecuencia()','onBlur'=>'monto_total_frecuencia()'])!!}
	</div>	
	<div class="form-group" >
		{!!Form::label('ahorro','Ahorro:')!!}
		{!!Form::text('ahorro',$ajuste->ahorro,['class'=>'form-control','placeholder'=>'Ahorro','maxlength'=>'10','onkeyup'=>'monto_total_frecuencia()','onBlur'=>'monto_total_frecuencia()'])!!}
	</div>	
    @endforeach
    <div class="form-group">
		{!!Form::label('obsercaciones','Observaciones:')!!}
		{!!Form::text('observaciones','',['class'=>'form-control','placeholder'=>'Observaciones'])!!}
	</div>
	<div class="form-group">
        {!!Form::select('permiso', array('0' => 'SIN PERMISO', '1' => 'CON PERMISO'),null,array('id'=>'permiso','class'=>'form-control'))!!}	
	</div>
	<div class="form-group" >
	@foreach($sumatoria as $sum)
		{!!Form::label('monto_total','Monto Total:')!!}
		{!!Form::text('monto_total',$sum->monto,['class'=>'form-control','placeholder'=>'Monto Total','maxlength'=>'10'])!!}
	@endforeach	
	</div>	
	
	<input type="hidden" name="id_empresa" id="id_empresa" value="{{Auth::user()->id_empresa}}">  


	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">		
		<div align="right">
			{!!Form::submit('PAGAR',['class'=>'btn btn-primary','id'=>'btn_registrar','onclick'=>'btn_esconder()'])!!}
			<a href="{!!URL::to('pago_frecuencia')!!}" class="btn btn-danger">CANCELAR</a>
			<?php //{!!Form::reset('CANCELAR',['class'=>'btn btn-danger'])!!} ?>
		</div>
	</div>


</div>	


		<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
			<font size="4">Frecuencias a Cancelar</font><br>

		
			<table class="table table-striped table-bordered table-condensed table-hover" style="background: white">
					<thead>
						<th><center>FECHA INICIO</center></th>
						<th><center>FECHA FIN</center></th>
						<th><center>NUMERO</center></th>
						<th><center>MONTO</center></th>
						<th><center>TIPO</center></th>
						<th><center>SELECCIONAR</center></th>
					</thead>
					<tbody align="center" id="body_moto">					
					@foreach($frecuencia as $deuda)
					<tr>
						<td>{{ $deuda->fecha_inicio}}</td>
						<td>{{ $deuda->fecha_fin}}</td>
						<td>{{ $deuda->numero}}</td>
						<td>{{ $deuda->monto}}</td>
						<td>{{ $deuda->tipo}}</td>
						<td><input type="checkbox"  checked="true" onclick="sumar_frecuencia(this,{{$deuda->monto}});monto_total_frecuencia();" value="1" id="{{$deuda->id}}" name="{{$deuda->id}}"></td>
					</tr>
					@endforeach
					</tbody>
			</table>

		</div>
	






	</div>
    

	</form>
	
   {!!Html::script('js/pago_frecuencia_crear.js')!!}	
</div>
 
	@endsection