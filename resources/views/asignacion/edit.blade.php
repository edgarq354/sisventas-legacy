@extends ('layouts.inicio')
@section ('contenido')
@include('alerts.success')


<script type="text/javascript">
	
	function cargar_placa(){
		$("#placa").val($("#placa1").val());
	}
</script>

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	    @include('alerts.request')
	<h3 align="left">ACTUALIZAR LA ASIGNACION DEL CONDUCTOR - VEHICULO</h3>	

@foreach($asignacion as $asi)
	    {{Form::open(array('url' => 'Actualizar_Asignacion','onKeypress'=>'if(event.keyCode == 13) event.returnValue = false;','enctype'=>'multipart/form-data'))}}     




		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
			
			
          <div class="input-group">
	      <select name="ci" class="form-control selectpicker text-uppercase" id="ci" data-live-search="true" >
					     <option value="{{$asi->ci}}">  {{$asi->ci}}</option>
					        @foreach($buscar_conductor as $mov)
					        <option value="{{$mov->ci}}">{{$mov->ci}} {{$mov->expedido}}  </option>
					        @endforeach
					    </select>
	      <span class="input-group-btn">
	        <button class="btn btn-success" onclick="verificar_ci_conductor()" type="button">Verificar</button>
	      </span>
      	</div>


		


			<div class="form-group" >
				{!!Form::label('nombre','Nombre del Conductor:')!!}
				{!!Form::text('nombre',$asi->nombre,['class'=>'form-control','readonly'=>'Ingrese el nombre del conductor','maxlength'=>'15'])!!}
			</div>	

			<div class="form-group"  >
				{!!Form::label('paterno','Apellido Paterno:')!!}
				{!!Form::text('paterno',$asi->paterno,['class'=>'form-control','readonly'=>'Ingrese el apellido paterno','maxlength'=>'20'])!!}
			</div>

			<div class="form-group"  >
				{!!Form::label('materno','Apellido Materno:')!!}
				{!!Form::text('materno',$asi->materno,['class'=>'form-control','readonly'=>'Ingrese el apellido materno','maxlength'=>'20'])!!}
			</div>	

			<div class="form-group">
				{!!Form::label('fecha_nacimiento','Fecha de Nacimiento:')!!}              
				{!!Form::text('fecha_nacimiento',$asi->fecha_nacimiento,['class'=>'form-control','readonly'=>'Ingrese el apellido materno','maxlength'=>'20'])!!}
			</div>	


			<div class="form-group"  >
				{!!Form::label('celular','Celular:')!!}
				{!!Form::text('celular',$asi->celular,['class'=>'form-control','readonly'=>'Ingrese el celular','maxlength'=>'8'])!!}
			</div>		
			
			<div class="form-group"  >
				{!!Form::label('correo','Correo:')!!}
				{!!Form::text('correo',$asi->correo,['class'=>'form-control','readonly'=>'Ingrese el correo','maxlength'=>'30'])!!}
			</div>	

			<div class="form-group"  >
				{!!Form::label('categoria_licencia','Categoria Licencia:')!!}
				{!!Form::text('categoria_licencia',$asi->categoria_licencia,['class'=>'form-control','readonly'=>'Ingrese el correo','maxlength'=>'30'])!!}
			</div>				
		</div>	

		<input type="hidden" name="placa" id="placa" value="{{$asi->placa}}">
		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
		
		<div class="input-group">
		
      <select name="placa1" onchange="cargar_placa();"  class="form-control selectpicker text-uppercase" id="placa1" data-live-search="true" >
		<option value="{{$asi->placa}}"  > {{$asi->placa}}</option>
		 @foreach($buscar_vehiculo as $mov)
		 <option value="{{$mov->placa}}" >{{$mov->placa}} - {{$mov->marca}}  </option>
		 @endforeach
		</select>


      <span class="input-group-btn">
        <button class="btn btn-success" onclick="verificar_placa()" type="button">Verificar</button>
      </span>
    </div>

			<div class="form-group">
					{!!Form::label('marca','Marca:')!!}
					{!!Form::text('marca',$asi->marca,['class'=>'form-control','readonly'=>'Ingrese la placa','maxlength'=>'20'])!!}
			</div>

			<div class="form-group">
					{!!Form::label('modelo','Modelo:')!!}
					{!!Form::text('modelo',$asi->modelo,['class'=>'form-control','readonly'=>'Ingrese el modelo','maxlength'=>'4', 'onkeypress'=>'return bloqueo_de_punto(event)'])!!}
			</div>

			<div class="form-group">
					{!!Form::label('color','Color:')!!}
					{!!Form::text('color',$asi->color,['class'=>'form-control','readonly'=>'Ingrese el color','maxlength'=>'20'])!!}
			</div>

			<div class="form-group">
					{!!Form::label('tipo','Tipo:')!!}
					{!!Form::text('tipo',$asi->tipo,['class'=>'form-control','readonly'=>'Ingrese el tipo','maxlength'=>'15'])!!}
			</div>		

			<div class="form-group">
					{!!Form::label('clase','Clase de Vehiculo:')!!}
					{!!Form::text('clase',$asi->clase,['class'=>'form-control','readonly'=>'Ingrese el tipo','maxlength'=>'15'])!!}	
			</div>

			<div class="form-group">
					{!!Form::label('nro_chasis','Nro de Chasis:')!!}
					{!!Form::text('nro_chasis',$asi->nro_chasis,['class'=>'form-control','readonly'=>'Ingrese el nro de chasis','maxlength'=>'15'])!!}
			</div>	

			<div class="form-group">
					{!!Form::label('nro_soat','Nro de Soat:')!!}
					{!!Form::text('nro_soat',$asi->nro_soat,['class'=>'form-control','readonly'=>'Ingrese el nro de soat','maxlength'=>'50', 'onkeypress'=>'return bloqueo_de_punto(event)'])!!}
			</div>
				
		</div>


		<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
		 <div class="form-group">
			<label>
			<font color="red" size="5px">*</font></span>Codigo Empresa.<br>
			<font color="red" size="5px">*</font></span>Codigo Movil<br>
			<font color="red" size="5px">*</font></span>GEA.
			</label>
			{!!Form::text('codigo_empresa',$asi->codigo_empresa,['class'=>'form-control text-uppercase' ,'placeholder'=>'Ingrese el Código Empresa','maxlength'=>'15'])!!}
			
			</div>

			<div class="form-group" >
			{!!Form::label('estado','Estado:')!!}
            {!!Form::select('estado', array('1' => 'ACTIVO', '0' => 'OBSERVADO','2' => 'INACTIVO'),$asi->estado,array('class'=>'form-control'))!!}
			</div>	


		   @if(Auth::user()->privilegio==1 || Auth::user()->privilegio==10 || Auth::user()->privilegio==11 || Auth::user()->privilegio==11 || Auth::user()->privilegio==12)
		   <div class="form-group" >
		        {!!Form::label('','Empresa :')!!}<span ><font color="red" size="5px">*</font></span>
		            <select name="id_empresa" class="form-control selectpicker" id="id_empresa" data-live-search="true" >
		                    <option value="{{$asi->id_empresa}}" ></option>
		                    @foreach($empresa as $mov)
		                     @if($asi->id_empresa==$mov->id) 
		                    <option value="{{$mov->id}}" selected="" > {{$mov->razon_social}}</option>
		                    @endif
		                     <option value="{{$mov->id}}" >   {{$mov->razon_social}}</option>
		                    @endforeach
		            </select>
		    </div>
		     @else
		     <input name="id_empresa" value="{{$asi->id_empresa}}" type="hidden" />
		     @endif 


		</div>


		<input type="hidden" name="latitud" id="latitud" value="0">
		<input type="hidden" name="longitud" id="longitud" value="0">


	</div>	




    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div align="right">
			{!!Form::submit('ACTUALIZAR',['class'=>'btn btn-primary','id'=>'btn_actualizar','onclick'=>'btn_esconder()'])!!} 
			<a href="{!!URL::to('asignacion')!!}" class="btn btn-danger">CANCELAR</a>
			<?php //{!!Form::reset('CANCELAR',['class'=>'btn btn-danger'])!!} ?>
		</div>
	</div>

	</form>
@endforeach
   {!!Html::script('js/asignacion_actualizar.js')!!}

</div>
	@endsection