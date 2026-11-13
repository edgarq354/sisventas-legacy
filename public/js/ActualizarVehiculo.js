$(document).ready(function(){
    if( $('#select').prop('checked') ) {
        $("#div_poseedor").show();
        var ci = $("input[name='ci_apoderado']").val();  
        $.get('../../Cargar_Apoderado/'+ci, function(response){
	         $("input[name='ci_apoderado']").val(response[0].ci);               
	         $("select[name='expedido_apoderado']").val(response[0].expedido);               
	         $("input[name='nombre_apoderado']").val(response[0].nombre);               
	         $("input[name='paterno_apoderado']").val(response[0].paterno);               
	         $("input[name='materno_apoderado']").val(response[0].materno);               
	         $("input[name='correo_apoderado']").val(response[0].correo);               
	         $("input[name='fecha_nacimiento_apoderado']").val(response[0].fecha_nacimiento);         	
	         $("input[name='titulo_apoderado']").val(response[0].titulo);         	
        });    
    }else{
        $("#div_poseedor").hide();                      
    }
});


function poseedor(){
    if( $('#select').prop('checked') ) {
        $("#div_poseedor").show();        
    }else{
        $("#div_poseedor").hide();                  
    }
}

function verificar_ci_propietario(){
    var ci = $("#ci_propietario").val();
    if ($("#ci_propietario").val() != "") {
        $.get('../../verificar_ci_propietario/'+ci , function (response) {
            if (response[0].contador == 0) {
                 $("#ci_propietario_verificar").hide();
                 $("select[name='expedido_propietario']").val("0");               
                 $("input[name='nombre_propietario']").val("");               
                 $("input[name='paterno_propietario']").val("");               
                 $("input[name='materno_propietario']").val("");               
                 $("input[name='correo_propietario']").val("");               
                 $("input[name='fecha_nacimiento_propietario']").val("");         
            } else {
                 $("#ci_propietario_verificar").show();
                 $("input[name='ci_propietario']").val(response[0].ci);               
                 $("select[name='expedido_propietario']").val(response[0].expedido);               
                 $("input[name='nombre_propietario']").val(response[0].nombre);               
                 $("input[name='paterno_propietario']").val(response[0].paterno);               
                 $("input[name='materno_propietario']").val(response[0].materno);               
                 $("input[name='correo_propietario']").val(response[0].correo);               
                 $("input[name='fecha_nacimiento_propietario']").val(response[0].fecha_nacimiento);                         
            }
        }); 
    }   
}

function verificar_ci_apoderado(){
    var ci = $("#ci_apoderado").val();
    if ($("#ci_apoderado").val() != "") {
        $.get('../../verificar_ci_apoderado/'+ci , function (response) {
            if (response[0].contador == 0) {
                 $("#ci_apoderado_verificar").hide();
                 $("select[name='expedido_apoderado']").val("0");               
                 $("input[name='nombre_apoderado']").val("");               
                 $("input[name='paterno_apoderado']").val("");               
                 $("input[name='materno_apoderado']").val("");               
                 $("input[name='correo_apoderado']").val("");               
                 $("input[name='fecha_nacimiento_apoderado']").val("");         
            } else {
                 $("#ci_apoderado_verificar").show();
                 $("input[name='ci_apoderado']").val(response[0].ci);               
                 $("select[name='expedido_apoderado']").val(response[0].expedido);               
                 $("input[name='nombre_apoderado']").val(response[0].nombre);               
                 $("input[name='paterno_apoderado']").val(response[0].paterno);               
                 $("input[name='materno_apoderado']").val(response[0].materno);               
                 $("input[name='correo_apoderado']").val(response[0].correo);               
                 $("input[name='fecha_nacimiento_apoderado']").val(response[0].fecha_nacimiento);                         
            }
        }); 
    }   
}



/////LAS 4 IMAGENS DEL VEHICULO
function cargar_imagen(evt) {
    var files = evt.target.files; // FileList object
    // Obtenemos la imagen del campo "file".
    for (var i = 0, f; f = files[i]; i++) {
      //Solo admitimos imágenes.
      if (!f.type.match('image.*')) {
          continue;
      }
      var reader = new FileReader();
      reader.onload = (function(theFile) {
          return function(e) {
            // Insertamos la imagen            
           document.getElementById("list"+img).innerHTML = ['<img class="thumb" src="', e.target.result,'" title="', escape(theFile.name), '" width="200px" height="200px"/>'].join('');
          };
      })(f);
      reader.readAsDataURL(f);
      $("#foto_"+img).hide();
    }
}
document.getElementById('perfil_vehiculo_adelante').addEventListener('change', cargar_imagen, false);
document.getElementById('perfil_vehiculo_atras').addEventListener('change', cargar_imagen, false);
document.getElementById('perfil_vehiculo_interior_adelante').addEventListener('change', cargar_imagen, false);
document.getElementById('perfil_vehiculo_interior_atras').addEventListener('change', cargar_imagen, false);
document.getElementById('perfil_propietario').addEventListener('change', cargar_imagen, false);

