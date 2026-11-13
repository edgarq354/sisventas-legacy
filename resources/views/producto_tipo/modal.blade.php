
<div class="modal fade" id="Modal_agregar_producto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static">
   <div class="modal-dialog modal-md">
    <!-- Modal content-->
    <div class="modal-content">

      <div class="modal-header" style="background: #3c8dbc; color: white">
        <h3 class="modal-title">AGREGAR CANTIDAD</h3>
      </div>   
      

      <div class="modal-body">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    {{Form::open(array('url' => 'Actualizar_producto_tipo','onKeypress'=>'if(event.keyCode == 13) event.returnValue = false;','enctype'=>'multipart/form-data'))}} 
   <input type="hidden" name="id_producto" id="id_producto"  value="0">
   <input type="hidden" name="cantidad_actual" id="cantidad_actual"  value="0">
                <label id="cantidad_actual_2"></label>
                  <div class="form-group">
                      {!!Form::label('cantidad a agregar','')!!}
                      {!!Form::text('cantidad_agregar','1',['id'=>'cantidad_agregar','class'=>'form-control'])!!}
                  </div>

        </div>
      </div>


      <div class="modal-footer">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

          {!!Form::submit('AGREGAR',['class'=>'btn btn-primary','id'=>'btn_actualizar','onclick'=>'btn_esconder()'])!!}
          </form>


          <button data-dismiss="modal"  class="btn btn-danger">CANCELAR</button>
       </div>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="Modal_agregar_producto_restar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static">
   <div class="modal-dialog modal-md">
    <!-- Modal content-->
    <div class="modal-content">

      <div class="modal-header" style="background: #3c8dbc; color: white">
        <h3 class="modal-title">RESTAR PRODUCTO</h3>
      </div>   
      

      <div class="modal-body">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    {{Form::open(array('url' => 'Actualizar_producto_tipo_menos','onKeypress'=>'if(event.keyCode == 13) event.returnValue = false;','enctype'=>'multipart/form-data'))}} 
   <input type="hidden" name="id_producto_2" id="id_producto_2"  value="0">
   <input type="hidden" name="cantidad_actual_2" id="cantidad_actual_2_menos"  value="0">
                <label id="cantidad_actual_2_2"></label>
                  <div class="form-group">
                      {!!Form::label('cantidad a agregar','')!!}
                      {!!Form::text('cantidad_agregar_2','1',['id'=>'cantidad_agregar','class'=>'form-control'])!!}
                  </div>

        </div>
      </div>


      <div class="modal-footer">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

          {!!Form::submit('RESTAR',['class'=>'btn btn-primary','id'=>'btn_actualizar','onclick'=>'btn_esconder()'])!!}
          </form>


          <button data-dismiss="modal"  class="btn btn-danger">CANCELAR</button>
       </div>
      </div>
    </div>
  </div>
</div>