
function cargar_tipo_de_deuda(id){
    $.get('cargar_tipo_de_deuda/'+id , function (response) { 
        $("#id_empresa_edit").val(response[0].id_empresa);      
        $("#id_tipo_de_deuda_edit").val(response[0].id);      
        $("#nombre_edit").val(response[0].nombre);
        var estado=response[0].estado;
        if(estado==1){
			$("#estado").prop( "checked", true );
        }else{
        	$("#estado").prop( "checked", false );
        }

    });
}
