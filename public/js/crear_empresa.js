$(document).ready(function(){
  Agregar_Telefono(); 
});

function controlar(){
    var nit = $("#nit").val();
    $.get('../verificar_nit/'+nit , function (response) {
        if (response[0].contador == 0) {
            $("#nit_verificar").hide();
            $("#btn_registrar").show();                        
        } else {
            $("#nit_verificar").show();            
            $("#btn_registrar").hide();            
        }
    });
}

function con_factura(){
  if($("#con_factura").is(":checked")==false){
    $("#div_con_factura").show();
  }else{
    $("#paga_iva").prop( "checked", false );
    $("#paga_it").prop( "checked", false );
    $("#div_con_factura").hide();
    $("#div_iva").hide();
     $("#div_it").hide();
  }
}

 

function paga_iva(){
  if($("#paga_iva").is(":checked")==false){
    $("#div_iva").show();
  }else{
    $("#div_quien_paga_iva").hide();
    $("#div_iva").hide();
  }
}

function paga_it(){
  if($("#paga_it").is(":checked")==false){
    $("#div_it").show();
  }else{
    $("#div_it").hide();
  }
}


function verificar_ci_representante(){
    var ci = $("#ci").val();
    if ($("#ci").val() != "") {
        $.get('../verificar_ci_propietario/'+ci , function (response) {
            if (response[0].contador == 0) {
                 $("#ci_verificar").hide();  
                 $("input[name=nombre]").val("");
                 $("input[name=paterno]").val("");
                 $("input[name=materno]").val("");
                 $("input[name=correo_dueño]").val("");
                 $("input[name=fecha_nacimiento]").val("");
                 $("select[name=expedido]").val("0");  
                 $("#foto_rep_legal").hide();                    
                 $("#list_RL").show();                    
                 $("#imagen_rep_legal").show();                                       
            } else {
                 $("#ci_verificar").show();
                 $("input[name=nombre]").val(response[0].nombre);
                 $("input[name=paterno]").val(response[0].paterno);
                 $("input[name=materno]").val(response[0].materno);
                 $("input[name=correo_dueño]").val(response[0].correo);
                 $("input[name=fecha_nacimiento]").val(response[0].fecha_nacimiento);
                 $("select[name=expedido]").val(response[0].expedido);

                 if (response[0].direccion_imagen != null) {
                  $("#foto_rep_legal").show();
                  $("#list_RL").hide();                    
                  $("#imagen_rep_legal").hide();
                  document.getElementById('foto_rep_legal').src = 'data:image/jpeg;base64,'+response[0].imagen;                  
                 }
                  
            }
        }); 
    }  
}

var cont = 0;
var telefono = [];
function Agregar_Telefono(){
    tabladatos = $('#lista_telefono');
    var fila = '<tr id="fila'+cont+'">\n\
       <td><input name="telefono[]" id="telefono'+cont+'" type="text" class="form-control" placeholder="Ingrese el telefono"></td>\n\
       <td> <button type="button" id="btn_eli'+cont+'" class="btn-sm btn-danger" title=Eliminar onclick="eliminar_lista_telefono(' + cont + ')"><i class="fa fa-trash-o" aria-hidden="true"></i></button></td></tr>';            
    $('#lista_telefono').append(fila);  
  cont++;          
}

function eliminar_lista_telefono(index){
   telefono[index]=0;
   $('#fila' + index).remove();
}


      ///////CARGAR EL IMAGEN DEL REPRESENTANTE LEGAL
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
           document.getElementById("list_RL").innerHTML = ['<img class="thumb" src="', e.target.result,'" title="', escape(theFile.name), '" width="150px" height="150px"/>'].join('');
          };
      })(f);
      reader.readAsDataURL(f);
    }
}
document.getElementById('imagen_rep_legal').addEventListener('change', cargar_imagen, false);



//AGREGAR IMAGEN CONSTITUCION DE EMPRESA
var imagen_cons_emp = [];
var cont_cons_emp = 0;
function Agregar_Imagen_Constitucion_Empresa(){
    tabladatos = $('#lista_const_Emp');
    var fila = '<tr id="fila_cont_emp'+cont_cons_emp+'">\n\
        <td><input name="imagen_cons_emp[]" id="imagen_cons_emp'+cont_cons_emp+'" type="file" accept="image/*"></td>\n\
       <td> <button type="button" id="btn_eli'+cont_cons_emp+'" class="btn-sm btn-danger" title=Eliminar onclick="Eliminar_lista_Const_Empresa(' + cont_cons_emp + ')"><i class="fa fa-trash-o" aria-hidden="true"></i></button></td></tr>';            
    $('#lista_const_Emp').append(fila);
    cont_cons_emp++;
}
function Eliminar_lista_Const_Empresa(index){
   imagen_cons_emp[index]=0;
   $('#fila_cont_emp' + index).remove();
}

