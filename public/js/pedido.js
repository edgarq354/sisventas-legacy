
function mensaje(titulo,mensaje){
    alertify.alert(titulo, mensaje, function(){ alertify.success('Ok'); });s
}

function detalle_pedido_reserva_sin_aceptar(id_pedido){
  if ( id_pedido != "") {
      $.get('detalle_pedido_reserva_sin_aceptar/'+id_pedido , function (response) {
          if (response[0].id != "") {
               $("#pasajero_s").text(response[0].nombre_pasajero);        
               $("#celular_pasajero_s").text(response[0].celular_pasajero);              
               $("#perfil_pasajero_s").attr('src','../../taxivalle2/'+response[0].direccion_imagen_pasajero);  
               $("#direccion_pedido_s").text(response[0].direccion); 

                var estado=response[0].estado; 
                var tipo_reserva_auxiliar=response[0].tipo_reserva_auxiliar;
                var latitud=response[0].latitud;
                var longitud=response[0].longitud; 
                var ruta="";
                
                 ruta="https://maps.googleapis.com/maps/api/staticmap?size=600x400&scale=2&maptype=roadmap&markers=color:red%7Clabel:%7C"+latitud+","+longitud+"";
                 
              $('#body_punto_pedido_usuario_sin_aceptar').empty(); 
              var tabladatos=$("#body_punto_pedido_usuario_sin_aceptar");  
              tabladatos.append("<tr align=center><td></td></tr><tr><td colspan=1><a href='https://maps.google.com/?q="+latitud+","+longitud+"' ><img src='"+ruta+"&key=AIzaSyBFEeTkwD_HkWEg6dEhT4hhnkOy3XLppZI' class='img-responsive'></a></td></tr>");           
     

               if (estado==0)
               { 
                $("#estado_pedido_s").text("Solicitud de un movil.");
               }  else if(estado==1){
                $("#estado_pedido_s").text("El conductor esta en camino junto al pasajero.");
               
               }else if(estado==2){
               
                $("#estado_pedido_s").text("El conductor ha finalizado con exito la carrera.");
               }
          } 
      }); 
  }  
}


function Cargar_pedido(id_pedido){
	if ( id_pedido != "") {
      $.get('detalle_pedido/'+id_pedido , function (response) {
          if (response[0].id != "") {
               $("#pasajero").text(response[0].nombre_pasajero);        
               $("#celular_pasajero").text(response[0].celular_pasajero);        
               $("#correo").text(response[0].correo);        
               $("#conductor").text(response[0].nombre_conductor);        
               $("#cedula").text(response[0].ci+' '+response[0].expedido);        
               $("#celular_conductor").text(response[0].celular_conductor);        
               $("#categoria_licencia").text(response[0].categoria_licencia);      
               $("#calificacion_conductor").text(response[0].calificacion_conductor);        
               $("#calificacion_vehiculo").text(response[0].calificacion_vehiculo);        
               $("#marca").text(response[0].marca);        
               $("#placa").text(response[0].placa);        
               $("#modelo").text(response[0].modelo);        
               $("#color").text(response[0].color); 

               $("#perfil_conductor").attr('src',response[0].direccion_imagen_conductor);       
               $("#perfil_pasajero").attr('src','../../taxivalle2/'+response[0].direccion_imagen_pasajero);       
               $("#imagen_delantero").attr('src',response[0].direccion_imagen_adelante);  


               $("#direccion_pedido").text(response[0].direccion);      
               $("#btn_detalle_conductor").prop("href","conductors/"+response[0].ci);   
               $("#btn_detalle_vehiculo").prop("href","vehiculo/"+response[0].placa+"/edit");   


               var estado=response[0].estado;
               var panico=response[0].panico;

               $("#monto_total").text(response[0].monto_total+" Bs");

               	$("#btn_ver_ubicacion").hide();
               	$("#btn_ver_ubicacion").hide();

               if(panico==1)
               {
               	$("#estado_pedido").text("Este pedido esta en panico. porfavor haga seguimiento.");
               }else if (estado==0)
               {
               	$("#btn_ver_ubicacion").show();
               	$("#estado_pedido").text("El conductor acaba de partir a la solicitud del cliente.");
               }  else if(estado==1){
               	$("#estado_pedido").text("El conductor esta en camino junto al pasajero.");
               	$("#btn_ver_ubicacion").show();
               }else if(estado==2){
               	$("#btn_carrera").show();
               	$("#estado_pedido").text("El conductor ha finalizado con exito la carrera.");
               }
          } 
      }); 
  }  
}


function cargar_detalle_cancelacion_usuario(id_pedido,latitud,longitud){
     if ( id_pedido != "") {
      $.get('detalle_cancelacion_usuario/'+id_pedido , function (response) {
          if (response[0].id != "") {
               $("#indicacion").text(response[0].direccion);        
               $("#fecha_inicio").text(response[0].fecha_pedido);        
               $("#fecha_proceso").text(response[0].fecha_proceso);        
               $("#fecha_cancelado").text(response[0].fecha_finalizado);        
               $("#detalle_cancelacion").text(response[0].detalle_cancelo_usuario);     

                 $('#body_punto_pedido_usuario').empty();   
            var tabladatos=$("#body_punto_pedido_usuario");  
            var ruta="https://maps.googleapis.com/maps/api/staticmap?size=600x400&scale=2&maptype=roadmap&markers=color:red%7Clabel:%7C"+latitud+","+longitud+"";
              tabladatos.append("<tr align=center><td></td></tr><tr><td colspan=1> <a href='https://maps.google.com/?q="+latitud+","+longitud+"' > <img src='"+ruta+"&key=AIzaSyBFEeTkwD_HkWEg6dEhT4hhnkOy3XLppZI' class='img-responsive'></a></td></tr>");           
     
            }
 
      }); 
  }
}


function cargar_detalle_cancelacion_conductor(id_pedido,latitud,longitud){
     if ( id_pedido != "") {
      $.get('detalle_cancelacion_conductor/'+id_pedido , function (response) {
          if (response[0].id != "") {
               $("#indicacion_c").text(response[0].direccion);        
              $("#fecha_inicio_c").text(response[0].fecha_pedido);        
               $("#fecha_proceso_c").text(response[0].fecha_proceso);       
               $("#fecha_cancelado_c").text(response[0].fecha_finalizado);        
               $("#detalle_cancelacion_c").text(response[0].detalle_cancelo_conductor);       

                 $('#body_punto_pedido').empty();   
      var tabladatos=$("#body_punto_pedido");  
        var ruta="https://maps.googleapis.com/maps/api/staticmap?size=600x400&scale=2&maptype=roadmap&markers=color:red%7Clabel:%7C"+latitud+","+longitud+"";
          tabladatos.append("<tr align=center><td></td></tr><tr><td colspan=1><a href='https://maps.google.com/?q="+latitud+","+longitud+"' ><img src='"+ruta+"&key=AIzaSyBFEeTkwD_HkWEg6dEhT4hhnkOy3XLppZI' class='img-responsive'></a></td></tr>");           
   
            }
 
      }); 
  }
}

 
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




