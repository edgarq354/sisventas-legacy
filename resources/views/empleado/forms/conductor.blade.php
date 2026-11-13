
<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
	<div class="pull-left">
		{!!Form::label('ci','Cedula de Identidad:')!!}<span ><font color="red" size="5px">*</font></span>
		
		<label id="ci_verificar" hidden="" style="color: red">* Ya existe ese C.I.</label>			
	</div>
	<div class="pull-left">
		{!!Form::label('expedido','    Expedido:')!!}<span ><font color="red" size="5px">*</font></span>
        
	</div>

	<div class="pull-left" hidden="">		
        <br>
        <button class="btn-sm btn-success" type="button" onclick="verificar_ci_conductor()">Verificar</button>
	</div>
   
   <div class = "col-lg-10" style="margin-left: -15px;">
            <div class = "input-group">
               <input type = "text" class = "form-control" name="ci" id="ci" placeholder="C.I. del Conductor" onkeypress="return bloqueo_de_punto(event);">
               <div class = "input-group-btn">
                  
                  <select class="custom-select form-control dropdown-toggle" 
                     data-toggle = "dropdown" name="expedido" id="expedido" >
					  <option  value="LP" selected>LA PAZ</option>
					  <option value="SC">SANTA CRUZ</option>
					  <option value="CO">COCHABAMBA</option>
					  <option value="PT">POTOSI</option>
					  <option value="TJ">TARIJA</option>
					  <option value="OR">ORURO</option>
					  <option value="BN">BENI</option>
					  <option value="PD">PANDO</option>
					  <option value="CH">CHUQUISACA</option>
					  <option value="EX">EXTRANJERO</option>
					</select>
                     <button class="btn-sm btn-success" type="button" tabindex = "-1" onclick="verificar_ci_conductor()">Verificar</button>
               </div><!-- /btn-group -->
               
               
            </div><!-- /input-group -->
         </div>

	<br><br><br><br>

	<div class="form-group" >
		{!!Form::label('nombre','Nombre del Conductor:')!!}<span ><font color="red" size="5px">*</font></span>
		{!!Form::text('nombre',null,['class'=>'form-control','placeholder'=>'Ingrese el nombre del conductor','maxlength'=>'30'])!!}
	</div>	

	<div class="form-group"  >
		{!!Form::label('paterno','Apellido Paterno:')!!}<span ><font color="red" size="5px">*</font></span>
		{!!Form::text('paterno',null,['class'=>'form-control','placeholder'=>'Ingrese el apellido paterno','maxlength'=>'30'])!!}
	</div>

	<div class="form-group"  >
		{!!Form::label('materno','Apellido Materno:')!!}<span ><font color="red" size="5px">*</font></span>
		{!!Form::text('materno',null,['class'=>'form-control','placeholder'=>'Ingrese el apellido materno','maxlength'=>'30'])!!}
	</div>	

	<div class="form-group">
		{!!Form::label('fecha_nacimiento','Fecha de Nacimiento:')!!} <span ><font color="red" size="5px">*</font></span>          
		<div class='input-group date' id='datetimepicker10'>
			{!!Form::text('fecha_nacimiento','1990-01-01',['id'=>'fecha_nacimiento','class'=>'form-control','maxlength'=>'10','onkeypress'=>'return bloqueo_de_punto(event)','style'=>'font-size:20px;text-align:left'])!!}
			<span class="input-group-addon ">
			  <span class="fa fa-calendar" aria-hidden="true"></span> 
			</span>
		</div>
	</div>	

	<div class="form-group"  >
		{!!Form::label('sexo','Género :')!!}<span ><font color="red" size="5px">*</font></span>
		 <input type="radio"  name="select" checked="true" id="select" value="M" style="width:17px; height:17px;" onclick="verificar_sexo()"> MASCULINO 
		{!!Form::hidden('sexo','M',['id'=>'sexo','value'=>'M','class'=>'form-control','maxlength'=>'1'])!!}
		<input type="radio" name="select" id="select" value="F" style="width:17px; height:17px;" onclick="verificar_sexo()"> FEMENINO  	
	</div>

		

</div>	


<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">

