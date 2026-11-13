<!-- Modal -->
<div id="ModalCrearNuevo" class="modal fade" role="dialog">
  <div class="modal-dialog modal-md">
    <!-- Modal content-->
    <div class="modal-content">

      <div class="modal-header" style="background: #3c8dbc; color: white">
        <h3 class="modal-title">REGISTRAR UN NUEVO VIDEO</h3>
      </div>   
      

      <div class="modal-body">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    {!!Form::open(['route'=>'radio.store', 'method'=>'POST' , 'enctype'=>'multipart/form-data','onKeypress'=>'if(event.keyCode == 13) event.returnValue = false;'])!!} 
   <input type="hidden" name="id_empresa" id="id_empresa" value="{{Auth::user()->id_empresa}}">
   <input type="hidden" name="id_login" id="id_empresa" value="{{Auth::user()->id}}">
                
               <div class="form-group">
                      {!!Form::label('Nombre','Codigo de Radio:')!!}
                      {!!Form::text('id',null,['id'=>'nombre','class'=>'form-control','placeholder'=>'CODIGO DE RADIO'])!!}
                  </div>

                   <div class="form-group">
                      {!!Form::label('apellido','Marca:')!!}
                      {!!Form::text('marca',null,['id'=>'marca','class'=>'form-control','placeholder'=>'Ingrese la marca'])!!}
                  </div>
                  <div class="form-group">
                      {!!Form::label('apellido','Modelo:')!!}
                      {!!Form::text('modelo',null,['id'=>'modelo','class'=>'form-control','placeholder'=>'Ingrese el modelo'])!!}
                  </div>


                  <div class="form-group">
                      {!!Form::label('apellido','Descripcion:')!!}
                      {!!Form::textarea('descripcion',null,['id'=>'apellido','class'=>'form-control','placeholder'=>'Ingrese la descripcion'])!!}
                  </div>
                <div class="form-group">
                      {!!Form::label('traccion','Estado:')!!}
                            {!!Form::select('estado', array('1' => 'DISPONIBLE', '0' => 'NO DISPONIBLE','2'=>'EN REPARACIÓN'),null,array('class'=>'form-control'))!!}
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
        <h3 class="modal-title">ACTUALIZAR RADIO</h3>
      </div>   
      

      <div class="modal-body">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

           {!!Form::open(['route'=>['radio.update','null'],'method'=>'PUT','enctype'=>'multipart/form-data','name'=>'formulario_actualizar','onKeypress'=>'if(event.keyCode == 13) event.returnValue = false;'])!!}
           <input type="hidden" name="id_empresa_edit" id="id_empresa_edit" value="{{Auth::user()->id_empresa}}">
           <input type="hidden" name="id_login_edit" id="id_empresa_edit" value="{{Auth::user()->id}}">
          <input type="hidden" name="id_radio_edit" id="id_radio_edit" >
               
                <div class="form-group">
                      {!!Form::label('Nombre','Codigo de Radio:')!!}
                      {!!Form::text('id',null,['id'=>'codigo_radio','class'=>'form-control','placeholder'=>'CODIGO DE RADIO','disabled'=>'disabled'])!!}
                  </div>
                  <div class="form-group">
                      {!!Form::label('apellido','Marca:')!!}
                      {!!Form::text('marca_edit',null,['id'=>'marca_edit','class'=>'form-control','placeholder'=>'Ingrese la marca'])!!}
                  </div>
                  <div class="form-group">
                      {!!Form::label('apellido','Modelo:')!!}
                      {!!Form::text('modelo_edit',null,['id'=>'modelo_edit','class'=>'form-control','placeholder'=>'Ingrese el modelo'])!!}
                  </div>

                  <div class="form-group">
                      {!!Form::label('apellido','Descripcion:')!!}
                      {!!Form::textarea('descripcion_edit',null,['id'=>'descripcion_edit','class'=>'form-control','placeholder'=>'Ingrese la descripcion'])!!}
                  </div>
                <div class="form-group">
                      {!!Form::label('traccion_edit','Estado:')!!}
                            {!!Form::select('estado_edit', array('1' => 'DISPONIBLE', '0' => 'NO DISPONIBLE','2'=>'EN REPARACIÓN'),null,array('id'=>'estado_edit','class'=>'form-control'))!!}
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
