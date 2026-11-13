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
   {{ \Carbon\Carbon::now()->locale(app()->getLocale())->translatedFormat(app()->getLocale() === 'en' ? 'M j, Y, g:i A' : 'j \d\e F \d\e Y, H:i') }}
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
      {{ __('producto.telefono_label') }} {{$empresa[0]->whatsapp}}<br>
      {{ __('producto.direccion_label') }} {{$empresa[0]->direccion}}<br>
     
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
					<td class="fila">{{ __('caja.fecha_hora_apertura') }}:</td>
					<td>{{$caja[0]->fecha_abrir}}</td>
					<td>{{ __('caja.fecha_hora_cierre') }}:</td>
					<td>{{$caja[0]->fecha_cierre}}</td>
				</tr>
				 
				<tr>
					<td>{{ __('caja.monto_de_apertura') }}</td>
					<td>{{$caja[0]->monto_abrir}} Bs</td> 
					<td>{{ __('caja.monto_de_cierre_efectivo_dp') }}</td>
					<td><b>{{$caja[0]->monto_cierre}} Bs</b></td>
				</tr>
        <tr>
					<td></td>
					<td></td> 
					<td>{{ __('caja.monto_de_cierre_qr_dp') }}</td>
					<td><b>{{$caja[0]->monto_cierre_qr}} Bs</b></td>
				</tr>
        <tr>
					<td></td>
					<td></td> 
					<td>{{ __('caja.monto_de_cierre_por_cobrar') }}</td>
					<td><b>{{$caja[0]->monto_cierre_por_cobrar}} Bs</b></td>
				</tr>
        <tr>
					<td></td>
					<td></td> 
					<td>{{ __('caja.monto_de_cierre_pos') }}</td>
					<td><b>{{$caja[0]->monto_cierre_pos_tarjeta}} Bs</b></td>
				</tr>
				<tr>
					<td >{{ __('caja.estado_dp') }}</td>
					<td> {{ __('estados.'.$caja[0]->estado) }}
					</td>
				</tr>  
</table>
 <br>
        <table  >
          <thead >
          	<tr><td colspan="7"><center> <h3>{{ __('caja.historial_de_ventas') }}</h3></center></td></tr>
          <tr>
                  <th><center>{{ __('caja.col_id') }}</center></th>
									<th><center>{{ __('caja.col_nro') }}</center></th>
									<th><center>{{ __('caja.col_fecha') }}</center></th>
									<th><center>{{ __('caja.col_cliente') }}</center></th>
									<th><center>{{ __('caja.col_monto_total') }}</center></th> 
									<th><center>{{ __('caja.col_usuario') }}</center></th> 
									<th><center>{{ __('caja.col_estado') }}</center></th>           
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
									<td>{{ __('estados.'.$pago->estado) }}</td>
									 
					</tr>
					@endforeach
        </tbody>
        </table>
        <br>

        <table  >
          <thead >
          	<tr><td colspan="7"><center> <h3>{{ __('caja.historial_de_compras') }}</h3></center></td></tr>
          <tr>
            <th>
              <center>{{ __('caja.col_id') }}</center>
          </th>
          <th>
              <center>{{ __('caja.col_nro') }}</center>
          </th>
          <th>
              <center>{{ __('caja.col_fecha') }}</center>
          </th>
          <th>
              <center>{{ __('caja.col_proveedor') }}</center>
          </th>
          <th>
              <center>{{ __('caja.col_comprador') }}</center>
          </th>
          <th>
              <center>{{ __('caja.col_monto_total') }}</center>
          </th>
          <th>
              <center>{{ __('caja.col_usuario') }}</center>
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
          	<tr><td colspan="7"><center> <h3>{{ __('caja.historial_de_gastos') }}</h3></center></td></tr>
          <tr>
            <th><center>{{ __('caja.col_id') }}</center></th>
            <th><center>{{ __('caja.col_tipo_de_gasto') }}</center></th>
            <th><center>{{ __('caja.col_detalle') }}</center></th>
            <th><center>{{ __('caja.col_nota') }}</center></th>
            <th><center>{{ __('caja.col_precio') }}</center></th>
            <th><center>{{ __('caja.col_usuario') }}</center></th>
            <th><center>{{ __('caja.col_caja') }}</center></th>
            <th><center>{{ __('caja.col_fecha') }}</center></th>         
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
          	<tr><td colspan="10"><center> <h3>{{ __('caja.historial_de_ingresos') }}</h3></center></td></tr>
          <tr>
            <th><center>{{ __('caja.col_id') }}</center></th>  
            <th><center>{{ __('caja.col_fecha') }}</center></th>
            <th><center>{{ __('caja.col_concepto') }}</center></th>
            <th><center>{{ __('caja.col_descripcion') }}</center></th>
            <th><center>{{ __('caja.col_tipo') }}</center></th>   
            <th><center>{{ __('caja.col_cliente') }}</center></th>   
            <th><center>{{ __('caja.col_monto') }}</center></th>   
            <th><center>{{ __('caja.col_sucursal') }}</center></th>    
            <th><center>{{ __('caja.col_caja') }}</center></th>    
            <th><center>{{ __('caja.col_usuario') }}</center></th>     
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

