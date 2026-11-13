<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="UTF-8">
    <title>DETALLE COBRANZA PAGO</title>
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
 

<?php
setlocale(LC_TIME, 'es_ES.UTF-8');
date_default_timezone_set ("America/La_Paz");


$dia="";

?>
 

 <table id=table border="0" width="270px"  >
  <tr >
    <td colspan="2" >
      <center>
        Empresa {{$empresa[0]->razon_social}}<br>
      <?php 
          $dia=date("j",strtotime ( $detalle_cobranza[0]->fecha_registro ));
          $dia_s=strftime("%u",strtotime ( $detalle_cobranza[0]->fecha_registro ));
          $mes=strftime("%m",strtotime ( $detalle_cobranza[0]->fecha_registro ));
          $anio=date("Y",strtotime ( $detalle_cobranza[0]->fecha_registro )); 
          
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




          echo strftime( $dia_s.", %d de ". $mes." de %Y", $mifecha );
          ?>
          <br>
       Hora:
       <?php 
          $time = strftime("%H:%M", strtotime ( $detalle_cobranza[0]->fecha_registro ));
          echo $time;
          ?>  
          <br>
          Nro. Comprobante: {{$detalle_cobranza[0]->id}}<BR><br>
        
            <B>DATOS DE COBRANZA</B>
        </center>
        <hr style="background-color: black;"> 
    </td>
  </tr>
  <tr>
    <td>  # Cobranza:  </td>
    <td>  {{$cobranzas[0]->id}}  </td>  
  </tr>
  <tr>
    <td>  Tipo:  </td>
    <td>  {{$cobranzas[0]->tipo}}  </td>  
  </tr>
  <tr>
    <td>  Monto Total:  </td>
    <td>  {{$cobranzas[0]->monto_total}}  </td>  
  </tr>
  <tr>
    <td>  Monto Pagado:  </td>
    <td>  {{$cobranzas[0]->monto_pagado}}  </td>  
  </tr>
  <tr>
    <td>  Estado:  </td>
    <td>   @if($cobranzas[0]->monto_pagado >= $cobranzas[0]->monto_total)
                                    PAGADO 
                                    @else
                                     PENDIENTE 
                                    @endif </td>  
  </tr>
  <tr>
    <td>  Fecha:  </td>
    <td>  {{$cobranzas[0]->fecha_registro}}  </td>  
  </tr>
  <tr>
    <td colspan="2"> 
      <BR>
      <CENTER><B>PAGO COBRANZA</B></CENTER>
      <hr style="background-color: black;">

      NIT/CI: {{$detalle_cobranza[0]->ci_nit}} 
    </td>
  </tr>
  <tr>
    <td colspan="2">
      Cliente(es):  {{$detalle_cobranza[0]->razon_social}} 
     
    </td>
  </tr>
  <tr>
    <td colspan="2"> 
       Detalle:  {{$detalle_cobranza[0]->detalle}} 
    </td>
  </tr>
  <tr>
    <td>  Monto (Bs):  </td>
    <td>  {{$detalle_cobranza[0]->monto}}  </td>  
  </tr>
  <tr>
    <td>  Forma de pago:  </td>
    <td>  {{$detalle_cobranza[0]->forma_pago}}  </td>  
  </tr>
  <tr>
    <td>  Usuario:  </td>
    <td>  {{$detalle_cobranza[0]->usuario}}  </td>  
  </tr>    
  <tr>
    <td>  Caja:  </td>
    <td>  {{$detalle_cobranza[0]->caja}}  </td>  
  </tr>   
  <tr>
    <td colspan="2"> 
      <center style="font-size: 10px;"><b >DESARROLLADO POR</b> ELISOFT - 75602869 </center>
    </td>
  </tr>

</table>
 


</body>
</html>
 




  
  

