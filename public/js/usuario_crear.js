
function verficar_numero_celular(){
  var  celular=String($("#celular").val());
     if ( celular.length ==8) {
      $.get('verificar_numero_celular_pasajero/'+celular , function (response) {
        var usuario=response.usuario;
        var pedido=response.pedido;
          if (usuario.length>0) {
               $("#celular").val(usuario[0].celular);        
              $("#correo").val(usuario[0].correo);        
               $("#nombre").val(usuario[0].nombre);       
               $("#apellidos").val(usuario[0].apellido);        
               $("#id_pasajero").val(usuario[0].id);   
               $("#direccion").text("");   
               var html="";
               var i=1;
               $(pedido).each(function (key, value) { 
               var lb_direccion=String(value.direccion_inicio);
               lb_direccion=lb_direccion.toString().replace(/\,/g,''); 
                html+="\n\
               <label class='btn btn-default' style='width: 100%; text-align: left;' onclick=apuntar_direccion_usuario("+value.latitud+","+value.longitud+",'"+String(value.direccion)+"');><b>"+i+": </b><b>"+value.direccion_inicio+"</b><br>"+value.direccion+"</label>\n\
               ";
               i++;
               });
               document.getElementById('lista_direccion').innerHTML=html;
            }else{
              $("#correo").val("");        
               $("#nombre").val("");       
               $("#apellidos").val(""); 
               $("#id_pasajero").val("0"); 
               $("#direccion").text("");   
                 document.getElementById('lista_direccion').innerHTML="";
            }
 
      }); 
  }else{
    $("#correo").val("");        
    $("#nombre").val("");       
    $("#apellidos").val(""); 
    $("#id_pasajero").val("0"); 
  }
}


function cargar_usuario_id(id_pedido,clase_vehiculo,latitud,longitud)
{
 var ruta='ver_datos_pedido/'+id_pedido+"/"+clase_vehiculo+"/"+latitud+"/"+longitud;
 // var ruta='ver_datos_pedido' ;
   $.get(ruta , function (response) {

    var tablapedido=$('#body_conductor_libre');
     $('#body_conductor_libre').empty();  

    var conductor=response.conductor;
    var usuario=response.usuario; 

       
             var clase="";
              if( usuario[0].clase_vehiculo==1){
                clase="MOVIL NORMAL";
              }
              else if(usuario[0].clase_vehiculo==2){
                clase="DE LUJO";
              }
              
              else if(usuario[0].clase_vehiculo==3){
                clase="CON AIRE";
              }
              else if(usuario[0].clase_vehiculo==4){
                clase="CON MALETERO";
              }
              else if(usuario[0].clase_vehiculo==5){
                clase="PEDIDO";
              } 
              else if(usuario[0].clase_vehiculo==6){
                clase="RESERVA";
              }
              else if(usuario[0].clase_vehiculo==7){
                clase="MOTO";
              }
              else if(usuario[0].clase_vehiculo==7){
                clase="MOTO PEDIDO";
              }

            var estado_empresa="NEGATIVO";
            if(usuario[0].estado_pago_empresa==1){
              estado_empresa="ACTIVO";
            }              

               $("#lb_nombre").text(usuario[0].nombre);        
              $("#lb_correo").text(usuario[0].correo);        
               $("#lb_direccion").text(usuario[0].direccion);       
               $("#lb_celular").text(usuario[0].celular);        
               $("#lb_indicacion").text(usuario[0].direccion_inicio);        
               $("#lb_clase_vehiculo").text(clase);        
               $("#lb_empresa").text(estado_empresa);        
               $("#lb_hora").text(usuario[0].hora); 
               $("#lb_tiempo").text("Hace "+usuario[0].minuto+" minutos."); 
           


                $(conductor).each(function (key, value) {       

                tablapedido.append('<tr id="fila'+value.ci+'">\n\
                <td  align="left"><b> '+String(value.numero_movil) + ' </b>  </td>\n\
                <td  align="left"><b> '+String(value.nombre)+' ' + String(value.paterno) +' ' + String(value.materno) + ' </b>  </td>\n\
                <td>'+value.distancia+' Km.</td>\n\
                <td>'+value.credito+' </td>\n\
                <td> \n\
                    <a class="fa fa-car" href=""  data-toggle="modal" data-target="#ModalAsignar" aria-hidden="true"  onclick=asignar_pedido('+value.ci+','+id_pedido+',"'+String(value.id_vehiculo)+'")> Asignar conductor</a>\n\
               </td>\n\
                </tr>');         
              });
             
 
      }); 
}

function asignar_pedido( ci,id_pedido_c,placa)
{
      //  var miurl="asignar_usuario_pedido/"+id_pedido_c+"/"+ci+"/"+placa; 
       var  token = $('input[name="_token"]').val();
        var miurl="asignar_usuario_pedido"; 
        var divresul="notificacion_resultado";
        //información del formulario
        var formData =  new FormData();    
        formData.append( 'id_conductor', ci);
        formData.append( 'id_pedido', id_pedido_c);
        formData.append( 'id_vehiculo', placa);
        formData.append( '_token', token);

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
              $("#"+divresul+"").html($("#cargando_asignacion").html());                
            },
            //una vez finalizado correctamente
            success: function(data){
              alertify.success(":"+data);
              $("#"+divresul+"").html("Asignacion de Taxi completado"); 
              ver_ocultar_pasajero(0);   
            },
            //si ha ocurrido un error
            error: function(data){
               alertify.error("ha ocurrido un error:"+data) ;
                
            }
        });

}

