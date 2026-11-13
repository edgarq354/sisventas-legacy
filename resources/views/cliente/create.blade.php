
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
	<form method="POST" action="{{ route('cliente.store') }}" enctype="multipart/form-data" onkeypress="if(event.keyCode == 13) event.returnValue = false;">
    @csrf

     <?php //echo e(Form::open(array('url' => 'crear_empresa'))); ?>
  <h4 align="left" style="color: red">Registrar del personal</h4>

  <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
	<div class="form-group">
		CI/NIT:<br>
		<input type="text"  name="ci_nit" placeholder="Ingrese el CI / NIT" class="form-control" id="ci_nit" maxlength="18" >
	</div>

	<div class="form-group">
		NOMBRE:<br>
		<input type="text"  name="nombre" placeholder="Ingrese el nombre" class="form-control" id="nombre"  >
	</div>
  <div class="form-group">
    PATERNO:<br>
    <input type="text"  name="paterno" placeholder="Ingrese el apellido paterno" class="form-control" id="paterno"  >
  </div>
  <div class="form-group">
    MATERNO:<br>
    <input type="text"  name="materno" placeholder="Ingrese el apellido materno" class="form-control" id="materno"  >
  </div>




	</div>
<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
<div class="form-group">
    TELEFONO:<br>
    <input type="number"  name="telefono" id="telefono" class="form-control" placeholder="Ingrese el telefono" maxlength="10" >
  </div>

  <div class="form-group">
    CORREO:<br>
    <input type="email"  name="correo" id="correo" class="form-control" placeholder="ejemplo@ejemplo.com" >
  </div>

  <div    >
    <h4>Tipo de Personal</h4>
     <div align="form-group" >
      <div class="list-group-item ">
         Cliente:
        <div class="material-switch pull-right">
          <input id="tipo_c" name="tipo_c" type="checkbox" value="1" checked="" />
          <label for="tipo_c" class="label-success"  ></label>
        </div>
       </div>
     </div>

     <div align="form-group" >
      <div class="list-group-item ">
         Proveedor:
        <div class="material-switch pull-right">
          <input id="tipo_p" name="tipo_p" type="checkbox"  value="1" />
          <label for="tipo_p" class="label-success"  ></label>
        </div>
       </div>
     </div>

      <div align="form-group" >
      <div class="list-group-item ">
         Empleado:
        <div class="material-switch pull-right">
          <input id="tipo_e" name="tipo_e" type="checkbox" value="1" />
          <label for="tipo_e" class="label-success" onclick="categoria_empleado();" ></label>
        </div>
       </div>
     </div>
  </div>

</div>

 <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
  <div class="form-group">
    <label for="direccion">DIRECCION:</label><br>
    <textarea name="direccion" id="direccion" class="form-control" placeholder="Ingrese la dirección" style="height:100px;">{{ old('direccion') }}</textarea>
  </div>

  <div class="form-group">
    <label for="descripcion">DESCRIPCION:</label><br>
    <textarea name="descripcion" id="descripcion" class="form-control" placeholder="Ingrese la descripcion" style="height:100px;">{{ old('descripcion') }}</textarea>

    <input type="hidden" name="latitud" id="latitud" value="{{ old('latitud') }}">
    <input type="hidden" name="longitud" id="longitud" value="{{ old('longitud') }}">
  </div>
</div>

<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
  <div id="cat_empleado" hidden>
    <div class="form-group">
      <label for="fecha_nacimiento">Fecha de Ingreso:</label>
      <div class="input-group date" id="datetimepicker10">
        <input
          type="text"
          name="fecha_ingreso"
          id="fecha_nacimiento"
          maxlength="10"
          onkeypress="return bloqueo_de_punto(event)"
          class="form-control"
          style="font-size:20px;text-align:left"
          value="{{ old('fecha_ingreso', date('Y-m-d')) }}"
        />
        <span class="input-group-addon">
          <span class="fa fa-calendar" aria-hidden="true"></span>
        </span>
      </div>
    </div>

    <div class="form-group">
      <label for="sueldo">Sueldo:</label>
      <input
        type="text"
        name="sueldo"
        id="sueldo"
        class="form-control"
        placeholder="Ingrese su sueldo"
        value="{{ old('sueldo', 0) }}"
      />
    </div>

    <div class="form-group">
      <label for="cargo">Cargo:</label>
      <input
        type="text"
        name="cargo"
        id="cargo"
        class="form-control"
        placeholder="Ingrese el cargo"
        value="{{ old('cargo', '') }}"
      />
    </div>
  </div>
</div>


<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" hidden>
  <label for="pac-input">Dirección de domicilio:</label>
  <input id="pac-input" class="controls form-control" type="text" placeholder="Search Box" />
  <div id="map" style="width: 100%; height: 500px;"></div>
</div>



        <div align="left">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <button type="submit" class="btn btn-primary" id="btn_registrar" onclick="btn_esconder()">REGISTRAR</button>
            <a href="{{ url('cliente') }}" class="btn btn-danger">CANCELAR</a>
        </div>
        </div>

		</form>

	</div>
<script src="{{ asset('js/cliente_crear.js') }}"></script>

<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBFEeTkwD_HkWEg6dEhT4hhnkOy3XLppZI&callback=initAutocomplete&libraries=places"></script>

@endsection

