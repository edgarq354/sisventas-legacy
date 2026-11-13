<html>
<head>
<meta charset="UTF-8">
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

      <h2>{{ __('cliente.lista_de_clientes') }}</h2></center>
    </td>
    <td style="width: 10%; border: 0px solid white;">

    </td>
  </tr>
</table>
</div>




        <table  >
          <thead >
          <tr>
            <th><center>{{ __('cliente.col_ci_nit_mayus') }}</center></th>
						<th><center>{{ __('cliente.col_nombre_mayus') }}</center></th>
						<th><center>{{ __('cliente.col_telefono_mayus') }}</center></th>
						<th><center>{{ __('cliente.col_cliente_mayus') }}</center></th>
						<th><center>{{ __('cliente.col_proveedor_mayus') }}</center></th>
						<th><center>{{ __('cliente.col_empleado_mayus') }}</center></th>
          </tr>
           </thead>
           <tbody >

            @foreach($cliente as $usr)
					<tr>
						<td>{{$usr->ci_nit}}</td>
						<td>{{$usr->nombre}} {{$usr->paterno}} {{$usr->materno}}</td>
						<td >
						@if(strlen($usr->telefono)>0)
						 {{$usr->telefono}}
						</button>
						@endif
						</td>

						<td align="center">
							@if($usr->tipo_c==1)
							{{ __('cliente.col_cliente_mayus') }}
							@endif
						</td>
						<td align="center">
							@if($usr->tipo_p==1)
							{{ __('cliente.col_proveedor_mayus') }}
							@endif
						</td>
						<td align="center">
							@if($usr->tipo_e==1)
							{{ __('cliente.col_empleado_mayus') }}<br>
              {{ __('cliente.ing_fecha', ['fecha' => $usr->fecha_ingreso]) }}
							@endif
						</td>

					</tr>
					@endforeach
        </tbody>
        </table>

  </body>
  </html>

