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

<style type="text/css">
    .li {
    float: left;
}
</style>


<script type="text/javascript">
    
  


$(document).on("submit",".formulario_corporativa",function(e){
        e.preventDefault();
        var formu=$(this);
        var nombreform=$(this).attr("id");

        if(nombreform=="f_subir_imagen_corporativa" ){ var miurl="subir_imagen_corporativa";  var divresul="notificacion_corporativa"}
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
              $('<li class="dropdown li"></li>').appendTo('#lista_corporativa').html('<img src="'+data+'" alt="" class="img-rounded img-thumbnail"  width="150px" />').addClass('success');
              $("#fotografia_corporativa").attr('src', $("#fotografia_corporativa").attr('src') + '?' + Math.random() );               
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
  
{{Form::open(array('url' => 'Actualizar_Empresa_Cliente','onKeypress'=>'if(event.keyCode == 13) event.returnValue = false;','enctype'=>'multipart/form-data'))}} 
 
  <h3 align="left" style="color: red">ACTUALIZAR DE EMPRESA</h3>
  <input type="hidden" name="id_empresa" id="id_empresa" value="{{$empresa[0]->id}}">
  <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
    <div class="form-group">
        {!!Form::label('nit','NIT:')!!}
        {!!Form::text('nit',$empresa[0]->nit,['id'=>'nit','class'=>'form-control','placeholder'=>'Ingrese el NIT de la Empresa','maxlength'=>'50','onkeyup'=>'controlar()', 'onkeypress'=>'return bloqueo_de_punto(event)'])!!}
        <label id="nit_verificar" hidden="" style="color: red">* Ya existe ese NIT</label>
    </div>

    

    <div class="form-group" >
        {!!Form::label('razon_social','Razon Social:')!!}
        {!!Form::text('razon_social',$empresa[0]->razon_social,['class'=>'form-control','placeholder'=>'Ingrese la razon social','maxlength'=>'50'])!!}
    </div>

         <div class="form-group">
        {!!Form::label('direccion','Direccion:')!!} 
        {!!Form::textarea('direccion',$empresa[0]->direccion,['class'=>'form-control','placeholder'=>'Ingrese la Dirección','style'=>'height:100px;'])!!}    
        {!!Form::hidden('latitud',$empresa[0]->latitud,['class'=>'form-control'])!!}    
        {!!Form::hidden('longitud',$empresa[0]->longitud,['class'=>'form-control'])!!}
    </div>


    <div class="form-group"  > 
        {!!Form::label('correo','correo:')!!}
        {!!Form::text('correo',$empresa[0]->correo,['class'=>'form-control','placeholder'=>'Ingrese su correo'])!!}
    </div>  
  
    <div class="form-group" >
   

    <div class="form-group" >
            {!!Form::label('estado','Estado:')!!}
            {!!Form::select('estado', array('1' => 'ACTIVO', '0' => 'INACTIVO'),$empresa[0]->estado,array('id'=>'estado','class'=>'form-control'))!!}
    </div>          
 
    <div class="form-group" >
      {!!Form::label('','Telefono:')!!}
        {!!Form::text('telefono',$empresa[0]->telefono,['class'=>'form-control','placeholder'=>'Telefono'])!!}
    </div>

    <div class="form-group"  > 
        {!!Form::label('whatsapp','whatsapp:')!!}
        {!!Form::text('whatsapp',$empresa[0]->whatsapp,['class'=>'form-control','placeholder'=>'Ingrese su whatsapp','maxlength'=>'15'])!!}
    </div>  



<input type="hidden" name="id_imagen_corporativa" id="id_imagen_corporativa" value="">

<input type="hidden" name="privilegio" id="privilegio" value="0">
</div>




<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12" >
  <div align="form-group">
    <div class="list-group-item ">
       Con factura
      <div class="material-switch pull-right">
        <input id="con_factura" name="con_factura"  type="checkbox"  @if($empresa[0]->con_factura==1) checked="" @endif />
        <label for="con_factura" class="label-success" onclick="con_factura()" ></label>
      </div>
     </div>
   </div>

  

  <div id="div_con_factura" @if($empresa[0]->con_factura==0) hidden="" @endif >
     <div align="form-group" >
      <div class="list-group-item ">
         Paga IVA
        <div class="material-switch pull-right">
          <input id="paga_iva" name="paga_iva" type="checkbox"   @if($empresa[0]->paga_iva==1) checked="" @endif/>
          <label for="paga_iva" class="label-success"  onclick="paga_iva()"></label>
        </div>
       </div>
     </div>

     <div align="form-group" >
      <div class="list-group-item ">
         Paga IT
        <div class="material-switch pull-right">
          <input id="paga_it" name="paga_it" type="checkbox"  @if($empresa[0]->paga_it==1) checked="" @endif />
          <label for="paga_it" class="label-success"  onclick="paga_it()"></label>
        </div>
       </div>
     </div>
  </div>

  <div  id="div_iva"  @if($empresa[0]->paga_iva==0) hidden="" @endif >
    <div class="form-group" id="div_iva" > 
      {!!Form::label('iva','Iva (%):')!!}
      {!!Form::number('iva', $empresa[0]->iva,['class'=>'form-control','placeholder'=>'Ingrese su whatsapp','maxlength'=>'15'])!!}
    </div>
     <div class="panel-group">
        <div class="panel panel-default">
          <div class="panel-body">
            <div class="funkyradio"  >
            <label>¿Quien paga el IVA?</label></br>
              <div class="funkyradio-primary">
                  <input type="radio" name="quien_paga_iva" id="quien_paga_iva_r1" value="1" @if($empresa[0]->quien_paga_iva==1) checked="" @endif/>
                  <label for="quien_paga_iva_r1">Empresa</label>
              </div>
              <div class="funkyradio-success">
                  <input type="radio" name="quien_paga_iva" id="quien_paga_iva_r2"   value="2" @if($empresa[0]->quien_paga_iva==2) checked="" @endif />
                  <label for="quien_paga_iva_r2">Conductor</label>
              </div>
            </div>
          </div>
        </div>
    </div>
  </div>

  <div id="div_it"   @if($empresa[0]->paga_it==0) hidden="" @endif>
    <div class="form-group"  > 
      {!!Form::label('i','IT (%):')!!}
      {!!Form::number('it',$empresa[0]->it,['class'=>'form-control','placeholder'=>'Ingrese su whatsapp','maxlength'=>'15'])!!}
    </div>


      <div class="panel-group" >
        <div class="panel panel-default">
          <div class="panel-body">
            <div class="funkyradio"  >
            <label>¿Quien paga el IT?</label></br>
              <div class="funkyradio-primary">
                  <input type="radio" name="quien_paga_it" id="radio1"  @if($empresa[0]->quien_paga_it==1) checked="" @endif value="1" />
                  <label for="radio1">Empresa</label>
              </div>
              <div class="funkyradio-success">
                  <input type="radio" name="quien_paga_it" id="radio2"  @if($empresa[0]->quien_paga_it==2) checked="" @endif value="2" />
                  <label for="radio2">Conductor</label>
              </div>
            </div>
          </div>
        </div>
    </div>
  </div>

 </div>



<div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
<label>Dirección de la empresa:</label>
    <input id="pac-input" class="controls" type="text" placeholder="Search Box" class="form-control">
    <div id="map" style="width: 100%; height: 550px;"></div>
  
</div>


   
</div>



   <div align="right">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            {!!Form::submit('ACTUALIZAR',['class'=>'btn btn-success','id'=>'btn_registrar','onclick'=>'btn_esconder()'])!!}   
            </form>
            <button class="btn btn-danger" data-toggle="modal" data-target="#ModalCambiar">CAMBIAR ADMINISTRADOR</button>
      
            <a href="{{url('usuarios_empresa', ['idguest' => $empresa[0]->id])}}" class="btn btn-primary" hidden="">Usuarios</a>
           <a class='btn btn-default  ' href="{{url('crear_pago_empresa', ['idguest' => $empresa[0]->id])}}" aria-hidden="true"  target="_blanck" hidden>Pagar deuda</a>
      

        </div>
    </div>

        

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <hr style="background: black; height:3px; size: 4px;" >

  <h4 align="left" style="color: red"><b>DOCUMENTOS DE LA EMPRESA</b></h4>
</div>

<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 " >
        <form  id="f_subir_imagen_corporativa" name="f_subir_imagen_corporativa" method="post"  action="subir_imagen_corporativa" class="formulario_corporativa" enctype="multipart/form-data" >  
            <input type="hidden" name="id_empresa" id="id_empresa" value="{{$empresa[0]->id}}">
        <table class="table table-striped table-bodered table-condensed table-hover" style="background: #EEDECA; border-radius: 8px;">
            <tr style="background: #635234; color: white"> <td>Imagen Corporativa </td></tr>
            <tr>
                <td>
                  
                           <input type="hidden" name="_token" id="_token"  value="<?= csrf_token(); ?>">
                            <div id="notificacion_corporativa"></div>
                            
                            <center><ul id="lista_corporativa"  class="nav navbar-nav">
                                   
                                    </ul></center>
                            <div class="btn-group">
                                 <button type="submit" class="btn btn-default"><i class="fa fa-upload" aria-hidden="true"></i> Subir Imagen</button>
                                <label class="btn btn-primary">
                                    Buscar.. <input type="file" name="perfil_imagen_corporativa" id="perfil_imagen_corporativa" class="perfil_imagen_corporativa"   required style="display: none;">
                                </label>
                            </div>        
                          
                </td>
            </tr>
        </table> 
        </form>    
</div>  
</div>








    



    


   {!!Html::script('js/empresa_cliente_actualizar.js')!!}
</div>
</div>

<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCNTI7MFuYXiwGi3Opvcr8G3fJYE4ug4fc&callback=initAutocomplete&libraries=places"></script>


@endsection

