@extends ('layouts.inicio')
@section ('contenido')
@include('alerts.success')
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	    @include('alerts.request')
	<h3 align="left" style="color: red">REGISTRO DE ASIGNACION DE CONDUCTOR - VEHICULO</h3>	
	<span ><font color="red" size="4px">(*) <b>Campos obligatorios</b></font></span>    
		{!!Form::open(['route'=>'asignacion.store', 'method'=>'POST' , 'enctype'=>'multipart/form-data','onKeypress'=>'if(event.keyCode == 13) event.returnValue = false;'])!!}	
			@include('asignacion.forms.asignacion')	
	</div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">		
		<div align="right">
			{!!Form::submit('REGISTRAR',['class'=>'btn btn-primary','id'=>'btn_registrar','onclick'=>'btn_esconder()'])!!}
			<a href="{!!URL::to('asignacion')!!}" class="btn btn-danger">CANCELAR</a>
			<?php //{!!Form::reset('CANCELAR',['class'=>'btn btn-danger'])!!} ?>
		</div>
	</div>

	</form>
</div>
   {!!Html::script('js/asignacion_crear.js')!!}
	@endsection