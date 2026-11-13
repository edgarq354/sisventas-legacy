@extends ('layouts.inicio')
@section ('contenido')
@include('alerts.success')
@include('alerts.request')
@include('alerts.errors')
	

	<div class="row">	

	 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 well">

  <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
	{!!Form::open(['route'=>'empleado.store', 'method'=>'POST' , 'enctype'=>'multipart/form-data','onKeypress'=>'if(event.keyCode == 13) event.returnValue = false;'])!!} 

	<font size="6">{{ __('empleado.titulo_empleado') }}</font>
	 
		 
            <div class = "form-group">
               <input type = "text" class = "form-control" name="ci" id="ci" placeholder="{{ __('empleado.placeholder_ci') }}" onkeypress="return bloqueo_de_punto(event);">
             </div><!-- /input-group -->
       
         
	  
 
	<div class="form-group" >
		{!!Form::label('',__('empleado.expedido_dp'))!!}<span ><font color="red" size="5px">*</font></span>
	{!!Form::select('expedido', array( 'SC' => 'SANTA CRUZ', 'CB' => 'COCHABAMBA', 'PT' => 'POTOSI','LP' => 'LA PAZ', 'TJ' => 'TARIJA', 'OR' => 'ORURO', 'BN' => 'BENI', 'PD' => 'PANDO', 'CH' => 'CHUQUISACA', 'EX' => 'EXTRANJERO'),null,array('id'=>'expedido','class'=>'custom-select form-control dropdown-toggle','data-toggle' => 'dropdown'))!!}
	</div>
	  <div class="form-group">
	    {{ __('empleado.nombre_dp') }}<br>
	    <input  name="nombre" placeholder="{{ __('empleado.placeholder_nombre') }}" class="form-control" id="nombre" value="" >
	  </div>
	  <div class="form-group">
	    {{ __('empleado.paterno_dp') }}<br>
	    <input  name="paterno" placeholder="{{ __('empleado.placeholder_paterno') }}" class="form-control" id="paterno" value="" >
	  </div>
	  <div class="form-group">
	    {{ __('empleado.materno_dp') }}<br>
	    <input  name="materno" placeholder="{{ __('empleado.placeholder_materno') }}" class="form-control" id="materno" value="" >
	  </div>

</div>
  <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
  	  <div class="form-group">
	    {{ __('empleado.celular_dp') }}<br>
	    <input  name="celular" placeholder="{{ __('empleado.placeholder_celular') }}" class="form-control" id="celular" value="" >
	  </div>
	   
	    <input type="hidden"  name="garante" placeholder="Ingrese el garante" class="form-control" id="garante" value="" >
	 
	  <div class="form-group"  >
		{!!Form::label(' ',__('empleado.cargo_dp'))!!} 
		{!!Form::text('cargo',null,['class'=>'form-control','placeholder'=>__('empleado.placeholder_cargo'),'maxlength'=>'50' ])!!}
	</div>
	  <div class="form-group"  >
		{!!Form::label('direccion',__('empleado.direccion_dp'))!!} 
		{!!Form::textarea('direccion',null,['class'=>'form-control','placeholder'=>__('empleado.placeholder_direccion'),'maxlength'=>'50','style'=>'height:100px;'])!!}
	</div>
  	  <div class="form-group">
		{!!Form::label('fecha_nacimiento',__('empleado.fecha_nacimiento_dp'))!!} <span ><font color="red" size="5px">*</font></span>          
		<div class='input-group date' id='datetimepicker10'>
			{!!Form::text('fecha_nacimiento','1990-01-01',['id'=>'fecha_nacimiento','class'=>'form-control','maxlength'=>'10','onkeypress'=>'return bloqueo_de_punto(event)','style'=>'font-size:20px;text-align:left'])!!}
			<span class="input-group-addon ">
			  <span class="fa fa-calendar" aria-hidden="true"></span> 
			</span>
		</div>
	</div>	

           





       
 <div align="left">

      {!!Form::submit(__('empleado.registrar'),['class'=>'btn btn-primary','id'=>'btn_registrar','onclick'=>'btn_esconder()'])!!}

    </div>
</div>


    </form>
    
  </div>







		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="table-responsive" style="overflow-x:inherit">	
		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
			<font size="6">{{ __('empleado.titulo_conductor') }}</font>
		</div>


		

		 

				<table class="table table-striped table-bordered table-condensed table-hover" id="myTable" style="background: white">
					<thead>
						<th><center>{{ __('empleado.col_ci') }}</center></th>
						<th><center>{{ __('empleado.col_nombre') }}</center></th>
						<th><center>{{ __('empleado.col_cargo') }}</center></th>
						<th><center>{{ __('empleado.col_fecha_nacimiento') }}</center></th>
						<th><center>{{ __('empleado.col_opcion') }}</center></th>
						
					</thead>

					<tbody align="center" id="body_conductor">					
					@foreach($empleado as $con)
					<tr>
						<td>{{ $con->ci}} {{ $con->expedido}}</td>
						<td>{{ $con->nombre}} {{ $con->paterno}} {{ $con->materno}}</td>
						<td>{{ $con->fecha_nacimiento}}</td>
						
					</tr>
					@endforeach
					</tbody>

					<tbody align="center" id="body_empleado_2">
					</tbody>					
				</table>

	<div class="pull-left">	{!!$empleado->render()!!}  </div>
	<div class="pull-right">	<button class="btn btn-default" id="mostrar" onclick="ver_todos()"><b>{{ __('empleado.ver_todos') }}</b></button>  </div>
			</div>
		</div>
	</div>

   {!!Html::script('js/conductor.js')!!}
@endsection
