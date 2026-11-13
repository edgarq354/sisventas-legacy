$(document).ready(function(){
    $('#mostrar').hide();
    $('#loading').css("display","none");
    $('#body_principal').show();
});

function Cargar_Datos_Admins(id_user){
    $.get("cargar_admins/"+id_user, function (res) {
         $("#id_user").val(res[0].id);
         $("#nombre").val(res[0].nombre);
         $("#usuario").val(res[0].usuario);
         $("#usuario_aux").val(res[0].usuario);
    });    
}

function Cargar_historial_inicio_sesion_empresa(id_user){
   

   $.get("cargar_historial_inicio_sesion/"+id_user, function (res) {//CONSULTA DE HISTORIAL DE INICIOS DE SESION
    
    //ELIMINAR LA LISTA DE CONDUCTORES EN PEDIDOS
    $('#body_usuario_historial_inicio').empty();
    var tabladatos=$('#body_usuario_historial_inicio');

      for (var i = 0; i < res.length; i++) { 
        tabladatos.append("<tr><td>"+res[i].fecha+"</td><td>"+res[i].ip+"</td><td>"+res[i].detalle+"</td></tr>");
      }
  });
}




function Cargar_Admin_Usuario(id_user,privilegio,nombre){
    $("#id_usuario").val(id_user);      
    $("#privilegio").val(privilegio);            
    $("#nombres").text(nombre);            
}

$("#buscar_administrativos").change(function(event){
    var id = $("#buscar_administrativos").val();   
    if (id == "") {
        $("#body_usuario").show();
        $("#mostrar").hide(); 
        $('#body_usuario_2').empty();                                     
    } else {
        var tabladatos=$("#body_usuario_2");
        $("#mostrar").show();
        $("#body_usuario").hide();
        $.get("cargar_admins/"+id, function (res) {
          $('#body_usuario_2').empty();                
            tabladatos.append("<tr align=center ><td>"+res[0].nombre+"</td><td>"+res[0].usuario+"</td></td>\n\
                <td><button class='btn btn-primary' data-toggle='modal' data-target='#ModalAdministrativo' onclick='Cargar_Datos_Admins("+res[0].id+")'>ACTUALIZAR</button>\n\
                <button style='background: #A4A4A4; color: white' class='btn btn-default' data-toggle='modal' data-target='#ModalContraseña' onclick='Cargar_Admin_Usuario("+res[0].id+","+res[0].privilegio+",\""+res[0].nombre+"\")'>CAMBIAR CONTRASEÑA</button></td></tr>");              
          
        });
    }
});

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
                tipo="EMPRESA"
                break;
              case 3:
                tipo="COBRADOR"
                break;
            }              
            tabladatos.append("<tr align=center ><td>"+res[0].razon_social+"</td><td>"+res[0].usuario+"</td><td>"+tipo+"</td></td>\n\
                <td><a class='btn btn-primary' href='usuario_actualizar/"+res[0].id+"'>ACTUALIZAR</a>\n\
                <button style='background: #A4A4A4; color: white' class='btn btn-default' data-toggle='modal' data-target='#ModalContraseña' onclick='Cargar_Admin_Usuario("+res[0].id+","+res[0].id_empresa+",\""+res[0].razon_social+"\")'>CAMBIAR CONTRASEÑA</button></td></tr>");              
          
        });
    }
});

function ver_todos(){
    $('#body_usuario_2').empty();                       
    $("#body_usuario").show();   
    $("#mostrar").hide();            
}
