@extends ('layouts.inicio')
@section ('contenido')
@include('alerts.success')

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
	<h2 align="left" style="color: black;">REGISTRAR DESAPARECIDOS</h2>	
   <span ><font color="black" size="4px">(*) <b>Campos obligatorios</b></font></span>

		{!!Form::open(['route'=>'desaparecido.store', 'method'=>'POST' , 'enctype'=>'multipart/form-data','onKeypress'=>'if(event.keyCode == 13) event.returnValue = false;'])!!}	
			@include('desaparecido.forms.desaparecido')	
	</div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">		
		<div align="right">
			{!!Form::submit('REGISTRAR',['class'=>'btn btn-primary','id'=>'btn_registrar','onclick'=>'btn_esconder()'])!!}
			<a href="{!!URL::to('conductor')!!}" class="btn btn-danger">CANCELAR</a>
			<?php //{!!Form::reset('CANCELAR',['class'=>'btn btn-danger'])!!} ?>
		</div>
	</div>

	</form>
</div>
   {!!Html::script('js/conductor_crear.js')!!}

  
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBFEeTkwD_HkWEg6dEhT4hhnkOy3XLppZI&callback=initAutocomplete&libraries=places"></script>
	@endsection