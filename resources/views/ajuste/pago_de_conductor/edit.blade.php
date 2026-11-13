@extends ('layouts.inicio')
@section ('contenido')
@include('alerts.success')
@include('alerts.errors')

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
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	    @include('alerts.request')
@foreach($conductor as $con)
<?php /*{!!Form::model(['route'=>['conductor.update',$con->ci],'method'=>'PUT','enctype'=>'multipart/form-data','onKeypress'=>'if(event.keyCode == 13) event.returnValue = 
	    false;'])!!}     */?>
{{Form::open(array('url' => 'Actualizar_Conductor_Pago','onKeypress'=>'if(event.keyCode == 13) event.returnValue = false;','enctype'=>'multipart/form-data'))}} 
		
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> <h4 align="left"><b>ACTUALIZAR DATOS DEL CONDUCTOR</b></h4> </div>
<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">

	<div class="pull-left">
  <img src="../{{$con->direccion_imagen}}" width="90px" height="90px"  class="img-thumbnail"><br>
		{!!Form::label('ci','C/I:')!!} {!!$con->ci!!} {!!$con->expedido!!}
	</div>
</div>
<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
	

	<div class="form-group" >
		{!!Form::label('nombre','Nombre:')!!}
		{!!$con->nombre!!} {!!$con->paterno!!} {!!$con->materno!!} 
	</div>	
  
  <div class="form-group" >
		{!!Form::label('celular','Celular:')!!}
		{!!$con->celular!!}
	</div>	

</div>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
	<div class="form-group">
			{!!Form::label('tipo_de_pago','Tipo De Pago:')!!}<span ><font color="red" size="5px">*</font></span>
            {!!Form::select('tipo_de_pago', array(
            'DIA' => 'DIA', 
            'SEMANA' => 'SEMANAL',
            'CONDENADO'=>'CONDENADO',
            'NINGUNO'=>'NINGUNO'),$con->tipo_de_pago,array('id'=>'tipo_de_pago','class'=>'form-control'))!!}
	</div>	
	<div class="form-group">
			{!!Form::label('monto_frecuencia','Monto de Frecuencia:')!!}<span ><font color="red" size="5px">*</font></span>
            {!!Form::text('monto_frecuencia',$con->monto_frecuencia,['class'=>'form-control','placeholder'=>'Monto de Frecuencia','maxlength'=>'20'])!!}
	</div>	
<div class="form-group">
    {!!Form::label('fecha_inicio_pago','Fecha de inicio de pago:')!!}<span ><font color="red" size="5px">*</font></span>          
    <div class='input-group date' id='datetimepicker10'>
      <input type='text' value="{{$con->fecha_inicio_pago}}" class="form-control" id="fecha_inicio_pago" name="fecha_inicio_pago" style="font-size:20px;text-align:left" />
      <span class="input-group-addon ">
         <span class="fa fa-calendar" aria-hidden="true"></span> 
      </span>
    </div>
  </div>    
  <div class="form-group">
    {!!Form::label('fecha_fin_pago','Fecha de fin de pago:')!!}<span ><font color="red" size="5px">*</font></span>          
    <div class='input-group date' id='datetimepicker11'>
      <input type='text' value="{{$con->fecha_fin_pago}}" class="form-control" id="fecha_fin_pago" name="fecha_fin_pago" style="font-size:20px;text-align:left" />
      <span class="input-group-addon ">
         <span class="fa fa-calendar" aria-hidden="true"></span> 
      </span>
    </div>
  </div>    
</div>  
</div>
</div>
<input type="hidden" name="id_empresa" id="id_empresa" value="{{$con->id_empresa}}">  
<input type="hidden" name="ci" id="ci" value="{{$con->ci}}">  
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div align="right">
			{!!Form::submit('ACTUALIZAR',['class'=>'btn btn-primary','id'=>'btn_actualizar','onclick'=>'btn_esconder()'])!!} 
			<a href="{!!URL::to('ajuste_pago_conductor')!!}" class="btn btn-danger">CANCELAR</a>
			<?php //{!!Form::reset('CANCELAR',['class'=>'btn btn-danger'])!!} ?>
		</div>
	</div>

	</form>
@endforeach
   {!!Html::script('js/conductor_actualizar.js')!!}

</div>
	@endsection