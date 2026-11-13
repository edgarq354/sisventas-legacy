$(document).ready(function(){
    var id_empresa = $("#id_empresa").val();
   
});


$("#estado_opcion").change(function(event){
    var id_empresa = $("#id_empresa").val();
   
});

 
function CargarDetalleCarreraEmpresa(id_pedido,otra){
  var contador=1;
  var tabladatos=$("#body_historial_detalle");  
  var route="";
  if(otra==1){
    route= "historial_carrera_detalle/"+id_pedido;
  }else{
    route= "../historial_carrera_detalle/"+id_pedido;
  }

   
  $.get(route, function (res) {
    $('#body_historial_detalle').empty();                   
    $(res).each(function (key, value) { 
      tabladatos.append("<tr align=center><td><font size=4><b>"+contador+"</b></font></td><td><font size=4>Fecha: <b>"+value.fecha_pedido+"</b></font></td><td><font size=4>Monto: <b>"+value.monto+" Bs.</b></font></td></tr>\n\
          <tr><td colspan=3><img src='"+value.ruta+"&key=AIzaSyBFEeTkwD_HkWEg6dEhT4hhnkOy3XLppZI' class='img-responsive'></td></tr>");           
          contador++;                                 
    });
  });    
}


function CargarDetalleSolicitud(latitud,longitud){
  $('#body_punto_pedido').empty();   
  var tabladatos=$("#body_punto_pedido");  
    var ruta="https://maps.googleapis.com/maps/api/staticmap?size=600x400&scale=2&maptype=roadmap&markers=color:red%7Clabel:%7C"+latitud+","+longitud+"";
      tabladatos.append("<tr align=center><td></td></tr><tr><td colspan=1><img src='"+ruta+"&key=AIzaSyBFEeTkwD_HkWEg6dEhT4hhnkOy3XLppZI' class='img-responsive'></td></tr>");           
}



function cargar_detalle_cancelacion_usuario(id_pedido){
     if ( id_pedido != "") {
      $.get('detalle_cancelacion_usuario/'+id_pedido , function (response) {
          if (response[0].id != "") {
               $("#indicacion").text(response[0].direccion);        
               $("#fecha_inicio").text(response[0].fecha_pedido);        
               $("#fecha_proceso").text(response[0].fecha_proceso);        
               $("#fecha_cancelado").text(response[0].fecha_finalizado);        
               $("#detalle_cancelacion").text(response[0].detalle_cancelo_usuario);        
            }
 
      }); 
  }
}


function cargar_detalle_cancelacion_conductor(id_pedido){
     if ( id_pedido != "") {
      $.get('detalle_cancelacion_conductor/'+id_pedido , function (response) {
          if (response[0].id != "") {
               $("#indicacion_c").text(response[0].direccion);        
              $("#fecha_inicio_c").text(response[0].fecha_pedido);        
               $("#fecha_proceso_c").text(response[0].fecha_proceso);       
               $("#fecha_cancelado_c").text(response[0].fecha_finalizado);        
               $("#detalle_cancelacion_c").text(response[0].detalle_cancelo_conductor);        
            }
 
      }); 
  }
}

function cargar_detalle_cancelacion_usuario_2(id_pedido){
     if ( id_pedido != "") {
      $.get('detalle_cancelacion_usuario/'+id_pedido , function (response) {
          if (response[0].id != "") {
               $("#indicacion").text(response[0].direccion);        
               $("#fecha_inicio").text(response[0].fecha_pedido);        
               $("#fecha_proceso").text(response[0].fecha_proceso);        
               $("#fecha_cancelado").text(response[0].fecha_finalizado);        
               $("#detalle_cancelacion").text(response[0].detalle_cancelo_usuario);        
            }
 
      }); 
  }
}


function cargar_detalle_cancelacion_conductor_2(id_pedido){
     if ( id_pedido != "") {
      $.get('detalle_cancelacion_conductor/'+id_pedido , function (response) {
          if (response[0].id != "") {
               $("#indicacion_c").text(response[0].direccion);        
              $("#fecha_inicio_c").text(response[0].fecha_pedido);        
               $("#fecha_proceso_c").text(response[0].fecha_proceso);       
               $("#fecha_cancelado_c").text(response[0].fecha_finalizado);        
               $("#detalle_cancelacion_c").text(response[0].detalle_cancelo_conductor);      

               
   
            }
 
      }); 
  }
}

