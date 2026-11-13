@extends ('layouts.inicio')
@section ('contenido')
@include('alerts.success')
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

    <style type="text/css">
    .li {
    float: left;
}
</style>

<script type="text/javascript">
  
  $(document).on("submit",".formulario_ci",function(e){
        e.preventDefault();
        var formu=$(this);
        var nombreform=$(this).attr("id");

        if(nombreform=="f_subir_imagen_ci" ){ var miurl="subir_imagen_ci";  var divresul="notificacion_ci"}
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
              alertify.success("Imagen agregada correctamente");
              $("#"+divresul+"").html("Imagen agregada correctamente");
              $('<li class="dropdown li"></li>').appendTo('#lista_cedula').html('<img src="'+data+'" alt="" class="img-rounded img-thumbnail"  width="150px" />').addClass('success');
              $("#fotografia_ci").attr('src', $("#fotografia_ci").attr('src') + '?' + Math.random() );               
            },
            //si ha ocurrido un error
            error: function(data){
               alertify.error("ha ocurrido un error") ;
                
            }
        });
    });

    $(document).on("submit",".formulario_licencia",function(e){
        e.preventDefault();
        var formu=$(this);
        var nombreform=$(this).attr("id");

        if(nombreform=="f_subir_imagen_licencia" ){ var miurl="subir_imagen_licencia";  var divresul="notificacion_licencia"}
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
              alertify.success("Imagen agregada correctamente");
              $("#"+divresul+"").html("Imagen agregada correctamente");
              $('<li class="dropdown li"></li>').appendTo('#lista_licencia').html('<img src="'+data+'" alt="" class="img-rounded img-thumbnail"  width="150px" />').addClass('success');
              $("#fotografia_licencia").attr('src', $("#fotografia_licencia").attr('src') + '?' + Math.random() );               
            },
            //si ha ocurrido un error
            error: function(data){
               alertify.error("ha ocurrido un error") ;
                
            }
        });
    });

    $(document).on("submit",".formulario_ham",function(e){
        e.preventDefault();
        var formu=$(this);
        var nombreform=$(this).attr("id");

        if(nombreform=="f_subir_imagen_ham" ){ var miurl="subir_imagen_ham";  var divresul="notificacion_ham"}
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
              alertify.success("Imagen agregada correctamente");
              $("#"+divresul+"").html("Imagen agregada correctamente");
              $('<li class="dropdown li"></li>').appendTo('#lista_ham').html('<img src="'+data+'" alt="" class="img-rounded img-thumbnail"  width="150px" />').addClass('success');
              $("#fotografia_ham").attr('src', $("#fotografia_ham").attr('src') + '?' + Math.random() );               
            },
            //si ha ocurrido un error
            error: function(data){
               alertify.error("ha ocurrido un error") ;
                
            }
        });
    });

    $(document).on("submit",".formulario_transito",function(e){
        e.preventDefault();
        var formu=$(this);
        var nombreform=$(this).attr("id");

        if(nombreform=="f_subir_imagen_transito" ){ var miurl="subir_imagen_transito";  var divresul="notificacion_transito"}
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
              alertify.success("Imagen agregada correctamente");
              $("#"+divresul+"").html("Imagen agregada correctamente");
              $('<li class="dropdown li"></li>').appendTo('#lista_transito').html('<img src="'+data+'" alt="" class="img-rounded img-thumbnail"  width="150px" />').addClass('success');
              $("#fotografia_transito").attr('src', $("#fotografia_transito").attr('src') + '?' + Math.random() );               
            },
            //si ha ocurrido un error
            error: function(data){
               alertify.error("ha ocurrido un error") ;
                
            }
        });
    });

    $(document).on("submit",".formulario_factura",function(e){
        e.preventDefault();
        var formu=$(this);
        var nombreform=$(this).attr("id");

        if(nombreform=="f_subir_imagen_factura" ){ var miurl="subir_imagen_factura";  var divresul="notificacion_factura"}
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
              alertify.success("Imagen agregada correctamente");
              $("#"+divresul+"").html("Imagen agregada correctamente");
              $('<li class="dropdown li"></li>').appendTo('#lista_factura').html('<img src="'+data+'" alt="" class="img-rounded img-thumbnail"  width="150px" />').addClass('success');
              $("#fotografia_factura").attr('src', $("#fotografia_factura").attr('src') + '?' + Math.random() );               
            },
            //si ha ocurrido un error
            error: function(data){
               alertify.error("ha ocurrido un error") ;
                
            }
        });
    });

    $(document).on("submit",".formulario_antecedentes",function(e){
        e.preventDefault();
        var formu=$(this);
        var nombreform=$(this).attr("id");

        if(nombreform=="f_subir_imagen_antecedentes" ){ var miurl="subir_imagen_antecedentes";  var divresul="notificacion_antecedentes"}
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
              alertify.success("Imagen agregada correctamente");
              $("#"+divresul+"").html("Imagen agregada correctamente");
              $('<li class="dropdown li"></li>').appendTo('#lista_antecedentes').html('<img src="'+data+'" alt="" class="img-rounded img-thumbnail"  width="150px" />').addClass('success');
              $("#fotografia_antecedentes").attr('src', $("#fotografia_antecedentes").attr('src') + '?' + Math.random() );               
            },
            //si ha ocurrido un error
            error: function(data){
               alertify.error("ha ocurrido un error") ;
                
            }
        });
    });
$(document).on("submit",".formulario_felcc",function(e){
        e.preventDefault();
        var formu=$(this);
        var nombreform=$(this).attr("id");

        if(nombreform=="f_subir_imagen_felcc" ){ var miurl="subir_imagen_felcc";  var divresul="notificacion_felcc"}
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
              
              alertify.success('Imagen Agregada correctamente');
              $("#"+divresul+"").html("Imagen agregada correctamente");
              $('<li class="dropdown li"></li>').appendTo('#lista_felcc').html('<img src="'+data+'" alt="" class="img-rounded img-thumbnail"  width="150px" />').addClass('success');
              $("#fotografia_felcc").attr('src', $("#fotografia_felcc").attr('src') + '?' + Math.random() );               
            },
            //si ha ocurrido un error
            error: function(data){
               alert("ha ocurrido un error") ;
                alertify.error('Ocurrio un error');
            }
        });
    });






</script>



  <!--//////////////////////////////////////////////////////////////////////////////////////////////////////-->
