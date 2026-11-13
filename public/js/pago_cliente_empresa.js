function sumar_deudas_emrpesa_cliente(checkbox,monto){
    var monto_total=parseFloat($("#monto_total_auxiliar").val());
    var cantidad=parseInt($("#cantidad").val());

    if(!$("#"+checkbox).prop('checked') )
    { 
      monto_total=monto_total+parseFloat(monto);
      $("#"+checkbox).val(1);
      cantidad +=1;
    }else
    {   
      monto_total=monto_total-parseFloat(monto);
      $("#"+checkbox).val(0);
      cantidad -=1;
    }
    if (isNaN(monto_total)) {
      monto_total=0;
      cantidad=0;
    }
    $("#monto_total").val(monto_total.toFixed(2));
    $("#monto_total_auxiliar").val(monto_total.toFixed(2));
     $("#cantidad").val(cantidad);
    }


function CargarDetalleSolicitud(latitud,longitud){
  $('#body_punto_pedido').empty();   
  var tabladatos=$("#body_punto_pedido");  
    var ruta="https://maps.googleapis.com/maps/api/staticmap?size=600x400&scale=2&maptype=roadmap&markers=color:red%7Clabel:%7C"+latitud+","+longitud+"";
      tabladatos.append("<tr align=center><td></td></tr><tr><td colspan=1><img src='"+ruta+"&key=AIzaSyBFEeTkwD_HkWEg6dEhT4hhnkOy3XLppZI' class='img-responsive'></td></tr>");           
}

    
function CargarDetalleCarreraEmpresa(id_pedido,otra){
  var contador=1;
  var tabladatos=$("#body_historial_detalle");  
  var route="";
  if(otra==1){
    route= "historial_carrera_detalle/"+id_pedido;
  }else{
    route= "../historial_carrera_detalle/"+id_pedido;
  }

   
  $.get(route, function (res) {
    $('#body_historial_detalle').empty();                   
    $(res).each(function (key, value) { 
      tabladatos.append("<tr align=center><td><font size=4><b>"+contador+"</b></font></td><td><font size=4>Fecha: <b>"+value.fecha_pedido+"</b></font></td><td><font size=4>Monto: <b>"+value.monto+" Bs.</b></font></td></tr>\n\
          <tr><td colspan=3><img src='"+value.ruta+"&key=AIzaSyBFEeTkwD_HkWEg6dEhT4hhnkOy3XLppZI' class='img-responsive'></td></tr>");           
          contador++;                                 
    });
  });    
}