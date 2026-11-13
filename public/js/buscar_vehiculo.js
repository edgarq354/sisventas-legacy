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
var merker_tienda;
var map_cont = 0;
var markers2=[];



 

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



function initialize() {
 

    map = new google.maps.Map(document.getElementById('mapa'), {
    zoom: 15,
    center: new google.maps.LatLng(-18.484573, -64.104989),
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


     mapa2 = new google.maps.Map(document.getElementById('mapa2'), {
    zoom: 15,
    center: new google.maps.LatLng(-18.484573, -64.104989),
    mapTypeId: google.maps.MapTypeId.ROADMAP
    });
     var myLatLng = {lat:-18.484573, lng:  -64.104989};
     var location_tienda = {lat:-18.4841 , lng:-64.1041};

  const image = {
    url:
      "https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png",
    // This marker is 20 pixels wide by 32 pixels high.
    size: new google.maps.Size(20, 32),
    // The origin for this image is (0, 0).
    origin: new google.maps.Point(0, 0),
    // The anchor for this image is the base of the flagpole at (0, 32).
    anchor: new google.maps.Point(0, 32)
  };

  const shape = {
    coords: [1, 1, 1, 20, 18, 20, 18, 1],
    type: "poly"
  };
//agregar un marker con una ubicacion en Santa Cruz de la Sierra
       marker2 = new google.maps.Marker({
                  map: mapa2,
                  draggable: true,              
                  //icon: icon,
                  animation: google.maps.Animation.DROP,
                  title:"Marker Comercial",
                  position: myLatLng,                  
              });
       marker_tienda = new google.maps.Marker({
                  map: mapa2,
                  draggable: true,  
                   icon: image,
      // @ts-ignore TODO(jpoehnelt) fix typings
      shape: shape,         
                  //icon: icon,
                  animation: google.maps.Animation.DROP,
                  title:"Tienda",
                  position: location_tienda,                  
              });
            $("input[name='latitud']").val(myLatLng.lat);  
            $("input[name='longitud']").val(myLatLng.lng);  

            $("input[name='latitud_lugar']").val(location_tienda.lat);  
            $("input[name='longitud_lugar']").val(location_tienda.lng); 

               google.maps.event.addListener(marker2, 'dragend', (function(marker) {
                  return function() {
                    $("input[name='latitud']").val(this.getPosition().lat());  
                    $("input[name='longitud']").val(this.getPosition().lng());  
                  }
                })(marker2));

              google.maps.event.addListener(marker_tienda, 'dragend', (function(marker) {
                  return function() {
                    $("input[name='latitud_lugar']").val(this.getPosition().lat());  
                    $("input[name='longitud_lugar']").val(this.getPosition().lng());  
                  }
                })(marker_tienda));


             
//optener direccion por punto
              var geocoder = new google.maps.Geocoder;
              var infowindow = new google.maps.InfoWindow();
              geocoder.geocode({'location': myLatLng}, function(results, status) {
                if (status === 'OK') {
                  if (results[1]) {  
                   var  html = "<b>" + String(results[0].formatted_address )+"<br>";            
                      infowindow.setContent(html);  //COLOCA EL NOMBRE Y APELLIDOA LAS UBICACIONES
                      infowindow.open(mapa2, marker2);  //COLOCA EL NOMBRE Y APELLIDOA LAS UBICACIONES
                  } else {
                  $("#direccion").text('No results found');
                  }
                } else {
                  $("#direccion").text('Geocoder failed due to: ' + status);
                }
              });


                
/*IMPLEMENTADO PARA LO EVENTOS DE CLICK*/
               google.maps.event.addListener(mapa2, 'click', function(event) {
                  addMarker(event.latLng, mapa2);

             
                  //optener direccion por punto
             
              var geocoder = new google.maps.Geocoder;
              var infowindow = new google.maps.InfoWindow();
              geocoder.geocode({'location': event.latLng}, function(results, status) {
                if (status === 'OK') {
                  if (results[1]) {  
                   var  html = "<b>" + String(results[0].formatted_address )+"<br>";            
                      infowindow.setContent(html);  //COLOCA EL NOMBRE Y APELLIDOA LAS UBICACIONES

                  } else {
                  $("#direccion").text('No results found');
                  }
                } else {
                  $("#direccion").text('Geocoder failed due to: ' + status);
                }
              });
                });


               function addMarker(location, mapa2) {
//agregar un marker en el mapa 
              $("input[name='latitud']").val(location.lat());  
              $("input[name='longitud']").val(location.lng());  

                 marker2.setPosition(location); 


//optener direccion por punto 
              var geocoder = new google.maps.Geocoder;
              var infowindow = new google.maps.InfoWindow();
              geocoder.geocode({'location': location}, function(results, status) {
                if (status === 'OK') {
                  if (results[1]) {  
                   var  html = "<b>" + String(results[0].formatted_address )+"<br>";            
                      infowindow.setContent(html);  //COLOCA EL NOMBRE Y APELLIDOA LAS UBICACIONES 
                     
                  } else {
                  $("#direccion").text('No results found');
                  }
                } else {
                  $("#direccion").text('Geocoder failed due to: ' + status);
                }
              });


              }
// FIN DE INICIAR LA APP








        // Create the search box and link it to the UI element.
        var input = document.getElementById('pac-input');
        var searchBox = new google.maps.places.SearchBox(input);
        mapa2.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

        // Bias the SearchBox results towards current map's viewport.
        mapa2.addListener('bounds_changed', function() {
          searchBox.setBounds(mapa2.getBounds());
        });

        var markers2 = [];
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
           // marker2.setMap(null);            
          }
          //});
          
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


              marker2.setPosition(place.geometry.location);
              marker_tienda.setPosition(place.geometry.location);
              marker2.setTitle(place.name);
            $("#latitud").val(place.geometry.location.lat());  
            $("#longitud").val(place.geometry.location.lng());  
            $("#latitud_lugar").val(place.geometry.location.lat());  
            $("#longitud_lugar").val(place.geometry.location.lng());
 
          map_cont++;

                google.maps.event.addListener(marker2, 'dragend', (function(marker) {
                  return function() {
                    $("#latitud").val(this.getPosition().lat());  
                    $("#longitud").val(this.getPosition().lng());  
                  }
                })(marker2));
                
/*IMPLEMENTADO PARA LO EVENTOS DE CLICK*/
               google.maps.event.addListener(mapa2, 'click', function(event) {
                  addMarker(event.latLng, mapa2);
                });

               function addMarker(location, map) {
  // Add the marker at the clicked location, and add the next-available label
  // from the array of alphabetical characters.
              $("#latitud").val(location.lat());  
              $("#longitud").val(location.lng());  

                 marker2.setPosition(location);
              }


             
//FIN DE EVENTO DE AGRAEGAR CLICK

            if (place.geometry.viewport) {
              // Only geocodes have viewport.
              bounds.union(place.geometry.viewport);
            } else {
              bounds.extend(place.geometry.location);
            }
          });
          mapa2.fitBounds(bounds);
        });
   




     

    //set an interval
     tiempo=setInterval(cargar_buscador, 5000);
    cargar_buscador(map);
    //Call the function
 

}


