@extends ('layouts.inicio')
@section ('contenido')
@include('alerts.success')

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	    @include('alerts.request')
	<h4 align="left" style="color: red"><b>CREAR ARCHIVO</b></h4>	    
		{!!Form::open(['name'=>'Form1','route'=>'crear_archivo.store', 'method'=>'POST' , 'enctype'=>'multipart/form-data','onKeypress'=>'if(event.keyCode == 13) event.returnValue = false;','onsubmit'=>'return validateForm()'])!!}	
		
<?php //<input type="file" name="imagenes" id="imagenes"> ?>


<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	<font align="left" style="color: red"><b>REGISTRO DEL LAS FOTOS</b></font>       
</div>	
<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
<input type="text" name="ci" id="ci">
	<table class="table table-striped table-bodered table-condensed table-hover">
		<thead>
			<th><center>TIPO DE IMAGEN</center></th>
			<th><center>SUBIR IMAGEN</center></th>
		</thead>
		<tbody id="lista_fotocopia"></tbody>  
	</table> <br>
	<button type="button" class="btn-sm btn-info" onclick="Agregar_Imagen()"><i class="fa fa-plus-square" aria-hidden="true"></i></button>   
</div>	

	</div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">		
		<div align="right">
			{!!Form::submit('REGISTRAR',['class'=>'btn btn-primary','id'=>'btn_registrar'])!!}
			<?php //{!!Form::reset('CANCELAR',['class'=>'btn btn-danger'])!!} ?>
		</div>
	</div>

	</form>
</div>
   {!!Html::script('js/crear_fotocopia.js')!!}
EL ONSUBMIT SOLO SIRVE SI COLOCAMOS EL JAVASCRIP ARRIBA DEL FORM
@endsection