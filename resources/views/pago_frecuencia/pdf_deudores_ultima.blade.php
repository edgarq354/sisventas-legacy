<head>
 <meta charset="UTF-8">
    <title>CONDUCTORES CON DEUDA</title>
 <!--link href="css/reporte.css" type="text/css" rel="stylesheet"  -->

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
  border:1px solid #000 !important;
        color: black;
        padding-left: 5px;
        padding-right: 5px; 
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
   {{date("j - F - Y, g:i a")}}
  </div>
<body>
<div style="width: 100%">
<center><font size="3">CONDUCTORES CON DEUDA</font></center>
</div>
<br>
<br>


    

    <?php
    $cantidad=1;
    $sum_deuda=0;
    ?>

        <table  >
          <thead >
          <tr>
            <th ><center>Nº</center></th>
            <th ><center>Codigo</center></th>
            <th><center>Ci</center></th>
            <th><center>Nombre</center></th>
            <th><center>Celular</center></th>
            <th><center>Numero</center></th>
            <th><center>Monto x F</center></th>
            <th><center>Tipo de Pago</center></th>
            </tr>
            </thead>
           <tbody >
            @foreach($deudores as $conductor)

          <tr>
            <td><center>{{$cantidad}}</center></td>
            <td><center>{{ $conductor->codigo_empresa}}</center></td>
            <td><center>{{ $conductor->ci}}</center></td>
            <td>{{ $conductor->nombre}} {{$conductor->paterno}} {{$conductor->materno}}</td>
            <td>{{ $conductor->celular}}</td>
            <td><center>{{ $conductor->numero}}</center></td>
            <td>{{ $conductor->monto_frecuencia}} Bs</td>
            <td>{{ $conductor->tipo}}</td>
           
          </tr>
          <?php 
            $cantidad++;
            
            $sum_deuda=$sum_deuda+ $conductor->monto_frecuencia;
            

            ?>
          @endforeach
        </tbody>
            
        </table>

  <br><br>
  <?php 
$cantidad--;
  ?>
Cantidad de deudas :{{$cantidad}}.<br>
El monto total a cobrar por una frecuencia en general es {{$sum_deuda}} bs.<br>


</body>
</html>




  
  