<div class="form-group"  >
		{!!Form::label('celular','Celular:')!!}<span ><font color="red" size="5px">*</font></span>
		{!!Form::text('celular',null,['class'=>'form-control','placeholder'=>'Ingrese el celular','maxlength'=>'8','onkeypress'=>'return bloqueo_de_punto(event)'])!!}
	</div>		

	<div class="form-group"  >
		{!!Form::label('imei','Imei:')!!}
		{!!Form::text('imei',null,['class'=>'form-control','placeholder'=>'Ingrese el imei del celular','maxlength'=>'30'])!!}
	</div>	
	
	<div class="form-group"  >
		{!!Form::label('correo','Correo:')!!}
		{!!Form::text('correo',null,['class'=>'form-control','placeholder'=>'Ingrese el correo','maxlength'=>'30'])!!}
	</div>	
	<div class="form-group"  >
		{!!Form::label('direccion','Dirección:')!!}<span ><font color="red" size="5px">*</font></span>
		{!!Form::text('direccion',null,['class'=>'form-control','placeholder'=>'Ingrese la dirección','maxlength'=>'50'])!!}
	</div>

	<div class="form-group"  >
		{!!Form::label('usuario','Usuario:')!!}<span ><font color="red" size="5px">*</font></span>
		{!!Form::text('usuario',null,['class'=>'form-control','placeholder'=>'Ingrese el usuario','maxlength'=>'15'])!!}
	</div>			

	<div class="form-group"  >
		{!!Form::label('contrasenia','Contraseña:')!!}<span ><font color="red" size="5px">*</font></span>
		{!!Form::text('contrasenia',null,['class'=>'form-control','placeholder'=>'Ingrese ls contraseña','maxlength'=>'15'])!!}
	</div>					

	     
</div>	

<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
<div class="form-group" hidden="">
			{!!Form::label('estado','Estado:')!!}
            {!!Form::select('estado', array('1' => 'ACTIVO', '0' => 'INACTIVO'),null,array('id'=>'estado','class'=>'form-control'))!!}
	</div>

	<div class="form-group">
			{!!Form::label('categoria_licencia','Categoria Licencia:')!!}<span ><font color="red" size="5px">*</font></span>
            {!!Form::select('categoria_licencia', array('' => 'SELECCIONE UNA CATEGORIA', 'A' => 'A', 'B' => 'B', 'C' => 'C', 'P' => 'P'),null,array('id'=>'categoria_licencia','class'=>'form-control'))!!}
	</div>	

	<div class="form-group">
			{!!Form::label('tipo','Tipo de Conductor:')!!}<span ><font color="red" size="5px">*</font></span>
            {!!Form::select('tipo', array('' => 'SELECCIONE UN TIPO', 'ASALARIADO' => 'ASALARIADO', 'PROPIETARIO' => 'PROPIETARIO'),null,array('id'=>'tipo','class'=>'form-control'))!!}
	</div>

	<div class="form-group" hidden="">
			{!!Form::label('bloqueo','Bloqueo:')!!}
            {!!Form::select('bloqueo', array('0' => 'DESBLOQUEADO', '1' => 'BLOQUEADO'),null,array('id'=>'bloqueo','class'=>'form-control'))!!}
	</div>	

	<div class="form-group" hidden="">
			{!!Form::label('aceptar_condiciones','Aceptar Condiciones:')!!}
            {!!Form::select('aceptar_condiciones', array('1' => 'SI', '0' => 'NO'),null,array('id'=>'aceptar_condiciones','class'=>'form-control'))!!}
	</div>	

	<div class="form-group" hidden="">
		{!!Form::label('credito','Codigo Empresa:')!!}
		{!!Form::text('credito',1000,['class'=>'form-control','placeholder'=>'Ingrese el credito','maxlength'=>'3'])!!}
	</div>

	<div class="form-group">
			{!!Form::label('tipo_de_pago','Tipo De Pago:')!!}<span ><font color="red" size="5px">*</font></span>
            {!!Form::select('tipo_de_pago', array('DIA' => 'DIA', 'SEMANA' => 'SEMANA', 'MES' => 'MES','CONDENADO'=>'CONDENADO','NINGUNO'=>'NINGUNO'),null,array('id'=>'tipo_de_pago','class'=>'form-control'))!!}
	</div>	
	{!!Form::label('Foto del Conductor')!!} <br>
    <!--center><img id="logo" src="{{asset('images/usuario.jpg')}}" title="Cargar Imagen" style="cursor:pointer" class="img-circle"></center><br-->
	<input type="file" name="perfil" id="perfil" style="cursor: pointer;" accept="image/*">
    <br/><center><output id="list"></output></center>   
</div>

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
{!!Form::label('domicilio','Ubicacion de su Domicilio :')!!}<span ><font color="red" size="5px">*</font></span>
    <input id="pac-input" class="controls" type="text" placeholder="Search Box" class="form-control">
    <div id="map" style=" height: 550px;"></div>
