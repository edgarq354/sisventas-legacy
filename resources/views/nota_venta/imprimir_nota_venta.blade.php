<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="UTF-8">
    <title>NOTA DE VENTA</title>
 <!--link href="css/reporte.css" type="text/css" rel="stylesheet"  -->

 <style type="text/css">
   body{
        font-size: 12px;
        font-family:Elegance, sans-serif;
       }
       .line_pequenio {
      border-top: 0.5px dashed black;
      width: 100%; /* Ajusta el ancho según sea necesario */
      margin: 0px auto; /* Margen superior e inferior, centrado */
    }

    .line {
      border-top: 1.8px dashed black;
      width: 100%; /* Ajusta el ancho según sea necesario */
      margin: 5px auto; /* Margen superior e inferior, centrado */
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
 

 <table id=table border="0" width="250px"  >
  <tr >
    <td  >
      <center>
        Empresa {{$empresa[0]->razon_social}}<br>
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




          echo strftime( $dia_s.", %d de ". $mes." de %Y", $mifecha );
          ?>
          <br>
       Hora:
       <?php 
          $time = strftime("%H:%M", strtotime ( $nota_venta[0]->fecha ));
          echo $time;
          ?>  
          <br>
          Nro.Recibo: {{$nota_venta[0]->numero_correlativo}}<BR>
          <B>NOTA DE VENTA</B>
        </center>
      <hr style="border: 1px solid black; margin: 0px;">
    </td>
  </tr>

  <tr>
    <td>
      Señor(es): {{$nota_venta[0]->razon_social}}<br>
       
      NIT/CI: {{$nota_venta[0]->ci_nit}} 
      <hr style="border: 1px solid black; margin: 0px;">
    </td>
  </tr>
  <tr>
    <td>
      <center>
      <table border="0" style="width: 100%;">
        <tr>
          <td>Cantidad</td>
          <td>Detalle</td> 
          <td>Subtotal</td>
        </tr>
        <tr>
          <td colspan="3"> <hr style="border: 1px solid black; margin: 0px;"></td>
        </tr>
      
      <?php foreach($detalle_venta as $fre)
      {
        echo  "<tr><td>".$fre->peso."</td><td>".$fre->descripcion."</td><td>".$fre->sub_total."</td></tr>";
      }
      ?>
      <tr>
          <td colspan="3"> <hr style="border: 1px solid black; margin: 0px;"></td>
        </tr>
      </table>
      <b>TOTAL Bs {{$nota_venta[0]->monto_total}}</b><br>
      <div style="text-align: left; width: 100%;">SON: {{$numeroLetra}} </div>
      </center>
    </td>
  </tr>

   
  <tr>
    <td> 
      <center>
        
        <img src="data:image/png;base64,{!! $qr !!}" width="120" height="120" style="margin:0; padding:0;"><br>
      POR FAVOR VERIFIQUE LOS DATOS DEL RECIBO
      <br>
        <i><b>"SIN VALOR FISCAL"</b></i>
      </center>
    </td>
  </tr>

</table>
 


</body>
</html>
 




  
  

