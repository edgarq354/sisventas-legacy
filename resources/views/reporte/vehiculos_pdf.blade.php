     
<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="UTF-8">
    <title>REPORTE DE VEHICULOS</title>
 <!--link href="css/reporte.css" type="text/css" rel="stylesheet"  -->

<style type="text/css">
        
       th #titulo{
         background-color: #ef973f;
        color: black;
         border: 1px solid #000;
        height: 30px;
        padding-left: 5px;
        padding-right: 5px; 
       }
       #td{
        height: 40px;
        align-content: center;
       }
       div{
        height: 100%;
       }
       #table
       {
        border-collapse: collapse;
       
       }
       body{
        font-size: 12px;
        font-family:Elegance, sans-serif;
       }
       
     </style>
  
</head>
<div align="right" style="height: 10px;">
   {{date("j - F - Y, g:i a")}}
  </div>
<body>

<div style="width: 100%;height: 0%;">
<center><font size="3">REPORTE DE VEHICULOS REGISTRADOS</font></center>
</div>

<table >
<tr>
  <td colspan="3" align="center">.</td>
</tr>
<tr>
  <td>
    USUARIO: @foreach($usuario as $usu)
             {{$usu->usuario}} 
            @endforeach
  </td>
  </tr>   
  <TR><td>Fecha <?php echo date("j-n-Y");  ?>
</td>
</TR>
<tr>
 <TD>
  EMPRESA: @foreach($empresa as $emp) {{$emp->razon_social}}  @endforeach
</TD>
</tr>
</table>
<br>
<HR>
<table width="740px" border="1" id="table" >
  <thead>
  <tr style="background-color: #ef973f;">
    <th>PLACA</th>
    <th>MARCA</th>
    <th>TIPO</th>
    <th>COLOR</th>
    <th>MODELO</th>
    <th>C.I. PROPIETARIO</th>
    <th>FECHA DE REGISTRO</th>
  </tr>
  </thead>
  <tbody>
  <?php $cantidad=0;?>
  @foreach($vehiculo as $pago)
  <tr>
    <td align="center">
     {{$pago->placa}}
    </td>
    <td align="center">
     {{$pago->marca}}
    </td>
    <td align="center">
     {{$pago->tipo}}
    </td>
    <td align="left">
     {{$pago->color}}
    </td>
    <td align="center">
     {{$pago->modelo}} 
    </td>
    <td align="center">
     {{$pago->id_propietario}}
    </td>
    <td align="center">
     {{$pago->fecha_registrado}}
    </td>
  </tr>
  <?php $cantidad+=1;?>
  @endforeach
  </tbody>

</table>
<b>Cantidad total de vehiculos registrados:<?php echo $cantidad;?></b>
</body>
</html>




  
  

