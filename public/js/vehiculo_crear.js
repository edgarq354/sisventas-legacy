$(document).ready(function(){
    $('#mostrar').hide();
    $('#loading').css("display","none");
    $('#body_principal').show();
    ver_datos_vehiculo();
});

function seleccionar_marca()
{
    $("#marca").val($("#marca_aux").val());
}

function seleccionar_clase()
{
    $("#clase").val($("#clase_aux").val());
}
function ver_datos_vehiculo(){
    if($("#moto_2").is(":checked") == true ){
     $("#div_caracteristicas").hide();
     $("#div_nro_puertas").hide();
     $("#div_traccion").hide();
     $("#div_nro_asientos").hide();
    }else{
     $("#div_caracteristicas").show();
     $("#div_nro_puertas").show();
     $("#div_traccion").show();
     $("#div_nro_asientos").show();
    }
}

function tiene_radio()
{
    if($("#radio_n").is(":checked")==true)
    {
        $("#div_radio").show();
    }else{
        $("#div_radio").hide();
    }
}



function poseedor(){
    if( $('#select').prop('checked') ) {
        $("#div_poseedor").show();        
    }else{
        $("#div_poseedor").hide();        
         $("input[name='ci_apoderado']").val("");               
         $("select[name='expedido_apoderado']").val("0");               
         $("input[name='nombre_apoderado']").val("");               
         $("input[name='paterno_apoderado']").val("");               
         $("input[name='materno_apoderado']").val("");               
         $("input[name='correo_apoderado']").val("");               
         $("input[name='fecha_nacimiento_apoderado']").val("");               
         $("input[name='imagen_apo']").val("");               
         document.getElementById("list_apo").innerHTML ="";             
         document.getElementById('foto_apo').src = "";                                      
         $("#foto_apo").hide();                               
    }
}

function verificar_ci_propietario(){
    var ci = $("#ci_propietario").val();
    //var expedido =  $("#expedido_propietario").val();
    if ($("#ci_propietario").val() != "") {
        $.get('../verificar_ci_propietario/'+ci , function (response) {
            if (response[0].contador == 0) {
                 $("#ci_propietario_verificar").hide();
                 $("input[name='nombre_propietario']").val("");               
                 $("input[name='paterno_propietario']").val("");               
                 $("input[name='materno_propietario']").val("");               
                 $("input[name='correo_propietario']").val("");               
                 $("input[name='fecha_nacimiento_propietario']").val("");   
                 $("#foto_pro").hide();                    
                 $("#list_pro").show();                    
                 $("#imagen_pro").show();                                     
            } else {
                 $("#ci_propietario_verificar").show();
                 $("input[name='ci_propietario']").val(response[0].ci);               
                 $("select[name='expedido_propietario']").val(response[0].expedido);               
                 $("input[name='nombre_propietario']").val(response[0].nombre);               
                 $("input[name='paterno_propietario']").val(response[0].paterno);               
                 $("input[name='materno_propietario']").val(response[0].materno);               
                 $("input[name='correo_propietario']").val(response[0].correo);               
                 $("input[name='fecha_nacimiento_propietario']").val(response[0].fecha_nacimiento);  
                 if (response[0].direccion_imagen != "") {                 
                     $("#foto_pro").show();
                     $("#list_pro").hide();                    
                     $("#imagen_pro").hide();
                     document.getElementById('foto_pro').src = 'data:image/jpeg;base64,'+response[0].imagen;      
                  }                                
            }
        }); 
    }  
}

