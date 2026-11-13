var map;
var markers=[];
var tiempo="";

var sw_solicitudes=true;
var sw_servicios_en_proceso=false;
var sw_servicios_concluidos=false;



var cant_libre=0;
var cant_descanso=0;
var cant_en_servicio=0;
var cant_suspendido=0; 
var cant_moto_libre=0;
var cant_moto_descanso=0;
var cant_moto_en_servicio=0;
var cant_moto_suspendido=0; 


var mapa2;
var merker2;
var marker_lugar;
var map_cont = 0;
var markers2=[];

 
 
 

 


function ver_recorrido_pedido() {
 

    map = new google.maps.Map(document.getElementById('mapa'), {
    zoom: 16,
    center: new google.maps.LatLng(-18.484264, -64.105909),
    mapTypeId: google.maps.MapTypeId.ROADMAP,
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
    //set an interval
     tiempo=setInterval(cargar_buscador, 5000);
    cargar_buscador(map);
    //Call the function
 

}

function ver_ubicacion_cancelado() {
 

  var latitud_inicio=$("#latitud_inicio").val();
var longitud_inicio=$("#longitud_inicio").val();

var latitud_pedido=$("#latitud_pedido").val();
var longitud_pedido=$("#longitud_pedido").val();

var latitud_cancelado=$("#latitud_cancelado").val();
var longitud_cancelado=$("#longitud_cancelado").val();


    deleteMarkers();
          usuario = new google.maps.Marker({
                position: new google.maps.LatLng(parseFloat(latitud_pedido), parseFloat(longitud_pedido)),
                map: map,
              }); 
           markers.push(usuario);

          aceptado = new google.maps.Marker({
                position: new google.maps.LatLng(parseFloat(latitud_inicio), parseFloat(longitud_inicio)),
                map: map,
              }); 
              markers.push(aceptado);

          cancelado = new google.maps.Marker({
                position: new google.maps.LatLng(parseFloat(latitud_cancelado), parseFloat(longitud_cancelado)),
                map: map,
              }); 
              markers.push(cancelado);


      var lat_p=parseFloat(latitud_pedido);
      var lon_p=parseFloat(longitud_pedido);
      map.setCenter(new google.maps.LatLng(lat_p, lon_p));     

              usuario.setIcon('../images/solicitud.png');  //conductor bloqueado

              aceptado.setIcon('../images/ic_pedido_proceso.png');  
              
              cancelado.setIcon('../images/inactivo.png');  
 

}

function ver_ubicacion_puntos_finalizados() {
 
var latitud_inicio=$("#latitud_inicio").val();
var longitud_inicio=$("#longitud_inicio").val();

var latitud_pedido=$("#latitud_pedido").val();
var longitud_pedido=$("#longitud_pedido").val();

var latitud_lugar=$("#latitud_lugar").val();
var longitud_lugar=$("#longitud_lugar").val();


    deleteMarkers();
          usuario = new google.maps.Marker({
                position: new google.maps.LatLng(parseFloat(latitud_pedido), parseFloat(longitud_pedido)),
                map: map,
              }); 
     markers.push(usuario);

          aceptado = new google.maps.Marker({
                position: new google.maps.LatLng(parseFloat(latitud_inicio), parseFloat(longitud_inicio)),
                map: map,
              }); 
              markers.push(aceptado);

          marker_lugar = new google.maps.Marker({
                position: new google.maps.LatLng(parseFloat(latitud_lugar), parseFloat(longitud_lugar)),
                map: map,
              }); 
              markers.push(marker_lugar);    

      var lat_p=parseFloat(latitud_pedido);
      var lon_p=parseFloat(longitud_pedido);
      map.setCenter(new google.maps.LatLng(lat_p, lon_p));     

             usuario.setIcon('../images/solicitud.png');  //conductor bloqueado

              aceptado.setIcon('../images/ic_pedido_proceso.png');  
              
              marker_lugar.setIcon('../images/empresa.png');  
               
 


}




 function cargar_buscador(mapa)
 {


    var sw_estado_pedido=$('#estado_pedido').val();
    var latitud_pedido=$('#latitud_pedido').val();
    var longitud_pedido=$('#longitud_pedido').val();
     var latitud_lugar=$('#latitud_lugar').val();
    var longitud_lugar=$('#longitud_lugar').val();
    var id_conductor_pedido=$('#id_conductor_pedido').val();


  if(sw_estado_pedido==0){
  
 
         deleteMarkers();
          usuario = new google.maps.Marker({
                position: new google.maps.LatLng(parseFloat(latitud_pedido), parseFloat(longitud_pedido)),
                map: map,
              }); 
              markers.push(usuario);

          marker_lugar = new google.maps.Marker({
                position: new google.maps.LatLng(parseFloat(latitud_lugar), parseFloat(longitud_lugar)),
                map: map,
              }); 
              markers.push(marker_lugar);
          
      var lat_p=parseFloat(latitud_pedido);
      var lon_p=parseFloat(longitud_pedido);
      map.setCenter(new google.maps.LatLng(lat_p, lon_p));     

              usuario.setIcon('../images/ic_pedido_us.png');  //conductor bloqueado
              marker_lugar.setIcon('../images/empresa.png');  //conductor bloqueado



      $.get("../ver_ubicacion_conductor/"+id_conductor_pedido, function (res) {  
      
      $(res).each(function (key, value) {            
            

               conductor = new google.maps.Marker({ 
                map:map,
                position: new google.maps.LatLng(parseFloat(value.latitud_asignacion), parseFloat(value.longitud_asignacion)),
              });
          markers.push(conductor);
          conductor.setIcon('../images/carrera.png');   
            
              
               
 
          });
        });            
    }
 
  
 }


// Sets the map on all markers in the array.
      function setMapOnAll(map) {
        for (var i = 0; i < markers.length; i++) {
          markers[i].setMap(map);
        }
      }

      // Removes the markers from the map, but keeps them in the array.
      function clearMarkers() {
        setMapOnAll(null);
      }

      // Shows any markers currently in the array.
      function showMarkers() {
        setMapOnAll(map);
      }

      // Deletes all markers in the array by removing references to them.
      function deleteMarkers() {
        clearMarkers();
        markers = [];
      }


 
 