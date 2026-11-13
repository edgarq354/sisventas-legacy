@extends ('layouts.inicio')
@section ('contenido')
@include('alerts.success')

<div class="row">
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="table-responsive" style="overflow-x:inherit">	
		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
			<font size="6">ACTUALIZAR AJUSTE</font><br>
			@foreach($ajuste as $mot)
			<font size="6" ><b>{{$mot->anio}}</b></font>	
		
		</div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

    	    @include('alerts.request')

<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
		{!!Form::open(['route'=>['ajuste.update','null'],'method'=>'PUT','enctype'=>'multipart/form-data','onKeypress'=>'if(event.keyCode == 13) event.returnValue = false;'])!!}	
<input type="hidden" name="id_empresa" id="id_empresa" value="{{Auth::user()->id_empresa}}">  

		<div class="form-group" >
		{!!Form::label('frecuencia_dia','Frecuencia por día:')!!}
		{!!Form::text('frecuencia_dia',$mot->frecuencia_dia,['class'=>'form-control','placeholder'=>'Freccuencia por dia','maxlength'=>'10'])!!}
	</div>	
	<div class="form-group" >
		{!!Form::label('frecuencia_semana','Frecuencia por semana:')!!}
		{!!Form::text('frecuencia_semana',$mot->frecuencia_semana,['class'=>'form-control','placeholder'=>'Freccuencia por semana','maxlength'=>'10'])!!}
	</div>	
	<div class="form-group" >
		{!!Form::label('frecuencia_mes','Frecuencia por mes:')!!}
		{!!Form::text('frecuencia_mes',$mot->frecuencia_mes,['class'=>'form-control','placeholder'=>'Freccuencia por mes','maxlength'=>'10'])!!}
	</div>
	<div class="form-group" >
		{!!Form::label('retraso_dia','Retraso por día:')!!}
		{!!Form::text('retraso_dia',$mot->retraso_dia,['class'=>'form-control','placeholder'=>'Retraso por día','maxlength'=>'10'])!!}
	</div>	
	<div class="form-group" >
		{!!Form::label('pro_navidad','Pro navidad:')!!}
		{!!Form::text('pro_navidad',$mot->pro_navidad,['class'=>'form-control','placeholder'=>'Pro navidad','maxlength'=>'10'])!!}
	</div>	
	<div class="form-group" >
		{!!Form::label('pro_accidente','Pro accidente:')!!}
		{!!Form::text('pro_accidente',$mot->pro_accidente,['class'=>'form-control','placeholder'=>'Pro accidente','maxlength'=>'10'])!!}
	</div>	
	<div class="form-group" >
		{!!Form::label('ahorro','Ahorro:')!!}
		{!!Form::text('ahorro',$mot->ahorro,['class'=>'form-control','placeholder'=>'Ahorro','maxlength'=>'10'])!!}
	</div>	
<input type="hidden" name="anio" id="anio" value="{{$mot->anio}}">  


	

</div>	




	</div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">		
		<div align="right">
			{!!Form::submit('REGISTRAR',['class'=>'btn btn-primary','id'=>'btn_registrar','onclick'=>'btn_esconder()'])!!}
			<a href="{!!URL::to('ajuste')!!}" class="btn btn-danger">CANCELAR</a>
			<?php //{!!Form::reset('CANCELAR',['class'=>'btn btn-danger'])!!} ?>
		</div>
	</div>

	</form>
		@endforeach
</div>
 
	@endsection