function apuntar_direccion_cliente()
{
 
     var latitud=  $("input[name='latitud']").val();  
     var longitud= $("input[name='longitud']").val();  


    var myLatlng = new google.maps.LatLng(latitud,longitud);

 
    marker2.setPosition(myLatlng);
mapa2.setCenter(new google.maps.LatLng(parseFloat(latitud), parseFloat(longitud)));

}

function apuntar_direccion_tienda()
{
 
     var latitud=  $("input[name='latitud_lugar']").val();  
     var longitud= $("input[name='longitud_lugar']").val();  


    var myLatlng = new google.maps.LatLng(latitud,longitud);

 
    marker_tienda.setPosition(myLatlng);
mapa2.setCenter(new google.maps.LatLng(parseFloat(latitud), parseFloat(longitud)));

}

function apuntar_direccion_usuario(latitud,longitud,indicacion)
{
 
  $("#indicacion").val(indicacion);

   
  var myLatLng = {lat:latitud , lng: longitud};
   
            $("input[name='latitud']").val(myLatLng.lat);  
            $("input[name='longitud']").val(myLatLng.lng);  


    var myLatlng = new google.maps.LatLng(latitud,longitud);

 
    marker2.setPosition(myLatlng);
mapa2.setCenter(new google.maps.LatLng(parseFloat(latitud), parseFloat(longitud)));


  
}


