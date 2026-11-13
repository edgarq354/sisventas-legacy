
@extends ('layouts.inicio')
@section ('contenido')
@include('alerts.success')
@include('alerts.request')
@include('alerts.errors')

    <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 100%;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
      .controls {
        margin-top: 10px;
        border: 1px solid transparent;
        border-radius: 2px 0 0 2px;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        height: 32px;
        outline: none;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
      }

      #pac-input {
        background-color: #fff;
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
        margin-left: 12px;
        padding: 0 11px 0 13px;
        text-overflow: ellipsis;
        width: 300px;
      }

      #pac-input:focus {
        border-color: #4d90fe;
      }

      .pac-container {
        font-family: Roboto;
      }

      #type-selector {
        color: #fff;
        background-color: #4d90fe;
        padding: 5px 11px 0px 11px;
      }

      #type-selector label {
        font-family: Roboto;
        font-size: 13px;
        font-weight: 300;
      }
      #target {
        width: 345px;
      }








    </style>







    <script type="text/javascript">


function changeFunc(sel) {
   $("#nombre_tipo_producto").val(sel.options[sel.selectedIndex].text);
   }




      $(document).on("submit",".formulario_imagen1",function(e){
        e.preventDefault();
        var formu=$(this);
        var nombreform=$(this).attr("id");

        if(nombreform=="f_subir_imagen1" ){ var miurl="subir_imagen1";  var divresul="notificacion_imagen1"}
        //información del formulario
        var formData = new FormData($("#"+nombreform+"")[0]);

        //hacemos la petición ajax   
        $.ajax({
            url: miurl,  
            type: 'POST',
     
            // Form data
            //datos del formulario
            data: formData,
            //necesario para subir archivos via ajax
            cache: false,
            contentType: false,
            processData: false,
            //mientras enviamos el archivo
            beforeSend: function(){
              $("#"+divresul+"").html($("#cargador_empresa").html());                
            },
            //una vez finalizado correctamente
            success: function(data){
                alertify.success(@json(__('producto_tipo.imagen_agregada')));
              $("#"+divresul+"").html(@json(__('producto_tipo.imagen_agregada')));
              $('<li class="dropdown li"></li>').appendTo('#lista_imagen1').html('<img src="'+data+'" alt="" class="img-rounded img-thumbnail"  width="150px" />').addClass('success');
              $("#foto_imagen1").attr('src', $("#foto_imagen1").attr('src') + '?' + Math.random() );
            },
            //si ha ocurrido un error
            error: function(data){
               alertify.error(@json(__('producto_tipo.ha_ocurrido_error'))+data) ;
                
            }
        });
    });

 

 
</script>

	<div class="row">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
 {!!Form::open(['route'=>['producto_tipo.update','null'],'method'=>'PUT','enctype'=>'multipart/form-data','name'=>'formulario_actualizar','onKeypress'=>'if(event.keyCode == 13) event.returnValue = false;'])!!}
  

  @foreach($producto as $value)

<?php
$id_empresa=$value->id; 
$imagen1=$value->imagen1; 
?>

  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12  " > 
  <h2 align="left" style="color: black">{{ __('producto_tipo.editar_producto') }}</h2>
  <hr style="background-color: black; height: 1px;">
</div>


<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12  well " > 


    	<div class="col-lg-4 col-md-8 col-sm-10 col-xs-12  " > 
            <input type="hidden" name='id_producto' value="{{$value->id}}" />  

          	<div class="form-group">
              {{ __('producto_tipo.nombre_label') }}<br>
              <input type="text"  name="nombre" placeholder="{{ __('producto.placeholder_nombre') }}" class="form-control" id="nombre" value="{{$value->nombre}}" >
            </div>

            <div class="form-group">
              {{ __('producto_tipo.imei_label') }}<br>
              <input type="text"  name="imei"    class="form-control"  value="{{$value->imei}}"  >
            </div>


            <div class="form-group">
              {{ __('producto_tipo.precio_label') }}<br>
              <input type="decimal"  name="precio"   value="0" class="form-control"    value="{{$value->precio}}">
            </div>

             <div class="form-group">
              {{ __('producto_tipo.cantidad_label') }}<br>
              <input type="number"  name="cantidad"   value="0" class="form-control"  value="{{$value->cantidad}}"  >
            </div>


      </div>


      <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">

         {{ __('producto_tipo.buscar_categoria') }}
          <div class="form-group">
            <select name="id_tipo_producto" class="form-control selectpicker" id="id_tipo_producto" data-live-search="true"  onchange="changeFunc(this);">
               <option value="">  {{ __('producto_tipo.opt_buscar') }}                                </option>
                  @foreach($tipo_producto as $mov)
                  <option value="{{$mov->id}}"
                      @if($mov->id == $value->id_tipo_producto)
                      selected
                      @endif
                    >
                    {{$mov->nombre}}
                   </option>
                  @endforeach
              </select>
           
          </div>
           <div class="form-group">
          {{ __('producto_tipo.nombre_tipo_producto_label') }}<br>
          <input type="text"  name="nombre_tipo_producto"   id="nombre_tipo_producto" class="form-control"   value="{{$value->nombre_tipo}}" >
        </div>

        <div class="form-group">
          {{ __('producto_tipo.descripcion_label') }}<br>
          {!!Form::textarea('descripcion',$value->descripcion,['class'=>'form-control','placeholder'=>__('producto_tipo.placeholder_descripcion'),'style'=>'height:100px;'  ])!!}
        </div>
        {!!Form::submit(__('producto_tipo.actualizar_producto'),['class'=>'btn btn-primary','id'=>'btn_registrar','onclick'=>'btn_esconder()'])!!}
            <a href="{!!URL::to('producto_tipo')!!}" class="btn btn-danger">{{ __('producto_tipo.cancelar') }}</a>
        
      </div>
 
  
	  </div>

</div>


    
		
		
  </div>
 

@endforeach
</form>

  </div>
  





<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 " >
 
        <form  id="f_subir_imagen1" name="f_subir_imagen1" method="post"  action="subir_imagen1" class="formulario_imagen1" enctype="multipart/form-data" >  
        
         <input type="hidden" name="id_producto" id="id_producto" value="{{$id_empresa}}">

        <table class="table table-striped table-bodered  well "  >
            <tr style="background: #000; color: white"> <td>{{ __('producto_tipo.imagen_numero') }} </td></tr>
            <tr>
                <td>
                  
                           <input type="hidden" name="_token" id="_token"  value="<?= csrf_token(); ?>">
                            <div id="notificacion_imagen1"></div>
                            
                            <center><ul id="lista_imagen1"  class="nav navbar-nav">
                                     <li class="dropdown">
                                        <img src="../../../storage/{{$imagen1}}" class="img-rounded img-thumbnail" alt="" style="width: 100%; max-width: 250px;" ></img>
                                    </li>
                                    
                                    </ul></center>
                            
                          
                </td>
            </tr>
            <tr>
              <td>
                 <div class="btn-group">
                                 <button type="submit" class="btn btn-default"><i class="fa fa-upload" aria-hidden="true"></i> {{ __('producto_tipo.subir_imagen') }}</button>
                                <label class="btn btn-primary">
                                    {{ __('producto_tipo.buscar_puntos') }} <input type="file" name="perfil_imagen1" id="perfil_imagen1" class="perfil_imagen1"   required style="display: none;">
                                </label>
                            </div>       
              </td>
            </tr>
        </table> 
        </form>   
      </div>

 




</div>

   
@endsection

