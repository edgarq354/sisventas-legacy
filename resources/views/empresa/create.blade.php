
@extends ('layouts.inicio')
@section ('contenido')
@include('alerts.success')
@include('alerts.request')
@include('alerts.errors')

    <style>












      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 100%;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
      .controls {
        margin-top: 10px;
        border: 1px solid transparent;
        border-radius: 2px 0 0 2px;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        height: 32px;
        outline: none;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
      }

      #pac-input {
        background-color: #fff;
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
        margin-left: 12px;
        padding: 0 11px 0 13px;
        text-overflow: ellipsis;
        width: 300px;
      }

      #pac-input:focus {
        border-color: #4d90fe;
      }

      .pac-container {
        font-family: Roboto;
      }

      #type-selector {
        color: #fff;
        background-color: #4d90fe;
        padding: 5px 11px 0px 11px;
      }

      #type-selector label {
        font-family: Roboto;
        font-size: 13px;
        font-weight: 300;
      }
      #target {
        width: 345px;
      }
    </style>

	<div class="row">
	    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	{!!Form::open(['route'=>'empresa.store', 'method'=>'POST' , 'enctype'=>'multipart/form-data','onKeypress'=>'if(event.keyCode == 13) event.returnValue = false;'])!!}	
  <h4 align="left" style="color: red">REGISTRO DE EMPRESA</h4>

  <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
	<div class="form-group">
		{!!Form::label('nit','NIT:')!!}<span ><font color="red" size="5px">*</font></span>
		{!!Form::text('nit',null,['id'=>'nit','class'=>'form-control','placeholder'=>'Ingrese el NIT de la Empresa','maxlength'=>'50','onkeyup'=>'controlar()', 'onkeypress'=>'return bloqueo_de_punto(event)'])!!}
		<label id="nit_verificar" hidden="" style="color: red">* Ya existe ese NIT</label>
	</div>

	<div class="form-group" hidden="" >
		{!!Form::label('tipo','tipo:')!!}<span ><font color="red" size="5px">*</font></span>
		{!!Form::select('tipo', array('UNIPERSONAL' => 'UNIPERSONAL', 'S.R.L.' => 'S.R.L.', 'ASOCIACIÓN' => 'ASOCIACIÓN','OTROS' => 'OTROS'),null,array('class'=>'custom-select form-control dropdown-toggle','data-toggle' => 'dropdown'))!!}
	</div>

	<div class="form-group" >
		{!!Form::label('razon_social','Razon Social:')!!}<span ><font color="red" size="5px">*</font></span>
		{!!Form::text('razon_social',null,['class'=>'form-control','placeholder'=>'Ingrese la razon social','maxlength'=>'50'])!!}
	</div>

	<div class="form-group">
		{!!Form::label('direccion','Dirección:')!!}	<span ><font color="red" size="5px">*</font></span>
		{!!Form::textarea('direccion',null,['class'=>'form-control','placeholder'=>'Ingrese la Dirección','style'=>'height:100px;'])!!}	

		{!!Form::hidden('latitud',null,['class'=>'form-control'])!!}	
		{!!Form::hidden('longitud',null,['class'=>'form-control'])!!}
	</div>

	<div class="form-group" hidden="">
			{!!Form::label('estado','Estado:')!!}
            {!!Form::select('estado', array('1' => 'ACTIVO', '0' => 'INACTIVO'),null,array('id'=>'estado','class'=>'form-control'))!!}
	</div>			

	<div class="form-group"  hidden=""> 
		{!!Form::label('credito','credito:')!!}
		{!!Form::text('credito',1000,['class'=>'form-control','placeholder'=>'Ingrese su credito','maxlength'=>'3'])!!}
	</div>	
	<div class="form-group" hidden="" >
		{!!Form::label('','Administrador :')!!}<span ><font color="red" size="5px">*</font></span>
			<select name="id_administrador" class="form-control selectpicker" id="id_administrador" data-live-search="true" >
			        @foreach($administrador as $mov)
			        <option value="{{$mov->id}}">{{$mov->nombre}} {{$mov->paterno}} {{$mov->materno}} - {{$mov->telefono}}</option>
			        @endforeach
			</select>
	</div>
	<div class="form-group"  > 
		{!!Form::label('correo','correo:')!!}
		{!!Form::text('correo',null,['class'=>'form-control','placeholder'=>'Ingrese su correo','maxlength'=>'50'])!!}
	</div>	

	
	<div class="form-group"  > 
		{!!Form::label('','Telefono:')!!}
		{!!Form::text('telefono',null,['class'=>'form-control','placeholder'=>'Ingrese su telefono','maxlength'=>'50'])!!}
	</div>	

	<div class="form-group"  > 
		{!!Form::label('whatsapp','whatsapp:')!!}
		{!!Form::text('whatsapp',null,['class'=>'form-control','placeholder'=>'Ingrese su whatsapp','maxlength'=>'15'])!!}
	</div>


	


	<div class="form-group" hidden="" >
		{!!Form::label('','Pais :')!!}<span ><font color="red" size="5px">*</font></span>
			<select name="id_pais" class="form-control selectpicker" id="id_pais" data-live-search="true" >
			        @foreach($pais as $mov)
			        <option value="{{$mov->id}}">{{$mov->nombre}}</option>
			        @endforeach
			</select>
	</div>

	



	
		


