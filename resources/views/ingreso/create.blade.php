
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
	<form method="POST" action="{{ route('ingreso.store') }}" enctype="multipart/form-data" onkeypress="if(event.keyCode == 13) event.returnValue = false;">
    @csrf


  <h4 align="left" style="color: red">Registrar Ingreso</h4>
  <input type="hidden" name="id_caja" value="{{$id_caja}}"/>

  <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
      Nombre del Cliente:
         <div class="input-group">
           <select name="id_cliente" class="form-control selectpicker" id="id_cliente" data-live-search="true" >
         <option value="">  BUSCAR...                                </option>
            @foreach($buscar_cliente as $mov)
            <option value="{{$mov->id}}">{{$mov->nombre}}  {{$mov->paterno}} - {{$mov->ci_nit}} </option>
            @endforeach
        </select>

          <span class="input-group-btn ">
            <a href="{!!URL::to('cliente/create')!!}">
            <button class="btn btn-success" type="button"><i class="fa fa-plus" aria-hidden="true"></i> Nuevo</button>
            </a>
          </span>
        </div>


       Tipo de Ingreso:


        <div class="input-group">
          <select name="id_tipo" class="form-control selectpicker" id="id_tipo" data-live-search="true" >
         <option value="">  BUSCAR...                                </option>
            @foreach($buscar_tipo as $mov)
            <option value="{{$mov->id}}" >{{$mov->nombre}} </option>
            @endforeach
        </select>

          <span class="input-group-btn ">
            <a href="{!!URL::to('tipo_gasto')!!}">
            <button class="btn btn-success" type="button"><i class="fa fa-plus" aria-hidden="true"></i> Nuevo</button>
            </a>
          </span>
        </div>

	<div class="form-group">
		Monto Total:<br>
		<input type="number"  name="monto" placeholder="Ingrese el Monto" class="form-control" id="monto" value="0" >
	</div>

	<div class="form-group">
		Concepto:<br>
		<textarea name="concepto" class="form-control" placeholder="Ingrese el concepto">{{ old('concepto') }}</textarea>

	</div>







		<div align="left">

			<button type="submit" class="btn btn-primary" id="btn_registrar" onclick="btn_esconder()">REGISTRAR</button>

			<a href="{!!URL::to('ingreso')!!}" class="btn btn-danger">CANCELAR</a>

</div>

		</form>

	</div>
 <script src="{{ asset('js/crear_empresa.js') }}"></script>


@endsection

