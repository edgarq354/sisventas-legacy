
@extends ('layouts.inicio')
@section ('contenido')
@include('alerts.success')
@include('alerts.request')
@include('alerts.errors')
@include('lugar.modal_cambiar_administrador')

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
   var loadFile = function(event) {
    var reader = new FileReader();
    reader.onload = function(){
      var output = document.getElementById('output');
      output.src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
  };
</script>


</script>


    <script type="text/javascript">
      $(document).on("submit",".formulario_logo",function(e){
        e.preventDefault();
        var formu=$(this);
        var nombreform=$(this).attr("id");

        if(nombreform=="f_subir_logo" ){ var miurl="subir_logo_lugar";  var divresul="notificacion_corporativa"}
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
              $('<li class="dropdown li"></li>').appendTo('#lista_logo').html('<img src="'+data+'" alt="" class="img-rounded img-thumbnail"  width="150px" />').addClass('success');
              $("#fotografia_corporativa").attr('src', $("#fotografia_corporativa").attr('src') + '?' + Math.random() );               
            },
            //si ha ocurrido un error
            error: function(data){
               alertify.error("ha ocurrido un error"+data) ;
                
            }
        });
    });

      $(document).on("submit",".formulario_banner",function(e){
        e.preventDefault();
        var formu=$(this);
        var nombreform=$(this).attr("id");

        if(nombreform=="f_subir_banner" ){ var miurl="subir_banner_lugar";  var divresul="notificacion_banner"}
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
              $("#"+divresul+"").html($("#cargador_banner").html());                
            },
            //una vez finalizado correctamente
            success: function(data){
                alertify.success("Imagen agregada correctamente");
              $("#"+divresul+"").html("Imagen agregada correctamente");
              $('<li class="dropdown li"></li>').appendTo('#lista_banner').html('<img src="'+data+'" alt="" class="img-rounded img-thumbnail"  width="150px" />').addClass('success');
              $("#fotografia_corporativa").attr('src', $("#fotografia_corporativa").attr('src') + '?' + Math.random() );               
            },
            //si ha ocurrido un error
            error: function(data){
               alertify.error("ha ocurrido un error"+data) ;
                
            }
        });
    });
</script>

	<div class="row">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
 {!!Form::open(['route'=>['lugar.update','null'],'method'=>'PUT','enctype'=>'multipart/form-data','name'=>'formulario_actualizar'])!!}


<?php
 $nombre_administrador="";
 
foreach ($administrador as $va){
   $nombre_administrador=$va->nombre." ".$va->apellido;
 }

?>
  

  @foreach($lugar as $value)

<?php
$id_empresa=$value->id;
$direccion_logo=$value->direccion_logo;
$direccion_banner=$value->direccion_banner;
$imagen1=$value->imagen1;
$imagen2=$value->imagen2;
$imagen3=$value->imagen3;
$imagen4=$value->imagen4;
$imagen5=$value->imagen5;
$imagen6=$value->imagen6;
$imagen7=$value->imagen7;
$imagen8=$value->imagen8;
$imagen9=$value->imagen9;
$imagen10=$value->imagen10;
?>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

<div class="col-lg-2 col-xs-3">
          <div class="small-box bg-green">
            <div class="inner fa fa-cart-arrow-down fa-2x">             
            </div>
             <a    style="color: white;">  {{$value->cantidad}} </a>
             <a    class="small-box-footer">Cantidad de pedidos <i class="fa fa-arrow-circle-right"></i></a>
          </div>
</div>

<div class="col-lg-2 col-xs-3">
          <div class="small-box bg-blue">
            <div class="inner fa fa-money fa-2x">             
            </div>
             <a    style="color: white;">  {{$value->ganancia}} Bs</a>
             <a  href='../../historial_pedidos_lugar/{{$id_empresa}}'   class="small-box-footer">Ganancia <i class="fa fa-arrow-circle-right"></i></a>
          </div>
</div>

<div class="col-lg-2 col-xs-3">
          <div class="small-box bg-yellow">
            <div class="inner fa fa-handshake-o fa-2x">             
            </div>
             <a href=""  style="color: white;">  {{$value->monto_deuda}} Bs</a>
             <a   href="{{url('crear_pago_lugar', ['idguest' => $id_empresa])}}"   class="small-box-footer">Pagar deuda <i class="fa fa-arrow-circle-right"></i></a>
          </div>