<input type="hidden" name="ci_representante_legal" id="ci_representante_legal" value="">

<input type="hidden" name="id_fotocopia_constitucion_de_empresa" id="id_fotocopia_constitucion_de_empresa" value=null>
<input type="hidden" name="id_fotocopia_poder_del_representante_legal" id="id_fotocopia_poder_del_representante_legal" value="">
<input type="hidden" name="id_fotocopia_registro_fundaempresa" id="id_fotocopia_registro_fundaempresa" value="">
<input type="hidden" name="id_fotocopia_ci_del_representante_legal" id="id_fotocopia_ci_del_representante_legal" value="">

<input type="hidden" name="id_fotocopia_licencia_funcionamiento_gmlp" id="id_fotocopia_licencia_funcionamiento_gmlp" value="">
<input type="hidden" name="id_fotocopia_nit" id="id_fotocopia_nit" value="">
<input type="hidden" name="id_fotocopia_resolucion_administrativa_att" id="id_fotocopia_resolucion_administrativa_att" value="">
<input type="hidden" name="id_fotocopia_factura_luz_agua_de_oficinas" id="id_fotocopia_factura_luz_agua_de_oficinas" value="">

<input type="hidden" name="id_imagen_corporativa" id="id_imagen_corporativa" value="">
<input type="hidden" name="id_fotocopia_registro_senapi" id="id_fotocopia_registro_senapi" value="">

<div class="form-group" hidden="" >
		{!!Form::label('','Departamento :')!!}<span ><font color="red" size="5px">*</font></span>
			<select name="id_departamento" class="form-control selectpicker" id="id_departamento" data-live-search="true" >
			        @foreach($departamento as $mov)
			        <option value="{{$mov->id}}">{{$mov->nombre}}</option>
			        @endforeach
			</select>
	</div>

