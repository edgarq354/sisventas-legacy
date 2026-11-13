


<script type="text/javascript">
  function cargar_usuario(){
  	var ci=$("#ci").val();
  	$("#usuario").val(ci);
  	$("#contrasenia").val(ci);
  }	
</script>


<style type="text/css">
	input[type="checkbox"] {
		display:none;
	}
	
	input[type="checkbox"] {
		color:#f2f2f2;
	}
	
	input[type="checkbox"] + label span {
		display:inline-block;
		width:19px;
		height:19px;
		margin:-2px 10px 0 0;
		vertical-align:middle;
		background:url("../images/check_radio_sheet.png") left top no-repeat;
		cursor:pointer;
	}
	
	input[type="checkbox"]:checked + label span {
		background:url("../images/check_radio_sheet.png") -19px top no-repeat;
	}
	</style>
	<script type="text/javascript">
		function seleccionar(){
			if($("#privilegio").val()=="0")
			{
				$("#div_permiso").hide();
			}
			else{
				$("#div_permiso").show();
			}
		}
		
	
	</script>
	
	


<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
	<div class="form-group">
		{!!Form::label('ci','Cedula de Identidad:')!!}<span ><font color="black" size="5px">*</font></span>
		<label id="ci_verificar" hidden="" style="color: black">* Ya existe ese C.I.</label>			
	</div>
	
         <div class="input-group">
	      <input type = "text" class = "form-control selectpicker text-uppercase" name="ci" id="ci" placeholder="C.I. del Conductor" onkeyup="cargar_usuario();" onkeypress="return bloqueo_de_punto(event);">
					     
	      <span class="input-group-btn">
	        <button class="btn btn-success" onclick="verificar_ci_conductor();cargar_usuario();" type="button">Verificar</button>
	      </span>
      	</div>

	<div class="form-group" >
		{!!Form::label('','Expedido:')!!}<span ><font color="black" size="5px">*</font></span>
	{!!Form::select('expedido', array( 'SC' => 'SANTA CRUZ', 'CB' => 'COCHABAMBA', 'PT' => 'POTOSI','LP' => 'LA PAZ', 'TJ' => 'TARIJA', 'OR' => 'ORURO', 'BN' => 'BENI', 'PD' => 'PANDO', 'CH' => 'CHUQUISACA', 'EX' => 'EXTRANJERO'),null,array('id'=>'expedido','class'=>'custom-select form-control dropdown-toggle','data-toggle' => 'dropdown'))!!}
	</div>	

	<div class="form-group" >
		{!!Form::label('nombre','Nombre del Conductor:')!!}<span ><font color="black" size="5px">*</font></span>
		{!!Form::text('nombre',null,['class'=>'form-control text-capitalize','placeholder'=>'Ingrese el nombre del conductor'])!!}
	</div>	

	<div class="form-group"  >
		{!!Form::label('paterno','Apellido Paterno:')!!}<span ><font color="black" size="5px">*</font></span>
		{!!Form::text('paterno',null,['class'=>'form-control text-capitalize','placeholder'=>'Ingrese el apellido paterno'])!!}
	</div>

	<div class="form-group"  >
		{!!Form::label('materno','Apellido Materno:')!!}<span ><font color="black" size="5px">*</font></span>
		{!!Form::text('materno',null,['class'=>'form-control text-capitalize','placeholder'=>'Ingrese el apellido materno'])!!}
	</div>	

	<div class="form-group">
		{!!Form::label('','Localidad:')!!}<span ><font color="black" size="5px">*</font></span>
		{!!Form::select('localidad', array(
		'LA PAZ' => 'LA PAZ',
		'VALLEGRANDE' => 'VALLEGRANDE',
		'CAMIRI'=>'CAMIRI',
		'MONTERO'=>'MONTERO',
		'YAPACANI'=>'YAPACANI',
		'SANTA CRUZ'=>'SANTA CRUZ'
		),null,array('id'=>'localidad','class'=>'form-control'))!!}
	</div>	

</div>	


