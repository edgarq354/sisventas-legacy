
@extends ('layouts.inicio')
@section ('contenido')
@include('alerts.success')
@include('alerts.request')
	<div class="row"  style="overflow-x:inherit">
	    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" >
		<H2>{{ __('asistencia.registro_asistencia_h2') }}</H2>	  
    {{Form::open(array('rutes' => 'asistencia.create','onKeypress'=>'if(event.keyCode == 13) event.returnValue = false;'))}}  

		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">

			

			<div class="form-group" >
				{!!Form::label('nombre','')!!}
				{!!Form::text('nombre',null,['class'=>'form-control','placeholder'=>__('asistencia.placeholder_nombre'),'maxlength'=>'100'])!!}
			</div>

			<div class="form-group">
				{!!Form::label('usuario',__('asistencia.usuario_dp'))!!}
				{!!Form::text('usuario',null,['class'=>'form-control','placeholder'=>__('asistencia.placeholder_usuario'),'maxlength'=>'15'])!!}
			</div>

			<div class="form-group">
				{!!Form::label('password',__('asistencia.contrasena_dp'))!!}
				{!!Form::text('password',null,['class'=>'form-control','placeholder'=>__('asistencia.placeholder_contrasena'),'maxlength'=>'15'])!!}
			</div>

			<div class="form-group" >
					{!!Form::label('privilegio',__('asistencia.tipo_de_usuario_dp'))!!}
		            {!!Form::select('privilegio', array('0' => __('asistencia.opt_empresa'), '3' => __('asistencia.opt_cobrador')),null,array('id'=>'privilegio','class'=>'form-control'))!!}
			</div>	


		<div align="right">
			{!!Form::submit(__('asistencia.registrar'),['class'=>'btn btn-primary','id'=>'btn_registrar','onclick'=>'btn_esconder()'])!!}
			<a href="{!!URL::to('asistencia')!!}" class="btn btn-danger">{{ __('asistencia.cancelar') }}</a>
		</div>

		</div>


		</form>
		</div>
	</div>
@endsection
