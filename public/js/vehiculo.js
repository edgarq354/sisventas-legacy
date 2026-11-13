$(document).ready(function(){
    $('#mostrar').hide();
    $('#loading').css("display","none");
    $('#body_principal').show();
});

function Cargarvehiculo(id){
    $.get('cargar_vehiculo/'+id , function (response) { 
        $("#id_vehiculo").val(response[0].id);      
        $("#nombre").val(response[0].nombre);
        $("#apellido").val(response[0].apellido);
        $("#ci").val(response[0].ci);
        $("#celular").val(response[0].celular);
        $("#celular_aux").val(response[0].celular);
        $("#correo").val(response[0].correo);
        $("#marca").val(response[0].marca);
        $("#modelo").val(response[0].modelo);
        $("#placa").val(response[0].placa);
        $("#color").val(response[0].color);
        $("#direccion").val(response[0].direccion);
        $("#tipo_vehiculo").val(response[0].tipo_vehiculo);
        $("#contrasenia").val(response[0].contrasenia);
        $("#credito").val(response[0].credito);
        $("#latitud").val(response[0].latitud);
        $("#longitud").val(response[0].longitud);
        $("#login").val(response[0].login);
        $("#estado").val(response[0].estado);
        $("#token").val(response[0].token);
        $("#imagen").val(response[0].imagen); 
        document.getElementById('logo').src = response[0].imagen; //ESTA ES LA FORMA PARA PODER MOSTRA CUANDO YA LO GUARDO CON LO DE CANVA
        document.getElementById('logo_1').src = response[0].imagen_1; 
        $("#imagen_1").val(response[0].imagen_1); 
        document.getElementById('logo_2').src = response[0].imagen_2; 
        $("#imagen_2").val(response[0].imagen_2); 
        document.getElementById('logo_3').src = response[0].imagen_3; 
        $("#imagen_3").val(response[0].imagen_3); 
        document.getElementById('logo_4').src = response[0].imagen_4; 
        $("#imagen_4").val(response[0].imagen_4);                         

        // document.getElementById('foto').src = 'data:image/jpeg;base64,'+response[0].imagen; 

        //CARGA A LO DE NOTIFICACION        
        document.getElementById('logo_not').src = response[0].imagen; //ESTA ES LA FORMA PARA PODER MOSTRA CUANDO YA LO GUARDO CON LO DE CANVA
        $("#id_vehiculo_not").val(response[0].id); 
        $("#nombre_not").text(response[0].nombre+" "+response[0].apellido); 
        $("#ci_not").text(response[0].ci); 
        $("#placa_not").text(response[0].placa); 
        $("#modelo_not").text(response[0].modelo); 
        $("#color_not").text(response[0].color); 
        $("#token_not").val(response[0].token);

    });
}

$("#id_vehi").change(function(event){
    var id_vehiculo = $("#id_vehi").val();   
    if (id_vehiculo == "") {
        $("#body_vehiculo").show();
        $("#mostrar").hide(); 
        $('#body_vehiculo_2').empty();                                     
    } else {
        var tabladatos=$("#body_vehiculo_2");
        $("#mostrar").show();
        $("#body_vehiculo").hide();
        $.get("cargar_vehiculo/"+id_vehiculo, function (res) {
          $('#body_vehiculo_2').empty();                   
          $(res).each(function (key, value) { 
            tabladatos.append("<tr align=center ><td>"+value.placa+"</td><td>"+value.marca+"</td><td>"+value.modelo+"</td><td>"+value.clase+"</td><td>"+value.servicio+"</td><td>"+value.nro_soat+"</td>\n\
            <td><a class='btn btn-primary fa fa-eye' href='vehiculo/"+value.placa+"/edit'></a>\n\
            <a class='btn btn-success fa fa-qrcode' href='vehiculo_pdf/"+value.placa+"' target='_blank'></a><span onclick =getConfirm('"+value.placa+"') class='btn btn-warning fa fa-arrow-down'></span></td></tr>");              
          });
        });
    }
});

function ver_todos(){
    $('#body_vehiculo_2').empty();                       
    $("#body_vehiculo").show();   
    $("#mostrar").hide();            
}