function verificar_ci_apoderado(){
    var ci = $("#ci_apoderado").val();
    //var expedido =  $("#expedido_apoderado").val();
    if ($("#ci_apoderado").val() != "") {
        $.get('../verificar_ci_propietario/'+ci , function (response) {
            if (response[0].contador == 0) {
                 $("#ci_apoderado_verificar").hide();
                 $("input[name='nombre_apoderado']").val("");               
                 $("input[name='paterno_apoderado']").val("");               
                 $("input[name='materno_apoderado']").val("");               
                 $("input[name='correo_apoderado']").val("");               
                 $("input[name='fecha_nacimiento_apoderado']").val(""); 
                 $("#foto_apo").hide();                    
                 $("#list_apo").show();                    
                 $("#imagen_apo").show();                          
            } else {
                 $("#ci_apoderado_verificar").show();
                 $("input[name='ci_apoderado']").val(response[0].ci);               
                 $("select[name='expedido_apoderado']").val(response[0].expedido);               
                 $("input[name='nombre_apoderado']").val(response[0].nombre);               
                 $("input[name='paterno_apoderado']").val(response[0].paterno);               
                 $("input[name='materno_apoderado']").val(response[0].materno);               
                 $("input[name='correo_apoderado']").val(response[0].correo);               
                 $("input[name='fecha_nacimiento_apoderado']").val(response[0].fecha_nacimiento); 
                 if (response[0].direccion_imagen != "") {
                    $("#foto_apo").show();
                    $("#list_apo").hide();                    
                    $("#imagen_apo").hide();
                    document.getElementById('foto_apo').src = 'data:image/jpeg;base64,'+response[0].imagen;   
                 }                                        
            }
        }); 
    }   
}


function verificar_placa(){               
    var placa = $("input[name='placa']").val();
    if ($("input[name='placa']").val() != "") {
        $.get('../verificar_placa/'+placa , function (response) {
            if (response[0].contador == 0) {
                 $("#btn_registrar").show();   
                 $("select[name='marca']").val("0");               
                 $("input[name='modelo']").val("");               
                 $("input[name='color']").val("");               
                 $("input[name='cilindrada']").val("");               
                 $("input[name='tipo']").val("");               
                 $("select[name='clase']").val("0");               
                 $("input[name='nro_poliza']").val("");                                         
                 $("select[name='traccion']").val("0");                                         
                 $("input[name='nro_chasis']").val("");                                         
                 $("input[name='nro_rua']").val("");                                         
                 $("input[name='nro_documento_propiedad']").val("");                                         
                 $("input[name='nro_soat']").val("");                                         
                 $("input[name='nro_inspeccion_tecnica']").val("");                                         
                 $("input[name='nro_puertas']").val("");                                         
                 $("input[name='nro_asientos']").val("");                                         
                 $("select[name='clasificacion_vehiculo']").val("0");                                         
                 $("select[name='servicio']").val("0");                                         
                 $("input[name='radicatoria']").val(""); 

                alertify.alert("Radio Movil La Carroza","El Vehículo no esta registrado en Radio Movil La Carroza.", function(){alertify.error('OK');});   
            } else {
                 $("#btn_registrar").hide();  
                 $("select[name='marca']").val(response[0].marca);               
                 $("input[name='modelo']").val(response[0].modelo);               
                 $("input[name='color']").val(response[0].color);               
                 $("input[name='cilindrada']").val(response[0].cilindrada);               
                 $("input[name='tipo']").val(response[0].tipo);               
                 $("select[name='clase']").val(response[0].clase);               
                 $("input[name='nro_poliza']").val(response[0].nro_poliza);                                         
                 $("select[name='traccion']").val(response[0].traccion);                                         
                 $("input[name='nro_chasis']").val(response[0].nro_chasis);                                         
                 $("input[name='nro_rua']").val(response[0].nro_rua);                                         
                 $("input[name='nro_documento_propiedad']").val(response[0].nro_documento_propiedad);                                         
                 $("input[name='nro_soat']").val(response[0].nro_soat);                                         
                 $("input[name='nro_inspeccion_tecnica']").val(response[0].nro_inspeccion_tecnica);                                         
                 $("input[name='nro_puertas']").val(response[0].nro_puertas);                                         
                 $("input[name='nro_asientos']").val(response[0].nro_asientos);                                         
                 $("select[name='clasificacion_vehiculo']").val(response[0].clasificacion_vehiculo);                                         
                 $("select[name='servicio']").val(response[0].servicio);                                         
                 $("input[name='radicatoria']").val(response[0].radicatoria);  


                 /*if (response[0].direccion_imagen != null) {
                  $("#foto_adelante").show();
                  $("#list_RL").hide();                    
                  $("#imagen_rep_legal").hide();
                  document.getElementById('foto_adelante').src = 'data:image/jpeg;base64,'+response[0].imagen;                  
                 }*/
                var estado="RETIRADO";
                 if(response[0].estado==1){
                    estado="ACTIVO";
                 }

                 
    // ==============================
    // Para nosotros es más natural primero aceptar y luego cancelar
    // por defecto: Cancel, OK


                 alertify.confirm("Radio Movil La Carroza",response[0].placa+" esta "+estado+", registrado en la empresa "+response[0].razon_social+".\nContactece:\nWhatsApp:"+response[0].whatsapp+".\nDirección:"+response[0].direccion+".",
                  function(){
                    alertify.success('OK');
                },
                 function(){
                     document.location.target = "_blank";
                        document.location.href="../historial_baja_alta_vehiculo/"+response[0].placa;
                    alertify.error('Ver historial de retiros');
                  } );          

            }
             
        }); 
    } 
}


