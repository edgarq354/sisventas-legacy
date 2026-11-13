<div class="form-group">
	{!!Form::label('nombre','Nombre:')!!}
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

