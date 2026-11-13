<html>

<head>
    <meta charset="UTF-8">
    <title>{{ __('ingreso.historial_de_ingresos_mayus') }}</title>
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
                    <img src=<?php echo '' . asset('../public/' . $empresa[0]->direccion_logo); ?> name="logo" id="foto_logo" width="50px" height="50px"
                        class="img-thumbnail" style=" position:absolute; top:20px; " />
                </td>
                <td style="width: 80%; border: 0px solid white;">
                    <center>
                        <font size="3" style="font-weight: bold;">{{ __('producto.tienda') }} {{ $empresa[0]->razon_social }} </font>
                        <br>
                        {{ __('producto.telefono_label') }} {{ $empresa[0]->whatsapp }}<br>
                        {{ __('producto.direccion_label') }} {{ $empresa[0]->direccion }}<br>

                        <h3>{{ __('ingreso.historial_de_ingresos_mayus') }}</h3>
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
            <th><center>{{ __('ingreso.col_id') }}</center></th>  
						<th><center>{{ __('ingreso.col_fecha') }}</center></th>
						<th><center>{{ __('ingreso.col_concepto') }}</center></th>
						<th><center>{{ __('ingreso.col_descripcion') }}</center></th>
						<th><center>{{ __('ingreso.col_tipo') }}</center></th>   
						<th><center>{{ __('ingreso.col_cliente') }}</center></th>   
						<th><center>{{ __('ingreso.col_monto') }}</center></th>   
						<th><center>{{ __('ingreso.col_sucursal') }}</center></th>    
						<th><center>{{ __('ingreso.col_caja') }}</center></th>    
						<th><center>{{ __('ingreso.col_usuario') }}</center></th>   
						<th><center>{{ __('ingreso.col_estado') }}</center></th>  

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
                <span class="badge  btn-success">{{ __('estados.'.$item->estado) }}</span>
                @elseif($item->estado=='Por cobrar')
                <span class="badge  btn-warning">{{ __('estados.'.$item->estado) }}</span> 
                @else
                <span class="badge  btn-danger">{{ __('estados.'.$item->estado) }}</span>
                @endif
            </TD>
        </tr>			
        @endforeach


    </table>




</body>

</html>
