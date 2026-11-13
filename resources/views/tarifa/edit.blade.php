@extends ('layouts.inicio')
@section ('contenido')
@include('alerts.success')

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
    background:url("./images/check_radio_sheet.png") left top no-repeat;
    cursor:pointer;
}

input[type="checkbox"]:checked + label span {
    background:url("./images/check_radio_sheet.png") -19px top no-repeat;
}
</style>




    <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 100%;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
      .controls {
        margin-top: 10px;
        border: 1px solid transparent;
        border-radius: 2px 0 0 2px;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        height: 32px;
        outline: none;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
      }

      #pac-input {
        background-color: #fff;
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
        margin-left: 12px;
        padding: 0 11px 0 13px;
        text-overflow: ellipsis;
        width: 300px;
      }

      #pac-input:focus {
        border-color: #4d90fe;
      }

      .pac-container {
        font-family: Roboto;
      }

      #type-selector {
        color: #fff;
        background-color: #4d90fe;
        padding: 5px 11px 0px 11px;
      }

      #type-selector label {
        font-family: Roboto;
        font-size: 13px;
        font-weight: 300;
      }
      #target {
        width: 345px;
      }
    </style>
 
 <script type="text/javascript">
function showVal(newVal){
  $("#cantidad_1").text(newVal);
  $("#distancia_viru").val(newVal);
   cambiar_ancho();
}

function showVal_2(newVal){
  $("#cantidad_2").text(newVal+" mn.");
}


 
 
</script>

<center><H2> TARIFARIO</H2></center>

<div class="row">
	 @include('alerts.request')
     {!!Form::open(['route'=>['tarifa.update','null'],'method'=>'PUT','enctype'=>'multipart/form-data','name'=>'formulario_actualizar','onKeypress'=>'if(event.keyCode == 13) event.returnValue = false;'])!!}
      @foreach ($tarifa as $key => $value)  

      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
      <div class=" panel panel-success">

      	<div class="panel-heading"><h3>Formula </h3><br>
 
      		Se aplica mientras la tarifa normal sea mayor a la  <b>Tarifa Minima</b><br><br>
      		<b>Tarifa normal </b> = Tarifa base + ((Distancia recorrida / Distancia) * Monto por distancia) + ((Tiempo recorrido /  Tiempo) * Monto por tiempo)
      		<br>
      		<b>Tarifa Nocturna</b> = Tarifa normal + nocturna 


   
      	</div>


      	<div class="panel-body">

 
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
    
     <div class="form-group" hidden="">
		 <input type="checkbox" id="mostrar_tarifa_vallegrande"   name="mostrar_tarifa_vallegrande" @if($value->mostrar_tarifa_vallegrande==1) checked="true" @endif   />
		 <label for="mostrar_tarifa_vallegrande" ><span></span>Mostrar notificacion tarifa en Vallegrande</label>
	 </div>
	 
	 <div class="form-group" hidden="">
		 <input type="checkbox" id="mostrar_tarifa_montero"   name="mostrar_tarifa_montero"    @if($value->mostrar_tarifa_montero==1) checked="true" @endif   />
		 <label for="mostrar_tarifa_montero" ><span></span>Mostrar notificacion tarifa en Montero</label>
	 </div>
	
	 <div class="form-group" hidden="">
		 <input type="checkbox" id="mostrar_tarifa_camiri"   name="mostrar_tarifa_camiri" @if($value->mostrar_tarifa_camiri==1) checked="true" @endif   />
		 <label for="mostrar_tarifa_camiri" ><span></span>Mostrar notificacion tarifa en Camiri</label>
	 </div>
	 
	 <div class="form-group" hidden="">
		 <input type="checkbox" id="mostrar_tarifa_guarayo"   name="mostrar_tarifa_guarayo"  @if($value->mostrar_tarifa_guarayo==1) checked="true" @endif   />
		 <label for="mostrar_tarifa_guarayo" ><span></span>Mostrar notificacion tarifa en Guarayo</label>
	 </div>


			 		 		 		 
 
 
	 
	</div>
