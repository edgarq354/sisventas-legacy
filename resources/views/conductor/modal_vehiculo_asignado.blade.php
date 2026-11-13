<!-- Modal -->
<div id="ModalCambiarVehiculo" class="modal fade" role="dialog">
  <div class="modal-dialog modal-md">
    <!-- Modal content-->
    <div class="modal-content">

      <div class="modal-header" style="background: #3c8dbc; color: white">
        <h3 class="modal-title"><b>CAMBIAR VEHICULO ASIGNADO</b></h3>
      </div>   
      

      <div class="modal-body">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

          {{Form::open(array('url' => 'Cambiar_vehiculo_asignacion','onKeypress'=>'if(event.keyCode == 13) event.returnValue = false;'))}} 
          <?php //{!!Form::open(['route'=>['vehiculo.update','null'],'method'=>'PUT'])!!}  ?>
          <input type="hidden" name="id_empresa" id="id_empresa" value="{{Auth::user()->id_empresa}}">
          <input type="hidden" name="ci_conductor" id="ci_conductor" value="{{$conductor[0]->ci}}">
                
              <div class="form-group">
                  {!!Form::label('','Cambiar de vehiculo asignado:')!!}
                  <select name="id_vehiculo_asignacion" class="form-control selectpicker" id="id_vehiculo_asignado" data-live-search="true" >
              @foreach($vehiculo as $mov)
              <option value="{{$mov->placa}}">{{$mov->placa}}  ->{{$mov->marca}} - {{$mov->tipo}}</option>
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
