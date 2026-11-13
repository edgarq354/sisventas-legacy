

function cargar_video(id){
    $.get('cargar_video/'+id , function (response) { 
        $("#id_empresa_edit").val(response[0].id_empresa);      
        $("#id_video_edit").val(response[0].id);      
        $("#titulo_edit").val(response[0].nombre);
        $("#descripcion_edit").val(response[0].descripcion);
        $("#url_edit").val(response[0].url);

    });
}
