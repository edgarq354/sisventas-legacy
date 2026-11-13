var usuarios;
var DatoUsuario=null;
var ChatUsuario=null;
var ChatUsuarioNuevo=null;
var jsonDato;

$(document).ready(function() {
    usuarios_completo();
    actualizar_mensaje();
});
 
function actualizar_mensaje()
{
if(this.DatoUsuario!=null)
{
  chat_completo_autompletado(this.DatoUsuario.id, 1);
}
setTimeout("actualizar_mensaje()",7000);
}


 
function usuarios_completo() {
    $.get('usuarios_completo', function(response) {
        var usuario = response.usuario;
        var divUsuario = $('#usuarios_completo');
        usuarios = usuario;
        $('#usuarios_completo').empty();

        for (i = 0; i < usuario.length; i++) {
            divUsuario.append('<div class="chat_people" id="usuario' + i + '" onclick="ver_chat_por_id_usuario(' + usuario[i].id + ',' + i + ')">\n\
                <div class="chat_img"> <img src="../../clasico2/' + usuario[i].direccion_imagen + '" alt="perfil" title="perfil"> </div>\n\
                <div class="chat_ib">\n\
                <h5> ' + usuario[i].nombre + ' <span class = "chat_date">' + usuario[i].celular + ' </span></h5>\n\
                    <p>' + usuario[i].correo + ' </p> \n\
                    </div> </div>');
        }
    });
}

function buscar_pasajero() {
    var txtBuscar = $("#buscar_nombre").val();
    for (i = 0; i < this.usuarios.length; i++) {
        var found = false;
        if (this.usuarios[i].nombre != null) {

            var datosCompleto = this.usuarios[i].nombre + ' ' + this.usuarios[i].apellido + ' ' + this.usuarios[i].celular;
            if (txtBuscar.length == 0 || (datosCompleto.indexOf(txtBuscar) > -1)) {
                found = true;
            }
        }

        if (found) {
            $("#usuario" + i).show();
        } else {
            // si no ha encontrado ninguna coincidencia, esconde la
            // fila de la tabla
            $("#usuario" + i).hide();
        }
    }


}

function ver_chat_por_id_usuario(id_usuario, index) {
    this.DatoUsuario = this.usuarios[index];
    $("#nombre_pasajero").text(this.DatoUsuario.nombre + ' ' + this.DatoUsuario.apellido);
    $("#im_perfil").attr("src","../../clasico2/"+this.DatoUsuario.direccion_imagen);
    chat_completo(id_usuario, 1);
}

function chat_completo(id_usuario, id_administrador) {
    $.get('chat_completo/' + id_usuario + '/' + id_administrador, function(response) {
        var chat = response.chat;
        ChatUsuario = response.chat;
        var divChat = $('#chat_completo');
        $('#chat_completo').empty();


        for (i = 0; i < chat.length; i++) {

            var fecha = new Date(chat[i].fecha);
            var hora = fecha.getHours() + ':' + fecha.getMinutes() + ':' + fecha.getSeconds();
            var meses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
            var mes = meses[fecha.getMonth() - 1];

            if (chat[i].yo == 1) {
                divChat.append('<div class="incoming_msg">\n\
              <div class="incoming_msg_img"> \n\
              <img  src="images/ic_perfil.png" alt="sunil"> </div>\n\
              <div class="received_msg">\n\
              <div class="received_withd_msg">\n\
              <p>' + chat[i].mensaje + '</p>\n\
              <span class="time_date"> ' + hora + '   |    ' + mes + '</span></div>\n\
              </div>\n\
              </div>');
            } else {
                divChat.append('<div class="outgoing_msg">\n\
              <div class="sent_msg">\n\
              <p>' + chat[i].mensaje + '</p>\n\
              <span class="time_date"> ' + hora + '   |    ' + mes + '</span> </div>\n\
              </div>');
            }
        }
       var height = 0;
$('#chat_completo div').each(function(i, value){
    height += parseInt($(this).height());
});

height += '';

$('div').animate({scrollTop: height});

    });
}

