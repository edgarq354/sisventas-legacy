$(document).ready(function(){
  if ($("input[name=privilegio]").val() == "0") {
    $("#div_buscar_opcion").show();
  }
});

//INICIACION DEL MAPA
//BUSCAR POR ACTIVOS - INACTIVOS - TODOS - CARRERAS
$( window ).load(function(event){
 initialize();
 
});

$(document).ready(function(){
   
});

 

var map;
var markers=[];
var tiempo="";

function initialize() {

  $.get("ubicacion_empresa", function (res) {

    map = new google.maps.Map(document.getElementById('mapa'), {
    zoom: 14,
    center: new google.maps.LatLng(res[0].latitud, res[0].longitud),
    mapTypeId: google.maps.MapTypeId.ROADMAP
    });

     

    //set an interval
     tiempo=setInterval(cargar_buscador, 15000);
    cargar_buscador(map);
    //Call the function

    });

}
function cargar_buscador(map)
{
  var opcion = $("#buscar_opcion").val();   
             
      //CASO CONTRARIO SIGNIFICA Q SELECCIONO UNA DE LAS DEMAS OPCIONES
        Cargar_Mapa_Lista_Adm(0,opcion,map);   
 
}
//FIN DE LA INICIALIZACION DEL MAPA

var cont = 0;
var id_conductor = [];
var token_not = [];

sw=0;//PARA VERIFICAR SI YA EXISTE ESE MOTISTA EN LA LISTA SW = 0 Q NO EXISTE Y SW = 1 Q YA EXISTE EN LA LISTA

//MUESTRA LOS CONDUCTOR DEPENDE A LA OPCION Q SE SELECIONO EN EL COMBOBOX (ACTIVO-INACTIVO-TODOS)
function Cargar_Mapa_Lista_Adm(ver,opcion,mapa) {
 
  
  var infowindow = new google.maps.InfoWindow();
  var marker, i;

  var fecha_inicio=$("#fecha_inicio").val();
  var fecha_fin=$("#fecha_fin").val();
  var opcion=parseInt($("#opcion").val());

    route = "puntos_de_solicitud/"+fecha_inicio+"/"+fecha_fin+"/"+opcion; //MOSTOS ACTIVOS      
  
      
  
  $.get(route, function (res) { //CONSULTA DE TODOS LOS MOTISTAS ACTIVOS
    
    var conductor=res.conductor;

    deleteMarkers();
    var i=0;
  //VER la ubicacion de todos los conductores...
      for ( i = 0; i < conductor.length; i++) {  
        infowindow = new google.maps.InfoWindow();
        marker = new google.maps.Marker({ //SE CREA UN NUEVO MARKER
          map:map,
          position: new google.maps.LatLng(parseFloat(conductor[i].latitud ), parseFloat(conductor[i].longitud )),
          title: String(conductor[i].conductor)
        });
        if(conductor[i].estado==2){
          marker.setIcon('images/pedido_finalizado.png');  
        }else if(conductor[i].estado>=4)
        {
          marker.setIcon('images/cancelado.png');  
        }else if(conductor[i].estado==0){
        marker.setIcon('images/sin_aceptar.png');  
        }else{
          marker.setIcon('images/sin_aceptar.png');  
        }
        

        markers.push(marker);
          
        html = "<b>" + String(conductor[i].fecha_pedido) + "</b> <br/>" + String(conductor[i].estado);
        infowindow.setContent(html);
        
      }

      var markerCluster = new MarkerClusterer(map, markers,
            {imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'});
   


      
  
  }); 
 
  
}


function Esconder_Textos(){
  $("#titulo_msn").val("");
  $("#detalle_msn").val("");
  $("#notificacion").hide();
}
//ENVIAR NOTIFICACION
function Mostrar_Textos(){         
  $("#notificacion").show();
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