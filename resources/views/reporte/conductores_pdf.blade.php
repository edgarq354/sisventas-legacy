     
<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="UTF-8">
    <title>REPORTE DE CONDUCTORES</title>
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
<center><font size="3">REPORTE DE CONDUCTORES REGISTRADOS</font></center>
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
    <th>CI</th>
    <th>NOMBRE Y APELLIDO</th>
    <th>CELULAR</th>
    <th>DIRECCION</th>
    <th>CATEGORIA</th>
    <th>TIPO DE PAGO</th>
    <th>FECHA DE REGISTRO</th>
  </tr>
</thead>
<tbody>
  <?php $cantidad=0;?>
  @foreach($conductor as $pago)
  <tr>
    <td align="center">
     {{$pago->ci}} {{$pago->expedido}}
    </td>
    <td >
     {{$pago->nombre}} {{$pago->paterno}} {{$pago->materno}}
    </td>
    <td align="center">
     {{$pago->celular}} 
    </td>
    <td align="center">
     {{$pago->direccion}}
    </td>
    <td align="center">
     {{$pago->categoria_licencia}}
    </td>
    <td align="center">
     {{$pago->tipo_de_pago}}
    </td>
    <td align="center">
     {{$pago->fecha_registro}}
    </td>
  </tr>
  <?php $cantidad+=1;?>
  @endforeach
  </tbody>

</table>
<b>Cantidad total de Conductores registrados:<?php echo $cantidad;?></b>
</body>
</html>




  
  

