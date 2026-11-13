<html>
<head>
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
	border:1px solid #ddd!important;
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
<center><font size="3">HISTORIAL DE DEUDA</font></center>

	 
	<font size='2'> <b> Conductor:</b>{{$conductor[0]->nombre}} {{$conductor[0]->paterno}} {{$conductor[0]->materno}}</font><br>
	<font size='2'> <b>C.I:</b> {{$conductor[0]->ci}}</font><br>
	<font size='2'> <b>Empresa:</b> {{$empresa[0]->razon_social}}</font><br>
	<font size='2'> <b>Nit:</b> {{$empresa[0]->nit}}</font><br>

	<br>
	<br>

	<?php 
	$can_deuda=0;
	$sum_deuda=0;

	?>
</div>

			
    

				<table  >
					<thead >
					<tr>
						<th><center>Nro</center></th>
						<th><center>Fecha de Inicio</center></th>
						<th><center>Fecha fin</center></th>
						<th><center>Monto</center></th>
						<th><center>Tipo de pago</center></th>
					</tr>
					 </thead>
					 <tbody >

					@foreach($frecuencia as $deuda)
						<tr>
							<td><center>{{$deuda->numero}}</center></td>
							<td><center>{{$deuda->fecha_inicio}}</center></td>
							<td><center>{{$deuda->fecha_fin}}</center></td>
							<td><center>{{$deuda->monto}}</center></td>
							<td><center>{{$deuda->tipo}}</center></td>
	                <?php 
	                $can_deuda+=1;
	                $sum_deuda+=$deuda->monto;
	                ?>
	                	</tr>
					@endforeach
				</tbody>
				</table>

<br><br>
Cantidad de deudas :{{$can_deuda}}.<br>
El monto a pagar por frecuencia es {{$conductor[0]->monto_frecuencia}} Bs.<br>
El monto total de deuda es {{$sum_deuda}} Bs.
	</body>
	</html>


 