<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">

	<div class="form-group">
		{!!Form::label('fecha_nacimiento','Fecha de Nacimiento:')!!} <span ><font color="black" size="5px">*</font></span>          
		<div class='input-group date' id='datetimepicker10'>
			{!!Form::text('fecha_nacimiento','1990-01-01',['id'=>'fecha_nacimiento','class'=>'form-control','maxlength'=>'10','onkeypress'=>'return bloqueo_de_punto(event)','style'=>'font-size:20px;text-align:left'])!!}
			<span class="input-group-addon ">
			  <span class="fa fa-calendar" aria-hidden="true"></span> 
			</span>
		</div>
	</div>	

	<div class="form-group"  >
		{!!Form::label('sexo','Género:')!!}
		{!!Form::select('sexo', array('M' => 'MASCULINO', 'F' => 'FEMENINO'),null,array('class'=>'form-control'))!!}
</div>
<div class="form-group"  >
		{!!Form::label('celular','Celular:')!!}<span ><font color="black" size="5px">*</font></span>
		{!!Form::text('celular',null,['class'=>'form-control','placeholder'=>'Ingrese el celular','maxlength'=>'8','onkeypress'=>'return bloqueo_de_punto(event)'])!!}
	</div>		

	<div class="form-group" hidden="" >
		{!!Form::label('imei','Imei:')!!}
		{!!Form::text('imei',null,['class'=>'form-control','placeholder'=>'Ingrese el imei del celular','maxlength'=>'30'])!!}
	</div>	
	
	
	<div class="form-group"  >
		{!!Form::label('usuario','Usuario:')!!}<span ><font color="black" size="5px">*</font></span>
		{!!Form::text('usuario',null,['class'=>'form-control','placeholder'=>'Ingrese el usuario','maxlength'=>'15','id'=>'usuario'])!!}
	</div>			

	<div class="form-group"  >
		{!!Form::label('contrasenia','Contraseña:')!!}<span ><font color="black" size="5px">*</font></span>
		{!!Form::text('contrasenia',null,['class'=>'form-control','placeholder'=>'Ingrese ls contraseña','maxlength'=>'15','id'=>'contrasenia'])!!}
	</div>		

	<div class="form-group"  hidden="" >
		{!!Form::label('','Monto de garantia:')!!}<span ><font color="black" size="5px">*</font></span>
		{!!Form::number('monto_garantia',0,['class'=>'form-control text-capitalize','placeholder'=>'Ingrese el monto de garantia'])!!}
	</div>		

	 

	<div class="form-group" hidden="" >
		{!!Form::label('','Ahorro:')!!}<span ><font color="black" size="5px">*</font></span>
		{!!Form::number('ahorro',0,['class'=>'form-control text-capitalize','placeholder'=>'Ingrese el monto de ahorro'])!!}
	</div>	

	<div class="form-group" hidden >
		{!!Form::label('','Descripción:')!!}<span ><font color="black" size="5px">*</font></span>
		{!!Form::textarea('descripcion',null,['class'=>'form-control text-capitalize','placeholder'=>'Descripción del conductor','style'=>'height:100px'])!!}
	</div>	
	

	
	
	     
</div>	

