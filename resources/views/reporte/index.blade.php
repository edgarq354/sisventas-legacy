@extends ('layouts.inicio')
@section ('contenido')
@include('alerts.success')
@include('alerts.request')
@include('alerts.errors')
	
	<div class="row">	
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="table-responsive" style="overflow-x:inherit">	
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<font size="6">COBROS DE FRECUENCIA POR USUARIO</font>
			</div>
		</div>
	</div>
{!!Form::open(['route'=>'reporte.index', 'method'=>'GET'])!!}
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
<hr>
	
		<div class="form-group  col-lg-3 col-md-3 col-sm-3 col-xs-12" >
		<div class='input-group date' id='datetimepicker11'>
		  {!!Form::text('fecha_inicio',date('Y-m-j'),['id'=>'fecha_inicio','class'=>'form-control','maxlength'=>'10','onkeypress'=>'return bloqueo_de_punto(event)','style'=>'font-size:20px;text-align:left'])!!}		
		  <span class="input-group-addon ">
		     <span class="fa fa-calendar" aria-hidden="true"></span> 
		  </span>
		</div>
		</div>
		<div class=" col-lg-1 col-md-1 col-sm-1 col-xs-12" >
		 <font ><b>Entre</b></font> 
		</div>
			<div class="form-group  col-lg-3 col-md-3 col-sm-3 col-xs-12" >
        <div class='input-group date' id='datetimepicker10'>

		  {!!Form::text('fecha_fin',date('Y-m-j'),['class'=>'form-control','maxlength'=>'10','style'=>'font-size:20px;text-align:left;'])!!}        
          <span class="input-group-addon ">
             <span class="fa fa-calendar" aria-hidden="true"></span>  <!--span class="glyphicon glyphicon-calendar"></span-->
          </span>
        </div>
        </div>

        
		<div class=" form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">		
		<button class="btn-sm btn-primary" id="btn_buscar" name='btn_buscar'onclick="btn_esconder()"><i class="fa fa-search"></i></button> 
		</div>

</div>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
		    <select name="id_conduc" class="form-control selectpicker" id="id_conduc" data-live-search="true" >
		     <option value="">  BUSCAR POR CONDUCTOR...                                </option>
		        @foreach($conductor as $mov)
		        <option value="{{$mov->ci}}">{{$mov->nombre}} {{$mov->paterno}} {{$mov->materno}} - {{$mov->ci}} </option>
		        @endforeach
		    </select>
		</div>
			<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
		    <select name="id_usu" class="form-control selectpicker" id="id_usu" data-live-search="true" >
		     <option value="">  BUSCAR POR USUARIO...                                </option>
		        @foreach($usuario as $mov)
		        <option value="{{$mov->id}}">{{$mov->nombre}} </option>
		        @endforeach
		    </select>
		</div>

</div>
 </form>

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">	
<hr>
				<table class="table table-striped table-bordered table-condensed table-hover" style="background: white">
					<thead>
						<th><center>USUARIO</center></th>
						<th><center>C.I.</center></th>
						<th><center>CONDUCTOR</center></th>
						<th><center>NRO</center></th>
						<th><center>FECHA</center></th>
						<th><center>CANTIDAD</center></th>
						<th><center>PAGO FRECUENCIA</center></th>
						<th><center>MONTO TOTAL</center></th>
						
						
						<th><center>OPCION</center></th>
						
					</thead>

					<tbody align="center" id="body_conductor">					
					 
					</tbody>

					<tbody align="center" id="body_conductor_2">
					</tbody>					
				</table>

	<div class="pull-right">	<button class="btn btn-default" id="mostrar" onclick="ver_todos()"><b>VER TODOS</b></button>  </div>
			</div>
		</div>
	</div>

@endsection
