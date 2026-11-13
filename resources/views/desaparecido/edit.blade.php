@extends ('layouts.inicio')
@section ('contenido')
@include('alerts.success')
@include('alerts.errors')

<style type="text/css">
  .container{max-width:1170px; margin:auto;}
img{ max-width:100%;}
.inbox_people {
  background: #f8f8f8 none repeat scroll 0 0;
  float: left;
  overflow: hidden;
  width: 40%; border-right:1px solid #c4c4c4;
}
.inbox_msg {
  border: 1px solid #c4c4c4;
  clear: both;
  overflow: hidden;
}
.top_spac{ margin: 20px 0 0;}


.recent_heading {float: left; width:40%;}
.srch_bar {
  display: inline-block;
  text-align: right;
  width: 60%; padding:
}
.headind_srch{ padding:10px 29px 10px 20px; overflow:hidden; border-bottom:1px solid #c4c4c4;}

.recent_heading h4 {
  color: #05728f;
  font-size: 21px;
  margin: auto;
}
.srch_bar input{ border:1px solid #cdcdcd; border-width:0 0 1px 0; width:80%; padding:2px 0 4px 6px; background:none;}
.srch_bar .input-group-addon button {
  background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
  border: medium none;
  padding: 0;
  color: #707070;
  font-size: 18px;
}
.srch_bar .input-group-addon { margin: 0 0 0 -27px;}

.chat_ib h5{ font-size:15px; color:#464646; margin:0 0 8px 0;}
.chat_ib h5 span{ font-size:13px; float:right;}
.chat_ib p{ font-size:14px; color:#989898; margin:auto}
.chat_img {
  float: left;
  width: 11%;
}
.chat_ib {
  float: left;
  padding: 0 0 0 15px;
  width: 88%;
}

.chat_people{ overflow:hidden; clear:both;}
.chat_list {
  border-bottom: 1px solid #c4c4c4;
  margin: 0;
  padding: 18px 16px 10px;
}
.inbox_chat { height: 550px; overflow-y: scroll;}

.active_chat{ background:#ebebeb;}

.incoming_msg_img {
  display: inline-block;
  width: 6%;
}
.received_msg {
  display: inline-block;
  padding: 0 0 0 10px;
  vertical-align: top;
  width: 92%;
 }
 .received_withd_msg p {
  background: #ebebeb none repeat scroll 0 0;
  border-radius: 3px;
  color: #646464;
  font-size: 14px;
  margin: 0;
  padding: 5px 10px 5px 12px;
  width: 100%;
}
.time_date {
  color: #747474;
  display: block;
  font-size: 12px;
  margin: 8px 0 0;
}
.received_withd_msg { width: 57%;}
.mesgs {
  float: left;
  padding: 30px 15px 0 25px;
  width: 60%;
}

 .sent_msg p {
  background: #05728f none repeat scroll 0 0;
  border-radius: 3px;
  font-size: 14px;
  margin: 0; color:#fff;
  padding: 5px 10px 5px 12px;
  width:100%;
}
.outgoing_msg{ overflow:hidden; margin:26px 0 26px;}
.sent_msg {
  float: right;
  width: 46%;
}
.input_msg_write input {
  background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
  border: medium none;
  color: #4c4c4c;
  font-size: 15px;
  min-height: 48px;
  width: 100%;
}

.type_msg {border-top: 1px solid #c4c4c4;position: relative;}
.msg_send_btn {
  background: #05728f none repeat scroll 0 0;
  border: medium none;
  border-radius: 50%;
  color: #fff;
  cursor: pointer;
  font-size: 17px;
  height: 33px;
  position: absolute;
  right: 0;
  top: 11px;
  width: 33px;
}
.messaging { padding: 0 0 50px 0;}
.msg_history {
  height: 516px;
  overflow-y: auto;
}

</style>
  


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

  $(document).on("submit",".formulario_perfil",function(e){
        e.preventDefault();
        var formu=$(this);
        var nombreform=$(this).attr("id");

        if(nombreform=="f_subir_imagen_perfil" ){ var miurl="../../subir_imagen_desaparecido";  var divresul="notificacion_perfil"}
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

 
 





    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      @include('alerts.request')
      <?
      $id_desaparecido=0;
      ?>
@foreach($desaparecido as $con)

<?php
/*{!!Form::model(['route'=>['desaparecido.update',$con->id],'method'=>'PUT','enctype'=>'multipart/form-data','onKeypress'=>'if(event.keyCode == 13) event.returnValue = 
      false;'])!!}    
      */
        $id_desaparecido=$con->id;
?>
 
{{Form::open(array('url' => 'actualizar_desaparecido','onKeypress'=>'if(event.keyCode == 13) event.returnValue = false;','enctype'=>'multipart/form-data'))}} 
  
 
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> <h2 align="left" style="color: black">ACTUALIZAR DEL DESAPARECIDO</h2> </div>
<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">

 
  
  



  <div class="form-group" >
    {!!Form::label('nombre','Expedido:')!!}<span ><font color="black" size="5px">*</font></span>
    {!!Form::select('departamento', array( 'SANTA CRUZ' => 'SANTA CRUZ', 'COCHABAMBA' => 'COCHABAMBA', 'POTOSI' => 'POTOSI','LA PAZ' => 'LA PAZ', 'TARIJA' => 'TARIJA', 'ORURO' => 'ORURO', 'BENI' => 'BENI', 'PANDO' => 'PANDO', 'CHUQUISACA' => 'CHUQUISACA'),null,array( 'class'=>'custom-select form-control dropdown-toggle','data-toggle' => 'dropdown'))!!}
  </div>  

  <div class="form-group" >
    {!!Form::label('nombre','Nombre del Conductor:')!!}<span ><font color="black" size="5px">*</font></span>
    {!!Form::text('nombre',$con->nombre,['class'=>'form-control text-capitalize','placeholder'=>'Ingrese el nombre del conductor'])!!}
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
    {!!Form::label('fecha_nacimiento','Fecha de Desaparición:')!!}<span ><font color="black" size="5px">*</font></span>          
    <div class='input-group date' id='datetimepicker11'>
      <input type='text' value="{{$con->fecha_desaparecido}}" class="form-control"  name="fecha_desaparecido" style="font-size:20px;text-align:left" />
      <span class="input-group-addon ">
         <span class="fa fa-calendar" aria-hidden="true"></span> 
      </span>
    </div>
  </div>  


  <div class="form-group"  >
    {!!Form::label('sexo','Género :')!!}<span ><font color="black" size="5px">*</font></span><br>
     <input type="radio"  name="select" id="select" value="M" style="width:17px; height:17px;" onclick="verificar_sexo()" <?php if ($con->sexo == "M") echo "checked"; ?> > MASCULINO 
     <input type="hidden" name="sexo" id="sexo" value="{{$con->sexo}}">       
    <input type="radio" name="select" id="select" value="F"  style="width:17px; height:17px;" onclick="verificar_sexo()" <?php if ($con->sexo == "F") echo "checked"; ?> > FEMENINO    </input>
  </div>

 

  
</div>  

<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
  

  
  <div class="form-group"  >
    {!!Form::label('','Dirección:')!!}<span ><font color="black" size="5px">*</font></span>
    {!!Form::textarea('direccion',$con->direccion,['class'=>'form-control text-capitalize','placeholder'=>'Ingrese la dirección','style'=>'height:100px;'])!!}
  </div>



  <div class="form-group"  >
    {!!Form::label('','Descripción:')!!}<span ><font color="black" size="5px">*</font></span>
    {!!Form::textarea('descripcion',$con->descripcion,['class'=>'form-control text-capitalize','placeholder'=>'Descripción','style'=>'height:100px;'])!!}
  </div>
  
  <div class="form-group" >
      {!!Form::label('estado','Estado:')!!}
            {!!Form::select('estado', array('1' => 'DESAPARECIDO', '0' => 'ENCONTRADO'),$con->estado,array( 'class'=>'form-control'))!!}
  </div>
     
   
 
    
</div>  


<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">



 <div class="form-group" >
    {!!Form::label('','Nombre 1:')!!}<span ><font color="black" size="5px">*</font></span>
    {!!Form::text('nombre_referencia_1',$con->nombre_referencia_1,['class'=>'form-control text-capitalize','placeholder'=>'Ingrese el nombre'])!!}
  </div>  

  <div class="form-group"  >
    {!!Form::label('','Celular 1:')!!}<span ><font color="black" size="5px">*</font></span>
    {!!Form::text('celular_referencia_1',$con->celular_referencia_1,['class'=>'form-control','placeholder'=>'Ingrese el celular','maxlength'=>'8','onkeypress'=>'return bloqueo_de_punto(event)'])!!}
  </div>  

   <div class="form-group" >
    {!!Form::label('','Nombre 2:')!!}<span ><font color="black" size="5px">*</font></span>
    {!!Form::text('nombre_referencia_2',$con->nombre_referencia_2,['class'=>'form-control text-capitalize','placeholder'=>'Ingrese el nombre'])!!}
  </div>  
  <div class="form-group"  >
    {!!Form::label('celular_referencia_2','Celular 2:')!!}<span ><font color="black" size="5px">*</font></span>
    {!!Form::text('celular_referencia_2',$con->celular_referencia_2,['class'=>'form-control','placeholder'=>'Ingrese el celular','maxlength'=>'8','onkeypress'=>'return bloqueo_de_punto(event)'])!!}
  </div>  
  


</div>
 


 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
{!!Form::label('domicilio','Ubicacion de desaparición :')!!}<span ><font color="black" size="5px">*</font></span>
    <input id="pac-input" class="controls" type="text" placeholder="Search Box" class="form-control">
    <div id="map" style=" height: 550px;"></div>
</div>  

   {!!Form::hidden('latitud',$con->latitud,['class'=>'form-control'])!!}
    {!!Form::hidden('longitud',$con->longitud,['class'=>'form-control'])!!} 


    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div align="right">
      {!!Form::submit('ACTUALIZAR',['class'=>'btn btn-primary','id'=>'btn_actualizar','onclick'=>'btn_esconder()'])!!} 
      <a href="{!!URL::to('conductor')!!}" class="btn btn-danger">CANCELAR</a>
     
    </div>
  </div>

<input type="hidden" name="id_desaparecido" id="id_desaparecido"  value="{{$con->id}}">
  </form>
@endforeach


</div>





 

 

@foreach($desaparecido as $con)

      <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 " >
          <form  id="f_subir_imagen_perfil" name="f_subir_imagen_perfil" method="post"  action="subir_imagen_desaparecido" class="formulario_perfil" enctype="multipart/form-data" >  

        <table  style="background:white; border-radius: 8px; border:1px solid black;">
            <tr style="background :black; color: white"> 
              <td><h3>Fotos de perfil</h3> 
              </td>
              <tr>
                <td style="padding: 5px;">
              <a href="../../../storage/{{$con->direccion_imagen}}"  target="_blank">
                                     <img src="../../../storage/{{$con->direccion_imagen}}"  class="thumbnail"  width="100px" height="100px" />
                                    
                                       </a>
                                
                                <label class="btn btn-primary">
                                    Buscar ..
                                    <input type="file" name="perfil_imagen_perfil" id="perfil_imagen_perfil" class="perfil_imagen_perfil"   required style="display: none;">
                                </label>
                                 <button type="submit" class="btn btn-default"><i class="fa fa-upload" aria-hidden="true"></i> Subir Imagen</button>
                      

            </td></tr>
            <tr>
                <td>
                  
                           <input type="hidden" name="_token" id="_token"  value="<?= csrf_token(); ?>">
                           <input type="hidden" name="id_desaparecido" id="id_desaparecido"  value="{{$con->id}}">
                            <div id="notificacion_perfil"></div>
                            
                           
                    
                   
               
                </td>
            </tr>
        </table>


        </form>    
</div>  
@endforeach


    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
 <div class="container">
<h3 class=" text-center">Mensaje</h3>
<div class="messaging">
      <div class="inbox_msg">
        <div class="inbox_people">
          <div class="headind_srch">
            <div class="recent_heading">
              <h4>Usuarios</h4>
            </div>
          </div>
          <div class="inbox_chat">

            @foreach($usuario as $con)
            <div class="chat_list active_chat" onclick="ver_chat({{$con->id}},{{$id_desaparecido}})">
              <div class="chat_people">
                <div class="chat_img"> <img src="https://ptetutorials.com/images/user-profile.png" alt="sunil"> </div>
                <div class="chat_ib">
                  <h5>{{$con->nombre}} {{$con->apellido}} <span class="chat_date">EH</span></h5>
                  <p>{{$con->celular}}<br> 
                    {{$con->correo}}</p>
                </div>
              </div>
            </div>

            @endforeach

          </div>
        </div>
        <div class="mesgs">
          <div class="msg_history">
             
             
           
            <div id="div_mensaje">
              
            </div>
          </div>
          <div class="type_msg">
            <div class="input_msg_write">
              <input type="text" class="write_msg" placeholder="Type a message">
              <button class="msg_send_btn" type="button"><i class="fa fa-paper-plane-o" aria-hidden="true"></i></button>
            </div>
          </div>
        </div>
      </div>
      
      
      <p class="text-center top_spac"> Design by <a target="_blank" href="#">Sunil Rajput</a></p>
      
    </div></div>


 
  </div>
    @foreach($mensaje as $con)
    @endforeach
 


   {!!Html::script('js/desaparecido_actualizar.js')!!}
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBFEeTkwD_HkWEg6dEhT4hhnkOy3XLppZI&callback=initAutocomplete&libraries=places"></script>
 


  @endsection


