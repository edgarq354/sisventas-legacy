<script type="text/javascript">
	
	function cargar_placa(){
		$("#placa").val($("#placa1").val());
	}
</script>


<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
	<div class="pull-left">
		{!!Form::label('ci','Cedula de Identidad:')!!}<span ><font color="red" size="5px">*</font></span>
					
	</div>
	

       <div class="input-group">
	      <select name="ci" class="form-control selectpicker text-uppercase" id="ci" data-live-search="true" >
					     <option value="">  Buscar el conductor . .</option>
					        @foreach($conductor as $mov)
					        <option value="{{$mov->ci}}">{{$mov->ci}} {{$mov->expedido}}  </option>
					        @endforeach
					    </select>
	      <span class="input-group-btn">
	        <button class="btn btn-success" onclick="verificar_ci_conductor()" type="button">Verificar</button>
	      </span>
      </div>

	<br>

	<div class="form-group" >
		{!!Form::label('nombre','Nombre del Conductor:')!!}
		{!!Form::text('nombre',null,['class'=>'form-control','readonly'=>'Ingrese el nombre del conductor','maxlength'=>'15'])!!}
	</div>	

	<div class="form-group"  >
		{!!Form::label('paterno','Apellido Paterno:')!!}
		{!!Form::text('paterno',null,['class'=>'form-control','readonly'=>'Ingrese el apellido paterno','maxlength'=>'20'])!!}
	</div>

	<div class="form-group"  >
		{!!Form::label('materno','Apellido Materno:')!!}
		{!!Form::text('materno',null,['class'=>'form-control','readonly'=>'Ingrese el apellido materno','maxlength'=>'20'])!!}
	</div>	

	<div class="form-group">
		{!!Form::label('fecha_nacimiento','Fecha de Nacimiento:')!!}              
		{!!Form::text('fecha_nacimiento',null,['class'=>'form-control','readonly'=>'Ingrese el apellido materno','maxlength'=>'20'])!!}
	</div>	


	<div class="form-group"  >
		{!!Form::label('celular','Celular:')!!}
		{!!Form::text('celular',null,['class'=>'form-control','readonly'=>'Ingrese el celular','maxlength'=>'8'])!!}
	</div>		
	
	<div class="form-group"  >
		{!!Form::label('correo','Correo:')!!}
		{!!Form::text('correo',null,['class'=>'form-control','readonly'=>'Ingrese el correo','maxlength'=>'30'])!!}
	</div>	

	<div class="form-group"  >
		{!!Form::label('categoria_licencia','Categoria Licencia:')!!}
		{!!Form::text('categoria_licencia',null,['class'=>'form-control','readonly'=>'Ingrese el correo','maxlength'=>'30'])!!}
	</div>				
</div>	


<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">


	<div class="form-group">
		<div class="pull-left">
			{!!Form::label('placa','Placa:')!!}<span ><font color="red" size="5px">*</font></span>
			</div>
	</div>
	<div class="form-group">
	<input type="hidden" name="placa" id="placa">
	</div>

	<div class="input-group">
		
      <select name="placa1" onchange="cargar_placa();"  class="form-control selectpicker text-uppercase" id="placa1" data-live-search="true" >
		<option value=""  >  Buscar vehiculo . .</option>
		 @foreach($vehiculo as $mov)
		 <option value="{{$mov->placa}}" >{{$mov->placa}} - {{$mov->marca}}  </option>
		 @endforeach
		</select>
      <span class="input-group-btn">
        <button class="btn btn-success" onclick="verificar_placa()" type="button">Verificar</button>
      </span>
    </div>

	<div class="form-group">
			{!!Form::label('marca','Marca:')!!}
			{!!Form::text('marca',null,['class'=>'form-control','readonly'=>'Ingrese la placa','maxlength'=>'20'])!!}
	</div>

	<div class="form-group">
			{!!Form::label('modelo','Modelo:')!!}
			{!!Form::text('modelo',null,['class'=>'form-control','readonly'=>'Ingrese el modelo','maxlength'=>'4', 'onkeypress'=>'return bloqueo_de_punto(event)'])!!}
	</div>

	<div class="form-group">
			{!!Form::label('color','Color:')!!}
			{!!Form::text('color',null,['class'=>'form-control','readonly'=>'Ingrese el color','maxlength'=>'20'])!!}
	</div>

	<div class="form-group">
			{!!Form::label('tipo','Tipo:')!!}
			{!!Form::text('tipo',null,['class'=>'form-control','readonly'=>'Ingrese el tipo','maxlength'=>'15'])!!}
	</div>		

	<div class="form-group">
			{!!Form::label('clase','Clase de Vehiculo:')!!}
			{!!Form::text('clase',null,['class'=>'form-control','readonly'=>'Ingrese el tipo','maxlength'=>'15'])!!}	
	</div>

	<div class="form-group">
			{!!Form::label('nro_chasis','Nro de Chasis:')!!}
			{!!Form::text('nro_chasis',null,['class'=>'form-control','readonly'=>'Ingrese el nro de chasis','maxlength'=>'15'])!!}
	</div>	

	<div class="form-group">
			{!!Form::label('nro_soat','Nro de Soat:')!!}
			{!!Form::text('nro_soat',null,['class'=>'form-control','readonly'=>'Ingrese el nro de soat','maxlength'=>'50', 'onkeypress'=>'return bloqueo_de_punto(event)'])!!}
	</div>
		
</div>


<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
	<div class="form-group">
			<label>
			<font color="red" size="5px">*</font></span>Codigo Empresa.<br>
			<font color="red" size="5px">*</font></span>Codigo Movil<br>
			<font color="red" size="5px">*</font></span>GEA.
			</label>
			{!!Form::text('codigo_empresa',null,['class'=>'form-control text-uppercase','placeholder'=>'Ingrese el Código Empresa','maxlength'=>'15'])!!}
	</div>

	<div class="form-group" hidden="">
			{!!Form::label('estado','Estado:')!!}
            {!!Form::select('estado', array('1' => 'ACTIVO', '0' => 'INACTIVO'),null,array('class'=>'form-control'))!!}
	</div>	

		@if(Auth::user()->privilegio==1 || Auth::user()->privilegio==10 || Auth::user()->privilegio==11 || Auth::user()->privilegio==11 || Auth::user()->privilegio==12)
	    <div class="form-group" >
			{!!Form::label('','Empresa :')!!}<span ><font color="red" size="5px">*</font></span>
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



<input type="hidden" name="latitud" id="latitud" value="0">
<input type="hidden" name="longitud" id="longitud" value="0">