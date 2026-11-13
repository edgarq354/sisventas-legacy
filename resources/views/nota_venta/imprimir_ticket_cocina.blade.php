<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="UTF-8">
    <title>{{ __('nota_venta.nota_de_venta_mayus') }}</title>
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
 

 <table id=table border="0" width="270px"  >
  <tr >
    <td  >
      <center>
      {{ fecha_larga($nota_venta[0]->fecha) }}
          <br>
       {{ __('nota_venta.hora_dp') }}
       <?php 
          $time = date('H:i', strtotime($nota_venta[0]->fecha));
          echo $time;
          ?>  
          <br>  
        </center>
      
    </td>
  </tr>

  <tr>
    <td>
      {{ __('nota_venta.clientes_label', ['valor' => $nota_venta[0]->razon_social]) }} 
      
  </tr>
  <tr>
    <td>
      <center>
      <table border="0" style="width: 250px; margin:0px; padding:0px;"> 
        <tr style=" margin:0px; padding:0px;">
          <td style="width: 5px; margin:0px; padding:0px;" align="center">{{ __('nota_venta.col_cant_mayus') }}</td>
          <td align="center">{{ __('nota_venta.col_detalle_mayus') }}</td> 
          <td style="width: 6px; margin:0px; padding:0px;" align="center">{{ __('nota_venta.col_pu_mayus') }}</td>
          <td style="width: 5px; margin:0px; padding:0px;" align="center">{{ __('nota_venta.col_total_mayus2') }}</td>
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
          <td colspan="3" align="right"> <b>{{ __('nota_venta.total_dp_mayus') }}  </b></td>
          <td align="center"> <b> {{$nota_venta[0]->monto_total}}</b></td>
        </tr>
      </table>
      
      </center>
    </td>
  </tr>
  <tr>
    <td align="left"> 
      <b style="font-size: 20px; margin:0px; padding:0px;"> {{ __('nota_venta.ticket_numero_tipo', ['numero' => $nota_venta[0]->numero_ticket]) }}</b>   <b style="font-size: 18px;">, {{$nota_venta[0]->tipo}}</b> 
       <br>
      
    </td>
  </tr>
   
  <tr>
    <td>   
      <center style="font-size: 10px;">{{ __('nota_venta.gracias_buen_provecho') }}</center>
      <center style="font-size: 10px;"><b >{{ __('nota_venta.desarrollado_por') }}</b> ELISOFT - 75602869 </center>
    </td>
  </tr>

</table>
 


</body>
</html>
 




  
  

