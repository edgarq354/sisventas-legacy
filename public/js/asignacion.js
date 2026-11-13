$(document).ready(function(){
    $('#mostrar').hide();
    $('#loading').css("display","none");
    $('#body_principal').show();
});


$("#id_asigna").change(function(event){
    var id_asignacion = $("#id_asigna").val();   
    if (id_asignacion == "") {
        $("#body_asignacion").show();
        $("#mostrar").hide(); 
        $('#body_asignacion_2').empty();                                     
    } else {
        var tabladatos=$("#body_asignacion_2");
        $("#mostrar").show();
        $("#body_asignacion").hide();
        $.get("cargar_asignacion/"+id_asignacion, function (res) {
          $('#body_asignacion_2').empty();                   
          $(res).each(function (key, value) { 
            
            tabladatos.append("<tr align=center ><td>"+value.razon_social+"</td><td>"+value.codigo_empresa+"</td>\n\
                <td>"+value.id_conductor+" "+value.expedido+"</td><td>"+value.conductor+"</td><td>"+value.id_vehiculo+"</td>\n\
                <td>"+value.marca+"</td><td>"+value.clase+"</td>\n\
            <td><a class=' fa fa-eye' href='asignacions/"+value.id_conductor+"/"+value.id_vehiculo+"'></a></td></tr>"); 
                         
          });
        });
    }
});


function ver_todos(){
    $('#body_asignacion_2').empty();                       
    $("#body_asignacion").show();   
    $("#mostrar").hide();            
}
