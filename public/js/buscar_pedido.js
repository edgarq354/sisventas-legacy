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

function pedido_taxi(){
  
     var audio = new Audio('sonido/pedir_taxi.ogg');
      audio.play();
    
}

var map;
var markers=[];
var marker_pedidos=[];
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
    cont = 0;          
    $('#body_conductor').empty();               
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
}
//FIN DE LA INICIALIZACION DEL MAPA

var cont = 0;
var sw_pedido=0;
var id_conductor = [];
var token_not = [];

sw=0;//PARA VERIFICAR SI YA EXISTE ESE MOTISTA EN LA LISTA SW = 0 Q NO EXISTE Y SW = 1 Q YA EXISTE EN LA LISTA

//MUESTRA LOS CONDUCTOR DEPENDE A LA OPCION Q SE SELECIONO EN EL COMBOBOX (ACTIVO-INACTIVO-TODOS)
function Cargar_Mapa_Lista_Adm(ver,opcion,mapa) {
  var tabladatos=$("#body_conductor");
  
  var infowindow = new google.maps.InfoWindow();
  var marker, i;

      route = "buscar_todos_pedidos"; //MOSTOS ACTIVOS      
  
      
  
  $.get(route, function (res) { //CONSULTA DE TODOS LOS MOTISTAS ACTIVOS
    
    var conductor=res.conductor;
    var pedido=res.pedido;

    deleteMarkers();
    var i=0;
  //VER la ubicacion de todos los conductores...
      for ( i = 0; i < conductor.length; i++) {  
        infowindow = new google.maps.InfoWindow();
        marker = new google.maps.Marker({ //SE CREA UN NUEVO MARKER
          map:map,
          position: new google.maps.LatLng(parseFloat(conductor[i].latitud_asignacion), parseFloat(conductor[i].longitud_asignacion)),
          title: String(conductor[i].conductor)
        });

    


 

        markers.push(marker);
        
       if(conductor[i].estado==1){
                 marker.setIcon('images/activo.png');  //Estado disponible
              }


        html = "<b>" + String(conductor[i].conductor) + "</b> <br/>" + String(conductor[i].placa+' '+conductor[i].marca);
        infowindow.setContent(html);
       
        google.maps.event.addListener(marker, 'click', (function(marker, i) {
          return function() {
            html = "<center><img src='../public/"+String(conductor[i].direccion_imagen)+"' title='perfil.png' style='height:150px; width:150px;   border-radius: 15px;' ></center><br><a class='btn btn-link' href='conductors/"+String(conductor[i].ci)+"'><i class='fa fa-user' aria-hidden='true'></i> <b>" + String(conductor[i].conductor) + " </b> <i class='fa fa-chevron-right' aria-hidden='true'></i></a> </br><a class='btn btn-link' href='vehiculo/"+String(conductor[i].placa)+"/edit'><i class='fa fa-car' aria-hidden='true'></i>" + String(conductor[i].placa+' '+conductor[i].marca+' '+"<i class='fa fa-chevron-right' aria-hidden='true'></i></a>"+"<br>"+String(conductor[i].fecha_ultimo));            
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
        } )(marker, i));




      } 


        var markerCluster = new MarkerClusterer(map, markers,
            {imagePath: 'images/m1.png'});
    


sw_pedido=pedido.length;
if(sw_pedido>0){
    pedido_taxi();
  }  
  //LISTA DE los pedidos
      for ( i = 0; i < pedido.length; i++) {  
        infowindow = new google.maps.InfoWindow();
        marker = new google.maps.Marker({ //SE CREA UN NUEVO MARKER
          map:map,
          position: new google.maps.LatLng(parseFloat(pedido[i].latitud_asignacion), parseFloat(pedido[i].longitud_asignacion)),
          title: String(pedido[i].nombre)
        });


        markers.push(marker);
        
       if(conductor[i].estado==1){
                 marker.setIcon('images/ic_pedido_us.png');  //Estado disponible
              }
              infowindow.setContent(html);


        html = "<center><img src='../public/"+String(pedido[i].direccion_imagen)+"' title='perfil.png' style='height:150px; width:150px;   border-radius: 15px;' ></center><br><b>" + String(pedido[i].nombre+" "+pedido[i].apellido) + " </b> </br>"+pedido[i].direccion+"<br>"+pedido[i].mensaje+"<br><b>"+pedido[i].numero_casa+"</b>";            
            infowindow.setContent(html);
            infowindow.open(map, marker);
           
          
       
      }

        


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