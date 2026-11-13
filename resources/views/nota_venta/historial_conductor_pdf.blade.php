<html>
<head>
<style type="text/css">
table { 
  table-layout: fixed;
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
<center><font size="3">HISTORIAL DE PAGO</font></center>

	 
	<font size='2'> <b> Conductor:</b>{{$conductor[0]->nombre}} {{$conductor[0]->paterno}} {{$conductor[0]->materno}}</font><br>
	<font size='2'> <b>C.I:</b> {{$conductor[0]->ci}}</font><br>
	<font size='2'> <b>Empresa:</b> {{$conductor[0]->razon_social}}</font><br>
	<font size='2'> <b>Nit:</b> {{$conductor[0]->nit}}</font><br>

	<br>
	<br>

<?php 
$cant_pagado=0;
$cant_permiso=0;
$cant_deuda=0;
$sum_deuda=0;
$sum_pagado=0;
?>

</div>

			
    

				<table  >
					<thead >
					<tr>
						<th><center>Nro Pago</center></th>
						<th><center>Nro / Tipo</center></th>
						<th><center>Fecha</center></th>
						<th><center>Fecha de inicio</center></th>
						<th><center>Fecha fin</center></th>
						<th><center>Monto</center></th>
						<th><center>Tipo</center></th>
						<th><center>Usuario</center></th>
						</tr>
					 </thead>
					 <tbody >
						@foreach($pago_frecuencia as $pago)
						
			
					@if($pago->permiso==0)
						<tr style="background-color: #9FF781;">
						<td><center>{{ $pago->nro_pago}}</center></td>
						<td><center><b>{{ $pago->numero}} - {{$pago->tipo}}</b></center></td>
						<td><center><b>{{date("j - m - Y",strtotime($pago->fecha))}}</b></center></td>
						<td><center>{{ $pago->fecha_inicio}}</center></td>
						<td><center>{{ $pago->fecha_fin}}</center></td>
						<td><center><b>{{ $pago->monto}}</b></center></td>
						<td  ><center>PAGADO</center></td>
						<td  ><center><b>{{ $pago->nombre}}</b></center></td>
						</tr>

						<?php 
						$cant_pagado+=1;
						$sum_pagado+=$pago->monto;
						?>
					@elseif($pago->permiso==1)
					<tr style="background-color: #F2F5A9;">
						<td><center>-</center></td>
						<td><center><b>{{ $pago->numero}} - {{$pago->tipo}}</b></center></td>

						<td><center><b>{{date("j - m - Y",strtotime($pago->fecha))}}</b></center></td>
						<td><center>{{ $pago->fecha_inicio}}</center></td>
						<td><center>{{ $pago->fecha_fin}}</center></td>
						<td><center>-</center></td>
						<td  ><center>PERMISO</center></td>
						<td  ><center><b>{{ $pago->nombre}}</b></center></td>
					</tr>

						<?php 
						$cant_permiso+=1;
						?>
					
					@elseif($pago->permiso==-1)
					<tr style="background-color: #F5A9A9;">
						<td><center>-</center></td>
						<td><center><b>{{ $pago->numero}} - {{$pago->tipo}}</b></center></td>

						<td><center>-</center></td>
						<td><center>{{ $pago->fecha_inicio}}</center></td>
						<td><center>{{ $pago->fecha_fin}}</center></td>
						<td><center>-</center></td>
						<td ><center>DEUDA</center></td>
						<td ><center>-</center></td>
					</tr>
						<?php 
						$cant_deuda+=1;
						$sum_deuda+=$pago->monto;
						?>
					@endif
						
					@endforeach
					</tbody>
						
				</table>
<br>
<br>
<table  style="width:250px;">
	<thead style="background-color: #F8B712;">
		<tr>
		<th>Detalle</th>
		<th>Cantidad</th>
		<th>Monto</th>
	</tr>
	</thead>
	<tbody>
		<tr >
			<td>Pagado</td>
			<td>{{$cant_pagado}}</td>
			<td>{{$sum_pagado}} Bs</td>
		</tr>
		<tr>
			<td>Permiso</td>
			<td>{{$cant_permiso}}</td>
			<td>-</td>
		</tr>
		<tr>
			<td>Deuda</td>
			<td>{{$cant_deuda}}</td>
			<td>{{$sum_deuda}} Bs.</td>
		</tr>
		
	</tbody>
</table >
<br><br>

	</body>
	</html>


 

