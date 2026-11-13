@extends ('layouts.inicio')
@section ('contenido')
@include('alerts.success')
@include('alerts.request')
@include('alerts.errors')
@include('pedido.modal')
	


<style type="text/css">
  .container{max-width:1170px; margin:auto;}
img{ max-width:100%;}
.inbox_people {
  background: #f8f8f8 none repeat scroll 0 0;
  float: left;
  overflow: hidden;
  width: 40%; border-right:1px solid #c4c4c4;
}
.inbox_msg {
  border: 1px solid #c4c4c4;
  clear: both;
  overflow: hidden;
}
.top_spac{ margin: 20px 0 0;}


.recent_heading {float: left; width:40%;}
.srch_bar {
  display: inline-block;
  text-align: right;
  width: 60%; padding:
}
.headind_srch{ padding:10px 29px 10px 20px; overflow:hidden; border-bottom:1px solid #c4c4c4;}

.recent_heading h4 {
  color: #05728f;
  font-size: 21px;
  margin: auto;
}
.srch_bar input{ border:1px solid #cdcdcd; border-width:0 0 1px 0; width:80%; padding:2px 0 4px 6px; background:none;}
.srch_bar .input-group-addon button {
  background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
  border: medium none;
  padding: 0;
  color: #707070;
  font-size: 18px;
}
.srch_bar .input-group-addon { margin: 0 0 0 -27px;}

.chat_ib h5{ font-size:15px; color:#464646; margin:0 0 8px 0;}
.chat_ib h5 span{ font-size:13px; float:right;}
.chat_ib p{ font-size:14px; color:#989898; margin:auto}
.chat_img {
  float: left;
  width: 11%;
}
.chat_ib {
  float: left;
  padding: 0 0 0 15px;
  width: 88%;
}

.chat_people{ overflow:hidden; clear:both;}
.chat_list {
  border-bottom: 1px solid #c4c4c4;
  margin: 0;
  padding: 18px 16px 10px;
}
.inbox_chat { height: 550px; overflow-y: scroll;}

.active_chat{ background:#ebebeb;}

.incoming_msg_img {
  display: inline-block;
  width: 6%;
}
.received_msg {
  display: inline-block;
  padding: 0 0 0 10px;
  vertical-align: top;
  width: 92%;
 }
 .received_withd_msg p {
  background: #ebebeb none repeat scroll 0 0;
  border-radius: 3px;
  color: #646464;
  font-size: 14px;
  margin: 0;
  padding: 5px 10px 5px 12px;
  width: 100%;
}
.time_date {
  color: #747474;
  display: block;
  font-size: 12px;
  margin: 8px 0 0;
}
.received_withd_msg { width: 57%;}
.mesgs {
  float: left;
  padding: 30px 15px 0 25px;
  width: 60%;
}

 .sent_msg p {
  background: #05728f none repeat scroll 0 0;
  border-radius: 3px;
  font-size: 14px;
  margin: 0; color:#fff;
  padding: 5px 10px 5px 12px;
  width:100%;
}
.outgoing_msg{ overflow:hidden; margin:26px 0 26px;}
.sent_msg {
  float: right;
  width: 46%;
}
.input_msg_write input {
  background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
  border: medium none;
  color: #4c4c4c;
  font-size: 15px;
  min-height: 48px;
  width: 100%;
}

.type_msg {border-top: 1px solid #c4c4c4;position: relative;}
.msg_send_btn {
  background: #05728f none repeat scroll 0 0;
  border: medium none;
  border-radius: 50%;
  color: #fff;
  cursor: pointer;
  font-size: 17px;
  height: 33px;
  position: absolute;
  right: 0;
  top: 11px;
  width: 33px;
}
.messaging { padding: 0 0 50px 0;}
.msg_history {
  height: 516px;
  overflow-y: auto;
}

</style>

	 <style>
      #map {
        height: 100%;
      }
  </style>

<div class="row">	
 
		 
<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 ">
      <div class=" panel panel-primary">
      	<div class="panel-heading">Pasajero</div>
      	<div class="panel-body">
      	<table>
				<tr>
					<td style="padding:5px;">
						<img src="../../../taxivalle2/{{$pasajero[0]->direccion_imagen}}"   width="100px" height="100px" style="border-radius: 10px;"/>
					</td>
					<td style="padding:5px;">
						    {!!Form::label('','Pasajero:')!!}
						    {{$pasajero[0]->nombre}} {{$pasajero[0]->apellido}}
						 <br>    
						     {!!Form::label('','Celular:')!!}
						    {{$pasajero[0]->celular}} 
						<br>    
						     {!!Form::label('','Correo:')!!}
						    {{$pasajero[0]->correo}}  
						<br>

						     {!!Form::label('','Imei:')!!}
						    {{$pasajero[0]->imei}}   
					 </td>
				 
				</tr>
			</table>
	           </div>
		</div>
</div>
 
<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 ">
      <div class=" panel panel-success">
      	<div class="panel-heading"><b>Conductor</b> <a href="{!!URL::to('conductors',$conductor[0]->ci)!!} "  class="btn btn-success" > Ver mas detalle</a> </div>
      	<div class="panel-body">
			<table>
				<tr>
					<td style="padding:5px;">
						<img src="../{{$conductor[0]->direccion_imagen}}"   width="100px" height="100px" style="border-radius: 10px;"/>
					</td>
					<td style="padding:5px;">
						  {!!Form::label('','CI:')!!}
						    {{$conductor[0]->ci}} 
						<br>    
						     {!!Form::label('','Numero de Movil:')!!}
						    {{$conductor[0]->numero_movil}} 
						<br>   
						    {!!Form::label('','Conductor:')!!}
						    {{$conductor[0]->nombre}} {{$conductor[0]->paterno}} {{$conductor[0]->materno}}
						 <br>    
						     {!!Form::label('','Celular:')!!}
						    {{$conductor[0]->celular}} 
					</td>
					 
				</tr>
			</table>
	      </div>
		</div>
</div>

<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 ">
      <div class=" panel panel-danger">
      	<div class="panel-heading"><b>Vehiculo  # {{$vehiculo[0]->codigo_empresa}} </b>  <a href="../vehiculo/{{$vehiculo[0]->placa}}/edit "  class="btn btn-danger" style="color: white;">  Ver mas detalle</a></div>
      	<div class="panel-body">
			<table>
				<tr>
					<td style="padding:5px;">
						<img src="../{{$vehiculo[0]->direccion_imagen_adelante}}"   width="100px" height="100px" style="border-radius: 10px;"   />
					</td>
					<td style="padding:5px;">
						 {!!Form::label('','Placa:')!!}
						    {{$vehiculo[0]->placa}} 
						
						<br>      
						     {!!Form::label('','Marca:')!!}
						    {{$vehiculo[0]->marca}} 
						    <br> 
						{!!Form::label('','Color:')!!}
						    {{$vehiculo[0]->color}} 
						 
					 </td>
					 
				</tr>
			</table>
	       </div>
		</div>
</div>

 
	@if($pedido[0]->clase_vehiculo==5)
<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 ">
      <div class=" panel panel-danger">
      	<div class="panel-heading"><b>TIENDA :  </b>  <a href="../lugar/{{$lugar[0]->id}}/edit "  class="btn btn-danger" style="color: white;">{{$lugar[0]->nombre}}</a></div>
      	<div class="panel-body">
			<table>
				<tr>
					<td style="padding:5px;">
						<img src="../../storage/{{$lugar[0]->direccion_logo}}"   class="img-rounded img-thumbnail" width="100px" height="100px" style="border-radius: 2px;"   />

					</td>
					<td style="padding:5px;">
						 {!!Form::label('','Nit:')!!}
						    {{$lugar[0]->nit}} 
						
						
						    <br> 
						{!!Form::label('','Dirección:')!!}
						    {{$lugar[0]->direccion}} 
						    <br>      
						     {!!Form::label('','Telefono:')!!}
						    {{$lugar[0]->telefono}} 
						 
					 </td>
					 
				</tr>
			</table>
	       </div>
		</div>
</div>


<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 ">
      <div class=" panel panel-danger">
      	<div class="panel-heading"><b>CARRITO </b>   </div>
      	<div class="panel-body">
			<table>
				<tr>
					<td  >
						
					 

<div class="messaging">
      <div class="inbox_msg">
           
          <div class="inbox_chat" >
          	<div class="chat_list  ">

			@foreach($carrito as $ca)
              <div class="chat_people" style="  border-bottom: solid 1px  #c4c4c4; padding-top: 10px;">
                <div class="chat_img"> 
                		<img src="../../storage/{{$ca->imagen1}}" class="img-rounded img-thumbnail" alt="" style="width: 100%; max-width: 250px;" width="100px" height="100px"  ></img>
                </div>
                <div class="chat_ib">
                  <h5>
                  	<b>{{$ca->cantidad}} - {{$ca->nombre}}</b>  
                  	<span class="chat_date">    {{$ca->monto_total}} BOB</span>
                  </h5>
                  <p style="color: black;"> Precio por unidad:   {{$ca->monto_unidad}} BOB </p>
                  <p style="color: black;"> {{$ca->descripcion}} </p>
                </div>
              </div>


              @endforeach

          	 

          </div>
        
      </div>
      
      
     
    </div>

					</td>
				</tr>
			</table>
	       </div>
		</div>
</div>
@endif		


<div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 ">
      <div class=" panel panel-success">
      	<div class="panel-heading"><b>Datos del Pedido </b>
      		<b>
      			<input type="hidden" id="estado_pedido" value="{{$pedido[0]->estado}}">
      			<input type="hidden" id="latitud_pedido" value="{{$pedido[0]->latitud}}">
      			<input type="hidden" id="longitud_pedido" value="{{$pedido[0]->longitud}}">

      			<input type="hidden" id="latitud_inicio" value="{{$pedido[0]->latitud_inicio}}">
      			<input type="hidden" id="longitud_inicio" value="{{$pedido[0]->longitud_inicio}}">

      			<input type="hidden" id="latitud_cancelado" value="{{$pedido[0]->latitud_cancelado}}">
      			<input type="hidden" id="longitud_cancelado" value="{{$pedido[0]->longitud_cancelado}}">

      			<input type="hidden" id="latitud_lugar" value="{{$pedido[0]->latitud_lugar}}">
      			<input type="hidden" id="longitud_lugar" value="{{$pedido[0]->longitud_lugar}}">




      			<input type="hidden" id="id_conductor_pedido" value="{{$pedido[0]->id_conductor}}">
      				@if($pedido[0]->estado==0)
						 
						 <button  class="btn btn-danger fa fa-street-view" style="color: white;" onclick="ver_recorrido_pedido();"> Ver Ubicación </button>
						@elseif($pedido[0]->estado==1)
					 
						<button  class="btn btn-danger fa fa-street-view" style="color: white;" onclick="ver_recorrido_pedido();"> Ver Ubicación </button>
						@elseif($pedido[0]->estado==2)
					 
						  <button  class="btn btn-danger fa fa-street-view" style="color: white;" onclick="ver_ubicacion_puntos_finalizados();"> Ver Ubicación: Finalizado</button>
						@elseif($pedido[0]->estado==4)
						 
						 <button  class="btn btn-danger fa fa-street-view" style="color: white;" onclick="ver_ubicacion_cancelado();"> Ver Ubicación: Cancelado </button>
						@elseif($pedido[0]->estado==5)
						 
						 <button  class="btn btn-danger fa fa-street-view" style="color: white;" onclick="ver_ubicacion_cancelado();"> Ver Ubicación: Cancelado </button>
						@endif
					  
						
      		</b>
      	</div>
      	<div class="panel-body">

			<h3 >
      		 @if($pedido[0]->estado==0)
						<b style="color: green;"> EN CAMINO A LA UBICACIÓN DEL PASAJERO
						@elseif($pedido[0]->estado==1)
						 <b style="color: black;">CON PASAJERO ABORDO
						  
						@elseif($pedido[0]->estado==2)
						<b style="color: blue;">PEDIDO FINALIZADO 
						 
						@elseif($pedido[0]->estado==4)
						 <b style="color: red;">PEDIDO CANCELADO POR EL PASAJERO
						 
						@elseif($pedido[0]->estado==5)
						<b style="color: orange;"> PEDIDO CANCELADO POR EL CONDUCTOR
					 
						@endif
			</b></h3  >
			<table>
				<tr>
					 
					<td style="padding:5px;">
						 {!!Form::label('','ID:')!!}
					    {{$pedido[0]->id}}
						 <br>
						 {!!Form::label('','Hora de solicitud:')!!}
						    {{$pedido[0]->fecha_pedido}} 

						<br>    
						     {!!Form::label('','Dirección:')!!}
						    {{$pedido[0]->direccion_inicio}} 
						<br>  
						     {!!Form::label('','Que necesitas?:')!!}
						    {{$pedido[0]->que_necesitas}} 
						<br>  
						     {!!Form::label('','Referencia:')!!}
						    {{$pedido[0]->direccion}} 
						<br>
						  {!!Form::label('','Localidad:')!!}
						    {{$pedido[0]->localidad}} 
						<br>
						
							@if($pedido[0]->estado==4)
						  {!!Form::label('','Detalle de la cancelación:')!!}
						    {{$pedido[0]->detalle_cancelo_usuario}}
						 
						@elseif($pedido[0]->estado==5)
						   {!!Form::label('','Detalle de la cancelación:')!!}
						    {{$pedido[0]->detalle_cancelo_conductor}}
						 
					 
						@endif
					 
						
					 </td>
					<td style="padding:5px;">
						  
						     {!!Form::label('','Decripción del servicio:')!!}
						    {{$pedido[0]->descripcion_finalizo}} 
						    <br>
						     {!!Form::label('','Clase de Vehiculo:')!!}
						   @if($pedido[0]->clase_vehiculo==1)
							MOVIL NORMAL
							@elseif($pedido[0]->clase_vehiculo==2)
							DE LUJO
							@elseif($pedido[0]->clase_vehiculo==3)
								CON AIRE
							@elseif($pedido[0]->clase_vehiculo==4)
							 CON MALETERO
							@elseif($pedido[0]->clase_vehiculo==5)
							PEDIDO
							@elseif($pedido[0]->clase_vehiculo==6)
							RESERVA
							@elseif($pedido[0]->clase_vehiculo==7)
							MOTO
							@elseif($pedido[0]->clase_vehiculo==7)
							MOTO PEDIDO
							@endif
						 <br>   
						    {!!Form::label('','Calificación al Conductor:')!!}
						    {{$pedido[0]->calificacion_conductor}}
						 <br> 
						   {!!Form::label('','Calificación al Vehiculo:')!!}
						    {{$pedido[0]->calificacion_vehiculo}} 
					<br>    
						     {!!Form::label('','Monto total:')!!}
						    {{$pedido[0]->monto_total}} Bs
					   	    	    
			  
					</td>
				</tr>
			</table>
	       </div>
		</div>
</div>		



<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
		<div class=" panel panel-info">
      	<div class="panel-heading">Carreras realizadas </div>
      	<div class="panel-body">
			 
			@foreach($carrera as $car)
			  

			 <div class="btn btn-default" id="btn_buscar" onclick="ver_linea({{$car->id}},{{$car->id_pedido}},{{$car->latitud_inicio}},{{$car->longitud_inicio}},{{$car->latitud_fin}},{{$car->longitud_fin}});"> 
			 	<table class="table">
			 		<thead  >
			 		<tr>
			 			<th colspan="2"  >
			 			 <center><b> CARRERA # {{$car->id}}</b></center>		
			 			</th>
			 		</tr>
			 		</thead>
			 		<tbody>
			 		<tr align="left">
			 			<td style="padding: 5px;" scope="row">
			 				Fecha: <?php echo date("j-n-Y",strtotime($car->fecha_inicio)); ?>   <br>

						 Hora de inicio: <?php echo date("H:i:s",strtotime($car->fecha_inicio)); ?>    <br>
 						 Hora final: <?php echo date("H:i:s",strtotime($car->fecha_fin)); ?>   
					    </td>

			 			<td style="padding: 5px;">
						 	<i class="fa fa-print-pin" style="color: green;"></i> {{$car->direccion_inicio}}    <br>
						 	<i class="fa fa-print-pin" style="color: red;"></i> {{$car->direccion_fin}}   <br>

			 			

			 			</td>
			 		</tr>
			 		<tr>
			 			<td colspan="2">
			 				 Monto: {{$car->monto}} Bs <br> 

			 				 <?php
			 				 $d=$car->distancia;
			 				 if($d>=1000)
			 				 {
			 				 	$m=$d/1000;
			 				 	$d=$m;
			 				 	echo "Distancia: ".$d." Km";
			 				 }else
			 				 {
								echo "Distancia: ".$d." mt";
			 				 }
			 				 ?>
			 			  <br>  
						 	<b>  VER EL RECORRIDO  </b>
			 			</td>
			 		</tr>
			 		</tbody>
			 	</table> 
			 </div>
			 @endforeach
			</div>
		</div>
	</div>
</div>
			   
			  <br><br>
		
		    
		   	<div id="mapa" style="width: 100%; height: 500px;"></div>
		</div>  

</div>


 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
 <div class="container">
<h3 class=" text-center">Chat del Conductor y del Pasajero</h3>
<div class="messaging">
      <div class="inbox_msg">
        <div class="inbox_people">
          <div class="headind_srch">
            <div class="recent_heading">
              <h4>Usuarios</h4>
            </div>
          </div>
          <div class="inbox_chat" style="padding: 10px;">
          	<div class="chat_list active_chat">
              <div class="chat_people">
                <div class="chat_img"> <img src="../../../taxivalle2/{{$pasajero[0]->direccion_imagen}}"   alt="sunil"> </div>
                <div class="chat_ib">
                  <h5> {{$pasajero[0]->nombre}} {{$pasajero[0]->apellido}} <span class="chat_date">    {{$pasajero[0]->celular}} </span></h5>
                  <p> {{$pasajero[0]->correo}} </p>
                </div>
              </div>
            </div>
          	 
          	 

          </div>
        </div>
        <div class="mesgs">
          <div class="msg_history">

           

           
          @foreach($mensaje as $con)
          <?php
          $fecha=$con->fecha;
          $hora=date("g:i:s a",strtotime($fecha));   
          $mes=date("F j ",strtotime($fecha));   
          ?>
          @if($con->yo==1)
           <div class="incoming_msg">
              <div class="incoming_msg_img"> <img  src="../../../taxivalle2/{{$pasajero[0]->direccion_imagen}}" alt="sunil"> </div>
              <div class="received_msg">
                <div class="received_withd_msg">
                  <p>{{$con->mensaje}}</p>
                  <span class="time_date"> {{$hora}}   |    {{$mes}}</span></div>
              </div>
            </div>
          @else
           <div class="outgoing_msg">
              <div class="sent_msg">
              <p>{{$con->mensaje}}</p>
                <span class="time_date"> {{$hora}}   |    {{$mes}}</span> </div>
            </div>

          @endif

    		@endforeach

           

          </div>
          
        </div>
      </div>
      
      
      <p class="text-center top_spac"> Design by <a target="_blank" href="#">EliSoft</a></p>
      
    </div></div>


 
  </div>
    @foreach($mensaje as $con)
    @endforeach
 
   {!!Html::script('js/detalle_pedido.js')!!}
   {!!Html::script('js/detalle_pedido_buscar.js')!!}
<script async defer
  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBFEeTkwD_HkWEg6dEhT4hhnkOy3XLppZI">
</script>
@endsection
