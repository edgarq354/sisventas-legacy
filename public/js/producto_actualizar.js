 

function ver_producto(id_producto){ 
        $.get('get_producto_por_id/'+id_producto , function (response) {
            if (response[0] == 0) {
               
            } else {
                 $("#id_producto_actualizar").val(response[0].id);          
                 $("#nombre_actualizar").val(response[0].nombre);               
                 $("#descripcion_actualizar").val(response[0].descripcion);               
                 $("#precio_actualizar").val(response[0].precio);     
                 $("#peso_minimo_actualizar").val(response[0].peso_minimo);  
                 $("#cantidad_minima_actualizar").val(response[0].cantidad_minima);    
                 $("#precio_compra_actualizar").val(response[0].precio_compra);              
                 var estado_pedido_actualizar=response[0].estado_pedido; 
                 $("#cantidad_actualizar").val(response[0].cantidad);   
                 $("#peso_actualizar").val(response[0].peso);  
                 $("#precio_mayorista_actualizar").val(response[0].precio_mayorista);  
                 $("#numero_serie_actualizar").val(response[0].numero_serie);  
                 $("#marca_actualizar").val(response[0].marca);  
                 $("#modelo_actualizar").val(response[0].modelo);  
                 $("#precio_compra_sus_actualizar").val(response[0].precio_compra_sus);  
                 $("#precio_venta_2_actualizar").val(response[0].precio_venta_2);  

                  //estado del pedido
                 if(estado_pedido_actualizar==1){
                  $( "#estado_pedido_actualizar" ).prop( "checked", true );
                 }else{
                  $( "#estado_pedido_actualizar" ).prop( "checked", false );
                 }

                 //tipo de producto
                 $("#id_tipo_producto_actualizar option[value="+ response[0].id_tipo_producto +"]").attr("selected",true);

                 //cargar la imagen
                 $("#output_actualizar").attr("src",""+response[0].imagen1);

                 $('#imagen1_producto_actualizar').attr('data-url', ""+response[0].imagen1);

            }
        }); 
}
 