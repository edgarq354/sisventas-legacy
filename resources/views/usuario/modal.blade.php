
<!--//////////////////////////////////-->
<!--MODAL DE ENVIAR NOTIFICACIONES-->
<!--//////////////////////////////////-->
<div class="modal fade" id="ModalNotificacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background: #3c8dbc; color: white">
        <h3 id="titulogalpon" class="modal-title"><b>ENVIAR NOTIFICAION</b></h3>
      </div>

      <div class="modal-body">
        {{Form::open(array('url' => 'notificacion_pasajero'))}}  
              <input type="hidden" name="token_not" id="token_not">
              
              <div class="form-group">
                  {!!Form::label('detalle','Mensaje:')!!}
                  {!!Form::textarea('detalle',null,['id'=>'detalle','class'=>'form-control','rows'=>'5','placeholder'=>'Ingrese el mensaje'])!!}
              </div>  
       
      </div>

  <div class="modal-footer">
      {!!Form::submit('ENVIAR',['class'=>'btn btn-primary','id'=>'btn_notificacion','onclick'=>'btn_esconder()'])!!}
      </form>
          <!--button class="btn btn-primary"  onclick="crearalimento()" id="btnregistrar">REGISTRAR</button-->
      <button data-dismiss="modal"  class="btn btn-danger">CANCELAR</button>
  </div>
    </div>
  </div>
</div>


<!--//////////////////////////////////-->
<!--MODAL PARA CAMBIAR ESTADO DEL USUARIOS-->
<!--//////////////////////////////////-->
<div class="modal fade" id="ModalBloqueo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background: #3c8dbc; color: white">
        <h3 id="titulogalpon" class="modal-title"><b>CAMBIAR ESTADO DEL PASAJERO</b></h3>        
      </div>

      <div class="modal-body">
        
        <b>Cambiar el estado del Pasajero.</b><br>
        <b>Estado activo: </b>El pasajero podra iniciar sesion y solicitar Taxi por aplicación.<br>
        <b>Estado inactivo: </b>El pasajero <b>NO</b> podra iniciar sesion ni solicitar Taxi por aplicación.<br>


            {{Form::open(array('url' => 'cargar_estado_bloqueo'))}}  
              <input type="hidden" name="token_not_usuario" id="token_not_usuario">
              <input type="hidden" name="id_usuario" id="id_usuario">
              
              <div class="form-group">
                  {!!Form::label('','Descripción:')!!}
                  {!!Form::textarea('descripcion_usu',null,['id'=>'descripcion_usu','class'=>'form-control','rows'=>'5','placeholder'=>'Ingrese el mensaje'])!!}
              </div>  
               <div align="form-group">
                <div class="list-group-item ">
                   Estado
                  <div class="material-switch pull-right">
                    <input id="estado_edit" name="estado_edit" type="checkbox"  />
                    <label for="estado_edit" class="label-success"></label>
                  </div>
                 </div>
               </div>
      </div>

  <div class="modal-footer">
      {!!Form::submit('ENVIAR',['class'=>'btn btn-primary','id'=>'btn_notificacion','onclick'=>'btn_esconder()'])!!}
      </form>
      <button data-dismiss="modal"  class="btn btn-danger">CANCELAR</button>
  </div>
    </div>
  </div>
</div>


