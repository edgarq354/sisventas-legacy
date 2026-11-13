@extends ('layouts.inicio')
@section ('contenido')
@include('alerts.success')
@include('alerts.request')
@include('alerts.errors') 

 
<script type="text/javascript">

  //FOTO DE PERFIL

 




    $(document).on("submit",".formulario_registrar_pasajero",function(e){
 
        e.preventDefault();
        var formu=$(this); 

        var miurl="registrar_usuario_pedido"; 
        var divresul="notificacion_perfil";
        //información del formulario
        var formData = new FormData($("#formulario_registrar_pasajero")[0]);

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
              alertify.success(":"+data);
              $("#"+divresul+"").html("Solicitud registrado correctamente"); 
              ver_ocultar_pasajero(0);   
            },
            //si ha ocurrido un error
            error: function(data){
               alertify.error("ha ocurrido un error:"+data) ;
                
            }
        });
    });
 
</script>






<script type="text/javascript">
  $(document).ready(function(){
    $('#tabla_sin_imprimir2').DataTable({
      "order": [[ 0, "desc" ]],
       select:true,
        "dom": '<"top"fl>rt<"bottom"ip><"clear">',
    
  buttons: [
           { extend:'print',
             text: 'Imprimir'},
          
        ],
      "language":{
                    "sProcessing":     "Procesando...",
                    "sLengthMenu":     "Mostrar _MENU_ registros",
                    "sZeroRecords":    "No se encontraron resultados",
                    "sEmptyTable":     "Ningún dato disponible en esta tabla",
                    "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                    "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
                    "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                    "sInfoPostFix":    "",
                    "sSearch":         "Buscar:",
                    "sUrl":            "",
                    "sInfoThousands":  ",",
                    "sLoadingRecords": "Cargando...",
                    "oPaginate": {
                        "sFirst":    "Primero",
                        "sLast":     "Último",
                        "sNext":     "Siguiente",
                        "sPrevious": "Anterior"
                    },
                    "oAria": {
                        "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                    }
                  }           

    });

});

  $(document).ready(function(){
    $('#tabla_sin_imprimir3').DataTable({
      "order": [[ 0, "desc" ]],
       select:true,
        "dom": '<"top"fl>rt<"bottom"ip><"clear">',
    
  buttons: [
           { extend:'print',
             text: 'Imprimir'},
          
        ],
      "language":{
                    "sProcessing":     "Procesando...",
                    "sLengthMenu":     "Mostrar _MENU_ registros",
                    "sZeroRecords":    "No se encontraron resultados",
                    "sEmptyTable":     "Ningún dato disponible en esta tabla",
                    "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                    "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
                    "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                    "sInfoPostFix":    "",
                    "sSearch":         "Buscar:",
                    "sUrl":            "",
                    "sInfoThousands":  ",",
                    "sLoadingRecords": "Cargando...",
                    "oPaginate": {
                        "sFirst":    "Primero",
                        "sLast":     "Último",
                        "sNext":     "Siguiente",
                        "sPrevious": "Anterior"
                    },
                    "oAria": {
                        "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                    }
                  }           

    });

});

</script>
  
    <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #mapa2 {
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
     const empresa = {!! json_encode($empresa) !!};
    console.log(empresa);

  function seleccion_lugar()
  {

      var id_lugar=$("#id_lugar").val();
   
     for (var i=0; i<empresa.length; i++) { 
 
        var lugar=empresa[i];
        var id_lugar_empresa=lugar.id;

        if(id_lugar==id_lugar_empresa)
        {
          $("#latitud_lugar").val(lugar.latitud);
          $("#longitud_lugar").val(lugar.longitud);
        }
        
       }

       apuntar_direccion_tienda();

      
  }
</script>


<div class="modal fade" id="ModalAsignar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static">
   
 
      

  <div class="modal-dialog modal-lg" role="document" >
    <div class="modal-content">

            <div class="modal-header" style="background: #3c8dbc; color: white">
              <h3 id="titulogalpon" class="modal-title">Asignar un Conductor</h3>
            </div>

            <div class="modal-body">

             

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
   <div class=" panel panel-success">
        <div class="panel-heading"> 
          <label>Datos del pedido</label>
        </div>
    <div class="panel-body "  >

        <b>Nombre: <label id="lb_nombre"></label></b><br>
        <b>Celular: <label id="lb_celular"></label></b><br>
        <b>Correo: <label id="lb_correo"></label></b><br>
        <b>Referencia: <label id="lb_direccion"></label></b><br>
        <b>Dirección: <label id="lb_indicacion"></label></b><br>
        <b>Clase de Vehiculo:<label id="lb_clase_vehiculo"></label></b><br>
        <b>Empresarial:<label id="lb_empresa"></label></b><br>
        <b>Hora:</b> <label id="lb_hora"></label><br>
        <h3 id="lb_tiempo"></h3>
  </div>
  </div>
 
  </div>
 
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
  <div class=" panel panel-primary">
        <div class="panel-heading"> 
          <label>Conductores libres</label>
        </div>
    <div class="panel-body "  >
   <table class="table table-striped table-bordered table-condensed table-hover" style="background: white"  >   
      <thead>
            <th><center># Movil</center></th>
            <th><center>Conductor</center></th>
            <th><center>Distancia</center></th> 
            <th><center>Credito</center></th> 
            <th><center>Asignar</center></th> 
      </thead>
      <tbody align="center" id="body_conductor_libre">

      </tbody>
    </table>
  </div>
  </div>

<div style="display: none;" id="cargador_asignacion" align="center">
            <br>
         

         <label style="color:#FFF; background-color:#ABB6BA; text-align:center">&nbsp;&nbsp;&nbsp;Espere... &nbsp;&nbsp;&nbsp;</label>

         <img src="../../images/cargando.gif" align="middle" alt="cargador"> &nbsp;<label style="color:#ABB6BA">Asignando el Taxi ...</label>

          <br>
         <hr style="color:#003" width="50%">
         <br>
       </div>
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 " >
        <div id="notificacion_resultado"></div>
  </div> 

</div>

  
              
        </div>

      </div>

      <div class="modal-footer">

           
            <button data-dismiss="modal"  class="btn btn-danger">SALIR</button>
        </div>
    </div> 
  </div>


</div>








<div style="display: none;" id="cargador_empresa" align="center">
            <br>
         

         <label style="color:#FFF; background-color:#ABB6BA; text-align:center">&nbsp;&nbsp;&nbsp;Espere... &nbsp;&nbsp;&nbsp;</label>

         <img src="../../images/cargando.gif" align="middle" alt="cargador"> &nbsp;<label style="color:#ABB6BA">Registrando la solicitud</label>

          <br>
         <hr style="color:#003" width="50%">
         <br>
       </div>


<div class="row" id="inicio"> 
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

    
  <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12" id="div_buscar_empresa">
    @if(Auth::user()->privilegio==3) 
    @elseif(Auth::user()->privilegio!=0) 
        <select name="buscar_empresa" class="form-control selectpicker" id="buscar_empresa" data-live-search="true" >
         <option value="">BUSCAR EMPRESAS...                                   </option>
         <option value="-1">TODAS LAS EMPRESAS                                   </option>
            @foreach($buscar_empresa as $mot)
            <option value="{{$mot->id}}">{{$mot->razon_social}}</option>
            @endforeach
        </select>
    @endif  
  </div>


    

     
  </div>

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

  <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
    <div id="mapa" style="width: 100%; height: 700px;"></div>
  </div>

  <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">

    <table class="table table-striped table-bordered table-condensed table-hover" style="background: white;">
        <thead>
          <th ><center>Significado</center></th>
        </thead>
        <tbody>
                  <tr>
          <td align="left" data-toggle="tooltip" data-placement="top" title="Conductores Activos"><img src="images/activo.png" width="30px" height="40px"> Libre 
           (<b><label id="lb_cantidad_libre">0</label></b>)
          </td>
          </tr>
          <tr>
          <td align="left" data-toggle="tooltip" data-placement="top" title="Conductores con estado desabilitado"><img src="images/inactivo.png" width="30px" height="40px"> Descanso
           (<b><label id="lb_cantidad_descanso">0</label></b>)
          </td>
          </tr>
          <tr>
          <tr>
          <td align="left" data-toggle="tooltip" data-placement="top" title="Conductores que estan cubriendo una solicitud de pedido"><img src="images/ic_pedido.png" width="30px" height="40px"> Ocupado  (<b><label id="lb_cantidad_en_servicio">0</label></b>)</td>
          </tr>
          
          <td align="left" data-toggle="tooltip" data-placement="top" title="Conductores suspendido por (Deudas o Otros )"><img src="images/ic_suspendido.png" width="30px" height="40px"> Suspendido 
           (<b><label id="lb_cantidad_suspendido">0</label></b>)
          </td>
          </tr>
          <tr>
          <td   align="left" data-toggle="tooltip" data-placement="top" title="Motistas Activos"><img src="images/activo_moto.png" width="30px" height="40px"> Libre 
             (<b><label id="lb_cantidad_moto_libre">0</label></b>)
          </td>
          </tr>
          <tr>
          <td   align="left" data-toggle="tooltip" data-placement="top" title="Motistas con estado desabilitado"><img src="images/inactivo_moto.png" width="30px" height="40px"> Descanso
             (<b><label id="lb_cantidad_moto_descanso">0</label></b>)
          </td>
          </tr>
          <tr>
          <tr>
          <td   align="left" data-toggle="tooltip" data-placement="top" title="motistas que estan cubriendo una solicitud de pedido"><img src="images/ic_pedido_moto.png" width="30px" height="40px"> Ocupado (<b><label id="lb_cantidad_moto_en_servicio">0</label></b>) </td>
          </tr>
          
          <td  align="left" data-toggle="tooltip" data-placement="top" title="Motistas suspendido por (Deudas o Otros )"><img src="images/ic_suspendido_moto.png" width="30px" height="40px"> Suspendido 
          (<b><label id="lb_cantidad_moto_suspendido">0</label></b>)
          </td>
          </tr>
          <tr>
          <td align="left" >
            <div class="font-family" id="div_buscar_opcion" hidden="">        
                <select class="form-control" id="buscar_opcion" name="buscar_opcion"  >
                  <option value="0">OPCIONES DE BUSQUEDA</option>
                  <option value="1">LIBRE</option>
                  <option value="2">DESCANSO</option>
                  <option value="4">EN SERVICIO</option>
                  <option value="3" selected >TODOS</option>            
                </select>
            </div>  
          </td>
          </tr>
          </tbody>
        </tbody>
      </table>
      
    </div>

  </div>


  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
      <div class=" panel panel-success">
        <div class="panel-heading"> 
          <button class="btn btn-success" onclick="ver_solicitudes();">Ver las solicitudes</button>
          <button class="btn btn-primary" onclick="ver_servicios_en_proceso();">Servicio en proceso</button>
          <button class="btn btn-warning" onclick="ver_servicios_concluidos();">Servicios concluidos</button>
          <a class="btn btn-success fa fa-user"   href='#Modal_nuevo_pasajero' onclick="ver_ocultar_pasajero(1);" > Nuevo Pasajero</a>
        </div>
    
      
     
    <div class="panel-body " id="div_ver_solicitudes" style="background: #d6e9c6" >
        <table class="table table-striped table-bordered table-condensed table-hover" style="background: white" id="tabla_sin_imprimir">    
          <thead>
          <th><center>ID</center></th>
          <th><center>Nombre</center></th>
          <th><center>Celular</center></th>
          <th><center>Correo</center></th>
          <th><center>Direccion</center></th>
          <th><center>Indicación</center></th>
          <th><center>Clase de Vehiculo</center></th>
          <th><center>Empresarial</center></th>
          <th><center>...</center></th>
           
      </thead>

      <tbody align="center" id="body_ver_solicitudes">

      </tbody>
    </table>
    </div>

    <div class="panel-body" id="div_ver_servicios_en_proceso" hidden="" style="background: #d9edf7;">
        <table class="table table-striped table-bordered table-condensed table-hover" style="background: white" id="tabla_sin_imprimir2">   
          <thead>
          <th><center>ID</center></th>
          <th><center>Nro Movil</center></th>
          <th><center>Conductor</center></th>
          <th><center>Celular</center></th>
          <th><center>Marca</center></th>
          <th><center>PLaca</center></th>
          <th><center>Color</center></th>
          <th><center>Pasajero</center></th>
          <th><center>Celular</center></th>
          <th><center>Dirección</center></th>
          <th><center>Indicación</center></th>
          <th><center>. . .</center></th>
           
      </thead>

      <tbody align="center" id="body_ver_servicios_en_proceso">

      </tbody>
    </table>
    </div>

    <div class="panel-body" id="div_ver_servicios_concluidos" hidden="" style="background: #faebcc;">
        <table class="table table-striped table-bordered table-condensed table-hover" style="background: white" id="tabla_sin_imprimir3">   
          <thead>
            <th><center>Id</center></th>
            <th><center># Movil</center></th>
            <th><center>Conductor</center></th>
            <th><center>Pasajero</center></th>
            <th><center>Fecha de registro</center></th>
            <th><center><i class="fa fa-money"></i> Monto</center></th>
            <th><center>Tipo de vehiculo</center></th>
            <th><center>Direccion</center></th>
            <th><center>Indicacion/Ref.</center></th>
            <th><center>. . .</center></th>
      </thead>

      <tbody align="center" id="body_ver_servicios_concluidos">

      </tbody>
    </table>
    </div>
  </div> 

 
  </div>


  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 " style="margin-top: 100px; margin-bottom: 150px; padding-bottom: 150px;">
    

      <div   id="Modal_nuevo_pasajero" hidden=""  >
        <div class=" panel panel-primary">
            <div class="panel-heading"><h3 id="titulogalpon" class="modal-title">Registrar un nuevo pasajero</h3></div>
            <div class="panel-body">     
       
            
 
                  
 

                   

      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 "  >
        <form id="formulario_registrar_pasajero" name="formulario_registrar_pasajero" method="post"  action="registrar_usuario_pedido" class="formulario_registrar_pasajero" enctype="multipart/form-data">

              <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12 " >
                <div class="input-group">
                  <input type = "text" class = "form-control selectpicker text-uppercase" name="celular" id="celular" placeholder="Telefono" maxlength="10" >
                         
                  <span class="input-group-btn">
                    <button class="btn btn-success" onclick="verficar_numero_celular();" type="button">Verificar</button>
                  </span>
                  </div>


                
                 <div class="form-group" >
                {!!Form::label('nombre','Nombre:')!!}<span ><font color="red" size="5px">*</font></span>
                {!!Form::text('nombre',null,['class'=>'form-control text-capitalize','placeholder'=>'Ingrese el nombre','id'=>'nombre'])!!}
                </div> 
                 <div class="form-group"  >
                {!!Form::label('','Apellidos:')!!}<span ><font color="red" size="5px">*</font></span>
                {!!Form::text('apellidos',null,['class'=>'form-control text-capitalize','placeholder'=>'Ingrese el apellido','id'=>'apellidos'])!!}
              </div>
              

               <div class="form-group" >
                 {!!Form::label('','Tienda:')!!}<span ><font color="red" size="5px">*</font></span>
                <select name="id_lugar" class="form-control selectpicker" id="id_lugar" data-live-search="true" onchange="seleccion_lugar();" >
                     <option value="">BUSCAR TIENDAS</option>
                     <option value="0">Nuevo lugar</option>
                    @foreach($empresa as $emp)
                    <option value="{{$emp->id}}" >{{$emp->nombre}}</option>
                    @endforeach
                </select>
                 </div>

              <div class="form-group"  >
                {!!Form::label('','Nombre lugar:')!!}<span ><font color="red" size="5px">*</font></span>
                {!!Form::text('nombre_lugar','',['class'=>'form-control text-capitalize'])!!}
              </div>

              <div class="form-group"  >
                {!!Form::label('','Dirección lugar:')!!}<span ><font color="red" size="5px">*</font></span>
                {!!Form::text('direccion_lugar','',['class'=>'form-control text-capitalize'])!!}
              </div>

              <div class="form-group"  >
                {!!Form::label('','Monto de pedido:')!!}<span ><font color="red" size="5px">*</font></span>
                {!!Form::text('monto_pedido',0,['class'=>'form-control text-capitalize'])!!}
              </div>

               <div class="form-group"  >
                {!!Form::label('','Monto de envio:')!!}<span ><font color="red" size="5px">*</font></span>
                {!!Form::text('monto_envio',5,['class'=>'form-control text-capitalize'])!!}
              </div>

              <div class="form-group"  >
                <label id="que_necesitas">*</label><br>
                {!!Form::label('','Que necesitas?:')!!}<span ><font color="red" size="5px">*</font></span>
                {!!Form::textarea('que_necesitas',null,['class'=>'form-control text-capitalize','placeholder'=>'Ej. Un pollo economico','style'=>'height:100px;','id'=>'que_necesitas'])!!}
              </div>  
              
              <div class="form-group"  >
                <label id="direccion">*</label><br>
                {!!Form::label('','Indica la direccion de entrega:')!!}<span ><font color="red" size="5px">*</font></span>
                {!!Form::textarea('indicacion',null,['class'=>'form-control text-capitalize','placeholder'=>'Ej. Casa color roja con porton negro.','style'=>'height:100px;','id'=>'indicacion'])!!}
              </div>  


              <div class="form-group" hidden="" >  
                {!!Form::label('correo','Correo:')!!}
                {!!Form::text('correo',null,['class'=>'form-control','placeholder'=>'Ingrese el correo','id'=>'correo'])!!}
               </div>

          <div class="form-group"  >  
               {!!Form::label('','Punto de la tienda:')!!}<span ><font color="red" size="5px">*</font></span>
              
               <div class="input-group">
               <input type="text" class="form-control" name="latitud_lugar" value="" enabled="" id="latitud_lugar">
                   <span class="input-group-btn">
                    <a><button class="btn btn-primary"  type="button" onclick="apuntar_direccion_tienda();"><i class="fa fa-eye" aria-hidden="true"></i></button></a>
                   </span>
                 </div>

                <div class="input-group">
                 <input type="text" class="form-control" name="longitud_lugar" value="" enabled="" id="longitud_lugar">
                   <span class="input-group-btn">
                    <a><button class="btn btn-danger"  type="button" onclick="apuntar_direccion_tienda();"><i class="fa fa-eye" aria-hidden="true"></i></button></a>
                   </span>
                 </div>
          </div>

          <div class="form-group"  > 
             {!!Form::label('','Punto del cliente:')!!}<span ><font color="red" size="5px">*</font></span> 
               <div class="input-group">
               <input type="text" class="form-control" name="latitud" value="" enabled="" id="latitud">
                   <span class="input-group-btn">
                    <a><button class="btn btn-primary"  type="button" onclick="apuntar_direccion_cliente();"><i class="fa fa-eye" aria-hidden="true"></i></button></a>
                   </span>
                 </div>

                <div class="input-group">
                 <input type="text" class="form-control" name="longitud" value="" enabled="" id="longitud">
                   <span class="input-group-btn">
                    <a><button class="btn btn-danger"  type="button" onclick="apuntar_direccion_cliente();"><i class="fa fa-eye" aria-hidden="true"></i></button></a>
                   </span>
                 </div>
             
          </div>



 <div class="panel panel-primary" id="panel2">
        <div class="panel-heading">
             <h4 class="panel-title">
        <a data-toggle="collapse" data-target="#collapseFor" 
           href="#collapseFor" class="collapsed">
          Mis direcciones de pedidos
        </a>
      </h4>
        </div>
        <div id="collapseFor" class="panel-collapse collapse">
            <div id="lista_direccion" style="height: 300px;"></div>
        </div>
    </div>
            <div class="panel-group" hidden="">
                  <div class="panel panel-primary">
                    <div class="panel-heading">
                      Tipo de Vehiculo
                    </div>
                    <div class="panel-body" style="padding: 3px 3px 3px 3px;">
                      <div class="funkyradio" >
                        <div class="funkyradio-primary"  >
                            <input type="radio" name="clase_vehiculo" id="taxi_normal_2" value="1"  />
                            <label for="taxi_normal_2" style=" margin:  3px 3px 3px 3px; ">Taxi Normal</label>
                        </div>
                        <div class="funkyradio-primary" >
                            <input type="radio" name="clase_vehiculo" id="taxi_aire_2"   value="3"   />
                            <label for="taxi_aire_2" style=" margin:  3px 3px 3px 3px;" >Taxi con Aire</label>
                        </div>
                       <div class="funkyradio-primary" >
                            <input type="radio" name="clase_vehiculo" id="taxi_vip_2"   value="2"   />
                            <label for="taxi_vip_2" style=" margin:  3px 3px 3px 3px;">Taxi VIP</label>
                        </div>

                      <div class="funkyradio-primary" >
                            <input type="radio" name="clase_vehiculo" id="taxi_vagoneta_2"   value="4"   />
                            <label for="taxi_vagoneta_2" style=" margin:  3px 3px 3px 3px;">Taxi Vagoneta</label>
                      </div>
                           <div class="funkyradio-primary" >
                            <input type="radio" name="clase_vehiculo" id="taxi_vagoneta_2"   value="5"  checked=""   />
                            <label for="taxi_vagoneta_2" style=" margin:  3px 3px 3px 3px;">Delivery</label>
                      </div>
                <div class="funkyradio-primary" >
                            <input type="radio" name="clase_vehiculo" id="moto_2"   value="7"   />
                            <label for="moto_2" style=" margin:  3px 3px 3px 3px;">Moto Taxi</label>
                      </div>
 

                      </div>
                    </div>
                  </div>
              </div> 


             

               
             
            <input type="hidden" name="id_pasajero" id="id_pasajero" value="0">

          <button data-dismiss="modal"  class="btn btn-success"  >ENVIAR SOLICITUD</button>
               <a href="#inicio" data-dismiss="modal"  class="btn btn-danger" onclick="ver_ocultar_pasajero(0);">CANCELAR</a>
                    
         </div>

         <div class="col-lg-9 col-md-9 col-sm-8 col-xs-12 " >


            {!!Form::label('domicilio','Punto de solicitud:')!!}<span ><font color="red" size="5px">*</font></span>
                <input id="pac-input" class="controls" type="text" placeholder="Search Box" class="form-control">
                <div id="mapa2" style=" height: 700px;"></div>
            </div>  
          
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 " >
                             <div id="notificacion_perfil"></div>
            </div> 

            
            </div>

             <input type="hidden" name="_token" id="_token"  value="<?= csrf_token(); ?>">

                </form>  
                  

                 
              </div>
          </div> 


      </div>
      </div>
      </div>
 
  </div>











<input type="hidden" name="privilegio" id="privilegio" value="{{Auth::user()->privilegio}}">


{!!Html::script('js/buscar_vehiculo.js')!!}
{!!Html::script('js/usuario_crear.js')!!}

<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCNTI7MFuYXiwGi3Opvcr8G3fJYE4ug4fc&libraries=places"></script>
@endsection
