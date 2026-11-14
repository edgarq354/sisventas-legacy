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



</head>
<div align="right" style="height: 10px;">
   {{ fecha_hora_impresion() }}
  </div><br>
<body  >

<div style="width: 100%">
  <table>
  <tr>
    <td style="width: 10%; border: 0px solid white;">
      <img src="{{$empresa[0]->direccion_logo}}" name="logo" id="foto_logo" width="50px" height="50px"  class="img-thumbnail" style=" position:absolute; top:20px; " />
    </td>
    <td style="width: 80%; border: 0px solid white;">
      <center>
      <font size="3" style="font-weight: bold;">{{ __('producto.tienda') }} {{$empresa[0]->razon_social}} </font><br>
      {{ __('producto.telefono_label') }} {{$empresa[0]->whatsapp}}<br>
      {{ __('producto.direccion_label') }} {{$empresa[0]->direccion}}<br>

      <h2>{{ __('tipo_gasto.lista_de_tipo_de_gasto') }}</h2></center>
    </td>
    <td style="width: 10%; border: 0px solid white;">

    </td>
  </tr>
</table>
</div>




        <table  >
          <thead >
          <tr>
            <th><center>{{ __('tipo_gasto.col_id_mayus') }}</center></th>
            <th><center>{{ __('tipo_gasto.col_nombre_mayus') }}</center></th>
            <th><center>{{ __('tipo_gasto.col_estado_mayus') }}</center></th>
          </tr>
           </thead>
           <tbody >
              @foreach($tipo_gasto as $usr)
            <tr>
             <td style="width: 10%;"  align="center">{{ $usr->id}}</td>
            <td>{{ $usr->nombre}}</td>
            <td style="width: 15%;" align="center">@if($usr->estado==1)
              {{ __('tipo_gasto.activo_mayus') }}
              @else
              {{ __('tipo_gasto.inactivo_mayus') }}
              @endif
            </td>

            </tr>
            @endforeach
        </tbody>
        </table>

  </body>
  </html>