</div>
	</div>
</div>





 
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
      <div class=" panel panel-danger">
      	<div class="panel-heading"> <label>Tarifario para el Movil </label>  </div>
      	<div class="panel-body">

 
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
   
     <input type="hidden" name="id_empresa" id="id_empresa" value="{{Auth::user()->id_empresa}}">
    

	  <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
	   
			<input type="hidden" name="id" id="id" value="{{$value->id}}">
			<div class="form-group">
					{!!Form::label('p','Tatifa base (bolivianos):')!!}
					{!!Form::text('basica',$value->basica,['class'=>'form-control','placeholder'=>'Ingrese el porcentaje moto','maxlength'=>'4', 'onkeypress'=>'return numerosmasdecimal(event)'])!!}
			</div>
			<div class="form-group">
					{!!Form::label('c','Distancia (metros):')!!}
					{!!Form::text('distancia',$value->distancia,['class'=>'form-control','placeholder'=>'Ingrese el costo fijo moto','maxlength'=>'4', 'onkeypress'=>'return numerosmasdecimal(event)'])!!}
			</div>
			<div class="form-group">
					{!!Form::label('c','Tarifa por distancia (bolivianos):')!!}
					{!!Form::text('monto_distancia',$value->monto_distancia,['class'=>'form-control','placeholder'=>'Ingrese el costo fijo moto','maxlength'=>'4', 'onkeypress'=>'return numerosmasdecimal(event)'])!!}
			</div>

			<div class="form-group" >
					{!!Form::label('','Tiempo (minutos):')!!}
					{!!Form::number('tiempo',$value->tiempo,['class'=>'form-control','placeholder'=>'Ingrese el porcentaje empresa','maxlength'=>'4', 'onkeypress'=>'return numerosmasdecimal(event)'])!!}
			</div>
			<div class="form-group" >
					{!!Form::label('','Tarifa por tiempo (bolivianos):')!!}
					{!!Form::text('monto_tiempo',$value->monto_tiempo,['class'=>'form-control','placeholder'=>'Ingrese el porcentaje empresa','maxlength'=>'4', 'onkeypress'=>'return numerosmasdecimal(event)'])!!}
			</div>
			
		</div>
 

	 	<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
		<div class="form-group" >
				{!!Form::label('p','Taxi normal :')!!}
				{!!Form::text('movil',$value->movil,['class'=>'form-control','placeholder'=>'Ingrese el monto','maxlength'=>'4', 'onkeypress'=>'return numerosmasdecimal(event)'])!!}
		</div>
		<div class="form-group">
				{!!Form::label('c','Tarifa minima:')!!}
				{!!Form::number('tarifa_minima',$value->tarifa_minima,['class'=>'form-control','placeholder'=>'Ingrese la tarifa minima','maxlength'=>'4', 'onkeypress'=>'return numerosmasdecimal(event)'])!!}
		</div>
		<div class="form-group">
				{!!Form::label('c','VIP :')!!}
				{!!Form::text('lujo',$value->lujo,['class'=>'form-control','placeholder'=>'Ingrese el costo fijo moto','maxlength'=>'4', 'onkeypress'=>'return numerosmasdecimal(event)'])!!}
		</div>
		<div class="form-group">
				{!!Form::label('c','Taxi con aire:')!!}
				{!!Form::text('aire',$value->aire,['class'=>'form-control','placeholder'=>'Ingrese el costo fijo moto','maxlength'=>'4', 'onkeypress'=>'return numerosmasdecimal(event)'])!!}
		</div>

		<div class="form-group" >
				{!!Form::label('','Vagoneta :')!!}
				{!!Form::text('maletero',$value->maletero,['class'=>'form-control','placeholder'=>'Ingrese el porcentaje empresa','maxlength'=>'4', 'onkeypress'=>'return numerosmasdecimal(event)'])!!}
		</div>
		<div class="form-group"   >
				{!!Form::label('','Movil con pedido :')!!}
				{!!Form::text('pedido',$value->pedido,['class'=>'form-control','placeholder'=>'Ingrese el porcentaje empresa','maxlength'=>'4', 'onkeypress'=>'return numerosmasdecimal(event)'])!!}
		</div>
		<div class="form-group" hidden="">
				{!!Form::label('p','Movil con reserva :')!!}
				{!!Form::text('reservar',$value->reservar,['class'=>'form-control','placeholder'=>'Ingrese el monto','maxlength'=>'4', 'onkeypress'=>'return numerosmasdecimal(event)'])!!}
		</div>
		
	 
	</div> 
	 <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
 
			
			  <div class="form-group well">
			 	{!!Form::label('p','Horario diurno (Hora): ')!!}
			 	 <table>
			 	 	<tr  >
			 	 		<td>{!!Form::label('p','Inicio: ')!!}</td>
			 	 		<td>
			 	 				{!!Form::select('hora_inicio', array( 
			 	 				'1' => '1',
			 	 				'2' => '2',
			 	 				'3' => '4',
			 	 				'5'=>'5',
			 	 				'6'=>'6',
			 	 				'7'=>'7',
			 	 				'8'=>'8',
			 	 				'9'=>'9',
			 	 				'10'=>'10',
			 	 				'11'=>'11',
			 	 				'12'=>'12',
			 	 				'13'=>'13',
			 	 				'14'=>'14',
			 	 				'15'=>'15',
			 	 				'16'=>'16',
			 	 				'17'=>'17',
			 	 				'18'=>'18',
			 	 				'19'=>'19',
			 	 				'20'=>'20',
			 	 				'21'=>'21',
			 	 				'22'=>'22',
			 	 				'23'=>'23',
			 	 				'24'=>'24'
			 	 				),$value->hora_inicio,array('id'=>'hora_inicio','class'=>'custom-select form-control dropdown-toggle','data-toggle' => 'dropdown'))!!}
			 	 		</td>
			 	 	</tr>
			 	 	<tr>
			 	 		<td>.</td>
			 	 		<td></td>
			 	 	</tr>

			 	 	<tr >
			 	 		<td>{!!Form::label('p','Fin: ')!!}</td>
			 	 		<td>
			 	 			{!!Form::select('hora_fin', array( 
			 	 				'1' => '1',
			 	 				'2' => '2',
			 	 				'3' => '4',
			 	 				'5'=>'5',
			 	 				'6'=>'6',
			 	 				'7'=>'7',
			 	 				'8'=>'8',
			 	 				'9'=>'9',
			 	 				'10'=>'10',
			 	 				'11'=>'11',
			 	 				'12'=>'12',
			 	 				'13'=>'13',
			 	 				'14'=>'14',
			 	 				'15'=>'15',
			 	 				'16'=>'16',
			 	 				'17'=>'17',
			 	 				'18'=>'18',
			 	 				'19'=>'19',
			 	 				'20'=>'20',
			 	 				'21'=>'21',
			 	 				'22'=>'22',
			 	 				'23'=>'23',
			 	 				'24'=>'24'
			 	 				),$value->hora_fin,array('id'=>'hora_inicio','class'=>'custom-select form-control dropdown-toggle','data-toggle' => 'dropdown'))!!}
			 	 		</td>
			 	 	</tr>
			 	 </table>	
			 </div>
			 <div class="form-group">
					{!!Form::label('p','Nocturno(Agregar tarifa nocturna):')!!}
					{!!Form::text('monto_hora_nocturna',$value->monto_hora_nocturna,['class'=>'form-control','placeholder'=>'Ingrese el monto para el horario nocturno','maxlength'=>'4', 'onkeypress'=>'return numerosmasdecimal(event)'])!!}
			</div>
		</div>
	</div>
