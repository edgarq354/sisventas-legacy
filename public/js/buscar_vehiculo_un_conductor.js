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
  
 

    map = new google.maps.Map(document.getElementById('mapa'), {
    zoom: 14,
    center: new google.maps.LatLng(-17.7646878,-63.1155947),
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
 

}




var cont = 0;
var id_conductor = [];
var token_not = [];


//BUSQUEDA INDIVUAL DE UN SOLO CONDUCTOR
$("#buscar_un_conductor").change(function(event){
var centro;
 var ci = $("#buscar_un_conductor").val();
    $("#btn_sel_todos").hide(); 
    if (ci == "") {
        $('#body_conductor').empty();    
       // document.getElementById("mapa").innerHTML="";
        $("#btn_not").hide();   
        $("#btn_desel_todos_adm").hide();   
        $("#btn_sel_todos_adm").hide();   
        Esconder_Textos();                                              
    } else {
      $("#btn_not").show(); 
      $("#btn_desel_todos_adm").hide();        
      $("#btn_sel_todos_adm").hide();        
      $.get("buscar_un_conductor/"+ci, function (res) { 
      $('#body_conductor').empty();                   
      $(res).each(function (key, value) {            
        
         map = new google.maps.Map(document.getElementById('mapa'), {
          zoom: 14,
          center: new google.maps.LatLng(parseFloat(value.latitud_asignacion), parseFloat(value.longitud_asignacion)),
          mapTypeId: google.maps.MapTypeId.ROADMAP
          });

         centro=new google.maps.LatLng(parseFloat(value.latitud_asignacion), parseFloat(value.longitud_asignacion));

        infowindow = new google.maps.InfoWindow();       
              nombre_emp = String(value.conductor);
              
              deleteMarkers();
              marker = new google.maps.Marker({
                position: new google.maps.LatLng(parseFloat(value.latitud_asignacion), parseFloat(value.longitud_asignacion)),
                map: map,
              }); 
              markers.push(marker);
      

            if(value.panico==1){
               marker.setIcon('images/ic_panico.png');  //en panico
            }else if(value.bloqueo==1){
               marker.setIcon('images/ic_bloqueado.png');  //conductor bloqueado
            }else if(value.estado==0)
            {
               marker.setIcon('images/ic_suspendido.png');  //conductor suspendido
            }else if(value.estado==1){
              if(value.estado_conductor==0){
                 marker.setIcon('images/inactivo.png');  //Estado ocupado
              }else if(value.estado_conductor==1){
                 marker.setIcon('images/activo.png');  //Estado disponible
              }else if(value.estado_conductor==2){
                 marker.setIcon('images/ic_pedido.png');  //Estado en pedido.
              }

            }else {
               marker.setIcon('images/ic_bloqueado.png');  //conductor bloqueado
            }


              html = "<b>" + String(value.conductor) + "</b> <br/>" + String(value.placa+' '+value.marca)+"<br>"+String(value.fecha_ultimo);            
              infowindow.setContent(html);  //COLOCA EL NOMBRE Y APELLIDOA LAS UBICACIONES
              infowindow.open(map, marker);  //COLOCA EL NOMBRE Y APELLIDOA LAS UBICACIONES
              

              tabladatos=$("#body_conductor");    
              if ($("#privilegio").val()!=0) {//CUANDO ES DISTINTO A CERO SIGNIFICA Q ES UN ADMINISTRADOR O ADMINISTRATIVO Y PUEDE VER DE Q EMPRESA ES EL OCNDUCTOR
                tabladatos.append('<tr><td><img src="../public/'+String(value.direccion_imagen)+'" title="perfil.png" style="height:150px; width:150px;   border-radius: 15px;" ></td> <td> <input name="id_conductor[]" id="id_conductor0" value='+value.ci+' type="hidden" size=3>\n\
                '+value.ci+' '+value.expedido+'</td><td>'+value.conductor+'</td><td>'+value.placa+'</td><td>'+value.marca+'</td><td>'+value.clase+'</td><td>'+value.celular+' <br><input type="hidden" name="token_not[]" id="token_not0"  value="'+value.token+'"></td><td>'+value.razon_social+'</td></tr>');                                            
              } else { //EN ESTE CASO ES CUANDO ES UNA EMPRESA POR LO TANTO NO SE CREA EL <TD> EMPRESA
                tabladatos.append('<tr> <td><img src="../public/'+String(value.direccion_imagen)+'" title="perfil.png" style="height:150px; width:150px;   border-radius: 15px;" ></td><td> <input name="id_conductor[]" id="id_conductor0" value='+value.ci+' type="hidden" size=3>\n\
                '+value.ci+' '+value.expedido+'</td><td>'+value.conductor+'</td><td>'+value.placa+'</td><td>'+value.marca+'</td><td>'+value.clase+'</td><td>'+value.celular+' <br><input type="hidden" name="token_not[]" id="token_not0"  value="'+value.token+'"></td></tr>');                                            
              }


                               
              
          });
        });       


    }




    
   tiempo=setInterval(function ()
{
   var ci = $("#buscar_un_conductor").val();
   var marker;
     
      $.get("buscar_un_conductor/"+ci, function (res) { 
 eliminar_lista(0);
   deleteMarkers();
for (var i = 0; i < 1; i++) {  
        infowindow = new google.maps.InfoWindow();
        marker = new google.maps.Marker({ //SE CREA UN NUEVO MARKER
          map:map,
          position: new google.maps.LatLng(parseFloat(res[i].latitud_asignacion), parseFloat(res[i].longitud_asignacion)),
          title: String(res[i].conductor)
        });
        markers.push(marker);
        /*if (ver == 1) { //SI ES UNO SIGNIFICA Q SELCCIONE Q MIESTRE TODOS Y EL ICONO CAMBIA DE IMAGEN
          marker.setIcon('images/notificacion.png');  //AQUI SE PONE LA IMAGEN                                                                                     
        }*/

        if(res[i].panico==1){
               marker.setIcon('images/ic_panico.png');  //en panico
            }else if(res[i].bloqueo==1){
               marker.setIcon('images/ic_bloqueado.png');  //conductor bloqueado
            }else if(res[i].estado==0)
            {
               marker.setIcon('images/ic_suspendido.png');  //conductor suspendido
            }else if(res[i].estado==1){
              if(res[i].estado_conductor==0){
                 marker.setIcon('images/inactivo.png');  //Estado ocupado
              }else if(res[i].estado_conductor==1){
                 marker.setIcon('images/activo.png');  //Estado disponible
              }else if(res[i].estado_conductor==2){
                 marker.setIcon('images/ic_pedido.png');  //Estado en pedido.
              }

            }else {
               marker.setIcon('images/ic_bloqueado.png');  //conductor bloqueado
            }


        
              html = "<b>" + String(res[i].conductor) + "</b> <br/>" + String(res[i].placa+' '+res[i].marca)+"<br>"+String(res[i].fecha_ultimo);            
              infowindow.setContent(html);  //COLOCA EL NOMBRE Y APELLIDOA LAS UBICACIONES
              infowindow.open(map, marker);  //COLOCA EL NOMBRE Y APELLIDOA LAS UBICACIONES
      } 






        });            
    
  }, 10000);
   

   
});






sw=0;//PARA VERIFICAR SI YA EXISTE ESE MOTISTA EN LA LISTA SW = 0 Q NO EXISTE Y SW = 1 Q YA EXISTE EN LA LISTA

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
      Cargar_Tabla_Lista_Adm(opcion);   
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

//CARGA LA TABLA DONDE ESTAN LOS TOKEN
function Cargar_Tabla_Lista_Adm(opcion){
  var tabladatos=$("#body_conductor"); 
  if ($("#privilegio").val()==0) {
    if (opcion == 1) {
      route = "buscar_activos_conductor"; //MOSTOS ACTIVOS      
    } else {
      if (opcion == 2 ) {
        route = "buscar_inactivos_conductor";  //MOTOS INACTIVOS    
      } else {
        if (opcion == 3) {
          route = "buscar_todo_los_conductor";  //TODAS LAS MOTOS            
        } else {
          route = "buscar_carrera_conductor";  //LAS MOTOS EN CARRERA
        }
      }
    } 
  } else {
    var id_emp = $("#buscar_empresa").val();  
      if (id_emp == -1) {
            if (opcion == 1) {
              route = "buscar_activos_conductor"; //MOSTOS ACTIVOS      
            } else {
              if (opcion == 2 ) {
                route = "buscar_inactivos_conductor";  //MOTOS INACTIVOS    
              } else {
                if (opcion == 3) {
                  route = "buscar_todo_los_conductor";  //TODAS LAS MOTOS            
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
  $.get(route, function (res) {
    $('#body_conductor').empty();               
    $(res).each(function (key, value) { 
      if ($("#privilegio").val()!=0) {  //CUANDO ES DISTINTO A CERO SIGNIFICA Q ES UN ADMINISTRADOR O ADMINISTRATIVO Y PUEDE VER DE Q EMPRESA ES EL OCNDUCTOR
        tabladatos.append('<tr id="fila'+cont+'"> <td><img src="../public/'+String(value.direccion_imagen)+'" title="perfil.png" style="height:150px; width:150px;   border-radius: 15px;" ></td>  <td> <input name="id_conductor[]" id="id_conductor'+cont+'" value='+value.ci+' type=hidden size=2>\n\
                '+value.ci+' '+value.expedido+'</td><td>'+value.conductor+'</td><td>'+value.placa+'</td><td>'+value.marca+'</td><td>'+value.clase+'</td><td>'+value.celular+' <br><input type="hidden" name="token_not[]" id="token_not'+cont+'"  value="'+value.token+'"></td><td>'+value.razon_social+'</td></tr>');              
                cont++;      
      } else { //EN ESTE CASO ES CUANDO ES UNA EMPRESA POR LO TANTO NO SE CREA EL <TD> EMPRESA
        tabladatos.append('<tr id="fila'+cont+'"><td><img src="../public/'+String(value.direccion_imagen)+'" title="perfil.png" style="height:150px; width:150px;   border-radius: 15px;" ></td>   <td> <input name="id_conductor[]" id="id_conductor'+cont+'" value='+value.ci+' type=hidden size=2>\n\
                '+value.ci+' '+value.expedido+'</td><td>'+value.conductor+'</td><td>'+value.placa+'</td><td>'+value.marca+'</td><td>'+value.clase+'</td><td>'+value.celular+' <br><input type="hidden" name="token_not[]" id="token_not'+cont+'"  value="'+value.token+'"></td></tr>');              
                cont++;      
      }       
    });
    $("#btn_desel_todos_adm").show();                
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