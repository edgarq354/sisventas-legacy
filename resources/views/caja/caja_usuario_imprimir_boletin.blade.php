<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="UTF-8">
    <title>{{ __('caja.cierre_de_caja') }}</title>
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
      <b>{{ __('caja.cierre_de_caja') }}</b><br>
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
      <hr style="border: 1px solid black; margin: 0px; ">
    </td>
  </tr>
  <tr> 
    <td> 
      <table border="0" style="width: 260px;">
        <tr>
        @foreach ( $caja as $c) 
        <td><b>#{{$c->id}} - {{$c->caja}}</b><br>
          {{ __('caja.fecha_apertura_dp') }} <br>
          {{ __('caja.fecha_cierre_dp') }} <br>
          {{ __('caja.apertura_efectivo_dp') }} <br>
          {{ __('caja.apertura_qr_dp') }} <br>
          {{ __('caja.cierre_efectivo_dp') }} <br>
          {{ __('caja.cierre_qr_dp') }} <br>
          {{ __('caja.monto_total_dp') }}
        </td>
        <td><br>
          {{$c->fecha_abrir}}<br>  
          {{$c->fecha_cierre}}<br>
          {{$c->monto_abrir}} Bs<br>
          {{$c->monto_abrir_qr}} Bs<br>
            {{$c->monto_cierre}} Bs<br>
           {{$c->monto_cierre_qr}} Bs<br> 
          <b style="font-size: 15px;">{{$c->monto_cierre_total}} Bs</b>
        </td>  
        <hr style="border: 1px solid black; margin: 0px; ">
        @endforeach 
      </table> 
  </td> 
  </tr>

  <tr>
    <td> 
      {{ __('caja.nota_al_abrir_dp') }} <i>"{{$caja[0]->nota_abrir}}"</i><br>
      {{ __('caja.nota_al_cerrar_dp') }} <i>"{{$caja[0]->nota_cierre}}"</i>
      <hr style="border: 1px solid black; margin: 0px; ">
      
    </td>
  </tr>

  <tr>
    <td>
      <center>
      <table border="0" style="width: 260px;">
        <tr>
          <td align="center"><b>{{ __('caja.detalle_mayus') }}</b></td>
          <td style="width: 6px;" align="center"><b>{{ __('caja.total_mayus') }}</b></td>
        </tr>
        <?php $suma=0; ?>
        @foreach ( $nota_venta as $fre)
        <tr>
          <td  >{{ __('caja.ventas_prefix') }} {{ __('estados.'.$fre->estado) }}</td>
          @if($fre->estado=='Cancelado')
          @php $fre->monto_total=$fre->monto_total * -1; @endphp
          @endif
          <td style="width: 6px;" align="right">{{$fre->monto_total}}</td> 
        
        </tr>
        @if($fre->estado!='Cancelado')
          @php $suma+=$fre->monto_total; @endphp
          @endif
        
        @endforeach
      
        @foreach ( $nota_compra as $v)
        <tr>
          <td  >{{ __('caja.compras_prefix') }} {{ __('estados.'.$v->estado) }}</td>
          <td style="width: 6px;" align="right">{{$v->monto_total}}</td> 
        </tr>
        <?php $suma-=$v->monto_total; ?>
        @endforeach
          
        <tr>
          <td ></td> 
          <td > <hr style="border: 1px solid black; margin: 0px; "></td> 
        </tr>
        <tr>
          <td align="right"><b>{{ __('caja.total_ventas_dp') }}</b></td>
          <td style="width: 6px;" align="center"><b>{{number_format($suma, 2, '.', '.')}}</b></td>
        </tr>

        @if(count($gasto) > 0)
        <tr><td colspan="2"><b>{{ __('caja.gastos_dp') }}</b></td></tr>
        @endif
        @foreach ( $gasto as $v)
        <tr>
          <td>{{ $v->detalle ?: $v->tipo_gasto }}</td>
          <td style="width: 6px;" align="right">{{$v->monto_total}}</td>
        </tr>
        <?php $suma-=$v->monto_total; ?>
        @endforeach

        @foreach ( $ingreso as $v)
        <tr>
          <td  >{{ __('caja.ingreso_prefix') }} {{$v->tipo_gasto}}</td>
          <td style="width: 6px;" align="right">{{$v->monto}}</td> 
        </tr>
        <?php $suma+=$v->monto; ?>
        @endforeach
        <tr>
          <td ></td> 
          <td > <hr style="border: 1px solid black; margin: 0px; "></td> 
        </tr>
        <tr>
          <td align="left"><b>{{ __('caja.total_mayus') }}</b></td>
          <td style="width: 6px;" align="center"><b> {{number_format($suma, 2, '.', '.')}}</b></td> 
        </tr>
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
 




  
  

