<html>

<head>
    <meta charset="UTF-8">
    <title>{{ __('nota_venta.historial_dia_mayus') }}</title>
    <!--link href="css/reporte.css" type="text/css" rel="stylesheet"  -->

    <style type="text/css">
        table {
            width: 730px;
            border-collapse: collapse;
        }

        td {
            overflow: hidden;
            max-width: 400px;
            word-wrap: break-word;
        }

        body {
            font-size: 12px;
            font-family: Elegance, sans-serif;
        }

        th {
            height: 30px;
            border: 1px solid #f44336 !important;
            color: white;
            padding-left: 5px;
            padding-right: 5px;
            background: #f44336;
        }

        td {
            border: 1px solid #ddd;
        }

        tr {
            display: table-row;
            vertical-align: inherit;
            border-color: inherit;
        }
    </style>



</head>
<div align="right" style="height: 10px; width: 730px;">
    {{ fecha_hora_impresion() }}
</div>

<body style="height: 10px; ">

    <div style="width: 100%">
        <table>
            <tr>
                <td style="width: 10%; border: 0px solid white;">
                    
                    <img src="{{$empresa[0]->direccion_logo}}" name="logo" id="foto_logo" width="50px" height="50px"  class="img-thumbnail" style=" position:absolute; top:20px; " />
                </td>
                <td style="width: 80%; border: 0px solid white;">
                    <center>
                        <font size="3" style="font-weight: bold;">{{ __('producto.tienda') }} {{ $empresa[0]->razon_social }} </font>
                        <br>
                        {{ __('producto.telefono_label') }} {{ $empresa[0]->whatsapp }}<br>
                        {{ __('producto.direccion_label') }} {{ $empresa[0]->direccion }}<br>

                        <h1>{{ __('nota_venta.historial_dias_mayus') }}</h1>
                        {{ __('nota_venta.periodo_rango', ['desde' => $fechaInicio, 'hasta' => $fechaFinal]) }}
                    </center>
                </td>
                <td style="width: 10%; border: 0px solid white;">

                </td>
            </tr>
        </table>

    </div>

    <?php $total = 0; ?>

    <table>
        <tr> 
            <th>
                <center>{{ __('nota_venta.col_fecha_mayus') }}</center>
            </th>
            <th>
                <center>{{ __('nota_venta.col_modalidad_mayus') }}</center>
            </th>
            <th>
                <center>{{ __('nota_venta.col_monto_mayus') }}</center>
            </th> 
        </tr>
        @foreach ($nota_venta as $pago)
            <tr> 
                <?php  
          $dia_s=strftime("%u",strtotime ( $pago->fecha  )); 
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

    ?>
                <td> {{ $pago->fecha }}</td>
                <td>{{ __('estados.'.$pago->estado) }} </td> 
                <td align="right">{{ $pago->monto_total }} </td>
            </tr>
            <?php $total = $pago->monto_total + $total; ?>
        @endforeach

        <tr>
            <?php 
                $formateado = number_format($total, 2, '.', ''); 
                ?>
            <td colspan="2" align="right"> <b>{{ __('nota_venta.total_mayus_dp') }} </b></td>
            <td align="right"> <b>{{ $formateado }}</b> </td>
        </tr>


    </table>




</body>

</html>
