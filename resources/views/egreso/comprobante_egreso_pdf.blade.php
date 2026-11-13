<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="UTF-8">
    <title>{{ __('egreso.comprobante_egreso_mayus') }}</title>
 <!--link href="css/reporte.css" type="text/css" rel="stylesheet"  -->

<style type="text/css">
        
      th #titulo{
         background-color: #ef973f;
        color: black;
         border: 1px solid #000;
        height: 30px;
        padding-left: 5px;
        padding-right: 5px; 
       }
       #td{
        height: 40px;
        align-content: center;
       }
       div{
        height: 100%;
       }
       #table
       {
        border-collapse: collapse;
       }
       body{
        font-size: 13px;
         font-family:Elegance, sans-serif;
       }
  html {
  margin-top: 0mm;
}

     </style>
  
</head>

<body>

<?php
$fecha_recibo = fecha_larga($egreso[0]->fecha);
?>


@foreach($egreso as $egre)
@foreach($cliente as $cli)
@foreach($admin as $ad)


  <table width="750px">
  <tr>
  <td>
      <table width="370px" border="0" style="border: 1px solid #ccc;
    border-radius: 5px; padding:5px;" >
        <tr>
          <td style=" font-size:14px; color:red;" >{{ __('egreso.comprobante_egreso_mayus') }}</td>
          <td style="color: red; font-size:13px;" align="right">{{ __('egreso.nro_dp') }} <b >{{$egre->id}}</b></td>
        </tr>
        <tr>
          <td></td>
          <td align="right">{{ __('egreso.bs_dp') }} <label >{{$egre->monto}}</label></td>
        </tr>
        <tr>
          <td colspan="2"  >
                  <p style=" padding-top:10px;">
                  {{ __('egreso.he_pagado_a_inline') }} <b>{{$cli->nombre}}</b><br>
                  {{ __('egreso.cheque_nro_inline') }} <b>{{$egre->numero_cheque}}</b> {{ __('egreso.banco_inline') }} <b>{{$egre->banco}}</b><br>
                  {{ __('egreso.tipo_de_egreso_inline') }} <b>{{$tipo_ingreso_egreso[0]->nombre}}</b><br>
                  {{ __('egreso.la_cantidad_de') }} <b>{{$numero_letra}} {{ __('egreso.bolivianos_label') }}</b><br>
                  {{ __('egreso.por_concepto_de_inline') }} <b>{{$egre->observacion}}</b>
                  </p>
          </td>
        </tr>
        <tr>
          <td >
          <?php  echo $fecha_recibo; ?></td>
          <td align="center"  rowspan="2" style="font-size:10px; padding-bottom:0px; padding-top:15px;">....................................<br>{{ __('egreso.entregue_conforme') }}</td>
        </tr>
        <tr>
          <td>
          {{ __('egreso.nombre_dp') }} <b>{{$ad->nombre}}</b></td>
        </tr>
      </table>
      </td>

      <td>
      <table width="370px" border="0" style="border: 1px solid #ccc;
    border-radius: 5px; padding:5px; width:370px;" >
        <tr>
          <td style=" font-size:14px; color:red;" >{{ __('egreso.comprobante_egreso_mayus') }}</td>
          <td style="color: red; font-size:13px;" align="right">{{ __('egreso.nro_dp') }} <b >{{$egre->id}}</b></td>
        </tr>
        <tr>
          <td></td>
          <td align="right">{{ __('egreso.bs_dp') }} <label >{{$egre->monto}}</label></td>
        </tr>
        <tr>
          <td colspan="2"  >
                  <p style=" padding-top:10px;">
                  {{ __('egreso.he_pagado_a_inline') }} <b>{{$cli->nombre}}</b><br>
                  {{ __('egreso.cheque_nro_inline') }} <b>{{$egre->numero_cheque}}</b> {{ __('egreso.banco_inline') }} <b>{{$egre->banco}}</b><br>
                   {{ __('egreso.tipo_de_egreso_inline') }} <b>{{$tipo_ingreso_egreso[0]->nombre}}</b><br>
                  {{ __('egreso.la_cantidad_de') }} <b>{{$numero_letra}} {{ __('egreso.bolivianos_label') }}</b><br>
                  {{ __('egreso.por_concepto_de_inline') }} <b>{{$egre->observacion}}</b>
                  </p>
          </td>
        </tr>
        <tr>
          <td >
          <?php  echo $fecha_recibo; ?></td>
          <td align="center"  rowspan="2" style="font-size:10px; padding-bottom:0px; padding-top:15px;">....................................<br>{{ __('egreso.entregue_conforme') }}</td>
        </tr>
        <tr>
          <td>
          {{ __('egreso.nombre_dp') }} <b>{{$ad->nombre}}</b></td>
        </tr>
      </table>
      </td>

      </tr>
      </table>

@endforeach
@endforeach
@endforeach
 




</body>
</html>




  
  

