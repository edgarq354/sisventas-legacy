$(document).ready(function(){
    $('#mostrar').hide();
    $('#loading').css("display","none");
    $('#body_principal').show();
});




function CargarEmpresas(id){
    $.get('cargar_empresa/'+id , function (response) { 
        $("#id_empresa").val(response[0].id);      
        $("#razon_social").val(response[0].razon_social);      
        $("#direccion").val(response[0].direccion);
        $("#telefono").val(response[0].telefono);
        $("#usuario").val(response[0].usuario);
        $("#celular").val(response[0].celular);
        $("#usuario_aux").val(response[0].usuario);
        $("#nit").val(response[0].nit);
        $("#imagen").val(response[0].imagen);
       // document.getElementById('logo').src = response[0].imagen; //ESTA ES LA FORMA PARA PODER MOSTRA CUANDO YA LO GUARDO CON LO DE CANVA        

        //NOTIFICACION
        $("#id_empresa_not").val(response[0].id);      
        $("#nombre_not").val(response[0].nombre);      
        $("#direccion_not").val(response[0].direccion);
        $("#telefono_not").val(response[0].telefono);
        $("#usuario").val(response[0].usuario);
        $("#celular_not").val(response[0].celular);   

        $("#empresa").text(response[0].razon_social);    
        $("#id_empresa_pass").val(response[0].id);      

    });
}

$("#buscar_empresa").change(function(event){
    var id_emp = $("#buscar_empresa").val();   
    if (id_emp == "") {
        $("#body_empresa").show();
        $("#mostrar").hide();  
        $('#body_empresa_2').empty();                               
    } else {
        var tabladatos=$("#body_empresa_2");
        $("#mostrar").show();
        $("#body_empresa").hide();
        $.get("cargar_empresa/"+id_emp, function (res) {
          $('#body_empresa_2').empty();                   
          $(res).each(function (key, value) {   
            tabladatos.append("<tr align=center ><td>"+value.nit+"</td><td>"+value.razon_social+"</td><td>"+value.nro_licencia_funcionamiento+"</td><td>"+value.correo+"</td>\n\
                <td><a class='btn btn-primary' href='empresa/"+value.id+"/edit'>ACTUALIZAR</a>\n\
                <a class='btn btn-warning' href='empresa_pedidos/"+value.id+"'>PEDIDOS</a></td></tr>");              
          });
        });
    }
});


$("#buscar_administrativos").change(function(event){
    var id_emp = $("#buscar_administrativos").val();   
    if (id_emp == "") {
        $("#body_empresa").show();
        $("#mostrar").hide();  
        $('#body_empresa_2').empty();                               
    } else {
        var tabladatos=$("#body_empresa_2");
        $("#mostrar").show();
        $("#body_empresa").hide();
        $.get("cargar_empresa/"+id_emp, function (res) {
          $('#body_empresa_2').empty();                   
          $(res).each(function (key, value) {   
            tabladatos.append("<tr align=center ><td>"+value.razon_social+"</td><td>"+value.usuario+"</td>\n\
                <td><button class='btn btn-primary' data-toggle='modal' data-target='#ModalAdministrativo' onclick='CargarEmpresas("+value.id+")'>ACTUALIZAR</button></tr>");              
          });
        });
    }
});



function ver_todos(){
    $('#body_empresa_2').empty();                       
    $("#body_empresa").show();   
    $("#mostrar").hide();            
}
