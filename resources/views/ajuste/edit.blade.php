@extends ('layouts.inicio')
@section ('contenido')
@include('alerts.success')

 

<style type="text/css">


 input[type=range] {
  -webkit-appearance: none;
  width: 100%;
  margin: 13.8px 0;
}
input[type=range]:focus {
  outline: none;
}
input[type=range]::-webkit-slider-runnable-track {
  width: 100%;
  height: 8.4px;
  cursor: pointer;
  box-shadow: 1px 1px 1px #000000, 0px 0px 1px #0d0d0d;
  background: #3071a9;
  border-radius: 1.3px;
  border: 0.2px solid #010101;
}
input[type=range]::-webkit-slider-thumb {
  box-shadow: 1px 1px 1px #000000, 0px 0px 1px #0d0d0d;
  border: 1px solid #000000;
  height: 36px;
  width: 16px;
  border-radius: 3px;
  background: #ffffff;
  cursor: pointer;
  -webkit-appearance: none;
  margin-top: -14px;
}
input[type=range]:focus::-webkit-slider-runnable-track {
  background: #367ebd;
}
input[type=range]::-moz-range-track {
  width: 100%;
  height: 8.4px;
  cursor: pointer;
  box-shadow: 1px 1px 1px #000000, 0px 0px 1px #0d0d0d;
  background: #3071a9;
  border-radius: 1.3px;
  border: 0.2px solid #010101;
}
input[type=range]::-moz-range-thumb {
  box-shadow: 1px 1px 1px #000000, 0px 0px 1px #0d0d0d;
  border: 1px solid #000000;
  height: 36px;
  width: 16px;
  border-radius: 3px;
  background: #ffffff;
  cursor: pointer;
}
input[type=range]::-ms-track {
  width: 100%;
  height: 8.4px;
  cursor: pointer;
  background: transparent;
  border-color: transparent;
  color: transparent;
}
input[type=range]::-ms-fill-lower {
  background: #2a6495;
  border: 0.2px solid #010101;
  border-radius: 2.6px;
  box-shadow: 1px 1px 1px #000000, 0px 0px 1px #0d0d0d;
}
input[type=range]::-ms-fill-upper {
  background: #3071a9;
  border: 0.2px solid #010101;
  border-radius: 2.6px;
  box-shadow: 1px 1px 1px #000000, 0px 0px 1px #0d0d0d;
}
input[type=range]::-ms-thumb {
  box-shadow: 1px 1px 1px #000000, 0px 0px 1px #0d0d0d;
  border: 1px solid #000000;
  height: 36px;
  width: 16px;
  border-radius: 3px;
  background: #ffffff;
  cursor: pointer;
  height: 8.4px;
}
input[type=range]:focus::-ms-fill-lower {
  background: #3071a9;
}
input[type=range]:focus::-ms-fill-upper {
  background: #367ebd;
}



</style>




 

 <script type="text/javascript">
function showVal(newVal){
  $("#cantidad_1").text(newVal);
}

function showVal_2(newVal){
  $("#cantidad_2").text(newVal+" mn.");
}


 
 
</script>
 

<div class="row">
		@foreach($ajuste as $mot)
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
 <div class=" panel panel-primary">
      	<div class="panel-heading"><font size="6">Actualizar la configuración anual</font><font size="6" ><b> </b></font></div>
      	<div class="panel-body">

			<div class="table-responsive" style="overflow-x:inherit">	
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			 
		
			<font size="6" ><b>{{$mot->anio}}</b></font>
		</div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

    	    @include('alerts.request')
	
<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
{!!Form::open(['route'=>['ajuste.update','null'],'method'=>'PUT','enctype'=>'multipart/form-data','onKeypress'=>'if(event.keyCode == 13) event.returnValue = false;'])!!}	
			
<input type="hidden" name="id_empresa" id="id_empresa" value="{{Auth::user()->id_empresa}}">  

		<div class="form-group" >
		Frecuencia por día:
		{!!Form::text('frecuencia_dia',$mot->frecuencia_dia,['class'=>'form-control','placeholder'=>'Freccuencia por dia','maxlength'=>'10'])!!}
	</div>	
	<div class="form-group" >
		Frecuencia por semana:
		{!!Form::text('frecuencia_semana',$mot->frecuencia_semana,['class'=>'form-control','placeholder'=>'Freccuencia por semana','maxlength'=>'10'])!!}
	</div>	


	<div class="form-group" hidden="">
		Frecuencia por mes:
		{!!Form::text('frecuencia_mes',$mot->frecuencia_mes,['class'=>'form-control','placeholder'=>'Freccuencia por mes','maxlength'=>'10'])!!}
	</div>

	<div class="form-group" >
		Retraso por día:
		{!!Form::text('retraso_dia',$mot->retraso_dia,['class'=>'form-control','placeholder'=>'Retraso por día','maxlength'=>'10'])!!}
	</div>
	

	<div class="form-group">
			{!!Form::submit('ACTUALIZAR',['class'=>'btn btn-primary','id'=>'btn_registrar','onclick'=>'btn_esconder()'])!!}
			</div>

	</div>
