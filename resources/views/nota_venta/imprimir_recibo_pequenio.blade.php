<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="UTF-8">
    <title>{{ __('nota_venta.nota_de_venta_mayus') }}</title>
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
 

 <table id=table border="0" style="padding: 0px; margin: 0px;" width="260px"  >
  <tr >
    <td  >
      <center>
        @if(strlen($empresa[0]->direccion_baner)>5) 
        <img src="{{$empresa[0]->direccion_baner}}" name="logo" id="foto_logo" width="200px" height="80px"     /><BR>
        @endif
        <b> {{$empresa[0]->razon_social}}</b><br>
          {{ fecha_larga($nota_venta[0]->fecha) }}
          <br>
       {{ __('nota_venta.hora_dp') }}
       <?php 
          $time = date('H:i', strtotime($nota_venta[0]->fecha));
          echo $time;
          ?>  
          <br> 
          <B>{{ __('nota_venta.nota_de_venta_numero', ['id' => $nota_venta[0]->id]) }}</B>
        </center>
        <div class="line_pequenio"></div>
    </td>
  </tr>

  <tr>
    <td> 
      {{ __('nota_venta.nit_ci_corto', ['valor' => $nota_venta[0]->ci_nit]) }} 
    </td>
  </tr>
  <tr>
    <td>
      {{ __('nota_venta.clientes_label', ['valor' => $nota_venta[0]->razon_social]) }} 
      <div class="line_recta"></div>
    </td>
  </tr>
  </table>
 

      <table  border="0" width="260px" >
        <tr>
          <td style="width: 5px;">{{ __('nota_venta.col_cant_corta2') }}</td>
          <td>{{ __('nota_venta.col_detalle_corta') }}</td> 
          <td style="width: 45px;">{{ __('nota_venta.col_subtotal_corta') }}</td>
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
      <b>{{ __('nota_venta.total_bs_valor', ['monto' => $nota_venta[0]->monto_total]) }}</b><BR>
      <b>{{ __('nota_venta.estado_dp') }} </b> {{ __('estados.'.$nota_venta[0]->estado) }}<br> 
     
    </center>
  
      <center style="font-size: 10px;">{{ __('nota_venta.gracias_por_su_compra') }}</center>
      <div class="line_pequenio"></div> 
      <center>{{ __('nota_venta.direccion_dp', ['valor' => $empresa[0]->direccion]) }}<br>
      @if(strlen($empresa[0]->comentario_recibo)>0)
        {{$empresa[0]->comentario_recibo}}<br> 
      @endif
      </center>

      <div class="line_pequenio"></div>
      <center style="font-size: 10px;"><b >{{ __('nota_venta.desarrollado_por') }}</b> ELISOFT - 75602869 </center>
  
       

</body>
</html>
 




  
  

