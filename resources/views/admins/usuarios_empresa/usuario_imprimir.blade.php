<head>
    <meta charset="UTF-8">
    <title>{{ __('admins.historial_de_venta_titulo') }}</title>
    <!--link href="css/reporte.css" type="text/css" rel="stylesheet"  -->
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
    {{ fecha_hora_impresion() }}
</div><br>

<body>

    <div style="width: 100%">
        <table>
            <tr>
                <td style="width: 10%; border: 0px solid white;">
                    <img src="{{ $empresa[0]->direccion_logo }}" name="logo" id="foto_logo" width="50px"
                        height="50px" class="img-thumbnail" style=" position:absolute; top:20px; " />
                </td>
                <td style="width: 80%; border: 0px solid white;">
                    <center>
                        <font size="3" style="font-weight: bold;">{{ $empresa[0]->razon_social }} </font>
                        <br>
                        {{ __('producto.telefono_label') }} {{ $empresa[0]->whatsapp }}<br>
                        {{ __('producto.direccion_label') }} {{ $empresa[0]->direccion }}<br>

                        <h2>{{ __('admins.lista_de_usuarios') }}</h2>
                    </center>
                </td>
                <td style="width: 10%; border: 0px solid white;">

                </td>
            </tr>
        </table>
    </div>

    <table border=1>
        <thead>
            <tr>
                <th>
                    <center>{{ __('admins.col_nombre_mayus') }}</center>
                </th>
                <th>
                    <center>{{ __('admins.col_usuario_mayus') }}</center>
                </th>
                <th>
                    <center>{{ __('admins.col_tipo') }}</center>
                </th>
            </tr>
        </thead>
        <tbody>

            @foreach ($usuarios as $user)
                <tr>
                    <td align="left">{{ $user->nombre }}</td>
                    <td align="left">{{ $user->usuario }}</td>
                    <td align="left">
                        <?php
                        $tipo = '';
                        if ($user->privilegio == 0) {
                            $tipo = __('admins.administrador');
                        } elseif ($user->privilegio == 3) {
                            $tipo = __('admins.normal');
                        }
                        echo $tipo; ?></td>
                </tr>
            @endforeach
        </tbody>
    </table>


</body>

</html>