<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
<div class="form-group" hidden="">
			{!!Form::label('estado','Estado:')!!}
            {!!Form::select('estado', array('1' => 'ACTIVO', '0' => 'INACTIVO'),null,array('id'=>'estado','class'=>'form-control'))!!}
	</div>

	<div class="form-group">
			{!!Form::label('categoria_licencia','Categoria Licencia:')!!}<span ><font color="black" size="5px">*</font></span>
            {!!Form::select('categoria_licencia', array( 'A' => 'A', 'B' => 'B', 'C' => 'C', 'P' => 'P','M'=>'M'),null,array('id'=>'categoria_licencia','class'=>'form-control'))!!}
	</div>	

	<div class="form-group">
			{!!Form::label('tipo','Tipo de Conductor:')!!}<span ><font color="black" size="5px">*</font></span>
            {!!Form::select('tipo', array('PROPIETARIO' => 'PROPIETARIO','ASALARIADO' => 'ASALARIADO'),null,array('id'=>'tipo','class'=>'form-control'))!!}
	</div>

	<div class="form-group" hidden="">
			{!!Form::label('bloqueo','Bloqueo:')!!}
            {!!Form::select('bloqueo', array('0' => 'DESBLOQUEADO', '1' => 'BLOQUEADO'),null,array('id'=>'bloqueo','class'=>'form-control'))!!}
	</div>	

	<div class="form-group" hidden="">
			{!!Form::label('aceptar_condiciones','Aceptar Condiciones:')!!}
            {!!Form::select('aceptar_condiciones', array('1' => 'SI', '0' => 'NO'),null,array('id'=>'aceptar_condiciones','class'=>'form-control'))!!}
	</div>	

	<div class="form-group"  >
		{!!Form::label('','Credito:')!!}
		{!!Form::text('credito',1000,['class'=>'form-control','placeholder'=>'Ingrese el cblackito','maxlength'=>'5'])!!}
	</div>

	<div class="form-group"  >
		{!!Form::label('direccion','Dirección:')!!}<span ><font color="black" size="5px">*</font></span>
		{!!Form::textarea('direccion',null,['class'=>'form-control text-capitalize','placeholder'=>'Ingrese la dirección','style'=>'height:50px'])!!}
	</div>

	<div class="form-group"  >	
		{!!Form::label('correo','Correo:')!!}
		{!!Form::text('correo',null,['class'=>'form-control','placeholder'=>'Ingrese el correo'])!!}
	</div>	

	@if(Auth::user()->privilegio==1 || Auth::user()->privilegio==10 || Auth::user()->privilegio==11 || Auth::user()->privilegio==11 || Auth::user()->privilegio==12)
	    <div class="form-group" >
			{!!Form::label('','Empresa :')!!}<span ><font color="black" size="5px">*</font></span>
				<select name="id_empresa" class="form-control selectpicker" id="id_empresa" data-live-search="true" >
				        @foreach($empresa as $mov)
				        <option value="{{$mov->id}}">{{$mov->razon_social}}</option>
				        @endforeach
				</select>
		</div>
     @else
     <input name="id_empresa" value="{{Auth::user()->id_empresa}}" type="hidden" />
     @endif  

	
</div>

<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
	
	<div class="form-group">
		{!!Form::label('Foto del Conductor')!!} <br>
	<center><output id="list"></output></center> 
	<img alt="..." class="img-thumbnail" id="imgPerfil" src="{{asset('images/default.jpg')}}" width="200px" height="200px">
    <!--center><img id="logo" src="{{asset('images/usuario.jpg')}}" title="Cargar Imagen" style="cursor:pointer" class="img-circle"></center><br-->
	<input type="file" name="perfil" id="perfil" style="cursor: pointer;" accept="image/*">
</div>	

<div class="form-group">
    {!!Form::label('','Fecha de Ingreso:')!!}<span ><font color="red" size="5px">*</font></span>          
    <div class='input-group date' id='datetimepicker11'>
      <input type='text' value="{{date("Y-m-d")}}" class="form-control" id="fecha_inicio_pago" name="fecha_inicio_pago" style="font-size:20px;text-align:left" />
      <span class="input-group-addon ">
         <span class="fa fa-calendar" aria-hidden="true"></span> 
      </span>
    </div>
  </div>  

<div class="form-group">
	{!!Form::label('tipo_de_pago','Tipo De Pago:')!!}<span ><font color="black" size="5px">*</font></span>
	{!!Form::select('tipo_de_pago', array(
	'SEMANA' => 'SEMANAL',
	'DIA' => 'DIA' ),null,array('id'=>'tipo_de_pago','class'=>'form-control'))!!}
</div>	




</div>

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" >
	<h4 align="left" style="color: black;">DATOS DE REFERENCIA </h4>
	<hr style="background: black; height: 3px;"/>

<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
	<div class="form-group"  >
		{!!Form::label('','C.I.:')!!}<span ><font color="black" size="5px">*</font></span>
		{!!Form::text('ci_referencia',null,['class'=>'form-control text-capitalize','placeholder'=>'Cedula de Identidad'])!!}
	</div>
</div>	

<div class="col-lg-5 col-md-4 col-sm-4 col-xs-12">
	<div class="form-group"  >
		{!!Form::label('','Nombre:')!!}<span ><font color="black" size="5px">*</font></span>
		{!!Form::text('nombre_referencia',null,['class'=>'form-control text-capitalize','placeholder'=>'Ingrese su nombre completo'])!!}
	</div>
</div>
<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
	<div class="form-group"  >
		{!!Form::label('','Parentezco:')!!}<span ><font color="black" size="5px">*</font></span>
		{!!Form::text('parentezco_referencia',null,['class'=>'form-control text-capitalize','placeholder'=>'Esposa | Hermano'])!!}
	</div>
