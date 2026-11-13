@extends ('layouts.inicio')
@section ('contenido')
@include('alerts.success')
@include('alerts.errors')
@include('conductor.modal')
@include('conductor.modal_vehiculo_asignado')

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

  function cargar_usuario(){
    var ci=$("#ci").val();
    $("#usuario").val(ci);
    $("#contrasenia").val(ci);
  } 

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
    

    <div class="col-lg-1 col-md-1 col-sm-1 col-xs-3">
      <a target="_blank"  href="{!!URL::to('conductors/kardex_pdf',$conductor[0]->ci)!!} " data-toggle="tooltip" data-placement="top" title="Imprimir Kardex" > 
      <div class="bg-gray">
        <span class="info-box-icon bg-red">
          <span class="fa fa-address-card"></span>
        </span>
      </div>
        </a>
    </div>

  
<?php
$asi="Asinar"; 
  if($conductor[0]->id_vehiculo!=0){
    $asi="Asignado";
  }

?>
    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-3">
      
            <a data-toggle="modal" data-target="#ModalCambiarVehiculo"  >
         
       
      <div class="info-box bg-gray">
        <span class="info-box-icon bg-green">
          <i class="fa fa-link"></i>
        </span>
        <div class="info-box-content " >
          <span class="info-box-number">{{$conductor[0]->id_vehiculo}}</span>
          <span class="info-box-text">
            @if($conductor[0]->id_vehiculo!=0)
            {{$conductor[0]->id_vehiculo}}
            @else
            No.
            @endif
          </span>
        </div>
      </div>
        </a>
    </div>


     <div class="col-lg-1 col-md-1 col-sm-1 col-xs-12">
        <span  data-toggle="modal" data-target="#ModalNotificacion"  onclick="Cargarconductor('{{$conductor[0]->ci}}','{{$conductor[0]->nombre}} {{$conductor[0]->paterno}} {{$conductor[0]->materno}}','{{$conductor[0]->token}}');"> 
            <div class="info-box bg-gray">
              <span class="info-box-icon bg-aqua">
                <i class="fa fa-commenting-o"></i>
              </span>
            </div>
          </span>
    </div>

     <div class="col-lg-1 col-md-1 col-sm-1 col-xs-12">
        <a target="_blank"   data-toggle="modal" data-target="#ModalBaja"   data-toggle="tooltip" data-placement="top" title="Registrar la baja el Conductor"> 
            <div class="info-box bg-gray">
              <span class="info-box-icon bg-yellow">
                <i class="fa fa-arrow-down"></i>
              </span>
            </div>
          </a>
    </div>

    <div class="col-lg-1 col-md-1 col-sm-1 col-xs-12">
        <a href="{!!URL::to('pago_frecuencia/historial',$conductor[0]->ci)!!} " target="_blanck" data-toggle="tooltip" data-placement="top" title="Historial de pagos"  > 
            <div class="info-box bg-gray">
              <span class="info-box-icon bg-green">
                <i class="fa fa-history"></i>
              </span>
            </div>
          </a>
    </div>

    <div class="col-lg-1 col-md-1 col-sm-1 col-xs-12">
            <a target="_blank"  href="{!!URL::to('conductor_pedido',$conductor[0]->ci)!!} "   aria-hidden="true"  data-toggle="tooltip" data-placement="top" title="Ver historial de pedidos"> 
                <div class="info-box bg-gray">
                  <span class="info-box-icon bg-blue">
                    <i class="fa fa-list"></i>
                  </span>
                </div>
              </a>
        </div>

    
  </div>





    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      @include('alerts.request')
@foreach($conductor as $con)
<?php /*{!!Form::model(['route'=>['conductor.update',$con->ci],'method'=>'PUT','enctype'=>'multipart/form-data','onKeypress'=>'if(event.keyCode == 13) event.returnValue = 
      false;'])!!}     */?>
{{Form::open(array('url' => 'Actualizar_Conductor','onKeypress'=>'if(event.keyCode == 13) event.returnValue = false;','enctype'=>'multipart/form-data'))}} 
    
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> <h2 align="left" style="color: red">ACTUALIZAR DATOS DEL CONDUCTOR</h2> </div>
<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">

