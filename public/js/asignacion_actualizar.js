$(document).ready(function(){
    $('#mostrar').hide();
    $('#loading').css("display","none");
    $('#body_principal').show();
});

function verificar_ci_conductor(){
    var ci = $("#ci").val();
    //var expedido =  $("#expedido").val();
    if ($("#ci").val() != "") {
        $.get('../../verificar_ci_conductor/'+ci , function (response) {
            if (response[0].contador == 0) {
                 $("#ci_verificar").show();        
                 $("#btn_actualizar").hide();   
                 $("input[name=nombre]").val("");  
                 $("input[name=paterno]").val("");  
                 $("input[name=materno]").val("");  
                 $("input[name=fecha_nacimiento]").val("");  
                 $("input[name=celular]").val("");  
                 $("input[name=correo]").val("");  
                 $("input[name=categoria_licencia]").val("");
                alertify.alert("Taxi-Corp","El Conductor no esta registrado", function(){alertify.error('OK');});                         
                                   
            } else {
                 $("#ci_verificar").hide();
                 $("#btn_actualizar").show();  
                 $("select[name=expedido]").val(response[0].expedido);  
                 $("input[name=nombre]").val(response[0].nombre);  
                 $("input[name=paterno]").val(response[0].paterno);  
                 $("input[name=materno]").val(response[0].materno);  
                 $("input[name=fecha_nacimiento]").val(response[0].fecha_nacimiento);  
                 $("input[name=celular]").val(response[0].celular);  
                 $("input[name=correo]").val(response[0].correo);  
                 $("input[name=categoria_licencia]").val(response[0].categoria_licencia);  
                  alertify.alert("Taxi-Corp","El Conductor ya esta registrado", function(){alertify.success('OK');});                         
               
            }
        }); 
    }  
}

function verificar_placa(){               
    var placa = $("input[name='placa']").val();
    if ($("input[name='placa']").val() != "") {
        $.get('../../verificar_placa_asignacion/'+placa , function (response) {
            if (response[0].contador == 0) {
                 $("#placa_verificar").show();        
                 $("#btn_actualizar").hide();   
                 $("input[name=marca]").val("");                         
                 $("input[name=modelo]").val("");                         
                 $("input[name=color]").val("");                         
                 $("input[name=tipo]").val("");                         
                 $("input[name=clase]").val("");                         
                 $("input[name=nro_chasis]").val("");                         
                 $("input[name=nro_soat]").val(""); 
                  alertify.alert("Taxi-Corp","El Vehiculo no esta registrado", function(){alertify.error('OK');});                         
                                       
            } else {
                 $("#placa_verificar").hide();                         
                 $("#btn_actualizar").show();     
                 $("input[name=marca]").val(response[0].marca);                         
                 $("input[name=modelo]").val(response[0].modelo);                         
                 $("input[name=color]").val(response[0].color);                         
                 $("input[name=tipo]").val(response[0].tipo);                         
                 $("input[name=clase]").val(response[0].clase);                         
                 $("input[name=nro_chasis]").val(response[0].nro_chasis);                         
                 $("input[name=nro_soat]").val(response[0].nro_soat); 
                  alertify.alert("Taxi-Corp","El Vehiculo ya esta registrado", function(){alertify.success('OK');});                         
                                       
            }
        }); 
    } 
}

function ver_todos(){
    $('#body_vehiculo_2').empty();                       
    $("#body_vehiculo").show();   
    $("#mostrar").hide();            
}
