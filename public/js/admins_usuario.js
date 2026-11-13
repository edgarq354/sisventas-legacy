$(document).ready(function(){
    $('#mostrar').hide();
    $('#loading').css("display","none");
    $('#body_principal').show();
});

function Cargar_Admin_Usuario(id_user,id_empresa,privilegio,empresa){
    $("#id_usuario").val(id_user);      
    $("#id_empresa").val(id_empresa);            
    $("#empresa").text(empresa);            
    $("#privilegio").val(privilegio);            
}

function Cargar_historial_inicio_sesion_empresa(id_user){
   

   $.get("../cargar_historial_inicio_sesion/"+id_user, function (res) {//CONSULTA DE HISTORIAL DE INICIOS DE SESION
    
    //ELIMINAR LA LISTA DE CONDUCTORES EN PEDIDOS
    $('#body_usuario_historial_inicio').empty();
    var tabladatos=$('#body_usuario_historial_inicio');

      for (var i = 0; i < res.length; i++) { 
        tabladatos.append("<tr><td>"+res[i].fecha+"</td><td>"+res[i].ip+"</td><td>"+res[i].detalle+"</td></tr>");
      }
  });
}


$("#buscar_usuario").change(function(event){
    var id = $("#buscar_usuario").val();   
    if (id == "") {
        $("#body_usuario").show();
        $("#mostrar").hide(); 
        $('#body_usuario_2').empty();                                     
    } else {
        var tabladatos=$("#body_usuario_2");

        $("#mostrar").show();
        $("#body_usuario").hide();
        $.get("cargar_admins_usuarios/"+id, function (res) {
          $('#body_usuario_2').empty();  
           var tipo="";  
            switch (res[0].privilegio) {
              case 0:
                tipo="ADMINISTRADOR"
                break;
              case 3:
                tipo="COBRADOR"
                break;
            }       
            var html="<tr align=center ><td>"+res[0].usuario+"</td><td>"+tipo+"</td></td>\n\
                <td>";
            html+="<a class='btn btn-primary fa fa-eye' href='actualizar_usuarios_empresa/"+res[0].id+"'></a>";
            html+='<button class="btn btn-success fa fa-list" data-toggle="modal" data-target="#historial_inicio_sesion" onclick="Cargar_historial_inicio_sesion_empresa('+res[0].id+')"></button>';
            html+="<button class='btn btn-default'  data-toggle='modal' data-target='#ModalContraseña_usuario' onclick=Cargar_Admin_Usuario("+res[0].id+","+res[0].id_empresa+","+res[0].privilegio+",'')>CAMBIAR CONTRASEÑA</button>";      
            html+="</td></tr>";
            tabladatos.append(html);    

          
        });
    }
});

function ver_todos(){
    $('#body_usuario_2').empty();                       
    $("#body_usuario").show();   
    $("#mostrar").hide();            
}