</div>	
<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
	<div class="form-group"  >
		{!!Form::label('','Celular:')!!}<span ><font color="black" size="5px">*</font></span>
		{!!Form::number('celular_parentezco',null,['class'=>'form-control text-capitalize','placeholder'=>'Ingrese su Celular'])!!}
	</div>
</div>	
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	<div class="form-group"  >
		{!!Form::label('','Domicilio:')!!}<span ><font color="black" size="5px">*</font></span>
		{!!Form::text('domicilio_parentezco',null,['class'=>'form-control text-capitalize','placeholder'=>'Ingrese la dirección de su domicilio'])!!}
	</div>
</div>	
</div>







<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" >
	<h4 align="left" style="color: black;">DATOS DEL VEHICULO </h4>
	<hr style="background: black; height: 3px;"/>

	<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">

		{!!Form::label('p','Placa:')!!}<span ><font color="black" size="5px">*</font></span>
					<label id="placa_verificar" hidden="" style="color: black">* Ya existe esa PLACA</label>		
		
			<div class="input-group">
			  <input type="text" class="form-control text-uppercase" placeholder="Ingrese la placa" name="placa" id="placa" maxlength="10"/>
			  <span class="input-group-btn">
				<button class="btn btn-success" onclick="verificar_placa()" type="button">Verificar</button>
			  </span>
			</div>
		 
		
		
			
			 <div class="form-group">
				{!!Form::label('marca','Marca:')!!}<span ><font color="black" size="5px">*</font></span>
				  <div class="input-group">
					<input class="form-control" name="marca" type="text" id="marca" placeholder="Marca">
					
					<div class="input-group-btn">
					  {!!Form::select('marca_aux', array(  'AGRALE' => 'AGRALE', 'ALFA ROMEO' => 'ALFA ROMEO', 'AMC'=>'AMC', 'ASIA'=>'ASIA', 'AUTOCAR'=>'AUTOCAR', 'BARREIRO'=>'BARREIRO', 'BAW'=>'BAW', 'BEIBEN'=>'BEIBEN', 'BEIJING'=>'BEIJING', 'BYD'=>'BYD', 'CDW'=>'CDW', 'CHANA'=>'CHANA', 'CHANGAN'=>'CHANGAN', 'CHERY'=>'CHERY', 'CHEVROLET'=>'CHEVROLET', 'CHRYSLER'=>'CHRYSLER', 'CHTC AUTO'=>'CHTC AUTO', 'CHUNZHOU'=>'CHUNZHOU', 'COMER'=>'COMER', 'DAEWOO'=>'DAEWOO', 'DAIHATSU'=>'DAIHATSU', 'DAIMLER'=>'DAIMLER', 'DALI'=>'DALI', 'DATSUN'=>'DATSUN', 'DETROIT'=>'DETROIT', 'DODGE'=>'DODGE', 'DONG FENG'=>'DONG FENG', 'FARGO'=>'FARGO', 'FAW'=>'FAW', 'FEDERAL'=>'FEDERAL', 'FENG YANG'=>'FENG YANG', 'FIAT'=>'FIAT', 'FORD'=>'FORD', 'FORLAND'=>'FORLAND', 'FOTON'=>'FOTON', 'FREIGHTLINER'=>'FREIGHTLINER', 'GAC GONOW'=>'GAC GONOW', 'GEELY'=>'GEELY', 'GEO'=>'GEO', 'GMC'=>'GMC', 'GOLDEN DRAGON'=>'GOLDEN DRAGON', 'GREAT WALL'=>'GREAT WALL', 'HAIMA'=>'HAIMA', 'HIGER'=>'HIGER', 'HILLMAN'=>'HILLMAN', 'HINO'=>'HINO', 'HONDA'=>'HONDA', 'HONDA CIVIC'=>'HONDA CIVIC', 'HYUNDAI'=>'HYUNDAI', 'INTERNATIONAL'=>'INTERNATIONAL', 'ISUZU'=>'ISUZU', 'IVECO'=>'IVECO', 'JAC'=>'JAC', 'JEEP'=>'JEEP', 'JIN BEI'=>'JIN BEI', 'JINCHENG'=>'JINCHENG', 'JOYLONG'=>'JOYLONG', 'KAISER'=>'KAISER', 'KAMA'=>'KAMA', 'KAMAZ'=>'KAMAZ', 'KENWORTH'=>'KENWORTH', 'KEYTON'=>'KEYTON', 'KIA'=>'KIA', 'KING LONG'=>'KING LONG', 'KINGSTAR'=>'KINGSTAR', 'LADA'=>'LADA', 'LAND ROVER'=>'LAND ROVER', 'LEYLAND'=>'LEYLAND', 'LIFAN'=>'LIFAN', 'MACK'=>'MACK', 'MAN'=>'MAN', 'MAZDA'=>'MAZDA', 'MEIYA'=>'MEIYA', 'MERCEDES BENZ'=>'MERCEDES BENZ', 'MERCURY'=>'MERCURY', 'MITSUBISHI'=>'MITSUBISHI', 'MITSUBISHI FUSO'=>'MITSUBISHI FUSO', 'MORRIS'=>'MORRIS', 'N/E'=>'N/E', 'NISSAN'=>'NISSAN', 'NISSAN DIESEL'=>'NISSAN DIESEL', 'OPEL'=>'OPEL', 'OTRO'=>'OTRO', 'PETERBILT'=>'PETERBILT', 'PEUGEOT'=>'PEUGEOT', 'PLYMOUTH'=>'PLYMOUTH', 'POLARSUN'=>'POLARSUN', 'POLONEZ'=>'POLONEZ', 'POWLION'=>'POWLION', 'RAMBLER'=>'RAMBLER', 'RENAULT'=>'RENAULT', 'REO'=>'REO', 'SAMSUNG'=>'SAMSUNG', 'SAURER'=>'SAURER', 'SCANIA'=>'SCANIA', 'SCION'=>'SCION', 'SEAT'=>'SEAT', 'SIMCA'=>'SIMCA', 'SINOTRUK'=>'SINOTRUK', 'SKODA'=>'SKODA', 'SOUEAST'=>'SOUEAST', 'SSANG YONG'=>'SSANG YONG', 'STEYR'=>'STEYR', 'STUDEBAKER'=>'STUDEBAKER', 'SUBARU'=>'SUBARU', 'SUNLONG'=>'SUNLONG', 'SUZUKI'=>'SUZUKI', 'T-KING'=>'T-KING', 'TONGJIA'=>'TONGJIA', 'TOYOTA'=>'TOYOTA', 'UAZ'=>'UAZ', 'UD'=>'UD', 'URAL'=>'URAL', 'VICTORY'=>'VICTORY', 'VOLGA'=>'VOLGA', 'VOLKSWAGEN'=>'VOLKSWAGEN', 'VOLVO'=>'VOLVO', 'WAW'=>'WAW', 'WHITE'=>'WHITE', 'WHITEGMC'=>'WHITEGMC', 'WILLYS'=>'WILLYS', 'WINGS'=>'WINGS', 'YUEJIN'=>'YUEJIN', 'ZOTYE'=>'ZOTYE'),null,array('id'=>'marca_aux','class'=>'form-control','onchange'=>'seleccionar_marca();'))!!}
					</div>
					
				  </div>
			</div>
		
			<div class="form-group">
					{!!Form::label('modelo','Modelo:')!!}<span ><font color="black" size="5px">*</font></span>
					{!!Form::text('modelo',null,['class'=>'form-control','placeholder'=>'Ingrese el modelo','maxlength'=>'4', 'onkeypress'=>'return bloqueo_de_punto(event)'])!!}
			</div>
		
			<div class="form-group">
					{!!Form::label('tipo','Tipo:')!!}<span ><font color="black" size="5px">*</font></span>
					{!!Form::text('tipo',null,['class'=>'form-control','placeholder'=>'Ingrese el tipo','maxlength'=>'15'])!!}
			</div>		
		
			<div class="form-group">
					{!!Form::label('color','Color:')!!}<span ><font color="black" size="5px">*</font></span>
					{!!Form::text('color',null,['class'=>'form-control','placeholder'=>'Ingrese el color','maxlength'=>'20'])!!}
			</div>
		
			<div class="form-group">
					{!!Form::label('clase','Clase de Vehiculo:')!!}<span ><font color="black" size="5px">*</font></span>
			  <div class="input-group">
				<input class="form-control" name="clase" type="text" id="clase" placeholder="Clase de Vehículo">
				
				<div class="input-group-btn">
				  {!!Form::select('clase_aux', array(  'AUTOMOVIL' => 'AUTOMOVIL','MOTO'=>'MOTO', 'VAGONETA'=>'VAGONETA','SEMI VAGONETA'=>'SEMI VAGONETA','OTROS'=>'OTROS' ),null,array('id'=>'clase_aux','class'=>'form-control','onchange'=>'seleccionar_clase();' ))!!}
					
				</div>
				
			  </div>
			 </div>
	</div>

			 <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">

				<div class="form-group">
					{!!Form::label('','Numero Movil:')!!}<span ><font color="black" size="5px">*</font></span>
					  <div class="input-group">
						<input class="form-control" name="numero_movil" type="text" id="numero_movil" placeholder="Numero de Movil">
						
						<div class="input-group-btn">
							<select name="numero_movil_aux" class="form-control selectpicker" id="numero_movil_aux" data-live-search="true"  onchange="seleccionar_numero_movil();">
								@foreach($numero_movil as $mov)
								<option value="{{$mov->numero_movil}}">{{$mov->numero_movil}}</option>
								@endforeach
						</select>
						</div>
						
					  </div>
				</div>
		
				

			 <div class="form-group">
				{!!Form::label('nro_soat','Nro de Soat:')!!}
				{!!Form::text('nro_soat',0,['class'=>'form-control','placeholder'=>'Ingrese el nro de soat','maxlength'=>'50', 'onkeypress'=>'return bloqueo_de_punto(event)'])!!}
			</div>

			<div class="form-group">
				{!!Form::label('nro_inspeccion_tecnica','Nro de Inspección Técnica:')!!}
				{!!Form::text('nro_inspeccion_tecnica',0,['class'=>'form-control','placeholder'=>'Ingrese el nro de inspeccion tecnica','maxlength'=>'255', 'onkeypress'=>'return bloqueo_de_punto(event)'])!!}
			</div>
		
 
		
			 <div class="panel-group" hidden>
				<div class="panel panel-default">
				  <div class="panel-body">
					<div class="funkyradio"  >
					  <div class="funkyradio-primary"  onclick="ver_datos_vehiculo();"  >
						  <input type="radio" name="moto" id="vehiculo_2" value="0" checked=""  />
						  <label for="vehiculo_2">Vehículo</label>
					  </div>
					  <div class="funkyradio-success" onclick="ver_datos_vehiculo();">
						  <input type="radio" name="moto" id="moto_2"   value="1"   />
						  <label for="moto_2" >Moto</label>
					  </div>
					</div>
				  </div>
				</div>
			</div>
		
			<div class="well" id="div_caracteristicas"  hidden>
			<label>Caracteristicas:</label>
		
			<div class="form-group">
				<input type="checkbox" id="movil"   name="movil" checked="true"  />
				<label for="movil" ><span></span>Normal</label>
			</div>
			<div class="form-group">
				<input type="checkbox" id="maletero_libre" name="maletero_libre"  />
				<label for="maletero_libre"><span></span>Vagoneta</label>
			</div>
			<div class="form-group">
				<input type="checkbox" id="parrilla" name="parrilla"  />
				<label for="parrilla"><span></span>Con Parrilla</label>
			</div>
			<div class="form-group">
				<input type="checkbox" id="camioneta" name="camioneta"  />
				<label for="camioneta"><span></span>Vagoneta</label>
			</div>
		
			<div class="form-group"  >
				<input type="checkbox" id="lujo" name="lujo"   />
				<label for="lujo"><span></span>VIP</label>
			</div>
		
			<div class="form-group"  >
				<input type="checkbox" id="aire" name="aire"  />
				<label for="aire"><span></span>Con aire</label>
			</div>
		
			
			</div>
			
		 

			
	<div class="form-group" >
		{!!Form::label('nro_chasis','Nro de Chasis:')!!}
		{!!Form::text('nro_chasis',0,['class'=>'form-control','placeholder'=>'Ingrese el nro de chasis','maxlength'=>'255'])!!}

		</div>	
		 
		</div>



		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
	
			<div class="form-group">
				{!!Form::label('Foto del Vehiculo')!!} <br>
			<center><output id="listVehiculo"></output></center> 
			<img alt="..." class="img-thumbnail" id="imgVehiculo" src="{{asset('images/default.jpg')}}" width="400px" height="400px">
			<input type="file" name="fotoVehiculo" id="fotoVehiculo" style="cursor: pointer;" accept="image/*">
			</div>	
		</div>	
		