<!--        MODAL          -->
<!--//////////////////////////////////////////////////////////////////////////////////////////////////////-->
<!--/////////////////////       //////////                       ////////////////////////////////////////////-->
<!--/////////////////////       //////////                       ////////////////////////////////////////////-->
<!--/////////////////////       //////////                       ////////////////////////////////////////////-->
<!--/////////////////////       //////////      /////////////////////////////////////////////////////////////-->
<!--/////////////////////       //////////      /////////////////////////////////////////////////////////////-->
<!--/////////////////////       //////////      /////////////////////////////////////////////////////////////-->
<!--/////////////////////       //////////      /////////////////////////////////////////////////////////////-->
<!--/////////////////////       //////////      /////////////////////////////////////////////////////////////-->
<!--/////////////////////       //////////      /////////////////////////////////////////////////////////////-->
<!--/////////////////////       //////////      /////////////////////////////////////////////////////////////-->
<!--/////////////////////                                     ///////////////////////////////////////////////-->
<!--/////////////////////                                     ///////////////////////////////////////////////-->
<!--/////////////////////       //////////      /////////////////////////////////////////////////////////////-->
<!--/////////////////////       //////////      /////////////////////////////////////////////////////////////-->
<!--/////////////////////       //////////      /////////////////////////////////////////////////////////////-->
<!--/////////////////////       //////////      /////////////////////////////////////////////////////////////-->
<!--/////////////////////       //////////      /////////////////////////////////////////////////////////////-->
<!--/////////////////////       //////////      /////////////////////////////////////////////////////////////-->
<!--/////////////////////       //////////      /////////////////////////////////////////////////////////////-->
<!--/////////////////////       //////////      /////////////////////////////////////////////////////////////-->
<!--/////////////////////       //////////      /////////////////////////////////////////////////////////////-->
<!--/////////////////////       //////////                        ///////////////////////////////////////////-->
<!--/////////////////////       //////////                        ///////////////////////////////////////////-->
<!--/////////////////////       //////////                        ///////////////////////////////////////////-->
<!--/////////////////////////////////////////////////////////////////////////////////////////////////////////-->
<!--/////////////////////////////////////////////////////////////////////////////////////////////////////////-->

  <!--//////////////////////////////////-->
<!--MODAL DE ENVIAR NOTIFICACIONES-->
<!--//////////////////////////////////-->
 
 <div id="historial_imei" class="modal fade" role="dialog">
  <div class="modal-dialog modal-md">
    <!-- Modal content-->
    <div class="modal-content">

      <div class="modal-header" style="background: #3c8dbc; color: white">
        <h3 class="modal-title"><b>HISTORIAL DE IMEI</b></h3>
          <button data-dismiss="modal"  class="btn btn-danger">OCUTAR</button>
        
      </div>   
      <div class="modal-body" style="width: 100%;">

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
<table class="table table-striped table-bordered table-condensed table-hover" style="background: white" id="tabla_sin_imprimir">
          <thead>
            <tr>
            <th style="width: 170px;"><center>FECHA</center></th>
            <th><center>IMEI</center></th> 
            </tr>
          </thead>

          <tbody align="center" >          
          @foreach($imei as $con)
          <tr>
            <td>{{ $con->fecha}}</td>
            <td>{{ $con->imei}}</td> 
          </tr>
          @endforeach
          </tbody>

        </table>

            
          </div>                    
      </div>
      <div class="modal-footer">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
          <button data-dismiss="modal"  class="btn btn-danger">OCUTAR</button>
       </div>
      </div>
    </div>
  </div>
</div>




<div class="modal fade" id="ModalNotificacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background: #3c8dbc; color: white">
        <h3 id="titulogalpon" class="modal-title"><b>ENVIAR NOTIFICAION</b></h3>
      </div>

      <div class="modal-body">
    {{Form::open(array('url' => 'notificacion_conductor_2'))}}  
      <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
              <input type="hidden" name="token_not" id="token_not">
              
              <div class="form-group">
                  {!!Form::label('detalle','Mensaje:')!!}
                  {!!Form::textarea('detalle',null,['id'=>'detalle','class'=>'form-control','rows'=>'5','placeholder'=>'Ingrese el mensaje'])!!}
              </div>  
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
<!--DAR DE BAJA AL VEHICULO CON LA DESCRIPCION DE LA BAJA-->
<!--//////////////////////////////////-->
<div class="modal fade" id="ModalBaja" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background: #3c8dbc; color: white">
        <h3 id="titulogalpon" class="modal-title"><b>REGISTRAR LA BAJA DE CONDUCTOR</b></h3>
      </div>

      <div class="modal-body">
    {{Form::open(array('url' => 'dar_de_baja_conductor'))}}  
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
              <input type="hidden" name="token_not" id="token_not">
              <input type="hidden" name="numero_movil" id="numero_movil" value="{{$conductor[0]->numero_movil}}">

              <div class="form-group" >
               {!!Form::label('fecha','Fecha:')!!}              
              <div class='input-group date' id='datetimepicker10'>
                <input type='text' class="form-control" id="fecha" name="fecha" value="{{date('Y-m-j')}}" style="font-size:20px;text-align:left" />
                <span class="input-group-addon ">
                   <span class="fa fa-calendar" aria-hidden="true"></span> 
                </span>
              </div>
            </div>  

              <div class="form-group">
                  {!!Form::label('detalle','Descripcion de la baja del Conductor:')!!}
                  {!!Form::textarea('descripcion','Se retiro de la empresa',['id'=>'detalle','class'=>'form-control','rows'=>'5'])!!}
              </div> 

              
      </div>
      
      <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12" align="center">
            <input type="hidden" name="ci_conductor" id="ci_conductor" value="{{$conductor[0]->ci}}">
      </div>

  </div>

  <div class="modal-footer">
      {!!Form::submit('REGISTRAR',['class'=>'btn btn-primary','id'=>'btn_notificacion','onclick'=>'btn_esconder()'])!!}
      </form>
          <!--button class="btn btn-primary"  onclick="crearalimento()" id="btnregistrar">REGISTRAR</button-->
      <button data-dismiss="modal"  class="btn btn-danger">CANCELAR</button>
  </div>
    </div>
  </div>
</div>


<div class="modal fade" id="ModalAlta" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background: #3c8dbc; color: white">
        <h3 id="titulogalpon" class="modal-title"><b>REGISTRAR ALTA DEL CONDUCTOR</b></h3>
      </div>

      <div class="modal-body">
    {{Form::open(array('url' => 'dar_de_alta_conductor'))}}  
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
              <input type="hidden" name="token_not" id="token_not">
              <input type="hidden" name="numero_movil" id="numero_movil" value="{{$conductor[0]->numero_movil}}">

              <div class="form-group" >
               {!!Form::label('fecha','Fecha:')!!}              
              <div class='input-group date' id='datetimepicker10'>
                <input type='text' class="form-control" id="fecha" name="fecha" value="{{date('Y-m-j')}}" style="font-size:20px;text-align:left" />
                <span class="input-group-addon ">
                   <span class="fa fa-calendar" aria-hidden="true"></span> 
                </span>
              </div>
            </div>  

              <div class="form-group">
                  {!!Form::label('detalle','Descripcion de la alta del Conductor')!!}
                  {!!Form::textarea('descripcion','Se registro nuevamente en la empresa',['id'=>'detalle','class'=>'form-control','rows'=>'5'])!!}
              </div> 

              
      </div>
      
      <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12" align="center">
            <input type="hidden" name="ci_conductor" id="ci_conductor" value="{{$conductor[0]->ci}}">
      </div>

  </div>

  <div class="modal-footer">
      {!!Form::submit('REGISTRAR',['class'=>'btn btn-primary','id'=>'btn_notificacion','onclick'=>'btn_esconder()'])!!}
      </form>
          <!--button class="btn btn-primary"  onclick="crearalimento()" id="btnregistrar">REGISTRAR</button-->
      <button data-dismiss="modal"  class="btn btn-danger">CANCELAR</button>
  </div>
    </div>
  </div>
</div>


