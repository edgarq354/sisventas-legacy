<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="UTF-8">
    <title>FACTURA EN ROLLO</title>
 <!--link href="css/reporte.css" type="text/css" rel="stylesheet"  -->

 <style type="text/css">
   body{
        font-size: 10px;
        font-family:Elegance, sans-serif;
       }

 
        @page {
            margin: 0cm 0cm;
            font-family: Arial;
        }

        body {
            margin: 0cm 0cm 0cm 0.2cm;
        }

        header {
            position: fixed;
            top: 0cm;
            left: 0cm;
            right: 0cm;
            height: 0cm;
            background-color: #2a0927;
            color: white;
            text-align: center;
            line-height: 30px;
        }

        footer {
            position: fixed;
            bottom: 0cm;
            left: 0cm;
            right: 0cm;
            height: 2cm;
            background-color: #2a0927;
            color: white;
            text-align: center;
            line-height: 35px;
        } 

    .line_pequenio {
      border-top: 0.5px dashed black;
      width: 100%; /* Ajusta el ancho según sea necesario */
      margin: 0px auto; /* Margen superior e inferior, centrado */
    }

    .line {
      border-top: 1.8px dashed black;
      width: 100%; /* Ajusta el ancho según sea necesario */
      margin: 5px auto; /* Margen superior e inferior, centrado */
    }
 </style>
  
  <script>
function imprimir() {
  window.print();
}
</script>

</head>

<body onload="imprimir();">
 

<?php
setlocale(LC_TIME, 'es_ES.UTF-8');
date_default_timezone_set ("America/La_Paz");


$dia="";

