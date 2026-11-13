function mensaje(titulo,mensaje){
alertify.alert(titulo, mensaje, function(){ alertify.success('Ok'); });
}

$("#id_cliente").change(function(event){
    var ci = $("#id_cliente").val();   
    if (ci == "") {
        $("#body_cliente").show();
        $("#mostrar").hide(); 
        $('#body_cliente_2').empty();                                     
    } else {
        var tabladatos=$("#body_cliente_2");
        $("#mostrar").show();
        $("#body_cliente").hide();
        $.get("verificar_id_cliente/"+ci, function (res) {
          $('#body_cliente_2').empty();                   
          $(res).each(function (key, value) {
           var html="";
           
           html +='<tr>';
           html +='<td>'+value.ci_nit+'</td>';
           html +='<td>'+value.nombre+' '+value.paterno+' '+value.materno+'</td>';
           html +='<td>';
           if(value.telefono!=""){
            html +=' <button class="btn btn-primary fa fa-phone" ><font style="font-family: arial;">'+value.telefono+'</font></button>';
           }
           html +='</td>';
           html +='<td>'+value.direccion+'</td>';
           html +='<td>';
           html +='<a class="fa fa-pencil-square-o"  style="cursor: pointer;" href="cliente_id/'+value.id+'" aria-hidden="true"  data-toggle="tooltip" data-placement="top" title="Ver y editar"></a>';
           

           if(value.panico==1){
           html +='<i class="fa fa-bullhorn btn btn-link"  aria-hidden="true" aria-hidden="true"  data-toggle="tooltip" data-placement="top" title="Con panico"></i> ';
           }
           
           if(value.tipo_c==1){
            html+='<a class="fa fa-user" style="cursor: pointer;" aria-hidden="true"  data-toggle="tooltip" data-placement="top" title="Cliente normal"></a>';
           }
           if(value.tipo_p==1){
            html+='<a class="fa fa-users" style="cursor: pointer;" aria-hidden="true"  data-toggle="tooltip" data-placement="top" title="Cliente proveedor"></a>';
           }

           html +='</td>';
           html +='</tr>';

            tabladatos.append(html);              
          });
        });



                        
                        
                        
                        
    }
});