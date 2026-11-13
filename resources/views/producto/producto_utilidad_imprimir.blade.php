<html>
<head>
     <meta charset="UTF-8">
<style type="text/css">
table {
  width: 700px;
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
      <font size="3" style="font-weight: bold;">TIENDA {{$empresa[0]->razon_social}} </font><br>
      Telefono: {{$empresa[0]->whatsapp}}<br>
      Dirección: {{$empresa[0]->direccion}}<br>

      <h2>LISTA DE PRODUCTOS CON INVERSION</h2></center>
    </td>
    <td style="width: 10%; border: 0px solid white;">

    </td>
  </tr>
</table>
</div>
<?php
// Inicializar una lista vacía para almacenar los productos filtrados


// Iterar sobre la lista de productos y agregar aquellos que pertenecen a la sucursal deseada a la lista de productos filtrados
/*foreach ($sucursal as $su) {
  $productos_filtrados = array();
  echo "nombre: ".$su->nombre."<br>";
  foreach ($producto as $prod) {
      if ($prod->sucursal == $su->nombre) {
          $productos_filtrados[] = $prod;
      }
  }
}*/
?>

      @foreach ($sucursal as $su)
      <br><CENTER><B>SUCURSAL {{$su->nombre}}</B></CENTER>
        <?php $productos_filtrados = array(); ?>

        <table  >
          <thead >
          <tr>
            <th>
              <center>#</center>
          </th>
          <th>
              <center># Codigo</center>
          </th>
          <th>
            <center>Tipo</center>
        </th>
          <th>
              <center>Nombre / Descripcion</center>
          </th>
          <th>
              <center>Precio Compra</center>
          </th>
          <th>
              <center>Precio de Venta</center>
          </th>
          <th>
              <center>Cant</center>
          </th>

          <th>
              <center>Inversion</center>
          </th>

          </tr>
           </thead>
          <tbody>
           <?php $i=1;
           $inversion=0;
           ?>
           @foreach ($producto as $usr)
               <tr>
                   <td>{{ $i++ }}  </td>
                   <td>{{ $usr->codigo_producto }}</td>
                   <td>
                       {{ $usr->nombre_tipo_producto }}
                   </td>
                   <td>{{ $usr->nombre }}<br>
                   <span>{{ $usr->descripcion }}</span></td>
                   <td>{{ $usr->precio_compra }}</td>
                   <td>{{ $usr->precio }}</td>
                   <td>
                       @if ($usr->peso > $usr->peso_minimo)
                           {{ $usr->peso }}
                       @else
                           <span class="badge  btn-danger">{{ $usr->peso }}</span>
                       @endif
                   </td>


                   <td>
                    {{ number_format($usr->inversion, 2) }}
                  </td>
               </tr>

               <?php $inversion+=$usr->inversion ?>

           @endforeach
           <tr>
            <td colspan="7" align="right"> <b> TOTAL DE INVERSION: </b></td>
            <td>
              <hr style="border: 1px solid black; margin: 0px; ">
             {{ $inversion }}
            </td>
           </tr>
       </tbody>
        </table>
        @endforeach


  </body>
  </html>