<div class="modal fade" id="ModalActivar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background:green; color: white">
        <h3 id="titulogalpon" class="modal-title"><b>REGISTRAR EN CONDUCTORES ACTIVOS</b></h3>
      </div>

      <div class="modal-body">
    {{Form::open(array('url' => 'activar_conductor'))}}  
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
              <input type="hidden" name="token_not" id="token_not">
 
<LABEL>
  ¿Desea registrar en la lista de Conductores activos?
</LABEL>
              
      </div>
      
      <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12" align="center">
            <input type="hidden" name="ci_conductor" id="ci_conductor" value="{{$conductor[0]->ci}}">
            <input type="hidden" name="placa_vehiculo" id="placa_vehiculo" value="{{$conductor[0]->id_vehiculo}}">
      </div>

  </div>

  <div class="modal-footer">
      {!!Form::submit('SI',['class'=>'btn btn-success','id'=>'btn_notificacion','onclick'=>'btn_esconder()'])!!}
      </form>
          <!--button class="btn btn-primary"  onclick="crearalimento()" id="btnregistrar">REGISTRAR</button-->
      <button data-dismiss="modal"  class="btn btn-danger">NO</button>
  </div>
    </div>
  </div>
</div>

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
          <p>En la lista se lo mostrara todos los conductores que no estan asignados con ningun vehículo.</p>
          <br>

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
              <br><br>                                 
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



<!-- Modal -->
<div id="ModalEliminarVehiculo" class="modal fade" role="dialog">
  <div class="modal-dialog modal-md">
    <!-- Modal content-->
    <div class="modal-content">

      <div class="modal-header" style="background: #3c8dbc; color: white">
        <h3 class="modal-title"><b>LIBERAR EL CONDUCTOR</b></h3>
      </div>   
      

      <div class="modal-body">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
          <p>El conductor estara inhabilitado para recibir solicitudes hasta que se le asigne con un nuevo Movil.</p>
          <br> 
          <label>¿Desea confirmar la liberación del Movil?</label>
          

          {{Form::open(array('url' => 'Liberar_conductor','onKeypress'=>'if(event.keyCode == 13) event.returnValue = false;'))}} 
          <?php //{!!Form::open(['route'=>['vehiculo.update','null'],'method'=>'PUT'])!!}  ?>
          <input type="hidden" name="id_empresa" id="id_empresa" value="{{Auth::user()->id_empresa}}">
          <input type="hidden" name="ci_conductor" id="ci_conductor" value="{{$conductor[0]->ci}}">
          @if($conductor[0]->id_vehiculo!=0)
           <label>PLACA: {{$conductor[0]->id_vehiculo}}</label>
            @endif
                
        </div>
      </div>


      <div class="modal-footer">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

          {!!Form::submit('CONFIRMAR',['class'=>'btn btn-primary','id'=>'btn_actualizar','onclick'=>'btn_esconder()'])!!}
          </form>
              <!--button class="btn btn-primary"  onclick="crearalimento()" id="btnregistrar">REGISTRAR</button-->
          <button data-dismiss="modal"  class="btn btn-danger">CANCELAR</button>
       </div>
      </div>
    </div>
  </div>
</div>



  <!--//////////////////////////////////////////////////////////////////////////////////////////////////////-->
<!--        MODAL          -->
<!--//////////////////////////////////////////////////////////////////////////////////////////////////////-->
<!--/////////////////////       //////////                       ////////////////////////////////////////////-->
<!--/////////////////////       //////////                       ////////////////////////////////////////////-->
<!--/////////////////////       //////////                       ////////////////////////////////////////////-->
<!--/////////////////////       //////////      /////////////////////////////////////////////////////////////-->
<!--/////////////////////       //////////      /////////////////////////////////////////////////////////////-->
<!--/////////////////////       //////////      /////////////////////////////////////////////////////////////-->
<!--/////////////////////       //////////      /////////////////////////////////////////////////////////////-->
<!--/////////////////////       //////////      /////////////////////////////////////////////////////////////-->
<!--/////////////////////       //////////      /////////////////////////////////////////////////////////////-->
<!--/////////////////////       //////////      /////////////////////////////////////////////////////////////-->
<!--/////////////////////                                     ///////////////////////////////////////////////-->
<!--/////////////////////                                     ///////////////////////////////////////////////-->
<!--/////////////////////       //////////      /////////////////////////////////////////////////////////////-->
<!--/////////////////////       //////////      /////////////////////////////////////////////////////////////-->
<!--/////////////////////       //////////      /////////////////////////////////////////////////////////////-->
<!--/////////////////////       //////////      /////////////////////////////////////////////////////////////-->
<!--/////////////////////       //////////      /////////////////////////////////////////////////////////////-->
<!--/////////////////////       //////////      /////////////////////////////////////////////////////////////-->
<!--/////////////////////       //////////      /////////////////////////////////////////////////////////////-->
<!--/////////////////////       //////////      /////////////////////////////////////////////////////////////-->
<!--/////////////////////       //////////      /////////////////////////////////////////////////////////////-->
<!--/////////////////////       //////////                        ///////////////////////////////////////////-->
<!--/////////////////////       //////////                        ///////////////////////////////////////////-->
<!--/////////////////////       //////////                        ///////////////////////////////////////////-->
<!--/////////////////////////////////////////////////////////////////////////////////////////////////////////-->
<!--/////////////////////////////////////////////////////////////////////////////////////////////////////////-->








<script type="text/javascript">

  function cargar_usuario(){
    var ci=$("#ci").val();
    $("#usuario").val(ci);
    $("#contrasenia").val(ci);
  } 


function enviar_notificacion_activar()
{       var token_conductor=$("#token_conductor").val();
        var  token = $('input[name="_token"]').val();
        var formData =  new FormData();    
        formData.append( 'token', token_conductor); 
        formData.append( '_token', token);
 $.ajax({


            url: '../enviar_notificacion_activar',  
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
               alertify.success("inicio proceso");               
            },
            //una vez finalizado correctamente
            success: function(data){
              alertify.success("Notificacion enviada para la activación");
            },
            //si ha ocurrido un error
            error: function(data){
               alertify.error("Ha ocurrido un error") ;
                
            }
        });
}

function enviar_notificacion_desactivar()
{
     var token_conductor=$("#token_conductor").val();
          var  token = $('input[name="_token"]').val();
        var formData =  new FormData();    
        formData.append( 'token', token_conductor); 
        formData.append( '_token', token);
 $.ajax({


            url: '../enviar_notificacion_desactivar',  
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
                       alertify.success("inicio proceso");                  
            },
            //una vez finalizado correctamente
            success: function(data){
              alertify.success("Notificacion enviada para la desactivación");
            },
            //si ha ocurrido un error
            error: function(data){
               alertify.error("Ha ocurrido un error") ;
                
            }
        });
}

