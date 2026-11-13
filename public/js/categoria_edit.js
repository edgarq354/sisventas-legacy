
function cargar_categoria(id){
    $.get('cargar_categoria/'+id , function (response) { 
        $("#id_empresa_edit").val(response[0].id_empresa);      
        $("#id_categoria_edit").val(response[0].id);      
        $("#id_categoria").val(response[0].id);      
        $("#nombre_edit").val(response[0].nombre);
        if (response[0].estado==1) {
 		$("#estado_edit").prop( "checked", true);
        }else{
 		$("#estado_edit").prop( "checked", false);
        }

        if (response[0].estado_pedido==1) {
        $("#estado_pedido_edit").prop( "checked", true);
        }else{
        $("#estado_pedido_edit").prop( "checked", false);
        }

    });
}



function cargar_tipo_producto(id){
    $.get('cargar_tipo_producto/'+id , function (response) { 
        $("#id_empresa_edit").val(response[0].id_empresa);      
        $("#id_tipo_producto_edit").val(response[0].id);      
        $("#id_tipo_producto_edit_2").val(response[0].id);      
        $("#nombre_edit").val(response[0].nombre);
         if (response[0].estado==1) {
        $("#estado_edit").prop( "checked", true);
        }else{
        $("#estado_edit").prop( "checked", false);
        }

        if (response[0].estado_pedido==1) {
        $("#estado_pedido_edit").prop( "checked", true);
        }else{
        $("#estado_pedido_edit").prop( "checked", false);
        }

    });
}