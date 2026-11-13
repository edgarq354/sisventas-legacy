@extends ('layouts.inicio')
@section ('contenido')
@include('alerts.success')
@include('alerts.request')
@include('alerts.errors')
<script type="text/javascript">
$( window ).load(function(event){
 $("#semana").prop('checked', true);
 click_todo();
 
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
			<font class="col-lg-12 col-md-12 col-sm-12 col-xs-12" size="6">CONDUCTORES SIN DEUDA</font>
			
		
		<table class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
			<tr>
				<td >
					<a href="{!!URL::to('pago_frecuencia/buscar_pagos_realizados/1')!!}"><button class="form-group btn btn-primary" id="btn_buscar" name='btn_buscar'><i class="fa fa-refresh"></i> ACTUALIZAR</button> </a>
				</td>
				<td>
					<a href="{!!URL::to('pago_frecuencia/buscar_deudores/1')!!}"><button class=" form-group btn btn-danger" id="btn_buscar" name='btn_buscar'><i class="fa fa-search "></i> DEUDORES</button> </a>
				</td>
			</tr>
		</table>

		</div>


		

		<div clasrs="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="table-responsive" style="overflow-x:inherit">	
		


    

				<table class="table table-striped table-bordered table-condensed table-hover" style="background: white" id="myTable">
					
					<thead>
						<th><center></center></th>
						<th><center>CODIGO MOVIL</center></th>
						<th><center>CI</center></th>
						<th><center>NOMBRE</center></th>
						<th><center>TELEFONO</center></th>
						<th><center>NRO / TIPO</center></th>
						<th><center> * * *</center></th>

					</thead>
					
						<tbody>
						@foreach($deudores as $conductor)
						@if($conductor->nuevo=='1')
							<tr class="bg-yellow">
							@else
							<tr>
							@endif	

						<td><img src="../../{{$conductor->direccion_imagen}}" style="width: 50px; height: 50px; border-radius: 5px;" alt="img.png"></td>
						<td><center><b>{{ $conductor->codigo_empresa}}</b></center></td>
						<td><center>{{ $conductor->ci}}</center></td>
						<td>{{ $conductor->nombre}} {{$conductor->paterno}} {{$conductor->materno}}</td>
						<td>{{ $conductor->celular}}</td>
						<td><b><center>{{ $conductor->numero}} - {{ $conductor->tipo}}</center></b></td>
						<td> @if($conductor->nuevo==1) NUEVO @endif </td>
						
					</tr>
					@endforeach
					</tbody>
				
						
				</table>

	
	<div class="pull-right">	<button class="btn btn-default" id="mostrar"><b>VER TODOS</b></button>  </div>
			</div>


		</div>
	</div>


 
@endsection

