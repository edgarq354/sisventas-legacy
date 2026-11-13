<html>
<head>
<style type="text/css">
#table { 
  width: 730px;
  top: 350px;
  border-collapse: collapse;
}
#td {
overflow: hidden;
max-width: 400px;
word-wrap: break-word;
}
body{
        font-size: 12px;
        font-family:Elegance, sans-serif;
       }
#th{
	height: 30px;
	border:1px solid #ddd!important;
        color: black;
        padding-left: 5px;
        padding-right: 5px; 
}

#td{
	    border: 1px solid #ddd;
}  
#tr{
	display: table-row;
    vertical-align: inherit;
    border-color: inherit;
}    



</style>

    <style type="text/css">

    .container {
        margin-left: 25px;
        margin-right: 25px;
        margin-top: 100px;

    }

     #header { position: fixed; left: 0px; top: 0px; right: 0px; height: 300px; text-align: center; }
    #footer { position: fixed; left: 0px; bottom: -50px; right: 0px; height: 70px;  text-align: center;}
   

    </style>

</head>
 
<body onload="window.print()">
 
         
 
 
<div class="container1">

   <table style="width: 750px;" border="0"  id="tabla">
      <tr style="background: #56CB00; color: white;" >
      <td style="padding: 5px;">
        <img src=<?php echo "".asset('../public/images/icono.png');?> width="80px" height="80px"  >
        
      </td>
      <td>
        <div align="center">
          <h1>EliSoft - Recibo</h1>
        </div>
      </td>
      <td align="right">
        <img src=<?php echo "".asset('../public/images/traigo.png');?> width="80px" height="80px"  >
      </td>
    </tr> 
  </table>


	<?php
  $monto_total=0;
foreach($ingresos as $ing)
{
echo"<font size='2'> <b>Id:</b>".$ing->id."</font> <br> "; 
echo"<font size='2'> <b>Tipo:</b>".$ing->tipo_ingreso_egreso."</font><br>"; 
echo"<font size='2'> <b>USUARIO:</b>".$ing->usuario."</font><br>"; 
echo"<font size='2'> <b>PAGADOR:</b>".$ing->nombre_pagador."</font><br>"; 
echo"<font size='2'> <b>EMPRESA:</b>".$ing->razon_social."</font><br>"; 
echo"<font size='2'> <b>FECHA:</b>".$ing->fecha."</font><br>"; 
echo"<font size='2'> <b>OBSERVACIONES:</b>".$ing->observacion."</font><br>"; 
$monto_total=$ing->monto;
}
?>

 
				<table   id="table">
					<thead >
					<tr id="tr">
						<th id="th"><center>ID</center></th>
						<th id="th"><center>FECHA</center></th>
						<th id="th"><center>MOVIL</center></th>
						<th id="th"><center>CONDUCTOR</center></th>
						<th id="th"><center>REFERENCIA</center></th>
            <th id="th"><center>MONTO PEDIDO</center></th>
						<th id="th"><center>MONTO</center></th>
					</tr>
					 </thead>
					 <tbody >

					@foreach($pedidos as $ped)
						<tr id="tr">
							<td id="td"><center>{{$ped->id}}</center></td>
							<td id="td"><center>{{$ped->fecha_pedido}}</center></td>
							<td id="td"><center>{{$ped->codigo_empresa}}</center></td>
							<td id="td"><center>{{$ped->conductor}}</center></td>
              <td id="td"><center>{{$ped->direccion}}</center></td>
							<td id="td"><center>{{$ped->monto_pedido}}</center></td>
							<td id="td"><center>{{$ped->monto_deuda_lugar}}</center></td>
	                 
	                	</tr>
					@endforeach
				</tbody>
				</table>
</div>
<br><br>
Monto total:{{$monto_total}} Bs.<br>
	</body>
	</html>


 

