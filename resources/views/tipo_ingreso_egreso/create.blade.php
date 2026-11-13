
@extends ('layouts.inicio')
@section ('contenido')
@include('alerts.success')
@include('alerts.request')
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
	{!!Form::open(['route'=>'tipo_ingreso_egreso.store', 'method'=>'POST' , 'enctype'=>'multipart/form-data','onKeypress'=>'if(event.keyCode == 13) event.returnValue = false;'])!!}	
     <?php //echo e(Form::open(array('url' => 'crear_empresa'))); ?>  
  <h4 align="left" style="color: red">Registrar Tipo de Ingreso y Egreso</h4>

  <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
	
	<div class="form-group">
		NOMBRE:<br>
		<input type="text"  name="nombre" placeholder="Ingrese el nombre" class="form-control" id="nombre"  >
	</div>
  <div class="form-group">
    DETALLE:<br>
    {!!Form::textarea('detalle',null,['class'=>'form-control','placeholder'=>'Ingrese detalle' ])!!}
  </div>
  </div>






		<div align="left">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			{!!Form::submit('REGISTRAR',['class'=>'btn btn-primary','id'=>'btn_registrar','onclick'=>'btn_esconder()'])!!}
			<a href="{!!URL::to('tipo_ingreso_egreso')!!}" class="btn btn-danger">CANCELAR</a>
		</div>
</div>

		</form>
		
	</div>
   {!!Html::script('js/crear_empresa.js')!!}

@endsection

