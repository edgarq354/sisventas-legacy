<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="UTF-8">
    <title>RECIBO DE PAGO DE FRECUENCIA</title>
    
    <style type="text/css">
      body{
              font-size: 13px;
              font-family:Elegance, sans-serif;
             }
             
            
           table{
            border-spacing:0px;
           }
           #tabla{
            border: 1px solid #000;
           }
           #subtitulo{
            text-align: right;
            font-weight: bold; 
           }
      </style>
  
</head>

<body style="font-family: "Segoe UI",Arial,sans-serif;">
 
  <?php
  setlocale(LC_TIME, 'es_ES.UTF-8');
  date_default_timezone_set ("America/La_Paz");
  ?>

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




$fechaActual = strftime( $dia_s.", %d de ". $mes." de %Y", $mifecha );
 


$horaActual = strftime("%H:%M", strtotime ( $pago_frecuencia[0]->fecha ));
 

  ?>

 



<table id=table border="0" width="700px"  >
  <tr>
    <td style="padding-right: 10px;">

      
     <table id=table border="0" style="width: 100%;">
        <tr>
          <td>
            <img src=<?php echo "".asset('../public/images/logo_baner.png');?> width="200px" height="60px"  >
          </td>
          <td align="right" style="vertical-align: top; font-size:9px;">
            {{$fechaActual}}
            <br>
            {{$horaActual}}
          </td>
        </tr>

        <tr style="font-size: 20px; font-weight:bold;">
          <td>
            <u>HOJA DE RUTA</u>
          </td>
          <td align="right">
            N:  {{$pago_frecuencia[0]->numero}} 
            <br>
            ORIGINAL
          </td>
        </tr>
      </table>
  

    <hr style="border: 3px solid black;"/>

    <table id=table border="0" style="width: 100%;">
      <tr>
        <td id="subtitulo">
          Conductor: 
        </td>
        <td>
          {{$pago_frecuencia[0]->nombre}} {{$pago_frecuencia[0]->paterno}} {{$pago_frecuencia[0]->materno}}
        </td> 
        <td rowspan="3">
          <h1> <center>  {{$pago_frecuencia[0]->numero_movil}} </center></h1>
        </td>
      </tr>

      <tr>
        <td id="subtitulo">
          Licencia: 
        </td>
        <td>
          {{$pago_frecuencia[0]->ci}} 
        </td>
      </tr>

      <tr>
        <td id="subtitulo">
          Placa: 
        </td>
        <td>
          {{$pago_frecuencia[0]->placa}} 
        </td>
      </tr>

      <tr>
        <td id="subtitulo">
          Por Concepto de: 
        </td>
        <td colspan="2">
          PAGO SEMANAL DE FRECUENCIA
        </td>
      </tr>

      <tr>
        <td id="subtitulo">
          De Fecha: 
        </td>
        <td colspan="2">
          <?php foreach($frecuencia as $fre)
          {
            echo $fre->fecha_inicio." A ".$fre->fecha_fin." <br>";
          }
          ?>  
         
        </td>
      </tr>

      <tr>
        <td id="subtitulo">
          Frecuencia (Bs): 
        </td>
        <td>
          {{$pago_frecuencia[0]->monto_frecuencia}}
        </td>
        <td rowspan="2"  >
          <h1> <center>S/3</center></h1>
        </td>
      </tr>
      <tr>
        <td id="subtitulo">
          Retraso (Bs): 
        </td>
        <td>
          {{$pago_frecuencia[0]->monto_retraso}}
        </td>
      </tr>

      <tr>
        <td colspan="3" style="font-weight: bold; font-size: 20px;">
          <center> TOTAL  {{$pago_frecuencia[0]->monto_total}} (Bs)</center> 
        </td> 
      </tr>
 
    </table>
    *Guarde este comprobante para el sorteo de FIN DE AÑO
    <hr style="border: 3px solid black;"/>
    <table id=table border="0" style="width: 100%;">
      <tr align="center">
        <td style="padding: 10px;">
          <hr style="border: 1px solid black; margin-top:50px;"/> 
          {{$pago_frecuencia[0]->nombre}} {{$pago_frecuencia[0]->paterno}} {{$pago_frecuencia[0]->materno}}
        </td>
        <td style="padding: 10px;">
          <hr style="border: 1px solid black; margin-top:50px;"/> 
          {{$usuario}}
        </td>
      </tr>
    </table>


    </td>


    <td style="padding-left: 10px;">
      <table id=table border="0" style="width: 100%;">
        <tr>
          <td>
            <img src=<?php echo "".asset('../public/images/logo_baner.png');?> width="200px" height="60px"  >
          </td>
          <td align="right" style="vertical-align: top; font-size:9px;">
            {{$fechaActual}}
            <br>
            {{$horaActual}}
          </td>
        </tr>

        <tr style="font-size: 20px; font-weight:bold;">
          <td>
            <u>HOJA DE RUTA</u>
          </td>
          <td align="right">
            N:  {{$pago_frecuencia[0]->numero}} 
            <br>
            COPIA
          </td>
        </tr>
      </table>
  

    <hr style="border: 3px solid black;"/>

    <table id=table border="0" style="width: 100%;">
      <tr>
        <td id="subtitulo">
          Conductor: 
        </td>
        <td>
          {{$pago_frecuencia[0]->nombre}} {{$pago_frecuencia[0]->paterno}} {{$pago_frecuencia[0]->materno}}
        </td> 
        <td rowspan="3">
          <h1> <center>  {{$pago_frecuencia[0]->numero_movil}} </center></h1>
        </td>
      </tr>

      <tr>
        <td id="subtitulo">
          Licencia: 
        </td>
        <td>
          {{$pago_frecuencia[0]->ci}} 
        </td>
      </tr>

      <tr>
        <td id="subtitulo">
          Placa: 
        </td>
        <td>
          {{$pago_frecuencia[0]->placa}} 
        </td>
      </tr>

      <tr>
        <td id="subtitulo">
          Por Concepto de: 
        </td>
        <td colspan="2">
          PAGO SEMANAL DE FRECUENCIA
        </td>
      </tr>

      <tr>
        <td id="subtitulo">
          De Fecha: 
        </td>
        <td colspan="2">
          <?php foreach($frecuencia as $fre)
          {
            echo $fre->fecha_inicio." A ".$fre->fecha_fin." <br>";
          }
          ?>  
         
        </td>
      </tr>

      <tr>
        <td id="subtitulo">
          Frecuencia (Bs): 
        </td>
        <td>
          {{$pago_frecuencia[0]->monto_frecuencia}}
        </td>
        <td rowspan="2"  >
          <h1> <center>S/3</center></h1>
        </td>
      </tr>
      <tr>
        <td id="subtitulo">
          Retraso (Bs): 
        </td>
        <td>
          {{$pago_frecuencia[0]->monto_retraso}}
        </td>
      </tr>

      <tr>
        <td colspan="3" style="font-weight: bold; font-size: 20px;">
          <center> TOTAL  {{$pago_frecuencia[0]->monto_total}} (Bs)</center> 
        </td> 
      </tr>
 
    </table>
    *Guarde este comprobante para el sorteo de FIN DE AÑO
    <hr style="border: 3px solid black;"/>
    <table id=table border="0" style="width: 100%;">
      <tr align="center">
        <td style="padding: 10px;">
          <hr style="border: 1px solid black; margin-top:50px;"/> 
          {{$pago_frecuencia[0]->nombre}} {{$pago_frecuencia[0]->paterno}} {{$pago_frecuencia[0]->materno}}
        </td>
        <td style="padding: 10px;">
          <hr style="border: 1px solid black; margin-top:50px;"/> 
          {{$usuario}}
        </td>
      </tr>
    </table>

    </td>
  </tr>
</table>





</body>
</html>
 




  
  

