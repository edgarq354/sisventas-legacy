@extends ('layouts.inicio')
@section ('contenido')
@include('alerts.success')
@include('alerts.request')
@include('alerts.errors')
	
	
	<div class="row">
<!--Registrar pago de empleados-->
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 well">

  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
{!!Form::open(['route'=>'contrato.store', 'method'=>'POST' , 'enctype'=>'multipart/form-data','onKeypress'=>'if(event.keyCode == 13) event.returnValue = false;'])!!} 

<font size="6">Contrato</font>
<br>
  Empleado:
 <div class="input-group">
       <select name="id_empleado_contratado" class="form-control selectpicker" id="id_empleado_contratado" data-live-search="true" >
         <option value="">  Buscar empleado...                                </option>
            @foreach($empleado as $mov)
            <option value="{{$mov->ci}}">{{$mov->nombre}} - {{$mov->materno}} </option>
            @endforeach
        </select>

      <span class="input-group-btn ">
        <a href="{!!URL::to('empleado')!!}">
        <button class="btn btn-success" type="button"><i class="fa fa-plus" aria-hidden="true"></i> Nuevo</button>
        </a>
      </span>
    </div>
       


  Horario:
     <div class="input-group">
      <select name="id_horario" class="form-control selectpicker" id="id_horario" data-live-search="true" >
         <option value="">  Buscar horario...                                </option>
            @foreach($horario as $mov)
            <option value="{{$mov->id}}">{{$mov->nombre}} - {{$mov->tipo}} </option>
            @endforeach
        </select>

      <span class="input-group-btn ">
        <a href="{!!URL::to('horario')!!}">
        <button class="btn btn-success" type="button"><i class="fa fa-plus" aria-hidden="true"></i> Nuevo</button>
        </a>
      </span>
    </div>



  <div class="form-group">
    Sueldo:<br>
    <input type="number"  name="sueldo" placeholder="Ingrese el Monto" class="form-control" id="sueldo" value="0" >
  </div>

  <div class="form-group">
		{!!Form::label('','Inicio del contrato:')!!} <span ><font color="red" size="5px">*</font></span>          
		<div class='input-group date' id='datetimepicker10'>
			{!!Form::text('inicio_contrato',date("Y-m-d"),['id'=>'fecha_nacimiento','class'=>'form-control','maxlength'=>'10','onkeypress'=>'return bloqueo_de_punto(event)','style'=>'font-size:20px;text-align:left'])!!}
			<span class="input-group-addon ">
			  <span class="fa fa-calendar" aria-hidden="true"></span> 
			</span>
		</div>
	</div>	

<div class="form-group">
		{!!Form::label('','Fin del contrato:')!!} <span ><font color="red" size="5px">*</font></span>          
		<div class='input-group date' id='datetimepicker11'>
			{!!Form::text('fin_contrato',date('Y-m-d', strtotime(date("Y-m-d").' + 30 days')),['id'=>'fecha_nacimiento','class'=>'form-control','maxlength'=>'10','onkeypress'=>'return bloqueo_de_punto(event)','style'=>'font-size:20px;text-align:left'])!!}
			<span class="input-group-addon ">
			  <span class="fa fa-calendar" aria-hidden="true"></span> 
			</span>
		</div>


</div>
</div>
<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">

	  <div class="form-group">
	    Observaciones:<br>
	    {!!Form::textarea('observaciones',null,['class'=>'form-control','placeholder'=>'Ingrese las observaciones' ])!!}
	  </div>

    <div align="left">

      {!!Form::submit('REGISTRAR',['class'=>'btn btn-primary','id'=>'btn_registrar','onclick'=>'btn_esconder()'])!!}

    </div>

    </form>
    
  </div>
  </div>



	 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 well">
       <div class="table-responsive" style="overflow-x:inherit">	
       			<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
       			</div>

				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
				    <select name="id_tax" class="form-control selectpicker" id="id_tax" data-live-search="true" >
				     <option value="">  BUSCAR...   </option>
				        @foreach($buscar_contrato as $mov)
				        <option value="{{$mov->id}}">{{$mov->id}}  </option>
				        @endforeach
				    </select>
				</div>

      

				<table class="table table-striped table-bordered table-condensed table-hover" style="background: white">
					<thead>
						<th><center>Empleado</center></th>
						<th><center>Fecha de inicio</center></th>
						<th><center>Fecha fin </enter></th>
						<th><center>Sueldo</center></th>
						<th><center>Opcion</center></th>
						
					</thead>

					<tbody align="center" id="body_egreso">					
					@foreach($contrato as $usr)
					<tr>
						<td>{{$usr->nombre}} {{$usr->materno}} {{$usr->materno}}</td>
						<td>{{$usr->inicio_contrato}}</td>
						<td>{{$usr->fin_contrato}}</td>
						<td>{{$usr->sueldo}}</td>
						<td>
						<button class="btn btn-primary fa fa-refresh" data-toggle="modal" data-target="#ModalUsuario" onclick="CargarUsuario({{$usr->id}})"></button>
						</td>
					</tr>
					@endforeach
					</tbody>

					<tbody align="center" id="body_conductor_2">
					</tbody>					
				</table>

	
			</div>


		</div>
	</div>

   {!!Html::script('js/usuario.js')!!}
@endsection