function chat_completo_autompletado(id_usuario, id_administrador) {
    $.get('chat_completo/' + id_usuario + '/' + id_administrador, function(response) {
        var chat = response.chat;
        var divChat = $('#chat_completo');
 
        if(ChatUsuario!=null)
        {
        if(chat.length>ChatUsuario.length){
          
            var cantidad_inicial=ChatUsuario.length;
            if(cantidad_inicial>5)
                cantidad_inicial-=5;
            else
                cantidad_inicial-=1;

        for (i = cantidad_inicial; i < chat.length; i++) {
            var fecha = new Date(chat[i].fecha);
            var hora = fecha.getHours() + ':' + fecha.getMinutes() + ':' + fecha.getSeconds();
            var meses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
            var mes = meses[fecha.getMonth() - 1];
            var chat_antiguo = ChatUsuario;
            var id_antiguo="-1";

            if(chat_antiguo.length>i)
            {
            id_antiguo=chat_antiguo[i].id;               
            }


            if(chat[i].id!=id_antiguo)
            {
              if (chat[i].yo == 1) {
                divChat.append('<div class="incoming_msg">\n\
                  <div class="incoming_msg_img"> \n\
                  <img  src="images/ic_perfil.png" alt="sunil"> </div>\n\
                  <div class="received_msg">\n\
                  <div class="received_withd_msg">\n\
                  <p>' + chat[i].mensaje + '</p>\n\
                  <span class="time_date"> ' + hora + '   |    ' + mes + '</span></div>\n\
                  </div>\n\
                  </div>');
                } else {
                    divChat.append('<div class="outgoing_msg">\n\
                  <div class="sent_msg">\n\
                  <p>' + chat[i].mensaje + '</p>\n\
                  <span class="time_date"> ' + hora + '   |    ' + mes + '</span> </div>\n\
                  </div>');
                }  
            }
          }
          ChatUsuario=chat;
        }
    }

var height = 0;
$('#chat_completo div').each(function(i, value){
    height += parseInt($(this).height());
});

height += '';

$('div').animate({scrollTop: height});


    });
}

function chat_completo_conductor(id_usuario, id_conductor) {
    $.get('../chat_completo_conductor/' + id_usuario + '/' + id_conductor, function(response) {

        $("#indicacion_c").text(response[0].direccion);
    });
}

function enviar_mensaje() {
    var mensaje=$("#mensaje").val();
    var _token = $('#_token').val();

    $("#mensaje").val("");
 
 
    //hacemos la petición ajax   
   
    $.ajax({
        url: "../../clasico2/frmChat.php?opcion=enviar_mensaje_administrador&id_usuario="+this.DatoUsuario.id+"&titulo="+$("#nombre_usuario").val()+"&mensaje="+mensaje+"&remitente=0&id_administrador=1",
        type: 'POST',
        headers: {'X-CSRF-TOKEN': _token},
        // Form data
        //datos del formulario
        data: { },
        dataType: 'JSON',
        //necesario para subir archivos via ajax
        cache: false,
        contentType: false,
        processData: false,
        //mientras enviamos el archivo
        beforeSend: function() {
            alertify.success("Enviando...");
        },
        //una vez finalizado correctamente
        success: function(data) {
            /*
            var divChat = $('#chat_completo');
            var fecha = new Date(data.fecha);
            var hora = data.hora;
            var meses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
            var mes = meses[fecha.getMonth() - 1];
             divChat.append('<div class="outgoing_msg">\n\
              <div class="sent_msg">\n\
              <p>' + data.chat + '</p>\n\
              <span class="time_date"> ' + hora + '   |    ' + mes + '</span> </div>\n\
              </div>');


             var height = 0;
              $('#chat_completo div').each(function(i, value){
                  height += parseInt($(this).height());
              });

              height += '';

              $('div').animate({scrollTop: height});
              */
            alertify.success("Enviado correctamente");
        },
        //si ha ocurrido un error
        error: function(data) {
             console.log(data);
            alertify.error("ha ocurrido un error");

        }
    });
    
}




    