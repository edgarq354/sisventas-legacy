
$(document).ready(function(){
    $('#mostrar').hide();
    $('#loading').css("display","none");
    $('#body_principal').show();
});


$("#id_conduc").change(function(event){
    var ci = $("#id_conduc").val();   
    if (ci == "") {
        $("#body_conductor").show();
        $("#mostrar").hide(); 
        $('#body_conductor_2').empty();                                     
    } else {
        var tabladatos=$("#body_conductor_2");
        $("#mostrar").show();
        $("#body_conductor").hide();
        $.get("verificar_ci_conductor/"+ci, function (res) {
          $('#body_conductor_2').empty();                   
          $(res).each(function (key, value) {
           var html ="<tr align=center > "; 
           html +="<td><img src='"+value.direccion_imagen+"' width='90px' height='90px'  class='img-thumbnail'></td>";
           html +="<td>"+value.ci+" "+value.expedido+"</td>";
           html +="<td>"+value.nombre+" "+value.paterno+" "+value.materno+"</td>";
           html +='<td>'+value.tipo_de_pago+'</td>';
           html +='<td>'+value.monto_frecuencia+'</td>';
           html +='<td>'+value.fecha_inicio_pago+'</td>';
           html +='<td>'+value.fecha_fin_pago+'</td>';
           html +="<td><a class='btn btn-primary fa fa-refresh' href='editar_pago/"+value.ci+"'></a></td>";
           html +='</tr>';

            tabladatos.append(html);              
          });
        });
    }
});




function ver_todos(){
    $('#body_conductor_2').empty();                       
    $("#body_conductor").show();   
    $("#mostrar").hide();            
}
