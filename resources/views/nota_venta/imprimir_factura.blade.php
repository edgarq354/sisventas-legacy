<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="UTF-8">
    <title>FACTURA</title>
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

<table>
    <tr>
      <td align="center" colspan="2" style="width:200%;" >
      <b>{{$empresa[0]->razon_social}}</b>
      </td> 
      <td style="width:80%;"></td>
      <td align="left" style="width:100%; font-weight:bold;">
        NIT
      </td>
      <td align="left" style="width:100%;">
        {{$factura[0]->nit_emisor}}
      </td>
    </tr>
    <tr>
      <td align="center" colspan="2">
      <b>{{$sucursal[0]->nombre}}<br></b>
      </td> 
      <td ></td>
      <td align="left" style="width:100%; font-weight:bold;">
        FACTURA N°
      </td>
      <td align="left"  >
        {{$factura[0]->numero_factura}}
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
        CÓD. AUTORIZACIÓN 
      </td>
      <td align="left" style="vertical-align:top">
        {{$factura[0]->cafc}}
      </td>
    </tr>
    <tr> 
      <td  colspan='5'> 
    <center>
      <font style='font-size: 18px; font-weight:bold;' >FACTURA</font> <BR>
      (Con Derecho a Crédito Fiscal)
    </center>
      </td> 
    </tr> 
    <tr>
    <td>
      <b> Fecha: </b>
      </td> 
      <td>
        {{$factura[0]->fecha}}
      </td>  
      <td></td>
      <td align="right">
        <b>NIT/CI/CEX: </b>
      </td> 
      <td>
        {{$factura[0]->numero_documento}}
      </td> 
    </tr> 
    <tr>
    <td>
      <b>Nombre/Razón Social:</b>
      </td> 
      <td>
        {{$nota_venta[0]->razon_social}}
      </td>  
      <td></td>
      <td align="right">
        <b>Cod. Cliente:</b>
      </td> 
      <td>
        {{$factura[0]->codigo_cliente}}
      </td> 
    </tr> 
</table>

<table>
			<tr>
            <th><center>CÓDIGO<br>PRODUCTO / SERVICIO</center></th>
          	<th><center>CANTIDAD</center></th>
						<th><center>UNIDAD DE MEDIDA</center></th>
						<th><center>DESCRIPCIÓN </center></th>
						<th><center>PRECIO UNITARIO</center></th> 
						<th><center>DESCUENTO</center></th>  
						<th><center>SUBTOTAL</center></th> 
			</tr> 
      
        @foreach($detalle_venta as $dv)
        <tr>
          <td class='casillas'>{{$dv->codigo_producto_sin}}</td>
          <td class='casillas' align="right">{{$dv->cantidad}}</td>
          <td class='casillas'>{{$dv->unidad_medida}}</td>
          <td class='casillas'>{{$dv->descripcion}}</td>
          <td class='casillas' align="right">{{$dv->precio_unidad}}</td>
          <td class='casillas' align="right">{{$dv->monto_descuento}}</td>
          <td class='casillas' align="right">{{$dv->sub_total}}</td>
        </tr>
        @endforeach  

					<tr>
            <td rowspan="6" colspan="4" ><b>Son: {{$numeroLetra}} </b></td>
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
          <tr>
						<td align="right" colspan="2" class='casillas'>MONTO GIFT CARD Bs</td>
						<td align="right" class='casillas'>  </td>  
					</tr>
          <tr>
						<td align="right" colspan="2" class='casillasSombra'><b>MONTO A PAGAR Bs</b></td>
						<td align="right" class='casillasSombra'>  </td>  
					</tr>
          <tr>
						<td align="right" colspan="2" class='casillasSombra'><b>IMPORTE BASE CRÉDITO FISCAL</b></td>
						<td align="right" class='casillasSombra'>  </td>  
          </tr> 
          <tr><td colspan="7" style="height: 20px;"></td></tr>
          <tr> 
            <td colspan="6" align="center" >
            ESTA FACTURA CONTRIBUYE AL DESARROLLO DEL PAÍS, EL USO ILÍCITO SERÁ SANCIONADO PENALMENTE DE ACUERDO A LEY
            <br><br>
            Ley N° 453: El proveedor deberá entregar el producto en las modalidades y términos ofertados o convenidos.
            <br><br>
            “Este documento es la Representación Gráfica de un Documento Fiscal Digital emitido en una modalidad de facturación en línea”
            </td>
            <td>
              <?php
              $qrGenerar= "https://pilotosiat.impuestos.gob.bo/consulta/QR?nit=".$factura[0]->nit_emisor."&cuf=".$factura[0]->cuf."Cuf&numero=".$factura[0]->numero_factura."&t=1";
              ?>

              
            <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')
            ->margin(0)
            ->size(120)
            ->generate($qrGenerar)) !!} "   style="margin:0px; padding:0px; width:90px;  height:90px;"/>
            </td>
          </tr>


        </table>

</body>
</html>
 




  
  

