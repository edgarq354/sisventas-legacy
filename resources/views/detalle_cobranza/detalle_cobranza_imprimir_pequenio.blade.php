<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="UTF-8">
    <title>{{ __('detalle_cobranza.titulo_detalle_pago') }}</title>
 <!--link href="css/reporte.css" type="text/css" rel="stylesheet"  -->

 <style type="text/css">
   body{
        font-size: 12px;
        font-family:Elegance, sans-serif;
       }

 
        @page {
            margin: 0cm 0cm;
            font-family: Arial;
        }

        body {
            margin: 0.5cm 0.5cm 0.5cm 0.5cm;
        }

        header {
            position: fixed;
            top: 0cm;
            left: 0cm;
            right: 0cm;
            height: 2cm;
            background-color: #2a0927;
            color: white;
            text-align: center;
            line-height: 30px;
        }

        footer {
            position: fixed;
            bottom: 0cm;
            left: 0cm;
            right: 0cm;
            height: 2cm;
            background-color: #2a0927;
            color: white;
            text-align: center;
            line-height: 35px;
        } 
 </style>
  
  <script>
function imprimir() {
  window.print();
}
</script>

</head>

<body onload="imprimir();">
 

 <table id=table border="0" width="270px"  >
  <tr >
    <td colspan="2" >
      <center>
        {{ __('detalle_cobranza.empresa_dp') }} {{$empresa[0]->razon_social}}<br>
      {{ fecha_larga($detalle_cobranza[0]->fecha_registro) }}
          <br>
       {{ __('detalle_cobranza.hora_dp') }}
       <?php 
          $time = date('H:i', strtotime($detalle_cobranza[0]->fecha_registro));
          echo $time;
          ?>  
          <br>
          {{ __('detalle_cobranza.nro_comprobante', ['id' => $detalle_cobranza[0]->id]) }}<BR><br>
        
            <B>{{ __('detalle_cobranza.datos_de_cobranza') }}</B>
        </center>
        <hr style="background-color: black;"> 
    </td>
  </tr>
  <tr>
    <td>  {{ __('detalle_cobranza.numero_cobranza_dp') }}  </td>
    <td>  {{$cobranzas[0]->id}}  </td>  
  </tr>
  <tr>
    <td>  {{ __('detalle_cobranza.tipo_dp') }}  </td>
    <td>  {{$cobranzas[0]->tipo}}  </td>  
  </tr>
  <tr>
    <td>  {{ __('detalle_cobranza.monto_total_dp') }}  </td>
    <td>  {{$cobranzas[0]->monto_total}}  </td>  
  </tr>
  <tr>
    <td>  {{ __('detalle_cobranza.monto_pagado_dp') }}  </td>
    <td>  {{$cobranzas[0]->monto_pagado}}  </td>  
  </tr>
  <tr>
    <td>  {{ __('detalle_cobranza.estado_dp') }}  </td>
    <td>   @if($cobranzas[0]->monto_pagado >= $cobranzas[0]->monto_total)
                                    {{ __('detalle_cobranza.pagado_mayus') }} 
                                    @else
                                     {{ __('detalle_cobranza.pendiente_mayus') }} 
                                    @endif </td>  
  </tr>
  <tr>
    <td>  {{ __('detalle_cobranza.fecha_dp') }}  </td>
    <td>  {{$cobranzas[0]->fecha_registro}}  </td>  
  </tr>
  <tr>
    <td colspan="2"> 
      <BR>
      <CENTER><B>{{ __('detalle_cobranza.pago_cobranza_mayus') }}</B></CENTER>
      <hr style="background-color: black;">

      {{ __('detalle_cobranza.nit_ci_dp') }} {{$detalle_cobranza[0]->ci_nit}} 
    </td>
  </tr>
  <tr>
    <td colspan="2">
      {{ __('detalle_cobranza.clientes_dp') }}  {{$detalle_cobranza[0]->razon_social}} 
     
    </td>
  </tr>
  <tr>
    <td colspan="2"> 
       {{ __('detalle_cobranza.detalle_dp') }}  {{$detalle_cobranza[0]->detalle}} 
    </td>
  </tr>
  <tr>
    <td>  {{ __('detalle_cobranza.monto_bs') }}  </td>
    <td>  {{$detalle_cobranza[0]->monto}}  </td>  
  </tr>
  <tr>
    <td>  {{ __('detalle_cobranza.forma_de_pago_dp') }}  </td>
    <td>  {{$detalle_cobranza[0]->forma_pago}}  </td>  
  </tr>
  <tr>
    <td>  {{ __('detalle_cobranza.usuario_dp') }}  </td>
    <td>  {{$detalle_cobranza[0]->usuario}}  </td>  
  </tr>    
  <tr>
    <td>  {{ __('detalle_cobranza.caja_dp') }}  </td>
    <td>  {{$detalle_cobranza[0]->caja}}  </td>  
  </tr>   
  <tr>
    <td colspan="2"> 
      <center style="font-size: 10px;"><b >{{ __('detalle_cobranza.desarrollado_por') }}</b> ELISOFT - 75602869 </center>
    </td>
  </tr>

</table>
 


</body>
</html>
 




  
  