<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">

	

	<div class="form-group"  hidden="">
		Pro navidad:
		{!!Form::text('pro_navidad',$mot->pro_navidad,['class'=>'form-control','placeholder'=>'Pro navidad','maxlength'=>'10'])!!}
	</div>	

		<div class="form-group" hidden="">
			Dias de cobro de frecuencia:
			
             {!!Form::select('dia_cobro', array('1' => 'Lunes', '2' => 'Martes', '3' => 'Miercoles', '4' => 'Jueves', '5' => 'Viernes', '6' => 'Sabado'),$mot->dia_cobro,array('id'=>'dia_cobro','class'=>'form-control'))!!}
		</div>
 


  <div data-role="rangeslider">
    <label for="cantidad_tolerancia_cobro">Cantidad de dia de tolerancia:  (<span id="cantidad_1">{{$mot->cantidad_tolerancia_cobro}}</span></span>)</label>
    <input name="cantidad_tolerancia_cobro" id="cantidad_tolerancia_cobro" min="0" max="6" value="{{$mot->cantidad_tolerancia_cobro}}" type="range" onchange="showVal(this.value)" >
     <span id="ex6CurrentRangePickerValLabel">
  </div>
       
        <div class="form-group" hidden="" >
		Pro accidente:
		{!!Form::text('pro_accidente',$mot->pro_accidente,['class'=>'form-control','placeholder'=>'Pro accidente','maxlength'=>'10'])!!}
		</div>	


		  
 

  
  <div data-role="rangeslider">
    <label for="tiempo_visualizacion_conductor">Tiempo de visualizar (min): (<span id="cantidad_2">{{$mot->tiempo_visualizacion_conductor}}</span></span>)</label>
    <input name="tiempo_visualizacion_conductor" id="tiempo_visualizacion_conductor" min="0" max="360" value="{{$mot->tiempo_visualizacion_conductor}}" type="range" onchange="showVal_2(this.value)" >
  </div>

 

 		 <div class="form-group">
		Número de recibo (Pagos de frecuencia):
		<table>
        	<tr>
        		<td>
        			
        			<div class="form-group"><div class="input-group">
					   <input type="number" name="inicio_recibo" aria-describedby="start-date" class="form-control" value="{{$mot->numero_inicio_recibo}}" placeholder="Inicio">
					    <span class="input-group-addon" id="start-date"><span class="fa fa-arrow-up"></span></span>
					</div></div>
        		</td>
        		<td>
        			<i class="fa fa-arrows-h form-group"></i>
        		</td>
        		<td>
        			<div class="form-group"><div class="input-group">
					   <input type="number" name="fin_recibo" aria-describedby="start-date" class="form-control" value="{{$mot->numero_fin_recibo}}" placeholder="Fin">
					    <span class="input-group-addon" id="start-date"><span class="fa fa-arrow-down"></span></span>
					</div></div>
        		</td>
        	</tr>
        </table>
        </div>
        
       

 

		</div>
<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">

	
	<div class="form-group" hidden="" >
		Ahorro:
		{!!Form::text('ahorro',$mot->pro_accidente,['class'=>'form-control','placeholder'=>'Ahorro','maxlength'=>'10'])!!}
	</div>	
	<input type="hidden" name="anio" id="anio" value="{{$mot->anio}}">  
		
</div>

<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
       



       <div class="form-group" hidden="">
		Número de Facturacion:
		<table>
        	<tr>
        		<td>
        			
        			<div class="form-group"><div class="input-group">
					   <input type="number" name="inicio_factura" aria-describedby="start-date" class="form-control" value="{{$mot->numero_inicio_factura}}" placeholder="Inicio">
					    <span class="input-group-addon" id="start-date"><span class="fa fa-arrow-up"></span></span>
					</div></div>
        		</td>
        		<td>
        			<i class="fa fa-arrows-h form-group"></i>
        		</td>
        		<td>
        			<div class="form-group"><div class="input-group">
					   <input type="number" name="fin_factura" aria-describedby="start-date" class="form-control" value="{{$mot->numero_fin_factura}}" placeholder="Fin">
					    <span class="input-group-addon" id="start-date"><span class="fa fa-arrow-down"></span></span>
					</div></div>
        		</td>
        	</tr>
        </table>
        </div>

	

</div>	


</div>
</div>
	</div>
</div>
</div>
	</form>
	@endforeach

</div>

		

	@endsection