function cargar_buscador(map)
{


  var opcion = $("#buscar_opcion").val();   
    cont = 0;          
                   
    if (opcion == 0) { //NINGUNO
        $("#btn_sel_todos_adm").hide();      
        $('#body_conductor').empty();    
      //  document.getElementById("mapa").innerHTML="";
        $("#btn_not").hide();  
        $("#btn_sel_todos_adm").hide();           
        $("#btn_desel_todos_adm").hide();           
        Esconder_Textos();             
    }
    else{ //CASO CONTRARIO SIGNIFICA Q SELECCIONO UNA DE LAS DEMAS OPCIONES
        Cargar_Mapa_Lista_Adm(0,opcion,map); 
        $("#btn_not").show();   
        $("#btn_sel_todos_adm").show();   
        $("#btn_desel_todos_adm").hide();  

    } 

    mapa_ver_solicitudes();
    mapa_ver_servicios_en_proceso();
    mapa_ver_servicios_concluidos();
}

var cont = 0;
var id_conductor = [];
var token_not = [];


//BUSCAR POR ACTIVOS - INACTIVOS - TODOS - CARRERAS
$("#buscar_opcion").change(function(event){

    clearInterval(tiempo);
   tiempo=setInterval(cargar_buscador, 5000);
    cargar_buscador(map);

    var opcion = $("#buscar_opcion").val();   
    cont = 0;          
    $('#body_conductor').empty();               
    if (opcion == 0) { //NINGUNO
        $("#btn_sel_todos_adm").hide();      
        $('#body_conductor').empty();    
        //document.getElementById("mapa").innerHTML="";
        $("#btn_not").hide();  
        $("#btn_sel_todos_adm").hide();           
        $("#btn_desel_todos_adm").hide();           
        Esconder_Textos();             
    }
    else{ //CASO CONTRARIO SIGNIFICA Q SELECCIONO UNA DE LAS DEMAS OPCIONES
        Cargar_Mapa_Lista_Adm(0,opcion); 
        $("#btn_not").show();   
        $("#btn_sel_todos_adm").show();   
        $("#btn_desel_todos_adm").hide();   
    }  
});










sw=0;//PARA VERIFICAR SI YA EXISTE ESE MOTISTA EN LA LISTA SW = 0 Q NO EXISTE Y SW = 1 Q YA EXISTE EN LA LISTA

