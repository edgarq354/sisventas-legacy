$(document).ready(function(){
    $('#mostrar').hide();
    $('#loading').css("display","none");
    $('#body_principal').show();
    //Cargar_Perfil_Conductor($("#direccion_imagen").val());//
});



function ver_chat(id_usuario,id_desaparecido)
{

$.get("../../detalle_chat_por_id_usuario/"+id_usuario+"/"+id_desaparecido, function (res) {  
      
      $(res).each(function (key, value) {            
            
 $('#div_mensaje').empty();
        var tablapedido=$('#div_mensaje');
         

          tablapedido.append('\n\
          <div class="incoming_msg">\n\
              <div class="incoming_msg_img"> <img src="https://ptetutorials.com/images/user-profile.png" alt="sunil"> </div>\n\
              <div class="received_msg">\n\
                <div class="received_withd_msg">\n\
                  <p>'+value.mensaje+'</p>\n\
                  <span class="time_date">'+value.fecha+'</span></div>\n\
              </div>\n\
            </div>');   
    
              
              
               
 
          });
        });
}

 
 

function verificar_sexo(){
    $("#sexo").val($('input[name="select"]:checked').val());   
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
          mapTypeId: 'roadmap'
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