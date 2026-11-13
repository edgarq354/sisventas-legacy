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
