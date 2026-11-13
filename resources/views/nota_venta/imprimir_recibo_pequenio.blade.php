<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="UTF-8">
    <title>NOTA DE VENTA</title>
 <!--link href="css/reporte.css" type="text/css" rel="stylesheet"  -->

 <style type="text/css">
   body{
        font-size: 10px;
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

        .line_pequenio {
          border-top: 0.5px dashed black;
          width: 100%; /* Ajusta el ancho según sea necesario */
          margin: 0px auto; /* Margen superior e inferior, centrado */
        }

        .line { /*Linea punteada */
          border-top: 1.8px dashed black;
          width: 100%; /* Ajusta el ancho según sea necesario */
          margin: 0px auto; /* Margen superior e inferior, centrado */
        }
        .line_recta { /*Linea recta */
          border-top: 0.8px solid black;
          width: 100%;
          margin: 0 auto;
          height: 0;
          line-height: 0;
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
 
 <?php 
          $dia=date("j",strtotime ( $nota_venta[0]->fecha ));
          $dia_s=strftime("%u",strtotime ( $nota_venta[0]->fecha ));
          $mes=strftime("%m",strtotime ( $nota_venta[0]->fecha ));
          $anio=date("Y",strtotime ( $nota_venta[0]->fecha )); 
          
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
      $mes="Enero";
      break;
      case 2:
      $mes="Febrero";
      break;
      case 3:
      $mes="Marzo";
      break;
      case 4:
      $mes="Abril";
      break;
      case 5:
      $mes="Mayo";
      break;
      case 6:
      $mes="Junio";
      break;
      case 7:
      $mes="Julio";
      break;
      case 8:
      $mes="Agosto";
      break;
      case 9:
      $mes="Septiembre";
      break;
      case 10:
      $mes="Octubre";
      break;
      case 11:
      $mes="Noviembre";
      break;
      case 12:
      $mes="Diciembre";
      break;
    }
    ?>

 <table id=table border="0" style="padding: 0px; margin: 0px;" width="260px"  >
  <tr >
    <td  >
      <center>
        @if(strlen($empresa[0]->direccion_baner)>5) 
        <img src="{{$empresa[0]->direccion_baner}}" name="logo" id="foto_logo" width="200px" height="80px"     /><BR>
        @endif
        <b> {{$empresa[0]->razon_social}}</b><br>
          <?php
          echo strftime( $dia_s.", %d de ". $mes." de %Y", $mifecha );
          ?>
          <br>
       Hora:
       <?php 
          $time = strftime("%H:%M", strtotime ( $nota_venta[0]->fecha ));
          echo $time;
          ?>  
          <br> 
          <B>NOTA DE VENTA #{{$nota_venta[0]->id}}</B>
        </center>
        <div class="line_pequenio"></div>
    </td>
  </tr>

  <tr>
    <td> 
      NIT/CI: {{$nota_venta[0]->ci_nit}} 
    </td>
  </tr>
  <tr>
    <td>
      Cliente(es):  {{$nota_venta[0]->razon_social}} 
      <div class="line_recta"></div>
    </td>
  </tr>
  </table>
 

      <table  border="0" width="260px" >
        <tr>
          <td style="width: 5px;">Cant.</td>
          <td>Detalle</td> 
          <td style="width: 45px;">S.Total</td>
        </tr>
        <tr>
          <td colspan="3"> 
          <div class="line_recta"></div></td>
        </tr>
      
      <?php foreach($detalle_venta as $fre)
      {
        echo  "<tr><td>".$fre->peso."</td>
          <td>".$fre->descripcion."</td>
          <td>".$fre->sub_total."</td></tr>";
      }
      ?>
      <tr>
          <td colspan="3"> <hr style="border: 1px solid black; margin: 0px;"></td>
        </tr>
      </table>
      <center>
      <b>TOTAL Bs {{$nota_venta[0]->monto_total}}</b><BR>
      <b>Estado: </b> {{$nota_venta[0]->estado}}<br> 
     
    </center>
  
      <center style="font-size: 10px;">GRACIAS POR SU COMPRA</center>
      <div class="line_pequenio"></div> 
      <center>Dirección: {{$empresa[0]->direccion}}<br>
      @if(strlen($empresa[0]->comentario_recibo)>0)
        {{$empresa[0]->comentario_recibo}}<br> 
      @endif
      </center>

      <div class="line_pequenio"></div>
      <center style="font-size: 10px;"><b >DESARROLLADO POR</b> ELISOFT - 75602869 </center>
  
       

</body>
</html>
 




  
  