</div>
 
 <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12" >
	<div class="form-group"   >
		{!!Form::label('','Tipo de Empresa :')!!}<span ><font color="red" size="5px">*</font></span>
			<select name="tipo_empresa" class="form-control selectpicker"  data-live-search="true" > 
			        <option value="TIENDA" selected>TIENDA</option> 
			        <option value="RESTAURANTE">RESTAURANTE</option> 
			</select>
	</div>

  <div align="form-group">
    <div class="list-group-item ">
       Con factura
      <div class="material-switch pull-right">
        <input id="con_factura" name="con_factura"  type="checkbox"  />
        <label for="con_factura" class="label-success" onclick="con_factura();" ></label>
      </div>
     </div>
   </div>

	<div id="div_con_factura" hidden="">
	   <div align="form-group" >
	    <div class="list-group-item ">
	       Paga IVA
	      <div class="material-switch pull-right">
	        <input id="paga_iva" name="paga_iva" type="checkbox" />
	        <label for="paga_iva" class="label-success"  onclick="paga_iva()"></label>
	      </div>
	     </div>
	   </div>

	   <div align="form-group" >
	    <div class="list-group-item ">
	       Paga IT
	      <div class="material-switch pull-right">
	        <input id="paga_it" name="paga_it" type="checkbox" />
	        <label for="paga_it" class="label-success"  onclick="paga_it()"></label>
	      </div>
	     </div>
	   </div>
	</div>

	<div  id="div_iva" hidden="">
		<div class="form-group" id="div_iva" > 
			{!!Form::label('iva','Iva (%):')!!}
			{!!Form::number('iva',13,['class'=>'form-control','placeholder'=>'Ingrese su whatsapp','maxlength'=>'15'])!!}
		</div>
		 <div class="panel-group">
		  	<div class="panel panel-default">
			    <div class="panel-body">
			    	<div class="funkyradio"  >
			    	<label>¿Quien paga el IVA?</label></br>
			        <div class="funkyradio-primary">
			            <input type="radio" name="quien_paga_iva" id="quien_paga_iva_r1" value="1" checked/>
			            <label for="quien_paga_iva_r1">Empresa</label>
			        </div>
			        <div class="funkyradio-success">
			            <input type="radio" name="quien_paga_iva" id="quien_paga_iva_r2" value="2" />
			            <label for="quien_paga_iva_r2">Conductor</label>
			        </div>
			    	</div>
			    </div>
		  	</div>
		</div>
	</div>

	<div id="div_it" hidden="" >
		<div class="form-group"  > 
			{!!Form::label('i','IT (%):')!!}
			{!!Form::number('it',3,['class'=>'form-control','placeholder'=>'Ingrese su whatsapp','maxlength'=>'15'])!!}
		</div>


	    <div class="panel-group" >
		  	<div class="panel panel-default">
			    <div class="panel-body">
			    	<div class="funkyradio"  >
			    	<label>¿Quien paga el IT?</label></br>
			        <div class="funkyradio-primary">
			            <input type="radio" name="quien_paga_it" id="radio1" checked value="1" />
			            <label for="radio1">Empresa</label>
			        </div>
			        <div class="funkyradio-success">
			            <input type="radio" name="quien_paga_it" id="radio2" value="2" />
			            <label for="radio2">Conductor</label>
			        </div>
			    	</div>
			    </div>
		  	</div>
		</div>
	</div>

 </div>


 <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12" hidden="">
 	<div class="form-group" hidden="">
		{!!Form::label('mision','Misión:')!!}	
		{!!Form::textarea('mision',null,['class'=>'form-control','placeholder'=>'Ingrese la Misión','style'=>'height:100px;'])!!}	
	</div>

	<div class="form-group" hidden="">
		{!!Form::label('vision','Visión:')!!}	
		{!!Form::textarea('vision',null,['class'=>'form-control','placeholder'=>'Ingrese la Visión','style'=>'height:100px;'])!!}	
	</div>
	
	<div class="form-group" hidden="" > 
		{!!Form::label('facebook','facebook:')!!}
		{!!Form::text('facebook',null,['class'=>'form-control','placeholder'=>'Ingrese su facebook'])!!}
	</div>	

 	<div class="form-group" hidden="" >
		{!!Form::label('nro_licencia_funcionamiento','nro_licencia_funcionamiento:')!!}
		{!!Form::text('nro_licencia_funcionamiento',null,['class'=>'form-control','placeholder'=>'Ingrese su nro_licencia_funcionamiento','maxlength'=>'15', 'onkeypress'=>'return bloqueo_de_punto(event)'])!!}
	</div>		

	<div class="form-group" hidden="">
		{!!Form::label('nro_constitucion_de_empresa','Nro Constitucion De Empresa:')!!}
		{!!Form::text('nro_constitucion_de_empresa',null,['class'=>'form-control','placeholder'=>'Ingrese EL Nro Constitucion De Empresa','maxlength'=>'15' ])!!}
	</div>

   

	
 </div>
