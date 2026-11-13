
var cont = 0;
var id_empresa = [];
var token_not = [];
var map;
var markers=[];




$( window ).load(function(event){
 initialize();
 
});

function initialize() {

    map = new google.maps.Map(document.getElementById('mapa'), {
    zoom: 14,
    center: new google.maps.LatLng(-16.5205361, -68.1615534),
    mapTypeId: google.maps.MapTypeId.ROADMAP
    });
    mostrar_empresas();
}

function mostrar_empresas()
{
   var id = $("#buscar_empresa").val();
    if (id == "") {
        $('#body_empresa').empty();    
        //document.getElementById("mapa").innerHTML="";
        $("#btn_not").hide();   
        Esconder_Textos();  
        $("#div_buscar_opcion").hide(); 
    } else {
        Cargar_Mapa_Lista_Adm(0,id); 
        $("#btn_not").show();   
        $("#btn_sel_todos_adm").show();   
        $("#btn_desel_todos_adm").hide();                       
    }
}

//BUSQUEDA EMPRESA
$("#buscar_empresa").change(function(event){
    var id = $("#buscar_empresa").val();
    if (id == "") {
        $('#body_empresa').empty();    
        //document.getElementById("mapa").innerHTML="";
        $("#btn_not").hide();   
        Esconder_Textos();  
        $("#div_buscar_opcion").hide(); 
    } else {
        Cargar_Mapa_Lista_Adm(0,id); 
        $("#btn_not").show();   
        $("#btn_sel_todos_adm").show();   
        $("#btn_desel_todos_adm").hide();                       
    }
});

sw=0;//PARA VERIFICAR SI YA EXISTE ESE MOTISTA EN LA LISTA SW = 0 Q NO EXISTE Y SW = 1 Q YA EXISTE EN LA LISTA

//MUESTRA LAS EMPRESAS DEPENDE LO Q SELECCIONO EN EL BUSADOR
function Cargar_Mapa_Lista_Adm(ver,id) {
  var tabladatos=$("#body_empresa");
  
  var infowindow = new google.maps.InfoWindow();
  var marker, i;
  
  if (id == -1) {
    route = "buscar_todas_las_empresas"; //BUSCAR TODAS LAS EMPRESAS    
  } else {
    route = "buscar_empresa/"+id; //BUSCAR UNA EMPRESA
  } 


  $.get(route, function (res) { //CONSULTA DE TODOS LOS MOTISTAS ACTIVOS

      deleteMarkers();

      for (var i = 0; i < res.length; i++) {  
        infowindow = new google.maps.InfoWindow();
        marker = new google.maps.Marker({ //SE CREA UN NUEVO MARKER
          map:map,
          animation: google.maps.Animation.DROP,        
          position: new google.maps.LatLng(parseFloat(res[i].latitud), parseFloat(res[i].longitud)),
          title: String(res[i].razon_social)
        });
        markers.push(marker);

        /*if (ver == 1) { //SI ES UNO SIGNIFICA Q SELCCIONE Q MIESTRE TODOS Y EL ICONO CAMBIA DE IMAGEN
          marker.setIcon('images/notificacion.png');  //AQUI SE PONE LA IMAGEN                                                                                     
        }*/

        marker.setIcon('images/empresa.png');                                                                                             
        html = "<b>" + String(res[i].razon_social) + "</b> <br/>" + String(res[i].direccion);
        infowindow.setContent(html);  //COLOCA EL NOMBRE Y APELLIDOA LAS UBICACIONES
        infowindow.open(map, marker);  //COLOCA EL NOMBRE Y APELLIDOA LAS UBICACIONES

        google.maps.event.addListener(marker, 'click', (function(marker, i) {
          return function() {
            html = "<b>" + String(res[i].razon_social) + "</b> <br/>" + String(res[i].direccion);
            infowindow.setContent(html);
            infowindow.open(map, marker);
            id_m = res[i].id;

            for (var k = 0; k <= cont; k++) {
              if (!isNaN(parseInt($("#id_empresa"+k).val()))) { //VERIFICO SI EXISTE ESE TEXTO               
                if (parseInt($("#id_empresa"+k).val()) == id_m) {  //SI EXISTE, VERIFICO SI YA SE A DADO CLICK EN ESA UBICACION
                  sw=1; //SW = 1 SIGNIFICA QUE YA EXISTE ENTONCE SE ELIMINARA
                  break; //SE TERMINA EL FOR
                } 
              } 
            }
            if (sw == 0) {  //SW = 0 SIGNIFICA Q NO EXISTE Y SE AGREGA A LA LISTA
                tabladatos.append('<tr id="fila'+cont+'"> <td> <input name="id_empresa[]" id="id_empresa'+cont+'" value='+res[i].id+' type=hidden size=2>\n\
                '+res[i].nit+'</td><td>'+res[i].razon_social+'</td><td>'+res[i].direccion+'</td></tr>');              
                cont++;     

              $("#btn_sel_todos_adm").show(); 
              $("#btn_desel_todos_adm").hide(); 
             // marker.setIcon('images/notificacion.png');  //AQUI SE PONE LA IMAGEN                                                                           
            } 
            else {// CASO CONTRARIO SIGNIFICA Q YA EXISTE Y LO ELIMINA DE LA LISTA
              eliminar_lista(k);
              sw=0;  
            //  marker.setIcon(''); //PARA Q VUELVA AL ICONO ORIGINAL                                                                                                                                                              
            }
          }
        })(marker, i));
      } 
  });   
}

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

//CARGA LA TABLA DONDE ESTAN LOS TOKEN
function Cargar_Tabla_Lista_Adm(opcion){
  var tabladatos=$("#body_empresa"); 
  if (opcion == -1) {
    route = "buscar_todas_las_empresas"; //BUSCAR TODAS LAS EMPRESAS    
  } else {
    route = "buscar_empresa/"+opcion; //BUSCAR UNA EMPRESA
  }  
  $.get(route, function (res) {
    $('#body_empresa').empty();               
    $(res).each(function (key, value) { 
      tabladatos.append('<tr id="fila'+cont+'"> <td> <input name="id_empresa[]" id="id_empresa'+cont+'" value='+value.id+' type="hidden" size=2>\n\
      '+value.nit+'</td><td>'+value.razon_social+'</td><td>'+value.direccion+'</td></tr>'); 
      cont++;     
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

