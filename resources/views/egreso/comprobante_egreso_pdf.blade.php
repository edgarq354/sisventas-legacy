<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="UTF-8">
    <title>COMPROBASTE DE EGRESO</title>
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
setlocale(LC_TIME, 'es_ES.UTF-8');
date_default_timezone_set ("America/La_Paz");

function dia($numero)
{$dia="";
  switch ($numero) {
      case 1:
      $dia="Lunes";
      break;
      case 2:
      $dia="Martes";
      break;
      case 3:
      $dia="Miercoles";
      break;
      case 4:
      $dia="Jueves";
      break;
      case 5:
      $dia="Viernes";
      break;
      case 6:
      $dia="Sabado";
      break;
      case 7:
      $dia="Domingo";
      break;
    
    default:
      # code...
      break;
  }
  return $dia;
}

function mes($numero)
{$dia="";
  switch ($numero) {
      case 1:
      $dia="Enero";
      break;
      case 2:
      $dia="Febrero";
      break;
      case 3:
      $dia="Marzo";
      break;
      case 4:
      $dia="Abril";
      break;
      case 5:
      $dia="Mayo";
      break;
      case 6:
      $dia="Junio";
      break;
      case 7:
      $dia="Julio";
      break;
      case 8:
      $dia="Agosto";
      break;
      case 9:
      $dia="Septiembre";
      break;
      case 10:
      $dia="Octubre";
      break;
      case 11:
      $dia="Noviembre";
      break;
      case 12:
      $dia="Diciembre";
      break;
    
    default:
      # code...
      break;
  }
  return $dia;
}

          $dia=date("j",strtotime ( $egreso[0]->fecha ));
          $dia_s=strftime("%u",strtotime ( $egreso[0]->fecha ));
          $mes=strftime("%m",strtotime ( $egreso[0]->fecha ));
          $anio=date("Y",strtotime ( $egreso[0]->fecha )); 
          
          $mifecha=gmmktime(12,0,0,$mes,$dia,$anio);
          $fecha_recibo= strftime(dia($dia_s)." %d de ".mes($mes)." del %Y", $mifecha );

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
          <td style=" font-size:14px; color:red;" >COMPROBANTE DE EGRESO</td>
          <td style="color: red; font-size:13px;" align="right">Nº: <b >{{$egre->id}}</b></td>
        </tr>
        <tr>
          <td></td>
          <td align="right">Bs. <label >{{$egre->monto}}</label></td>
        </tr>
        <tr>
          <td colspan="2"  >
                  <p style=" padding-top:10px;">
                  He pagado a <b>{{$cli->nombre}}</b><br>
                  Cheque Nº <b>{{$egre->numero_cheque}}</b> Banco: <b>{{$egre->banco}}</b><br>
                  Tipo de egreso: <b>{{$tipo_ingreso_egreso[0]->nombre}}</b><br>
                  La cantidad de: <b>{{$numero_letra}} Bolivianos.</b><br>
                  Por concepto de: <b>{{$egre->observacion}}</b>
                  </p>
          </td>
        </tr>
        <tr>
          <td >
          <?php  echo $fecha_recibo; ?></td>
          <td align="center"  rowspan="2" style="font-size:10px; padding-bottom:0px; padding-top:15px;">.....................................<br>Entrege conforme</td>
        </tr>
        <tr>
          <td>
          Nombre: <b>{{$ad->nombre}}</b></td>
        </tr>
      </table>
      </td>

      <td>
      <table width="370px" border="0" style="border: 1px solid #ccc;
    border-radius: 5px; padding:5px; width:370px;" >
        <tr>
          <td style=" font-size:14px; color:red;" >COMPROBANTE DE EGRESO</td>
          <td style="color: red; font-size:13px;" align="right">Nº: <b >{{$egre->id}}</b></td>
        </tr>
        <tr>
          <td></td>
          <td align="right">Bs. <label >{{$egre->monto}}</label></td>
        </tr>
        <tr>
          <td colspan="2"  >
                  <p style=" padding-top:10px;">
                  He pagado a <b>{{$cli->nombre}}</b><br>
                  Cheque Nº <b>{{$egre->numero_cheque}}</b> Banco: <b>{{$egre->banco}}</b><br>
                   Tipo de egreso: <b>{{$tipo_ingreso_egreso[0]->nombre}}</b><br>
                  La cantidad de: <b>{{$numero_letra}} Bolivianos.</b><br>
                  Por concepto de: <b>{{$egre->observacion}}</b>
                  </p>
          </td>
        </tr>
        <tr>
          <td >
          <?php  echo $fecha_recibo; ?></td>
          <td align="center"  rowspan="2" style="font-size:10px; padding-bottom:0px; padding-top:15px;">.....................................<br>Entrege conforme</td>
        </tr>
        <tr>
          <td>
          Nombre: <b>{{$ad->nombre}}</b></td>
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




  
  