function verificar_ci_conductor(){
    var ci = $("#ci").val();
    //var expedido =  $("#expedido").val();
    if ($("#ci").val() != "") {
        $.get('../verificar_ci_conductor/'+ci , function (response) {
            if (response[0].contador == 0) {
                 $("#btn_registrar").show(); 
                 $("input[name='nombre']").val("");               
                 $("input[name='paterno']").val("");               
                 $("input[name='materno']").val(""); 
                 alertify.alert("Radio Movil La Carroza","El Conductor no esta registrado en Radio Movil La Carroza.", function(){alertify.error('OK');});                         
            } else {
                 $("#btn_registrar").hide();  
                 $("select[name='expedido']").val(response[0].expedido);                               
                 $("input[name='nombre']").val(response[0].nombre);               
                 $("input[name='paterno']").val(response[0].paterno);               
                 $("input[name='materno']").val(response[0].materno);
                 var estado="SUSPENDIDO";
                 if(response[0].estado_asignacion==1){
                    estado="ACTIVO";
                 }else if(response[0].estado_asignacion==6){
                    estado="RETIRADO";
                 }
                  alertify.confirm("Radio Movil La Carroza",response[0].nombre+" "+response[0].paterno+" "+response[0].materno+" esta "+estado+", registrado en la empresa "+response[0].razon_social+".\nContactece:\nWhatsApp:"+response[0].whatsapp+".\nDirección:"+response[0].direccion+".",
                   function(){
                    alertify.success('OK');
                     },
                 function(){
                     document.location.target = "_blank";
                        document.location.href="../historial_baja_alta/"+response[0].placa;
                    alertify.error('Ver historial de retiros');
                  }

                   );          
            }
        }); 

    }  
}


function Cargarvehiculo(id){
    $.get('cargar_vehiculo/'+id , function (response) { 
        $("#id_vehiculo").val(response[0].id);      
        $("#nombre").val(response[0].nombre);
        $("#apellido").val(response[0].apellido);
        $("#ci").val(response[0].ci);
        $("#celular").val(response[0].celular);
        $("#celular_aux").val(response[0].celular);
        $("#correo").val(response[0].correo);
        $("#marca").val(response[0].marca);
        $("#modelo").val(response[0].modelo);
        $("#placa").val(response[0].placa);
        $("#color").val(response[0].color);
        $("#direccion").val(response[0].direccion);
        $("#tipo_vehiculo").val(response[0].tipo_vehiculo);
        $("#contrasenia").val(response[0].contrasenia);
        $("#credito").val(response[0].credito);
        $("#latitud").val(response[0].latitud);
        $("#longitud").val(response[0].longitud);
        $("#login").val(response[0].login);
        $("#estado").val(response[0].estado);
        $("#token").val(response[0].token);
        $("#imagen").val(response[0].imagen); 
        document.getElementById('logo').src = response[0].imagen; //ESTA ES LA FORMA PARA PODER MOSTRA CUANDO YA LO GUARDO CON LO DE CANVA
        document.getElementById('logo_1').src = response[0].imagen_1; 
        $("#imagen_1").val(response[0].imagen_1); 
        document.getElementById('logo_2').src = response[0].imagen_2; 
        $("#imagen_2").val(response[0].imagen_2); 
        document.getElementById('logo_3').src = response[0].imagen_3; 
        $("#imagen_3").val(response[0].imagen_3); 
        document.getElementById('logo_4').src = response[0].imagen_4; 
        $("#imagen_4").val(response[0].imagen_4);                         

        // document.getElementById('foto').src = 'data:image/jpeg;base64,'+response[0].imagen; 

        //CARGA A LO DE NOTIFICACION        
        document.getElementById('logo_not').src = response[0].imagen; //ESTA ES LA FORMA PARA PODER MOSTRA CUANDO YA LO GUARDO CON LO DE CANVA
        $("#id_vehiculo_not").val(response[0].id); 
        $("#nombre_not").text(response[0].nombre+" "+response[0].apellido); 
        $("#ci_not").text(response[0].ci); 
        $("#placa_not").text(response[0].placa); 
        $("#modelo_not").text(response[0].modelo); 
        $("#color_not").text(response[0].color); 
        $("#token_not").val(response[0].token);

    });
}

