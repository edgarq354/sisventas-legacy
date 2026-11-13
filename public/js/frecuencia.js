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
            }
        }); 
    }  
}
