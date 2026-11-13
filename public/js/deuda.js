function Cargar_monto_pagar_deuda(id,nombre,monto,monto_pagar,id_tipo_deuda,tipo_deuda)
{
 $('#codigo_fac').text(id);
 $('#id_deuda').val(id);
$('#tipo_deuda').text("Tipo de ingreso ("+tipo_deuda+"):");

 $('#nombre_fac').text(nombre);
 $('#id_deuda_fac').val(id);
 $('#monto_pagar').text(monto_pagar);
 $('#monto_aux').val(monto_pagar);
 $('#monto').val(monto_pagar);
 $('#monto_total').text(monto);

}