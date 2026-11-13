var cont = 0;
var nombre_fotocopia = [];
var imagen = [];

function Agregar_Imagen(){
    tabladatos = $('#lista_fotocopia');
    var fila = '<tr id="fila'+cont+'">\n\
        <td><input name="nombre_fotocopia[]" id="nombre_fotocopia'+cont+'" type="text" class="form-control" placeholder="Ingrese el tipo de imagen">\n\
  <button id="btn_imagen'+cont+'" type="button" class="btn-sm btn-success pull-right" onclick="Agregar_Imagen_Hija()"><i class="fa fa-plus-square" aria-hidden="true"></i></button></td>\n\
        <td><input type="file" name="imagen[]" id="imagen'+cont+'" class="form-control"> </td>\n\
       <td> <button type="button" id="btn_eli'+cont+'" class="btn-sm btn-danger" title=Eliminar onclick="eliminar_lista_Imagen(' + cont + ')"><i class="fa fa-trash-o" aria-hidden="true"></i></button></td></tr>';            
    $('#lista_fotocopia').append(fila);
    cont++;
}

function eliminar_lista_Imagen(index){
   nombre_fotocopia[index]=0;
   imagen[index]=0;
   $('#fila' + index).remove();
}


function Agregar_Imagen_Hija(){
    tabladatos = $('#lista_fotocopia');
    var fila = '<tr id="fila'+cont+'">\n\
        <td><input name="nombre_fotocopia[]" id="nombre_fotocopia'+cont+'" type="hidden" class="form-control" placeholder="Ingrese el tipo de imagen"></td> \n\
        <td><input type="file" name="imagen[]" id="imagen'+cont+'" class="form-control"> </td>\n\
       <td> <button type="button" id="btn_eli'+cont+'" class="btn-sm btn-danger" title=Eliminar onclick="eliminar_lista_Imagen(' + cont + ')"><i class="fa fa-trash-o" aria-hidden="true"></i></button></td></tr>';            
    $('#lista_fotocopia').append(fila);
    cont++;
}

function validateForm(){
    var x = document.forms["Form1"]["ci"].value;
    if (x == "") {
        alert("Name must be filled out");
        return false;
    }
}