</div>

<div class="col-lg-2 col-xs-3">
          <div class="small-box bg-red">
            <div class="inner fa fa-user fa-2x">             
            </div>
             <a href=""  style="color: white;"> Administrador</a>
             <a href="" data-toggle="modal" data-target="#ModalCambiar"  class="small-box-footer">Cambiar <i class="fa fa-arrow-circle-right"></i></a>
          </div>
</div>

<div class="col-lg-2 col-xs-3">
          <div class="small-box bg-red">
            <div class="inner fa fa-product-hunt fa-2x">             
            </div>
             <a href=""  style="color: white;"> Productos</a>
              <a   href="{{url('producto_lugar', ['idguest' => $id_empresa])}}"    class="small-box-footer">Ver detalle <i class="fa fa-arrow-circle-right"></i></a>
          </div>
</div>

<div class="col-lg-2 col-xs-3">
          <div class="small-box bg-green">
            <div class="inner fa fa-whatsapp fa-2x">             
            </div>
             <a href=""  style="color: white;"> {{$value->cantidad_whatsapp}}  </a>
              <a   href="{{url('servicio_whatsapp_lugar', ['idguest' => $id_empresa])}}"    class="small-box-footer">Ver detalle <i class="fa fa-arrow-circle-right"></i></a>
          </div>
</div>

</div>

	<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
  <input type="hidden" name='id_empresa' value="{{$value->id_empresa}}" />
  <input type="hidden" name='id_lugar' value="{{$value->id}}" />


  
  Buscar Categoria:
    <div class="form-group">
      <select name="id_categoria" class="form-control selectpicker" id="id_categoria" data-live-search="true" >
         <option value="{{$value->id_categoria}}">  BUSCAR...                                </option>
            @foreach($categoria as $mov)
            <option value="{{$mov->id}}" @if($value->id_categoria==$mov->id ) selected="" @endif >{{$mov->nombre}} </option>            
            @endforeach
        </select>
     
    </div>


       

	<div class="form-group">
		Nombre:<br>
		<input type="text"  name="nombre" placeholder="Ingrese el nombre" class="form-control" id="nombre" value="{{$value->nombre}}" >
	</div>

<div class="form-group">
    Nit:<br>
    <input type="text"  name="nit" placeholder="Nit" class="form-control" id="nit" value="{{$value->nit}}" >
  </div>

  <div class="form-group">
    Dirección:<br>
    {!!Form::textarea('direccion',$value->direccion,['class'=>'form-control','placeholder'=>'Ingrese la dirección','style'=>'height:100px' ])!!}
  </div>

  <div class="form-group">
    Información:<br>
    {!!Form::textarea('informacion',$value->informacion,['class'=>'form-control','placeholder'=>'Ingrese la información','style'=>'height:100px' ])!!}
  </div>

<div class="form-group">
    Facebook:<br>
    <input type="text"  name="facebook" placeholder="URL..." value="{{$value->facebook}}" class="form-control"   >
  </div>

<div class="form-group">
    Porcentaje de pago por pedido(%):<br>
    <input type="number" min="0" max="50" name="porcentaje_pago" placeholder="Porcentaje" value="{{$value->porcentaje_pago}}" class="form-control"   >
  </div>



  <div class="form-group"  >
    {!!Form::label('','Longitud:')!!}
    <div class="input-group">
      <input type="text" class="form-control" name='latitud' id="latitud" value="{{$value->latitud}}"   enabled="">
      <span class="input-group-btn">
        <a><button class="btn btn-primary"     type="button"><i class="fa fa-print-pin" aria-hidden="true"></i></button></a>
      </span>
    </div>
  </div>  
 
  <div class="form-group"  >
    {!!Form::label('','latitud:')!!}
    <div class="input-group">
      <input type="text" class="form-control"  name='longitud' id="longitud" value="{{$value->longitud}}" enabled="">
      <span class="input-group-btn">
        <a><button class="btn btn-danger"      type="button"><i class="fa fa-print-pin" aria-hidden="true"></i></button></a>
      </span>
    </div>
  </div>  

  

 




 <div class="form-group">
    Titulo imagen:<br>
    <input type="text"  name="titulo_imagen" placeholder="Titulo imagen" value="{{$value->titulo_imagen}}" class="form-control" id="titulo_imagen" >
  </div>

 @if($value->id_administrador>0)
   <div class="form-group"  >
    {!!Form::label('','Administrador:')!!}
    <div class="input-group">
      <input type="text" class="form-control"  name='administrador' id="administrador" value="{{$nombre_administrador}}" enabled="">
      <span class="input-group-btn">
        <a  href="../../pasajero/{{$value->id_administrador}}/edit"><button class="btn btn-danger"      type="button"><i class="fa fa-eye" aria-hidden="true"></i></button></a>
      </span>
    </div>
  </div> 
