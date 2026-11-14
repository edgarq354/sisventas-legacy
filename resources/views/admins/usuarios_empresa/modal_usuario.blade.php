<!-- Modal -->
<div id="ModalContraseña_usuario" class="modal fade" role="dialog">
  <div class="modal-dialog modal-md">
    <!-- Modal content-->
    <div class="modal-content">

      <div class="modal-header" style="background: #3c8dbc; color: white">
        <h3 class="modal-title"><b>{{ __('admins.cambiar_contrasena_titulo') }}</b></h3>
      </div>
      <div class="modal-body">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

            <form method="POST" action="{{ url('Cambiar_Password_empresa') }}" onkeypress="if(event.keyCode == 13) event.returnValue = false;">
            @csrf

            <input type="hidden" name="id_usuario" id="id_usuario">
            <input type="hidden" name="id_empresa" id="id_empresa">
            <input type="hidden" name="privilegio" id="privilegio">

            <label>{{ __('admins.empresa_label') }}</label> <font id="empresa" size="4"></font>

            <div class="form-group">
                <label for="password">{{ __('admins.nueva_contrasena_label') }}</label>
                <input type="text" name="password" id="password" class="form-control" placeholder="{{ __('admins.placeholder_nueva_contrasena') }}" value="{{ old('password') }}">
            </div>
        </div>
        </div>

        <div class="modal-footer">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

            <button type="submit" class="btn btn-primary" id="btn_actualizar" onclick="btn_esconder()">{{ __('admins.actualizar_mayus') }}</button>
            </form>

            <button data-dismiss="modal" class="btn btn-danger">{{ __('admins.cancelar_mayus') }}</button>
        </div>
        </div>

    </div>
  </div>
</div>


<div id="historial_inicio_sesion" class="modal fade" role="dialog">
  <div class="modal-dialog modal-md">
    <!-- Modal content-->
    <div class="modal-content">

      <div class="modal-header" style="background: #3c8dbc; color: white">
        <h3 class="modal-title"><b>{{ __('admins.historial_inicio_sesion_titulo') }}</b></h3>
          <button data-dismiss="modal"  class="btn btn-danger">{{ __('admins.ocultar') }}</button>

      </div>
      <div class="modal-body" style="width: 100%;">

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">


            <table class="table table-striped table-bordered" style="background: white">
          <thead>
            <tr>
            <th style="width: 170px;"><center>{{ __('admins.col_fecha') }}</center></th>
            <th><center>{{ __('admins.col_ip') }}</center></th>
            <th><center>{{ __('admins.col_detalle') }}</center></th>
          </tr>
          </thead>
          <tbody align="center" id="body_usuario_historial_inicio">
          </tbody>
          </table>
          </div>
      </div>
      <div class="modal-footer">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
          <button data-dismiss="modal"  class="btn btn-danger">{{ __('admins.ocultar') }}</button>
       </div>
      </div>
    </div>
  </div>
</div>

