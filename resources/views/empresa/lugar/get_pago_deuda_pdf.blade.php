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
 
<body>
 <div id="header" >
                <table width="100%">
                    <tr>
                        <td width="55%"><img src="images/logo_1.png" height="80px" width="160px"></td>
                         <td width="55%"><img src="images/logo_2.png" height="80px" width="160px"></td>
                        <td width="55%"><img src="images/logo_3.png" height="80px" width="160px"></td>
                    </tr>
                </table>
<br>
 
	
</div>
         <div id="footer" >
         	<hr style="background: green; height: 2px;width: 100%;">
                <table width="100%" align="center">
                    <tr>
                        <td><center>Calle Asunción Nº 4 Barrio nueva Esperanza Zona de La Pampa de la isla * Tel.: 3474444 * Cel.: 700 54294 <br>
                            readiomovil.clasico@live.com</center>
                        </td>
                    </tr>
                </table>
                 
        </div>
 
 
<div class="container">
	<?php
foreach($ingresos as $ing)
{
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
						<th id="th"><center>USUARIO</center></th>
						<th id="th"><center>REFERENCIA</center></th>
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
							<td id="td"><center>{{$ped->usuario}}</center></td>
							<td id="td"><center>{{$ped->direccion}}</center></td>
							<td id="td"><center>{{$ped->monto_empresa}}</center></td>
	                 
	                	</tr>
					@endforeach
				</tbody>
				</table>
</div>
<br><br>
Monto total:{{$monto_total}} .<br>
	</body>
	</html>


 

