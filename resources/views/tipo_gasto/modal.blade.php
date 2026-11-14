<!-- Modal -->
<div id="ModalCrearNuevo" class="modal fade" role="dialog">
  <div class="modal-dialog modal-md">
    <!-- Modal content-->
    <div class="modal-content">

      <div class="modal-header" style="background: #3c8dbc; color: white">
        <h3 class="modal-title">{{ __('tipo_gasto.modal_crear_titulo') }}</h3>
      </div>


        <div class="modal-body">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <form method="POST" action="{{ route('tipo_gasto.store') }}" enctype="multipart/form-data" onkeypress="if(event.keyCode == 13) event.returnValue = false;">
                @csrf
                <input type="hidden" name="id_empresa" id="id_empresa" value="{{ Auth::user()->id_empresa }}">

                <div class="form-group">
                    <label for="nombre">{{ __('tipo_gasto.nombre_label') }}</label>
                    <input type="text" name="nombre" id="nombre" class="form-control" placeholder="{{ __('tipo_gasto.placeholder_nombre') }}" value="{{ old('nombre') }}">
                </div>
            </div>
        </div>

        <div class="modal-footer">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <button type="submit" class="btn btn-primary" id="btn_actualizar" onclick="btn_esconder()">{{ __('tipo_gasto.registrar') }}</button>
                <button type="button" data-dismiss="modal" class="btn btn-danger">{{ __('tipo_gasto.cancelar') }}</button>
            </div>
        </div>

        </form>
    </div>
  </div>
</div>

<!-- Modal -->
<div id="ModalEditar" class="modal fade" role="dialog">
  <div class="modal-dialog modal-md">
    <!-- Modal content-->
    <div class="modal-content">

      <div class="modal-header" style="background: #3c8dbc; color: white">
        <h3 class="modal-title">{{ __('tipo_gasto.modal_editar_titulo') }}</h3>
      </div>


      <div class="modal-body">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                <form
                    method="POST"
                    action="{{ route('tipo_gasto.update', 'null') }}"
                    enctype="multipart/form-data"
                    name="formulario_actualizar"
                    onkeypress="if(event.keyCode == 13) event.returnValue = false;"
                >
                    @csrf
                    @method('PUT')

                    <input type="hidden" name="id_empresa_edit" id="id_empresa_edit" value="{{ Auth::user()->id_empresa }}">
                    <input type="hidden" name="id_tipo_gasto_edit" id="id_tipo_gasto_edit" >

                    <div class="form-group">
                        <label for="nombre_edit">{{ __('tipo_gasto.nombre_label') }}</label>
                        <input
                            type="text"
                            name="nombre_edit"
                            id="nombre_edit"
                            class="form-control"
                            placeholder="{{ __('tipo_gasto.placeholder_nombre_edit') }}"
                            value="{{ old('nombre_edit') }}"
                        >
                    </div>

                    <div class="form-group" align="form-group">
                        <div class="list-group-item">
                            {{ __('tipo_gasto.estado_label') }}
                            <div class="material-switch pull-right">
                                <input id="estado_edit" name="estado_edit" type="checkbox" />
                                <label for="estado_edit" class="label-success"></label>
                            </div>
                        </div>

                        <div hidden>
                            {{ __('tipo_gasto.realiza_pedidos') }}
                            <div>
                                <input id="estado_pedido_edit" name="estado_pedido_edit" type="checkbox" />
                                <label for="estado_pedido_edit" class="label-success"></label>
                            </div>
                        </div>
                    </div>



            </div>
        </div>



      <div class="modal-footer">

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
          <button type="submit" class="btn btn-primary"  >{{ __('tipo_gasto.actualizar') }}</button>
          </form>
              <!--button class="btn btn-primary"  onclick="crearalimento()" id="btnregistrar">REGISTRAR</button-->
          <button data-dismiss="modal"  class="btn btn-danger">{{ __('tipo_gasto.cancelar') }}</button>

          <form  id="f_subir_imagen_tipo" name="f_subir_imagen_tipo" method="post"  action="subir_imagen_tipo" class="formulario_tipo" enctype="multipart/form-data"  hidden>

        <br>
                                         <input type="hidden" name="_token" id="_token"  value="<?= csrf_token(); ?>">
                          <input type="hidden" name="id_tipo_gasto_edit_2" id="id_tipo_gasto_edit_2" >
                            <div id="notificacion_perfil"></div>
                                <label class="btn btn-success">
                                    {{ __('tipo_gasto.buscar_img') }}
                                    <input type="file" name="perfil_imagen_tipo" id="perfil_imagen_tipo"   required style="display: none;">
                                </label>
                                 <button type="submit" class="btn btn-default"><i class="fa fa-upload" aria-hidden="true"></i> {{ __('tipo_gasto.subir_imagen') }}</button>



        </form>
       </div>
      </div>
    </div>
  </div>
</div>
