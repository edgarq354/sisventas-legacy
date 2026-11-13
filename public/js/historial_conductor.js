$(document).ready(function(){
    var id_conductor = $("#id_conductor").val();
    BuscarHistorial(id_conductor);
});

$("#estado_opcion").change(function(event){
    var id_conductor = $("#id_conductor").val();
    BuscarHistorial(id_conductor);
});

////////////////////////////////////////////////////////////////////////////////
//////////////////HISTORIAL DE LAS CARRERAS DE LOS MOTISTAS/////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////
function BuscarHistorial(id_conductor){
  var tabladatos=$("#body_historial");
  var estado=$("#estado_opcion").val();
  if (estado == 2) {
    $("#head_cancelado").hide();
    $("#head_completado").show();        
  } else {
    $("#head_cancelado").show();    
    $("#head_completado").hide();    
  }

  var fecha_inicio = $("#fecha_inicio").val();
  var fecha_fin = $("#fecha_fin").val();
  if (fecha_inicio == "" || fecha_fin == "") {
      alertify.alert("ERROR",'INTRODUSCA LAS 2 FECHAS');
    } else{
        var primera = Date.parse(fecha_inicio); 
        var segunda = Date.parse(fecha_fin); 
        if (primera > segunda) {
          alertify.alert("ERROR",'LA FECHA INICIO TIENE QUE SER MAYOR QUE LA FECHA FIN');
        }else{
          var route = "../historial_carrera_conductor/"+id_conductor+"/"+fecha_inicio+"/"+fecha_fin+"/"+estado;
          $.get(route, function (res) {
            $('#body_historial').empty();                   
            $(res).each(function (key, value) {    
              /*if (value.puntuacion==0) {
                ruta_img='../images/normal.png';
              }else{
                if (value.puntuacion==1) {
                  ruta_img='../images/me_gusta.png';
                } else {
                  ruta_img='../images/no_me_gusta.png';
                }
              }  */
              if (estado == 2) {
                tabladatos.append("<tr align=center ><td>"+value.id+"</td><td>"+value.usuario+"</td><td>"+value.direccion+"</td><td>"+value.fecha_pedido+"</td><td>"+value.monto_total+"</td>\n\
                <td><button class='btn btn-info' data-toggle='modal' data-target='#ModalDetalleCarrera' onclick='CargarDetalleCarrera("+value.id+")'>VER</button></td></tr>");                                                   
              } else {
                if (estado == 4) {
                  tabladatos.append("<tr align=center ><td>"+value.id+"</td><td>"+value.usuario+"</td><td>"+value.direccion+"</td><td>"+value.fecha_pedido+"</td><td>"+value.detalle_cancelo_usuario+"</td></tr>");                                                                 
                } else {
                  tabladatos.append("<tr align=center ><td>"+value.id+"</td><td>"+value.usuario+"</td><td>"+value.direccion+"</td><td>"+value.fecha_pedido+"</td><td>"+value.detalle_cancelo_conductor+"</td></tr>");                                                                 
                }
              }
              
            });
          });  
        }      
    }
}

function CargarDetalleCarrera(id_pedido){
  var contador=1;
  var tabladatos=$("#body_historial_detalle");  
  var route = "../historial_carrera_detalle/"+id_pedido;
  $.get(route, function (res) {
    $('#body_historial_detalle').empty();                   
    $(res).each(function (key, value) {    
      tabladatos.append("<tr align=center><td><font size=4><b>"+contador+"</b></font></td><td><font size=4>Fecha: <b>"+value.fecha_pedido+"</b></font></td><td><font size=4>Monto: <b>"+value.monto+" Bs.</b></font></td></tr>\n\
          <tr><td colspan=3><img src='"+value.ruta+"&key=AIzaSyBFEeTkwD_HkWEg6dEhT4hhnkOy3XLppZI' class='img-responsive'></td></tr>");
          contador++;      
    });
  });    
}





function BuscarHistorial_lugar(id_conductor){
  var tabladatos=$("#body_historial");
  var estado=$("#estado_opcion").val();
  if (estado == 2) {
    $("#head_cancelado").hide();
    $("#head_completado").show();        
  } else {
    $("#head_cancelado").show();    
    $("#head_completado").hide();    
  }

  var fecha_inicio = $("#fecha_inicio").val();
  var fecha_fin = $("#fecha_fin").val();
  if (fecha_inicio == "" || fecha_fin == "") {
      alertify.alert("ERROR",'INTRODUSCA LAS 2 FECHAS');
    } else{
        var primera = Date.parse(fecha_inicio); 
        var segunda = Date.parse(fecha_fin); 
        if (primera > segunda) {
          alertify.alert("ERROR",'LA FECHA INICIO TIENE QUE SER MAYOR QUE LA FECHA FIN');
        }else{
          var route = "../historial_carrera_conductor/"+id_conductor+"/"+fecha_inicio+"/"+fecha_fin+"/"+estado;
          $.get(route, function (res) {
            $('#body_historial').empty();                   
            $(res).each(function (key, value) {    
              /*if (value.puntuacion==0) {
                ruta_img='../images/normal.png';
              }else{
                if (value.puntuacion==1) {
                  ruta_img='../images/me_gusta.png';
                } else {
                  ruta_img='../images/no_me_gusta.png';
                }
              }  */
              if (estado == 2) {
                tabladatos.append("<tr align=center ><td>"+value.id+"</td><td>"+value.usuario+"</td><td>"+value.direccion+"</td><td>"+value.fecha_pedido+"</td><td>"+value.monto_total+"</td>\n\
                <td><button class='btn btn-info' data-toggle='modal' data-target='#ModalDetalleCarrera' onclick='CargarDetalleCarrera("+value.id+")'>VER</button></td></tr>");                                                   
              } else {
                if (estado == 4) {
                  tabladatos.append("<tr align=center ><td>"+value.id+"</td><td>"+value.usuario+"</td><td>"+value.direccion+"</td><td>"+value.fecha_pedido+"</td><td>"+value.detalle_cancelo_usuario+"</td></tr>");                                                                 
                } else {
                  tabladatos.append("<tr align=center ><td>"+value.id+"</td><td>"+value.usuario+"</td><td>"+value.direccion+"</td><td>"+value.fecha_pedido+"</td><td>"+value.detalle_cancelo_conductor+"</td></tr>");                                                                 
                }
              }
              
            });
          });  
        }      
    }
}

