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
body{
        font-size: 12px;
        font-family:Elegance, sans-serif;
       }
th{
  height: 30px;
  border:1px solid #f44336 !important;
        color: white;
        padding-left: 5px;
        padding-right: 5px;
        background: #f44336;
}

td{
      border: 1px solid #ddd;
}
tr{
  display: table-row;
    vertical-align: inherit;
    border-color: inherit;
}

</style>

  <script>
function imprimir() {
  window.print();
}
</script>

</head>
<div align="right" style="height: 10px;">
   {{ fecha_hora_impresion() }}
  </div><br>
<body onload="imprimir();">

<div style="width: 100%">
  <table>
  <tr>
    <td style="width: 10%; border: 0px solid white;">
      <img src="{{$empresa[0]->direccion_logo}}" name="logo" id="foto_logo" width="50px" height="50px"  class="img-thumbnail" style=" position:absolute; top:20px; " />
    </td>
    <td style="width: 80%; border: 0px solid white;">
      <center>
      <font size="3" style="font-weight: bold;">{{$empresa[0]->razon_social}} </font><br>
      {{ __('producto.telefono_label') }} {{$empresa[0]->whatsapp}}<br>
      {{ __('producto.direccion_label') }} {{$empresa[0]->direccion}}<br>

      <h2>{{ __('cobranzas.historial_de_cobranzas') }}</h2></center>
    </td>
    <td style="width: 10%; border: 0px solid white;">

    </td>
  </tr>
</table>
</div>




        <table  >
          <thead >
          <tr>
            <th>
              <center>{{ __('cobranzas.col_id') }}</center>
          </th>
          <th>
              <center>{{ __('cobranzas.col_usuario') }}</center>
          </th>
          <th>
              <center>{{ __('cobranzas.col_monto_total') }}</center>
          </th>
          <th>
              <center>{{ __('cobranzas.col_monto_pagado') }}</center>
          </th>
          <th>
              <center>{{ __('cobranzas.col_estado') }}</center>
          </th>
          <th>
              <center>{{ __('cobranzas.col_tipo') }}</center>
          </th>
          <th>
              <center>{{ __('cobranzas.col_id_nota_venta') }}</center>
          </th>
          <th>
              <center>{{ __('cobranzas.col_id_nota_compra') }}</center>
          </th>
          <th>
              <center>{{ __('cobranzas.col_fecha') }}</center>
          </th>

          </tr>
           </thead>
           <tbody >

            @foreach ($cobranzas as $item)
					<tr>
						<td>{{ $item->id }}</td>
                                <td>{{ $item->usuario }}</td>
                                <td>{{ $item->monto_total }}</td>
                                <td>{{ $item->monto_pagado }}</td>
                                <td>@if($item->monto_pagado>=$item->monto_total)
                                    <span class="badge  btn-success">{{ __('cobranzas.pagado_cap') }}</span>
                                    @else
                                    <span class="badge  btn-warning">{{ __('cobranzas.pendiente_cap') }}</span>
                                    @endif
                                </td>
                                <td>{{ $item->tipo }}<br>
                                    {{ $item->estado }}</td>
                                <td>{{ $item->id_nota_venta }}</td>
                                <td>{{ $item->id_nota_compra }}</td>
                                <td>{{ $item->fecha_registro }}</td>
					</tr>
					@endforeach
        </tbody>
        </table>

  </body>
  </html>

