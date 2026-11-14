<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="UTF-8">
    <title>{{ __('cobranzas.titulo_cobranzas') }}</title>
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
    <td colspan="2" >
      <center>
        {{ __('cobranzas.empresa_dp') }} {{$empresa[0]->razon_social}}<br>
      {{ fecha_larga($cobranzas[0]->fecha_registro) }}
          <br>
       {{ __('cobranzas.hora_dp') }}
       <?php 
          $time = date('H:i', strtotime($cobranzas[0]->fecha_registro));
          echo $time;
          ?>  
          <br>
          {{ __('cobranzas.nro_comprobante', ['id' => $cobranzas[0]->id]) }}<BR><br>
        
            <B>{{ __('cobranzas.datos_de_cobranza') }}</B>
        </center>
        <hr style="background-color: black;"> 
    </td>
  </tr>
  <tr>
    <td>  {{ __('cobranzas.numero_cobranza') }}  </td>
    <td>  {{$cobranzas[0]->id}}  </td>  
  </tr>
  <tr>
    <td> {{ __('cobranzas.clientes_dp') }} </td>
    <td> {{$cobranzas[0]->razon_social}}  </td>  
  </tr>
  <tr>
    <td>  {{ __('cobranzas.tipo_dp') }}  </td>
    <td>  {{$cobranzas[0]->tipo}}  </td>  
  </tr>
  <tr>
    <td>  {{ __('cobranzas.monto_total_dp') }}  </td>
    <td>  {{$cobranzas[0]->monto_total}}  </td>  
  </tr>
  <tr>
    <td>  {{ __('cobranzas.monto_pagado_dp') }}  </td>
    <td>  {{$cobranzas[0]->monto_pagado}}  </td>  
  </tr>
  <tr>
    <td>  {{ __('cobranzas.estado_dp') }}  </td>
    <td>   @if($cobranzas[0]->monto_pagado >= $cobranzas[0]->monto_total)
                                    <B>{{ __('cobranzas.pagado_cap') }} </B>
                                    @else
                                     {{ __('cobranzas.pendiente_cap') }} 
                                    @endif </td>  
  </tr>
  <tr>
    <td>  {{ __('cobranzas.fecha_dp') }}  </td>
    <td>  {{$cobranzas[0]->fecha_registro}}  </td>  
  </tr>
  <tr>
    <td colspan="2"> 
      <BR>
      <CENTER><B>{{ __('cobranzas.detalles_mayus') }}</B></CENTER> 
    </td>
  </tr>

  <tr>
    <td colspan="2">
      <center>
      <table border="0" style="width: 100%;">
        <tr>
          <td><b>{{ __('cobranzas.col_fecha_simple') }}</b></td>
          <td><b>{{ __('cobranzas.col_usuario_simple') }}</b></td>  
          <td><b>{{ __('cobranzas.col_monto_bs') }}</b></td>  
        </tr>
        <tr>
          <td colspan="3"> <hr style="border: 1px solid black; margin: 0px;"></td>
        </tr>
      
      <?php  
      foreach($detalle_cobranza as $fre)
            {
              echo  "<tr><td>".strftime("%u-%m-%Y",strtotime ( $fre->fecha_registro )) ."</td><td>".$fre->usuario."</td><td>".$fre->monto."</td></tr>";
            } 
      ?>
     
      </table>

    </td>
  </tr>

    <td colspan="2"> 
      <center style="font-size: 10px;"><b >{{ __('cobranzas.desarrollado_por') }}</b> ELISOFT - 75602869 </center>
    </td>
  </tr>

</table>
 


</body>
</html>
 




  
  

