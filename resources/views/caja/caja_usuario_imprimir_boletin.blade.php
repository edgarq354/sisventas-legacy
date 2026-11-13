<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="UTF-8">
    <title>CIERRE DE CAJA </title>
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
      <b>CIERRE DE CAJA</b><br>
        Empresa {{$empresa[0]->razon_social}}<br>
      <?php 
          $dia=date("j",strtotime ( $caja[0]->fecha_cierre ));
          $dia_s=strftime("%u",strtotime ( $caja[0]->fecha_cierre ));
          $mes=strftime("%m",strtotime ( $caja[0]->fecha_cierre ));
          $anio=date("Y",strtotime ( $caja[0]->fecha_cierre )); 
          
          $mifecha=gmmktime(12,0,0,$mes,$dia,$anio);
          
          //dia

     switch ($dia_s) {
      case 1:
      $dia_s="Lunes";
      break;
      case 2:
      $dia_s="Martes";
      break;
      case 3:
      $dia_s="Miercoles";
      break;
      case 4:
      $dia_s="Jueves";
      break;
      case 5:
      $dia_s="Viernes";
      break;
      case 6:
      $dia_s="Sabado";
      break;
      case 7:
      $dia_s="Domingo";
      break;
    }
          //fin de dia


 switch ($mes) {
      case 1:
      $mes="Ene";
      break;
      case 2:
      $mes="Feb";
      break;
      case 3:
      $mes="Mar";
      break;
      case 4:
      $mes="Abr";
      break;
      case 5:
      $mes="May";
      break;
      case 6:
      $mes="Jun";
      break;
      case 7:
      $mes="Jul";
      break;
      case 8:
      $mes="Ago";
      break;
      case 9:
      $mes="Sep";
      break;
      case 10:
      $mes="Oct";
      break;
      case 11:
      $mes="Nov";
      break;
      case 12:
      $mes="Dic";
      break;
    }



        echo $empresa[0]->direccion;
        echo "<br>";
        //echo "Fecha: ".$dia."-".$mes."-".$anio;
          echo strftime( $dia_s.", %d de ". $mes." de %Y", $mifecha );
          ?>
          <br>
       Hora:
       <?php 
          $time = strftime("%H:%M", strtotime ( $caja[0]->fecha_cierre ));
          echo $time;
          ?>  
          <br>  
        </center>
      
    </td>
  </tr>

  <tr>
    <td> 
      USUARIO: {{$caja[0]->usuario}} 
      <hr style="border: 1px solid black; margin: 0px; ">
    </td>
  </tr>
  <tr> 
    <td> 
      <table border="0" style="width: 260px;">
        <tr>
        @foreach ( $caja as $c) 
        <td><b>#{{$c->id}} - {{$c->caja}}</b><br> 
          Fecha Apertura: <br>
          Fecha Cierre: <br>
          Apertura Efectivo: <br>
          Apertura Qr: <br>
          Cierre Efectivo: <br>
          Cierre Qr: <br>
          Monto Total
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
      Nota al Abrir: <i>"{{$caja[0]->nota_abrir}}"</i><br>
      Nota al Cerrar: <i>"{{$caja[0]->nota_cierre}}"</i>
      <hr style="border: 1px solid black; margin: 0px; ">
      
    </td>
  </tr>

  <tr>
    <td>
      <center>
      <table border="0" style="width: 260px;">
        <tr>
          <td align="center"><b>DETALLE</b></td> 
          <td style="width: 6px;" align="center"><b>TOTAL</b></td> 
        </tr>
        <?php $suma=0; ?>
        @foreach ( $nota_venta as $fre)
        <tr>
          <td  >Ventas {{$fre->estado}}</td> 
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
          <td  >Compras {{$v->estado}}</td> 
          <td style="width: 6px;" align="right">{{$v->monto_total}}</td> 
        </tr>
        <?php $suma-=$v->monto_total; ?>
        @endforeach
          
        <tr>
          <td ></td> 
          <td > <hr style="border: 1px solid black; margin: 0px; "></td> 
        </tr>
        <tr>
          <td align="right"><b>TOTAL VENTAS:</b></td> 
          <td style="width: 6px;" align="center"><b>{{number_format($suma, 2, '.', '.')}}</b></td> 
        </tr>

        @if(count($gasto) > 0)
        <tr><td colspan="2"><b>Gastos:</b></td></tr>
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
          <td  >Ingreso: {{$v->tipo_gasto}}</td> 
          <td style="width: 6px;" align="right">{{$v->monto}}</td> 
        </tr>
        <?php $suma+=$v->monto; ?>
        @endforeach
        <tr>
          <td ></td> 
          <td > <hr style="border: 1px solid black; margin: 0px; "></td> 
        </tr>
        <tr>
          <td align="left"><b>TOTAL</b></td> 
          <td style="width: 6px;" align="center"><b> {{number_format($suma, 2, '.', '.')}}</b></td> 
        </tr>
      </table>
      
      </center>
    </td>
  </tr>
   
  <tr>
    <td colspan="2">   
       
      <center><b>DESARROLLADO POR</b> ELISOFT - 75602869 </center>
    </td>
  </tr>

</table>
 


</body>
</html>
 




  
  

