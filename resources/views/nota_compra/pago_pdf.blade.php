<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="UTF-8">
    <title>RECIBO DE PAGO DE FRECUENCIA</title>
 <!--link href="css/reporte.css" type="text/css" rel="stylesheet"  -->

 
  
</head>

<body>
 

<?php
setlocale(LC_TIME, 'es_ES.UTF-8');
date_default_timezone_set ("America/La_Paz");


$dia="";

?>
 

 <table id=table border="0" width="250px"  >
  <tr >
    <td  >
      <center>
        Empresa<br>
      <?php 
          $dia=date("j",strtotime ( $pago_frecuencia[0]->fecha ));
          $dia_s=strftime("%u",strtotime ( $pago_frecuencia[0]->fecha ));
          $mes=strftime("%m",strtotime ( $pago_frecuencia[0]->fecha ));
          $anio=date("Y",strtotime ( $pago_frecuencia[0]->fecha )); 
          
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
          $time = strftime("%H:%M", strtotime ( $pago_frecuencia[0]->fecha ));
          echo $time;
          ?>  
          <br>
          Documento #  {{$pago_frecuencia[0]->numero}}
        </center>

    </td>
  </tr>

  <tr>
    <td>
      Movil: {{$pago_frecuencia[0]->numero_movil}}<br>
      Conductor: {{$pago_frecuencia[0]->nombre}} {{$pago_frecuencia[0]->paterno}} {{$pago_frecuencia[0]->materno}}<br>
      ci: {{$pago_frecuencia[0]->ci}} 
    </td>
  </tr>
  <tr>
    <td>
      <center>
      ----- Detalle de pago ----<br>
      <?php foreach($frecuencia as $fre)
      {
        echo "Fecha : ".$fre->fecha_inicio."<br>";
      }
      ?>
      Ahorro: {{$pago_frecuencia[0]->ahorro}}<br>
      Retraso: {{$pago_frecuencia[0]->monto_retraso}}<br>
      Total de Frecuencia: {{$pago_frecuencia[0]->monto_frecuencia}}<br>
      Monto total: {{$pago_frecuencia[0]->monto_total}}<br>
      </center>
    </td>
  </tr>

   <tr>
    <td>
<center>
      ----- Detalle de deuda  ----<br>
      <?php
      foreach ($deuda_frecuencia as $key => $value) {
        echo "Fecha: ".$value->fecha_inicio.' <br>';
      } 
      ?>
    </center>
      Ahorro: {{$pago_frecuencia[0]->ahorro}}<br>
      Retraso: {{$pago_frecuencia[0]->monto_retraso}}<br>
      Total de Frecuencia: {{$pago_frecuencia[0]->monto_frecuencia}}<br>
      Monto total: {{$pago_frecuencia[0]->monto_total}}<br>

    </td>
  </tr>
  <tr>
    <td>
      <br>
      POR FAVOR VERIFIQUE LOS DATOS DEL RECIBO
    </td>
  </tr>

</table>
 


</body>
</html>
 




  
  

