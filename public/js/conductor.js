
$(document).ready(function(){
    $('#mostrar').hide();
    $('#loading').css("display","none");
    $('#body_principal').show();
});


function Cargar_monto_pagar(codigo,ci,nombre,monto)
{
 $('#codigo_fac').text(codigo);
 $('#nombre_fac').text(nombre);
 $('#id_conductor_fac').val(ci);
 $('#monto_pagar').text(monto);
 $('#monto_aux').val(monto);
 $('#monto').val(monto);

}

function Cargarconductor($ci,$nombre,$token)
{
 $('#nombre_not').text($nombre);
 $('#ci_not').text($ci);
 $('#id_taxi_not').val($ci);

 $('#token_not').val($token);
}

function cargar_conductor3($token)
{
 $('#token_not').val($token);
}


function Cargarconductor2($ci,$nombre,$token)
{
 $('#nombre_not').text($nombre);
 $('#ci_not').text($ci);
 $('#token_not').val($token);
}



function cargar_token($token)
{
 $('#token_not').val($token);

}


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
           var html="";
           
           html ='<tr>';
           html +='<td><img src="'+value.direccion_imagen+'" width="90px" height="90px"  class="img-thumbnail"></td>';
           html +='<td>'+value.ci+' '+value.expedido+'</td>';
           html +='<td>'+value.nombre+' '+value.paterno+' '+value.materno+'</td>';
           html +='<td>'+value.celular+'</td>';
           html +='<td>'+value.fecha_nacimiento+'</td>';
           html +='<td>';

           if(value.panico==1){
           html +='<i class="fa fa-bullhorn btn btn-link"  aria-hidden="true" aria-hidden="true"  data-toggle="tooltip" data-placement="top" title="Con panico"></i> ';
           }
           if(value.estado==1){
            html +='<i class="fa fa-thumbs-up btn btn-link"  aria-hidden="true" aria-hidden="true"  data-toggle="tooltip" data-placement="top" title="Estado activo"></i>';
           }else {
            html +='<i class="fa fa-thumbs-o-down btn btn-link" aria-hidden="true" aria-hidden="true"  data-toggle="tooltip" data-placement="top" title="Estado inactivo"></i>';
           }

           html +="<a class='btn btn-primary fa fa-eye' href='conductors/"+value.ci+"' aria-hidden='true'  data-toggle='tooltip' data-placement='top' title='Ver y editar'></a>";
           html +="<a class='btn btn-success fa fa-qrcode' href='conductors_pdf/"+value.ci+"' aria-hidden='true'  data-toggle='tooltip' data-placement='top' title='Codigo QR' target='_blanck'></a>";
           html +="<button class='btn btn-info fa fa-commenting-o' data-toggle='modal' data-target='#ModalNotificacion' onclick=cargar_token('"+value.token+"');  ></button>";
           html +='<span onclick = "getConfirm('+value.ci+');" class="btn btn-warning fa fa-arrow-down" aria-hidden="true"  data-toggle="tooltip" data-placement="top" title="Dar de baja"></span>';
           html +="<a class='btn btn-success fa fa-history ' href='pago_frecuencia/historial/"+value.ci+"' target='_blanck' data-toggle='tooltip' data-placement='top' title='Historial de pagos'></a>";
           html +="<a class='btn btn-warning fa fa-list' href='conductor_pedido/"+value.ci+"' aria-hidden='true'  data-toggle='tooltip' data-placement='top' title='Ver historial de pedidos'></a>";
           html +='</td>';
           html +='</tr>';
            tabladatos.append(html);              
          });
        });



                        
                        
                        
                        
    }
});


$("#id_pago_conductor").change(function(event){
    var ci = $("#id_pago_conductor").val();   
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
            tabladatos.append("<tr align=center ><td>"+value.ci+" "+value.expedido+"</td><td>"+value.nombre+" "+value.paterno+" "+value.materno+"</td><td>"+value.celular+"</td><td>"+value.fecha_nacimiento+"</td><td>"+value.correo+"</td>\n\
                <td><a class='btn btn-primary' href='conductors/"+value.ci+"'>ACTUALIZAR</a>\n\
                <button class='btn btn-info' data-toggle='modal' data-target='#ModalNotificacion' onclick='Cargarconductor("+value.ci+")'>NOTIFICACION</button>\n\
                <a class='btn btn-success' href='conductors_pdf/"+value.ci+"' target='_blanck'>PDF</a>\n\
                <a class='btn btn-warning' href='#' >PEDIDOS</a></td></tr>");              
          });
        });
    }
});

function ver_todos(){
    $('#body_conductor_2').empty();                       
    $("#body_conductor").show();   
    $("#mostrar").hide();            
}
