<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="UTF-8">
    <title>{{ __('ingreso.recibo_de_ingreso_mayus') }}</title>
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
        {{ __('ingreso.empresa_dp') }} {{$empresa[0]->razon_social}}<br>
      {{ fecha_larga($ingreso[0]->fecha) }}
          <br>
       {{ __('ingreso.hora_dp') }}
       <?php 
          $time = date('H:i', strtotime($ingreso[0]->fecha));
          echo $time;
          ?>  
          <br>
          {{ __('ingreso.nro_recibo', ['id' => $ingreso[0]->id]) }}<BR>
          <B>{{ __('ingreso.recibo_de_ingreso_mayus') }}</B>
        </center>
      <hr style="border: 1px solid black; margin: 0px;">
    </td>
  </tr>
  <tr>
    <td>
      {{ __('ingreso.cliente_dp') }} {{$ingreso[0]->nombre_cliente}}<br> 
      {{ __('ingreso.tipo_dp') }} {{$ingreso[0]->tipo_gasto}}<br> 
      {{ __('ingreso.concepto_dp') }} {{$ingreso[0]->concepto}}<br> 
      {{ __('ingreso.descripcion_dp') }} {{$ingreso[0]->descripcion}}<br> 
      {{ __('ingreso.monto_dp') }} {{$ingreso[0]->monto}}<br> 
      {{ __('ingreso.sucursal_dp') }} {{$ingreso[0]->sucursal}}<br> 
      {{ __('ingreso.caja_dp') }} {{$ingreso[0]->caja}}<br> 
      {{ __('ingreso.usuario_dp') }} {{$ingreso[0]->usuario}}<br>  
    </td>
  </tr> 
  

</table>
 


</body>
</html>
 




  
  