//AGREGAR IMAGEN CONSTITUCION DE EMPRESA
var imagen_rep_leg = [];
var cont_rep_leg = 0;
function Agregar_Imagen_Rep_Legal(){
    tabladatos = $('#lista_rep_leg');
    var fila = '<tr id="fila_rep_leg'+cont_rep_leg+'">\n\
        <td><input name="imagen_rep_leg[]" id="imagen_rep_leg'+cont_rep_leg+'" type="file" accept="image/*"></td>\n\
       <td> <button type="button" id="btn_eli'+cont_rep_leg+'" class="btn-sm btn-danger" title=Eliminar onclick="Eliminar_lista_Rep_Legal(' + cont_rep_leg + ')"><i class="fa fa-trash-o" aria-hidden="true"></i></button></td></tr>';            
    $('#lista_rep_leg').append(fila);
    cont_rep_leg++;
}
function Eliminar_lista_Rep_Legal(index){
   imagen_rep_leg[index]=0;
   $('#fila_rep_leg' + index).remove();
}

//AGREGAR IMAGEN FUNDAEMPRESA
var imagen_fundaempresa = [];
var cont_fundaempresa = 0;
function Agregar_Imagen_Fundaempresa(){
    tabladatos = $('#lista_fundaempresa');
    var fila = '<tr id="fila_fundaempresa'+cont_fundaempresa+'">\n\
        <td><input name="imagen_fundaempresa[]" id="imagen_fundaempresa'+cont_fundaempresa+'" type="file" accept="image/*"></td>\n\
       <td> <button type="button" id="btn_eli'+cont_fundaempresa+'" class="btn-sm btn-danger" title=Eliminar onclick="Eliminar_lista_Fundaempresa(' + cont_fundaempresa + ')"><i class="fa fa-trash-o" aria-hidden="true"></i></button></td></tr>';            
    $('#lista_fundaempresa').append(fila);
    cont_fundaempresa++;
}
function Eliminar_lista_Fundaempresa(index){
   imagen_fundaempresa[index]=0;
   $('#fila_fundaempresa' + index).remove();
}

//AGREGAR IMAGEN CI DEL REPRESENTANTE LEGAL
var imagen_ci_rep_leg = [];
var cont_ci_rep_leg = 0;
function Agregar_Imagen_CI_Rep_Legal(){
    tabladatos = $('#lista_CI_Rep_Leg');
    var fila = '<tr id="fila_ci_rep_leg'+cont_ci_rep_leg+'">\n\
        <td><input name="imagen_ci_rep_leg[]" id="imagen_ci_rep_leg'+cont_ci_rep_leg+'" type="file" accept="image/*"></td>\n\
       <td> <button type="button" id="btn_eli'+cont_ci_rep_leg+'" class="btn-sm btn-danger" title=Eliminar onclick="Eliminar_lista_CI_Rep_Leg(' + cont_ci_rep_leg + ')"><i class="fa fa-trash-o" aria-hidden="true"></i></button></td></tr>';            
    $('#lista_CI_Rep_Leg').append(fila);
    cont_ci_rep_leg++;
}
function Eliminar_lista_CI_Rep_Leg(index){
   imagen_ci_rep_leg[index]=0;
   $('#fila_ci_rep_leg' + index).remove();
}

//AGREGAR IMAGEN LICENCIA DE FUNCIONAMIENTO DE GMLP
var imagen_gmlp = [];
var cont_gmlp = 0;
function Agregar_Imagen_GMLP(){
    tabladatos = $('#lista_gmlp');
    var fila = '<tr id="fila_gmlp'+cont_gmlp+'">\n\
        <td><input name="imagen_gmlp[]" id="imagen_gmlp'+cont_gmlp+'" type="file" accept="image/*"></td>\n\
       <td> <button type="button" id="btn_eli'+cont_gmlp+'" class="btn-sm btn-danger" title=Eliminar onclick="Eliminar_lista_GMLP(' + cont_gmlp + ')"><i class="fa fa-trash-o" aria-hidden="true"></i></button></td></tr>';            
    $('#lista_gmlp').append(fila);
    cont_gmlp++;
}
function Eliminar_lista_GMLP(index){
   imagen_gmlp[index]=0;
   $('#fila_gmlp' + index).remove();
}

