$(document).ready(function(){
    $('#mostrar').hide();
    $('#loading').css("display","none");
    $('#body_principal').show();
    //Cargar_Perfil_Conductor($("#direccion_imagen").val());//
});




function Cargar_historial_imei(id_user){
   

   $.get("../cargar_historial_imei/"+id_user, function (res) {//CONSULTA DE HISTORIAL DE INICIOS DE SESION
    
    //ELIMINAR LA LISTA DE CONDUCTORES EN PEDIDOS
    $('#body_usuario_historial_imei').empty();
    var tabladatos=$('#body_usuario_historial_imei');

      for (var i = 0; i < res.length; i++) { 
        tabladatos.append("<tr><td>"+res[i].fecha+"</td><td>"+res[i].imei+"</td></tr>");
      }
  });
}


function Cargar_Perfil_Conductor(dir){
  if ( dir != "") {
      $.get('../Cargar_Perfil_Conductor/'+dir , function (response) {
          if (response[0].perfil == "") {
               $("#ci_verificar").hide();        
               $("#btn_actualizar").show();        
          } else {
               $("#ci_verificar").show();
               $("#btn_actualizar").hide();        
          }
      }); 
  }    
}
 function cargar_token_conductor(token){
    $("#token_not").val(token);
  }  

function verificar_sexo(){
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
                 alertify.alert("Radio Movil Clasico","El Conductor no esta registrado en Radio Movil Clasico.", function(){alertify.error('OK');});                         
            } else {
                 $("#btn_registrar").hide();  
                 $("select[name='expedido']").val(response[0].expedido);                               
                 $("input[name='nombre']").val(response[0].nombre);               
                 $("input[name='paterno']").val(response[0].paterno);               
                 $("input[name='materno']").val(response[0].materno);
                 var estado="INACTIVO";
                 if(response[0].estado==1){
                    estado="ACTIVO";
                 }
                  alertify.alert("Radio Movil Clasico",response[0].nombre+" "+response[0].paterno+" "+response[0].materno+" esta "+estado+", registrado en la empresa "+response[0].razon_social+".\nContactece:\nWhatsApp:"+response[0].whatsapp+".\nDirección:"+response[0].direccion+".", function(){alertify.success('OK');});          
            }
        }); 

    }  
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
           document.getElementById("list").innerHTML = ['<img class="thumb" src="', e.target.result,'" title="', escape(theFile.name), '" width="150px" height="150px"/>'].join('');
          };
      })(f);

      reader.readAsDataURL(f);
      $("#foto_conductor").hide();
    }
}
document.getElementById('perfil').addEventListener('change', archivo, false);

///////////////////////
///////GOOGLE MAPS/////
///////////////////////

///////////////////////
///////GOOGLE MAPS/////
///////////////////////
var map_cont = 0;
var latitud = $("input[name='latitud']").val();
var longitud = $("input[name='longitud']").val();
      function initAutocomplete() {
        var map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: parseFloat(latitud), lng: parseFloat(longitud),},
          zoom: 16,
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



                    if (place.geometry.viewport) {
                      // Only geocodes have viewport.
                      bounds.union(place.geometry.viewport);
                    } else {
                      bounds.extend(place.geometry.location);
                    }
                  });
                  map.fitBounds(bounds);
                });   
         
        if (map_cont == 0) {
            marker = new google.maps.Marker({
              map:map,
              draggable: true,
              animation: google.maps.Animation.DROP,        
              position: new google.maps.LatLng(parseFloat(latitud), parseFloat(longitud)),
              title: String($("#direccion").val())
            });

            map_cont++;
              google.maps.event.addListener(marker, 'dragend', (function(marker) {
                return function() {
                  $("input[name='latitud']").val(this.getPosition().lat());  
                  $("input[name='longitud']").val(this.getPosition().lng());  
                }
              })(marker));          
        }
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

      }