<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12" hidden="">
	 <div class="form-group" hidden="">
		{!!Form::label('nro_poder_del_representante','Nro Poder Del Representante:')!!}
		{!!Form::text('nro_poder_del_representante',null,['class'=>'form-control','placeholder'=>'Ingrese EL Nro Poder Del Representante','maxlength'=>'15' ])!!}
	</div>

	<div class="form-group" hidden="">
		{!!Form::label('nro_registro_fundaempresa','Nro Registro Fundaempresa:')!!}
		{!!Form::text('nro_registro_fundaempresa',null,['class'=>'form-control','placeholder'=>'Ingrese EL Nro Registro Fundaempresa','maxlength'=>'15' ])!!}
	</div>

	<div class="form-group" hidden="">
		{!!Form::label('nro_resolucion_administrativa_att','Nro Resolucion Administrativa ATT:')!!}
		{!!Form::text('nro_resolucion_administrativa_att',null,['class'=>'form-control','placeholder'=>'Ingrese Nro Resolucion Administrativa ATT','maxlength'=>'15' ])!!}
	</div>

	<div class="form-group" hidden="">
		{!!Form::label('nro_registro_senapi','Nro Registro Senapi:')!!}
		{!!Form::text('nro_registro_senapi',null,['class'=>'form-control','placeholder'=>'Ingrese EL Nro Registro Senapi','maxlength'=>'15' ])!!}
	</div>
</div>


<div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
{!!Form::label('','Dirección de la empresa:')!!}
    <input id="pac-input" class="controls" type="text" placeholder="Search Box" class="form-control">
    <div id="map" style="width: 100%; height: 550px;"></div>
	<div class="pull-right" hidden="">
	   <!--button id="btn_ver" type="button" class="btn-sm btn-info" hidden="" onclick="lista_direccion()">VER TODOS</button-->	
	   <!--button id="bt_add" type="button" class="btn-sm btn-success" hidden="" onclick="nuevo()"><i class="fa fa-plus-square" aria-hidden="true"></i></button-->
	</div>
</div>


<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" hidden="">
	<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
		<table class="table table-striped table-bodered table-condensed table-hover" style="background: white">
			<thead style="background: #635234; color: white">
				<th>Constitución De Empresa</th>
				<th><button type="button" class="btn-sm btn-info pull-right" onclick="Agregar_Imagen_Constitucion_Empresa()"><i class="fa fa-plus-square" aria-hidden="true"></i></button></th>
			</thead>
			<tbody id="lista_const_Emp"></tbody>  
		</table> 
	</div>	

	<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
		<table class="table table-striped table-bodered table-condensed table-hover" style="background: white">
			<thead style="background: #635234; color: white">
				<th>Poder Del Representante Legal</th>
				<th><button type="button" class="btn-sm btn-info pull-right" onclick="Agregar_Imagen_Rep_Legal()"><i class="fa fa-plus-square" aria-hidden="true"></i></button></th>
			</thead>
			<tbody id="lista_rep_leg"></tbody>  
		</table> 
	</div>	

	<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
		<table class="table table-striped table-bodered table-condensed table-hover" style="background: white">
			<thead style="background: #635234; color: white">
				<th>Registro Fundaempresa</th>
				<th><button type="button" class="btn-sm btn-info pull-right" onclick="Agregar_Imagen_Fundaempresa()"><i class="fa fa-plus-square" aria-hidden="true"></i></button></th>
			</thead>
			<tbody id="lista_fundaempresa"></tbody>  
		</table> 
	</div>	

	<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
		<table class="table table-striped table-bodered table-condensed table-hover" style="background: white">
			<thead style="background: #635234; color: white">
				<th>CI Del Representante Legal</th>
				<th><button type="button" class="btn-sm btn-info pull-right" onclick="Agregar_Imagen_CI_Rep_Legal()"><i class="fa fa-plus-square" aria-hidden="true"></i></button></th>
			</thead>
			<tbody id="lista_CI_Rep_Leg"></tbody>  
		</table> 
	</div>		
