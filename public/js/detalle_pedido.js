
var cont = 0;
var id_empresa = [];
var token_not = [];
var map;
var markers=[];
var flightPath;




$( window ).load(function(event){
 initialize();
 
});

function initialize() {

    map = new google.maps.Map(document.getElementById('mapa'), {
    zoom: 15,
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

     var flightPathCoordinates = [
          {lat: 37.772, lng: -122.214},
          {lat: 21.291, lng: -157.821},
          {lat: -18.142, lng: 178.431},
          {lat: -27.467, lng: 153.027}
        ];

        flightPath = new google.maps.Polyline({
          path: flightPathCoordinates,
          strokeColor: '#FF0000',
          strokeOpacity: 1.0,
          strokeWeight: 2
        });

        addLine(); 
        removeLine();

}


function ver_linea(id_carrera,id_pedido,latitud_inicio,longitud_inicio,latitud_fin,longitud_fin){
    $.get('../ver_linea_ruta/'+id_carrera+'/'+id_pedido, function (res) { 
      deleteMarkers();
removeLine();
         
    map.setCenter( new google.maps.LatLng(latitud_inicio, longitud_inicio));

         //CARGAR PUNTO INICIAL
        marker = new google.maps.Marker({ //SE CREA UN NUEVO MARKER
          map:map,
          animation: google.maps.Animation.DROP,        
          position: new google.maps.LatLng(latitud_inicio, longitud_inicio),
          title: 'INICIO'
        });
        markers.push(marker);
        marker.setIcon('../images/punto_inicio.png');  

        //CARGAR PUNTO FINAL
         marker = new google.maps.Marker({  
          map:map,
          animation: google.maps.Animation.DROP,        
          position: new google.maps.LatLng(latitud_fin, longitud_fin),
          title: 'FIN'
        });
        markers.push(marker);
        marker.setIcon('../images/punto_fin.png');                                                                                           
        
  var flightPlanCoordinates = [];
  var lati=0;
  var longi=0;
  var rotacion=0;
 
  var aux_linea="";
  var aux_rot=0,sw_rotacion=0;
     

flightPlanCoordinates.push({lat:  latitud_inicio, lng: longitud_inicio});

      for (var i = 0; i < res.length; i++) { 
        rotacion=parseInt(res[i].rotacion);
        lati= parseFloat(res[i].latitud);
        longi=parseFloat(res[i].longitud);
        sw_rotacion=0;
        if(aux_rot+1>rotacion&& aux_rot-1<rotacion)
        {
          sw_rotacion=1;
        }

        if(lati+","+longi!=aux_linea  )
        {
          aux_lat=lati+","+longi; 
          aux_rot=rotacion;
          
          flightPlanCoordinates.push({lat:  lati, lng: longi});
        }
        
      }

flightPlanCoordinates.push({lat:  latitud_fin, lng: longitud_fin});
 
         flightPath = new google.maps.Polyline({
          path: flightPlanCoordinates,
          geodesic: true,
          strokeColor: '#000',
          strokeOpacity: 1.0,
          strokeWeight: 5
        });

        flightPath.setMap(map);

    });
}

 

sw=0;//PARA VERIFICAR SI YA EXISTE ESE MOTISTA EN LA LISTA SW = 0 Q NO EXISTE Y SW = 1 Q YA EXISTE EN LA LISTA

//MUESTRA LAS EMPRESAS DEPENDE LO Q SELECCIONO EN EL BUSADOR
 

//ELIMINAR FILA CUANDO DA CLICK EN EL MAPA
function eliminar_lista(index){
   id_empresa[index]=0;
   $('#fila'+index).remove();
}

function Seleccionar_Todos(){
  var opcion = $("#buscar_empresa").val();
  cont=0;  
  if (opcion == 0) { //NINGUNO
    $('#body_empresa').empty();    
   // document.getElementById("mapa").innerHTML="";
    $("#btn_sel_todos_adm").hide();
  } else{ // CASO CONTRARIO SELECCIONO OTRAS OPCIONES
      Cargar_Mapa_Lista_Adm(1,opcion);  
      Cargar_Tabla_Lista_Adm(opcion);   
      $("#btn_sel_todos_adm").hide();   
      $("#btn_desel_todos_adm").show();            
  }    
}

function Deseleccionar_Todos(){
  var opcion = $("#buscar_empresa").val();
  cont=0;  
  if (opcion == 0) { //NINGUNO
    $('#body_empresa').empty();    
    //document.getElementById("mapa").innerHTML="";
    $("#btn_sel_todos_adm").hide();
  } else{ // CASO CONTRARIO SELECCIONO OTRAS OPCIONES
      Cargar_Mapa_Lista_Adm(0,opcion);  
      //Cargar_Tabla_Lista_Adm(opcion);   
      $("#btn_desel_todos_adm").hide();   
      $("#btn_sel_todos_adm").show();  
      cont=0;      
      $('#body_empresa').empty();          
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
 function addLine() {
        flightPath.setMap(map);
      }

      function removeLine() {
        flightPath.setMap(null);
      }