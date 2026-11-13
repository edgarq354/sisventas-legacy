$(document).ready(function(){
  Lista_Telefono($("#id_empresa").val()); 
});

var cont = 0;
var id_telefono = [];
var telefono = [];
var estado_tel = [];
function Lista_Telefono(id){
    tabladatos = $('#lista_telefono');
    $.get('../../Telefono_Empresa/'+id, function (res) {
      $('#lista_telefono').empty();                   
      $(res).each(function (key, value) {   
        fila = '<tr id="fila' + cont + '" style="background: white">\n\
        <td><input name="id_telefono[]" id="id_telefono'+cont+'" value='+value.id+' type="hidden">\n\
        <input name="telefono[]" id="telefono'+cont+'" value="'+value.numero+'" type="text" class="form-control" placeholder="Ingrese el telefono">\n\
        <input name="estado_tel[]" id="estado_tel'+cont+'" value="0" type="hidden" class="form-control"></td>\n\
        <td><button type="button" class="btn btn-danger" onclick="eliminar_lista_telefono('+cont+')"><i class="fa fa-trash" aria-hidden="true"></i></button></td></tr>';
        $('#lista_telefono').append(fila);
        cont++;     
      });
     
    });

}

function Cargar_nit(nit){
    $("#nit1").val(nit);
}
function eliminar_lista_telefono(index){
  if ( $("#estado_tel"+index).val() == 0) {
      $('#fila'+index).css("background","#F6CED8");      
      $('#estado_tel'+index).val(1); 
  } else {
      $('#fila'+index).css("background","white");      
      $('#estado_tel'+index).val(0);      
  }
}

function Agregar_Telefono(){
    tabladatos = $('#lista_telefono');
    var fila = '<tr id="fila_nueva'+cont+'">\n\
       <td><input name="telefono[]" id="telefono'+cont+'" type="text" class="form-control" placeholder="Ingrese el telefono">\n\
       <input name="estado_tel[]" id="estado_tel'+cont+'" value="2" type="hidden" class="form-control"></td>\n\
       <td> <button type="button" id="btn_eli'+cont+'" class="btn-sm btn-danger" title=Eliminar onclick="eliminar_lista_nueva_telefono(' + cont + ')"><i class="fa fa-trash-o" aria-hidden="true"></i></button></td></tr>';            
    $('#lista_telefono').append(fila);  
  cont++;          
}
function eliminar_lista_nueva_telefono(index){
   telefono[index]=0;
   $('#fila_nueva' + index).remove();
}


///////CARGAR EL IMAGEN DEL REPRESENTANTE LEGAL
function cargar_imagen(evt) {
    $("#list_RL").show();  
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
           document.getElementById("list_RL").innerHTML = ['<img class="thumb" src="', e.target.result,'" title="', escape(theFile.name), '" width="150px" height="150px"/>'].join('');
          };
      })(f);
      reader.readAsDataURL(f);
      $("#foto_rep_legal").hide();
    }
}







///checkbox en adtualizar
function con_factura2(){
  if($("#con_factura").is(":checked")==true){
    $("#div_con_factura").show();
  }else{
    $("#paga_iva").prop( "checked", false );
    $("#paga_it").prop( "checked", false );
    $("#div_con_factura").hide();
    $("#div_iva").hide();
     $("#div_it").hide();
  }
}



function con_factura(){
  if($("#con_factura").is(":checked")==false){
    $("#div_con_factura").show();
  }else{
    $("#paga_iva").prop( "checked", false );
    $("#paga_it").prop( "checked", false );
    $("#div_con_factura").hide();
    $("#div_iva").hide();
     $("#div_it").hide();
  }
}

function paga_iva(){
  if($("#paga_iva").is(":checked")==false){
    $("#div_iva").show();
  }else{
    $("#div_quien_paga_iva").hide();
    $("#div_iva").hide();
  }
}

function paga_it(){
  if($("#paga_it").is(":checked")==false){
    $("#div_it").show();
  }else{
    $("#div_it").hide();
  }
}







///////////////////////
///////GOOGLE MAPS/////
///////////////////////
var map_cont = 0;
var latitud = $("input[name='latitud']").val();
var longitud = $("input[name='longitud']").val();


             function initAutocomplete() {
        var myLatLng = {lat: -17.7862900, lng: -63.1811700};
        var map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: myLatLng.lat, lng: myLatLng.lng },
          zoom: 13,
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
      }

      