<div class="input-group">
    {!!Form::label('ci','Cedula de Identidad:')!!}<span ><font color="red" size="5px">*</font></span>
    
    <label id="ci_verificar" hidden="" style="color: red">* Ya existe ese C.I.</label>      
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
    {!!Form::label('nombre','Expedido:')!!}<span ><font color="red" size="5px">*</font></span>
    {!!Form::select('expedido', array('LP' => 'LA PAZ', 'SC' => 'SANTA CRUZ', 'CB' => 'COCHABAMBA', 'PT' => 'POTOSI', 'TJ' => 'TARIJA', 'OR' => 'ORURO', 'BN' => 'BENI', 'PD' => 'PANDO', 'CH' => 'CHUQUISACA', 'EX' => 'EXTRANJERO'),$con->expedido,array('id'=>'expedido','class'=>'custom-select form-control dropdown-toggle','data-toggle' => 'dropdown'))!!}
  </div>  

  <div class="form-group" >
    {!!Form::label('nombre','Nombre del Conductor:')!!}<span ><font color="red" size="5px">*</font></span>
    {!!Form::text('nombre',$con->nombre,['class'=>'form-control text-capitalize','placeholder'=>'Ingrese el nombre del conductor'])!!}
  </div>  

  <div class="form-group"  >
    {!!Form::label('paterno','Apellido Paterno:')!!}<span ><font color="red" size="5px">*</font></span>
    {!!Form::text('paterno',$con->paterno,['class'=>'form-control text-capitalize','placeholder'=>'Ingrese el apellido paterno'])!!}
  </div>

  <div class="form-group"  >
    {!!Form::label('materno','Apellido Materno:')!!}<span ><font color="red" size="5px">*</font></span>
    {!!Form::text('materno',$con->materno,['class'=>'form-control text-capitalize','placeholder'=>'Ingrese el apellido materno'])!!}
  </div>  

   <div class="form-group"  >
    {!!Form::label('celular','Celular:')!!}<span ><font color="red" size="5px">*</font></span>
    {!!Form::text('celular',$con->celular,['class'=>'form-control','placeholder'=>'Ingrese el celular','maxlength'=>'8'])!!}
  </div>  

  <div class="form-group">
    {!!Form::label('fecha_nacimiento','Fecha de Nacimiento:')!!}<span ><font color="red" size="5px">*</font></span>          
    <div class='input-group date' id='datetimepicker10'>
      <input type='text' value="{{$con->fecha_nacimiento}}" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" style="font-size:20px;text-align:left" />
      <span class="input-group-addon ">
         <span class="fa fa-calendar" aria-hidden="true"></span> 
      </span>
    </div>
  </div>  

    <div class="form-group">
    {!!Form::label('','Fecha de Ingreso:')!!}<span ><font color="red" size="5px">*</font></span>          
    <div class='input-group date' id='datetimepicker11'>
      <input type='text' value="{{$con->fecha_registro}}" class="form-control" id="fecha_registro" name="fecha_registro" style="font-size:20px;text-align:left" />
      <span class="input-group-addon ">
         <span class="fa fa-calendar" aria-hidden="true"></span> 
      </span>
    </div>
  </div>  


  <div class="form-group"  >
    {!!Form::label('sexo','Género :')!!}<span ><font color="red" size="5px">*</font></span>
     <input type="radio"  name="select" id="select" value="M" style="width:17px; height:17px;" onclick="verificar_sexo()" <?php if ($con->sexo == "M") echo "checked"; ?> > MASCULINO 
     <input type="hidden" name="sexo" id="sexo" value="{{$con->sexo}}">       
    <input type="radio" name="select" id="select" value="F" style="width:17px; height:17px;" onclick="verificar_sexo()" <?php if ($con->sexo == "F") echo "checked"; ?> > FEMENINO    
  </div>

 

  
</div>  

<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
  

  <div class="form-group"  >
    {!!Form::label('imei','Imei:')!!}
    {!!Form::text('imei',$con->imei,['class'=>'form-control','placeholder'=>'Ingrese el imei del celular','maxlength'=>'30'])!!}
  </div>  

  <div class="form-group"  >
    {!!Form::label('correo','Correo:')!!}
    {!!Form::text('correo',$con->correo,['class'=>'form-control','placeholder'=>'Ingrese el correo'])!!}
  </div>    

  <div class="form-group"  >
    {!!Form::label('direccion','Dirección:')!!}<span ><font color="red" size="5px">*</font></span>
    {!!Form::text('direccion',$con->direccion,['class'=>'form-control text-capitalize','placeholder'=>'Ingrese la dirección','maxlength'=>'50'])!!}
    {!!Form::hidden('latitud',$con->latitud,['class'=>'form-control'])!!}
    {!!Form::hidden('longitud',$con->longitud,['class'=>'form-control'])!!} 
  </div>

  <div class="form-group"  >
    {!!Form::label('usuario','Usuario:')!!}<span ><font color="red" size="5px">*</font></span>
    {!!Form::text('usuario',$con->usuario,['class'=>'form-control','placeholder'=>'Ingrese el usuario','maxlength'=>'15'])!!}
  </div>      

  <div class="form-group"  >
    {!!Form::label('contrasenia','Contraseña:')!!}<span ><font color="red" size="5px">*</font></span>
    {!!Form::text('contrasenia',$con->contrasenia,['class'=>'form-control','placeholder'=>'Ingrese ls contraseña','maxlength'=>'15'])!!}
  </div>          
  <div class="form-group" >
      {!!Form::label('estado','Estado:')!!}
            {!!Form::select('estado', array('1' => 'ACTIVO', '0' => 'INACTIVO'),$con->estado,array('id'=>'estado','class'=>'form-control'))!!}
  </div>

  <div class="form-group">
      {!!Form::label('categoria_licencia','Categoria Licencia:')!!}<span ><font color="red" size="5px">*</font></span>
            {!!Form::select('categoria_licencia', array('' => 'SELECCIONE UNA CATEGORIA', 'A' => 'A', 'B' => 'B', 'C' => 'C', 'P' => 'P'),$con->categoria_licencia,array('id'=>'categoria_licencia','class'=>'form-control'))!!}
  </div>  
    
