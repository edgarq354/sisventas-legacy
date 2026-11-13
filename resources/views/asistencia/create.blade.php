
@extends ('layouts.inicio')
@section ('contenido')
@include('alerts.success')
@include('alerts.request')
	<div class="row"  style="overflow-x:inherit">
	    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" >
		<H2>REGISTRO ASISTENCIA</H2>	  
    {{Form::open(array('rutes' => 'asistencia.create','onKeypress'=>'if(event.keyCode == 13) event.returnValue = false;'))}}  

		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">

			

			<div class="form-group" >
				{!!Form::label('nombre','')!!}
				{!!Form::text('nombre',null,['class'=>'form-control','placeholder'=>'Ingrese el nombre','maxlength'=>'100'])!!}
			</div>

			<div class="form-group">
				{!!Form::label('usuario','Usuario:')!!}
				{!!Form::text('usuario',null,['class'=>'form-control','placeholder'=>'Ingrese el usuario','maxlength'=>'15'])!!}
			</div>

			<div class="form-group">
				{!!Form::label('password','Contraseña:')!!}
				{!!Form::text('password',null,['class'=>'form-control','placeholder'=>'Ingrese la contraseña','maxlength'=>'15'])!!}
			</div>

			<div class="form-group" >
					{!!Form::label('privilegio','Tipo De Usuario:')!!}
		            {!!Form::select('privilegio', array('0' => 'EMPRESA', '3' => 'COBRADOR'),null,array('id'=>'privilegio','class'=>'form-control'))!!}
			</div>	


		<div align="right">
			{!!Form::submit('REGISTRAR',['class'=>'btn btn-primary','id'=>'btn_registrar','onclick'=>'btn_esconder()'])!!}
			<a href="{!!URL::to('asistencia')!!}" class="btn btn-danger">CANCELAR</a>
		</div>

		</div>


		</form>
		</div>
	</div>
@endsection
