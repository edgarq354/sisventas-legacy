<html>

<head>
    <meta charset="UTF-8">
    <title>{{ __('nota_compra.historial_por_producto_mayus') }}</title>
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
                    <img src=<?php echo '' . asset('../storage/' . $empresa[0]->direccion_logo); ?> name="logo" id="foto_logo" width="50px" height="50px"
                        class="img-thumbnail" style=" position:absolute; top:20px; " />
                </td>
                <td style="width: 80%; border: 0px solid white;">
                    <center>
                        <font size="3" style="font-weight: bold;">{{ __('producto.tienda') }} {{ $empresa[0]->razon_social }} </font>
                        <br>
                        {{ __('producto.telefono_label') }} {{ $empresa[0]->whatsapp }}<br>
                        {{ __('producto.direccion_label') }} {{ $empresa[0]->direccion }}<br>

                        <h1>{{ __('nota_compra.historial_por_producto_mayus') }}</h1>
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
                                <center>{{ __('nota_compra.col_id') }}</center>
                            </th> 
                            <th>
                                <center>{{ __('nota_compra.col_tipo_producto_mayus') }}</center>
                            </th>
                            <th>
                                <center>{{ __('nota_compra.col_nombre_mayus') }}</center>
                            </th> 
                            <th>
                                <center>{{ __('nota_compra.col_precio_mayus') }}</center>
                            </th>  
                            <th>
                                <center>{{ __('nota_compra.col_stock_mayus') }}</center>
                            </th>
                            <th>
                                <center>{{ __('nota_compra.col_stock_compra_mayus') }}</center>
                            </th>
                             <th>
                                <center>{{ __('nota_compra.col_total_mayus') }}</center>
                            </th>
        </tr>
        @foreach ($nota_compra as $usr)
                 <tr>
                                   <td>{{ $usr->id }}</td>
                                     <td>
                                        {{ $usr->nombre_tipo_producto }}
                                    </td>
                                    <td>{{ $usr->nombre }}<br>
                                        <span>{{ $usr->descripcion }}</span></td> 
                                    <td align="right">{{ $usr->precio }}</td> 
                                     
                                    <td align="right">
                                        @if ($usr->peso > $usr->peso_minimo)
                                            {{ $usr->peso }}
                                        @else
                                            <span class="badge  btn-danger">{{ $usr->peso }}</span>
                                        @endif
                                    </td>
                                    <td align="right"><b>{{ $usr->peso_compra }}</b></td> 
                                    <td align="right"><b>{{ $usr->sub_total }}</b></td>  
                </tr>
                <?php $total += $usr->sub_total; ?>
            @endforeach

            <tr>
                <td colspan="6" align="right"> <b>{{ __('nota_compra.total_mayus_dp') }} </b></td>
                <td align="right"> <b>{{ $total }}</b> </td>
            </tr>


    </table>





</body>

</html>