@endif
   

  
   <div class="form-group">
    Telefono:<br>
    <input type="number"  name="telefono" placeholder="Telefono" value="{{$value->telefono}}" class="form-control" id="telefono" >
  </div>

   <div class="form-group">
    WhatsApp:<br>
    <input type="text"  name="whatsapp" placeholder="WhatsApp" value="{{$value->whatsapp}}" class="form-control" id="whatsapp" >
  </div>

 <div class="form-group">
    Tiempo de preparación (min):<br>
    <input type="number"  name="tiempo_preparacion" placeholder="Tiempo de preparación" value="{{$value->tiempo_preparacion}}" class="form-control" id="tiempo_preparacion" >
  </div>

 <div class="form-group">
    Monto minimo:<br>
    <input type="number" name="monto_minimo" value="{{$value->monto_minimo}}" class="form-control"  >
  </div>


 <div class="form-group">
    Prioridad:<br>
    <input type="number"  name="prioridad" placeholder="Prioridad" value="{{$value->prioridad}}" class="form-control" >
  </div>

  <div class="form-group">
    <div class="list-group-item ">
       Estado
      <div class="material-switch pull-right">
        <input id="estado" name="estado" type="checkbox" @if($value->estado==1) checked="" @endif />
        <label for="estado" class="label-success"></label>
      </div>
     </div>
   </div>
	
<div class="form-group">
    <div class="list-group-item ">
      Visible en la app
      <div class="material-switch pull-right">
        <input id="estado_pedido" name="estado_pedido" type="checkbox" @if($value->estado_pedido==1) checked="" @endif />
        <label for="estado_pedido" class="label-success"></label>
      </div>
     </div>
   </div>

<div class="form-group">
    <div class="list-group-item ">
       Realiza por Whatsapp
      <div class="material-switch pull-right">
        <input id="solicitud_whatsapp" name="solicitud_whatsapp" type="checkbox" @if($value->solicitud_whatsapp==1) checked="" @endif />
        <label for="solicitud_whatsapp" class="label-success"></label>
      </div>
     </div>
   </div>

<div class="form-group">
    <div class="list-group-item ">
       Realiza con Delivery
      <div class="material-switch pull-right">
        <input id="solicitud_aplicacion" name="solicitud_aplicacion" type="checkbox" @if($value->solicitud_aplicacion==1) checked="" @endif />
        <label for="solicitud_aplicacion" class="label-success"></label>
      </div>
     </div>
   </div>   

		<div class ="form-group">

			{!!Form::submit('ACTUALIZAR',['class'=>'btn btn-primary','id'=>'btn_registrar','onclick'=>'btn_esconder()'])!!}
			<a href="{!!URL::to('lugar')!!}" class="btn btn-danger">CANCELAR</a>

</div>

		
		
  </div>
  <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
{!!Form::label('','Dirección de la empresa:')!!}
    <input id="pac-input" class="controls" type="text" placeholder="Search Box" class="form-control">
    <div id="map" style="width: 100%; height: 550px;"></div>