function enviar_notificacion_contacto()
{
     var token_conductor=$("#token_conductor").val();
     var id_conductor=$("#id_conductor").val();
          var  token = $('input[name="_token"]').val();
        var formData =  new FormData();    
        formData.append( 'token', token_conductor); 
        formData.append( 'id_conductor', id_conductor); 
        formData.append( '_token', token);
 $.ajax({


            url: '../enviar_notificacion_contacto',  
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
                       alertify.success("inicio proceso");                  
            },
            //una vez finalizado correctamente
            success: function(data){
              alertify.success("Notificacion enviada para obtener contacto");
            },
            //si ha ocurrido un error
            error: function(data){
               alertify.error("Ha ocurrido un error") ;
                
            }
        });
}


  //FOTO DE PERFIL

  $(document).on("submit",".formulario_perfil",function(e){
        e.preventDefault();
        var formu=$(this);
        var nombreform=$(this).attr("id");

        if(nombreform=="f_subir_imagen_perfil" ){ var miurl="subir_imagen_perfil";  var divresul="notificacion_perfil"}
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
              alertify.success("Imagen agregada correctamente");
              $("#"+divresul+"").html("Imagen agregada correctamente");



              $('<li class="col-md-2 bg-gray" style="border-radius: 5px;"></li>').appendTo('#lista_perfil').html('<img src="'+data+'"    class="thumbnail"   width="100px" height="100px" />').addClass('success');
              $("#fotografia_perfil").attr('src', $("#fotografia_perfil").attr('src') + '?' + Math.random() );               
            },
            //si ha ocurrido un error
            error: function(data){
               alertify.error("ha ocurrido un error") ;
                
            }
        });
    });




</script>

<div style="display: none;" id="cargador_empresa" align="center">
            <br>
         

         <label style="color:#FFF; background-color:#ABB6BA; text-align:center">&nbsp;&nbsp;&nbsp;Espere... &nbsp;&nbsp;&nbsp;</label>

         <img src="../../images/cargando.gif" align="middle" alt="cargador"> &nbsp;<label style="color:#ABB6BA">Realizando tarea solicitada ...</label>

          <br>
         <hr style="color:#003" width="50%">
         <br>
       </div>



<div class="row">

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

     @if($conductor[0]->estado_asignacion!=6 && $conductor[0]->pre_registro==0)

          <div class="  col-lg-2 col-md-2 col-sm-2 col-xs-2 ">
          <div class="panel-group">
                  <div class="panel panel-primary">
                    <div class="panel-body">
                    <label>
                      <i class="fa fa-car" aria-hidden="true"></i> {{$conductor[0]->numero_movil}}
                    </label>
                  
                    <label style="color: orange;" >
                      <i class="fa fa-star" aria-hidden="true"></i> {{$conductor[0]->calificacion}}
                    </label>

                    <label onclick="enviar_notificacion_activar();"  style="cursor: pointer;">
                      <i class="fa fa-superpowers" style="color: green;" aria-hidden="true"></i> Send
                    </label>

                    <label onclick="enviar_notificacion_desactivar();" style="cursor: pointer;">
                      <i class="fa fa-ban" style="color: black;" aria-hidden="true"></i> Cancel
                    </label>
                    <label onclick="enviar_notificacion_contacto();" style="cursor: pointer;">
                      <i class="fa fa-user" style="color: green;" aria-hidden="true"></i> Obtener Contactos
                    </label>
                </div>
            </div>
          </div>
          <input type="hidden" id="token_conductor" value="{{$conductor[0]->token}}">
          <input type="hidden" id="id_conductor" value="{{$conductor[0]->ci}}">    
         </div>



      <a target="_blank"  href="{!!URL::to('conductors/kardex_pdf',$conductor[0]->ci)!!}" data-toggle="tooltip" data-placement="top" title="Imprimir Kardex" > 
    
        <div class="col-lg-1 col-xs-3">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner fa fa-address-card fa-2x">
            </div>
          <p class="small-box-footer"> Kardex</p>
          </div>
        </div>
        </a>
 @endif
 
        <?php
        $asi="Asinar"; 
          if($conductor[0]->id_vehiculo!=0){
            $asi="Cambiar de movil";
          }
        ?>

 
     <a href="" data-toggle="modal" data-target="#ModalCambiarVehiculo"  >
        <div class="col-lg-2 col-md-3 col-sm-4 col-xs-5">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner fa fa-link fa-2x">             
            </div>
             @if($conductor[0]->id_vehiculo!=0)
            {{$conductor[0]->id_vehiculo}}
            @else
            No tiene movil
            @endif
          <p class="small-box-footer">{{$asi}}</p>
          </div>
        </div>
        </a>

      @if($conductor[0]->id_vehiculo!=0)
         

          <div class="col-lg-2 col-xs-3">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner fa fa-car fa-2x">             
            </div>
             
             <a href="../vehiculo/{{$conductor[0]->id_vehiculo}}/edit "  style="color: white;">  {{$conductor[0]->id_vehiculo}}</a>
            

             <a href="" data-toggle="modal" data-target="#ModalEliminarVehiculo"  class="small-box-footer">liberar movil<i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        @endif

         @if($conductor[0]->estado_asignacion!=6&& $conductor[0]->pre_registro==1)
        <a  href='../conductors_pdf/{{$conductor[0]->ci}}' aria-hidden="true"  data-toggle="tooltip" data-placement="top" title="Codigo QR" target="_blanck">
        <div class="col-lg-1 col-xs-3">
          <!-- small box -->
          <div class="small-box bg-gray">
            <div class="inner fa fa-qrcode fa-2x">
            </div>
          <p class="small-box-footer"> Codigo QR</p>
          </div>
        </div>
        </a>
  @endif

          @if($conductor[0]->estado_asignacion==6 && $conductor[0]->pre_registro==1)
          
          @else

            <a href="" data-toggle="modal" data-target="#ModalNotificacion"  onclick="cargar_token_conductor('{{$conductor[0]->token}}');"> 
            <div class="col-lg-1 col-xs-3">
              <!-- small box -->
              <div class="small-box bg-aqua">
                <div class="inner fa fa-commenting-o fa-2x">
                </div>
              <p class="small-box-footer"> Notificación</p>
              </div>
            </div>
            </a>
          @endif
       @if($conductor[0]->estado_asignacion==6 && $conductor[0]->pre_registro==1)
       <a href="" target="_blank"   data-toggle="modal" data-target="#ModalActivar"   data-toggle="tooltip" data-placement="top" title="Registrar la baja el Conductor"> 
        <div class="col-lg-2 col-xs-3">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner fa fa-arrow-up fa-2x">
            </div>
          <p class="small-box-footer">Registrar en Activos</p>
          </div>
        </div>
        </a>
@elseif($conductor[0]->estado_asignacion==6)
       <a href="" target="_blank"   data-toggle="modal" data-target="#ModalAlta"   data-toggle="tooltip" data-placement="top" title="Registrar la baja el Conductor"> 
        <div class="col-lg-1 col-xs-3">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner fa fa-arrow-up fa-2x">
            </div>
          <p class="small-box-footer"> Dar de alta</p>
          </div>
        </div>
        </a>
@else
   <a href="" target="_blank"   data-toggle="modal" data-target="#ModalBaja"   data-toggle="tooltip" data-placement="top" title="Registrar la baja el Conductor"> 
        <div class="col-lg-1 col-xs-3">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner fa fa-arrow-down fa-2x">
            </div>
          <p class="small-box-footer"> Dar de baja</p>
          </div>
        </div>
        </a>
@endif       

      

