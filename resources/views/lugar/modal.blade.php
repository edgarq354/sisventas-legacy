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
    {!!Form::open(['route'=>'video.store', 'method'=>'POST' , 'enctype'=>'multipart/form-data','onKeypress'=>'if(event.keyCode == 13) event.returnValue = false;'])!!} 
   <input type="hidden" name="id_empresa" id="id_empresa" value="{{Auth::user()->id_empresa}}">
                
               <div class="form-group">
                      {!!Form::label('Nombre','Titulo:')!!}
                      {!!Form::text('titulo',null,['id'=>'nombre','class'=>'form-control','placeholder'=>'Ingrese el titulo'])!!}
                  </div>

                  <div class="form-group">
                      {!!Form::label('apellido','Descripcion:')!!}
                      {!!Form::text('descripcion',null,['id'=>'apellido','class'=>'form-control','placeholder'=>'Ingrese la descripcion'])!!}
                  </div>

                  <div class="form-group">
                      {!!Form::label('ci','URL:')!!}
                      {!!Form::text('url',null,['id'=>'ci','class'=>'form-control','placeholder'=>'Ingrese la URL'])!!}
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
<div id="ModalEditarVideo" class="modal fade" role="dialog">
  <div class="modal-dialog modal-md">
    <!-- Modal content-->
    <div class="modal-content">

      <div class="modal-header" style="background: #3c8dbc; color: white">
        <h3 class="modal-title">ACTUALIZAR VIDEO</h3>
      </div>   
      

      <div class="modal-body">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

           {!!Form::open(['route'=>['video.update','null'],'method'=>'PUT','enctype'=>'multipart/form-data','name'=>'formulario_actualizar','onKeypress'=>'if(event.keyCode == 13) event.returnValue = false;'])!!}
          <input type="hidden" name="id_empresa_edit" id="id_empresa_edit" value="{{Auth::user()->id_empresa}}">
          <input type="hidden" name="id_video_edit" id="id_video_edit" >
                
               <div class="form-group">
                      {!!Form::label('Nombre','Titulo:')!!}
                      {!!Form::text('titulo_edit',null,['id'=>'titulo_edit','class'=>'form-control','placeholder'=>'Ingrese el titulo'])!!}
                  </div>

                  <div class="form-group">
                      {!!Form::label('apellido','Descripción:')!!}
                      {!!Form::text('escripcion_edit',null,['id'=>'descripcion_edit','class'=>'form-control','placeholder'=>'Ingrese la descripción'])!!}
                  </div>

                  <div class="form-group">
                      {!!Form::label('ci','URL:')!!}
                      {!!Form::text('url_edit',null,['id'=>'url_edit','class'=>'form-control','placeholder'=>'Ingrese la URL'])!!}
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
