<html>
<head>
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

      <br>
      <div><center><b> HISTORIAL DE ASISTENCIA</b> <br>( Del {{$fechaInicio}} al {{$fechaFinal}} )</p> </center></div>
     <br>
    </td>
    <td style="width: 10%; border: 0px solid white;">
      
    </td>
  </tr>
</table>
</div>

      
    

        <table  >
          <thead >
          <tr>
            <th><center>FECHA</center></th>
						<th><center>NOMBRE</center></th>
						<th><center>HORA DE INGRESO</center></th>
						<th><center>HORA DE SALIDA</center></th>
						<th><center>OBSERVACIONES</center></th>  
          </tr>
           </thead>
           <tbody >

            @foreach($asistencia as $con)
            <tr>
              <td>{{ date('Y-m-d',strtotime($con->fecha))}}</td>
              <td>{{ $con->nombre}}</td>
              <td>{{ $con->fecha_ingreso}} </td>
              <td>{{ $con->fecha_salida}} </td>
              <td>{{ $con->observaciones}}</td>
            </tr>
					@endforeach
        </tbody>
        </table>
 
  </body>
  </html>

