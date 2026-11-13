<html>

<head>
    <meta charset="UTF-8">
    <title>{{ __('gasto.historial_de_gastos_mayus') }}</title>
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
                    <img src="{{$empresa[0]->direccion_logo}}" name="logo" id="foto_logo" width="50px" height="50px"
                        class="img-thumbnail" style=" position:absolute; top:20px; " />
                </td>
                <td style="width: 80%; border: 0px solid white;">
                    <center>
                        <font size="3" style="font-weight: bold;">{{ __('producto.tienda') }} {{ $empresa[0]->razon_social }} </font>
                        <br>
                        {{ __('producto.telefono_label') }} {{ $empresa[0]->whatsapp }}<br>
                        {{ __('producto.direccion_label') }} {{ $empresa[0]->direccion }}<br>

                        <h1>{{ __('gasto.historial_de_gastos_mayus') }}</h1>
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
            <th><center>{{ __('gasto.col_id') }}</center></th>
						<th><center>{{ __('gasto.col_fecha') }}</center></th>
						<th><center>{{ __('gasto.col_detalle') }}</center></th>
						<th><center>{{ __('gasto.col_empleado') }}</center></th>
						<th><center>{{ __('gasto.col_usuario_min') }}</center></th>
						<th><center>{{ __('gasto.col_monto_total') }}</center></th>
        </tr>
        @foreach ($gasto as $pago)
                <tr>
                    <td>{{ $pago->id}}</td>
						<td>{{ $pago->fecha}}</td>
						<td>
							<span class="badge  btn-success">"{{ $pago->tipo_gasto}}"</span><br>
							{{ $pago->detalle}} </td>
						<td>{{ $pago->empleado}} </td>
						<td><center>{{ $pago->usuario}}</center></td>
						<td><center>{{ $pago->precio_gasto}}</center>  </td>

                </tr>
                <?php $total += $pago->precio_gasto; ?>
            @endforeach

            <tr>
                <td colspan="5" align="right"> <b>{{ __('gasto.total_mayus_dp') }} </b></td>
                <td align="right"> <b>{{ $total }}</b> </td>
            </tr>


    </table>





</body>

</html>

