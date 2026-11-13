@extends ('layouts.inicio')
@section ('contenido')
@include('alerts.success')
@include('alerts.request')
@include('alerts.errors')
    <style>
      #map {
        height: 100%;
      }
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


	<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12" id="div_buscar_empresa">
		@if(Auth::user()->privilegio!=0) 
		    <select name="buscar_empresa" class="form-control selectpicker" value="-1" id="buscar_empresa" data-live-search="true" >
		     <option value="">BUSCAR EMPRESAS...                                   </option>
		     <option value="-1" selected>TODAS LAS EMPRESAS                                   </option>
		        @foreach($empresa as $mot)
		        <option value="{{$mot->id}}">{{$mot->razon_social}}</option>
		        @endforeach
		    </select>
		@endif  
	</div>

		<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12" hidden="">
			<div class="pull-right" id="btn_not" hidden="">		
				<button type="button" class="btn btn-primary" onclick="Mostrar_Textos()"><i class="fa fa-check-circle" aria-hidden="true"></i> ENVIAR NOTIFICAION</button>	
			</div>		
		</div>
	</div>

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	<div id="mapa" style="width: 1240; height: 550px;"></div>
</div>

	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">		
{{Form::open(array('url' => 'notificacion_conductores'))}}  
		<div id="notificacion" hidden="">
			<input type="hidden" name="titulo_msn" id="titulo_msn" class="form-control" value="TAXICORP"> 
			<textarea id="detalle_msn" name="detalle_msn" class="form-control" rows="5" placeholder="Ingrese el mensaje..."></textarea><br>
			<div class="pull-right">
				{!!Form::submit('ENVIAR',['class'=>'btn-sm btn-primary','id'=>'btn_notificacion','onclick'=>'btn_esconder()'])!!}
				
				<input type="button" value="CANCELAR" onclick="Esconder_Textos()" class="btn-sm btn-danger">								
			</div>		
		</div>
		<br>
		<br>
			
		<input type="button" id="btn_sel_todos_adm" hidden="" value="SELECCIONAR TODOS" onclick="Seleccionar_Todos()" class="btn-sm btn-warning">	
		<input type="button" id="btn_desel_todos_adm" hidden="" style="background: #F7BE81" value="DESELECCIONAR TODOS" onclick="Deseleccionar_Todos()" class="btn-sm btn-warning">	
  			
		<table class="table table-striped table-bordered table-condensed table-hover" style="background: white">
			<thead>
					<th><center>NIT</center></th>
					<th><center>EMPRESA</center></th>
					<th><center>DIRECCION</center></th>
			</thead>

			<tbody align="center" id="body_empresa">

			</tbody>
		</table>
</form>
	</div>


</div>

<input type="hidden" name="privilegio" id="privilegio" value="{{Auth::user()->privilegio}}">


{!!Html::script('js/buscar_empresa.js')!!}
<script async defer
  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCNTI7MFuYXiwGi3Opvcr8G3fJYE4ug4fc">
</script>

@endsection