</div>


<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" hidden>

{!!Form::label('domicilio','Ubicacion de su Domicilio :')!!}<span ><font color="black" size="5px">*</font></span>
    <input id="pac-input" class="controls" type="text" placeholder="Search Box" class="form-control">
    <div id="map" style=" height: 550px;"></div>
</div>	

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
 
	<font align="left" style="color: black" hidden=""><b>DOCUMENTOS DEL CONDUCTOR</b></font>       
</div>	

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" hidden="">
	<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
		<table class="table table-striped table-bodeblack table-condensed table-hover" style="background: white">
			<thead style="background: #635234; color: white">
				<th>Cedula de Identidad C.I.</th>
				<th><button type="button" class="btn-sm btn-info pull-right" onclick="Agregar_Imagen_Carnet()"><i class="fa fa-plus-square" aria-hidden="true"></i></button></th>
			</thead>
			<tbody id="lista_fotocopia"></tbody>  
		</table> 
	</div>	

	<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
		<table class="table table-striped table-bodeblack table-condensed table-hover" style="background: white">
			<thead style="background: #635234; color: white">
				<th>Licencia de Conducir</th>
				<th><button type="button" class="btn-sm btn-info pull-right" onclick="Agregar_Imagen_Licencia()"><i class="fa fa-plus-square" aria-hidden="true"></i></button></th>
			</thead>
			<tbody id="lista_licencia"></tbody>  
		</table> 
	</div>	

	<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
		<table class="table table-striped table-bodeblack table-condensed table-hover" style="background: white">
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
		<table class="table table-striped table-bodeblack table-condensed table-hover" style="background: white">
			<thead style="background: #635234; color: white">
				<th>Tarjeta de Identificación de Transito</th>
				<th><button type="button" class="btn-sm btn-info pull-right" onclick="Agregar_Imagen_Identificacion_Transito()"><i class="fa fa-plus-square" aria-hidden="true"></i></button></th>
			</thead>
			<tbody id="lista_identificacion_transito"></tbody>  
		</table> 
	</div>	
	<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
		<table class="table table-striped table-bodeblack table-condensed table-hover" style="background: white">
			<thead style="background: #635234; color: white">
				<th>Factura de Agua o Luz</th>
				<th><button type="button" class="btn-sm btn-info pull-right" onclick="Agregar_Imagen_Agua_Luz()"><i class="fa fa-plus-square" aria-hidden="true"></i></button></th>
			</thead>
			<tbody id="lista_agua_luz"></tbody>  
		</table> 
	</div>	
	<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
		<table class="table table-striped table-bodeblack table-condensed table-hover" style="background: white">
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
		<table class="table table-striped table-bodeblack table-condensed table-hover" style="background: white">
			<thead style="background: #635234; color: white">
				<th>Certificado de Antecedentes de la FELCC</th>
				<th><button type="button" class="btn-sm btn-info pull-right" onclick="Agregar_Antecendente_FELCC()"><i class="fa fa-plus-square" aria-hidden="true"></i></button></th>
			</thead>
			<tbody id="lista_antecedente_felcc"></tbody>  
		</table> 
	</div>					
</div>	
<div class="form-group" hidden="">
	{!!Form::label('clasificacion_vehiculo','Clasificación de Vehiculo:')!!}
	{!!Form::select('clasificacion_vehiculo', array('Radio Movil'=>'Radio Movil'),null,array('id'=>'clasificacion_vehiculo','class'=>'form-control'))!!}
</div>


{!!Form::hidden('latitud',null,['class'=>'form-control','placeholder'=>'Ingrese la latitud','maxlength'=>'30'])!!}
{!!Form::hidden('longitud',null,['class'=>'form-control','placeholder'=>'Ingrese la longitud','maxlength'=>'30'])!!}


<input type="hidden" name="login" id="login" value="0">
<input type="hidden" name="token" id="token" value="0">
<input type="hidden" name="direccion_imagen" id="direccion_imagen" value="0">
