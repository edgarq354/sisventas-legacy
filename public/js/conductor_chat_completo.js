var usuarios;
var DatoUsuario=null;
var ChatUsuario=null;
var ChatUsuarioNuevo=null;
var jsonDato;
var id_conductor;

 
  
 $(document).ready(function() {
 	
    usuarios_completo();
});

 function usuarios_completo() {
 	id_conductor = $('#id_conductor').val();
    $.get('usuarios_completo_conductor/'+id_conductor, function(response) {
        var usuario = response.usuario;
        var divUsuario = $('#usuarios_completo');
        usuarios = usuario;
        $('#usuarios_completo').empty();

        for (i = 0; i < usuario.length; i++) {
            divUsuario.append('<div class="chat_people" id="usuario' + i + '" onclick="chat_mensaje_conductor(' + usuario[i].id + ',' + id_conductor+ ')">\n\
                <div class="chat_img"> <img src="../../../taxivalle2/' + usuario[i].direccion_imagen + '" alt="perfil" title="perfil"> </div>\n\
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


function chat_mensaje_conductor(id_usuario, id_conductor) {
    $.get('chat_mensaje_conductor/' + id_usuario + '/' + id_conductor, function(response) {
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
              <div class="sent_msg" onclick=playByteArray("'+ chat[i].mensaje + '")>\n\
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
 




    