//AGREGAR IMAGEN NIT
var imagen_nit = [];
var cont_nit = 0;
function Agregar_Imagen_NIT(){
    tabladatos = $('#lista_nit');
    var fila = '<tr id="fila_nit'+cont_nit+'">\n\
        <td><input name="imagen_nit[]" id="imagen_nit'+cont_nit+'" type="file" accept="image/*"></td>\n\
       <td> <button type="button" id="btn_eli'+cont_nit+'" class="btn-sm btn-danger" title=Eliminar onclick="Eliminar_lista_NIT(' + cont_nit + ')"><i class="fa fa-trash-o" aria-hidden="true"></i></button></td></tr>';            
    $('#lista_nit').append(fila);
    cont_nit++;
}
function Eliminar_lista_NIT(index){
   imagen_nit[index]=0;
   $('#fila_nit' + index).remove();
}

//AGREGAR IMAGEN RESOLUCION ADMINISTRATIVA ATT
var imagen_att = [];
var cont_att = 0;
function Agregar_Imagen_ATT(){
    tabladatos = $('#lista_att');
    var fila = '<tr id="fila_att'+cont_att+'">\n\
        <td><input name="imagen_att[]" id="imagen_att'+cont_att+'" type="file" accept="image/*"></td>\n\
       <td> <button type="button" id="btn_eli'+cont_att+'" class="btn-sm btn-danger" title=Eliminar onclick="Eliminar_lista_ATT(' + cont_att + ')"><i class="fa fa-trash-o" aria-hidden="true"></i></button></td></tr>';            
    $('#lista_att').append(fila);
    cont_att++;
}
function Eliminar_lista_ATT(index){
   imagen_att[index]=0;
   $('#fila_att' + index).remove();
}

//AGREGAR IMAGEN RFACTURA AGUA O LUZ DE EMPRESA
var imagen_agua_luz = [];
var cont_agua_luz = 0;
function Agregar_Imagen_Agua_Luz(){
    tabladatos = $('#lista_agua_luz');
    var fila = '<tr id="fila_agua_luz'+cont_agua_luz+'">\n\
        <td><input name="imagen_agua_luz[]" id="imagen_agua_luz'+cont_agua_luz+'" type="file" accept="image/*"></td>\n\
       <td> <button type="button" id="btn_eli'+cont_agua_luz+'" class="btn-sm btn-danger" title=Eliminar onclick="Eliminar_lista_Agua_Luz(' + cont_agua_luz + ')"><i class="fa fa-trash-o" aria-hidden="true"></i></button></td></tr>';            
    $('#lista_agua_luz').append(fila);
    cont_agua_luz++;
}
function Eliminar_lista_Agua_Luz(index){
   imagen_agua_luz[index]=0;
   $('#fila_agua_luz' + index).remove();
}

//AGREGAR IMAGEN CORPORATIVA
var imagen_corporativa = [];
var cont_corporativa = 0;
function Agregar_Imagen_Corporativa(){
    tabladatos = $('#lista_corporativa');
    var fila = '<tr id="fila_corporativa'+cont_corporativa+'">\n\
        <td><input name="imagen_corporativa[]" id="imagen_corporativa'+cont_corporativa+'" type="file" accept="image/*"></td>\n\
       <td> <button type="button" id="btn_eli'+cont_corporativa+'" class="btn-sm btn-danger" title=Eliminar onclick="Eliminar_lista_Corporativa(' + cont_corporativa + ')"><i class="fa fa-trash-o" aria-hidden="true"></i></button></td></tr>';            
    $('#lista_corporativa').append(fila);
    cont_corporativa++;
}
function Eliminar_lista_Corporativa(index){
   imagen_corporativa[index]=0;
   $('#fila_corporativa' + index).remove();
}

//AGREGAR IMAGEN SENAPI
var imagen_senapi = [];
var cont_senapi = 0;
function Agregar_Imagen_Senapi(){
    tabladatos = $('#lista_senapi');
    var fila = '<tr id="fila_senapi'+cont_senapi+'">\n\
        <td><input name="imagen_senapi[]" id="imagen_senapi'+cont_senapi+'" type="file" accept="image/*"></td>\n\
       <td> <button type="button" id="btn_eli'+cont_senapi+'" class="btn-sm btn-danger" title=Eliminar onclick="Eliminar_lista_Senapi(' + cont_senapi + ')"><i class="fa fa-trash-o" aria-hidden="true"></i></button></td></tr>';            
    $('#lista_senapi').append(fila);
    cont_senapi++;
}
function Eliminar_lista_Senapi(index){
   imagen_senapi[index]=0;
   $('#fila_senapi' + index).remove();
}




