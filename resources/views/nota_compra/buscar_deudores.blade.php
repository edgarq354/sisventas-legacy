@extends ('layouts.inicio')
@section ('contenido')
@include('alerts.success')
@include('alerts.request')
@include('alerts.errors')
<script type="text/javascript">
$( window ).load(function(event){
 $("#todo").prop('checked', true);
 click_todo()
 
});

	function click_todo(){
		if($("#todo").is(":checked")){
			$("#div_todo").show();

			$("#div_fecha_dia").hide();
			$("#div_fecha_semana").hide();
			$("#div_fecha_mes").hide();
			
			$("#dia").prop('checked', false);
			$("#semana").prop('checked', false);
			$("#mes").prop('checked', false);
		}else{
			$("#div_todo").hide();

			$("#div_fecha_dia").hide();
			$("#div_fecha_semana").show();
			$("#div_fecha_mes").hide();
			
			$("#dia").prop('checked', false);
			$("#semana").prop('checked', true);
			$("#mes").prop('checked', false);
		}
	}

	function click_dia(){
				$("#div_fecha_semana").hide();
				$("#div_fecha_mes").hide();

				$("#semana").prop('checked', false);
				$("#mes").prop('checked', false);

				$("#todo").prop('checked', true);
				$("#div_todo").show();

			if($("#dia").is(":checked") ){ 
				$("#div_fecha_dia").show(); 
				$("#div_todo").hide();
				$("#todo").prop('checked', false);
			}else{
				$("#dia").prop('checked', false);
				$("#div_fecha_dia").hide();
				$("#todo").prop('checked', true);
				$("#div_todo").show();
			}
	}
	function click_semana(){
			
				$("#div_fecha_dia").hide();
				$("#div_fecha_mes").hide();

				$("#dia").prop('checked', false);
				$("#mes").prop('checked', false);

				$("#todo").prop('checked', true);
				$("#div_todo").show();

			if($("#semana").is(":checked")){
			 	$("#div_fecha_semana").show(); 

				$("#div_todo").hide();
				$("#todo").prop('checked', false);
			}else {
				$("#div_fecha_semana").hide();
				$("#semana").prop('checked', false);

				$("#todo").prop('checked', true);
				$("#div_todo").show();
			}
	}

	function click_mes(){
				$("#div_fecha_dia").hide();
				$("#div_fecha_semana").hide();

				$("#dia").prop('checked', false);
				$("#semana").prop('checked', false);

				$("#todo").prop('checked', true);
				$("#div_todo").show();

			if($("#mes").is(":checked")){
			   $("#div_fecha_mes").show(); 
			    
				$("#div_todo").hide();
				$("#todo").prop('checked', false);
			}else {
				$("#div_fecha_mes").hide();
				$("#mes").prop('checked', false);

				$("#todo").prop('checked', true);
				$("#div_todo").show();
			}
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
    background:url("../../images/check_radio_sheet.png") left top no-repeat;
    cursor:pointer;
}

input[type="checkbox"]:checked + label span {
    background:url("../../images/check_radio_sheet.png") -19px top no-repeat;
}
</style>

	<div class="row">	
		
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<font size="6">CONDUCTORES CON DEUDA</font>
			<hr>
		</div>

		<div class=" col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
		<div class="table-responsive" style="overflow-x:inherit">	
		 <font size="4">Opciones de busqueda</font>
			<br>
	
		{!!Form::open(['url'=>'pago_frecuencia/buscar_deudores/2/', 'method'=>'GET'])!!}	

        
        <div class="form-group  col-lg-2 col-md-2 col-sm-2 col-xs-12" >
		    
		     <input type="checkbox" id="todo" name="todo" onchange="click_todo();"/>
		    <label for="todo" ><span></span>Todo</label>&nbsp;&nbsp;&nbsp;
			<div id="div_todo">
		   <div class='input-group date' id='datetimepicker10'>

		 	 {!!Form::text('fecha_todo',date('Y-m-j'),['class'=>'form-control','id'=>'fecha_todo','maxlength'=>'10','style'=>'font-size:20px;text-align:left;'])!!}        
         	 <span class="input-group-addon ">
             <span class="fa fa-calendar" aria-hidden="true"></span>  <!--span class="glyphicon glyphicon-calendar"></span-->
        	  </span>
        	</div>
		   </div>

		    </div>

        <div class="form-group  col-lg-3 col-md-3 col-sm-3 col-xs-12" >
		    
		    <input type="checkbox" id="dia" name="dia" onchange="click_dia();" />
		    <label for="dia" ><span></span>Dia</label>&nbsp;&nbsp;&nbsp;

		    <div id="div_fecha_dia">
		    <select name="buscar_fecha_dia" class="form-control selectpicker" id="buscar_fecha_dia" data-live-search="true" >
		     <option value="{{$fecha_dia[0]->fecha_fin}}"><b>{{$fecha_dia[0]->numero}}</b> * {{$fecha_dia[0]->fecha_fin}}</option>
		        @foreach($fecha_dia as $mov)
		        <option value="{{$mov->fecha_fin}}"><b>{{$mov->numero}}</b> * {{$mov->fecha_fin}}</option>
		        @endforeach
		    </select>
		    </div>
		    </div>


	
			
        
		<table class=" form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
			<tr>
				<td><button class="btn btn-success" id="btn_buscar" name='btn_buscar'onclick="btn_esconder()"><i class="fa fa-search"></i> BUSCAR</button> 
				</td>
				<td>
					<?php echo "<a class='btn btn-warning'  href='../pdf_deudores_ultima_frecuencia/$todo/$dia/$id_todo/$id_dia'> <i class='fa fa-print'></i> IMPRIMIR</a>";?>
				</td>
			</tr>
		</table>

		

		
			</form>
			</div>
		</div>

		

		<div clasrs="col-lg-12 col-md-12 col-sm-12 col-xs-12">

			<div class="table-responsive" style="overflow-x:inherit">	
		<hr>


    

				<table class="table table-striped table-bordered table-condensed table-hover" style="background: white" id="myTable">
					
					<thead>
						<th><center></center></th>
						<th><center>CODIGO MOVIL</center></th>
						<th><center>CI</center></th>
						<th><center>NOMBRE</center></th>
						<th><center>TELEFONO</center></th>
						<th><center>TIPO</center></th>
						<th><center>NUMERO</center></th>
						<th><center>* * *</center></th>

					</thead>
					
						<tbody>
						@foreach($deudores as $conductor)
					<tr>
						<td><img src="../../{{$conductor->direccion_imagen}}" style="width: 50px; height: 50px; border-radius: 5px;" alt="img.png"></td>
						<td><center>{{ $conductor->codigo_empresa}}</center></td>
						<td><center>{{ $conductor->ci}}</center></td>
						<td>{{ $conductor->nombre}} {{$conductor->paterno}} {{$conductor->materno}}</td>
						<td>{{ $conductor->celular}}</td>
						<td>{{ $conductor->tipo}}</td>
						<td>{{ $conductor->numero}}</td>
						<td>
						{!!Form::open(['route'=>'pago_frecuencia.create', 'method'=>'GET'])!!}	
							<input type="hidden" name="ci" id="ci" value="{{$conductor->ci}}">  
		     				 {!!Form::submit('PAGAR',['class'=>'btn btn-primary','id'=>'btn_buscar','onclick'=>'btn_esconder()'])!!}
		     			</form>
						</td>
					</tr>
					@endforeach
					</tbody>
				
						
				</table>

	
	<div class="pull-right">	<button class="btn btn-default" id="mostrar"><b>VER TODOS</b></button>  </div>
			</div>


		</div>
	</div>


 
@endsection

