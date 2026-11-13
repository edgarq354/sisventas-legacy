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
      Cargar_Representante_Legal($("input[name=ci_representante_legal]").val());       
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

function Cargar_Representante_Legal(id){
  $.get('../../verificar_ci_representante_legal/'+id , function (response) {    
     $("input[name=nombre]").val(response[0].nombre);
     $("input[name=paterno]").val(response[0].paterno);
     $("input[name=materno]").val(response[0].materno);
     $("input[name=correo_dueño]").val(response[0].correo);
     $("input[name=fecha_nacimiento]").val(response[0].fecha_nacimiento);
     $("select[name=expedido]").val(response[0].expedido);
     $("input[name=direccion_imagen]").val(response[0].direccion_imagen);

     if (response[0].direccion_imagen != null) {
      $("#foto_rep_legal").show();
     // $("#list_RL").hide();                    
     // $("#imagen_rep_legal").hide();
      document.getElementById('foto_rep_legal').src = 'data:image/jpeg;base64,'+response[0].imagen;                  
     } 
  });  
}

function verificar_ci_representante(){
    var ci = $("#ci_representante_legal").val();
    if ( $("#ci_representante_legal").val() != "") {
        $.get('../../verificar_ci_propietario/'+ci , function (response) {
            if (response[0].contador == 0) {
                 $("#ci_verificar").hide();  
                 $("input[name=nombre]").val("");
                 $("input[name=paterno]").val("");
                 $("input[name=materno]").val("");
                 $("input[name=correo_dueño]").val("");
                 $("input[name=fecha_nacimiento]").val("");
                 $("select[name=expedido]").val("0");  
                 $("#foto_rep_legal").hide();                    
                 $("#list_RL").show();                    
                 $("#imagen_rep_legal").show();                                       
            } else {
                 $("#ci_verificar").show();
                 $("input[name=nombre]").val(response[0].nombre);
                 $("input[name=paterno]").val(response[0].paterno);
                 $("input[name=materno]").val(response[0].materno);
                 $("input[name=correo_dueño]").val(response[0].correo);
                 $("input[name=fecha_nacimiento]").val(response[0].fecha_nacimiento);
                 $("select[name=expedido]").val(response[0].expedido);

                 if (response[0].direccion_imagen != null) {
                  $("#foto_rep_legal").show();
                  $("#list_RL").hide();                    
                  $("#imagen_rep_legal").show();
                  document.getElementById('foto_rep_legal').src = 'data:image/jpeg;base64,'+response[0].imagen;                  
                 }
                  
            }
        }); 
    }  
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








document.getElementById('imagen_rep_legal').addEventListener('change', cargar_imagen, false);


///////////////////////
///////GOOGLE MAPS/////
///////////////////////
var map_cont = 0;
var latitud = $("input[name='latitud']").val();
var longitud = $("input[name='longitud']").val();


             function initAutocomplete() {
        var map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: parseFloat(latitud), lng: parseFloat(longitud),},
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

      

