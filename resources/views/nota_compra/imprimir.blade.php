<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="UTF-8">
    <title>{{ __('nota_compra.titulo_nota_compra') }}</title>
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
            margin: 0.5cm 0.5cm 1cm;
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
 

 <table id=table border="0" width="270px"  >
  <tr >
    <td  >
      <center>
        {{ __('nota_compra.empresa_label') }} {{$empresa[0]->razon_social}}<br>
        {{ fecha_larga($nota_compra[0]->fecha) }}
          <br>
          {{ __('nota_compra.nro_comprobante', ['id' => $nota_compra[0]->id]) }}<BR><br>
          <B>{{ __('nota_compra.titulo_nota_compra') }}</B>
        </center>
      <hr style="border: 1px solid black; margin: 0px;">
    </td>
  </tr>

  <tr>
    <td>
      {{ __('nota_compra.proveedores_label') }} {{$nota_compra[0]->proveedor}}<br>
       
      {{ __('nota_compra.nit_ci_label') }} {{$nota_compra[0]->ci_nit}} 
      <hr style="border: 1px solid black; margin: 0px;">
    </td>
  </tr>
  <tr>
    <td>
      {{ __('nota_compra.comprador_es_label') }} {{$nota_compra[0]->comprador}}<br> 
      <hr style="border: 1px solid black; margin: 0px;">
    </td>
  </tr>
  <tr>
    <td>
      <center>
      <table border="0" style="width: 100%;">
        <tr> 
          <td>{{ __('nota_compra.col_cantidad_corta') }}</td>
          <td>{{ __('nota_compra.col_detalle_corta') }}</td> 
          <td>{{ __('nota_compra.col_subtotal') }}</td>
        </tr>
        <tr>
          <td colspan="3"> <hr style="border: 1px solid black; margin: 0px;"></td>
        </tr>
      
      <?php foreach($detalle_compra as $fre)
      {
        echo  "<tr>  <td>".$fre->peso."</td><td>".$fre->nombre."</td><td>".$fre->sub_total."</td></tr>";
      }
      ?>
      <tr>
          <td colspan="3"> <hr style="border: 1px solid black; margin: 0px;"></td>
        </tr>
      </table>
      <b>{{ __('nota_compra.total_bs_mayus', ['monto' => $nota_compra[0]->monto_total]) }}</b><BR>
        <b>{{ __('nota_compra.estado_dp2') }} </b> {{ __('estados.'.$nota_compra[0]->estado) }}<br> 
      </center>
    </td>
  </tr>

   
  <tr>
    <td> 
      <center>
        <img src="data:image/png;base64,{!! $qrBase64 !!}" width="120" height="120" style="margin:0; padding:0;"><br>
      {{ __('nota_compra.verifique_datos') }}
      <br>
        <i><b>"{{ __('nota_compra.sin_valor_fiscal') }}"</b></i>
      </center>
    </td>
  </tr>

</table>
 


</body>
</html>
 




  
  