@if($conductor[0]->estado_asignacion!=6 && $conductor[0]->pre_registro==0)
        <div class="btn-group">
                            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
          <!-- small box -->
                                <div class="inner fa fa-list fa-2x">
                                </div>
                                <p class="small-box-footer">Historial</p>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                              <li>
                                <a href="{!!URL::to('pago_frecuencia/historial',$conductor[0]->ci)!!} " > Cobros de frecuencia</a>
                              </li>
                               <li>
                                <a href="{!!URL::to('historial_otras_deudas',$conductor[0]->ci)!!} " > Cobros de otras deudas</a>
                              </li>
                              <li> 
                                <a target="_blank"  href="{!!URL::to('historial_pago_servicio',$conductor[0]->ci)!!} "  > Pagos por servicio corporativo</a>
                              </li>
                              <li> 
                                <a target="_blank"  href="{!!URL::to('conductor_pedido',$conductor[0]->ci)!!} "  > Servicios por aplicación</a>
                              </li>
                              <li> 
                                <a target="_blank"  href="{!!URL::to('historial_baja_alta',$conductor[0]->ci)!!} "  > Baja y alta</a>
                              </li>
                              <li> 
                                <a target="_blank"  href="{!!URL::to('historial_asignacion',$conductor[0]->ci)!!} "  > Asignación</a>
                              </li>
                              <li>
                                <a href="{!!URL::to('contactos_conductor',$conductor[0]->ci)!!} " > Contactos</a>
                              </li>
                             
                             
                              
                            </ul>
                          </div>
 @endif   
</div>







    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      @include('alerts.request')
@foreach($conductor as $con)
<?php /*{!!Form::model(['route'=>['conductor.update',$con->ci],'method'=>'PUT','enctype'=>'multipart/form-data','onKeypress'=>'if(event.keyCode == 13) event.returnValue = 
      false;'])!!}     */?>
{{Form::open(array('url' => 'Actualizar_Conductor','onKeypress'=>'if(event.keyCode == 13) event.returnValue = false;','enctype'=>'multipart/form-data'))}} 
    
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> <h2 align="left" style="color: black">ACTUALIZAR DATOS DEL CONDUCTOR</h2> </div>
<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">

<div class="input-group">
    {!!Form::label('ci','Cedula de Identidad:')!!}<span ><font color="black" size="5px">*</font></span>
    
    <label id="ci_verificar" hidden="" style="color: black">* Ya existe ese C.I.</label>      
  </div>
  

   <input type = "hidden" class = "form-control" name="ci_aux" id="ci_aux"  value="{{$con->ci}}">
   
   <div class="input-group">
        <input type = "text" class = "form-control" name="ci" id="ci" placeholder="C.I. del Conductor" value="{{$con->ci}}" onkeypress="return bloqueo_de_punto(event);" onkeyup="cargar_usuario();">
               
        <span class="input-group-btn">
          <button class="btn btn-success" onclick="verificar_ci_conductor();cargar_usuario();" type="button">Verificar</button>
        </span>
   </div>
   <br>



  <div class="form-group" >
    {!!Form::label('nombre','Expedido:')!!}<span ><font color="black" size="5px">*</font></span>
    {!!Form::select('expedido', array('LP' => 'LA PAZ', 'SC' => 'SANTA CRUZ', 'CB' => 'COCHABAMBA', 'PT' => 'POTOSI', 'TJ' => 'TARIJA', 'OR' => 'ORURO', 'BN' => 'BENI', 'PD' => 'PANDO', 'CH' => 'CHUQUISACA', 'EX' => 'EXTRANJERO'),$con->expedido,array('id'=>'expedido','class'=>'custom-select form-control dropdown-toggle','data-toggle' => 'dropdown'))!!}
  </div>  

  <div class="form-group" >
    {!!Form::label('nombre','Nombre del Conductor:')!!}<span ><font color="black" size="5px">*</font></span>
    {!!Form::text('nombre',$con->nombre,['class'=>'form-control text-capitalize','placeholder'=>'Ingrese el nombre del conductor'])!!}
  </div>  

  <div class="form-group"  >
    {!!Form::label('paterno','Apellido Paterno:')!!}<span ><font color="black" size="5px">*</font></span>
    {!!Form::text('paterno',$con->paterno,['class'=>'form-control text-capitalize','placeholder'=>'Ingrese el apellido paterno'])!!}
  </div>

  <div class="form-group"  >
    {!!Form::label('materno','Apellido Materno:')!!}<span ><font color="black" size="5px">*</font></span>
    {!!Form::text('materno',$con->materno,['class'=>'form-control text-capitalize','placeholder'=>'Ingrese el apellido materno'])!!}
  </div>  

   <div class="form-group"  >
    {!!Form::label('celular','Celular:')!!}<span ><font color="black" size="5px">*</font></span>
    {!!Form::text('celular',$con->celular,['class'=>'form-control','placeholder'=>'Ingrese el celular','maxlength'=>'8'])!!}
  </div>  

  <div class="form-group">
    {!!Form::label('fecha_nacimiento','Fecha de Nacimiento:')!!}<span ><font color="black" size="5px">*</font></span>          
    <div class='input-group date' id='datetimepicker10'>
      <input type='text' value="{{$con->fecha_nacimiento}}" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" style="font-size:20px;text-align:left" />
      <span class="input-group-addon ">
         <span class="fa fa-calendar" aria-hidden="true"></span> 
      </span>
    </div>
  </div>  

    <div class="form-group">
    {!!Form::label('','Fecha de Ingreso:')!!}<span ><font color="black" size="5px">*</font></span>          
    <div class='input-group date' id='datetimepicker11'>
      <input type='text' value="{{$con->fecha_registro}}" class="form-control" id="fecha_registro" name="fecha_registro" style="font-size:20px;text-align:left" />
      <span class="input-group-addon ">
         <span class="fa fa-calendar" aria-hidden="true"></span> 
      </span>
    </div>
  </div>  


  <div class="form-group"  >
    {!!Form::label('sexo','Género :')!!}<span ><font color="black" size="5px">*</font></span>
     <input type="radio"  name="select" id="select" value="M" style="width:17px; height:17px;" onclick="verificar_sexo()" <?php if ($con->sexo == "M") echo "checked"; ?> > MASCULINO 
     <input type="hidden" name="sexo" id="sexo" value="{{$con->sexo}}">       
    <input type="radio" name="select" id="select" value="F" style="width:17px; height:17px;" onclick="verificar_sexo()" <?php if ($con->sexo == "F") echo "checked"; ?> > FEMENINO    
  </div>

 

  
</div>  

