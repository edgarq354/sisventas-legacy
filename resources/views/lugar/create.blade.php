
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
{!!Form::open(['route'=>'lugar.store', 'method'=>'POST' , 'enctype'=>'multipart/form-data','onKeypress'=>'if(event.keyCode == 13) event.returnValue = false;'])!!} 

	<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
  <input type="hidden" name='id_empresa' value="{{Auth::user()->id_empresa}}" />
 
  <input type="hidden" name='latitud' id="latitud" value="0" />
  <input type="hidden" name='longitud' id="longitud" value="0" />

  <h4 align="left" style="color: red">Registrar Lugares turisticos:</h4>
  
  Buscar Categoria:
    <div class="form-group">
      <select name="id_categoria" class="form-control selectpicker" id="id_categoria" data-live-search="true" >
         <option value="">  BUSCAR...                                </option>
            @foreach($categoria as $mov)
            <option value="{{$mov->id}}">{{$mov->nombre}} </option>
            @endforeach
        </select>
     
    </div>


       

	<div class="form-group">
		Nombre:<br>
		<input type="text"  name="nombre" placeholder="Ingrese el nombre" class="form-control" id="nombre" value="" >
	</div>

  <div class="form-group">
    Nit:<br>
    <input type="text"  name="nit" placeholder="NIT" class="form-control" id="nit" value="" >
  </div>


  <div class="form-group">
    Dirección:<br>
    {!!Form::textarea('direccion',null,['class'=>'form-control','placeholder'=>'Ingrese la dirección','style'=>'height:100px;' ])!!}
  </div>

</div>

<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">

  <div class="form-group">
    Información:<br>
    {!!Form::textarea('informacion',null,['class'=>'form-control','placeholder'=>'Ingrese la información','style'=>'height:100px;' ])!!}
  </div>
  <div class="form-group">
    Facebook:<br>
    <input type="text"  name="facebook" placeholder="URL..." value="" class="form-control"   >
  </div>

<div class="form-group">
    Porcentaje de pago por pedido(%):<br>
    <input type="number" min="0" max="50" name="porcentaje_pago" placeholder="Porcentaje" value="0" class="form-control"   >
  </div>

 <div class="form-group">
    Titulo imagen:<br>
    <input type="text"  name="titulo_imagen" placeholder="Titulo imagen" value="" class="form-control" id="titulo_imagen" >
  </div>

   <div class="form-group">
    Telefono:<br>
    <input type="number"  name="telefono" placeholder="Telefono" value="" class="form-control" id="telefono" >
  </div>

   <div class="form-group">
    WhatsApp:<br>
    <input type="text"  name="whatsapp" placeholder="WhatsApp" value="" class="form-control" id="whatsapp" >
  </div>

</div>

<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
  <div class="form-group">
    Tiempo de preparación (min):<br>
    <input type="number"  name="tiempo_preparacion" placeholder="Tiempo de preparación" value="10" class="form-control" id="tiempo_preparacion" >
  </div>

 <div class="form-group">
    Monto minimo:<br>
    <input type="number"  name="monto_minimo"  value="10" class="form-control"  >
  </div>

  <div class="form-group">
    Prioridad:<br>
    <input type="number"  name="prioridad" placeholder="Prioridad" value="1" class="form-control">
  </div>


    <div class="form-group">
    <div class="list-group-item ">
       Estado
      <div class="material-switch pull-right">
        <input id="estado" name="estado" type="checkbox" checked=""   />
        <label for="estado" class="label-success"></label>
      </div>
     </div>
   </div>
  
<div class="form-group">
    <div class="list-group-item ">
      Visible en la app
      <div class="material-switch pull-right">
        <input id="estado_pedido" name="estado_pedido" type="checkbox"   checked=""  />
        <label for="estado_pedido" class="label-success"></label>
      </div>
     </div>
   </div>

<div class="form-group">
    <div class="list-group-item ">
       Realiza por Whatsapp
      <div class="material-switch pull-right">
        <input id="solicitud_whatsapp" name="solicitud_whatsapp" type="checkbox"   checked=""   />
        <label for="solicitud_whatsapp" class="label-success"></label>
      </div>
     </div>
   </div>

<div class="form-group">
    <div class="list-group-item ">
       Realiza con Delivery
      <div class="material-switch pull-right">
        <input id="solicitud_aplicacion" name="solicitud_aplicacion" type="checkbox" checked=""  />
        <label for="solicitud_aplicacion" class="label-success"></label>
      </div>
     </div>
   </div>  

  </div>

	

		<div class="form-group">

			{!!Form::submit('REGISTRAR',['class'=>'btn btn-primary','id'=>'btn_registrar','onclick'=>'btn_esconder()'])!!}
			<a href="{!!URL::to('lugar')!!}" class="btn btn-danger">CANCELAR</a>

    </div>

</div>

  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
{!!Form::label('','Dirección de la empresa:')!!}
    <input id="pac-input" class="controls" type="text" placeholder="Search Box" class="form-control">
    <div id="map" style="width: 100%; height: 550px;"></div>

</div>
</form>
  </div>
  
</div>
   {!!Html::script('js/lugar_crear.js')!!}
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCNTI7MFuYXiwGi3Opvcr8G3fJYE4ug4fc&callback=initAutocomplete&libraries=places"></script>


@endsection

