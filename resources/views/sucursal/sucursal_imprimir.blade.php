<html>

<head>
    <meta charset="UTF-8">
    <style type="text/css">
        table {
            width: 720px;
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
<div align="right" style="height: 10px;">
    {{ date('j - F - Y, g:i a') }}
</div><br>

<body>

    <div style="width: 100%">
        <table>
            <tr>
                <td style="width: 10%; border: 0px solid white;">
                    <img src="{{ $empresa[0]->direccion_logo }}" name="logo" id="foto_logo" width="50px" height="50px"
                        class="img-thumbnail" style=" position:absolute; top:20px; " />
                </td>
                <td style="width: 80%; border: 0px solid white;">
                    <center>
                        <font size="3" style="font-weight: bold;">TIENDA {{ $empresa[0]->razon_social }} </font>
                        <br>
                        Telefono: {{ $empresa[0]->whatsapp }}<br>
                        Dirección: {{ $empresa[0]->direccion }}<br>

                        <h2>LISTA DE SUCURSALES</h2>
                    </center>
                </td>
                <td style="width: 10%; border: 0px solid white;">

                </td>
            </tr>
        </table>
    </div>




    <table>
        <thead>
            <tr>
                <th>
                    <center>CODIGO</center>
                </th>
                <th>
                    <center>NOMBRE</center>
                </th>
                <th>
                    <center>MUNICIPIO</center>
                </th>
                <th>
                    <center>DIRECCIÓN</center>
                </th>
                <th>
                    <center>TELEFONO</center>
                </th>
                <th>
                    <center>CUIS </center>
                </th>
                <th>
                    <center>C. P. VENTA</center>
                </th>
            </tr>
        </thead>
        <tbody>

            @foreach ($sucursal as $usr)
                <tr>
                    <td>{{ $usr->codigo }}</td>
                    <td>{{ $usr->nombre }}</td>
                    <td>{{ $usr->municipio }}</td>
                    <td>{{ $usr->direccion }}</td>
                    <td>{{ $usr->telefono }}</td>
                    <td>{{ $usr->cuis }}</td>
                    <td>{{ $usr->codigo_punto_venta }}</td>

                </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>