<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
  

  <div class="form-group"  >
    {!!Form::label('imei','Imei:')!!}
    
    <div class="input-group">
      <input type="text" class="form-control" name="imei" value="{{$con->imei}}" enabled="">
      <span class="input-group-btn">
        <a><button class="btn btn-secondary " data-toggle="modal" data-target="#historial_imei"    type="button"><i class="fa fa-eye" aria-hidden="true"></i></button></a>
      </span>
    </div>

  </div>  

  <div class="form-group"  >
    {!!Form::label('correo','Correo:')!!}
    {!!Form::text('correo',$con->correo,['class'=>'form-control','placeholder'=>'Ingrese el correo'])!!}
  </div>    

  <div class="form-group"  >
    {!!Form::label('direccion','Dirección:')!!}<span ><font color="black" size="5px">*</font></span>
    {!!Form::text('direccion',$con->direccion,['class'=>'form-control text-capitalize','placeholder'=>'Ingrese la dirección','maxlength'=>'50'])!!}
    {!!Form::hidden('latitud',$con->latitud,['class'=>'form-control'])!!}
    {!!Form::hidden('longitud',$con->longitud,['class'=>'form-control'])!!} 
  </div>

  <div class="form-group"  >
    {!!Form::label('usuario','Usuario:')!!}<span ><font color="black" size="5px">*</font></span>
    {!!Form::text('usuario',$con->usuario,['class'=>'form-control','placeholder'=>'Ingrese el usuario','maxlength'=>'15'])!!}
  </div>      

  <div class="form-group"  >
    {!!Form::label('contrasenia','Contraseña:')!!}<span ><font color="black" size="5px">*</font></span>
    {!!Form::text('contrasenia',$con->contrasenia,['class'=>'form-control','placeholder'=>'Ingrese ls contraseña','maxlength'=>'15'])!!}
  </div>   

  <div class="form-group" hidden=""  >
    {!!Form::label('','Monto de garantia:')!!}<span ><font color="black" size="5px">*</font></span>
    {!!Form::number('monto_garantia',$con->monto_garantia,['class'=>'form-control','placeholder'=>'Ingrese la garantia','maxlength'=>'15'])!!}
  </div>  

 
  <div class="form-group" hidden=""  >
{!!Form::label('','Monto de ahorro:')!!}<span ><font color="black" size="5px">*</font></span>
<div class="input-group">
      <input type="number" class="form-control" name="caja" value="{{$con->ahorro}}" enabled="">
      <span class="input-group-btn">
        <a  href="{!!URL::to('historial_caja',$con->ci)!!} " ><button class="btn btn-secondary "     type="button"><i class="fa fa-eye" aria-hidden="true"></i></button></a>
      </span>
    </div> 
 </div>
    
   <div class="form-group" >
      {!!Form::label('','Estado:')!!}
            {!!Form::select('estado_asignacion', array('0'=>'INACTIVA','1' => 'ACTIVO', '2' => 'SUSPENDIDO','6'=>'RETIRADO'),$con->estado_asignacion,array('id'=>'estado_asignacion','class'=>'form-control'))!!}
  </div>  

  <div class="form-group">
      {!!Form::label('categoria_licencia','Categoria Licencia:')!!}<span ><font color="black" size="5px">*</font></span>
            {!!Form::select('categoria_licencia', array('' => 'SELECCIONE UNA CATEGORIA', 'A' => 'A', 'B' => 'B', 'C' => 'C', 'P' => 'P','M'=>'M'),$con->categoria_licencia,array('id'=>'categoria_licencia','class'=>'form-control'))!!}
  </div>    
  <div class="form-group" >
    {!!Form::label('','Descripción:')!!} 
    {!!Form::textarea('descripcion',$con->descripcion,['class'=>'form-control text-capitalize','placeholder'=>'Descripción del conductor','style'=>'height:100px'])!!}
  </div>  
   
 
    
</div>  


<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">




  <div class="form-group">
      {!!Form::label('tipo','Tipo de Conductor:')!!}<span ><font color="black" size="5px">*</font></span>
            {!!Form::select('tipo', array('' => 'SELECCIONE UN TIPO', 'ASALARIADO' => 'ASALARIADO', 'PROPIETARIO' => 'PROPIETARIO'),$con->tipo,array('id'=>'tipo','class'=>'form-control'))!!}
  </div>
  <div class="form-group"  >
    {!!Form::label('credito','Credito:')!!}
    {!!Form::text('credito',$con->credito,['class'=>'form-control','placeholder'=>'Ingrese el credito','maxlength'=>'5'])!!}
  </div>


  <div class="form-group">
      {!!Form::label('tipo_de_pago','Tipo De Pago:')!!}<span ><font color="black" size="5px">*</font></span>
            {!!Form::select('tipo_de_pago', array('DIA' => 'DIA',
            'SEMANA' => 'SEMANAL',
            'NINGUNO'=>'NINGUNO'),$con->tipo_de_pago,array('id'=>'tipo_de_pago','class'=>'form-control'))!!}
  </div>  

  <div class="form-group">
      {!!Form::label('login','¿Inicio Sesión?')!!}<span ><font color="black" size="5px">*</font></span>
            {!!Form::select('login', array('1' => 'SI', '0' => 'NO'),$con->login,array('id'=>'login','class'=>'form-control'))!!}
  </div>  
<div class="form-group">
      {!!Form::label('','Localidad')!!}<span ><font color="black" size="5px">*</font></span>
            {!!Form::select('localidad', array(
            'LA PAZ' => 'LA PAZ',
            'VALLEGRANDE' => 'VALLEGRANDE',
            'CAMIRI'=>'CAMIRI',
            'MONTERO'=>'MONTERO',
            'YAPACANI'=>'YAPACANI',
            'SANTA CRUZ'=>'SANTA CRUZ'
            ),$con->localidad,array('id'=>'localidad','class'=>'form-control'))!!}
  </div>  

 
     
      @if(Auth::user()->privilegio==1 || Auth::user()->privilegio==10 || Auth::user()->privilegio==11 || Auth::user()->privilegio==11 || Auth::user()->privilegio==12)
       <div class="form-group" >
            {!!Form::label('','Empresa :')!!}<span ><font color="black" size="5px">*</font></span>
                <select name="id_empresa" class="form-control selectpicker" id="id_empresa" data-live-search="true" >
                        <option value="{{$con->id_empresa}}" ></option>
                        @foreach($empresa as $mov)
                         @if($con->id_empresa==$mov->id) 
                        <option value="{{$mov->id}}" selected="" > {{$mov->razon_social}}</option>
                        @endif
                         <option value="{{$mov->id}}" >   {{$mov->razon_social}}</option>
                        @endforeach
                </select>
        </div>
         @else
         <input name="id_empresa" value="{{$con->id_empresa}}" type="hidden" />
         @endif 
     

  <div class="form-group">
    {!!Form::label('direccion_imagen','Foto De Perfil :')!!}
      <input type="text" hidden="" name="perfil" id="perfil" style="cursor: pointer;"  />
       <a href="../{{$con->direccion_imagen}}"  target="_blank"><img  src="../{{$con->direccion_imagen}}" name="foto_conductor" id="foto_conductor" width="350px" height="350px"  class="img-thumbnail"></a> 
  </div>

  
  <div class="form-group"  hidden="">
      {!!Form::label('aceptar_condiciones','Aceptar Condiciones:')!!}
            {!!Form::select('aceptar_condiciones', array('1' => 'SI', '0' => 'NO'),$con->aceptar_condiciones,array('id'=>'aceptar_condiciones','class'=>'form-control'))!!}
  </div>
</div>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" hidden>
{!!Form::label('domicilio','Ubicacion de su Domicilio :')!!}<span ><font color="black" size="5px">*</font></span>
    <input id="pac-input" class="controls" type="text" placeholder="Search Box" class="form-control">
    <div id="map" style=" height: 550px;"></div>
</div>  