</div>  


<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">


  

  <div class="form-group">
      {!!Form::label('tipo','Tipo de Conductor:')!!}<span ><font color="red" size="5px">*</font></span>
            {!!Form::select('tipo', array('' => 'SELECCIONE UN TIPO', 'ASALARIADO' => 'ASALARIADO', 'PROPIETARIO' => 'PROPIETARIO'),$con->tipo,array('id'=>'tipo','class'=>'form-control'))!!}
  </div>


  <div class="form-group">
      {!!Form::label('tipo_de_pago','Tipo De Pago:')!!}<span ><font color="red" size="5px">*</font></span>
            {!!Form::select('tipo_de_pago', array('DIA' => 'DIA', 'SEMANA' => 'SEMANAL', 'MES' => 'MES','CONDENADO'=>'CONDENADO','NINGUNO'=>'NINGUNO'),$con->tipo_de_pago,array('id'=>'tipo_de_pago','class'=>'form-control'))!!}
  </div>  

  <div class="form-group">
      {!!Form::label('login','¿Inicio Sesión?')!!}<span ><font color="red" size="5px">*</font></span>
            {!!Form::select('login', array('1' => 'SI', '0' => 'NO'),$con->login,array('id'=>'login','class'=>'form-control'))!!}
  </div>  

  <div class="form-group">
      {!!Form::label('bloqueo','¿Esta Bloqueado?')!!}<span ><font color="red" size="5px">*</font></span>
              {!!Form::select('bloqueo', array('1' => 'SI', '0' => 'NO'),$con->bloqueo,array('id'=>'bloqueo','class'=>'form-control'))!!}
  </div>  

  <div class="form-group">
      {!!Form::label('panico','¿Esta en Panico?')!!}<span ><font color="red" size="5px">*</font></span>
              {!!Form::select('panico', array('1' => 'SI', '0' => 'NO'),$con->panico,array('id'=>'panico','class'=>'form-control'))!!}
  </div>  
     
      @if(Auth::user()->privilegio==1 || Auth::user()->privilegio==10 || Auth::user()->privilegio==11 || Auth::user()->privilegio==11 || Auth::user()->privilegio==12)
       <div class="form-group" >
            {!!Form::label('','Empresa :')!!}<span ><font color="red" size="5px">*</font></span>
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
    <?php  if ($con->direccion_imagen != "") { ?>
      <input type="file" name="perfil" id="perfil" style="cursor: pointer;" accept="image/*">
        <br/><center><output id="list"></output></center> 
      <center><img src="../{{$con->direccion_imagen}}" name="foto_conductor" id="foto_conductor" width="150px" height="150px"  class="img-thumbnail"></center>
      <input type="hidden" name="direccion_imagen" id="direccion_imagen" value="{{$con->direccion_imagen}}" >       
    <?php } else{ ?>  
      <input type="file" name="perfil" id="perfil" style="cursor: pointer;" accept="image/*">
        <br/><center><output id="list"></output></center> 
    <?php } ?>

  </div>

  
  <div class="form-group"  hidden="">
      {!!Form::label('aceptar_condiciones','Aceptar Condiciones:')!!}
            {!!Form::select('aceptar_condiciones', array('1' => 'SI', '0' => 'NO'),$con->aceptar_condiciones,array('id'=>'aceptar_condiciones','class'=>'form-control'))!!}
  </div>
</div>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
{!!Form::label('domicilio','Ubicacion de su Domicilio :')!!}<span ><font color="red" size="5px">*</font></span>
    <input id="pac-input" class="controls" type="text" placeholder="Search Box" class="form-control">
    <div id="map" style=" height: 550px;"></div>
</div>  



<input type="hidden" name="credito" id="credito" value="{{$con->credito}}">
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
  
  <font align="center" style="color: red; width: 100%;"><h2>DOCUMENTOS DEL CONDUCTOR</h2></font>

</div>  

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

</div>

@foreach($conductor as $con)
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

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 " >
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


<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 " >
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


<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 " >
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

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 " >
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

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 " >
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
  
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 " >
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