<html>
<head>
   <meta charset="UTF-8">
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

table>tbody>tr> td{
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
  </div><br>
<body >

<div style="width: 100%"> 
  <table>
  <tr>
    <td style="width: 10%; border: 0px solid white;">
      <img src="{{$empresa[0]->direccion_logo}}" name="logo" id="foto_logo" width="50px" height="50px"  class="img-thumbnail" style=" position:absolute; " />
    </td>
    <td style="width: 80%; border: 0px solid white;">
      <center>
      <font size="3" style="font-weight: bold;">{{$empresa[0]->razon_social}} </font><br>
      Telefono: {{$empresa[0]->whatsapp}}<br>
      Dirección: {{$empresa[0]->direccion}}<br> 
     
    </td>
    <td style="width: 10%; border: 0px solid white;">
      
    </td>
  </tr>
</table>
</div>
 <br>

<table style="font-size: 12px;">
		<tr>	<th colspan="4">
			{{$caja[0]->caja}}</th>
		</tr> 					
				<tr>
					<td class="fila">Fecha y Hora de Apertura:</td>
					<td>{{$caja[0]->fecha_abrir}}</td>
					<td>Fecha y Hora de Cierre:</td>
					<td>{{$caja[0]->fecha_cierre}}</td>
				</tr>
				 
				<tr>
					<td>Monto de Apertura:</td>
					<td>{{$caja[0]->monto_abrir}} Bs</td> 
					<td>Monto de Cierre(Efectivo):</td>
					<td><b>{{$caja[0]->monto_cierre}} Bs</b></td>
				</tr>
        <tr>
					<td></td>
					<td></td> 
					<td>Monto de Cierre Qr:</td>
					<td><b>{{$caja[0]->monto_cierre_qr}} Bs</b></td>
				</tr>
        <tr>
					<td></td>
					<td></td> 
					<td>Monto de Cierre Por Cobrar:</td>
					<td><b>{{$caja[0]->monto_cierre_por_cobrar}} Bs</b></td>
				</tr>
        <tr>
					<td></td>
					<td></td> 
					<td>Monto de Cierre POS/Tarjeta:</td>
					<td><b>{{$caja[0]->monto_cierre_pos_tarjeta}} Bs</b></td>
				</tr>
				<tr>
					<td >Estado:</td>
					<td> {{$caja[0]->estado}}
					</td>
				</tr>  
</table>
 <br>
        <table  >
          <thead >
          	<tr><td colspan="7"><center> <h3>HISTORIAL DE VENTAS</h3></center></td></tr>
          <tr>
                  <th><center>Id</center></th>
									<th><center>Nro</center></th>
									<th><center>Fecha</center></th>
									<th><center>Cliente</center></th>
									<th><center>Monto Total</center></th> 
									<th><center>usuario</center></th> 
									<th><center>estado</center></th>           
								</tr>
           </thead>
           <tbody >

           @foreach($nota_venta as $pago)
					<tr>
            <td><center>{{ $pago->id}}</center></td>
						<td>{{ $pago->numero_correlativo}}</td>
									<td>{{ $pago->fecha}}</td>  
									<td>{{ $pago->razon_social}} </td> 
									<td>{{ $pago->monto_total}}  </td>
									<td>{{ $pago->usuario}}</td>
									<td>{{ $pago->estado}}</td>
									 
					</tr>
					@endforeach
        </tbody>
        </table>
        <br>

        <table  >
          <thead >
          	<tr><td colspan="7"><center> <h3>HISTORIAL DE COMPRAS</h3></center></td></tr>
          <tr>
            <th>
              <center>Id</center>
          </th>
          <th>
              <center>Nro</center>
          </th>
          <th>
              <center>Fecha</center>
          </th>
          <th>
              <cente>Proveedor</center>
          </th>
          <th>
              <cente>Comprador</center>
          </th>
          <th>
              <center>Monto Total</center>
          </th>
          <th>
              <center>usuario</center>
          </th>        
								</tr>
           </thead>
           <tbody >

           @foreach($nota_compra as $pago)
					<tr>
            <td><center>{{ $pago->id}}</center></td>
            <td>{{ $pago->nro_comprobante}}</td>
            <td>{{ $pago->fecha}}</td>
            <td>{{ $pago->proveedor}} </td>
            <td>{{ $pago->comprador}} </td>
            <td>{{ $pago->monto_total}} </td>
            <td>{{ $pago->usuario}}</td>
									 
					</tr>
					@endforeach
        </tbody>
        </table>
        <br>
        <table  >
          <thead >
          	<tr><td colspan="7"><center> <h3>HISTORIAL DE GASTOS</h3></center></td></tr>
          <tr>
            <th><center>ID</center></th>
            <th><center>TIPO DE GASTO</center></th>
            <th><center>DETALLE</center></th>
            <th><center>NOTA</center></th>
            <th><center>PRECIO</center></th>
            <th><center>USUARIO</center></th>
            <th><center>CAJA</center></th>
            <th><center>FECHA</center></th>         
								</tr>
           </thead>
           <tbody >

            @foreach($gasto as $usr)
            <tr>
                <td><center>{{ $usr->id}}</center></td>
                <td>{{ $usr->tipo_gasto}}</td>
                <td>{{ $usr->detalle}}</td>
                <td>{{ $usr->nota}}</td>
                <td>{{ $usr->precio_gasto}}</td>
                <td>{{ $usr->usuario}}</td>
                <td>{{ $usr->caja}}</td>
                <td>{{ $usr->fecha}}</td> 
            </tr>
            @endforeach
        </tbody>
        </table>
        <br>
        <table  >
          <thead >
          	<tr><td colspan="10"><center> <h3>HISTORIAL DE INGRESOS</h3></center></td></tr>
          <tr>
            <th><center>Id</center></th>  
            <th><center>Fecha</center></th>
            <th><center>Concepto</center></th>
            <th><center>Descripción</center></th>
            <th><center>Tipo</center></th>   
            <th><center>Cliente</center></th>   
            <th><center>Monto</center></th>   
            <th><center>Sucursal</center></th>    
            <th><center>Caja</center></th>    
            <th><center>Usuario</center></th>     
								</tr>
           </thead>
           <tbody >

            @foreach($ingreso as $item)
            <tr>
              <td>{{ $item->id}}</td>  
              <td>{{ $item->fecha}}</td>   
              <td>{{ $item->concepto}}  </td>
              <td>{{ $item->descripcion}}  </td>
              <td>{{ $item->tipo_gasto}}  </td> 
              <td>{{ $item->nombre_cliente}}  </td> 
              <td>{{ $item->monto}}  </td> 
              <td>{{ $item->sucursal}}  </td> 
              <td>{{ $item->caja}}  </td>  
              <td>{{ $item->usuario}}</td> 
            </tr>
            @endforeach
        </tbody>
        </table>
  </body>
  </html>

