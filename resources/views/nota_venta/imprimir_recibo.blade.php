<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="UTF-8">
    <title>RECIBO</title>
 <!--link href="css/reporte.css" type="text/css" rel="stylesheet"  -->

 <style type="text/css">


        table {
          width: 730px;
          border-collapse: collapse;
        }
        .casillas {
        overflow: hidden;
        max-width: 400px;
        word-wrap: break-word;
        border: 1px solid black;
        }

        td {
        overflow: hidden;
        max-width: 400px;
        word-wrap: break-word;
        }

        .casillasSombra {
        overflow: hidden;
        max-width: 400px;
        word-wrap: break-word;
        border: 1px solid black;
        background: #f7f7f7;
        }

        body{
                font-size: 12px;
                font-family:Tahoma, sans-serif;
               }
        th{
          height: 30px;
          border:1px solid black !important;
                color: black;
                padding-left: 5px;
                padding-right: 5px;
                background: #f7f7f7;
        }
        tr{
          display: table-row;
            vertical-align: inherit;
            border-color: inherit;
        }


             </style>




</head>

<body >

<table >
    <tr>
      <td align="center" colspan="2" style="width:200%;" >
      <b>{{$empresa[0]->razon_social}}</b>
      </td>
      <td style="width:80%;"></td>
      <td align="left" style="width:100%; font-weight:bold;">
        NIT
      </td>
      <td align="left" style="width:100%;">
        {{$empresa[0]->nit}}
      </td>
    </tr>
    <tr>
      <td align="center" colspan="2">
      <b>{{$sucursal[0]->nombre}}<br></b>
      </td>
      <td ></td>
      <td align="left" style="width:100%; font-weight:bold;">
        RECIBO N°
      </td>
      <td align="left"  >
        {{$nota_venta[0]->id}}
      </td>
    </tr>
    <tr>
      <td align="center" colspan="2" style="width:150%;vertical-align:top">
      No. Punto de Venta {{$sucursal[0]->codigo_punto_venta}}<br>
      {{$sucursal[0]->direccion}}<br>
      Teléfono: {{$sucursal[0]->telefono}}<br>
      {{$sucursal[0]->municipio}}
      </td>
      <td style="width:100%;"></td>
      <td style="font-weight:bold; vertical-align:top;">
        USER:
      </td>
      <td align="left" style="vertical-align:top">
        {{$nota_venta[0]->usuario}}
      </td>
    </tr>
    <tr>
      <td  colspan='5'>
    <center>
      <font style='font-size: 18px; font-weight:bold;' >NOTA DE VENTA</font> <BR>

    </center>
      </td>
    </tr>
    <tr>
    <td>
      <b> Fecha: </b>
      </td>
      <td>
        {{$nota_venta[0]->fecha}}
      </td>  
      <td></td>
      <td align="right">
        <b>NIT/CI/CEX: </b>
      </td>
      <td>
        {{$nota_venta[0]->ci_nit}}
      </td>
    </tr>
    <tr>
    <td>
      <b>Nombre/Razón Social:</b>
      </td>
      <td colspan="2">
        {{$nota_venta[0]->razon_social}}
      </td>
      <td align="right">
        <b>Cod. Cliente:</b>
      </td>
      <td>
        {{$nota_venta[0]->id_cliente}}
      </td>
    </tr>
</table>

<table>
			<tr>
            <th><center>CÓDIGO<br>PRODUCTO / SERVICIO</center></th>
          	<th><center>CANTIDAD</center></th>
						<th><center>DESCRIPCIÓN </center></th>
						<th><center>PRECIO UNITARIO</center></th>
						<th><center>DESCUENTO</center></th>
						<th><center>SUBTOTAL</center></th>
			</tr>

        @foreach($detalle_venta as $dv)
        <tr>
          <td class='casillas'>{{$dv->id_producto}}</td>
          <td class='casillas' align="right">{{$dv->peso}}</td>
          <td class='casillas'>{{$dv->descripcion}}</td>
          <td class='casillas' align="right">{{$dv->precio_unidad}}</td>
          <td class='casillas' align="right">{{$dv->monto_descuento}}</td>
          <td class='casillas' align="right">{{$dv->sub_total}}</td>
        </tr>
        @endforeach

					<tr>
            <td rowspan="4" colspan="3" ><b>Son: {{$numeroLetra}} </b></td>
						<td align="right" colspan="2" class='casillas'>SUBTOTAL Bs</td>
						<td align="right" class='casillas'>  </td>
					</tr>
          <tr>
						<td align="right" colspan="2"  class='casillas'>DESCUENTO Bs</td>
						<td align="right"  class='casillas'>  </td>
					</tr>
          <tr>
						<td align="right" colspan="2"  class='casillas'>TOTAL Bs</td>
						<td align="right" class='casillas'>  </td>
					</tr>

          <tr >
						<td align="right" colspan="2" class='casillasSombra'><b>MONTO A PAGAR Bs</b></td>
						<td align="right" class='casillasSombra'>  {{$nota_venta[0]->monto_total}}</td>
					</tr>

          <tr><td colspan="6" style="height: 20px;"></td></tr>
          <tr>
            <td colspan="5" align="center" >
            GRACIAS POR CONFIAR EN NOSOTROS .!</td>
            <td>

@php
    $qrGenerar = "nit=".$empresa[0]->nit."&numero=".$nota_venta[0]->id."&t=1";
@endphp

              
            <img src="data:image/png;base64,{!! $qrBase64 !!}" width="120" height="120" style="margin:0; padding:0;">
            </td>
          </tr>


        </table>

</body>
</html>








