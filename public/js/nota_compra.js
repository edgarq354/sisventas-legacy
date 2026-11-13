


//MUESTRA LAS EMPRESAS DEPENDE LO Q SELECCIONO EN EL BUSADOR
function Cargar_accesorios_por_id_tipo(id) {
  var tabladatos=$("#body_accesorios");
  
    route = "buscar_accesorios_por_id/"+id; //BUSCAR TODAS LAS EMPRESAS    
   


  $.get(route, function (res) { //CONSULTA DE TODOS LOS MOTISTAS ACTIVOS

 

      for (var i = 0; i < res.length; i++) {  

                tabladatos.append('<tr > <td> '+res[i].id+' </td> <td>'+res[i].nombre+'</td> \n\
                <td>'+res[i].precio+'</td><td>'+res[i].cantidad+'</td> </tr>');              
                cont++;     

                                                                                        
            } 
            
        
      }); 
  }



//MUESTRA LAS EMPRESAS DEPENDE LO Q SELECCIONO EN EL BUSADOR
function Cargar_accesorios_en_lista(id) {
  var tabladatos=$("#body_accesorios");
  
    route = "buscar_accesorios_por_id/"+id; //BUSCAR TODAS LAS EMPRESAS    
   


  $.get(route, function (res) { //CONSULTA DE TODOS LOS MOTISTAS ACTIVOS

 

      for (var i = 0; i < res.length; i++) {  

                tabladatos.append('<tr id="fila'+cont+'"> <td> <input name="id_empresa[]" id="id_empresa'+cont+'" value='+res[i].id+' type=hidden size=2>\n\
                '+res[i].nit+'</td><td>'+res[i].razon_social+'</td><td>'+res[i].direccion+'</td></tr>');              
                cont++;     

                                                                                        
            } 
            
        
      }); 
  }

function eliminar_lista(id)
{

}
