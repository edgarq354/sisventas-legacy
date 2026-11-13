@extends ('layouts.inicio')
@section ('contenido')
@include('alerts.success')

<script type="text/javascript">
	function seleccionar(
		titulo,
		mensaje,
		tp_conductor_moto,
		tp_conductor_torito,
		tp_conductor_movil,
		tp_pasajero,
		tp_deudor,
		tc_pasajero_pedido){
		$("#titulo").val(titulo);
		$("#mensaje").val(mensaje);

		$("#cb_conductor_moto").prop( "checked", false );
		$("#cb_conductor_torito").prop( "checked", false );
		$("#cb_conductor_movil").prop( "checked", false );
		$("#cb_cliente").prop( "checked", false );
		$("#cb_cliente_pedido").prop( "checked", false );

		if(tp_conductor_moto==1){
			$("#cb_conductor_moto").prop( "checked", true );
		}

		if(tp_conductor_torito==1){
			$("#cb_conductor_torito").prop( "checked", true );
		}

		if(tp_conductor_movil==1){
			$("#cb_conductor_movil").prop( "checked", true );
		}

		if(tp_pasajero==1){
			$("#cb_cliente").prop( "checked", true );
		}

		if(tp_pasajero_pedido==1){
			$("#cb_cliente_pedido").prop( "checked", true );
		}

		if(tp_deudor==1){
			$("#cb_deudor").prop( "checked", true );
		}
	}

	function seleccionar_otro(){
		if($("#cb_cliente").is(':checked'))
		{	
			$("#cb_deudor").prop( "checked", false );
		}
		if($("#cb_conductor").is(':checked'))
		{	
			$("#cb_deudor").prop( "checked", false );
		}

		if($("#cb_cliente_pedido").is(':checked'))
		{	
			$("#cb_deudor").prop( "checked", false );
		}


	}

	function seleccionar_deudores(){
		if($("#cb_deudor").is(':checked'))
		{	
			$("#cb_cliente").prop( "checked", false );
			$("#cb_cliente_pedido").prop( "checked", false );
			$("#cb_conductor_moto").prop( "checked", false );
			$("#cb_conductor_torito").prop( "checked", false );
			$("#cb_conductor_movil").prop( "checked", false );
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
    margin:0px 0px 0px 15px;
    vertical-align:middle;
    background:url("images/check_radio_sheet.png") left top no-repeat;
    cursor:pointer;
}

input[type="checkbox"]:checked + label span {
    background:url("images/check_radio_sheet.png") -19px top no-repeat;
}
</style>

	<div class="row">

	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
  <div class=" well">

	    @include('alerts.request')
	<h3 align="left" >Enviar Notificación</h3>	    
		{!!Form::open(['name'=>'Form1','route'=>'notificacion.store', 'method'=>'POST' , 'enctype'=>'multipart/form-data','onKeypress'=>'if(event.keyCode == 13) event.returnValue = false;','onsubmit'=>'return validateForm()'])!!}	


	<div class="form-group">
		Titulo:
		<input type="text" class="form-control" name="titulo" id="titulo">	
	</div>
	<div class="form-group">
		Mensaje:
		<textarea class="form-control" style="height: 100px;" name="mensaje" id="mensaje"></textarea> 	
	</div>
			<div class="form-group" >

		    

		    <input type="checkbox" id="cb_cliente" name="cb_cliente" value="1" onclick="seleccionar_otro();"  checked="" />
		    <label for="cb_cliente"><span></span>Clientes</label>
		    
		     <input type="checkbox" id="cb_cliente_pedido" name="cb_cliente_pedido" value="1" onclick="seleccionar_otro();"  checked="" />
		    <label for="cb_cliente_pedido"><span></span>Clientes Pedidos</label>
		    
		    
		    <input type="checkbox" id="cb_conductor_moto" name="cb_conductor_moto" onclick="seleccionar_otro();"   />
		    <label for="cb_conductor_moto"><span></span>Conductores Moto</label> 
		    
		    <input type="checkbox" id="cb_conductor_torito" name="cb_conductor_torito" onclick="seleccionar_otro();"   />
		    <label for="cb_conductor_torito"><span></span>Conductores Torito</label> 

		    <input type="checkbox" id="cb_conductor_movil" name="cb_conductor_movil" onclick="seleccionar_otro();"   />
		    <label for="cb_conductor_movil"><span></span>Conductores Movil</label> 

		    </div>


		    <div class="form-group " hidden="">
		    <input type="checkbox" id="cb_deudor" name="cb_deudor" onclick="seleccionar_deudores();"  />
		    <label for="cb_deudor"><span></span>Conductores con deuda</label>

		</div>
		<div class="form-group " >
		    <button class="btn btn-primary fa fa-paper-plane" id="btn_registrar"> Enviar</button>
		    </div>
		    </div>
	</div>
	</div>

	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	<div class=" well">
<div class="panel-body">
				<table class="table table-striped table-bordered table-condensed table-hover" style="background: white" id="myTable">		

					<thead>
						<th><center>Fecha</center></th>
						<th><center>Titulo</center></th>
						<th><center>Mensaje</center></th>
						<th><center>Opcion</center></th>
					</thead>
					<tbody align="center" id="body_usuario">					
					@foreach($notificacion as $user)
					<tr>
						<td>{{ $user->fecha}}</td>
						<td>{{ $user->titulo}}</td>
						<td>{{ $user->mensaje}}</td>
						<td align="left">
						<?php 
						$tipo="";
						if ($user->tp_conductor_moto==1) {
							echo '<i class="fa fa-user btn btn-link" aria-hidden="true"  data-toggle="tooltip" data-placement="top" title="Conductor" ></i>';
						} 
						if ($user->tp_conductor_torito==1) {
							echo '<i class="fa fa-user btn btn-link" aria-hidden="true"  data-toggle="tooltip" data-placement="top" title="Conductor" ></i>';
						} 
						if ($user->tp_conductor_movil==1) {
							echo '<i class="fa fa-car btn btn-link" aria-hidden="true"  data-toggle="tooltip" data-placement="top" title="Conductor" ></i>';
						} 
						if ($user->tp_pasajero == 1) {
							echo '<i class="fa fa-users btn btn-link" aria-hidden="true"  data-toggle="tooltip" data-placement="top" title="Pasajero"></i>';
						} 
						if ($user->tp_deudor == 1) {
							echo '<i class="fa fa-money btn btn-link" aria-hidden="true"  data-toggle="tooltip" data-placement="top" title="Deudores"></i>';
						}
						?>
						
					<i class="fa fa-share-square-o btn btn-link" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Re enviar" onclick="seleccionar('{{$user->titulo}}','{{$user->mensaje}}',{{$user->tp_conductor_moto}},{{$user->tp_conductor_torito}},{{$user->tp_conductor_movil}},{{$user->tp_pasajero}},{{$user->tp_deudor}});"></i>
						</td>
						
					</tr>
					@endforeach
					</tbody>

					<tbody align="center" id="body_usuario_2">
					</tbody>					
				</table>
				</div>
	</div>
	</div>

	</form>
</div>
   {!!Html::script('js/crear_fotocopia.js')!!}
@endsection