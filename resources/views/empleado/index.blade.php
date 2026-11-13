@extends ('layouts.inicio')
@section ('contenido')
@include('alerts.success')
@include('alerts.request')
@include('alerts.errors')
	

	<div class="row">	

	 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 well">

  <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
	{!!Form::open(['route'=>'empleado.store', 'method'=>'POST' , 'enctype'=>'multipart/form-data','onKeypress'=>'if(event.keyCode == 13) event.returnValue = false;'])!!} 

	<font size="6">Empleado</font>
	 
		 
            <div class = "form-group">
               <input type = "text" class = "form-control" name="ci" id="ci" placeholder="C.I. del Conductor" onkeypress="return bloqueo_de_punto(event);">
             </div><!-- /input-group -->
       
         
	  
 
	<div class="form-group" >
		{!!Form::label('','Expedido:')!!}<span ><font color="red" size="5px">*</font></span>
	{!!Form::select('expedido', array( 'SC' => 'SANTA CRUZ', 'CB' => 'COCHABAMBA', 'PT' => 'POTOSI','LP' => 'LA PAZ', 'TJ' => 'TARIJA', 'OR' => 'ORURO', 'BN' => 'BENI', 'PD' => 'PANDO', 'CH' => 'CHUQUISACA', 'EX' => 'EXTRANJERO'),null,array('id'=>'expedido','class'=>'custom-select form-control dropdown-toggle','data-toggle' => 'dropdown'))!!}
	</div>
	  <div class="form-group">
	    Nombre:<br>
	    <input  name="nombre" placeholder="Ingrese el Nombre" class="form-control" id="nombre" value="" >
	  </div>
	  <div class="form-group">
	    Paterno:<br>
	    <input  name="paterno" placeholder="Apellido Paterno" class="form-control" id="paterno" value="" >
	  </div>
	  <div class="form-group">
	    Materno:<br>
	    <input  name="materno" placeholder="Apellido Materno" class="form-control" id="materno" value="" >
	  </div>

</div>
  <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
  	  <div class="form-group">
	    Celular:<br>
	    <input  name="celular" placeholder="Ingrese su celular" class="form-control" id="celular" value="" >
	  </div>
	   
	    <input type="hidden"  name="garante" placeholder="Ingrese el garante" class="form-control" id="garante" value="" >
	 
	  <div class="form-group"  >
		{!!Form::label(' ','Cargo:')!!} 
		{!!Form::text('cargo',null,['class'=>'form-control','placeholder'=>'Ingrese el cargo','maxlength'=>'50' ])!!}
	</div>
	  <div class="form-group"  >
		{!!Form::label('direccion','Dirección:')!!} 
		{!!Form::textarea('direccion',null,['class'=>'form-control','placeholder'=>'Ingrese la dirección','maxlength'=>'50','style'=>'height:100px;'])!!}
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

           





       
 <div align="left">

      {!!Form::submit('REGISTRAR',['class'=>'btn btn-primary','id'=>'btn_registrar','onclick'=>'btn_esconder()'])!!}

    </div>
</div>


    </form>
    
  </div>







		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="table-responsive" style="overflow-x:inherit">	
		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
			<font size="6">CONDUCTOR</font>
		</div>


		

		 

				<table class="table table-striped table-bordered table-condensed table-hover" id="myTable" style="background: white">
					<thead>
						<th><center>CI</center></th>
						<th><center>NOMBRE</center></th>
						<th><center>CARGO</center></th>
						<th><center>FECHA NACIMIENTO</center></th>
						<th><center>OPCION</center></th>
						
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
	<div class="pull-right">	<button class="btn btn-default" id="mostrar" onclick="ver_todos()"><b>VER TODOS</b></button>  </div>
			</div>
		</div>
	</div>

   {!!Html::script('js/conductor.js')!!}
@endsection
