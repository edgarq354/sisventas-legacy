<!-- Modal -->
<div id="ModalContraseña_usuario" class="modal fade" role="dialog">
  <div class="modal-dialog modal-md">
    <!-- Modal content-->
    <div class="modal-content">

      <div class="modal-header" style="background: #3c8dbc; color: white">
        <h3 class="modal-title"><b>CAMBIAR CONTRASEÑA</b></h3>
      </div>
      <div class="modal-body">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

            <form method="POST" action="{{ url('Cambiar_Password_empresa') }}" onkeypress="if(event.keyCode == 13) event.returnValue = false;">
            @csrf

            <input type="hidden" name="id_usuario" id="id_usuario">
            <input type="hidden" name="id_empresa" id="id_empresa">
            <input type="hidden" name="privilegio" id="privilegio">

            <label>EMPRESA:</label> <font id="empresa" size="4"></font>

            <div class="form-group">
                <label for="password">Nueva Contraseña:</label>
                <input type="text" name="password" id="password" class="form-control" placeholder="Ingrese su nueva contraseña" value="{{ old('password') }}">
            </div>
        </div>
        </div>

        <div class="modal-footer">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

            <button type="submit" class="btn btn-primary" id="btn_actualizar" onclick="btn_esconder()">ACTUALIZAR</button>
            </form>

            <button data-dismiss="modal" class="btn btn-danger">CANCELAR</button>
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
        <h3 class="modal-title"><b>HISTORIAL DE INICIO DE SESION</b></h3>
          <button data-dismiss="modal"  class="btn btn-danger">OCUTAR</button>

      </div>
      <div class="modal-body" style="width: 100%;">

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">


            <table class="table table-striped table-bordered" style="background: white">
          <thead>
            <tr>
            <th style="width: 170px;"><center>FECHA</center></th>
            <th><center>IP</center></th>
            <th><center>DETALLE</center></th>
          </tr>
          </thead>
          <tbody align="center" id="body_usuario_historial_inicio">
          </tbody>
          </table>
          </div>
      </div>
      <div class="modal-footer">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
          <button data-dismiss="modal"  class="btn btn-danger">OCUTAR</button>
       </div>
      </div>
    </div>
  </div>
</div>