///////////////////////
///////GOOGLE MAPS/////
///////////////////////
var map_cont = 0;
   
      
       function initAutocomplete() {
        var myLatLng = {lat: -17.7862900, lng: -63.1811700};
        var map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: myLatLng.lat, lng: myLatLng.lng },
          zoom: 13,
          mapTypeId: 'roadmap'
        });
        




        
 //agregar un marker con una ubicacion en Santa Cruz de la Sierra
       marker = new google.maps.Marker({
                  map: map,
                  draggable: true,              
                  //icon: icon,
                  animation: google.maps.Animation.DROP,
                  title:"Marker Comercial",
                  position: myLatLng,                  
              });
            $("input[name='latitud']").val(myLatLng.lat);  
            $("input[name='longitud']").val(myLatLng.lng);  

               google.maps.event.addListener(marker, 'dragend', (function(marker) {
                  return function() {
                    $("input[name='latitud']").val(this.getPosition().lat());  
                    $("input[name='longitud']").val(this.getPosition().lng());  
                  }
                })(marker));
                
/*IMPLEMENTADO PARA LO EVENTOS DE CLICK*/
               google.maps.event.addListener(map, 'click', function(event) {
                  addMarker(event.latLng, map);
                });


               function addMarker(location, map) {
//agregar un marker en el mapa 
              $("input[name='latitud']").val(location.lat());  
              $("input[name='longitud']").val(location.lng());  

                 marker.setPosition(location);
              }
// FIN DE INICIAR LA APP


        // Create the search box and link it to the UI element.
        var input = document.getElementById('pac-input');
        var searchBox = new google.maps.places.SearchBox(input);
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

        // Bias the SearchBox results towards current map's viewport.
        map.addListener('bounds_changed', function() {
          searchBox.setBounds(map.getBounds());
        });

        var markers = [];
        // Listen for the event fired when the user selects a prediction and retrieve
        // more details for that place.
        searchBox.addListener('places_changed', function() {
          var places = searchBox.getPlaces();

          if (places.length == 0) {
            return;
          }

          // Clear out the old markers.
          //markers.forEach(function(marker) {
          if (map_cont > 0) {
            marker.setMap(null);            
          }
          //});
          markers = [];
          // For each place, get the icon, name and location.
          var bounds = new google.maps.LatLngBounds();
          places.forEach(function(place) {
            if (!place.geometry) {
              console.log("Returned place contains no geometry");
              return;
            }
            var icon = {
              url: place.icon,
              size: new google.maps.Size(71, 71),
              origin: new google.maps.Point(0, 0),
              anchor: new google.maps.Point(17, 34),
              scaledSize: new google.maps.Size(25, 25)
            };

            // Create a marker for each place.
            /*markers.push(new google.maps.Marker({
              map: map,
              draggable: true,              
              //icon: icon,
              animation: google.maps.Animation.DROP,
              title: place.name,
              position: place.geometry.location
            }));*/

              marker = new google.maps.Marker({
                  map: map,
                  draggable: true,              
                  //icon: icon,
                  animation: google.maps.Animation.DROP,
                  title: place.name,
                  position: place.geometry.location,                  
              });
            $("input[name='latitud']").val(place.geometry.location.lat());  
            $("input[name='longitud']").val(place.geometry.location.lng());  

            map_cont++;

                google.maps.event.addListener(marker, 'dragend', (function(marker) {
                  return function() {
                    $("input[name='latitud']").val(this.getPosition().lat());  
                    $("input[name='longitud']").val(this.getPosition().lng());  
                  }
                })(marker));
                
/*IMPLEMENTADO PARA LO EVENTOS DE CLICK*/
               google.maps.event.addListener(map, 'click', function(event) {
                  addMarker(event.latLng, map);
                });

               function addMarker(location, map) {
  // Add the marker at the clicked location, and add the next-available label
  // from the array of alphabetical characters.
              $("input[name='latitud']").val(location.lat());  
              $("input[name='longitud']").val(location.lng());  

                 marker.setPosition(location);
              }

             
//FIN DE EVENTO DE AGRAEGAR CLICK

            if (place.geometry.viewport) {
              // Only geocodes have viewport.
              bounds.union(place.geometry.viewport);
            } else {
              bounds.extend(place.geometry.location);
            }
          });
          map.fitBounds(bounds);
        });
      }