</div>

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" hidden="">
	<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
		<table class="table table-striped table-bodered table-condensed table-hover" style="background: white">
			<thead style="background: #635234; color: white">
				<th>Licencia De Funcionamiento GMLP</th>
				<th><button type="button" class="btn-sm btn-info pull-right" onclick="Agregar_Imagen_GMLP()"><i class="fa fa-plus-square" aria-hidden="true"></i></button></th>
			</thead>
			<tbody id="lista_gmlp"></tbody>  
		</table> 
	</div>	

	<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
		<table class="table table-striped table-bodered table-condensed table-hover" style="background: white">
			<thead style="background: #635234; color: white">
				<th>NIT</th>
				<th><button type="button" class="btn-sm btn-info pull-right" onclick="Agregar_Imagen_NIT()"><i class="fa fa-plus-square" aria-hidden="true"></i></button></th>
			</thead>
			<tbody id="lista_nit"></tbody>  
		</table> 
	</div>	
	<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
		<table class="table table-striped table-bodered table-condensed table-hover" style="background: white">
			<thead style="background: #635234; color: white">
				<th>Resolución Administrativa ATT</th>
				<th><button type="button" class="btn-sm btn-info pull-right" onclick="Agregar_Imagen_ATT()"><i class="fa fa-plus-square" aria-hidden="true"></i></button></th>
			</thead>
			<tbody id="lista_att"></tbody>  
		</table> 
	</div>	

	<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
		<table class="table table-striped table-bodered table-condensed table-hover" style="background: white">
			<thead style="background: #635234; color: white">
				<th>Factura Agua o Luz De la Empresa</th>
				<th><button type="button" class="btn-sm btn-info pull-right" onclick="Agregar_Imagen_Agua_Luz()"><i class="fa fa-plus-square" aria-hidden="true"></i></button></th>
			</thead>
			<tbody id="lista_agua_luz"></tbody>  
		</table> 
	</div>			
</div>

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" hidden="">
	<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
		<table class="table table-striped table-bodered table-condensed table-hover" style="background: white">
			<thead style="background: #635234; color: white">
				<th>Imagen Corporativa</th>
				<th><button type="button" class="btn-sm btn-info pull-right" onclick="Agregar_Imagen_Corporativa()"><i class="fa fa-plus-square" aria-hidden="true"></i></button></th>
			</thead>
			<tbody id="lista_corporativa"></tbody>  
		</table> 
	</div>	

	<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
		<table class="table table-striped table-bodered table-condensed table-hover" style="background: white">
			<thead style="background: #635234; color: white">
				<th>Registro Senapi</th>
				<th><button type="button" class="btn-sm btn-info pull-right" onclick="Agregar_Imagen_Senapi()"><i class="fa fa-plus-square" aria-hidden="true"></i></button></th>
			</thead>
			<tbody id="lista_senapi"></tbody>  
		</table> 
	</div>			
</div>


<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" hidden="">
	<h4 align="left" style="color: red"><b>REGISTRO DEL REPRESENTANTE LEGAL DE LA EMPRESA</b></h4>
	
</div>

