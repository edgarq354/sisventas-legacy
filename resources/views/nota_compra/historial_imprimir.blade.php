<html>

<head>
    <meta charset="UTF-8">
    <title>HISTORIAL DE COMPRAS</title>
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
    {{ date('j - F - Y, g:i a') }}
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
                        <font size="3" style="font-weight: bold;">TIENDA {{ $empresa[0]->razon_social }} </font>
                        <br>
                        Telefono: {{ $empresa[0]->whatsapp }}<br>
                        Dirección: {{ $empresa[0]->direccion }}<br>

                        <h1>HISTORIAL DE COMPRAS</h1>
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
                <center>Id</center>
            </th> 
            <th>
                <center>Fecha</center>
            </th>
            <th>
                <cente>Proveedor</center>
            </th>
            <th>
                <cente>Comprador</center>
            </th>
            <th>
                <center>usuario</center>
            </th>
            <th>
                <center>Estado</center>
            </th>
            <th>
                <center>Monto Total</center>
            </th>
        </tr>
        @foreach ($nota_compra as $pago)
                <tr>
                    <td>{{ $pago->id }}</td> 
                    <td>{{ $pago->fecha }}</td>
                    <td>{{ $pago->proveedor }} </td>
                    <td>{{ $pago->comprador }} </td>
                    <td>{{ $pago->usuario }}</td>
                    <td>{{ $pago->estado }}</td>
                    <td>{{ $pago->monto_total }} </td>
                </tr>
                <?php $total += $pago->monto_total; ?>
            @endforeach

            <tr>
                <td colspan="6" align="right"> <b>TOTAL: </b></td>
                <td align="right"> <b>{{ $total }}</b> </td>
            </tr>


    </table>





</body>

</html>

