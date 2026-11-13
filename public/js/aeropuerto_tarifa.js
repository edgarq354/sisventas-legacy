$(document).ready(function(){
 
    initAutocomplete() ;
});


//////////////////////////////
//////////////////////////////
///////                 //////
///////   GOOGLE MAPS   //////
///////                 //////
//////////////////////////////
//////////////////////////////




var map;
var map_cont = 0;
var circle;
            function initAutocomplete() {
        var myLatLng = {lat: parseFloat($("#latitud").val()), lng: parseFloat($("#longitud").val()) };
        var map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: myLatLng.lat, lng: myLatLng.lng },
          zoom: 13,
          mapTypeId: 'roadmap'
        }



        );
        

 circle = new google.maps.Circle({ 
map: map, 
radius: parseInt($("#cantidad_1").text()), 
strokeColor: '#FF0000',
strokeOpacity: 0.5,
strokeWeight: 2,
fillColor: '#FF0000',
fillOpacity: 0.35,
center: myLatLng, 
clickeable: true 
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
            $("#latitud").val(myLatLng.lat);  
            $("#longitud").val(myLatLng.lng);  

               google.maps.event.addListener(marker, 'dragend', (function(marker) {
                  return function() {
                    $("#latitud").val(this.getPosition().lat());  
                    $("#longitud").val(this.getPosition().lng());  
                    var myLatLng = {lat: this.getPosition().lat(), lng: this.getPosition().lng()};
                  circle.setCenter(myLatLng);
                  }
                })(marker));
                
/*IMPLEMENTADO PARA LO EVENTOS DE CLICK*/
               google.maps.event.addListener(map, 'click', function(event) {
                  addMarker(event.latLng, map);


                });


               function addMarker(location, map) {
//agregar un marker en el mapa 
              $("#latitud").val(location.lat());  
              $("#longitud").val(location.lng());  

                 marker.setPosition(location);
                  var myLatLng = {lat: location.lat(), lng:  location.lng()};
                  circle.setCenter(myLatLng);

              }
// FIN DE INICIAR LA APP 
      }


      function cambiar_ancho()
{
  var tamanio=parseInt($("#cantidad_1").text());
  circle.setRadius(tamanio);
}
