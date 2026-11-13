<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="UTF-8">
    <title>RECIBO DE INGRESO</title>
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
        Empresa {{$empresa[0]->razon_social}}<br>
      <?php 
          $dia=date("j",strtotime ( $ingreso[0]->fecha ));
          $dia_s=strftime("%u",strtotime ( $ingreso[0]->fecha ));
          $mes=strftime("%m",strtotime ( $ingreso[0]->fecha ));
          $anio=date("Y",strtotime ( $ingreso[0]->fecha )); 
          
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
          $time = strftime("%H:%M", strtotime ( $ingreso[0]->fecha ));
          echo $time;
          ?>  
          <br>
          Nro.Recibo: {{$ingreso[0]->id}}<BR>
          <B>RECIBO DE INGRESO</B>
        </center>
      <hr style="border: 1px solid black; margin: 0px;">
    </td>
  </tr>
  <tr>
    <td>
      Cliente: {{$ingreso[0]->nombre_cliente}}<br> 
      Tipo: {{$ingreso[0]->tipo_gasto}}<br> 
      Concepto: {{$ingreso[0]->concepto}}<br> 
      Descripción: {{$ingreso[0]->descripcion}}<br> 
      Monto: {{$ingreso[0]->monto}}<br> 
      Sucursal: {{$ingreso[0]->sucursal}}<br> 
      Caja: {{$ingreso[0]->caja}}<br> 
      Usuario: {{$ingreso[0]->usuario}}<br>  
    </td>
  </tr> 
  

</table>
 


</body>
</html>
 




  
  

