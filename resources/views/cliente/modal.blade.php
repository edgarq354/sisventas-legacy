<div class="modal fade" id="ModalCliente" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static">
  <div class="modal-dialog modal-lg" role="document" >
    <div class="modal-content">

            <div class="modal-header" style="background: #3c8dbc; color: white">
              <h3 id="titulogalpon" class="modal-title"><b>PERFIL DEL MOTISTA</b></h3>
            </div>

            <div class="modal-body">
         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

  <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
  <div class="form-group">
    CI/NIT:<br>
    <input type="text"  name="ci_nit" placeholder="Ingrese el CI / NIT" class="form-control" id="ci_nit" maxlength="18" >
  </div>

  <div class="form-group">
    NOMBRE:<br>
    <input type="text"  name="nombre" placeholder="Ingrese el nombre" class="form-control" id="nombre"  >
  </div>





  </div>
<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
    <div class="form-group">
        <label for="telefono">TELEFONO:</label><br>
        <input type="number" name="telefono" id="telefono" class="form-control" placeholder="Ingrese el telefono" maxlength="10" value="{{ old('telefono') }}">
    </div>

    <div class="form-group">
        <label for="correo">CORREO:</label><br>
        <input type="email" name="correo" id="correo" class="form-control" placeholder="ejemplo@ejemplo.com" value="{{ old('correo') }}">
    </div>

    <div class="form-group">
        <h4>Tipo de Cliente:</h4>
        <input type="checkbox" id="tipo_c" name="tipo_c" value="1" {{ old('tipo_c', '1') == '1' ? 'checked' : '' }}>
        <label for="tipo_c"><span></span>NORMAL</label>&nbsp;&nbsp;&nbsp;

        <input type="checkbox" id="tipo_p" name="tipo_p" value="1" {{ old('tipo_p') == '1' ? 'checked' : '' }}>
        <label for="tipo_p"><span></span>PROVEEDOR</label>
    </div>
</div>

<div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
    <div class="form-group">
        <label for="direccion">DIRECCION:</label><br>
        <textarea name="direccion" id="direccion" class="form-control" placeholder="Ingrese la dirección" style="height:100px;">{{ old('direccion') }}</textarea>
    </div>

    <div class="form-group">
        <label for="descripcion">DESCRIPCION:</label><br>
        <textarea name="descripcion" id="descripcion" class="form-control" placeholder="Ingrese la descripcion" style="height:100px;">{{ old('descripcion') }}</textarea>

        <input type="hidden" name="latitud" id="latitud" value="{{ old('latitud', 0) }}">
        <input type="hidden" name="longitud" id="longitud" value="{{ old('longitud', 0) }}">
    </div>
</div>

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <label for="pac-input">Dirección:</label>
    <input id="pac-input" class="controls form-control" type="text" placeholder="Search Box">
    <div id="map" style="width: 100%; height: 500px;"></div>
</div>





  </div>

        </div>
<br><br><br><br><br><br><br><br><br><br>
        <div class="modal-footer">
            <button data-dismiss="modal"  class="btn btn-danger">SALIR</button>
        </div>
    </div>
  </div>

</div>

<script src="{{ asset('js/cliente_actualizar.js') }}"></script>

<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBFEeTkwD_HkWEg6dEhT4hhnkOy3XLppZI&callback=initAutocomplete&libraries=places"></script>
