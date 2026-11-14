<!-- Modal -->
<div id="ModalContraseña" class="modal fade" role="dialog">
  <div class="modal-dialog modal-md">
    <!-- Modal content-->
    <div class="modal-content">

      <div class="modal-header" style="background: #3c8dbc; color: white">
        <h3 class="modal-title"><b>{{ __('admins.cambiar_contrasena_titulo') }}</b></h3>
      </div>
      <div class="modal-body">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

          {{Form::open(array('url' => 'Cambiar_Password','onKeypress'=>'if(event.keyCode == 13) event.returnValue = false;'))}}
          <input type="hidden" name="id_empresa" id="id_empresa" >
                  {!!Form::label('password', __('admins.empresa_label'))!!} <font id="empresa" size="4"></font>
              <div class="form-group">
                  {!!Form::label('password', __('admins.nueva_contrasena_label'))!!}
                  {!!Form::text('password',null,['id'=>'password','class'=>'form-control','placeholder'=>__('admins.placeholder_nueva_contrasena')])!!}
              </div>
        </div>
      </div>
      <div class="modal-footer">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

          {!!Form::submit(__('admins.actualizar_mayus'),['class'=>'btn btn-primary','id'=>'btn_actualizar','onclick'=>'btn_esconder()'])!!}
          </form>
              <!--button class="btn btn-primary"  onclick="crearalimento()" id="btnregistrar">REGISTRAR</button-->
          <button data-dismiss="modal"  class="btn btn-danger">{{ __('admins.cancelar_mayus') }}</button>
       </div>
      </div>
    </div>
  </div>
</div>