</div>	

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
<hr style="background: black; height: 3px;">
<h2>Por Favor complete las fotos de sus documentos legales una ves que halla REGISTRADO al Conductor.</h2>
	<font align="left" style="color: red" hidden=""><b>EDOCUMENTOS DEL CONDUCTOR</b></font>       
</div>	

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" hidden="">
	<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
		<table class="table table-striped table-bodered table-condensed table-hover" style="background: white">
			<thead style="background: #635234; color: white">
				<th>Cedula de Identidad C.I.</th>
				<th><button type="button" class="btn-sm btn-info pull-right" onclick="Agregar_Imagen_Carnet()"><i class="fa fa-plus-square" aria-hidden="true"></i></button></th>
			</thead>
			<tbody id="lista_fotocopia"></tbody>  
		</table> 
	</div>	

	<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
		<table class="table table-striped table-bodered table-condensed table-hover" style="background: white">
			<thead style="background: #635234; color: white">
				<th>Licencia de Conducir</th>
				<th><button type="button" class="btn-sm btn-info pull-right" onclick="Agregar_Imagen_Licencia()"><i class="fa fa-plus-square" aria-hidden="true"></i></button></th>
			</thead>
			<tbody id="lista_licencia"></tbody>  
		</table> 
	</div>	

	<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
		<table class="table table-striped table-bodered table-condensed table-hover" style="background: white">
			<thead style="background: #635234; color: white">
				<th>Tarjeta de Identificación de Ham</th>
				<th><button type="button" class="btn-sm btn-info pull-right" onclick="Agregar_Imagen_Identificacion_Ham()"><i class="fa fa-plus-square" aria-hidden="true"></i></button></th>
			</thead>
			<tbody id="lista_identificacion_ham"></tbody>  
		</table> 
	</div>	
</div>	

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" hidden="">
	<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
		<table class="table table-striped table-bodered table-condensed table-hover" style="background: white">
			<thead style="background: #635234; color: white">
				<th>Tarjeta de Identificación de Transito</th>
				<th><button type="button" class="btn-sm btn-info pull-right" onclick="Agregar_Imagen_Identificacion_Transito()"><i class="fa fa-plus-square" aria-hidden="true"></i></button></th>
			</thead>
			<tbody id="lista_identificacion_transito"></tbody>  
		</table> 
	</div>	
	<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
		<table class="table table-striped table-bodered table-condensed table-hover" style="background: white">
			<thead style="background: #635234; color: white">
				<th>Factura de Agua o Luz</th>
				<th><button type="button" class="btn-sm btn-info pull-right" onclick="Agregar_Imagen_Agua_Luz()"><i class="fa fa-plus-square" aria-hidden="true"></i></button></th>
			</thead>
			<tbody id="lista_agua_luz"></tbody>  
		</table> 
	</div>	
	<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
		<table class="table table-striped table-bodered table-condensed table-hover" style="background: white">
			<thead style="background: #635234; color: white">
				<th>Certificado de Antecedentes de Transito</th>
				<th><button type="button" class="btn-sm btn-info pull-right" onclick="Agregar_Antecendente_Transito()"><i class="fa fa-plus-square" aria-hidden="true"></i></button></th>
			</thead>
			<tbody id="lista_antecedente_transito"></tbody>  
		</table> 
	</div>				
</div>	

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" hidden="">
	<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
		<table class="table table-striped table-bodered table-condensed table-hover" style="background: white">
			<thead style="background: #635234; color: white">
				<th>Certificado de Antecedentes de la FELCC</th>
				<th><button type="button" class="btn-sm btn-info pull-right" onclick="Agregar_Antecendente_FELCC()"><i class="fa fa-plus-square" aria-hidden="true"></i></button></th>
			</thead>
			<tbody id="lista_antecedente_felcc"></tbody>  
		</table> 
	</div>					
</div>	
<input type="hidden" name="id_empresa" id="id_empresa" value="{{Auth::user()->id_empresa}}">  


{!!Form::hidden('latitud',null,['class'=>'form-control','placeholder'=>'Ingrese la latitud','maxlength'=>'30'])!!}
{!!Form::hidden('longitud',null,['class'=>'form-control','placeholder'=>'Ingrese la longitud','maxlength'=>'30'])!!}


<input type="hidden" name="login" id="login" value="0">
<input type="hidden" name="token" id="token" value="0">
<input type="hidden" name="direccion_imagen" id="direccion_imagen" value="0">
