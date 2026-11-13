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

      <h2>GASTOS # {{$gasto[0]->id}}</h2></center>
    </td>
    <td style="width: 10%; border: 0px solid white;">

    </td>
  </tr>
</table>
</div>


<table >
  <tr >
    <td class="sin_borde" style="width:80px;">NOMBRE:</td>
    <td class="sin_borde">{{$empleado[0]->nombre}} {{$empleado[0]->paterno}} {{$empleado[0]->materno}}</td>
  </tr>
  <tr>
    <td class="sin_borde">CARGO:</td>
    <td class="sin_borde">{{$empleado[0]->cargo}}</td>
  </tr>
  <tr>
    <td class="sin_borde">SUELDO:</td>
    <td class="sin_borde"><B>{{$gasto[0]->precio_gasto}} Bs</B></td>
  </tr>
  <tr>
    <td class="sin_borde">DETALLE:</td>
    <td class="sin_borde"><i>"{{$gasto[0]->detalle}}"</i></td>
  </tr>
  <tr>
    <td class="sin_borde">FECHA:</td>
    <td class="sin_borde">{{$gasto[0]->fecha}}</td>
  </tr>
  <tr>
    <td class="sin_borde">USUARIO:</td>
    <td class="sin_borde">{{$gasto[0]->usuario}}</td>
  </tr>
 </table>

  </body>
  </html>

