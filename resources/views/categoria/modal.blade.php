<!-- Modal -->
<div id="ModalCrearNuevo" class="modal fade" role="dialog">
  <div class="modal-dialog modal-md">
    <!-- Modal content-->
    <div class="modal-content">

      <div class="modal-header" style="background: #3c8dbc; color: white">
        <h3 class="modal-title">REGISTRAR UNA NUEVA CATEGORIA</h3>
      </div>   
      

      <div class="modal-body">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    {!!Form::open(['route'=>'categoria.store', 'method'=>'POST' , 'enctype'=>'multipart/form-data','onKeypress'=>'if(event.keyCode == 13) event.returnValue = false;'])!!} 
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
        <h3 class="modal-title">ACTUALIZAR CATEGORIA</h3>
      </div>   
      

      <div class="modal-body">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

           {!!Form::open(['route'=>['categoria.update','null'],'method'=>'PUT','enctype'=>'multipart/form-data','name'=>'formulario_actualizar','onKeypress'=>'if(event.keyCode == 13) event.returnValue = false;'])!!}
          <input type="hidden" name="id_empresa_edit" id="id_empresa_edit" value="{{Auth::user()->id_empresa}}">
          <input type="hidden" name="id_categoria_edit" id="id_categoria_edit" >
                
               <div class="form-group">
                      {!!Form::label('Nombre','Nombre:')!!}
                      {!!Form::text('nombre_edit',null,['id'=>'nombre_edit','class'=>'form-control','placeholder'=>'Ingrese la categoria'])!!}
                  </div>

                <div align="form-group">
                <div class="list-group-item ">
                   Estado
                  <div class="material-switch pull-right">
                    <input id="estado_edit" name="estado_edit" type="checkbox"  />
                    <label for="estado_edit" class="label-success"></label>
                  </div>
                 </div>

                 <div hidden="">
                   Realiza Pedidos
                  <div class="material-switch pull-right">
                    <input id="estado_pedido_edit" name="estado_pedido_edit" type="checkbox"  />
                    <label for="estado_pedido_edit" class="label-success"></label>
                  </div>
                 </div>
               </div>
                    
                                                            
        </div>

      </div>


      <div class="modal-footer">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

          {!!Form::submit('ACTUALIZAR',['class'=>'btn btn-primary','onclick'=>'btn_esconder()'])!!}
          </form>
              <!--button class="btn btn-primary"  onclick="crearalimento()" id="btnregistrar">REGISTRAR</button-->
          <button data-dismiss="modal"  class="btn btn-danger">CANCELAR</button>

             <form  id="f_subir_imagen_perfil" name="f_subir_imagen_perfil" method="post"  action="subir_imagen_perfil" class="formulario_perfil" enctype="multipart/form-data" >  

 <h3>.</h3>
                                         <input type="hidden" name="_token" id="_token"  value="<?= csrf_token(); ?>">
                           <input type="hidden" name="id_categoria" id="id_categoria" >
                            <div id="notificacion_perfil"></div>
                                <label class="btn btn-primary">
                                    Buscar IMG ..
                                    <input type="file" name="perfil_imagen_perfil" id="perfil_imagen_perfil"   required style="display: none;">
                                </label>
                                 <button type="submit" class="btn btn-default"><i class="fa fa-upload" aria-hidden="true"></i> Subir Imagen</button>
                            

           
        </form>  
       </div>

 


      </div>


    </div>
  </div>
</div>
