
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



    <script type="text/javascript">
      
function changeFunc(sel) {
   $("#nombre_tipo_producto").val(sel.options[sel.selectedIndex].text);
   }

    </script>

	<div class="row">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
{!!Form::open(['route'=>'producto_tipo.store', 'method'=>'POST' , 'enctype'=>'multipart/form-data','onKeypress'=>'if(event.keyCode == 13) event.returnValue = false;'])!!} 

	<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
  <input type="hidden" name='id_empresa' value="{{Auth::user()->id_empresa}}" />
  <input type="hidden" name='estado' value="1" />
 

  <h3 align="left" style="color: red">{{ __('producto_tipo.registrar_nuevo_producto_h3') }}</h3>


</div>



 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 well" >

 <h2>{{ __('producto_tipo.registrar_nuevo_producto_h2') }}</h2>
<hr style="height: 2px; background-color: black;">
 
 
  <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
  <input type="hidden" name='id_empresa' value="{{Auth::user()->id_empresa}}" />
 
 
 
  <div class="form-group">
    {{ __('producto_tipo.nombre_label') }}<br>
    <input type="text"  name="nombre" placeholder="{{ __('producto.placeholder_nombre') }}" class="form-control" id="nombre" value="" >
  </div>

<div class="form-group">
    {{ __('producto_tipo.imei_label') }}<br>
    <input type="text"  name="imei"    class="form-control"   >
  </div>


  <div class="form-group">
    {{ __('producto_tipo.precio_label') }}<br>
    <input type="decimal"  name="precio"   value="0" class="form-control"   >
  </div>

   <div class="form-group">
    {{ __('producto_tipo.cantidad_label') }}<br>
    <input type="number"  name="cantidad"   value="0" class="form-control"   >
  </div>



</div>
<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">

   {{ __('producto_tipo.buscar_categoria') }}
    <div class="form-group">
      <select name="id_tipo_producto" class="form-control selectpicker" id="id_tipo_producto" data-live-search="true"  onchange="changeFunc(this);">
         <option value="">  {{ __('producto_tipo.opt_buscar') }}                                </option>
            @foreach($tipo_producto as $mov)
            <option value="{{$mov->id}}" >{{$mov->nombre}} </option>
            @endforeach
        </select>

    </div>
     <div class="form-group">
    {{ __('producto_tipo.nombre_tipo_producto_label') }}<br>
    <input type="text"  name="nombre_tipo_producto"   id="nombre_tipo_producto"    class="form-control"   >
  </div>

  <div class="form-group">
    {{ __('producto_tipo.descripcion_label') }}<br>
    {!!Form::textarea('descripcion',null,['class'=>'form-control','placeholder'=>__('producto_tipo.placeholder_descripcion'),'style'=>'height:100px;' ])!!}
  </div>
 
  
</div>
 



		<div align="left">

			{!!Form::submit(__('producto_tipo.registrar'),['class'=>'btn btn-primary','id'=>'btn_registrar','onclick'=>'btn_esconder()'])!!}
      </form>
			<a href="{!!URL::to('producto_tipo')!!}" class="btn btn-danger">{{ __('producto_tipo.cancelar') }}</a>

</div>

		
		
  </div>
 
</form>
 
  
</div>

@endsection