</div>
	</div>
</div>





  
 

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
      <div class=" panel panel-primary">
      	<div class="panel-heading"> <label>Tarifario para la Moto </label>  </div>
      	<div class="panel-body">

	  	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
	    
	          <input type="hidden" name="id_empresa" id="id_empresa" value="{{Auth::user()->id_empresa}}">
	          

		  <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
		

				<div class="form-group">
						{!!Form::label('p','Tatifa basica:')!!}
						{!!Form::text('basica_moto',$value->basica_moto,['class'=>'form-control','placeholder'=>'Ingrese el porcentaje moto','maxlength'=>'4', 'onkeypress'=>'return numerosmasdecimal(event)'])!!}
				</div>
				<div class="form-group">
						{!!Form::label('c','Distancia (metros):')!!}
						{!!Form::text('distancia_moto',$value->distancia_moto,['class'=>'form-control','placeholder'=>'Ingrese el costo fijo moto','maxlength'=>'4', 'onkeypress'=>'return numerosmasdecimal(event)'])!!}
				</div>
				<div class="form-group">
						{!!Form::label('c','Tarifa por distancia (bolivianos):')!!}
						{!!Form::text('monto_distancia_moto',$value->monto_distancia_moto,['class'=>'form-control','placeholder'=>'Ingrese el costo fijo moto','maxlength'=>'4', 'onkeypress'=>'return numerosmasdecimal(event)'])!!}
				</div>


				
				
				
			</div>

		<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
			 <div class="form-group" >
						{!!Form::label('','Tiempo (minutos):')!!}
						{!!Form::text('tiempo_moto',$value->tiempo_moto,['class'=>'form-control','placeholder'=>'Ingrese el porcentaje empresa','maxlength'=>'4', 'onkeypress'=>'return numerosmasdecimal(event)'])!!}
				</div>
				<div class="form-group" >
						{!!Form::label('','Tarifa por tiempo (bolivianos):')!!}
						{!!Form::text('monto_tiempo_moto',$value->monto_tiempo_moto,['class'=>'form-control','placeholder'=>'Ingrese el monto por tiempo','maxlength'=>'4', 'onkeypress'=>'return numerosmasdecimal(event)'])!!}
				</div>

				<div class="form-group" hidden=""> 
					{!!Form::label('p','Moto con pedido (Agregar al monto de la tarifa):')!!}
					{!!Form::text('pedido_moto',$value->pedido_moto,['class'=>'form-control','placeholder'=>'Ingrese el monto por pedido','maxlength'=>'4', 'onkeypress'=>'return numerosmasdecimal(event)'])!!}
				</div>

				 
			 
			
		</div> 
		
		 <div class="col-lg-3 col-md-4 col-sm-4  col-xs-12" >
 
			
			  <div class="form-group well" hidden="">
			 	{!!Form::label('p','Horario diurno (Hora): ')!!}
			 	 <table>
			 	 	<tr  >
			 	 		<td>{!!Form::label('p','Inicio: ')!!}</td>
			 	 		<td>
			 	 				{!!Form::select('hora_inicio_moto', array( 
			 	 				'1' => '1',
			 	 				'2' => '2',
			 	 				'3' => '4',
			 	 				'5'=>'5',
			 	 				'6'=>'6',
			 	 				'7'=>'7',
			 	 				'8'=>'8',
			 	 				'9'=>'9',
			 	 				'10'=>'10',
			 	 				'11'=>'11',
			 	 				'12'=>'12',
			 	 				'13'=>'13',
			 	 				'14'=>'14',
			 	 				'15'=>'15',
			 	 				'16'=>'16',
			 	 				'17'=>'17',
			 	 				'18'=>'18',
			 	 				'19'=>'19',
			 	 				'20'=>'20',
			 	 				'21'=>'21',
			 	 				'22'=>'22',
			 	 				'23'=>'23',
			 	 				'24'=>'24'
			 	 				),$value->hora_inicio_moto,array('id'=>'hora_inicio_moto','class'=>'custom-select form-control dropdown-toggle','data-toggle' => 'dropdown'))!!}
			 	 		</td>
			 	 	</tr>
			 	 	<tr>
			 	 		<td>.</td>
			 	 		<td></td>
			 	 	</tr>

			 	 	<tr >
			 	 		<td>{!!Form::label('p','Fin: ')!!}</td>
			 	 		<td>
			 	 			{!!Form::select('hora_fin_moto', array( 
			 	 				'1' => '1',
			 	 				'2' => '2',
			 	 				'3' => '4',
			 	 				'5'=>'5',
			 	 				'6'=>'6',
			 	 				'7'=>'7',
			 	 				'8'=>'8',
			 	 				'9'=>'9',
			 	 				'10'=>'10',
			 	 				'11'=>'11',
			 	 				'12'=>'12',
			 	 				'13'=>'13',
			 	 				'14'=>'14',
			 	 				'15'=>'15',
			 	 				'16'=>'16',
			 	 				'17'=>'17',
			 	 				'18'=>'18',
			 	 				'19'=>'19',
			 	 				'20'=>'20',
			 	 				'21'=>'21',
			 	 				'22'=>'22',
			 	 				'23'=>'23',
			 	 				'24'=>'24'
			 	 				),$value->hora_fin_moto,array('id'=>'hora_inicio_moto','class'=>'custom-select form-control dropdown-toggle','data-toggle' => 'dropdown'))!!}
			 	 		</td>
			 	 	</tr>
			 	 </table>	
			 </div>
			 <div class="form-group" hidden="">
					{!!Form::label('p','Nocturno(Agregar tarifa nocturna):')!!}
					{!!Form::text('monto_hora_nocturna_moto',$value->monto_hora_nocturna_moto,['class'=>'form-control','placeholder'=>'Ingrese el monto para el horario nocturno','maxlength'=>'4', 'onkeypress'=>'return numerosmasdecimal(event)'])!!}
			</div>
		</div>

		</div> 
