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

      <br>
      <div><center><b> {{ __('asistencia.historial_de_asistencia_mayus') }}</b> <br>{{ __('asistencia.del_al', ['desde' => $fechaInicio, 'hasta' => $fechaFinal]) }}</p> </center></div>
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
            <th><center>{{ __('asistencia.col_fecha') }}</center></th>
						<th><center>{{ __('asistencia.col_nombre') }}</center></th>
						<th><center>{{ __('asistencia.col_hora_ingreso') }}</center></th>
						<th><center>{{ __('asistencia.col_hora_salida') }}</center></th>
						<th><center>{{ __('asistencia.col_observaciones') }}</center></th>  
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

