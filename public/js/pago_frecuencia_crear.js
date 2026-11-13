
function total_monto_frecuencia(){
    var cantidad=parseFloat($("#cantidad").val());
    var monto_unidad_frecuencia=parseFloat($("#monto_detalle").val());
    var monto_frecuencia=cantidad*monto_unidad_frecuencia;
    $("#monto_frecuencia").val(monto_frecuencia);
}
function sumar_frecuencia(checkbox,monto){

    var monto_frecuencia=parseFloat($("#monto_frecuencia").val());
    

    if(checkbox.checked)
    {
      //checkbox.value=1;
      monto_frecuencia=monto_frecuencia+parseFloat(monto);
      cantidad +=1;
    }else
    {
      //checkbox.value=0;
      monto_frecuencia=monto_frecuencia-parseFloat(monto);
      
    }
    if (isNaN(monto_frecuencia)) {
      monto_frecuencia=0;
      
    }
    $("#monto_frecuencia").val(monto_frecuencia);
    $("#monto_detalle").val(monto);
   
    }

function monto_retraso(fecha){
  var cantidad_tolerancia_cobro=parseInt($("#cantidad_tolerancia_cobro").val());
    var retraso_dia=parseFloat($("#retraso_dia").val());
    var monto_retraso=0;
      if(days>cantidad_tolerancia_cobro)
          {
            retraso_dia=retraso_dia*(days-cantidad_tolerancia_cobro);
             monto_retraso+=parseFloat(retraso_dia);
          }
    return monto_retraso;
}
function sumar_frecuencia2(checkbox,monto,monto_retraso_multa){
    var monto_frecuencia=parseFloat($("#monto_frecuencia").val());
    var cantidad=parseInt($("#cantidad").val());
    var monto_retraso= parseFloat($("#monto_retraso").val());  
 // fin de la verificaciones..
    console.log('monto:'+monto);
    console.log('monto retraso:'+monto_retraso); 
    console.log('monto multa:'+monto_retraso_multa); 

    if(!$("#"+checkbox).prop('checked') )
    {//$("#"+checkbox).val(1);
      monto_frecuencia=monto_frecuencia+parseFloat(monto);
      cantidad +=1;

      //sumamos el monto de retraso si es necesario..
      monto_retraso+=parseFloat(monto_retraso_multa);
           
    }else
    { //$("#"+checkbox).val(0);
      monto_frecuencia=monto_frecuencia-parseFloat(monto);
      cantidad -=1;

    //restamos el monto de retraso si es necesario..
      monto_retraso-=parseFloat(monto_retraso_multa);
    }
    if (isNaN(monto_frecuencia)) {
      monto_frecuencia=0;
      cantidad=0;
    }

   
 
    $("#monto_retraso").val(monto_retraso);
    $("#monto_frecuencia").val(monto_frecuencia);
    $("#monto_detalle").val(monto);
     $("#cantidad").val(cantidad);
    }

    function cambiar_value(checkbox){
        if(checkbox.checked)
        { //checkbox.value=1;
        }else
        { //checkbox.value=0;
        }
    }
     function cambiar_value_id(checkbox){
        if($("#"+checkbox).is(":checked")==false)
        { //$("#"+checkbox).val(1);
        }else
        {//$("#"+checkbox).val(0);
        }
    }
    
function monto_total_frecuencia(){
    var monto_frecuencia=parseFloat($("#monto_frecuencia").val());
    var monto_retraso=parseFloat($('#monto_retraso').val());
    var ahorro=parseFloat($('#ahorro').val());
    var monto_total=monto_frecuencia+monto_retraso+ahorro;
    if (isNaN(monto_total)) {
      monto_total=0;
    }
    $("#monto_total").val(monto_total);
    $("#monto_total_value").text("Monto Total:"+monto_total+" Bs");

    }