</div>
</div>
</div>


 



<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
      <div class=" panel panel-danger">
      	<div class="panel-heading"> <label>Tarifario para PEDIDO DE MOTO </label>  </div>
      	<div class="panel-body">

	  	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
	    
 
	          

		  <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
		

				<div class="form-group">
						{!!Form::label('p','Tatifa basica:')!!}
						{!!Form::text('basica_pedido_moto',$value->basica_pedido_moto,['class'=>'form-control','placeholder'=>'','maxlength'=>'4', 'onkeypress'=>'return numerosmasdecimal(event)'])!!}
				</div>
				<div class="form-group">
						{!!Form::label('c','Distancia (metros):')!!}
						{!!Form::text('distancia_pedido_moto',$value->distancia_pedido_moto,['class'=>'form-control','placeholder'=>'','maxlength'=>'4', 'onkeypress'=>'return numerosmasdecimal(event)'])!!}
				</div>
				<div class="form-group">
						{!!Form::label('c','Tarifa por distancia (bolivianos):')!!}
						{!!Form::text('monto_distancia_pedido_moto',$value->monto_distancia_pedido_moto,['class'=>'form-control','placeholder'=>'','maxlength'=>'4', 'onkeypress'=>'return numerosmasdecimal(event)'])!!}
				</div>


				
				
				
			</div>

		<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
			<div class="form-group" >
						{!!Form::label('','Tarifa minima:')!!}
						{!!Form::text('tarifa_minima_pedido_moto',$value->tarifa_minima_pedido_moto,['class'=>'form-control','placeholder'=>'','maxlength'=>'4', 'onkeypress'=>'return numerosmasdecimal(event)'])!!}
				</div>

			 <div class="form-group" >
						{!!Form::label('','Tiempo (minutos):')!!}
						{!!Form::text('tiempo_pedido_moto',$value->tiempo_pedido_moto,['class'=>'form-control','placeholder'=>'','maxlength'=>'4', 'onkeypress'=>'return numerosmasdecimal(event)'])!!}
				</div>
				<div class="form-group" >
						{!!Form::label('','Tarifa por tiempo (bolivianos):')!!}
						{!!Form::text('monto_tiempo_pedido_moto',$value->monto_tiempo_pedido_moto,['class'=>'form-control','placeholder'=>'','maxlength'=>'4', 'onkeypress'=>'return numerosmasdecimal(event)'])!!}
				</div>

				<div class="form-group"  > 
					{!!Form::label('p','Nocturno:')!!}
					{!!Form::text('monto_hora_nocturna_moto',$value->monto_hora_nocturna_moto,['class'=>'form-control','placeholder'=>'','maxlength'=>'4', 'onkeypress'=>'return numerosmasdecimal(event)'])!!}
				</div>

				 
			 
			
		</div> 
		

		<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
			<div class="form-group" >
						{!!Form::label('','Monto adicional de LoQueSea:')!!}
						{!!Form::text('monto_loquesea',$value->monto_loquesea,['class'=>'form-control','placeholder'=>'','maxlength'=>'4', 'onkeypress'=>'return numerosmasdecimal(event)'])!!}
				</div>

			 <div class="form-group" >
						{!!Form::label('','Hora inicio LoQueSea:')!!}
						{!!Form::text('hora_inicio_loquesea',$value->hora_inicio_loquesea,['class'=>'form-control','placeholder'=>'','maxlength'=>'4', 'onkeypress'=>'return numerosmasdecimal(event)'])!!}
				</div>
				<div class="form-group" >
						{!!Form::label('','Hora final LoQueSea:')!!}
						{!!Form::text('hora_fin_loquesea',$value->hora_fin_loquesea,['class'=>'form-control','placeholder'=>'','maxlength'=>'4', 'onkeypress'=>'return numerosmasdecimal(event)'])!!}
				</div>
 
				 
			 
			
		</div> 
		 

		</div> 
