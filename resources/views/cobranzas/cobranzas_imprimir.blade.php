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
   {{date("j - F - Y, g:i a")}}
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
      Telefono: {{$empresa[0]->whatsapp}}<br>
      Dirección: {{$empresa[0]->direccion}}<br>

      <h2>HISTORIAL DE COBRANZAS</h2></center>
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
              <center>ID</center>
          </th>
          <th>
              <center>USUARIO</center>
          </th>
          <th>
              <center>MONTO TOTAL</center>
          </th>
          <th>
              <center>MONTO PAGADO</center>
          </th>
          <th>
              <center>ESTADO</center>
          </th>
          <th>
              <center>TIPO</center>
          </th>
          <th>
              <center>ID NOTA DE VENTA</center>
          </th>
          <th>
              <center>ID NOTA DE COMPRA</center>
          </th>
          <th>
              <center>FECHA</center>
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
                                    <span class="badge  btn-success">Pagado</span>
                                    @else
                                    <span class="badge  btn-warning">Pendiente</span>
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

