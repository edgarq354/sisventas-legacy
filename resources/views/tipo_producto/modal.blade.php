<!-- Modal -->
<div id="ModalCrearNuevo" class="modal fade" role="dialog">
  <div class="modal-dialog modal-md">
    <!-- Modal content-->
    <div class="modal-content">

      <div class="modal-header" style="background: #3c8dbc; color: white">
        <h3 class="modal-title">{{ __('tipo_producto.modal_crear_titulo') }}</h3>
      </div>   
      

      <div class="modal-body">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <form action="{{ route('tipo_producto.store') }}" method="POST" enctype="multipart/form-data" onkeypress="if(event.keyCode == 13) event.returnValue = false;">
        @csrf
         <input type="hidden" name="id_empresa" id="id_empresa" value="{{Auth::user()->id_empresa}}">
                
               <div class="form-group">
                    <label for="nombre">{{ __('tipo_producto.nombre_label') }}</label>
                    <input type="text" name="nombre" id="nombre" class="form-control" placeholder="{{ __('tipo_producto.placeholder_nombre') }}">
                  </div>



        </div>
      </div>


      <div class="modal-footer">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

          <button type="submit" class="btn btn-primary"  >
              {{ __('tipo_producto.registrar') }}
          </button>
          </form>

              <!--button class="btn btn-primary"  onclick="crearalimento()" id="btnregistrar">REGISTRAR</button-->
          <button data-dismiss="modal"  class="btn btn-danger">{{ __('tipo_producto.cancelar') }}</button>
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
        <h3 class="modal-title">{{ __('tipo_producto.modal_editar_titulo') }}</h3>
      </div>   
      

      <div class="modal-body">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

<form action="{{ route('tipo_producto.update', ['tipo_producto' => 0]) }}" method="POST" enctype="multipart/form-data" onkeypress="if(event.keyCode == 13) event.returnValue = false;">
    @csrf
    @method('PUT')
          <input type="hidden" name="id_empresa_edit" id="id_empresa_edit" value="{{Auth::user()->id_empresa}}">
          <input type="hidden" name="id_tipo_producto_edit" id="id_tipo_producto_edit" >
                
               <div class="form-group">
                      <label for="nombre_edit">{{ __('tipo_producto.nombre_label') }}</label>
                      <input
                          type="text"
                          name="nombre_edit"
                          id="nombre_edit"
                          class="form-control"
                          placeholder="{{ __('tipo_producto.placeholder_tipo_producto') }}"
                          value="{{ old('nombre_edit') }}"
                      >
                  </div>

                <div align="form-group">
                <div class="list-group-item ">
                   {{ __('tipo_producto.estado_label') }}
                  <div class="material-switch pull-right">
                    <input id="estado_edit" name="estado_edit" type="checkbox"  />
                    <label for="estado_edit" class="label-success"></label>
                  </div>
                 </div>

                 <div  hidden="">
                   {{ __('tipo_producto.realiza_pedidos') }}
                  <div >
                    <input id="estado_pedido_edit" name="estado_pedido_edit" type="checkbox"  />
                    <label for="estado_pedido_edit" class="label-success"></label>
                  </div>
                 </div>
               </div>
                    
                                                            
        </div>
      </div>


      <div class="modal-footer">
       
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

          <button type="submit" class="btn btn-primary" >{{ __('tipo_producto.actualizar') }}</button>

          </form>
              <!--button class="btn btn-primary"  onclick="crearalimento()" id="btnregistrar">REGISTRAR</button-->
          <button data-dismiss="modal"  class="btn btn-danger">{{ __('tipo_producto.cancelar') }}</button>

          <form  id="f_subir_imagen_tipo" name="f_subir_imagen_tipo" method="post"  action="subir_imagen_tipo" class="formulario_tipo" enctype="multipart/form-data"  hidden>  

<br>
                                         <input type="hidden" name="_token" id="_token"  value="<?= csrf_token(); ?>">
                          <input type="hidden" name="id_tipo_producto_edit_2" id="id_tipo_producto_edit_2" >
                            <div id="notificacion_perfil"></div>
                                <label class="btn btn-success">
                                    {{ __('tipo_producto.buscar_img') }}
                                    <input type="file" name="perfil_imagen_tipo" id="perfil_imagen_tipo"   required style="display: none;">
                                </label>
                                 <button type="submit" class="btn btn-default"><i class="fa fa-upload" aria-hidden="true"></i> {{ __('tipo_producto.subir_imagen') }}</button>
                            

           
        </form>  
       </div>
      </div>
    </div>
  </div>
</div>
