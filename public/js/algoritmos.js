function obtenerCUF(){
    // Esta es la variable que vamos a pasar
    var nit=pad($("#ciNit").val(),13);
    //obtener Fecha y Hora del Emisor yyyyMMddHHmmssSSS
    var hoy = new Date();
    var fecha =hoy.getFullYear()+''+(hoy.getMonth() + 1)+''+hoy.getDate()+''+hoy.getHours()+''+hoy.getMinutes()+''+hoy.getSeconds()+''+hoy.getUTCMilliseconds();
    //Sucursal
    var sucursal=pad(0,4);
    // 1 = Electrónica en Línea--2 = Computarizada en Línea
    var modalidad=1;
    //1 = Online -- 2 = Offline -- 3 = Masiva 
    var tipoEmision=1;
    //1 = Factura con Derecho a Crédito Fiscal -- 2 = Factura sin Derecho a Crédito Fiscal -- 3 = Documento de Ajuste  
    var tipoFactura=3;
    //Documento Sector 1 = Factura Compra Venta -- 2 = Recibo de Alquiler de Bienes Inmuebles -- ……
    var tipoDoumentoSector=24;
    //Numeo de factura
    var numeroFactura=252
    //Punto de venta
    var puntoVenta=0;
    //cadena::nit+'-'+fecha+'-'+sucursal+'-'+modalidad+'-'+tipoEmision+'-'+tipoFactura+'-'+tipoDoumentoSector+'-'+numeroFactura+'-'+puntoVenta
    var cadena=nit+''+fecha+''+sucursal+''+modalidad+''+tipoEmision+''+tipoFactura+''+tipoDoumentoSector+''+numeroFactura+''+puntoVenta;
    //var cadena='00001234567892019011316372123100001110100000000010000';
    //console.log(cadena.length);
    var codigoVerificador=modulo11(cadena,1,9,false);
    var valorCadena=cadena+''+codigoVerificador;
    console.log(valorCadena);
    console.log(Base16(valorCadena));
}
function pad(n, width, z) { 
    z = z || '0'; n = n + ''; 
    return n.length >= width ? n : new Array(width - n.length + 1).join(z) + n; 
}

function modulo11(cadena , numDig, limMult, x10){
    console.log(cadena);
    if (!x10)  numDig = 1;    
    for(var n = 1; n <= numDig; n++) {
    suma = 0;
    mult = 2;
      for(var i = (cadena.length-1); i >= 0; i--) {
        suma += (mult * parseInt(cadena.substring(i, i + 1)));    
        if(++mult > limMult) mult = 2;
      }      
      if (x10) {
      dig = ((suma*10)%11)%10;
      }
      else{
      dig =suma%11;
      }                   
      if (dig == 10) {        
      cadena +="1";
      }
      if (dig == 11) {
      cadena +="0";
      }
      if (dig < 10) {        
      cadena += dig;
      }     
    }
      return cadena.substring(cadena.length - numDig, cadena.length);
}

function Base16(pString){
    var vValor = BigInt(pString);    
    return vValor.toString('16').toUpperCase();
}
function Base10(pString)
{
    var vValor = BigInteger.Parse(pString, System.Globalization.NumberStyles.HexNumber);
    return vValor.ToString();
}
