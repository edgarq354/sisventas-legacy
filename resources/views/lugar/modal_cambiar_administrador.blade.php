<!-- Modal -->
<div id="ModalCambiar" class="modal fade" role="dialog">
  <div class="modal-dialog modal-md">
    <!-- Modal content-->
    <div class="modal-content">

      <div class="modal-header" style="background: #3c8dbc; color: white">
        <h3 class="modal-title"><b>CAMBIAR ADMINISTRADOR</b></h3>
      </div>   
      <div class="modal-body">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

          {{Form::open(array('url' => 'Cambiar_Administrador_Lugar','onKeypress'=>'if(event.keyCode == 13) event.returnValue = false;'))}} 
          <?php //{!!Form::open(['route'=>['vehiculo.update','null'],'method'=>'PUT'])!!}  ?>
          <input type="hidden" name="id_empresa" id="id_empresa" value="{{$lugar[0]->id}}">
                  {!!Form::label('','EMPRESA:')!!} <font id="empresa" size="4"></font>
              <div class="form-group">
                  {!!Form::label('','Cambiar Administrador:')!!}
                  <select name="id_administrador" class="form-control selectpicker" id="id_administrador" data-live-search="true" >
              @foreach($administrador_libres as $mov)
              <option value="{{$mov->id}}">{{$mov->nombre}} {{$mov->apellido}} - {{$mov->celular}}</option>
              @endforeach
      </select>
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