<h4>Horario de atención</h4>
    <table class="table table-striped table-bordered table-condensed table-hover" >
      <thead>
      <tr>
        <th scope="col">Dia</th>
        <th scope="col">Hora inicial</th>
        <th scope="col">Hora final</th>
        <th scope="col">Estado</th>
      </tr>
      </thead>
      <tbody>
         @foreach($horario_lugar as $mov)

             <tr>
          <td>{{$mov->nombre_dia}}</td>
          <td>
            <input type="time" name="hora_inicio{{$mov->id}}" class="form-control" value="{{$mov->hora_inicio}}" >
           </td>
          <td>
            <input type="time" name="hora_fin{{$mov->id}}" class="form-control" value="{{$mov->hora_fin}}" >
         </td>
          <td>
             <div class="material-switch pull-right">
                <input id="estado{{$mov->id}}" name="estado{{$mov->id}}" type="checkbox"   @if($mov->estado==1) checked="" @endif   />
                <label for="estado{{$mov->id}}" class="label-success"></label>
              </div>

          </td>
        </tr>

            @endforeach

      </tbody>   
    </table>


</div>


@endforeach
</form>

  </div>
  </div>
  

 
<div class="row">
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">  
  <hr>
<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12  " >
  <div class=" panel panel-danger">
        <div class="panel-heading"> <label>LOGO (512 x 512)</label>  </div>
        <div class="panel-body">

        <form  id="f_subir_logo" name="f_subir_logo" method="post"  action="subir_logo_lugar" class="formulario_logo" enctype="multipart/form-data" >  
        
         <input type="hidden" name="id_lugar" id="id_lugar" value="{{$id_empresa}}">

        <table class="table table-striped table-bodered  "  >
            <tr>
                <td>
                  
                           <input type="hidden" name="_token" id="_token"  value="<?= csrf_token(); ?>">
                            <div id="notificacion_corporativa"></div>
                            
                            <center><ul id="lista_logo"  class="nav navbar-nav">
                                     <li class="dropdown">
                                        <img src="../../../storage/{{$direccion_logo}}" class="img-rounded img-thumbnail" alt="" style="width: 100%; max-width: 250px;" ></img>
                                    </li>
                                    
                                    </ul></center>
                              
                          
                </td>
            </tr>
            <tr>
              <td>
                 <div class="btn-group">
                                 <button type="submit" class="btn btn-default"><i class="fa fa-upload" aria-hidden="true"></i> Subir Imagen</button>
                                <label class="btn btn-primary">
                                    Buscar.. <input type="file" name="perfil_logo" id="perfil_logo" class="perfil_logo"   required style="display: none;">
                                </label>
                            </div>     
              </td>
            </tr>
        </table> 
        </form>    
</div>  
</div>  
</div>  


<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12" >
 
 <div class=" panel panel-danger">
        <div class="panel-heading"> <label>BANNER (1024 x 512) </label>  </div>
        <div class="panel-body">


        <form  id="f_subir_banner" name="f_subir_banner" method="post"  action="subir_banner_lugar" class="formulario_banner" enctype="multipart/form-data" >  
        
         <input type="hidden" name="id_lugar" id="id_lugar" value="{{$id_empresa}}">

        <table class="table table-striped table-bodered  "  >
            <tr>
                <td>
                  
                           <input type="hidden" name="_token" id="_token"  value="<?= csrf_token(); ?>">
                            <div id="notificacion_banner"></div>
                            
                            <center><ul id="lista_banner"  class="nav navbar-nav">
                                     <li class="dropdown">
                                        <img src="../../../storage/{{$direccion_banner}}" class="img-rounded img-thumbnail" alt="" style="width: 100%; max-width: 250px;" ></img>
                                    </li>
                                    
                                    </ul></center>
                              
                          
                </td>
            </tr>
            <tr>
              <td>
                 <div class="btn-group">
                                 <button type="submit" class="btn btn-default"><i class="fa fa-upload" aria-hidden="true"></i> Subir Imagen</button>
                                <label class="btn btn-primary">
                                    Buscar.. <input type="file" name="perfil_banner" id="perfil_banner" class="perfil_banner"   required style="display: none;">
                                </label>
                            </div>     
              </td>
            </tr>
        </table> 
        </form>    
</div>  
</div>  
</div>  
   

   </div>
   </div>


<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 well" hidden="" >  