//MUESTRA LOS CONDUCTOR DEPENDE A LA OPCION Q SE SELECIONO EN EL COMBOBOX (ACTIVO-INACTIVO-TODOS)
function Cargar_Mapa_Lista_Adm(ver,opcion,mapa) {
  var tabladatos=$("#body_conductor");
  
  var infowindow = new google.maps.InfoWindow();
  var marker, i;
  if ($("#privilegio").val()==0) {
    if (opcion == 1) {
      route = "buscar_activos_conductor_tiempo"; //MOSTOS ACTIVOS      
    } else {
      if (opcion == 2 ) {
        route = "buscar_inactivos_conductor";  //MOTOS INACTIVOS    
      } else {
        if (opcion == 3) {
          route = "buscar_todo_los_conductor_tiempo";  //TODAS LAS MOTOS            
        } else {
          route = "buscar_carrera_conductor";  //LAS MOTOS EN CARRERA
        }
      }
    } 
  } else {
    var id_emp = $("#buscar_empresa").val();    
      if (id_emp == -1) {
            if (opcion == 1) {
              route = "buscar_activos_conductor_tiempo"; //MOSTOS ACTIVOS      
            } else {
              if (opcion == 2 ) {
                route = "buscar_inactivos_conductor";  //MOTOS INACTIVOS    
              } else {
                if (opcion == 3) {
                  route = "buscar_todo_los_conductor_tiempo";  //TODAS LAS MOTOS            
                } else {
                  route = "buscar_carrera_conductor";  //LAS MOTOS EN CARRERA
                }
              }
            } 
      } else {
        if (opcion == 1) {
          route = "buscar_activos_conductor_adm/"+id_emp; //MOSTOS ACTIVOS      
        } else {
          if (opcion == 2 ) {
            route = "buscar_inactivos_conductor_adm/"+id_emp;  //MOTOS INACTIVOS    
          } else {
            if (opcion == 3) {
              route = "buscar_todo_los_conductor_adm/"+id_emp;  //TODAS LAS MOTOS            
            } else {
              route = "buscar_carrera_conductor_adm/"+id_emp;  //LAS MOTOS EN CARRERA
            }
          }
        }        
      }
  }
  $.get(route, function (res) { //CONSULTA DE TODOS LOS MOTISTAS ACTIVOS
    
    deleteMarkers();
    //ELIMINAR LA LISTA DE CONDUCTORES EN PEDIDOS
    var conductor=res.conductor;
    var pedido=res.pedido;

      var i=0;

cant_libre=0;
cant_descanso=0;
cant_en_servicio=0;
cant_suspendido=0; 
cant_moto_libre=0;
cant_moto_descanso=0;
cant_moto_en_servicio=0;
cant_moto_suspendido=0;

try{
  //VER la ubicacion de todos los conductores...
      for ( i = 0; i < conductor.length; i++) {  
        infowindow = new google.maps.InfoWindow();
        marker = new google.maps.Marker({ //SE CREA UN NUEVO MARKER
          map:map,
          position: new google.maps.LatLng(parseFloat(conductor[i].latitud_asignacion), parseFloat(conductor[i].longitud_asignacion)),
          title: String(conductor[i].conductor),
          label:String(conductor[i].numero_movil),
        });
        markers.push(marker);
        

       

          if(conductor[i].moto==0){

                 if(conductor[i].estado_asignacion!=1)
                {
                   marker.setIcon('images/ic_suspendido.png');  //conductor suspendido
                   cant_suspendido++;
                 }else if(conductor[i].estado==0){
                     marker.setIcon('images/inactivo.png');  //Estado ocupado
                     cant_descanso++;
                  }else if(conductor[i].estado==1){
                     marker.setIcon('images/activo.png');  //Estado disponible
                     cant_libre++;
                  }else if(conductor[i].estado==2){
                     marker.setIcon('images/ic_pedido.png');  //Estado en pedido.
                     cant_en_servicio++;
                  }else {
                   marker.setIcon('images/ic_bloqueado.png');  //conductor bloqueado
                  }

          }else{
              if(conductor[i].estado_asignacion!=1)
              {
                 marker.setIcon('images/ic_suspendido_moto.png');  //conductor suspendido
                 cant_moto_suspendido++;
               }else if(conductor[i].estado==0){
                   marker.setIcon('images/inactivo_moto.png');  //Estado ocupado
                 cant_moto_descanso++;
                }else if(conductor[i].estado==1){
                   marker.setIcon('images/activo_moto.png');  //Estado disponible
                   cant_moto_libre++;
                }else if(conductor[i].estado==2){
                   marker.setIcon('images/ic_pedido_moto.png');  //Estado en pedido.
                     cant_moto_en_servicio++;
                }else {
                 marker.setIcon('images/ic_bloqueado_moto.png');  //conductor bloqueado
                }
          }     




        html = "<b>" + String(conductor[i].conductor) + "</b> <br/>" + String(conductor[i].placa+' '+conductor[i].marca);
        infowindow.setContent(html);
       
        
      

        google.maps.event.addListener(marker, 'click', (function(marker, i) {
          return function() {
             
             html = "<table><tr><td>\n\
                        <img src='../public/"+String(conductor[i].direccion_imagen)+"' title='perfil.png' style='height:150px; width:150px;   border-radius: 15px;' >\n\
                      </td>\n\
                      <td style='padding:10px;'>\n\
                        <a class='btn btn-link' href='conductors/"+String(conductor[i].ci)+"'><i class='fa fa-user' aria-hidden='true'></i> <b> "+ String(conductor[i].conductor) +  "</b><i class='fa fa-chevron-right' aria-hidden='true'></i></a>\n\
                        <br>\n\
                        <b># de movil: "+String(conductor[i].numero_movil)+" </b>\n\
                        <br>\n\
                        <b>Placa: </b><a class='btn btn-link' href='vehiculo/"+String(conductor[i].placa)+"/edit'><i class='fa fa-car' aria-hidden='true'></i>" + String(conductor[i].placa)+"<i class='fa fa-chevron-right' aria-hidden='true'></i></a>\n\
                        <br>\n\
                        <b>Marca: </b> "+String(conductor[i].marca)+".\n\
                        <br>\n\
                        <b>Licencia: </b> "+String(conductor[i].categoria_licencia)+".\n\
                        <br>\n\
                        <b>Credito: </b> "+String(conductor[i].credito)+".\n\
                        <br>\n\
                        <b>Ultimo registro: </b> "+String(conductor[i].fecha_ultimo)+".\n\
                        <h3>Hace "+String(conductor[i].minuto)+ " minutos</h3>\n\
                      </td></tr></table>";              

            infowindow.setContent(html);
            infowindow.open(map, marker);
            id_m = conductor[i].ci;
            for (var k = 0; k <= cont; k++) {
              if (!isNaN(parseInt($("#id_conductor"+k).val()))) { //VERIFICO SI EXISTE ESE TEXTO               
                if (parseInt($("#id_conductor"+k).val()) == id_m) {  //SI EXISTE, VERIFICO SI YA SE A DADO CLICK EN ESA UBICACION
                  sw=1; //SW = 1 SIGNIFICA QUE YA EXISTE ENTONCE SE ELIMINARA
                  break; //SE TERMINA EL FOR
                } 
              } 
            }
            if (sw == 0) {  //SW = 0 SIGNIFICA Q NO EXISTE Y SE AGREGA A LA LISTA
                                                                                         
            } 
            else {// CASO CONTRARIO SIGNIFICA Q YA EXISTE Y LO ELIMINA DE LA LISTA
              eliminar_lista(k);
              sw=0;  
            //  marker.setIcon(''); //PARA Q VUELVA AL ICONO ORIGINAL                                                                                                                                                              
            }
          }
        })(marker, i));
      } 



$("#lb_cantidad_libre").text(cant_libre);
$("#lb_cantidad_descanso").text(cant_descanso);
$("#lb_cantidad_en_servicio").text(cant_en_servicio);
$("#lb_cantidad_suspendido").text(cant_suspendido);
$("#lb_cantidad_moto_libre").text(cant_moto_libre);
$("#lb_cantidad_moto_descanso").text(cant_moto_descanso);
$("#lb_cantidad_moto_en_servicio").text(cant_moto_en_servicio);
$("#lb_cantidad_moto_suspendido").text(cant_moto_suspendido);

      var sw_uno=0;
      for ( i = 0; i < pedido.length; i++) {            
        
        if (sw_uno==0) {
        // map.setCenter(new google.maps.LatLng(parseFloat(pedido[i].latitud), parseFloat(pedido[i].longitud)));

          sw_uno=1;
        }

     

        infowindow = new google.maps.InfoWindow();       
              nombre_emp = String(pedido[i].conductor);
               
              marker = new google.maps.Marker({
                position: new google.maps.LatLng(parseFloat(pedido[i].latitud), parseFloat(pedido[i].longitud)),
                map: map,
              }); 
              markers.push(marker);
      

 
 
 
                    
                   marker.setIcon('images/solicitud.png');  //conductor bloqueado
               
  

              html = "<b>" + String(pedido[i].nombre) + "</b> <br/>" + String(pedido[i].apellido)+"<br>";            
              infowindow.setContent(html);  //COLOCA EL NOMBRE Y APELLIDOA LAS UBICACIONES
              infowindow.open(map, marker);  //COLOCA EL NOMBRE Y APELLIDOA LAS UBICACIONES

 
            var clase="";
              if( pedido[i].clase_vehiculo==1){
                clase="MOVIL NORMAL";
              }
              else if(pedido[i].clase_vehiculo==2){
                clase="DE LUJO";
              }
              
              else if(pedido[i].clase_vehiculo==3){
                clase="CON AIRE";
              }
              else if(pedido[i].clase_vehiculo==4){
                clase="CON MALETERO";
              }
              else if(pedido[i].clase_vehiculo==5){
                clase="PEDIDO";
              } 
              else if(pedido[i].clase_vehiculo==6){
                clase="RESERVA";
              }
              else if(pedido[i].clase_vehiculo==7){
                clase="MOTO";
              }
              else if(pedido[i].clase_vehiculo==8){
                clase="MOTO PEDIDO";
              }
              else if(pedido[i].clase_vehiculo==9){
                clase="CON PARRILLA";
              }
              else if(pedido[i].clase_vehiculo==10){
                clase="TORITO";
              }

            var estado_empresa="NEGATIVO";
            if(pedido[i].estado_pago_empresa==1){
              estado_empresa="ACTIVO";
            }  
        
        var tablapedido=$('#body_ver_solicitudes');
         $('#body_ver_solicitudes').empty(); 
          

          tablapedido.append('<tr id="fila'+pedido[i].id+'">\n\
          <td  align="left"><b> '+String(pedido[i].id) + ' </b>  </td>\n\
          <td  align="left"><b> '+String(pedido[i].nombre)+' ' + String(pedido[i].apellido) + ' </b>  </td>\n\
          <td>'+pedido[i].celular+'</td>\n\
          <td>'+pedido[i].correo+'</td>\n\
          <td>'+pedido[i].direccion_inicio+'</td>\n\
          <td>'+pedido[i].direccion+'</td> \n\
          <td>'+clase+'  </td>\n\
          <td>'+estado_empresa+'</td>\n\
          <td><div class="btn-group">\n\
          <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">\n\
                              Opción <span class="caret"></span>\n\
                            </button>\n\
                            <ul class="dropdown-menu" role="menu">\n\
                                <li>\n\
                                  <a class="fa fa-key" href="" onclick="mover_camara('+pedido[i].latitud+','+pedido[i].longitud+');">Ver ubicación</a>\n\
                                </li>\n\
                                <li>\n\
                                 <a class="fa fa-car" href=""  data-toggle="modal" data-target="#ModalAsignar" aria-hidden="true"  onclick="cargar_usuario_id('+pedido[i].id+','+pedido[i].clase_vehiculo+','+pedido[i].latitud+','+pedido[i].longitud+');"> Asignar conductor</a>\n\
                                </li>\n\
                                </ul>\n\
                                </div>\n\
                                </td>\n\
          </tr>');   
    
              
          }
    }catch(error)
    {
      document.location.reload();
    }

  });   
}