</div>
</div>
</div>

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
      <div class=" panel panel-danger">
      	<div class="panel-heading"> <label>Distancia del rango </label>  </div>
      	<div class="panel-body">

  <div class="form-group"  >
    {!!Form::label('','Longitud:')!!}
    <div class="input-group">
      <input type="text" class="form-control" name='latitud' id="latitud" value="{{$value->latitud}}"   enabled="">
      <span class="input-group-btn">
        <a><button class="btn btn-primary"     type="button"><i class="fa fa-print-pin" aria-hidden="true"></i></button></a>
      </span>
    </div>
  </div>  
 
  <div class="form-group"  >
    {!!Form::label('','latitud:')!!}
    <div class="input-group">
      <input type="text" class="form-control"  name='longitud' id="longitud" value="{{$value->longitud}}" enabled="">
      <span class="input-group-btn">
        <a><button class="btn btn-danger"      type="button"><i class="fa fa-print-pin" aria-hidden="true"></i></button></a>
      </span>
    </div>
  </div> 

	<div data-role="rangeslider">
    <label for="distancia_rango">Rango (mt):  <span id="cantidad_1">{{$value->distancia_rango}}</span></span></label>
    <input name="distancia_rango" id="distancia_rango" min="1000" max="15000" value="{{$value->distancia_rango}}" type="range" onchange="showVal(this.value)" >
     <span id="ex6CurrentRangePickerValLabel">
     </div>

  
    <div id="map" style=" height: 550px;"></div>
	
	 

</div>	
</div>	

</div>	


	<div align="left">
				{!!Form::submit('ACTUALIZAR',['id'=>'btn_registrar','class'=>'btn btn-primary','onclick'=>'btn_esconder()'])!!}
				<a href="{!!URL::to('tarifa')!!}" class="btn btn-danger">CANCELAR</a>
				</div>

		@endforeach
	</form>
	 
</div>


{!!Html::script('js/aeropuerto_tarifa.js')!!}
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCNTI7MFuYXiwGi3Opvcr8G3fJYE4ug4fc&libraries=places"></script>
	@endsection