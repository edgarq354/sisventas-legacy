<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="UTF-8">
    <title>{{ __('caja.reporte_por_producto_titulo_boletin') }}</title>
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
            margin: 0.4cm 0.4cm 0.4cm 0.4cm;
        }

        header {
            position: fixed;
            top: 0cm;
            left: 0cm;
            right: 0cm;
            height: 0cm;
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
 

<?php
setlocale(LC_TIME, 'es_ES.UTF-8');
date_default_timezone_set ("America/La_Paz");


$dia="";

?>
 

 <table id=table border="0" width="270px"  >
  <tr >
    <td  >
      <center>
      <b>{{ __('caja.reporte_por_producto') }}</b><br>
        {{ __('caja.empresa_label') }} {{$empresa[0]->razon_social}}<br>
      <?php 
          $diasSemana = explode(',', __('caja.dias_semana'));
          $mesesAbr   = explode(',', __('caja.meses_abr'));
          $ts = strtotime($caja[0]->fecha_cierre);
          $dia_s = $diasSemana[(int) date('N', $ts) - 1];
          $mes   = $mesesAbr[(int) date('n', $ts) - 1];
          $dia   = date('d', $ts);
          $anio  = date('Y', $ts);
          $conector = __('caja.de') !== '' ? ' '.__('caja.de').' ' : ' ';

        echo $empresa[0]->direccion;
        echo "<br>";
        echo app()->getLocale() === 'en'
            ? "{$dia_s}, {$mes} {$dia}, {$anio}"
            : "{$dia_s}, {$dia}{$conector}{$mes}{$conector}{$anio}";
          ?>
          <br>
       {{ __('caja.hora_label') }}
       <?php 
          echo date('H:i', $ts);
          ?>  
          <br>  
        </center>
      
    </td>
  </tr>

  <tr>
    <td> 
      {{ __('caja.usuario_dp') }} {{$caja[0]->usuario}}  
    </td>
  </tr>
  <tr> 
    <td> 
      <table border="0" style="width: 260px;">
        <tr>
        @foreach ( $caja as $c) 
        <td><b>#{{$c->id}} - {{$c->caja}}</b><br> 
          {{ __('caja.fecha_apertura_dp') }} <br>
          {{ __('caja.fecha_cierre_dp') }} 
        </td> 
        <td><br>
          {{$c->fecha_abrir}}<br>  
          {{$c->fecha_cierre}}  
        </td>   
        @endforeach 
      </table> 
  </td> 
  </tr>

  <tr>
    <td>
      <center>
     <table style="width: 270px; border-collapse: collapse; border: 1px solid black;">
        <tr>
    <td align="center" style="width: 1px; border: 1px solid black; padding:2px;"><b>{{ __('caja.col_numeral') }}</b></td> 
    <td align="center" style="border: 1px solid black; padding:2px;"><b>{{ __('caja.col_fecha_mayus') }}</b></td> 
    <td align="center" style="border: 1px solid black; padding:2px;"><b>{{ __('caja.detalle_mayus') }}</b></td> 
    <td style="width: 6px; border: 1px solid black; padding:2px;" align="center"><b>{{ __('caja.col_cantidad_abr') }}</b></td> 
  </tr>
      <?php $cantidad=1; ?>
      @foreach ( $detalle_venta as $d)
      <tr>
        <td align="center" style="width: 3px; border: 1px solid black; padding:2px;"> {{$cantidad}}</td> 
        <td align="center" style="width: 11px; font-size:10px; border: 1px solid black; padding:2px;">{{$d->fecha}}</td> 
        <td style="width: 6px; font-size:10px; border: 1px solid black; padding:2px;">{{$d->descripcion}}</td> 
        <td style="width: 6px; border: 1px solid black; padding:2px;" align="center">{{(int)$d->cantidad}}</td> 
        <?php $cantidad++;?>
      </tr>
      @endforeach 
      </table>
      
      </center>
    </td>
  </tr>
   
  <tr>
    <td colspan="2">    
      <center><b>{{ __('caja.desarrollado_por') }}</b> ELISOFT - 75602869 </center>
    </td>
  </tr>

</table>
 


</body>
</html>
 




  
  