$("#id_tax").change(function(event){
    var id_vehiculo = $("#id_tax").val();   
    if (id_vehiculo == "") {
        $("#body_vehiculo").show();
        $("#mostrar").hide(); 
        $('#body_vehiculo_2').empty();                                     
    } else {
        var tabladatos=$("#body_vehiculo_2");
        $("#mostrar").show();
        $("#body_vehiculo").hide();
        $.get("cargar_vehiculo/"+id_vehiculo, function (res) {
          $('#body_vehiculo_2').empty();                   
          $(res).each(function (key, value) {
          if (value.estado == 0) {  
              estado = "INACTIVO";                 
          } else {
            if (value.estado==1) {
              estado = "ACTIVO";                 
            } else {
              estado = "BLOQUEADO";                               
            }
          }     
            tabladatos.append("<tr align=center ><td>"+value.nombre+"</td><td>"+value.apellido+"</td><td>"+value.ci+"</td><td>"+value.placa+"</td><td>"+value.modelo+"</td><td>"+value.color+"</td><td>"+value.celular+"</td><td>"+estado+"</td>\n\
                <td><button class='btn btn-primary' data-toggle='modal' data-target='#ModalMoto' onclick='CargarMoto("+value.id+")'>VER MAS</button>\n\
                <button class='btn btn-info' data-toggle='modal' data-target='#ModalNotificacion' onclick='CargarMoto("+value.id+")'>NOTIFICACION</button>\n\
                <a class='btn btn-warning' href='moto/"+value.id+"'>PEDIDOS</a></td></tr>");              
          });
        });
    }
});

function ver_todos(){
    $('#body_vehiculo_2').empty();                       
    $("#body_vehiculo").show();   
    $("#mostrar").hide();            
}

//CARGAR EL IMAGENES DEL VEHICULO
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
           document.getElementById("list_"+img).innerHTML = ['<img class="thumb" src="', e.target.result,'" title="', escape(theFile.name), '" width="200px" height="200px"/>'].join('');
          };
      })(f);
      reader.readAsDataURL(f);
    }
}
document.getElementById('imagen_adelante').addEventListener('change', cargar_imagen, false);
document.getElementById('imagen_atras').addEventListener('change', cargar_imagen, false);
document.getElementById('imagen_interior_adelante').addEventListener('change', cargar_imagen, false);
document.getElementById('imagen_interior_atras').addEventListener('change', cargar_imagen, false);

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




/////CARGAR EL IMAGENES DEL PROPIETARIO
function cargar_imagen_pro(evt) {
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
           document.getElementById("list_pro").innerHTML = ['<img class="thumb" src="', e.target.result,'" title="', escape(theFile.name), '" width="150px" height="150px"/>'].join('');
          };
      })(f);
      reader.readAsDataURL(f);
    }
}
document.getElementById('imagen_pro').addEventListener('change', cargar_imagen_pro, false);


/////CARGAR EL IMAGENES DEL APODERADO
function cargar_imagen_apoderado(evt) {
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
           document.getElementById("list_apo").innerHTML = ['<img class="thumb" src="', e.target.result,'" title="', escape(theFile.name), '" width="150px" height="150px"/>'].join('');
          };
      })(f);
      reader.readAsDataURL(f);
    }
}
document.getElementById('imagen_apo').addEventListener('change', cargar_imagen_apoderado, false);