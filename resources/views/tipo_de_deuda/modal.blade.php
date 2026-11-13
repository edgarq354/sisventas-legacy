<!-- Modal -->
<div id="ModalCrearNuevo" class="modal fade" role="dialog">
  <div class="modal-dialog modal-md">
    <!-- Modal content-->
    <div class="modal-content">

      <div class="modal-header" style="background: #3c8dbc; color: white">
        <h3 class="modal-title">REGISTRAR UN NUEVO TIPO DE DEUDAS</h3>
      </div>   
      

      <div class="modal-body">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    {!!Form::open(['route'=>'tipo_de_deuda.store', 'method'=>'POST' , 'enctype'=>'multipart/form-data','onKeypress'=>'if(event.keyCode == 13) event.returnValue = false;'])!!} 
   <input type="hidden" name="id_empresa" id="id_empresa" value="{{Auth::user()->id_empresa}}">
                
               <div class="form-group">
                      {!!Form::label('Nombre','Nombre:')!!}
                      {!!Form::text('nombre',null,['id'=>'nombre','class'=>'form-control','placeholder'=>'Ingrese el nombre'])!!}
                  </div>

                 
                                 
        </div>
      </div>


      <div class="modal-footer">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

          {!!Form::submit('REGISTRAR',['class'=>'btn btn-primary','id'=>'btn_actualizar','onclick'=>'btn_esconder()'])!!}
          </form>

              <!--button class="btn btn-primary"  onclick="crearalimento()" id="btnregistrar">REGISTRAR</button-->
          <button data-dismiss="modal"  class="btn btn-danger">CANCELAR</button>
       </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div id="ModalEditar" class="modal fade" role="dialog">
  <div class="modal-dialog modal-md">
    <!-- Modal content-->
    <div class="modal-content">

      <div class="modal-header" style="background: #3c8dbc; color: white">
        <h3 class="modal-title">ACTUALIZAR EL TIPO DE DEUDA</h3>
      </div>   
      

      <div class="modal-body">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

           {!!Form::open(['route'=>['tipo_de_deuda.update','null'],'method'=>'PUT','enctype'=>'multipart/form-data','name'=>'formulario_actualizar','onKeypress'=>'if(event.keyCode == 13) event.returnValue = false;'])!!}
          <input type="hidden" name="id_empresa_edit" id="id_empresa_edit" value="{{Auth::user()->id_empresa}}">
          <input type="hidden" name="id_tipo_de_deuda_edit" id="id_tipo_de_deuda_edit" >
                
               <div class="form-group">
                      {!!Form::label('Nombre','Nombre:')!!}
                      {!!Form::text('nombre_edit',null,['id'=>'nombre_edit','class'=>'form-control','placeholder'=>'Ingrese la tipo_de_deuda'])!!}
               </div>
                <div align="form-group">
                  <div class="list-group-item ">
                     Estado
                    <div class="material-switch pull-right">
                      <input id="estado" name="estado_edit"  type="checkbox"   />
                      <label for="estado" class="label-success"  ></label>
                    </div>
                   </div>
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