<div class="col-lg-5 col-md-5 col-sm-5 col-xs-12" hidden="">
	
	<div class="form-group">
		{!!Form::label('ci','Cedula de Identidad:')!!}<span ><font color="red" size="5px">*</font></span>
		<label id="ci_verificar" hidden="" style="color: red">* Ya existe ese C.I.</label>			
	</div>
	
         <div class="input-group">
	      <input type = "text" class = "form-control selectpicker text-uppercase" name="ci" id="ci" placeholder="C.I. del Representante" onkeyup="cargar_usuario();" onkeypress="return bloqueo_de_punto(event);">
					     
	      <span class="input-group-btn">
	        <button class="btn btn-success" onclick="verificar_ci_representante();" type="button">Verificar</button>
	      </span>
      	</div>

	<br>
	<div class="form-group" >
		{!!Form::label('','Expedido:')!!}<span ><font color="red" size="5px">*</font></span>
	{!!Form::select('expedido', array('LP' => 'LA PAZ', 'SC' => 'SANTA CRUZ', 'CB' => 'COCHABAMBA', 'PT' => 'POTOSI', 'TJ' => 'TARIJA', 'OR' => 'ORURO', 'BN' => 'BENI', 'PD' => 'PANDO', 'CH' => 'CHUQUISACA', 'EX' => 'EXTRANJERO'),null,array('id'=>'expedido','class'=>'custom-select form-control dropdown-toggle','data-toggle' => 'dropdown'))!!}
	</div>	


	<div class="form-group" >
		{!!Form::label('nombre','Nombre del Dueño:')!!}
		{!!Form::text('nombre',null,['class'=>'form-control','placeholder'=>'Ingrese el nombre del dueño','maxlength'=>'15'])!!}
	</div>	

	<div class="form-group"  >
		{!!Form::label('paterno','Apellido Paterno:')!!}<span ><font color="red" size="5px">*</font></span>
		{!!Form::text('paterno',null,['class'=>'form-control','placeholder'=>'Ingrese el apellido paterno del dueño','maxlength'=>'20'])!!}
	</div>

	<div class="form-group"  >
		{!!Form::label('materno','Apellido Materno:')!!}
		{!!Form::text('materno',null,['class'=>'form-control','placeholder'=>'Ingrese el apellido materno del dueño','maxlength'=>'20'])!!}
	</div>	
	<div class="form-group"  hidden="">
		{!!Form::label('titulo','Titulo:')!!}
		{!!Form::text('titulo',"REPRESENTANTE LEGAL",['class'=>'form-control','placeholder'=>'Ingrese el titulo','maxlength'=>'20','readonly'])!!}
	</div>	
	
</div>

<div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
	<div class="form-group"  hidden="">
		{!!Form::label('','Correo:')!!}
		{!!Form::text('correo_duenio',null,['class'=>'form-control','placeholder'=>'Ingrese el correo','maxlength'=>'30'])!!}
	</div>		
      <div class="form-group" hidden="">
		{!!Form::label('fecha_nacimientos','Fecha de Nacimiento:')!!}        
        <div class='input-group date' id='datetimepicker10'>
		  {!!Form::text('fecha_nacimiento','1990-01-01',['class'=>'form-control','maxlength'=>'10','style'=>'font-size:20px;text-align:left;'])!!}        
          <span class="input-group-addon ">
             <span class="fa fa-calendar" aria-hidden="true"></span>  <!--span class="glyphicon glyphicon-calendar"></span-->
          </span>
        </div>
      </div>	

	<div class="form-group" hidden="">		
		{!!Form::label('Foto Del Representante Legal:')!!}
		<input type="file" name="imagen_rep_legal" id="imagen_rep_legal" accept="image*/">
		<br/><center><output id="list_RL"></output></center>
		<center><img src="" name="foto_rep_legal" id="foto_rep_legal" width="150px" height="150px" hidden=""></center>
	</div>     		
</div>



		<div align="right">
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

			{!!Form::submit('REGISTRAR',['class'=>'btn btn-primary','id'=>'btn_registrar','onclick'=>'btn_esconder()'])!!}
			
		</div>
</div>

		</form>
		</div>
	</div>
   {!!Html::script('js/crear_empresa.js')!!}
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDz02-44rmUM4TCcICttE6_qLCh6RmzjJw&callback=initAutocomplete&libraries=places"></script>

@endsection

