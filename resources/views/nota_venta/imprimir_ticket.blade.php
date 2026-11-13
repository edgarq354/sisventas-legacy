<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="UTF-8">
    <title>TICKET CLIENTE</title>
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

                .line_pequenio {
          border-top: 0.5px dashed black;
          width: 100%; /* Ajusta el ancho según sea necesario */
          margin: 0px auto; /* Margen superior e inferior, centrado */
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
        <img src="{{$empresa[0]->direccion_baner}}" name="logo" id="foto_logo" width="100px" height="50px"     />
        <br> 
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



        echo $empresa[0]->direccion."<br>";
        //echo "Fecha: ".$dia."-".$mes."-".$anio; 
          echo strftime( $dia_s.", %d de ". $mes." de %Y", $mifecha );
          $time = strftime("%H:%M", strtotime ( $nota_venta[0]->fecha ));
          //echo $time;

          
          ?> 
          <br> 
     <?php echo "Cel.:".$empresa[0]->whatsapp." ,        Hora ".$time; ?>

        </center>
      
    </td>
  </tr>

  <tr>
    <td>
      Cliente(es):  {{$nota_venta[0]->razon_social}} 
      
  </tr>
  <tr>
    <td>
      <center>
      <table border="0" style="width: 250px; margin:0px; padding:0px;"> 
        <tr style=" margin:0px; padding:0px;">
          <td style="width: 5px; margin:0px; padding:0px;" align="center">CANT.</td>
          <td align="center">DETALLE</td> 
          <td style="width: 6px; margin:0px; padding:0px;" align="center">P/U</td>
          <td style="width: 5px; margin:0px; padding:0px;" align="center">TOTAL</td>
        </tr>
        <tr>
          <td colspan="4"> <hr style="border: 1px solid black; margin:0px; padding:0px;"></td>
        </tr>
      
      <?php foreach($detalle_venta as $fre)
      {
        echo  "<tr><td style='font-size: 15px;'> <b>".(int)$fre->peso." </b></td>
          <td><b>".$fre->descripcion."</b></td>
          <td align='center'><b>".$fre->precio_unidad."</b></td>
          <td align='center'><b>".$fre->sub_total."</b></td></tr>";
      }
      ?> 
      <tr>
        <td colspan="3" align="right"> </td>
        <td> <hr style="border: 1px solid black; margin:0px; padding:0px;"></td>
      </tr>
        <tr>
          <td colspan="3" align="right"> <b>TOTAL:  </b></td>
          <td align="center"> <b> {{$nota_venta[0]->monto_total}}</b></td>
        </tr>
      </table>
      
      </center>
    </td>
  </tr>
  <tr>
    <td align="left"> 
      <b style="font-size: 20px; margin:0px; padding:0px;"> TICKET: {{$nota_venta[0]->numero_ticket}}</b>   <b style="font-size: 18px;">, {{$nota_venta[0]->tipo}}</b> 
       <br>
      
    </td>
  </tr>
   
  <tr>
    <td>   
      <center style="font-size: 10px;">GRACIAS POR SU COMPRA, BUEN PROVECHO</center>
      
      @if(strlen($empresa[0]->comentario_recibo)>0)
      <div class="line_pequenio"></div>  
        {{$empresa[0]->comentario_recibo}}<br> 
      @endif
      </center>
       <div class="line_pequenio"></div> 
      <center style="font-size: 10px;"><b >DESARROLLADO POR</b> ELISOFT - 75602869 </center>
    </td>
  </tr>

</table>
 


</body>
</html>
 




  
  