//ELIMINAR FILA CUANDO DA CLICK EN EL MAPA
function eliminar_lista(index){
   id_conductor[index]=0;
   $('#fila'+index).remove();
}

function Seleccionar_Todos(){
  var opcion = $("#buscar_opcion").val();
  cont=0;  
  if (opcion == 0) { //NINGUNO
    $('#body_conductor').empty(); 

    //document.getElementById("mapa").innerHTML="";
    $("#btn_sel_todos_adm").hide();
  } else{ // CASO CONTRARIO SELECCIONO OTRAS OPCIONES
      Cargar_Mapa_Lista_Adm(1,opcion);  
      $("#btn_sel_todos_adm").hide();   
      $("#btn_desel_todos_adm").show();            
  }    
}

function Deseleccionar_Todos(){
  var opcion = $("#buscar_opcion").val();
  cont=0;  
  if (opcion == 0) { //NINGUNO
    $('#body_conductor').empty();    
   // document.getElementById("mapa").innerHTML="";
    $("#btn_sel_todos_adm").hide();
  } else{ // CASO CONTRARIO SELECCIONO OTRAS OPCIONES
      Cargar_Mapa_Lista_Adm(0,opcion);  
      //Cargar_Tabla_Lista_Adm(opcion);   
      $("#btn_desel_todos_adm").hide();   
      $("#btn_sel_todos_adm").show();  
      cont=0;      
      $('#body_conductor').empty();          
  }    
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


/////////------------ VER SOLICITUDES -------------////////////
function ver_solicitudes()
 {
  $("#div_ver_solicitudes").show();
  $("#div_ver_servicios_en_proceso").hide();
  $("#div_ver_servicios_concluidos").hide();
   sw_solicitudes=true;
   sw_servicios_en_proceso=false;
   sw_servicios_concluidos=false;

   mapa_ver_solicitudes();

 }
 


 /////////------------ VER SERVICIOS EN PROCESO -------------////////////
function ver_servicios_en_proceso()
 {
   $("#div_ver_solicitudes").hide();
  $("#div_ver_servicios_en_proceso").show();
  $("#div_ver_servicios_concluidos").hide();
   sw_solicitudes=false;
   sw_servicios_en_proceso=true;
   sw_servicios_concluidos=false;

   mapa_ver_servicios_en_proceso();

 }




 /////////------------ VER SERVICIOS CONCLUIDOS -------------////////////
function ver_servicios_concluidos()
 {
   $("#div_ver_solicitudes").hide();
  $("#div_ver_servicios_en_proceso").hide();
  $("#div_ver_servicios_concluidos").show();
   sw_solicitudes=false;
   sw_servicios_en_proceso=false;
   sw_servicios_concluidos=true;

    mapa_ver_servicios_concluidos();

 }

function ver_ocultar_pasajero(sw){
if(sw==0){
   $("#Modal_nuevo_pasajero").hide();
 }else{
   $("#Modal_nuevo_pasajero").show();

 } 

 } 


 function mapa_ver_solicitudes()
 {

    var tablapedido=$('#body_ver_solicitudes');
  if(sw_solicitudes==true){
  
 
         
      $.get("ver_solicitudes", function (res) { 
      $('#body_ver_solicitudes').empty();   
   


var sw_uno=0;
      $(res).each(function (key, value) {            
        
        if (sw_uno==0) {
        // map.setCenter(new google.maps.LatLng(parseFloat(value.latitud), parseFloat(value.longitud)));

          sw_uno=1;
        }

     

        infowindow = new google.maps.InfoWindow();       
              nombre_emp = String(value.conductor);
               
              marker = new google.maps.Marker({
                position: new google.maps.LatLng(parseFloat(value.latitud), parseFloat(value.longitud)),
                map: map,
              }); 
              markers.push(marker);
      

 
 
 
                    
                   marker.setIcon('images/solicitud.png');  //conductor bloqueado
               
  

              html = "<b>" + String(value.nombre) + "</b> <br/>" + String(value.apellido)+"<br>";            
              infowindow.setContent(html);  //COLOCA EL NOMBRE Y APELLIDOA LAS UBICACIONES
              infowindow.open(map, marker);  //COLOCA EL NOMBRE Y APELLIDOA LAS UBICACIONES

            var clase="";
              if( value.clase_vehiculo==1){
                clase="MOVIL NORMAL";
              }
              else if(value.clase_vehiculo==2){
                clase="DE LUJO";
              }
              
              else if(value.clase_vehiculo==3){
                clase="CON AIRE";
              }
              else if(value.clase_vehiculo==4){
                clase="CON MALETERO";
              }
              else if(value.clase_vehiculo==5){
                clase="PEDIDO";
              } 
              else if(value.clase_vehiculo==6){
                clase="RESERVA";
              }
              else if(value.clase_vehiculo==7){
                clase="MOTO";
              }
              else if(value.clase_vehiculo==7){
                clase="MOTO PEDIDO";
              }

            var estado_empresa="NEGATIVO";
            if(value.estado_pago_empresa==1){
              estado_empresa="ACTIVO";
            }   

            pedido_taxi();           
         tablapedido.append('<tr id="fila'+value.id+'">\n\
          <td  align="left"><b> '+String(value.id) + ' </b>  </td>\n\
          <td  align="left"><b> '+String(value.nombre)+' ' + String(value.apellido) + ' </b>  </td>\n\
          <td>'+value.celular+'</td>\n\
          <td>'+value.correo+'</td>\n\
          <td>'+value.direccion_inicio+'</td>\n\
          <td>'+value.direccion+'</td> \n\
          <td>'+clase+'  </td>\n\
          <td>'+estado_empresa+'</td>\n\
          <td><div class="btn-group">\n\
          <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">\n\
                              Opción <span class="caret"></span>\n\
                            </button>\n\
                            <ul class="dropdown-menu" role="menu">\n\
                                <li>\n\
                                  <a class="fa fa-key" href="" onclick="mover_camara('+value.latitud+','+value.longitud+');">Ver ubicación</a>\n\
                                </li>\n\
                                <li>\n\
                                 <a class="fa fa-car" href=""  data-toggle="modal" data-target="#ModalAsignar" aria-hidden="true"  onclick="cargar_usuario_id('+value.id+','+value.clase_vehiculo+','+value.latitud+','+value.longitud+');"> Asignar conductor</a>\n\
                                </li>\n\
                                </ul>\n\
                                </div>\n\
                                </td>\n\
          </tr>');   

            
              
          });
        });            
    }
 
 }


function pedido_taxi(){
  
    // var audio = new Audio('sonido/pedir_taxi.mp3');
//      audio.play();
    
}
 function mapa_ver_servicios_en_proceso()
 {


    var tablapedido=$('#body_ver_servicios_en_proceso');
  if(sw_servicios_en_proceso==true){
  
 
         
      $.get("ver_servicios_en_proceso", function (res) { 
      $('#body_ver_servicios_en_proceso').empty();                   
      $(res).each(function (key, value) {            
        
           

        infowindow = new google.maps.InfoWindow();       
              nombre_emp = String(value.conductor);
              
              deleteMarkers();
              marker = new google.maps.Marker({
                position: new google.maps.LatLng(parseFloat(value.latitud), parseFloat(value.longitud)),
                map: map,
                label:String(value.numero_movil),
              }); 
              markers.push(marker);
      

 
 
 
                    
                   marker.setIcon('images/ic_pedido.png');  //conductor bloqueado
               
  

              html = "<b>" + String(value.conductor) + "</b> <br/>" + String(value.numero_movil)+"<br>";            
              infowindow.setContent(html);  //COLOCA EL NOMBRE Y APELLIDOA LAS UBICACIONES
              infowindow.open(map, marker);  //COLOCA EL NOMBRE Y APELLIDOA LAS UBICACIONES

 
            var clase="";
              if( value.clase_vehiculo==1){
                clase="MOVIL NORMAL";
              }
              else if(value.clase_vehiculo==2){
                clase="DE LUJO";
              }
              
              else if(value.clase_vehiculo==3){
                clase="CON AIRE";
              }
              else if(value.clase_vehiculo==4){
                clase="CON MALETERO";
              }
              else if(value.clase_vehiculo==5){
                clase="PEDIDO";
              } 
              else if(value.clase_vehiculo==6){
                clase="RESERVA";
              }
              else if(value.clase_vehiculo==7){
                clase="MOTO";
              }
              else if(value.clase_vehiculo==7){
                clase="MOTO PEDIDO";
              }

            var estado_empresa="NEGATIVO";
            if(value.estado_pago_empresa==1){
              estado_empresa="ACTIVO";
            }   

                      
         tablapedido.append('<tr id="fila'+value.id+'">\n\
          <td  align="left"><b> '+String(value.id) + ' </b>  </td>\n\
          <td  align="left"><b> '+String(value.numero_movil) + ' </b>  </td>\n\
          <td  align="left"><b> '+String(value.conductor)  + ' </b>  </td>\n\
          <td>'+value.celular_conductor+'</td>\n\
          <td>'+value.marca+'</td>\n\
          <td>'+value.id_vehiculo+'</td>\n\
          <td>'+value.color+'</td>\n\
          <td>'+value.pasajero+'</td>\n\
          <td>'+value.celular_pasajero+'</td>\n\
          <td>'+value.direccion_inicio+'</td>\n\
          <td>'+value.direccion+' </td> \n\
          <td> '+clase+'<a class="fa fa-location-arrow btn btn-success" target="_BLANK"  aria-hidden="true"  href="ver_detalle_pedido_por_id/'+value.id+'"></a>  \n\
          </td>\n\
          </tr>');   
 
           });
        });            
    }
 
  
 }

 function mapa_ver_servicios_concluidos()
 {

  
    var tablapedido=$('#body_ver_servicios_concluidos');
  if(sw_servicios_concluidos==true){
  
 
         
      $.get("ver_servicios_concluidos", function (res) { 
      $('#body_ver_servicios_concluidos').empty();                   
      $(res).each(function (key, value) {            
        
 
              
 
            var clase="";
              if( value.clase_vehiculo==1){
                clase="MOVIL NORMAL";
              }
              else if(value.clase_vehiculo==2){
                clase="DE LUJO";
              }
              
              else if(value.clase_vehiculo==3){
                clase="CON AIRE";
              }
              else if(value.clase_vehiculo==4){
                clase="CON MALETERO";
              }
              else if(value.clase_vehiculo==5){
                clase="PEDIDO";
              } 
              else if(value.clase_vehiculo==6){
                clase="RESERVA";
              }
              else if(value.clase_vehiculo==7){
                clase="MOTO";
              }
              else if(value.clase_vehiculo==7){
                clase="MOTO PEDIDO";
              }

            var estado_empresa="NEGATIVO";
            if(value.estado_pago_empresa==1){
              estado_empresa="ACTIVO";
            }              
         tablapedido.append('<tr >\n\
          <td  align="left"><b> '+String(value.id) + ' </b>  </td>\n\
          <td  align="left"><b> '+String(value.numero_movil) + ' </b>  </td>\n\
          <td  align="left"><b> '+String(value.conductor) + ' </b>  </td>\n\
          <td  align="left"><b> '+String(value.pasajero) + ' </b>  </td>\n\
          <td>'+value.fecha_pedido+'</td>\n\
          <td>'+value.monto_conductor+' Bs.</td>\n\
          <td>'+clase+'  </td>\n\
          <td>'+value.direccion_inicio+'</td>\n\
          <td>'+value.direccion+'</td> \n\
          <td><a class="fa fa-eye btn btn-success" target="_BLANK"  aria-hidden="true"  href="ver_detalle_pedido_por_id/'+value.id+'"></a></td>\n\
          </tr>');   

              
          });
        });            
    }

 
 }


    function mover_camara(latitud_p,longitud_p)
    {
      var lat_p=parseFloat(latitud_p);
      var lon_p=parseFloat(longitud_p);
      map.setCenter(new google.maps.LatLng(lat_p, lon_p));
    }
