@extends ('layouts.inicio')
@section ('contenido')
@include('alerts.success')
@include('alerts.request')
@include('alerts.errors')
				<div class="header">
			<div class="top-header">
				<div class="logo">
					
					<p>Movie Theater</p>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="header-info">
				{!!Form::open(['route'=>'sendmail.store', 'method'=>'POST'])!!}
					<div class="form-group">
						{!!Form::label('correo','Correo:')!!}
						{!!Form::email('email',null,['class'=>'form-control', 'placeholder'=>'Ingresa tu correo'])!!}
					</div>
					<div class="form-group">
						{!!Form::label('mensaje','Mensaje:')!!}	
						{!!Form::text('mensaje',null,['class'=>'form-control','placeholder'=>'Ingrese el tipo'])!!}
					</div>
					{!!Form::submit('Iniciar',['class'=>'btn btn-primary'])!!}
				</form>
			</div>
		</div>
		
			
		</div>
	@endsection	