img = 0;
function id_img(id){
    img = id;
}






var imagen_rua = [];
var cont_rua = 0;
var imagen_ci_rua = [];
var cont_ci_rua = 0;
var imagen_doc_propiedad = [];
var cont_doc_propiedad = 0;
var imagen_soat = [];
var cont_soat = 0;
var imagen_inspec_tec = [];
var cont_inspec_tec = 0;

//AGREGAR IMAGEN RUA
function Agregar_Imagen_Rua(){
    tabladatos = $('#lista_rua');
    var fila = '<tr id="fila_rua'+cont_rua+'">\n\
        <td><input name="imagen_rua[]" id="imagen_rua'+cont_rua+'" type="file" accept="image/*"></td>\n\
       <td> <button type="button" id="btn_eli'+cont_rua+'" class="btn-sm btn-danger" title=Eliminar onclick="Eliminar_lista_rua(' + cont_rua + ')"><i class="fa fa-trash-o" aria-hidden="true"></i></button></td></tr>';            
    $('#lista_rua').append(fila);
    cont_rua++;
}
function Eliminar_lista_rua(index){
   imagen_rua[index]=0;
   $('#fila_rua' + index).remove();
}

//AGREGAR CI TITULAR DEL RUA
function Agregar_Imagen_CI_Rua(){
    tabladatos = $('#lista_ci_rua');
    var fila = '<tr id="fila_ci_rua'+cont_ci_rua+'">\n\
        <td><input name="imagen_ci_rua[]" id="imagen_ci_rua'+cont_ci_rua+'" type="file" accept="image/*"></td>\n\
       <td> <button type="button" id="btn_eli'+cont_ci_rua+'" class="btn-sm btn-danger" title=Eliminar onclick="Eliminar_lista_ci_rua(' + cont_ci_rua + ')"><i class="fa fa-trash-o" aria-hidden="true"></i></button></td></tr>';            
    $('#lista_ci_rua').append(fila);
    cont_ci_rua++;
}
function Eliminar_lista_ci_rua(index){
   imagen_ci_rua[index]=0;
   $('#fila_ci_rua' + index).remove();
}

//AGREGAR DOCUMENTO DE PROPIEDAD
function Agregar_Imagen_Doc_Propiedad(){
    tabladatos = $('#lista_doc_pro');
    var fila = '<tr id="fila_doc_pro'+cont_doc_propiedad+'">\n\
        <td><input name="imagen_doc_propiedad[]" id="imagen_doc_propiedad'+cont_doc_propiedad+'" type="file" accept="image/*"></td>\n\
       <td> <button type="button" id="btn_eli'+cont_doc_propiedad+'" class="btn-sm btn-danger" title=Eliminar onclick="Eliminar_lista_doc_pro(' + cont_doc_propiedad + ')"><i class="fa fa-trash-o" aria-hidden="true"></i></button></td></tr>';            
    $('#lista_doc_pro').append(fila);
    cont_doc_propiedad++;
}
function Eliminar_lista_doc_pro(index){
   imagen_doc_propiedad[index]=0;
   $('#fila_doc_pro' + index).remove();
}

//AGREGAR SOAT
function Agregar_Imagen_Soat(){
    tabladatos = $('#lista_soat');
    var fila = '<tr id="fila_soat'+cont_soat+'">\n\
        <td><input name="imagen_soat[]" id="imagen_soat'+cont_soat+'" type="file" accept="image/*"></td>\n\
       <td> <button type="button" id="btn_eli'+cont_soat+'" class="btn-sm btn-danger" title=Eliminar onclick="Eliminar_lista_Soat(' + cont_soat + ')"><i class="fa fa-trash-o" aria-hidden="true"></i></button></td></tr>';            
    $('#lista_soat').append(fila);
    cont_soat++;
}
function Eliminar_lista_Soat(index){
   imagen_soat[index]=0;
   $('#fila_soat' + index).remove();
}

//AGREGAR INSPECCION TECNICA
function Agregar_Imagen_Insp_Tec(){
    tabladatos = $('#lista_inspec_tec');
    var fila = '<tr id="fila_insp_tec'+cont_inspec_tec+'">\n\
        <td><input name="imagen_inspec_tec[]" id="imagen_inspec_tec'+cont_inspec_tec+'" type="file" accept="image/*"></td>\n\
       <td> <button type="button" id="btn_eli'+cont_inspec_tec+'" class="btn-sm btn-danger" title=Eliminar onclick="Eliminar_lista_Insp_Tec(' + cont_inspec_tec + ')"><i class="fa fa-trash-o" aria-hidden="true"></i></button></td></tr>';            
    $('#lista_inspec_tec').append(fila);
    cont_inspec_tec++;
}
function Eliminar_lista_Insp_Tec(index){
   imagen_inspec_tec[index]=0;
   $('#fila_insp_tec' + index).remove();
}