?>
 

 <table id=table border="0" width="200px"  >
  <tr >
    <td  >
      <center>
         
      <?php 
          $dia=date("j",strtotime ( $factura[0]->fecha_emision ));
          $dia_s=strftime("%u",strtotime ( $factura[0]->fecha_emision ));
          $mes=strftime("%m",strtotime ( $factura[0]->fecha_emision ));
          $anio=date("Y",strtotime ( $factura[0]->fecha_emision )); 
          
          $mifecha=gmmktime(12,0,0,$mes,$dia,$anio);
          
          //dia

     switch ($dia_s) {
      case 1:
      $dia_s="Lunes";
      break;
      case 2:
      $dia_s="Martes";
      break;
      case 3:
      $dia_s="Miercoles";
      break;
      case 4:
      $dia_s="Jueves";
      break;
      case 5:
      $dia_s="Viernes";
      break;
      case 6:
      $dia_s="Sabado";
      break;
      case 7:
      $dia_s="Domingo";
      break;
    }
          //fin de dia


 switch ($mes) {
      case 1:
      $mes="Enero";
      break;
      case 2:
      $mes="Febrero";
      break;
      case 3:
      $mes="Marzo";
      break;
      case 4:
      $mes="Abril";
      break;
      case 5:
      $mes="Mayo";
      break;
      case 6:
      $mes="Junio";
      break;
      case 7:
      $mes="Julio";
      break;
      case 8:
      $mes="Agosto";
      break;
      case 9:
      $mes="Septiembre";
      break;
      case 10:
      $mes="Octubre";
      break;
      case 11:
      $mes="Noviembre";
      break;
      case 12:
      $mes="Diciembre";
      break;
    }

    $time = strftime("%H:%M", strtotime ( $factura[0]->fecha_emision ));
    ?> 
    <B>FACTURA</b><br>
    <b>CON DERECHO A CRÉDITO FISCAL</b><br>
    {{$empresa[0]->razon_social}}<br>
    {{$sucursal[0]->nombre}}<br>
    No. Punto de Venta {{$punto_venta[0]->codigo}}<br>
    {{$punto_venta[0]->direccion}}<br>
      Teléfono: {{$punto_venta[0]->telefono}}<br>
      {{$punto_venta[0]->municipio}}<BR>

      <div class="line"></div>
      <br>
      <b>NIT</b><BR>
      {{$factura[0]->nit_emisor}}<BR>
      <b>FACTURA N°</b><BR>
      {{$factura[0]->numero_factura}}<BR>
      <b>CÓD. AUTORIZACIÓN</b><BR>

      <table> 
        <tr>
            <td style="width: 200px; word-wrap: break-word;"> 
                @if($factura[0]->corte_internet=="0" || $factura[0]->corte_internet=="1"
                || $factura[0]->corte_internet=="2"|| $factura[0]->corte_internet=="3"
                || $factura[0]->corte_internet=="4")
                   <center> {{$factura[0]->cuf}}</center>
                @else
                   <center> {{$factura[0]->cafc}}</center>
                @endif
            </td>
        </tr>
      </table>
 
      <div class="line"></div>
      <br>
      <table> 
        <tr>
            <td style="width: 135px; word-wrap: break-word; text-align: right; font-weight: bold;"> 
                NOMBRE/RAZÓN SOCIAL:
            </td>
            <td style="width: 135PX; word-wrap: break-word;"> 
            {{$factura[0]->nombre_razon_social}}
            </td>
        </tr>
        <tr>
            <td style="width: 135px; word-wrap: break-word; text-align: right; font-weight: bold;"> 
                NIT/CI/CEX:
            </td>
            <td style="width: 135PX; word-wrap: break-word;"> 
            {{$factura[0]->numero_documento}}
            </td>
        </tr>
        <tr>
            <td style="width: 135px; word-wrap: break-word; text-align: right; font-weight: bold;"> 
                COMPLEMENTO:
            </td>
            <td style="width: 135PX; word-wrap: break-word;"> 
            {{$factura[0]->complemento}}
            </td>
        </tr>
        <tr>
            <td style="width: 135px; word-wrap: break-word; text-align: right; font-weight: bold;"> 
                COD. CLIENTE:
            </td>
            <td style="width: 135PX; word-wrap: break-word;"> 
            {{$factura[0]->codigo_cliente}}
            </td>
        </tr>
        <tr>
            <td style="width: 135px; word-wrap: break-word; text-align: right; font-weight: bold;"> 
                FECHA DE EMISIÓN:
            </td>
            <td style="width: 135PX; word-wrap: break-word;"> 
              @php
              // Convertir a timestamp (segundos desde la Época Unix)
              $timestamp = strtotime($factura[0]->fecha_emision);

              // Formatear a la fecha deseada (ajusta el formato según tus necesidades)
              $fecha_formateada = date("d/m/Y h:i A", $timestamp);
              @endphp
              {{$fecha_formateada}}
                
            </td>
        </tr>
      </table>


      <div class="line"></div>
      <br>
        <B>DETALLE</B>          
        </center>

       @foreach($detalle_venta as $dv)
       <table> 
        <tr>
            <td style="width: 135px; word-wrap: break-word; "> 
            <b>{{$dv->codigo_producto_sin}} - {{$dv->descripcion}}</b><br>
            &ensp; Unidad de Medida: {{$dv->unidad_medida_descripcion}}<br>
            {{$dv->cantidad}} X {{$dv->precio_unidad}} - {{$dv->monto_descuento}}
            </td>
            <td style="width: 135PX; word-wrap: break-word; text-align: right;  vertical-align: bottom;"> 
              {{$dv->sub_total}}
            </td>
        </tr>
      </table>
      @endforeach 
    </td>
  </tr>

  <tr>
    <td>

    <div class="line_pequenio"></div>

    <table style='margin-top:0px;'> 
        <tr>
            <td style="width: 135px; word-wrap: break-word; text-align: right;  "> 
            SUBTOTAL Bs 
            </td>
            <td style="width: 135PX; word-wrap: break-word; text-align: right;">
            {{$factura[0]->monto_subtotal}}
            </td>
        </tr>
        <tr>
            <td style="width: 135px; word-wrap: break-word; text-align: right;  "> 
            DESCUENTO Bs
            </td>
            <td style="width: 135PX; word-wrap: break-word; text-align: right;">
            {{$factura[0]->descuento_adicional}}
            </td>
        </tr>
        <tr>
            <td style="width: 135px; word-wrap: break-word; text-align: right;  "> 
            TOTAL Bs
            </td>
            <td style="width: 135PX; word-wrap: break-word; text-align: right;">
            {{$factura[0]->monto_total}}
            </td>
        </tr>
        <tr>
            <td style="width: 135px; word-wrap: break-word; text-align: right;  "> 
            MONTO GIFT CARD Bs
            </td>
            <td style="width: 135PX; word-wrap: break-word; text-align: right;"> 
            {{$factura[0]->monto_gift_card}} 
            </td>
        </tr>
        <tr>
            <td style="width: 135px; word-wrap: break-word; text-align: right; font-weight: bold;"> 
            MONTO A PAGAR Bs
            </td>
            <td style="width: 135PX; word-wrap: break-word; text-align: right; font-weight: bold;"> 
            {{$factura[0]->monto_total_sujeto_iva}}
            </td>
        </tr>
        <tr>
            <td style="width: 135px; word-wrap: break-word; text-align: right; font-weight: bold;"> 
                IMPORTE BASE CRÉDITO FISCAL Bs
            </td>
            <td style="width: 135PX; word-wrap: break-word; text-align: right; font-weight: bold;"> 
            {{$factura[0]->monto_total_sujeto_iva}}                
            </td>
        </tr>
      </table>
      
    Son: {{$numeroLetra}} 
      <div class="line"></div>
      <br>
<center><br>
ESTA FACTURA CONTRIBUYE AL DESARROLLO DEL PAÍS, EL USO ILÍCITO SERÁ SANCIONADO PENALMENTE DE ACUERDO A LEY<br><br>
{{$factura[0]->leyenda_sin}}<br><br>
{{$factura[0]->tipo_factura_descripcion_leyenda}}<br><br>
            <?php
              $qrGenerar= $factura[0]->url_qr;
              ?>

              
            <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')
            ->margin(0)
            ->size(120)
            ->generate($qrGenerar)) !!} "   style="margin:0px; padding:0px; width:130px;  height:130px;"/>
            </td>

  </center>


    </TD>
  </tr>
  <tr>
    <td>  
    <div class="line"></div>
      <br> 
      <center style="font-size: 10px;">USUARIO:  {{$factura[0]->usuario}}</center>
      <center style="font-size: 10px;">DESARROLLADO POR <b >ELISOFT </b>- 75602869 </center>
    </td>
  </tr>

</table>
 


</body>
</html>
 




  
  