<input type="hidden" name="token" id="token" value="{{$con->token}}">

    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div align="right">
      {!!Form::submit('ACTUALIZAR',['class'=>'btn btn-primary','id'=>'btn_actualizar','onclick'=>'btn_esconder()'])!!} 
      <a href="{!!URL::to('conductor')!!}" class="btn btn-danger">CANCELAR</a>
      <?php //{!!Form::reset('CANCELAR',['class'=>'btn btn-danger'])!!} ?>
    </div>
  </div>

  </form>
@endforeach
   {!!Html::script('js/conductor_actualizar.js')!!}
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDz02-44rmUM4TCcICttE6_qLCh6RmzjJw&callback=initAutocomplete&libraries=places"></script>
</div>






<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
<hr style="background: black; height:3px; size: 4px;" >
  
  <font align="center" style="color: black; width: 100%;"><h2>DOCUMENTOS DEL CONDUCTOR</h2></font>

</div>  

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

</div>

@foreach($conductor as $con)

      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 " >
          <form  id="f_subir_imagen_perfil" name="f_subir_imagen_perfil" method="post"  action="subir_imagen_perfil" class="formulario_perfil" enctype="multipart/form-data" >  

        <table class="table table-striped table-bodered table-condensed table-hover" style="background:white; border-radius: 8px;">
            <tr style="background :black; color: white"> <td><h3>Fotos de perfil</h3> <br><input type="hidden"  placeholder="Ingrese el Número" name="numero" id="numero"  
              <div class="btn-group">
                                
                                <label class="btn btn-primary">
                                    Buscar ..
                                    <input type="file" name="perfil_imagen_perfil" id="perfil_imagen_perfil" class="perfil_imagen_rua"   required style="display: none;">
                                </label>
                                 <button type="submit" class="btn btn-default"><i class="fa fa-upload" aria-hidden="true"></i> Subir Imagen</button>
                            </div>

            </td></tr>
            <tr>
                <td>
                  
                           <input type="hidden" name="_token" id="_token"  value="<?= csrf_token(); ?>">
                           <input type="hidden" name="ci" id="ci"  value="{{$con->ci}}">
                            <div id="notificacion_perfil"></div>
                            
                           
                   <style type="text/css">
                   ul.horizontal-slide {
                      margin: 0;
                      padding: 0;
                      width: 100%;
                      white-space: nowrap;
                      overflow-x: auto;
                  }

                  ul.horizontal-slide li[class*="col"] {
                      display: inline-block;
                      float: none;
                  }

                  ul.horizontal-slide li[class*="col"]:first-child {
                      margin-left: 0;
                  }
                   </style>

                   <div class="container"  >
                              
                                <ul class="horizontal-slide" id="lista_perfil">
                                    @foreach($perfil as $r)
                                    <li class="col-md-2 bg-gray" style="border-radius: 5px;">
                                      <a href="../../storage/{{$r->direccion}}"  target="_blank">
                                       <center><img src="../../storage/{{$r->direccion}}"  class="thumbnail"  width="100px" height="100px" />
                                         <label>{{$r->detalle}}</label>
                                         <p>{{$r->fecha}}</p>
                                       </center>
                                       </a>
                                      </li>
                                      @endforeach
                                </ul>
                         
                      </div>
                   
               
                </td>
            </tr>
        </table> 
        </form>    
</div>  


<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 " >
        <form  id="f_subir_imagen_ci" name="f_subir_imagen_ci" method="post"  action="subir_imagen_ci" class="formulario_ci" enctype="multipart/form-data" >  

        <table class="table table-striped table-bodered table-condensed table-hover" style="background: #EEDECA; border-radius: 8px;">
            <tr style="background: #635234; color: white"> <td>Cedula de Identidad C.I. <input type="text"  placeholder="Ingrese el Número" name="numero" id="numero" style="color: black; width: 250px;" required></td></tr>
            <tr>
                <td>
                  
                           <input type="hidden" name="_token" id="_token"  value="<?= csrf_token(); ?>">
                           <input type="hidden" name="ci" id="ci"  value="{{$con->ci}}">
                            <div id="notificacion_ci"></div>
                            <div class="btn-group">
                                 <button type="submit" class="btn btn-default"><i class="fa fa-upload" aria-hidden="true"></i> Subir Imagen</button>
                                <label class="btn btn-primary">
                                    Buscar.. <input type="file" name="perfil_imagen_ci" id="perfil_imagen_ci" class="perfil_imagen_rua"   required style="display: none;">
                                </label>
                            </div>
                            <center><ul id="lista_cedula"  class="nav navbar-nav">
                                   @foreach($cedula as $r)
                                    <li class="dropdown">
                                        <img src="../../storage/{{$r->direccion}}" class="img-rounded img-thumbnail" alt="" width="150px" ></img>
                                    </li>
                                    @endforeach
                                    </ul></center>
                          
                </td>
            </tr>
        </table> 
        </form>    
</div>  

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 " hidden="" >
        <form  id="f_subir_imagen_licencia" name="f_subir_imagen_licencia" method="post"  action="subir_imagen_licencia" class="formulario_licencia" enctype="multipart/form-data" >  

        <table class="table table-striped table-bodered table-condensed table-hover" style="background: #EEDECA; border-radius: 8px;">
            <tr style="background: #635234; color: white"> <td>Licencia de Conducir <input type="text"  placeholder="Ingrese el Número" name="numero" id="numero" style="color: black; width: 250px;" required></td></tr>
            <tr>
                <td>
                  
                           <input type="hidden" name="_token" id="_token"  value="<?= csrf_token(); ?>">
                           <input type="hidden" name="ci" id="ci"  value="{{$con->ci}}">
                            <div id="notificacion_rua"></div>
                            <div class="btn-group">
                                 <button type="submit" class="btn btn-default"><i class="fa fa-upload" aria-hidden="true"></i> Subir Imagen</button>
                                <label class="btn btn-primary">
                                    Buscar.. <input type="file" name="perfil_imagen_licencia" id="perfil_imagen_licencia" class="perfil_imagen_licencia"   required style="display: none;">
                                </label>
                            </div>
                            <center><ul id="lista_licencia"  class="nav navbar-nav">
                                   @foreach($licencia as $r)
                                    <li class="dropdown">
                                        <img src="../../storage/{{$r->direccion}}" class="img-rounded img-thumbnail" alt="" width="150px" ></img>
                                    </li>
                                    @endforeach
                                    </ul></center>
                          
                </td>
            </tr>
        </table> 
        </form>    
</div>  

  
  
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 " hidden="">
        <form  id="f_subir_imagen_ham" name="f_subir_imagen_ham" method="post"  action="subir_imagen_ham" class="formulario_ham" enctype="multipart/form-data" >  

        <table class="table table-striped table-bodered table-condensed table-hover" style="background: #EEDECA; border-radius: 8px;">
            <tr style="background: #635234; color: white"> <td>Tarjeta de Identificación de Ham <input type="text"  placeholder="Ingrese el Número" name="numero" id="numero" style="color: black; width: 250px;" required></td></tr>
            <tr>
                <td>
                  
                           <input type="hidden" name="_token" id="_token"  value="<?= csrf_token(); ?>">
                           <input type="hidden" name="ci" id="ci"  value="{{$con->ci}}">
                            <div id="notificacion_ham"></div>
                            <div class="btn-group">
                                 <button type="submit" class="btn btn-default"><i class="fa fa-upload" aria-hidden="true"></i> Subir Imagen</button>
                                <label class="btn btn-primary">
                                    Buscar.. <input type="file" name="perfil_imagen_ham" id="perfil_imagen_ham" class="perfil_imagen_ham"   required style="display: none;">
                                </label>
                            </div>
                            <center><ul id="lista_ham"  class="nav navbar-nav">
                                   @foreach($ham as $r)
                                    <li class="dropdown">
                                        <img src="../../storage/{{$r->direccion}}" class="img-rounded img-thumbnail" alt="" width="150px" ></img>
                                    </li>
                                    @endforeach
                                    </ul></center>
                          
                </td>
            </tr>
        </table> 
        </form>    
