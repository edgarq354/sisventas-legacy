<html>

<head>
    <meta charset="UTF-8">
    <title>HISTORIAL DE INGRESOS</title>
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
                    <img src=<?php echo '' . asset('../public/' . $empresa[0]->direccion_logo); ?> name="logo" id="foto_logo" width="50px" height="50px"
                        class="img-thumbnail" style=" position:absolute; top:20px; " />
                </td>
                <td style="width: 80%; border: 0px solid white;">
                    <center>
                        <font size="3" style="font-weight: bold;">TIENDA {{ $empresa[0]->razon_social }} </font>
                        <br>
                        Telefono: {{ $empresa[0]->whatsapp }}<br>
                        Dirección: {{ $empresa[0]->direccion }}<br>

                        <h3>HISTORIAL DE INGRESOS</h3>
                    </center>
                </td>
                <td style="width: 10%; border: 0px solid white;">

                </td>
            </tr>
        </table>

    </div>

    <?php $total = 0; ?>

    <table>
        <TR>
            <th><center>Id</center></th>  
						<th><center>Fecha</center></th>
						<th><center>Concepto</center></th>
						<th><center>Descripción</center></th>
						<th><center>Tipo</center></th>   
						<th><center>Cliente</center></th>   
						<th><center>Monto</center></th>   
						<th><center>Sucursal</center></th>    
						<th><center>Caja</center></th>    
						<th><center>Usuario</center></th>   
						<th><center>Estado</center></th>  

        </TR>
        @foreach($ingreso as $item)
		<tr>
            <td>{{ $item->id}}</td>  
            <td>{{ $item->fecha}}</td>   
            <td>{{ $item->concepto}}  </td>
            <td>{{ $item->descripcion}}  </td>
            <td>{{ $item->tipo_gasto}}  </td> 
            <td>{{ $item->nombre_cliente}}  </td> 
            <td>{{ $item->monto}}  </td> 
            <td>{{ $item->sucursal}}  </td> 
            <td>{{ $item->caja}}  </td>  
            <td>{{ $item->usuario}}</td> 
            <TD>@if($item->estado=='Procesado')
                <span class="badge  btn-success">{{$item->estado}}</span>
                @elseif($item->estado=='Por cobrar')
                <span class="badge  btn-warning">{{$item->estado}}</span> 
                @else
                <span class="badge  btn-danger">{{$item->estado}}</span>
                @endif
            </TD>
        </tr>			
        @endforeach


    </table>




</body>

</html>
