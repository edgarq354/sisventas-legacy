var imagen_ci = [];
var cont_ci = 0;
var imagen_licencia = [];
var cont_licencia = 0;
var imagen_identificacion_de_ham = [];
var cont_ham = 0;
var imagen_identificacion_de_transito = [];
var cont_ident_trans = 0;
var imagen_agua_luz = [];
var cont_agua_luz = 0;
var imagen_antecedente_transito = [];
var cont_antecedente_trans = 0;
var imagen_antecedente_felcc = [];
var cont_antecedente_felcc = 0;

$(document).ready(function(){
    $('#mostrar').hide();
    $('#loading').css("display","none");
    $('#body_principal').show();
});

function verificar_sexo(){
    //alert($('input[name="select"]:checked').val());
    $("#sexo").val($('input[name="select"]:checked').val());   
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
                 alertify.alert("Sistema","El Conductor no esta registrado en el Sistema.", function(){alertify.error('OK');});                         
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
                  alertify.confirm("Sistema",response[0].nombre+" "+response[0].paterno+" "+response[0].materno+" esta "+estado+", registrado en la empresa "+response[0].razon_social+".\nContactece:\nWhatsApp:"+response[0].whatsapp+".\nDirección:"+response[0].direccion+".",
                   function(){
                    alertify.success('OK');
                     },
                 function(){
                     document.location.target = "_blank";
                        document.location.href="../historial_baja_alta/"+response[0].ci;
                    alertify.error('Ver historial de retiros');
                  }

                   );   


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

              alertify.alert("Radio Movil","El Vehículo no esta registrado en Radio Movil.", function(){alertify.success('OK');});   
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


               alertify.confirm("Radio Movil ",response[0].placa+" esta "+estado+", registrado en la empresa "+response[0].razon_social+".\nContactece:\nWhatsApp:"+response[0].whatsapp+".\nDirección:"+response[0].direccion+".",
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



//AFREAR CARNET CI
function Agregar_Imagen_Carnet(){
    tabladatos = $('#lista_fotocopia');
    var fila = '<tr id="fila_ci'+cont_ci+'">\n\
        <td><input name="imagen_ci[]" id="imagen_ci'+cont_ci+'" type="file"  accept="image/*"></td>\n\
       <td> <button type="button" id="btn_eli'+cont_ci+'" class="btn-sm btn-danger" title=Eliminar onclick="Eliminar_lista_CI(' + cont_ci + ')"><i class="fa fa-trash-o" aria-hidden="true"></i></button></td></tr>';            
    $('#lista_fotocopia').append(fila);
    cont_ci++;
}
function Eliminar_lista_CI(index){
   imagen_ci[index]=0;
   $('#fila_ci' + index).remove();
}

//AGREGAR LICENCIA
function Agregar_Imagen_Licencia(){
    tabladatos = $('#lista_licencia');
    var fila = '<tr id="fila_licencia'+cont_licencia+'">\n\
        <td><input name="imagen_licencia[]" id="imagen_licencia'+cont_licencia+'" type="file"  accept="image/*"></td>\n\
       <td> <button type="button" id="btn_eli'+cont_licencia+'" class="btn-sm btn-danger" title=Eliminar onclick="Eliminar_lista_Licencia(' + cont_licencia + ')"><i class="fa fa-trash-o" aria-hidden="true"></i></button></td></tr>';            
    $('#lista_licencia').append(fila);
    cont_licencia++;
}
function Eliminar_lista_Licencia(index){
   imagen_licencia[index]=0;
   $('#fila_licencia' + index).remove();
}

//AGREGAR TARJETA DE IDENTIFICACION DE HAM
function Agregar_Imagen_Identificacion_Ham(){
    tabladatos = $('#lista_identificacion_ham');
    var fila = '<tr id="fila_ham'+cont_ham+'">\n\
        <td><input name="imagen_identificacion_de_ham[]" id="imagen_identificacion_de_ham'+cont_ham+'" type="file"  accept="image/*"></td>\n\
       <td> <button type="button" id="btn_eli'+cont_ham+'" class="btn-sm btn-danger" title=Eliminar onclick="Eliminar_lista_Ham(' + cont_ham + ')"><i class="fa fa-trash-o" aria-hidden="true"></i></button></td></tr>';            
    $('#lista_identificacion_ham').append(fila);
    cont_ham++;
}
function Eliminar_lista_Ham(index){
   imagen_identificacion_de_ham[index]=0;
   $('#fila_ham' + index).remove();
}

//AGREGAR TARJETA DE IDENTIFICACION DE TRANSITO
function Agregar_Imagen_Identificacion_Transito(){
    tabladatos = $('#lista_identificacion_transito');
    var fila = '<tr id="fila_ident_tarnsito'+cont_ident_trans+'">\n\
        <td><input name="imagen_identificacion_de_transito[]" id="imagen_identificacion_de_transito'+cont_ident_trans+'" type="file"  accept="image/*"></td>\n\
       <td> <button type="button" id="btn_eli'+cont_ident_trans+'" class="btn-sm btn-danger" title=Eliminar onclick="Eliminar_lista_Ident_Transito(' + cont_ident_trans + ')"><i class="fa fa-trash-o" aria-hidden="true"></i></button></td></tr>';            
    $('#lista_identificacion_transito').append(fila);
    cont_ident_trans++;
}
function Eliminar_lista_Ident_Transito(index){
   imagen_identificacion_de_ham[index]=0;
   $('#fila_ident_tarnsito' + index).remove();
}

//AGREGAR IMAGEN AGUA O LUZ
function Agregar_Imagen_Agua_Luz(){
    tabladatos = $('#lista_agua_luz');
    var fila = '<tr id="fila_agua_luz'+cont_agua_luz+'">\n\
        <td><input name="imagen_agua_luz[]" id="imagen_agua_luz'+cont_agua_luz+'" type="file"  accept="image/*"></td>\n\
       <td> <button type="button" id="btn_eli'+cont_agua_luz+'" class="btn-sm btn-danger" title=Eliminar onclick="Eliminar_lista_Agua_Luz(' + cont_agua_luz + ')"><i class="fa fa-trash-o" aria-hidden="true"></i></button></td></tr>';            
    $('#lista_agua_luz').append(fila);
    cont_agua_luz++;
}
function Eliminar_lista_Agua_Luz(index){
   imagen_agua_luz[index]=0;
   $('#fila_agua_luz' + index).remove();
}


//AGREGAR IMAGEN CERTIFICADO DE ANTECEDENTES DE TRANSITO
function Agregar_Antecendente_Transito(){
    tabladatos = $('#lista_antecedente_transito');
    var fila = '<tr id="fila_antecedente_trans'+cont_antecedente_trans+'">\n\
        <td><input name="imagen_antecedente_transito[]" id="imagen_antecedente_transito'+cont_antecedente_trans+'" type="file"  accept="image/*"></td>\n\
       <td> <button type="button" id="btn_eli'+cont_antecedente_trans+'" class="btn-sm btn-danger" title=Eliminar onclick="Eliminar_lista_Antecedente_Transito(' + cont_antecedente_trans + ')"><i class="fa fa-trash-o" aria-hidden="true"></i></button></td></tr>';            
    $('#lista_antecedente_transito').append(fila);
    cont_antecedente_trans++;
}
function Eliminar_lista_Antecedente_Transito(index){
   imagen_antecedente_transito[index]=0;
   $('#fila_antecedente_trans' + index).remove();
}

//AGREGAR IMAGEN CERTIFICADO DE ANTECEDENTES DE FELCC
function Agregar_Antecendente_FELCC(){
    tabladatos = $('#lista_antecedente_felcc');
    var fila = '<tr id="fila_antecedente_felcc'+cont_antecedente_felcc+'">\n\
        <td><input name="imagen_antecedente_felcc[]" id="imagen_antecedente_felcc'+cont_antecedente_felcc+'" type="file"  accept="image/*"></td>\n\
       <td> <button type="button" id="btn_eli'+cont_antecedente_felcc+'" class="btn-sm btn-danger" title=Eliminar onclick="Eliminar_lista_Antecedente_FELCC(' + cont_antecedente_felcc + ')"><i class="fa fa-trash-o" aria-hidden="true"></i></button></td></tr>';            
    $('#lista_antecedente_felcc').append(fila);
    cont_antecedente_felcc++;
}
function Eliminar_lista_Antecedente_FELCC(index){
   imagen_antecedente_felcc[index]=0;
   $('#fila_antecedente_felcc' + index).remove();
}


//////////////////////////////
//////////////////////////////
///////                 //////
///////   GOOGLE MAPS   //////
///////                 //////
//////////////////////////////
//////////////////////////////
var map_cont = 0;
            function initAutocomplete() {
        var myLatLng = {lat: -17.7862900, lng: -63.1811700};
        var map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: myLatLng.lat, lng: myLatLng.lng },
          zoom: 13,
          mapTypeId: 'roadmap',
          styles:
          [
  {
    "elementType": "geometry",
    "stylers": [
      {
        "color": "#dee3e7"
      }
    ]
  },
  {
    "elementType": "geometry.stroke",
    "stylers": [
      {
        "color": "#2a2a2a"
      }
    ]
  },
  {
    "elementType": "labels.text",
    "stylers": [
      {
        "color": "#0f0f0f"
      }
    ]
  },
  {
    "elementType": "labels.text.fill",
    "stylers": [
      {
        "color": "#191919"
      }
    ]
  },
  {
    "elementType": "labels.text.stroke",
    "stylers": [
      {
        "color": "#f5f5f5"
      }
    ]
  },
  {
    "featureType": "administrative.land_parcel",
    "elementType": "labels.text.fill",
    "stylers": [
      {
        "color": "#000000"
      }
    ]
  },
  {
    "featureType": "poi",
    "elementType": "geometry",
    "stylers": [
      {
        "color": "#eeeeee"
      }
    ]
  },
  {
    "featureType": "poi",
    "elementType": "labels.text.fill",
    "stylers": [
      {
        "color": "#9b5200"
      }
    ]
  },
  {
    "featureType": "poi.attraction",
    "elementType": "labels.text.fill",
    "stylers": [
      {
        "color": "#155f86"
      }
    ]
  },
  {
    "featureType": "poi.business",
    "elementType": "labels.text.fill",
    "stylers": [
      {
        "color": "#1874cf"
      }
    ]
  },
  {
    "featureType": "poi.park",
    "elementType": "geometry",
    "stylers": [
      {
        "color": "#e5e5e5"
      }
    ]
  },
  {
    "featureType": "poi.park",
    "elementType": "labels.text.fill",
    "stylers": [
      {
        "color": "#006400"
      }
    ]
  },
  {
    "featureType": "poi.school",
    "elementType": "labels.text.fill",
    "stylers": [
      {
        "color": "#c42444"
      }
    ]
  },
  {
    "featureType": "road",
    "elementType": "geometry",
    "stylers": [
      {
        "color": "#ffffff"
      }
    ]
  },
  {
    "featureType": "road",
    "elementType": "labels.text",
    "stylers": [
      {
        "color": "#ffffff"
      }
    ]
  },
  {
    "featureType": "road.arterial",
    "elementType": "labels.text.fill",
    "stylers": [
      {
        "color": "#101827"
      }
    ]
  },
  {
    "featureType": "road.highway",
    "elementType": "geometry",
    "stylers": [
      {
        "color": "#377ca2"
      }
    ]
  },
  {
    "featureType": "road.highway",
    "elementType": "labels.text.fill",
    "stylers": [
      {
        "color": "#060e26"
      },
      {
        "saturation": -35
      }
    ]
  },
  {
    "featureType": "road.local",
    "elementType": "labels.text.fill",
    "stylers": [
      {
        "color": "#000000"
      }
    ]
  },
  {
    "featureType": "transit.line",
    "elementType": "geometry",
    "stylers": [
      {
        "color": "#0a6676"
      }
    ]
  },
  {
    "featureType": "transit.station",
    "elementType": "geometry",
    "stylers": [
      {
        "color": "#eeeeee"
      }
    ]
  },
  {
    "featureType": "water",
    "elementType": "geometry",
    "stylers": [
      {
        "color": "#1ad5ea"
      },
      {
        "weight": 2
      }
    ]
  },
  {
    "featureType": "water",
    "elementType": "labels.text.fill",
    "stylers": [
      {
        "color": "#9e9e9e"
      }
    ]
  }
]
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



//CARGAR EL PERFIL DEL CONDUCTOR
function archivo(evt) {
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
            $("#imgPerfil").hide();
           document.getElementById("list").innerHTML = ['<img class="img-thumbnail" src="', e.target.result,'" title="', escape(theFile.name), '" width="200px" height="200px"/>'].join('');
          };
      })(f);

      reader.readAsDataURL(f);
    }
}


//CARGAR FOTO DEL VEHICULO
function archivoVehiculo(evt) {
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
          $("#imgVehiculo").hide();
         document.getElementById("listVehiculo").innerHTML = ['<img class="img-thumbnail" src="', e.target.result,'" title="', escape(theFile.name), '" width="400px" height="400px"/>'].join('');
        };
    })(f);

    reader.readAsDataURL(f);
  }
}
document.getElementById('perfil').addEventListener('change', archivo, false);
document.getElementById('fotoVehiculo').addEventListener('change', archivoVehiculo, false);

function seleccionar_marca()
{
    $("#marca").val($("#marca_aux").val());
}
function seleccionar_numero_movil()
{
    $("#numero_movil").val($("#numero_movil_aux").val());
}
function seleccionar_clase()
{
    $("#clase").val($("#clase_aux").val());
}