</div>  


<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 " hidden="" >
        <form  id="f_subir_imagen_transito" name="f_subir_imagen_transito" method="post"  action="subir_imagen_transito" class="formulario_transito" enctype="multipart/form-data" >  

        <table class="table table-striped table-bodered table-condensed table-hover" style="background: #EEDECA; border-radius: 8px;">
            <tr style="background: #635234; color: white"> <td>Tarjeta de Identificación de Transito <input type="text"  placeholder="Ingrese el Número" name="numero" id="numero" style="color: black; width: 250px;" required></td></tr>
            <tr>
                <td>
                  
                           <input type="hidden" name="_token" id="_token"  value="<?= csrf_token(); ?>">
                           <input type="hidden" name="ci" id="ci"  value="{{$con->ci}}">
                            <div id="notificacion_transito"></div>
                            <div class="btn-group">
                                 <button type="submit" class="btn btn-default"><i class="fa fa-upload" aria-hidden="true"></i> Subir Imagen</button>
                                <label class="btn btn-primary">
                                    Buscar.. <input type="file" name="perfil_imagen_transito" id="perfil_imagen_transito" class="perfil_imagen_transito"   required style="display: none;">
                                </label>
                            </div>
                            <center><ul id="lista_transito"  class="nav navbar-nav">
                                   @foreach($transito as $r)
                                    <li class="dropdown">
                                        <img src="../../storage/{{$r->direccion}}" class="img-rounded img-thumbnail" alt="" width="150px" ></img>
                                    </li>
                                    @endforeach
                                    </ul></center>
                          
                </td>
            </tr>
        </table> 
        </form>    
</div>  

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 " hidden="">
        <form  id="f_subir_imagen_factura" name="f_subir_imagen_factura" method="post"  action="subir_imagen_factura" class="formulario_factura" enctype="multipart/form-data" >  

        <table class="table table-striped table-bodered table-condensed table-hover" style="background: #EEDECA; border-radius: 8px;">
            <tr style="background: #635234; color: white"> <td>Factura de Agua o Luz <input type="text"  placeholder="Ingrese el Número" name="numero" id="numero" style="color: black; width: 250px;" required></td></tr>
            <tr>
                <td>
                  
                           <input type="hidden" name="_token" id="_token"  value="<?= csrf_token(); ?>">
                           <input type="hidden" name="ci" id="ci"  value="{{$con->ci}}">
                            <div id="notificacion_factura"></div>
                            <div class="btn-group">
                                 <button type="submit" class="btn btn-default"><i class="fa fa-upload" aria-hidden="true"></i> Subir Imagen</button>
                                <label class="btn btn-primary">
                                    Buscar.. <input type="file" name="perfil_imagen_factura" id="perfil_imagen_factura" class="perfil_imagen_factura"   required style="display: none;">
                                </label>
                            </div>
                            <center><ul id="lista_factura"  class="nav navbar-nav">
                                   @foreach($factura as $r)
                                    <li class="dropdown">
                                        <img src="../../storage/{{$r->direccion}}" class="img-rounded img-thumbnail" alt="" width="150px" ></img>
                                    </li>
                                    @endforeach
                                    </ul></center>
                          
                </td>
            </tr>
        </table> 
        </form>    
</div>  

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 " hidden="" >
        <form  id="f_subir_imagen_antecedentes" name="f_subir_imagen_antecedentes" method="post"  action="f_subir_imagen_antecedentes" class="formulario_antecedentes" enctype="multipart/form-data" >  

        <table class="table table-striped table-bodered table-condensed table-hover" style="background: #EEDECA; border-radius: 8px;">
            <tr style="background: #635234; color: white"> <td>Certificado de Antecedentes de Transito <input type="text"  placeholder="Ingrese el Número" name="numero" id="numero" style="color: black; width: 250px;" required></td></tr>
            <tr>
                <td>
                  
                           <input type="hidden" name="_token" id="_token"  value="<?= csrf_token(); ?>">
                           <input type="hidden" name="ci" id="ci"  value="{{$con->ci}}">
                            <div id="notificacion_antecedentes"></div>
                            <div class="btn-group">
                                 <button type="submit" class="btn btn-default"><i class="fa fa-upload" aria-hidden="true"></i> Subir Imagen</button>
                                <label class="btn btn-primary">
                                    Buscar.. <input type="file" name="perfil_imagen_antecedentes" id="perfil_imagen_antecedentes" class="perfil_imagen_antecedentes"   required style="display: none;">
                                </label>
                            </div>
                            <center><ul id="lista_antecedentes"  class="nav navbar-nav">
                                   @foreach($antecedentes as $r)
                                    <li class="dropdown">
                                        <img src="../../storage/{{$r->direccion}}" class="img-rounded img-thumbnail" alt="" width="150px" ></img>
                                    </li>
                                    @endforeach
                                    </ul></center>
                          
                </td>
            </tr>
        </table> 
        </form>    
</div> 
  
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 " hidden="">
        <form  id="f_subir_imagen_felcc" name="f_subir_imagen_felcc" method="post"  action="subir_imagen_felcc" class="formulario_felcc" enctype="multipart/form-data" >  

        <table class="table table-striped table-bodered table-condensed table-hover" style="background: #EEDECA; border-radius: 8px;">
            <tr style="background: #635234; color: white"> <td>Certificado de Antecedentes de la FELCC <input type="text"  placeholder="Ingrese el Número" name="numero" id="numero" style="color: black; width: 250px;" required></td></tr>
            <tr>
                <td>
                  
                           <input type="hidden" name="_token" id="_token"  value="<?= csrf_token(); ?>">
                           <input type="hidden" name="ci" id="ci"  value="{{$con->ci}}">
                            <div id="notificacion_felcc"></div>
                            <div class="btn-group">
                                 <button type="submit" class="btn btn-default"><i class="fa fa-upload" aria-hidden="true"></i> Subir Imagen</button>
                                <label class="btn btn-primary">
                                    Buscar.. <input type="file" name="perfil_imagen_felcc" id="perfil_imagen_felcc" class="perfil_imagen_felcc"   required style="display: none;">
                                </label>
                            </div>
                            <center><ul id="lista_felcc"  class="nav navbar-nav">
                                   @foreach($felcc as $r)
                                    <li class="dropdown">
                                        <img src="../../storage/{{$r->direccion}}" class="img-rounded img-thumbnail" alt="" width="150px" ></img>
                                    </li>
                                    @endforeach
                                    </ul></center>
                          
                </td>
            </tr>
        </table> 
        </form>    
</div>  

@endforeach

  @endsection


