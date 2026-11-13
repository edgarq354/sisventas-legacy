<!-- Modal -->
<div id="ModalAdministrador" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header" style="background: #3c8dbc; color: white">
        <h3 class="modal-title"><b>ACTUALIZAR EMPRESA</b></h3>
      </div>   
      <div class="modal-body">
          {{Form::open(array('url' => 'actualizar_administrador'))}}  
          <input type="hidden" name="id_empresa" id="id_empresa">
                  <div class="form-group">
                      {!!Form::label('razon_social','Nombre:')!!}
                      {!!Form::text('razon_social',null,['id'=>'razon_social','class'=>'form-control','placeholder'=>'Ingrese el nombre'])!!}
                  </div>

                  <div class="form-group">
                      {!!Form::label('usuario','Usuario:')!!}
                      {!!Form::text('usuario',null,['id'=>'usuario','class'=>'form-control','placeholder'=>'Ingrese el usuario'])!!}
                  </div>                                    

                  <input type="hidden" name="usuario_aux" id="usuario_aux">

                  <div class="form-group" hidden="">
                    <img id="logo" src="" alt="Cargar Imagen" onclick="cargarImagen(this, 1)" class="point"/><br>
                    <input type="text" name="imagen" id="imagen">                  
                  </div>                                    
      </div>
      <div class="modal-footer">
          {!!Form::submit('ACTUALIZAR',['class'=>'btn btn-primary','id'=>'btn_actualizar','onclick'=>'btn_esconder()'])!!}
          </form>
              <!--button class="btn btn-primary"  onclick="crearalimento()" id="btnregistrar">REGISTRAR</button-->
          <button data-dismiss="modal"  class="btn btn-danger">CANCELAR</button>
      </div>
    </div>
  </div>
</div>



<!-- Modal -->
<div id="ModalContraseña" class="modal fade" role="dialog">
  <div class="modal-dialog modal-md">
    <!-- Modal content-->
    <div class="modal-content">

      <div class="modal-header" style="background: #3c8dbc; color: white">
        <h3 class="modal-title"><b>CAMBIAR CONTRASEÑA</b></h3>
      </div>   
      <div class="modal-body">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

          {{Form::open(array('url' => 'Cambiar_Password','onKeypress'=>'if(event.keyCode == 13) event.returnValue = false;'))}} 
          <?php //{!!Form::open(['route'=>['vehiculo.update','null'],'method'=>'PUT'])!!}  ?>
          <input type="hidden" name="id_empresa_pass" id="id_empresa_pass" >
                  {!!Form::label('password','ADMINISTRATIVO:')!!} <font id="empresa" size="4"></font>
              <div class="form-group">
                  {!!Form::label('password','Nueva Contraseña:')!!}
                  {!!Form::text('password',null,['id'=>'password','class'=>'form-control','placeholder'=>'Ingrese su nueva contraseña'])!!}
              </div>                                    
        </div>
      </div>
      <div class="modal-footer">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

          {!!Form::submit('ACTUALIZAR',['class'=>'btn btn-primary','id'=>'btn_actualizar','onclick'=>'btn_esconder()'])!!}
          </form>
              <!--button class="btn btn-primary"  onclick="crearalimento()" id="btnregistrar">REGISTRAR</button-->
          <button data-dismiss="modal"  class="btn btn-danger">CANCELAR</button>
       </div>
      </div>
    </div>
  </div>
</div>