<h2> Lista de  Productos </h2>
<hr style="height: 2px; background-color: black;">

  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
 
  

 
{!!Form::open(['route'=>'producto.store', 'method'=>'POST' , 'enctype'=>'multipart/form-data'])!!} 
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 well">
  <div class="col-lg-4 col-md-8 col-sm-10 col-xs-12" > 
   <input type="hidden" name='id_empresa' value="{{Auth::user()->id_empresa}}" />
  <input type="hidden" name='id_lugar' value="{{$id_empresa}}" />

  <h2 align="left" style="color: black">Agregar Producto</h2>
  
  

       

  <div class="form-group">
    Nombre:<br>
    <input type="text"  name="nombre" placeholder="Ingrese el nombre" class="form-control" id="nombre" value="" >
  </div>

   Buscar Categoria:
    <div class="form-group">
      <select name="id_tipo_producto" class="form-control selectpicker" id="id_categoria" data-live-search="true" >
         <option value="">  BUSCAR CATEGORIA...                                </option>
            @foreach($tipo_producto as $mov)

            <option value="{{$mov->id}}"
              @if(""==$mov->id )
               selected="" @endif >{{$mov->nombre}}
            </option>  

            @endforeach
        </select>
     
    </div>


  <div class="form-group">
    Descripcion:<br>
    {!!Form::textarea('descripcion','',['class'=>'form-control','placeholder'=>' ','style'=>'height:100px' ])!!}
  </div>

  
<div class ="form-group">
    <div class="list-group-item ">
       Realiza Pedidos
      <div class="material-switch pull-right">
        <input id="estado_pedido_producto" name="estado_pedido_producto" type="checkbox"   />
        <label for="estado_pedido_producto" class="label-success"></label>
      </div>
     </div>
    
   </div>

  <div class="form-group">
    Precio:<br>
    <input type="decimal"  name="precio" placeholder=" " class="form-control" id="nombre" value="2" >
  </div>
  


  

</div>
<div class="col-lg-4 col-md-8 col-sm-10 col-xs-12 " > 
     

  <div class="form-group">
     <div class="btn-group">
       <label class="btn btn-warning">
        <i class="fa fa-upload" aria-hidden="true"></i>
        Buscar imagen del producto<input type="file" name="imagen1_producto" id="imagen1_producto" onchange="loadFile(event)"    style="display: none;">
        </label>
    </div> 
    </div> 

  <div class="form-group">
     <img id="output" style="max-width: 200px;" />
</div>

   <div class="form-group">
     {!!Form::submit('Agregar a la lista',['class'=>'btn btn-primary','id'=>'btn_registrar','onclick'=>'btn_esconder()'])!!}
  </div>

  </div>
 </div> 
</form>



 
 
 


  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

<hr style="height: 2px; background-color: black;">

   
  <div class="panel-body">
          <table class="table table-striped table-bordered table-condensed table-hover" style="background: white" id="myTable">
            <thead>
              <th><center>ID</center></th>
              <th><center>NOMBRE</center></th>
              <th><center>DESCRIPCION</center></th>
              <th><center>PRECIO</center></th>
              <th><center>IMAGEN </center></th>
              <th><center>TIPO DE PRODUCTO</center></th>
              <th><center>PEDIDOS</center></th>
              <th><center>...</center></th>
              
            </thead>

            <tbody align="center" id="body_video">          
            @foreach($producto as $usr)
            <tr>
              <td>{{ $usr->id}}</td>
              <td>{{ $usr->nombre}}</td>
              <td>{{ $usr->descripcion}}</td>
              <td>{{ $usr->precio}}</td>

              <td>@if($usr->imagen1!="")
                <img src="../../../storage/{{$usr->imagen1}}" class="img-rounded img-thumbnail" alt="" style="width: 100%; max-width: 250px;" ></img> 
                @endif 
              </td>
              <td>
                {{ $usr->nombre_tipo_producto}}
              </td>

            <td>@if($usr->estado_pedido==1)
              <label style="color: green;">REALIZA</label>
              @else
              <label style="color: red;">NO REALIZA</label>
              @endif
             </td>


              <td>
              {!!link_to_route('producto.edit','', $parameters = $usr->id, $attributes = ['class'=>'btn btn-primary fa fa-eye','data-toggle'=>'tooltip','data-placement'=>'top','title'=>'Ver y editar'])!!}
              
                </td>
            </tr>
            @endforeach
            </tbody>

               
          </table>
          </div>
</div>




</div>

   {!!Html::script('js/lugar_actualizar.js')!!}
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCNTI7MFuYXiwGi3Opvcr8G3fJYE4ug4fc&callback=initAutocomplete&libraries=places"></script>
 
@endsection

