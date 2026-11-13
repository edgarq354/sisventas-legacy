


<script type="text/javascript">
  function cargar_usuario(){
  	var ci=$("#ci").val();
  	$("#usuario").val(ci);
  	$("#contrasenia").val(ci);
  }	
</script>


<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
          

	<div class="form-group" >
		{!!Form::label('','Expedido:')!!}<span ><font color="black" size="5px">*</font></span>
	{!!Form::select('departamento', array( 'SANTA CRUZ' => 'SANTA CRUZ', 'COCHABAMBA' => 'COCHABAMBA', 'POTOSI' => 'POTOSI','LA PAZ' => 'LA PAZ', 'TARIJA' => 'TARIJA', 'ORURO' => 'ORURO', 'BENI' => 'BENI', 'PANDO' => 'PANDO', 'CHUQUISACA' => 'CHUQUISACA'),null,array( 'class'=>'custom-select form-control dropdown-toggle','data-toggle' => 'dropdown'))!!}
	</div>	

	<div class="form-group" >
		{!!Form::label('nombre','Nombre:')!!}<span ><font color="black" size="5px">*</font></span>
		{!!Form::text('nombre',null,['class'=>'form-control text-capitalize','placeholder'=>'Ingrese el nombre'])!!}
	</div>	

	 

	<div class="form-group">
		{!!Form::label('fecha_nacimiento','Fecha de Nacimiento:')!!} <span ><font color="black" size="5px">*</font></span>          
		<div class='input-group date' id='datetimepicker10'>
			{!!Form::text('fecha_nacimiento','1990-01-01',['id'=>'fecha_nacimiento','class'=>'form-control','maxlength'=>'10','onkeypress'=>'return bloqueo_de_punto(event)','style'=>'font-size:20px;text-align:left'])!!}
			<span class="input-group-addon ">
			  <span class="fa fa-calendar" aria-hidden="true"></span> 
			</span>
		</div>
	</div>	

<div class="form-group">
		{!!Form::label(' ','Fecha de desaparición:')!!} <span ><font color="black" size="5px">*</font></span>          
		<div class='input-group date' id='datetimepicker11'>
			{!!Form::text('fecha_desaparecido','1990-01-01',['id'=>'fecha_nacimiento','class'=>'form-control','maxlength'=>'10','onkeypress'=>'return bloqueo_de_punto(event)','style'=>'font-size:20px;text-align:left'])!!}
			<span class="input-group-addon ">
			  <span class="fa fa-calendar" aria-hidden="true"></span> 
			</span>
		</div>
	</div>	


	<div class="form-group"  >
		{!!Form::label('sexo','Género :')!!}<span ><font color="black" size="5px">*</font></span>
		 <input type="radio"  name="select" checked="true" id="select" value="M" style="width:17px; height:17px;" onclick="verificar_sexo()"> MASCULINO 
		{!!Form::hidden('sexo','M',['id'=>'sexo','value'=>'M','class'=>'form-control','maxlength'=>'1'])!!}
		<input type="radio" name="select" id="select" value="F" style="width:17px; height:17px;" onclick="verificar_sexo()"> FEMENINO  	
	</div>

	 

		

</div>	


<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">

	

	
	 
	<div class="form-group"  >
		{!!Form::label('direccion','Dirección:')!!}<span ><font color="black" size="5px">*</font></span>
		{!!Form::textarea('direccion',null,['class'=>'form-control text-capitalize','placeholder'=>'Ingrese la dirección','style'=>'height:100px;'])!!}
	</div>



	<div class="form-group"  >
		{!!Form::label('descripcion','Descripción:')!!}<span ><font color="black" size="5px">*</font></span>
		{!!Form::textarea('descripcion',null,['class'=>'form-control text-capitalize','placeholder'=>'Descripción','style'=>'height:100px;'])!!}
	</div>
	
	<div class="form-group" >
			{!!Form::label('estado','Estado:')!!}
            {!!Form::select('estado', array('1' => 'DESAPARECIDO', '0' => 'ENCONTRADO'),null,array('id'=>'estado','class'=>'form-control'))!!}
	</div>
	 	 

	
	
	     
</div>	

<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">

 <div class="form-group" >
		{!!Form::label('','Nombre 1:')!!}<span ><font color="black" size="5px">*</font></span>
		{!!Form::text('nombre_referencia_1',null,['class'=>'form-control text-capitalize','placeholder'=>'Ingrese el nombre'])!!}
	</div>	

	<div class="form-group"  >
		{!!Form::label('','Celular 1:')!!}<span ><font color="black" size="5px">*</font></span>
		{!!Form::text('celular_referencia_1',null,['class'=>'form-control','placeholder'=>'Ingrese el celular','maxlength'=>'8','onkeypress'=>'return bloqueo_de_punto(event)'])!!}
	</div>	

	 <div class="form-group" >
		{!!Form::label('','Nombre 2:')!!}<span ><font color="black" size="5px">*</font></span>
		{!!Form::text('nombre_referencia_2',null,['class'=>'form-control text-capitalize','placeholder'=>'Ingrese el nombre'])!!}
	</div>	
	<div class="form-group"  >
		{!!Form::label('celular_referencia_2','Celular 2:')!!}<span ><font color="black" size="5px">*</font></span>
		{!!Form::text('celular_referencia_2',null,['class'=>'form-control','placeholder'=>'Ingrese el celular','maxlength'=>'8','onkeypress'=>'return bloqueo_de_punto(event)'])!!}
	</div>	
	




	  
 
   
</div>

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
{!!Form::label('','Lugar de Desaparición:')!!}<span ><font color="black" size="5px">*</font></span>
    <input id="pac-input" class="controls" type="text" placeholder="Search Box" class="form-control">
    <div id="map" style=" height: 550px;"></div>
</div>	

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
<hr style="background: black; height: 3px;">
<h2>Por Favor complete el REGISTRO.</h2>
	 
</div>	

 
 	
 


{!!Form::hidden('latitud',null,['class'=>'form-control','placeholder'=>'Ingrese la latitud','maxlength'=>'30'])!!}
{!!Form::hidden('longitud',null,['class'=>'form-control','placeholder'=>'Ingrese la longitud','maxlength'=>'30'])!!}

 
